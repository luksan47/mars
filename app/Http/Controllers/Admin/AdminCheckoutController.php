<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Checkout;
use App\PaymentType;
use App\Semester;
use App\Transaction;
use App\User;
use App\Workshop;

use App\Utils\TabulatorPaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminCheckoutController extends Controller
{
    public function showCheckout()
    {
        if(!Auth::user()->isSysAdmin()) abort(403); //TODO make policy
        $transactions = [];
        $checkout = Checkout::where('name', 'ADMIN')->firstOrFail();
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
            $transactions['netreg'] = $checkout->netregSum($semester);
            $transactions['print'] = $checkout->printSum($semester);
            $transactions['sum'] = $semester->transactionsInCheckout($checkout)
                ->sum('amount');
            
            $data[$semester->tag().' ('.$semester->getStartDate()->format('Y.m.d').'-'.$semester->getEndDate()->format('Y.m.d').')'] = [
                'transactions' => $transactions,
                'workshop_balances' => $semester->workshopBalances
            ];
        };

        $current_balance = $checkout->balance();
        $current_balance_in_checkout = $checkout->balanceInCheckout();
        
        return view('admin.checkout', [
            'data' => $data,
            'current_balance' => $current_balance,
            'current_balance_in_checkout' => $current_balance_in_checkout]);
    }
}
