<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NeedPasswordResetController extends Controller
{
    public function edit()
    {
        return view('auth.passwords.change_end');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        $user->password = Hash::make($request->input('password'));
        $user->pass_reset_req = false;

        $user->save();

        return redirect()->route('home')->with('success', 'A jelszó sikeresen megváltoztatásra került!');
    }
}
