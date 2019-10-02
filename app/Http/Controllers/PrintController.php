<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PrintAccount;

class PrintController extends Controller
{
    public function index() {
        return view('print.app');
    }

    public function modify_balance(Request $request) {
        User::findOrFail($request->user_id)
            ->printAccount
            ->increment('balance', $request->balance);
        return redirect()->route('print');
    }
}
