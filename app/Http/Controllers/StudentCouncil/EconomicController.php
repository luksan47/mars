<?php

namespace App\Http\Controllers\StudentCouncil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\InternetController;

use App\Checkout;
use App\PaymentType;
use App\Semester;
use App\Transaction;
use App\User;
use App\Workshop;


class EconomicController extends Controller
{
    public function index($redirected = false)
    {
        $transactions = [];
        $checkout = Checkout::where('name', 'VALASZTMANY')->firstOrFail();
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
                ->where('payment_type_id', PaymentType::where('name', 'INCOME')->firstOrFail()->id)
                ->get();
            
            $transactions['expense'] = $semester->transactionsInCheckout($checkout)
                ->where('payment_type_id', PaymentType::where('name', 'EXPENSE')->firstOrFail()->id)
                ->get();
            $transactions['kkt'] = $checkout->kktSum($semester);
            $transactions['sum'] = $semester->transactionsInCheckout($checkout)
                ->sum('amount');
            
            $workshop_balances = [];
            foreach ($semester->workshopBalances as $workshop_balance) {
                $payed_member_num = $workshop_balance->workshop->users->filter(function ($user, $key) use ($workshop_balance) {
                    return ($user->isActiveIn($workshop_balance->semester)
                         && !$user->haveToPayKKTNetregInSemester($workshop_balance->semester));
                    })->count();
                $remaining_member_num = $workshop_balance->workshop->users->filter(function ($user, $key) use ($workshop_balance) {
                    return ($user->haveToPayKKTNetregInSemester($workshop_balance->semester));
                    })->count();;

                $workshop_balances[$workshop_balance->workshop->name] = [
                    'payed_member_num' => $payed_member_num,
                    'remaining_members_num' => $remaining_member_num,
                    'allocated_balance' => $workshop_balance->allocated_balance,
                    'used_balance' => $workshop_balance->used_balance,
                    'remaining_balance' => $workshop_balance->allocated_balance - $workshop_balance->used_balance
                ];
            }
            
            $data[$semester->tag().' ('.$semester->getStartDate()->format('Y-m-d').' / '.$semester->getEndDate()->format('Y-m-d').')'] = [
                'transactions' => $transactions,
                'workshop_balances' => $workshop_balances
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
        $user = Auth::user();
        if(!$user->hasRole(\App\Role::STUDENT_COUNCIL)) return response(403); //TODO make policy
        $users = User::all();

        $my_transactions_not_in_checkout = Transaction::where('receiver_id', $user->id)
            ->where('moved_to_checkout', null)->get();
        $sum = $my_transactions_not_in_checkout->sum('amount');

        $semester = Semester::current();
        $all_kktnetreg_transaction = Transaction::where(function ($query) {
            $query->where('payment_type_id', PaymentType::where('name', 'KKT')->firstOrFail()->id)
                    ->orWhere('payment_type_id', PaymentType::where('name', 'NETREG')->firstOrFail()->id);
        })->get();

        return view('student-council.economic-committee.kktnetreg', [
            'users' => $users,
            'my_transactions' => $my_transactions_not_in_checkout,
            'sum_my_transactions' => $sum,
            'all_transactions' => $all_kktnetreg_transaction,
            'current_semester' => $semester->tag()
        ]);
}

    public function indexTransaction()
    {
        $user = Auth::user();
        if(!$user->hasRole(\App\Role::STUDENT_COUNCIL)) return response(403); //TODO make policy
        return view('student-council.economic-committee.transaction');

    }

    public function payKKTNetreg(Request $request)
    {
        $user = Auth::user();
        if(!$user->hasRole(\App\Role::STUDENT_COUNCIL)) return response(403); //TODO make policy
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'kkt' => 'required|integer|min:0',
            'netreg' => 'required|integer|min:0',
        ]);
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $valasztmany_checkout = Checkout::where('name', 'VALASZTMANY')->firstOrFail();
        $admin_checkout = Checkout::where('name', 'ADMIN')->firstOrFail();

