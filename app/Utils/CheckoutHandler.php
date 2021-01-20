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
    /**
     * Gets the transactions of the certain payment types in the checkout.
     * @param Checkout
     * @param array $payment_types payment type names
     * @return array transactions: filtered by payment_type, checkout;
     * @return array user_transactions_not_in_checkout: filtered by payment_type, receiver
     * @return array checkout_id: int
     * @return array route_base: eg. economic_committee
     */
    private function getCurrentCheckout(Checkout $checkout, array $payment_types): array
    {
        $this->authorize('view', $checkout);

        $payment_type_ids = $this->paymenyTypeIDs($payment_types);

        $user_transactions_not_in_checkout = $this->userTransactionsNotInCheckout($payment_types);

        $transactions = Transaction::where('checkout_id', $checkout->id)
            ->whereIn('payment_type_id', $payment_type_ids)
            ->with(['semester', 'type'])
            ->orderBy('semester_id', 'desc')
            ->get();

        return [
            'transactions' => $transactions,
            'user_transactions_not_in_checkout' => $user_transactions_not_in_checkout,
            'checkout_id' => $checkout->id,
            'route_base' => $this->routeBase(),
        ];
    }

    /**
     * Gets the transactions of the certain payment types in the checkout.
     * @param Checkout
     * @param array $payment_types payment type names
     * @return array semesters: transactions grouped by semesters
     * @return array current_balance: int
     * @return array current_balance_in_checkout: int
     * @return array route_base: eg. economic_committee
     */
    private function getCheckout(Checkout $checkout, array $payment_types)
    {
        $this->authorize('view', $checkout);

        $payment_type_ids = $this->paymenyTypeIDs($payment_types);

        $current_semester = Semester::current();
        $semesters = Semester::orderBy('year', 'desc')
            ->orderBy('part', 'desc')
            ->get()
            ->where('tag', '<=', $current_semester->tag)
            ->load([
                'transactions' => function ($query) use ($checkout, $payment_type_ids) {
                    $query->whereIn('payment_type_id', $payment_type_ids);
                    $query->where('checkout_id', $checkout->id);
                    $query->with('type');
                },
                'workshopBalances.workshop',
            ]);

        $current_balance = $checkout->balance();
        $current_balance_in_checkout = $checkout->balanceInCheckout();


        return [
            'semesters' => $semesters,
            'current_balance' => $current_balance,
            'current_balance_in_checkout' => $current_balance_in_checkout,
            'checkout_id' => $checkout->id,
            'route_base' => $this->routeBase(),
        ];
    }

    /**
     * Move all the transactions received by the authenticated user
     * (filtered by the given payment types and the checkout)
     * to the checkout.
     * The checkout's password is required.
     * Moving the Netreg amount from the students council to the admins is not tracked.
     * @param Request
     * @param Checkout
     * @param array $payment_types payment type names
     * @return redirect back with message
     */
    public function toCheckout(Request $request, Checkout $checkout, array $payment_types)
    {
        $this->authorize('addPayment', $checkout);
        $validator = Validator::make($request->all(), [
            'password' => 'required|in:' . $checkout->password,
        ]);
        $validator->validate();

        $payment_type_ids = $this->paymenyTypeIDs($payment_types);

        Transaction::where('receiver_id', Auth::user()->id)
            ->whereIn('payment_type_id', $payment_type_ids)
            ->where('checkout_id', $checkout->id)
            ->where('moved_to_checkout', null)
            ->update(['moved_to_checkout' => Carbon::now()]);

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    /**
     * Validates the request and creates a basic (income/expense) transaction in the checkout.
     * The checkout's password is required.
     * The receiver will be null.
     * The transaction will be moved to the checkout instantly.
     * @param Request
     * @param Checkout $checkout
     * @return void
     */
    public function createTransaction(Request $request, Checkout $checkout): void
    {
        $this->authorize('administrate', $checkout);

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'amount' => 'required|integer',
            'password' => 'required|in:' . $checkout->password,
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

    /**
     * Return the transactions received by the authenticated user,
     * which has not been moved to checkout,
     * filtered by the payment types attribute.
     * Note that the checkout is not filtered.
     *
     * @param array $payment_types payment type names
     * @return iterable the collection of the transactions
     */
    public function userTransactionsNotInCheckout(array $payment_types): iterable
    {
        $payment_type_ids = $this->paymenyTypeIDs($payment_types);

        $user_transactions_not_in_checkout = Transaction::where('receiver_id', Auth::user()->id)
            ->with(['type', 'payer'])
            ->where('moved_to_checkout', null)
            ->whereIn('payment_type_id', $payment_type_ids)
            ->get();

        return $user_transactions_not_in_checkout;
    }


    /**
     * Converts the paymentType names to the paymentType ids in an array.
     * @param array $payment_types array of the names
     * @return array of ints
     */
    private function paymenyTypeIDs(array $payment_types): array
    {
        return array_map(fn ($name) => PaymentType::getByName($name)->id, $payment_types);
    }

    /**
     * Returns the route name base, so some routes could be generated automatically.
     * For example the route base of economic_committee.transaction.delete is economic_committee.
     */
    abstract public static function routeBase();
}
