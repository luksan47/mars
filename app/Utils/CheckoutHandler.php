<?php

namespace App\Utils;

use App\Models\Checkout;
use App\Models\PaymentType;
use App\Models\Semester;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait CheckoutHandler
{
    /**
     * Gets the transactions (collection) of the certain payment types in the checkout.
     * @param Checkout
     * @param array $payment_types payment type names
     */
    private function getTransactionsByPaymentTypes(Checkout $checkout, array $payment_types)
    {
        $this->authorize('view', $checkout);

        $payment_type_ids = $this->paymentTypeIDs($payment_types);

        return Transaction::where('checkout_id', $checkout->id)
            ->whereIn('payment_type_id', $payment_type_ids)
            ->with(['semester', 'type'])
            ->orderBy('semester_id', 'desc')
            ->get();
    }

    /**
     * Gets the transactions of the certain payment types in the checkout.
     * @param Checkout
     * @param array $payment_types payment type ids
     */
    private function getTransactionsGroupedBySemesters(Checkout $checkout, array $payment_types)
    {
        $this->authorize('view', $checkout);

        return Semester::orderBy('year', 'desc')
            ->orderBy('part', 'desc')
            ->get()
            ->where('tag', '<=', Semester::current()->tag)
            ->load([
                'transactions' => function ($query) use ($checkout, $payment_types) {
                    $query->whereIn('payment_type_id', $payment_types);
                    $query->where('checkout_id', $checkout->id);
                    $query->with('type');
                },
                'workshopBalances.workshop',
            ]);
    }

    /**
     * Gets the users with the transactions received which are not added to checkout yet.
     * @param array $payment_typed payment type names
     * @param collection of the users with transactions_received attribute
     */
    public function getCollectedTransactions(array $payment_types)
    {
        $payment_type_ids = $this->paymentTypeIDs($payment_types);

        return User::collegists()->load(['transactions_received' => function ($query) use ($payment_type_ids) {
            $query->whereIn('payment_type_id', $payment_type_ids);
            $query->where('moved_to_checkout', null);
        }])->filter(function ($user, $key) {
            return $user->transactions_received->count();
        })->unique();
    }

    /**
     * Move all the transactions received by the given user to the checkout.
     * Moving the Netreg amount from the students council to the admins is not tracked.
     * Note that the function do not filter with checkouts, only payment types.
     * @param User
     * @param Checkout
     * @param array $payment_types payment type names
     * @return void
     */
    public function toCheckout(Request $request, array $payment_types)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        $validator->validate();
        $user = User::findOrFail($request->user_id);

        $payment_type_ids = $this->paymentTypeIDs($payment_types);

        Transaction::where('receiver_id', $user->id)
            ->whereIn('payment_type_id', $payment_type_ids)
            ->where('moved_to_checkout', null)
            ->update(['moved_to_checkout' => Carbon::now()]);
    }

    /**
     * Validates the request and creates a basic (income/expense) transaction in the checkout.
     * The receiver will be null.
     * The transaction will be moved to the checkout instantly.
     * @param Request
     * @param Checkout
     * @return void
     */
    public function createTransaction(Request $request, Checkout $checkout): void
    {
        $this->authorize('administrate', $checkout);

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'amount' => 'required|integer',
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
     * Note that the checkout is not filtered (because KKT and NETREG are in diff. checkouts).
     *
     * @param array $payment_types payment type names
     */
    public function userTransactionsNotInCheckout(array $payment_types): iterable
    {
        $payment_type_ids = $this->paymentTypeIDs($payment_types);

        return Transaction::where('receiver_id', Auth::user()->id)
            ->with(['type', 'payer'])
            ->where('moved_to_checkout', null)
            ->whereIn('payment_type_id', $payment_type_ids)
            ->get();
    }

    /**
     * Converts the paymentType names to the paymentType ids in an array.
     * @param array $payment_types array of the names
     * @return array of ints
     */
    private function paymentTypeIDs(array $payment_types): array
    {
        return array_map(fn ($name) => PaymentType::getByName($name)->id, $payment_types);
    }

    /**
     * Returns the route name base, so some routes could be generated automatically.
     * For example the route base of economic_committee.transaction.delete is economic_committee.
     */
    abstract public static function routeBase();
}
