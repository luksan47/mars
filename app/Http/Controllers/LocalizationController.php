<?php

namespace App\Http\Controllers;

use App\LocalizationContribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class LocalizationController extends Controller
{
    public function index()
    {
        return view('localizations', ['contributions'=> LocalizationContribution::all()]);
    }

    public function indexAdmin()
    {
        return view('admin.localizations', ['contributions'=> LocalizationContribution::where('approved', false)->get()]);
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        LocalizationContribution::create([
            'language' => $request->language,
            'key' => $request->key,
            'value' => $request->value,
            'contributor_id' => $user->id,
        ]);
        return back()->with('message', __('general.successful_modification'));
    }

    public function approve(Request $request)
    {
        $contribution = LocalizationContribution::findOrFail($request->id);
        $exitCode = Artisan::call('locale:add', [
            'language' => $contribution->language,
            'key' => $contribution->key,
            'value' => $contribution->value, 
            '--force' => 'true'
        ]);
        if($exitCode==0){
            $contribution->update(['approved' => true]);
            return back()->with('message', __('general.successful_modification'));
        }
        return back()->with('message', 'Something went wrong. Artisan error code: '.$exitCode);
    }

    public function delete(Request $request)
    {
        $contribution = LocalizationContribution::findOrFail($request->id);
        $contribution->delete();
        return back()->with('message', __('general.successful_modification'));
    }
}
