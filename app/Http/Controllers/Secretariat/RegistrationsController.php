<?php

namespace App\Http\Controllers\Secretariat;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;

class RegistrationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:registration.handle');
    }

    public function index()
    {
        $users = User::where('verified', false)->with('educationalInformation')->get();

        return view('secretariat.registrations.list', ['users' => $users]);
    }

    public function accept(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->update(['verified' => true]);

        Cache::decrement('user');

        // Send notification mail.
        if (config('mail.active')) {
            Mail::to($user)->queue(new \App\Mail\ApprovedRegistration($user->name));
        }
        if($request->next){
            $next_user = User::where('verified', false)->first();
            if($next_user != null) {
                return redirect()->route('secretariat.registrations.show', ['id' => $next_user->id]);
            }
        }
        return redirect()->route('secretariat.registrations')->with('message', __('general.successful_modification'));
    }

    public function reject(Request $request)
    {
        User::findOrFail($request->id)->delete();

        Cache::decrement('user');

        if($request->next){
            $next_user = User::where('verified', false)->first();
            if($next_user != null) {
                return redirect()->route('secretariat.registrations.show', ['id' => $next_user->id]);
            }
        }
        return redirect()->route('secretariat.registrations')->with('message', __('general.successful_modification'));
    }

    public function show(Request $request)
    {
        $user = User::find($request->id);
        $unverified_users_left = count(User::where('verified', false)->get());
        return view('secretariat.registrations.show', ['user' => $user, 'users_left' => $unverified_users_left]);
    }
}
