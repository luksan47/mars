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

    public function list()
    {
        $locale = [];
        $languages = array_diff(scandir(base_path('resources/lang/')), ['..', '.']);
        foreach ($languages as $language) {
            $files = array_diff(scandir(base_path('resources/lang/'.$language)), ['..', '.']);
            foreach ($files as $file_in) {
                if ($file_in != 'validation.php') {
                    $name = substr($file_in, 0, strlen($file_in) - 4);
                    $expressions = require base_path('resources/lang/'.$language.'/'.$file_in);
                    $locale[$language][$name] = $expressions;
                }
            }
        }
        return view('locale.app')->with('locale', $locale);
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

        return back()->with('message', __('general.successful_modification'));
    }

    public function approve(Request $request)
    {
        $contribution = LocalizationContribution::findOrFail($request->id);
        $exitCode = Artisan::call('locale:add', [
            'language' => $contribution->language,
            'key' => $contribution->key,
            'value' => $contribution->value,
            '--force' => 'true',
        ]);
        if ($exitCode == 0) {
            $contribution->update(['approved' => true]);

            return back()->with('message', __('general.successful_modification'));
        }

        return back()->with('error', 'Something went wrong. Artisan error code: '.$exitCode);
    }

    public function delete(Request $request)
    {
        $contribution = LocalizationContribution::findOrFail($request->id);
        $contribution->delete();

        return back()->with('message', __('general.successful_modification'));
    }
}
