<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permissions;

class UserController extends Controller
{
    public function profile(){
        $user = auth()->user();
        $permissions = Permissions::where('user_id',$user['id'])->get();

        return view('user.profile')->with(['user' => $user, 'permissions' => $permissions]);
    }
}
