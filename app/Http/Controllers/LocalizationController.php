<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\LocalizationContribution;

class LocalizationController extends Controller
{
    public function index()
    {
        return view('localizations');
    }

    public function add(Request $request){
        $user = Auth::user();

        for ($i=0; $i < count($request->key); $i++) { 
           LocalizationContribution::create([
                'key' => $request->key[$i],
                'value' => $request->value[$i],
                'contributor_id' => $user->id
           ]);
        }

        return back()->with('message', @lang('successful_modification'));
    }
}
