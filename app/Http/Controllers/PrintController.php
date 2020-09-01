<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function index()
    {
        return view('print.app');
    }

    public function modify_balance(Request $request)
    {
        User::findOrFail($request->user_id)
            ->printAccount
            ->increment('balance', $request->balance);

        return redirect()->route('print');
    }
}
