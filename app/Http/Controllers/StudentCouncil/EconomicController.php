<?php

namespace App\Http\Controllers\StudentCouncil;

use App\Checkout;
use App\PaymentType;
use App\Semester;
use App\Transaction;
use App\User;
use App\Workshop;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InternetController;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class EconomicController extends Controller
{
    public function index($redirected = false)
    {
        $checkout = Checkout::studentsCouncil();

        $this->authorize('view', $checkout);

        $transactions = [];
        $semesters = Semester::allUntilCurrent()
            ->sortByDesc(function ($semester, $key) {
                return $semester->getStartDate();
            })->filter(function ($semester, $key){
                return $semester->transactions()->count()>0;
            });

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
            $transactions['kkt'] = $checkout->kktSum($semester);
            $transactions['sum'] = $semester->transactionsInCheckout($checkout)->sum('amount');

            $data[$semester->tag().' ('.$semester->getStartDate()->format('Y.m.d').'-'.$semester->getEndDate()->format('Y.m.d').')'] = [
                'transactions' => $transactions,
                'workshop_balances' => $semester->workshopBalances
            ];
        };

        //checkout balances
        $current_balance = $checkout->balance();
        $current_balance_in_checkout = $checkout->balanceInCheckout();

        if($redirected){
            return view('student-council.economic-committee.app',[
                'data' => $data,
                'current_balance' => $current_balance,
                'current_balance_in_checkout' => $current_balance_in_checkout,
                ])->with('message', __('general.successfully_added'));
        } else {
            return view('student-council.economic-committee.app',[
                'data' => $data,
                'current_balance' => $current_balance,
                'current_balance_in_checkout' => $current_balance_in_checkout]);
        }
    }

    public function indexKKTNetreg()
    {
        $checkout = Checkout::studentsCouncil();
        $this->authorize('handle', $checkout);

        $my_transactions_not_in_checkout = Transaction::where('receiver_id', Auth::user()->id)
            ->where('moved_to_checkout', null)->get();
        $sum = $my_transactions_not_in_checkout->sum('amount');

        $all_kktnetreg_transaction = Transaction::whereIn(
            'payment_type_id',
            [PaymentType::kkt()->id, PaymentType::netreg()->id]
        )->get();

        return view('student-council.economic-committee.kktnetreg', [
            'users' => User::all(),
            'my_transactions' => $my_transactions_not_in_checkout,
            'sum_my_transactions' => $sum,
            'all_transactions' => $all_kktnetreg_transaction,
            'current_semester' => Semester::current()->tag()
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

        $this->authorize('handle', $valasztmany_checkout);
        $this->authorize('handle', $admin_checkout);

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
        $kkt = $this->createTransaction($valasztmany_checkout, Auth::user()->id, $payer->id, $request->kkt, PaymentType::KKT);
        $netreg = $this->createTransaction($admin_checkout, Auth::user()->id, $payer->id, $request->netreg, PaymentType::NETREG);

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
        $this->authorize('handle', $checkout);

        /* Moving the Netreg amount from Valasztmany to Admins is not tracked (yet) */
        $validator = Validator::make($request->all(), [
            'password' => 'required|in:'.$checkout->password,
        ]);
        $validator->validate();
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $transactions = Transaction::where('receiver_id', Auth::user()->id)
            ->where('moved_to_checkout', null)->get();

        foreach ($transactions as $transaction) {
            $transaction->update([
                'moved_to_checkout' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    public function addTransaction(Request $request)
    {
        $checkout = Checkout::studentsCouncil();
        $this->authorize('handle', $checkout);

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'amount' => 'required|integer',
            'password' => 'required|in:'.$checkout->password,
        ]);
        $validator->validate();
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $type = $request->amount > 0 ? PaymentType::INCOME : PaymentType::EXPENSE;

        $this->createTransaction($checkout, null, Auth::user()->id, $request->amount, $type, Carbon::now(), $request->comment);

        return redirect()->action(
            [EconomicController::class, 'index'], ['redirected' => true]
        );
    }

    public function deleteTransaction(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transaction);

        $this->authorize('delete', $transaction);

        $transaction->delete();
        return redirect()->back()->with('message', __('general.successfully_deleted'));
    }

    public function calculateWorkshopBalance(Semester $semester)
    {
        //TODO (#382)
        //for every active member in a workshop
        //payed kkt * (if resident: 0.6, if day-boarder: 0.45) / user's workshops' count
        //or the proportions should be edited?

        /* $payed_member_num = $workshop_balance->workshop->users->filter(function ($user, $key) use ($workshop_balance) {
                return ($user->isActiveIn($workshop_balance->semester)
                        && !$user->haveToPayKKTNetregInSemester($workshop_balance->semester));
                })->count();
        $remaining_member_num = $workshop_balance->workshop->users->filter(function ($user, $key) use ($workshop_balance) {
                return ($user->haveToPayKKTNetregInSemester($workshop_balance->semester));
                })->count(); */

    }

    private function createTransaction($checkout, $receiver_id, $payer_id, $amount, $type, $moved_to_checkout = null, $comment = null)
    {
        $transaction = Transaction::create([
            'checkout_id' => $checkout->id,
            'receiver_id' => $receiver_id,
            'payer_id' => $payer_id,
            'semester_id' => Semester::current()->id,
            'amount' => $amount,
            'payment_type_id' => PaymentType::where('name', $type)->firstOrFail()->id,
            'comment' => $comment,
            'moved_to_checkout' => $moved_to_checkout,
        ]);
        return $transaction;
    }
}
