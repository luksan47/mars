<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\PaymentType;
use App\Utils\CheckoutHandler;
use Illuminate\Http\Request;

class AdminCheckoutController extends Controller
{
    use CheckoutHandler;

    public function showCheckout($redirected = false)
    {
        $checkout = Checkout::admin();
        $payment_type_ids = PaymentType::forCheckout($checkout)->pluck('id')->toArray();
        $payment_type_names = PaymentType::forCheckout($checkout)->pluck('name')->toArray();
        $this->authorize('view', $checkout);

        $view = view('network.checkout', [
            'current_balance' => $checkout->balance(),
            'current_balance_in_checkout' => $checkout->balanceInCheckout(),
            'user_transactions_not_in_checkout' => $this->userTransactionsNotInCheckout($payment_type_names),
            'collected_transactions' => $this->getCollectedTransactions($payment_type_names),
            'semesters' => $this->getTransactionsGroupedBySemesters($checkout, $payment_type_ids),
            'checkout' => $checkout,
            'route_base' => $this->routeBase(),
        ]);

        if ($redirected) {
            return $view->with('message', __('general.successfully_added'));
        }

        return $view;
    }

    public function printToCheckout(Request $request)
    {
        $checkout = Checkout::admin();
        $payment_types = [
            PaymentType::PRINT,
        ];

        return $this->toCheckout($request, $checkout, $payment_types);
    }

    public function addTransaction(Request $request)
    {
        $checkout = Checkout::admin();
        $this->createTransaction($request, $checkout);

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    public static function routeBase()
    {
        return 'admin.checkout';
    }
}
