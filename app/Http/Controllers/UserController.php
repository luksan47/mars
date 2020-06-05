<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showData()
    {
        return view('userdata', ['user' => Auth::user()]);
    }

    /**
     * @param Request $request
     * @return
     */
    public function updateEmail(Request $request)
    {
        // Get current user
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        // Validate the data submitted by user
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:225|'.Rule::unique('users')->ignore($user->id),
        ]);

        // if fails redirects back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Fill user model
        $user->fill([
            'email' => $request->email,
        ]);

        // Save user to database
        $user->save();

        // Redirect to route
        return redirect()->route('userdata');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (! (\Hash::check($request->get('old_password'), $user->password))) {
            // The old passwords don't match
            return redirect()->back()
                ->withErrors('olds dont match')
                ->withInput();
        }
        if (strcmp($request->get('old_password'), $request->get('new_password')) == 0) {
            //Current password and new password are same
            return redirect()->back()
            ->withErrors('new same as old')
            ->withInput();
        }

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
            'password_confirm' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        die();
        $user->password = Hash::make($request->get('password'));

        //Change Password
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully !');
    }
}
