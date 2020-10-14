<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\PaymentType;
use App\Models\Semester;
use App\Models\Transaction;
use App\Utils\CheckoutHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminCheckoutController extends Controller
{
    use CheckoutHandler;

    public function showCheckout()
    {
        $payment_types = [
            PaymentType::INCOME,
            PaymentType::EXPENSE,
            PaymentType::PRINT,
            PaymentType::NETREG,
        ];
        $checkoutData = $this->getCheckout(Checkout::admin(), $payment_types);
        return view('network.checkout', $checkoutData);
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

    public static function routeBase() {
        return 'admin.checkout';
    }
}
