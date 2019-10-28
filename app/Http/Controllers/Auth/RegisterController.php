<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\PrintAccount;
use App\Faculty;
use App\Workshop;
use App\PersonalInformation;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        return view('auth.register', ['faculties' => Faculty::all(), 'workshops' => Workshop::all()]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //    echo implode($data); die();
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'place_of_birth' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date_format:Y-m-d'],
            'mothers_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'min:16', 'max:18'],
            'country' => ['required', 'string', 'max:255'],
            'county' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:31'],
            'city' => ['required', 'string', 'max:255'],
            'street_and_number' => ['required', 'string', 'max:255'],
            'year_of_graduation' => ['required', 'integer', 'between:1895,' . date("Y")],
            'high_school' => ['required', 'string', 'max:255'],
            'neptun' => ['required', 'string', 'size:6'],
            'year_of_acceptance' => ['required', 'integer', 'between:1895,' . date("Y")],
            'faculty' => ['required', 'array', 'exists:faculties,id',],
            'workshop' => ['required', 'array', 'exists:workshops,id',],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        echo __('admin.message');
        exit;
        $unigue_key=md5(microtime().rand());
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'verified' => 0,
            'password' => Hash::make($data['password']),
            'verification_user' => 0,
            'end_date_verification'=>date('Y-m-d', strtotime(date('Y-m-d'). ' + 15 days')),
            'unique_key'=>$unigue_key
        ]);
        PersonalInformation::create([
            'user_id' => $user->id,
            'place_of_birth' => $data['place_of_birth'],
            'date_of_birth' => $data['date_of_birth'],
            'mothers_name' => $data['mothers_name'],
            'phone_number' => $data['phone_number'],
            'country' => $data['country'],
            'county' => $data['county'],
            'zip_code' => $data['zip_code'],
            'city' => $data['city'],
            'street_and_number' => $data['street_and_number'],
            'year_of_graduation' => $data['year_of_graduation'],
            'high_school' => $data['high_school'],
            'neptun' => $data['neptun'],
            'year_of_acceptance' => $data['year_of_acceptance'],
            'faculty' => $data['faculty'],
            'workshop' => $data['workshop'],
        ]);

        PrintAccount::create([
            'user_id' => $user->id
        ]);
       $this->sendConfirmationLink($data['email'],$user->id.'_'.$key);
        return $user;
    }


    private function sendConfirmationLink($email,$unique_key)
    {
        $to = $email;
        $subject = 'Acception link';
        $message = '<html>'.__('admin.registration_link').'<br>
       <br>
        '.$unique_key.'
         </html>';
        $headers = 'From: mars@mars.hu' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);

    }

    public function verificationRegistration($key)
    {

        $info_key = explode("_", $key);
        $date_now = date("Y-m-d");


        $userData = User::where('id', '=', intval($info_key[0]))->get();

        echo $info_key[1];

        echo $userData[0]->verification_user;

        if ($userData[0]->verification_user == 0) {

            $dateTimestamp1 = strtotime($date_now);
            $dateTimestamp2 = strtotime($userData[0]->end_date_verification);
            if ($dateTimestamp1 <= $dateTimestamp2) {
                if ($userData[0]->unique_key == $info_key[1]) {
                    User::where('id', '=', intval($info_key[0]))->update([
                        'verification_user' => 1
                    ]);
                }
            } else {
                return view("admin/noactivationlink");

            }

        } else {
            return redirect('/');
        }
    }
}
