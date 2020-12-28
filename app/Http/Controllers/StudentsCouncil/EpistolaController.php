<?php

namespace App\Http\Controllers\StudentsCouncil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EpistolaCollegii;
use Image;

use App\Models\EpistolaNews;

class EpistolaController extends Controller
{
    public function index(Request $request)
    {
        return view('student-council.communication-committee.epistola', ['news' => EpistolaNews::where('sent', false)->get()->sortBy('valid_until')]);
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
            'further_details_url' => 'nullable|url',
            'website_url' => 'nullable|url',
            'facebook_event_url' => 'nullable|url|starts_with:https://www.facebook.com/events/',
            'registration_url' => 'nullable|url|required_with:registration_deadline',
            'registration_deadline' => 'nullable|date',
            'fill_url' => 'nullable|url|required_with:registration_deadline',
            'filling_deadline' => 'nullable|date',
            'approved' => 'nullable|required_with:picture_upload|accepted',
            'picture_upload' => 'nullable|image',
            'picture_path' => ['nullable', 'url', function ($attribute, $value, $fail) use ($request) {
                if ($request->picture_upload != null && $request->picture_path != null)
                    $fail('Fájl feltöltése és belinkelése együtt nem lehetséges.');
            }]
        ]);
        $validator->validate();

        //store and resize uploaded picture
        if ($request->picture_upload != null) {
            $path = $request->file('picture_upload')->store('', 'epistola');
            Image::make(public_path('/img/epistola/' . $path))->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $picture_path = config('app.url') . '/img/epistola/' . $path;
        }
        $values = $request->except(['picture_path', 'id']);
        $values['picture_path'] = $picture_path ?? $request->picture_path;
        $values['uploader_id'] = Auth::user()->id;
        $epistola = EpistolaNews::find($request->id);
        if ($epistola) {
            $updated = true;
            $epistola->update($values);
        } else {
            $updated = false;
            $epistola = EpistolaNews::create($values);
        }
        return redirect(route('epistola'))->with('message', $updated ? __('general.successful_modification') : __('general.successfully_added'));
    }

    public function preview()
    {
        $this->authorize('send', EpistolaNews::class);

        return (new EpistolaCollegii(EpistolaNews::where('sent', false)->get()));
    }

    public function send()
    {
        $this->authorize('send', EpistolaNews::class);

        $mail = new EpistolaCollegii(EpistolaNews::where('sent', false)->get());
        Mail::to(env('MAIL_KOMMBIZ'))->send($mail);

        EpistolaNews::where('sent', false)->update(['sent' => true]);

        return back()->with('message', 'Elküldve a Bizottság e-mail címére.');
    }
}
