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
        $print_account = User::findOrFail($request->user_id)->printAccount; 
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'balance' => 'required|integer',
        ]);
        $validator->validate();

        if ($balance < 0) {
            $balance = abs($balance);
            if ($print_account->balance < $balance) {
                $validator->errors()->add('balance', __('print.nobalance'));
                return back()
                        ->withErrors($validator)
                        ->withInput();
            } else {
                $print_account->decrement('balance', $balance);
            }
        } else {
            $print_account->increment('balance', $balance);
        }
        return redirect()->route('print');
    }

    public function modify_free_pages(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'free_pages' => 'required|integer',
        ]);
        $validator->validate();

        $free_pages = $request->free_pages;
        $print_account = User::find($request->user_id)->printAccount;

        if ($print_account->free_pages + $free_pages < 0) {
            $validator->errors()->add('$free_pages', __('print.no_free_pages_left'));
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $print_account->increment('free_pages', $free_pages);
        return redirect()->route('print');
    }
}
