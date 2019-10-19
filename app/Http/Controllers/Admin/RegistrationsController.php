<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class RegistrationsController extends Controller {
    public function __construct() {
        $this->middleware('can:registration.handle');
    }

    public function index() {
        $users = User::where('verified', false)->get();
        return view('admin.registrations', ['users' => $users]);
    }
    public function accept(Request $request) {
        User::findOrFail($request->user_id)->update(['verified' => true]);
        return redirect()->route('admin.registrations');
    }
    public function reject(Request $request) {
        User::findOrFail($request->user_id)->delete();
        return redirect()->route('admin.registrations');
    }
    public function show(Request $request) {
        //TODO
        return redirect()->route('admin.registrations');
    }
}
