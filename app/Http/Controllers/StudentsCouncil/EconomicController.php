<?php

namespace App\Http\Controllers\StudentsCouncil;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Network\InternetController;
use App\Models\Checkout;
use App\Models\PaymentType;
use App\Models\Semester;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WorkshopBalance;
use App\Utils\CheckoutHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EconomicController extends Controller
{
    use CheckoutHandler;

    public function index($redirected = false)
    {
        $checkout = Checkout::studentsCouncil();

        $payment_types = [
            PaymentType::INCOME,
            PaymentType::EXPENSE,
            PaymentType::KKT,
        ];

        $checkoutData = $this->getCheckout($checkout, $payment_types);

        $view = view('student-council.economic-committee.app', $checkoutData);

        if ($redirected) {
            return $view->with('message', __('general.successfully_added'));
        }

        return $view;
    }

    public function indexKKTNetreg()
    {
        $checkout = Checkout::studentsCouncil();

        $this->authorize('handleAny', $checkout);

        $payment_types = [
            PaymentType::NETREG,
            PaymentType::KKT,
        ];

        $users_has_to_pay_kktnetreg = User::hasToPayKKTNetregInSemester(Semester::current()->id)->get();

        $checkoutData = $this->getCurrentCheckout($checkout, $payment_types);

        return view('student-council.economic-committee.kktnetreg', $checkoutData)
            ->with('users', $users_has_to_pay_kktnetreg);
    }

    public function indexTransaction()
    {
        $checkout = Checkout::studentsCouncil();

        $this->authorize('handleAny', $checkout);

        $payment_types = [
            PaymentType::INCOME,
            PaymentType::EXPENSE,
            PaymentType::KKT,
        ];

        $checkoutData = $this->getCheckout($checkout, $payment_types);

        return view('student-council.economic-committee.transaction', $checkoutData);
    }

    public function payKKTNetreg(Request $request)
    {
        $valasztmany_checkout = Checkout::studentsCouncil();
        $admin_checkout = Checkout::admin();

        $this->authorize('addPayment', $valasztmany_checkout);
        $this->authorize('addPayment', $admin_checkout);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'kkt' => 'required|integer|min:0',
            'netreg' => 'required|integer|min:0',
        ]);
        $validator->validate();

        $payer = User::findOrFail($request->user_id);

        // Creating transactions
        $kkt = Transaction::create([
            'checkout_id' => $valasztmany_checkout->id,
            'receiver_id' => Auth::user()->id,
            'payer_id' => $payer->id,
            'semester_id' => Semester::current()->id,
            'amount' => $request->kkt,
            'payment_type_id' => PaymentType::kkt()->id,
            'comment' => null,
            'moved_to_checkout' => null,
        ]);

        $netreg = Transaction::create([
            'checkout_id' => $admin_checkout->id,
            'receiver_id' => Auth::user()->id,
            'payer_id' => $payer->id,
            'semester_id' => Semester::current()->id,
            'amount' => $request->netreg,
            'payment_type_id' => PaymentType::netreg()->id,
            'comment' => null,
            'moved_to_checkout' => null,
        ]);

        WorkshopBalance::generateBalances(Semester::current()->id);

        $new_internet_expire_date = InternetController::extendUsersInternetAccess($payer);
        $internet_expiration_message = null;
        if ($new_internet_expire_date !== null) {
            $internet_expiration_message = __('internet.expiration_extended', [
                'new_date' => Carbon::parse($new_internet_expire_date)->format('Y-m-d'),
            ]);
        }
        Mail::to($payer)->queue(new \App\Mail\PayedTransaction($payer->name, [$kkt, $netreg], $internet_expiration_message));

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    public function KKTNetregToCheckout(Request $request)
    {
        $checkout = Checkout::studentsCouncil();
        $payment_types = [
            PaymentType::KKT,
            PaymentType::NETREG,
        ];

        return $this->toCheckout($request, $checkout, $payment_types);
    }

    public function addTransaction(Request $request)
    {
        $checkout = Checkout::studentsCouncil();
        $this->createTransaction($request, $checkout);

        return redirect()->action(
            [EconomicController::class, 'index'],
            ['redirected' => true]
        );
    }

    public function calculateWorkshopBalance()
    {
        $this->authorize('administrate', Checkout::studentsCouncil());
        WorkshopBalance::generateBalances(Semester::current()->id);

        return redirect()->back()->with('message', __('general.successful_modification'));
    }

    public static function routeBase()
    {
        return 'economic_committee';
    }
}
