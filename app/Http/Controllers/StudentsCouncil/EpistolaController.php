<?php

namespace App\Http\Controllers\StudentsCouncil;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EpistolaCollegii;
use Image;

use App\Models\EpistolaNews;


class EpistolaController extends Controller
{

    const IMAGE_TARGET_SIZE = 800;

    public function index()
    {
        $this->authorize('view', EpistolaNews::class);

        //sort by valid_until property with null values at the end
        $unsent = EpistolaNews::where('sent', false)->get()->sortBy(function ($result) {
            if ($result->valid_until == null)
                if($result->date_for_sorting == null){
                    return PHP_INT_MAX;
                }
                return $result->date_for_sorting;
            return $result->valid_until;
        });

        $sent = EpistolaNews::where('sent', true)->get();
        return view(
            'student-council.communication-committee.app',
            [
                'unsent' => $unsent,
                'sent' => $sent,
            ]
        );
    }

    public function edit(EpistolaNews $epistola)
    {
        $this->authorize('edit', EpistolaNews::class);
        return view('student-council.communication-committee.edit', ['epistola' => $epistola]);
    }

    public function new()
    {
        $this->authorize('create', EpistolaNews::class);
        return view('student-council.communication-committee.edit', ['epistola' => []]);
    }

    public function restore(EpistolaNews $epistola)
    {
        $this->authorize('send', EpistolaNews::class);
        $epistola->update(['sent' => false]);
        return redirect(route('epistola'))->with('message', __('general.successful_modification'));
    }

    public function markAsSent(EpistolaNews $epistola)
    {
        $this->authorize('send', EpistolaNews::class);
        $epistola->update(['sent' => true]);
        return redirect(route('epistola'))->with('message', __('general.successful_modification'));
    }

    public function delete(EpistolaNews $epistola)
    {
        $this->authorize('edit', EpistolaNews::class);
        $epistola->delete();
        return redirect(route('epistola'))->with('message', __('general.successfully_deleted'));
    }

    public function updateOrCreate(Request $request)
    {
        $this->authorize('create', EpistolaNews::class);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'description' => 'required|string',
            'date' => 'nullable|date|required_with:time,end_date',
            'time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date',
            'details_name_1' => 'nullable|string|required_with:details_url_1',
            'details_url_1' => 'nullable|url|required_with:details_name_1',
            'details_name_2' => 'nullable|string|required_with:details_url_2',
            'details_url_2' => 'nullable|url|required_with:details_name_2',
            'deadline_name' => 'nullable|string|required_with:deadline_date',
            'deadline_date' => 'nullable|date|required_with:deadline_name',
            'approved' => 'nullable|required_with:picture_upload',
            'date_for_sorting' => 'nullable|date',
            'picture_upload' => 'nullable|image',
            'picture_path' => ['nullable', 'url', function ($attribute, $value, $fail) use ($request) {
                if ($request->picture_upload != null && $request->picture_path != null)
                    $fail(__('validation.upload_with_link'));
            }]
        ]);
        $validator->validate();

        //store and resize uploaded picture
        if ($request->picture_upload != null) {
            $path = $request->file('picture_upload')->store('', 'epistola');
            Image::make(public_path('/img/epistola/' . $path))->resize(self::IMAGE_TARGET_SIZE, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $picture_path = config('app.url') . '/img/epistola/' . $path;
        }
        $values = $request->except(['picture_path', 'id']);
        $values['picture_path'] = $picture_path ?? $request->picture_path;

        $epistola = EpistolaNews::find($request->id);
        if ($epistola) {
            $updated = true;
            $epistola->update($values);
        } else {
            $updated = false;
            $values['uploader_id'] = Auth::user()->id;
            $epistola = EpistolaNews::create($values);
        }
        return redirect(route('epistola'))->with('message', $updated ? __('general.successful_modification') : __('general.successfully_added'));
    }

    public static function getActiveNews()
    {
        return EpistolaNews::where('sent', false)->get()->sortBy(function ($result) {
            if ($result->valid_until == null)
                return PHP_INT_MAX;
            return $result->valid_until;
        });
    }

    public function preview()
    {
        $this->authorize('view', EpistolaNews::class);

        return (new EpistolaCollegii(self::getActiveNews()));
    }

    public function send()
    {
        $this->authorize('send', EpistolaNews::class);

        $unsent = EpistolaNews::where('sent', false)->get()->sortBy(function ($result) {
            if ($result->valid_until == null)
                return PHP_INT_MAX;
            return $result->valid_until;
        });

        Mail::to(env('MAIL_KOMMBIZ'))->send(new EpistolaCollegii($unsent));

        EpistolaNews::where('sent', false)->update(['sent' => true]);

        return back()->with('message', 'Elküldve a Bizottság e-mail címére.');
    }
}
