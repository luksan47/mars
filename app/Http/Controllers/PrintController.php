<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\PrintAccount;

class PrintController extends Controller
{
    public function index() {
        return view('print.app');
    }

    public function modify_balance(Request $request) {
        $balance = $request->balance;
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'balance' => 'required|integer',
        ]);
        $validator->validate();

        if ($balance < 0 && User::findOrFail($request->user_id)->printAccount->balance < abs($balance)) {
            $validator->errors()->add('balance', __('print.nobalance'));
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        
        User::findOrFail($request->user_id)
            ->printAccount
            ->where('balance', '>=', abs(min($request->balance, 0)))
            ->increment('balance', $request->balance);
        return redirect()->route('print');
    }
}
