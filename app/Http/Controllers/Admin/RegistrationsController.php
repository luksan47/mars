<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\User;

class RegistrationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:registration.handle');
    }

    public function index()
    {
        $users = User::where('verified', false)->get();

        return view('admin.registrations', ['users' => $users]);
    }

    public function accept(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->update(['verified' => true]);

        // Send notification mail.
        if (config('mail.active')) {
            Mail::to($user)->queue(new \App\Mail\ApprovedRegistration($user->name));
        }
        if($request->next){
            $next_user = User::where('verified', false)->first();
            if($next_user != null) {
                return redirect()->route(
                    'admin.registrations.show', 
                    ['id' => $next_user->id]
                );
            }
        }
        return redirect()->route('admin.registrations')->with('message', __('general.successful_modification'));
    }

    public function reject(Request $request)
    {
        User::findOrFail($request->id)->delete();

        if($request->next){
            $next_user = User::where('verified', false)->first();
            if($next_user != null) {
                return redirect()->route(
                    'admin.registrations.show', 
                    ['id' => $next_user->id]
                );
            }
        }
        return redirect()->route('admin.registrations')->with('message', __('general.successful_modification'));
    }

    public function show(Request $request)
    {
        $user = User::find($request->id);
        $unverified_users_left = count(User::where('verified', false)->get());
        return view('admin.user', ['user' => $user, 'users_left' => $unverified_users_left]);
    }
}
