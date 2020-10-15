<?php

namespace App\Utils;

use App\Models\Checkout;
use App\Models\PaymentType;
use App\Models\Semester;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait CheckoutHandler
{
    private function getCheckout(Checkout $checkout, array $payment_types)
    {
        $this->authorize('view', $checkout);

        $payment_type_ids = $this->paymenyTypeIDs($payment_types);

        $user_transactions_not_in_checkout = $this->userTransactionsNotInCheckout($payment_types);

        $transactions = Transaction::all()
            ->whereIn('payment_type_id', $payment_type_ids)
            ->groupBy([function ($item) {
                return $item['semester']->tag();
            }, function ($item) {
                return $item['type']->name;
            }]);

        $current_balance = $checkout->balance();
        $current_balance_in_checkout = $checkout->balanceInCheckout();

        return [
            'transactions' => $transactions,
            'user_transactions_not_in_checkout' => $user_transactions_not_in_checkout,
            'current_balance' => $current_balance,
            'current_balance_in_checkout' => $current_balance_in_checkout,
            'checkout_id' => $checkout->id,
            'route_base' => $this->routeBase(),
        ];
    }

    public function toCheckout(Request $request, Checkout $checkout, array $payment_types)
    {
        $this->authorize('addPayment', $checkout);

        /* Moving the Netreg amount from Valasztmany to Admins is not tracked (yet) */
        $validator = Validator::make($request->all(), [
            'password' => 'required|in:'.$checkout->password,
        ]);
        $validator->validate();

        $payment_type_ids = $this->paymenyTypeIDs($payment_types);

        $transactions = Transaction::where('receiver_id', Auth::user()->id)
            ->whereIn('payment_type_id', $payment_type_ids)
            ->where('moved_to_checkout', null)
            ->get();

        foreach ($transactions as $transaction) {
            $transaction->update([
                'moved_to_checkout' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    public function createTransaction(Request $request, Checkout $checkout)
    {
        $this->authorize('administrate', $checkout);

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'amount' => 'required|integer',
            'password' => 'required|in:'.$checkout->password,
        ]);
        $validator->validate();

        $type = $request->amount > 0 ? PaymentType::income()->id : PaymentType::expense()->id;

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
    }

    public function deleteTransaction(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        $transaction->delete();

        return redirect()->back()->with('message', __('general.successfully_deleted'));
    }

    public function userTransactionsNotInCheckout(array $payment_types)
    {
        $payment_type_ids = $this->paymenyTypeIDs($payment_types);

        $user_transactions_not_in_checkout = Transaction::where('receiver_id', Auth::user()->id)
            ->where('moved_to_checkout', null)
            ->whereIn('payment_type_id', $payment_type_ids)
            ->get();

        return $user_transactions_not_in_checkout;
    }

    private function paymenyTypeIDs(array $payment_types)
    {
        return array_map(fn ($name) => PaymentType::getByName($name)->id, $payment_types);
    }

    /**
     * Returns the route name base, so some routes could be generated automatically.
     * For example the route base of economic_committee.transaction.delete is economic_committee.
     */
    abstract public static function routeBase();
}
