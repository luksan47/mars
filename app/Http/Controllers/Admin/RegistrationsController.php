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
        $user = User::findOrFail($request->user_id);
        $user->update(['verified' => true]);

        // Send notification mail.
        if (config('mail.active')) {
            Mail::to($user)->queue(new \App\Mail\ApprovedRegistration($user->name));
        }

        return redirect()->route('admin.registrations')->with('message', __('general.successful_modification'));
    }

    public function reject(Request $request)
    {
        User::findOrFail($request->user_id)->delete();

        return redirect()->route('admin.registrations')->with('message', __('general.successful_modification'));
    }

    public function show(Request $request)
    {
        $user = User::find($request->id);
        return view('admin.user')->with('user', $user);
    }
}
