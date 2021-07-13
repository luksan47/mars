<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications;
use App\Models\Uploads;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $application = Applications::where('user_id', $user_id)->take(1)->get(['id', 'profile_picture_path'])[0];

        $uploads = Uploads::where('applications_id', $application['id'])->get();

        return view('upload.upload')->with(['uploads' => $uploads, 'profile_picture_path' => $application['profile_picture_path']]);
    }

    public function list()
    {
        $user_id = auth()->user()->id;
        $application_id = Applications::where('user_id', $user_id)->take(1)->get(['id'])[0]['id'];
        $uploads = Uploads::where('applications_id', $application_id)->get();

        return view('upload.upload')->with('uploads', $uploads);
    }

    public function edit()
    {
        return view('upload.edit');
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'file_file' => 'required|mimes:jpg,jpeg,png,gif,svg,pdf|max:2000', //TODO: file extensions
        ]);

        $path = $request->file('file_file')->store('uploads');

        $user_id = auth()->user()->id;
        $application_id = Applications::where('user_id', $user_id)->take(1)->get(['id'])[0]['id'];

        Uploads::create([
            'applications_id' => $application_id,

            'file_name' => $request->name,
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'A fájl sikeresen feltöltésre került!');
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $user_id = auth()->user()->id;
        $application_id = Applications::where('user_id', $user_id)->take(1)->get(['id'])[0]['id'];

        $file = Uploads::where('id', $request->input('id'))->where('applications_id', $application_id)->get();

        if (is_null($file)) {
            return redirect()->back()->with('error', 'I <3 U, dude...');
        } else {
            $file = $file[0];
        }

        Storage::delete($file['file_path']);

        Uploads::where('id', $request->input('id'))->where('applications_id', $application_id)->delete();
        return redirect()->back()->with('success', 'A fájl eltávolításrakerült!');
    }
}
