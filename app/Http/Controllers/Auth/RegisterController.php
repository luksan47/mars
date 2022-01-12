<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewRegistration;
use App\Models\PersonalInformation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
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
            'countries' => require base_path('countries.php'),
        ]);
    }

    public function showTenantRegistrationForm()
    {
        return view('auth.register', [
            'user_type' => Role::TENANT,
            'countries' => require base_path('countries.php'),
        ]);
    }

    public const USER_RULES = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ];

    public const PERSONAL_INFORMATION_RULES = [
        'place_of_birth' => 'required|string|max:255',
        'date_of_birth' => 'required|date_format:Y-m-d',
        'mothers_name' => 'required|string|max:255',
        'phone_number' => 'required|string|min:8|max:18',
        'country' => 'required|string|max:255',
        'county' => 'required|string|max:255',
        'zip_code' => 'required|string|max:31',
        'city' => 'required|string|max:255',
        'street_and_number' => 'required|string|max:255',
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //TODO sync with Secretartiat/UserController
        $common = self::USER_RULES + self::PERSONAL_INFORMATION_RULES + ['user_type' => 'required|exists:roles,name'];

        switch ($data['user_type']) {
            case Role::TENANT:
                return Validator::make($data, $common + ['tenant_until'=>'required|date_format:Y-m-d']);
            case Role::COLLEGIST:
                return Validator::make($data, $common);
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
        $user->roles()->attach(Role::getId(Role::PRINTER));
        $user->roles()->attach(Role::getId(Role::INTERNET_USER));
        $user->roles()->attach(Role::getId($data['user_type']));

        // EducationalInformation::create([
        //     'user_id' => $user->id,
        //     'year_of_graduation' => $data['year_of_graduation'],
        //     'high_school' => $data['high_school'],
        //     'neptun' => $data['neptun'],
        //     'year_of_acceptance' => $data['year_of_acceptance'],
        //     'email' => $data['educational_email'].'@student.elte.hu',
        // ]);
        // foreach ($data['faculty'] as $key => $faculty) {
        //     $user->faculties()->attach($faculty);
        // }
        // foreach ($data['workshop'] as $key => $workshop) {
        //     $user->workshops()->attach($workshop);
        // }
        //$user->setStatus(Semester::ACTIVE, 'Activated through registration');

        $user->internetAccess->setWifiUsername();

        if ($data['user_type'] == Role::TENANT) {
            // Send confirmation mail.
            Mail::to($user)->queue(new \App\Mail\Confirmation($user->name));
            // Send notification about new tenant to the staff and network admins.
            if (! $user->isCollegist()) {
                $users_to_notify = User::whereHas('roles', function ($q) {
                    $q->whereIn('role_id', [
                        Role::getId(Role::NETWORK_ADMIN),
                        Role::getId(Role::STAFF),
                    ]);
                })->get();
                foreach ($users_to_notify as $person) {
                    Mail::to($person)->send(new NewRegistration($person->name, $user));
                }
            }
        }

        return $user;
    }
}
