<?php

namespace App\Http\Controllers\Admin;

use App\Checkout;
use App\Http\Controllers\Controller;
use App\PaymentType;
use App\Semester;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminCheckoutController extends Controller
{
    public function showCheckout()
    {
        $checkout = Checkout::admin();
        $this->authorize('view', $checkout);
        $transactions = [];
        $semesters = Semester::allUntilCurrent()
            ->sortByDesc(function ($semester, $key) {
                return $semester->getStartDate();
            })->filter(function ($semester, $key) {
                return $semester->transactions()->count() > 0;
            });
        $my_transactions_not_in_checkout = Transaction::where('receiver_id', Auth::user()->id)
            ->where('moved_to_checkout', null)
            ->where('payment_type_id', PaymentType::print()->id)
            ->get();
        $sum = $my_transactions_not_in_checkout->sum('amount');

        $data = [];
        foreach ($semesters as $semester) {
            //transactions
            $transactions = [];
            $transactions['income'] = $semester->transactionsInCheckout($checkout)
                ->where('payment_type_id', PaymentType::income()->id)
                ->get();
            $transactions['expense'] = $semester->transactionsInCheckout($checkout)
                ->where('payment_type_id', PaymentType::expense()->id)
                ->get();
            $transactions['netreg'] = $checkout->netregSum($semester);
            $transactions['print'] = $checkout->printSum($semester);
            $transactions['sum'] = $semester->transactionsInCheckout($checkout)
                ->sum('amount');

            $data[$semester->tag().' ('.$semester->getStartDate()->format('Y.m.d').'-'.$semester->getEndDate()->format('Y.m.d').')'] = [
                'transactions' => $transactions,
                'workshop_balances' => $semester->workshopBalances,
            ];
        }

        $current_balance = $checkout->balance();
        $current_balance_in_checkout = $checkout->balanceInCheckout();

        return view('admin.checkout', [
            'data' => $data,
            'my_transactions' => $my_transactions_not_in_checkout,
            'sum_my_transactions' => $sum,
            'current_balance' => $current_balance,
            'current_balance_in_checkout' => $current_balance_in_checkout, ]);
    }

    public function printToCheckout(Request $request)
    {
        $checkout = Checkout::admin();
        $this->authorize('addPayment', $checkout);

        /* Moving the Netreg amount from Valasztmany to Admins is not tracked (yet) */
        $validator = Validator::make($request->all(), [
            'password' => 'required|in:'.$checkout->password,
        ]);
        $validator->validate();
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $transactions = Transaction::where('receiver_id', Auth::user()->id)
            ->where('moved_to_checkout', null)
            ->where('payment_type_id', PaymentType::print()->id)
            ->get();
        foreach ($transactions as $transaction) {
            $transaction->update([
                'moved_to_checkout' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    public function addTransaction(Request $request)
    {
        $checkout = Checkout::admin();
        $this->authorize('administrate', $checkout);

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'amount' => 'required|integer',
            'password' => 'required|in:'.$checkout->password,
        ]);
        $validator->validate();
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $type = $request->amount > 0 ? PaymentType::income()->id : PaymentType::expense()->id;

        // $this->createTransaction($checkout, null, Auth::user()->id, $request->amount, $type, Carbon::now(), $request->comment);

        Transaction::create([
            'checkout_id' => $checkout->id,
            'receiver_id' => null,
            'payer_id' => Auth::user()->id,
            'semester_id' => Semester::current()->id,
            'amount' => $request->amount,
            'payment_type_id' => $type,
            'comment' => $request->comment,
            'moved_to_checkout' => Carbon::now(),
        ]);

        return redirect()->back()->with('message', __('general.successfully_added'));
    }
}
