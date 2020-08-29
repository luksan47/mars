<?php

namespace App\Http\Controllers;

use App\User;
use App\ImportItem;
use App\Console\Commands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class DocumentController extends Controller
{

    // Returns .tex file in debug mode
    public function generatePDF($path, $data)
    {
        $renderedLatex = view($path)->with($data)->render();

        $filename =  md5(rand(0, 100000) . date('c'));
        $path = Storage::disk('latex')->put($filename . '.tex', $renderedLatex);
        $outputDir = Storage::disk('latex')->path('/');

        // TODO: figure out result
        Commands::latexToPdf($path, $outputDir);

        if (config('app.debug')) {
            $result_file = Storage::disk('latex')->path($filename . ".tex");
        } else {
            $result_file = Storage::disk('latex')->path($filename . ".pdf");
        }
        return $result_file;
    }

    public function generateLicense()
    {
        $user = Auth::user();

        if(!$user->hasPersonalInformation()) {
            return back()->withInput()->with('error',  __('latex.missing_personal_info'));
        }
        $info = $user->personalInformation;

        $pdf = $this->generatePDF('latex.license',
            [ 'name' => $user->name,
              'address' => $user->zip_code . ' ' . $info->getAddress(),
              'phone' => $info->phone_number,
              'email' => $user->email,
              'place_and_of_birth' => $info->getPlaceAndDateOfBirth(),
              'mothers_name' => $info->mothers_name,
              'date' => date("Y.m.d"),
        ]);
        return $pdf;
    }

    public function printLicense()
    {
        $license = $this->generateLicense();
        //TODO
        return redirect()->back();
    }

    public function downloadLicense()
    {
        $license = $this->generateLicense();
        return response()->download($license);
    }

    public function index()
    {
        return view('document.index');
    }

    public function showImport()
    {
        return view('document.import', ['items' => Auth::user()->importItems]);
    }

    public function addImport(Request $request)
    {
        ImportItem::create([
            'user_id' => Auth::user()->id,
            'name' => $request->item,
            'serial_number'=> $request->serial_number ?? null
        ]);
        return redirect()->back()->with('message', __('general.successful_modification'));
    }
    public function removeImport(Request $request)
    {
        ImportItem::findOrFail($request->id)->delete();
        return redirect()->back()->with('message', __('general.successful_modification'));
    }
}
