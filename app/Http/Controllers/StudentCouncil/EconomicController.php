<?php

namespace App\Http\Controllers\StudentCouncil;

use App\Checkout;
use App\Http\Controllers\Controller;
use App\PaymentType;
use App\Semester;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EconomicController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::all();

        $my_transactions_not_in_checkout = Transaction::where('receiver_id', $user->id)
            ->where('moved_to_checkout', null)->get();
        $sum = $my_transactions_not_in_checkout->sum('amount');

        $semester = Semester::current();
        $all_kktnetreg_transaction = Transaction::where(function ($query) {
            $query->where('payment_type_id', PaymentType::where('name', 'KKT')->firstOrFail()->id)
                    ->orWhere('payment_type_id', PaymentType::where('name', 'NETREG')->firstOrFail()->id);
        })->get();

        return view('student-council.economic-committee', [
            'users' => $users,
            'my_transactions' => $my_transactions_not_in_checkout,
            'sum_my_transactions' => $sum,
            'all_transactions' => $all_kktnetreg_transaction,
        ]);
    }

    public function payKKTNetreg(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'kkt' => 'required|integer|min:0',
            'netreg' => 'required|integer|min:0',
        ]);
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $valasztmany_checkout = Checkout::firstWhere('name', 'VALASZTMANY');
        $admin_checkout = Checkout::firstWhere('name', 'ADMIN');

        /** Creating transactions even if amount is 0.
         * Paying 0 means that the user payed their netreg+kkt depts (which is 0 in this case).
         */
        $kkt = Transaction::create([
            'checkout_id' => $valasztmany_checkout->id,
            'receiver_id' => $user->id,
            'payer_id' => $request->user_id,
            'semester_id' => Semester::current()->id,
            'amount' => $request->kkt,
            'payment_type_id' => PaymentType::where('name', 'KKT')->firstOrFail()->id,
            'comment' => null,
            'moved_to_checkout' => null,
        ]);

        $netreg = Transaction::create([
            'checkout_id' => $admin_checkout->id,
            'receiver_id' => $user->id,
            'payer_id' => $request->user_id,
            'semester_id' => Semester::current()->id,
            'amount' => $request->netreg,
            'payment_type_id' => PaymentType::where('name', 'NETREG')->firstOrFail()->id,
            'comment' => null,
            'moved_to_checkout' => null,
        ]);

        //TODO email
        //TODO activate internet

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    public function KKTNetregToCheckout(Request $request)
    {
        $user = Auth::user();

        /* Moving the Netreg amount from Valasztmany to Admins is not tracked (yet) */
        $checkout_password = Checkout::where('name', 'VALASZTMANY')->firstOrFail()->password;
        $validator = Validator::make($request->all(), [
            'checkout_pwd' => 'required|in:'.$checkout_password,
        ]);
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        //TODO log? (because the password is not encrypted)

        $transactions = Transaction::where('receiver_id', $user->id)
            ->where('moved_to_checkout', null)->get();

        foreach ($transactions as $transaction) {
            $transaction->moved_to_checkout = \Carbon\Carbon::now();
            $transaction->save();
        }

        return redirect()->back()->with('message', __('general.successfully_added'));
    }
}
