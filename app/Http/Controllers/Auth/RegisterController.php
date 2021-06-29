<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewRegistration;
use App\Models\EducationalInformation;
use App\Models\Faculty;
use App\Models\PersonalInformation;
use App\Models\Role;
use App\Models\Semester;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/verification';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'user_type' => Role::COLLEGIST,
            'faculties' => Faculty::all(),
            'workshops' => Workshop::all(),
            'countries' => require base_path('countries.php'),
        ]);
    }

    public function showTenantRegistrationForm()
    {
        return view('auth.register', [
            'user_type' => Role::TENANT,
            'faculties' => Faculty::all(),
            'workshops' => Workshop::all(),
            'countries' => require base_path('countries.php'),
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //TODO sync with Secretartiat/UserController
        $common = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'mothers_name' => 'required|string|max:255',
            'phone_number' => 'required|string|min:8|max:18',
            'country' => 'required|string|max:255',
            'county' => 'required|string|max:255',
            'zip_code' => 'required|string|max:31',
            'city' => 'required|string|max:255',
            'street_and_number' => 'required|string|max:255',
            'user_type' => 'required|exists:roles,name',
        ];
        $informationOfStudies = [
            'year_of_graduation' => 'required|integer|between:1895,'.date('Y'),
            'high_school' => 'required|string|max:255',
            'neptun' => 'required|string|size:6',
            'year_of_acceptance' => 'required|integer|between:1895,'.date('Y'),
            'faculty' => 'required|array|exists:faculties,id',
            'workshop' => 'required|array|exists:workshops,id',
            'collegist_status' => 'required|integer|between:1,2',
            'educational_email' => 'required|string|email|max:255|unique:educational_information,email',
        ];
        switch ($data['user_type']) {
            case Role::TENANT:
                return Validator::make($data, $common + ['tenant_until'=>'required|date_format:Y-m-d']);
            case Role::COLLEGIST:
                $data['educational_email'] = $data['educational_email'].'@student.elte.hu';

                return Validator::make($data, array_merge($common, $informationOfStudies));
            default:
                throw new AuthorizationException();
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        PersonalInformation::create([
            'user_id' => $user->id,
            'place_of_birth' => $data['place_of_birth'],
            'date_of_birth' => $data['date_of_birth'],
            'tenant_until' => $data['tenant_until'] ?? null,
            'mothers_name' => $data['mothers_name'],
            'phone_number' => $data['phone_number'],
            'country' => $data['country'],
            'county' => $data['county'],
            'zip_code' => $data['zip_code'],
            'city' => $data['city'],
            'street_and_number' => $data['street_and_number'],
        ]);

        //TODO change collegist and tenant role into role group
        switch ($data['user_type']) {
            case Role::TENANT:
                $user->roles()->attach(Role::getId(Role::TENANT));
                $user->roles()->attach(Role::getId(Role::PRINTER));
                $user->roles()->attach(Role::getId(Role::INTERNET_USER));
                break;
            case Role::COLLEGIST:
                $user->roles()->attach(Role::getId(Role::COLLEGIST), ['object_id' => $data['collegist_status']]);
                $user->roles()->attach(Role::getId(Role::PRINTER));
                $user->roles()->attach(Role::getId(Role::INTERNET_USER));
                EducationalInformation::create([
                    'user_id' => $user->id,
                    'year_of_graduation' => $data['year_of_graduation'],
                    'high_school' => $data['high_school'],
                    'neptun' => $data['neptun'],
                    'year_of_acceptance' => $data['year_of_acceptance'],
                    'email' => $data['educational_email'].'@student.elte.hu',
                ]);
                foreach ($data['faculty'] as $key => $faculty) {
                    $user->faculties()->attach($faculty);
                }
                foreach ($data['workshop'] as $key => $workshop) {
                    $user->workshops()->attach($workshop);
                }
                $user->setStatus(Semester::ACTIVE, 'Activated through registration');
                break;
            default:
                throw new AuthorizationException();
        }
        $user->internetAccess->setWifiUsername();

        // Send confirmation mail.
        Mail::to($user)->queue(new \App\Mail\Confirmation($user->name));
        // Send notification about new user to the admins and to the secretaries.
        $admins = User::role(Role::NETWORK_ADMIN)->get();
        $secretaries = User::role(Role::SECRETARY)->get();
        foreach ($admins as $admin) {
            Mail::to($admin)->send(new NewRegistration($admin->name, $user->name, $user->isCollegist()));
        }
        foreach ($secretaries as $secretary) {
            Mail::to($secretary)->send(new NewRegistration($secretary->name, $user->name, $user->isCollegist()));
        }

        return $user;
    }
}
