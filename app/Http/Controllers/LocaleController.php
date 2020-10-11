<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\LocalizationContribution;
use App\Models\User;

/**
 * Localization Contributions
 */
class LocaleController extends Controller
{
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
        $this->authorize('viewAny', LocalizationContribution::class);

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
        $contribution = LocalizationContribution::findOrFail($request->id);

        $this->authorize('approve', $contribution);

        if ($this->addExpression($contribution->language, $contribution->key, $contribution->value) == 0) {
            $contribution->update(['approved' => true]);
            return back()->with('message', __('general.successful_modification'));
        } else {
            return back()->with('error', 'Something went wrong. Please contact the system administrators.');
        }
    }

    public function approveAll(Request $request)
    {

        foreach (LocalizationContribution::where('approved', false)->get() as $contribution) {
            if(Auth::user()->cannot('approve', $contribution)) {
                continue;
            }

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
        $contribution = LocalizationContribution::findOrFail($request->id);

        $this->authorize('approve', $contribution);

        $contribution->delete();

        return back()->with('message', __('general.successful_modification'));
    }
}
