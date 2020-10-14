<?php

namespace App\Http\Controllers\StudentsCouncil;

use App\Models\Checkout;
use App\Models\PaymentType;
use App\Models\Semester;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WorkshopBalance;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Network\InternetController;
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

        $workshop_balances = WorkshopBalance::groupBy(function ($item) {
            return $item['semester']->tag();
        });

        $view = view('student-council.economic-committee.app', $checkoutData)
            ->with('workshop_balances', $workshop_balances);
        if($redirected){
            return $view->with('message', __('general.successfully_added'));
        }
        return $view;
    }

    // TODO: use getCheckout when #437 is merged.
    public function indexKKTNetreg()
    {
        $checkout = Checkout::studentsCouncil();

        $this->authorize('handleAny', $checkout);

        $payment_types = [
            PaymentType::NETREG,
            PaymentType::KKT,
        ];

        $all_kktnetreg_transaction = Transaction::whereIn(
            'payment_type_id',
            [PaymentType::kkt()->id, PaymentType::netreg()->id]
        )->get();

        $user_transactions_not_in_checkout = $this->userTransactionsNotInCheckout($payment_types);

        return view('student-council.economic-committee.kktnetreg', [
            'users' => User::all(),
            'user_transactions_not_in_checkout' => $user_transactions_not_in_checkout,
            'transactions' => $all_kktnetreg_transaction,
            'route_base' => $this->routeBase(),
        ]);
}

    public function indexTransaction()
    {
        $this->authorize('handleAny', Checkout::class);
        return view('student-council.economic-committee.transaction');
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
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $payer = User::findOrFail($request->user_id);

        // Creating transactions even if amount is 0.
        // Paying 0 means that the user payed their netreg+kkt depts (which is 0 in this case).
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

        $new_internet_expire_date = InternetController::extendUsersInternetAccess($payer);
        if (config('mail.active')) {
            $internet_expiration_message = null;
            if ($new_internet_expire_date !== null){
                $internet_expiration_message = __('internet.expiration_extended', [
                    'new_date' => $new_internet_expire_date->format('Y-m-d')
                ]);
            }
            Mail::to($payer)->queue(new \App\Mail\PayedTransaction($payer->name, [$kkt, $netreg], $internet_expiration_message));
        }

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
            [EconomicController::class, 'index'], ['redirected' => true]
        );
    }

    public function calculateWorkshopBalance(Semester $semester)
    {
        $this->authorize('administrate', Checkout::studentsCouncil());
        WorkshopBalance::generateBalances();
        return redirect()->back()->with('message', __('general.successful_modification'));
    }

    public static function routeBase() {
        return 'economic_committee';
    }
}
