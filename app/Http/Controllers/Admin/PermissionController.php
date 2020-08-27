<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\User;

class PermissionController extends Controller
{
    public function __construct()
    {
        // TODO change
        $this->middleware('can:registration.handle');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.permissions.list', ['users' => $users]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('admin.permissions.show', ['user' => $user]);
    }

    public function edit(Request $request)
    {
        return index();
    }
}
