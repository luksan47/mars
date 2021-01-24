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
        $payment_types = PaymentType::forCheckout($checkout)->pluck('id')->toArray();
        $this->authorize('view', $checkout);

        $view = view('network.checkout', [
            'current_balance' => $checkout->balance(),
            'current_balance_in_checkout' => $checkout->balanceInCheckout(),
            'user_transactions_not_in_checkout' => $this->userTransactionsNotInCheckout([PaymentType::PRINT]),
            'collected_transactions' => $this->getCollectedTransactions([PaymentType::PRINT]),
            'semesters' => $this->getTransactionsGroupedBySemesters($checkout, $payment_types),
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
        $this->authorize('administrate', $checkout);

        $payment_types = [
            PaymentType::PRINT,
        ];

        $this->toCheckout($request, $payment_types);

        return redirect()->back()->with('message', __('general.successfully_added'));
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