        /** Creating transactions even if amount is 0.
         * Paying 0 means that the user payed their netreg+kkt depts (which is 0 in this case).
         */
        $kkt = Transaction::create([
            'checkout_id' => $valasztmany_checkout->id,
            'receiver_id' => $user->id,
            'payer_id' => $request->user_id,
            'semester_id' => Semester::current()->id,
            'amount' => $request->kkt,
            'payment_type_id' => PaymentType::where('name', 'KKT')->firstOrFail()->id,
            'comment' => null,
            'moved_to_checkout' => null,
        ]);

        $netreg = Transaction::create([
            'checkout_id' => $admin_checkout->id,
            'receiver_id' => $user->id,
            'payer_id' => $request->user_id,
            'semester_id' => Semester::current()->id,
            'amount' => $request->netreg,
            'payment_type_id' => PaymentType::where('name', 'NETREG')->firstOrFail()->id,
            'comment' => null,
            'moved_to_checkout' => null,
        ]);
        $payer = User::find($request->user_id);
        
        $new_internet_expire_date = InternetController::extendUsersInternetAccess($payer);
        if (config('mail.active')) {
            if ($new_internet_expire_date == null){
                Mail::to($payer)
                    ->queue(new \App\Mail\PayedTransaction(
                        $payer->name, [$kkt, $netreg]));
            } else {
                Mail::to($payer)
                    ->queue(new \App\Mail\PayedTransaction(
                        $payer->name, [$kkt, $netreg], 
                        __('internet.expiration_extended', 
                            ['new_date' => $new_internet_expire_date->format('Y-m-d')])));
            }
        }

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    public function KKTNetregToCheckout(Request $request)
    {
        $user = Auth::user();
        if(!$user->hasRole(\App\Role::STUDENT_COUNCIL)) return response(403); //TODO make policy

        /* Moving the Netreg amount from Valasztmany to Admins is not tracked (yet) */
        $checkout_password = Checkout::where('name', 'VALASZTMANY')->firstOrFail()->password;
        $validator = Validator::make($request->all(), [
            'password' => 'required|in:'.$checkout_password, //TODO bug on wrong pwd
        ]);
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        //TODO log? (because the password is not encrypted)

        $transactions = Transaction::where('receiver_id', $user->id)
            ->where('moved_to_checkout', null)->get();

        foreach ($transactions as $transaction) {
            $transaction->moved_to_checkout = \Carbon\Carbon::now();
            $transaction->save();
        }

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    public function addTransaction(Request $request)
    {
        $user = Auth::user();
        if(!$user->hasRole(\App\Role::STUDENT_COUNCIL)) return response(403); //TODO make policy
        
        $checkout_password = Checkout::where('name', 'VALASZTMANY')->firstOrFail()->password;
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'amount' => 'required|integer',
            'password' => 'required|in:'.$checkout_password, //TODO bug on wrong pwd
        ]);
        $validator->validate();
        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $checkout = Checkout::firstWhere('name', 'VALASZTMANY');
        $type = ($request->amount > 0 ? 'INCOME' : 'EXPENSE');
        Transaction::create([
            'checkout_id' => $checkout->id,
            'receiver_id' => null,
            'payer_id' => $user->id,  //null would be enough, just store for logging
            'semester_id' => Semester::current()->id,
            'amount' => $request->amount,
            'payment_type_id' => PaymentType::where('name', $type)->firstOrFail()->id,
            'comment' => $request->comment,
            'moved_to_checkout' => \Carbon\Carbon::now(), //TODO? option to add to checkout later
        ]);

        return redirect()->action(
            [EconomicController::class, 'index'], ['redirected' => true]
        );
    }

    public function deleteTransaction(Transaction $transaction)
    {
        $user = Auth::user();
        if(!$user->hasRole(\App\Role::STUDENT_COUNCIL)) return response(403); //TODO make policy
        $transaction->delete();
        return redirect()->back()->with('message', __('general.successfully_deleted'));
    }

    public function calculateWorkshopBalance(Semester $semester)
    {
        //TODO (#382) 
        //for every active member in a workshop
        //payed kkt * (if resident: 0.6, if day-boarder: 0.45) / user's workshops' count
        //or the proportions should be edited?

    }
}
