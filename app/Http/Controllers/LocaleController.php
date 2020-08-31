<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\LocalizationContribution;
use App\User;

class LocaleController extends Controller
{
    public function set(Request $request, $locale)
    {
        App::setLocale($locale);
        return redirect()->back()->cookie('locale', $locale, config('app.locale_cookie_lifespan'));
    }

    /**
     * Localization Contributions
     */

    public function index()
    {
        $contributor_ids = DB::table('localization_contributions')
            ->select('contributor_id as id')
            ->where('approved', true)
            ->groupBy('contributor_id')
            ->get();

        $contributors = [];
        foreach ($contributor_ids as $value) {
            $contributor = User::find($value->id);
            if ($contributor != null){
                $contributors[] = $contributor->name;
            }
        }
        return view('localizations', [
            'contributions' => LocalizationContribution::all(),
            'contributors' => $contributors
        ]);
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

        return response()->json(null, 204);
    }

    function addExpression($language, $key, $value)
    {
        return Artisan::call('locale:add', [
            'language' => $language,
            'key' => $key,
            'value' => $value,
            '--force' => 'true',
        ]);
    }

    public function approve(Request $request)
    {
        $this->authorize('approve', LocalizationContribution::class);

        $contribution = LocalizationContribution::findOrFail($request->id);
        if ($this->addExpression($contribution->language, $contribution->key, $contribution->value) == 0) {
            $contribution->update(['approved' => true]);
            return back()->with('message', __('general.successful_modification'));
        } else {
            return back()->with('error', 'Something went wrong. Please contact the system administrators.');
        }
    }

    public function approveAll(Request $request)
    {
        $this->authorize('approve', LocalizationContribution::class);

        foreach (LocalizationContribution::where('approved', false)->get() as $contribution) {
            if ($this->addExpression($contribution->language, $contribution->key, $contribution->value) == 0) {
                $contribution->update(['approved' => true]);
            } else {
                return back()->with('error', 'Something went wrong with '.$contribution->key.'. Please contact the system administrators.');
            }
        }
        return back()->with('message', __('general.successful_modification'));
    }

    public function delete(Request $request)
    {
        $this->authorize('approve', LocalizationContribution::class);

        $contribution = LocalizationContribution::findOrFail($request->id);
        $contribution->delete();

        return back()->with('message', __('general.successful_modification'));
    }
}
