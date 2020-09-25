<?php

namespace App\Http\Controllers\StudentCouncil;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Transaction;
use App\Checkout;
use App\PaymentType;
use App\Semester;
use App\User;

class EconomicController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::all();
        
        $my_transactions_not_in_checkout = Transaction::where('receiver_id', $user->id)
            ->where('in_checkout', false)->get();
        $sum = $my_transactions_not_in_checkout->sum('amount');

        return view('student-council.economic-committee', [
            'users' => $users,
            'transactions' => $my_transactions_not_in_checkout,
            'sum' => $sum
        ]);
    }

    public function payKKTNetreg(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'kkt' => 'required|integer|min:0',
            'netreg' => 'required|integer|min:0'
        ]);
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $valasztmany_checkout = Checkout::firstWhere('name', 'VALASZTMANY');
        $admin_checkout = Checkout::firstWhere('name', 'ADMIN');

        $kkt = Transaction::create([
            'checkout_id' => $valasztmany_checkout->id,
            'receiver_id' => $user->id,
            'payer_id' => $request->user_id,
            'semester_id' => Semester::current()->id,
            'amount' => $request->kkt,
            'payment_type_id' => PaymentType::where('name', 'KKT')->firstOrFail()->id,
            'comment' => null,
            'in_checkout' => false
        ]);
        $kkt = Transaction::create([
            'checkout_id' => $admin_checkout->id,
            'receiver_id' => $user->id,
            'payer_id' => $request->user_id,
            'semester_id' => Semester::current()->id,
            'amount' => $request->netreg,
            'payment_type_id' => PaymentType::where('name', 'NETREG')->firstOrFail()->id,
            'comment' => null,
            'in_checkout' => false
        ]);
        
        //TODO email

        return redirect()->back()->with('message', __('general.successfully_added'));
    }
}
