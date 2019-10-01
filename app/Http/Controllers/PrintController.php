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
        $printAccount = User::find($request->user_id)->printAccount;
        $printAccount->balance += $request->balance;
        $printAccount->save();

        return redirect()->route('print');
    }
}
