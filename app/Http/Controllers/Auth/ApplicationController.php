<?php

namespace App\Http\Controllers\Auth;

use App;
use App\Http\Controllers\Controller;
use App\Models\ApplicationForm;
use App\Models\EducationalInformation;
use App\Models\Faculty;
use App\Models\PersonalInformation;
use App\Models\Workshop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class ApplicationController extends Controller
{

    public function showApplicationForm(Request $request)
    {
        App::setLocale('hu');
        $data = [
            'workshops' => Workshop::all(),
            'faculties' => Faculty::all(),
            'deadline' => self::getApplicationDeadline(),
            'deadline_extended' => self::isDeadlineExtended(),
            'countries' => require base_path('countries.php'),
            'user' => $request->user()
        ];
        switch ($request->page) {
            case 'educational':
                return view('auth.application.educational', $data);
            case 'questions':
                return view('auth.application.questions', $data);
            case 'files':
                return view('auth.application.files', $data);
            case 'finalize':
                return view('auth.application.finalize', $data);
            default:
                return view('auth.application.personal', $data);
        }

    }

    public function storeApplicationForm(Request $request)
    {
        $user = $request->user();
        switch ($request->page) {
            case 'personal':
                $request->validate(RegisterController::PERSONAL_INFORMATION_RULES + ['name' => 'required|string|max:255']);
                $user->update(['name' => $request->name]);
                $user->personalInformation()->update($request->only([
                    'place_of_birth',
                    'date_of_birth',
                    'mothers_name',
                    'phone_number',
                    'country',
                    'county',
                    'zip_code',
                    'city',
                    'street_and_number'])
                );
                break;
            case 'educational':
                $request->validate([
                    'year_of_graduation' => 'required|integer|between:1895,'.date('Y'),
                    'high_school' => 'required|string|max:255',
                    'neptun' => 'required|string|size:6',
                    'faculty' => 'required|array',
                    'faculty.*' => 'exists:faculties,id',
                    'educational_email' => 'required|string|email|max:255',
                    'high_school_address' => 'required|string',
                    'programs' => 'required|array',
                    'programs.*' => 'nullable|string'
                ]);
                EducationalInformation::updateOrCreate(['user_id' => $user->id],[
                    'year_of_graduation' => $request->year_of_graduation,
                    'high_school' => $request->high_school,
                    'neptun' => $request->neptun,
                    'year_of_acceptance' => date('Y'),
                    'email' => $request->educational_email,
                    'program' => $request->programs,
                ]);
                ApplicationForm::updateOrCreate(['user_id' => $user->id],[
                    'high_school_address' => $request->high_school_address,
                    'graduation_average' => $request->graduation_average,
                    'semester_average' => $request->semester_average,
                    'language_exam' => $request->language_exam,
                    'competition' => $request->competition,
                    'publication' => $request->publication,
                    'foreign_studies' => $request->foreign_studies
                ]);
                $user->faculties()->sync($request->faculty);
                break;
            case 'questions':
                $request->validate([
                    'status' => 'nullable|in:extern,resident',
                    'workshop' => 'array',
                    'workshop.*' => 'exists:workshops,id',
                ]);
                if($request->status == 'resident') {
                    $user->setResident();
                }
                if($request->status == 'extern') {
                    $user->setExtern();
                }
                $user->workshops()->sync($request->workshop);
                ApplicationForm::updateOrCreate(['user_id' => $user->id],[
                    'question_1' => $request->question_1,
                    'question_2' => $request->question_2,
                    'question_3' => $request->question_3,
                    'question_4' => $request->question_4,
                ]);
                break;
            case 'files':
                $request->validate([
                    'file' => 'required|file|mimes:pdf,jpg,jpeg,png,gif,svg|max:2048',
                    'name' => 'required|string|max:255',
                ]);
                $path = $request->file('file')->store('uploads');
                $user->application()->firstOrCreate()->files()->create(['path' => $path, 'name' => $request->name]);
                break;
            case 'files.delete':
                $request->validate([
                    'id' => 'required|exists:files',
                ]);

                $file = $user->application->files()->find($request->id);
                if($file){
                    Storage::delete($file->path);
                    $file->delete();
                }
                break;
            case 'files.profile':
                $request->validate([
                    'picture' => 'required|mimes:jpg,jpeg,png,gif,svg',
                ]);
                $path = $request->file('picture')->store('avatars');
                $old_profile = $user->profilePicture;
                if($old_profile){
                    Storage::delete($old_profile->path);
                    $old_profile->update(['path' => $path]);
                } else {
                    $user->profilePicture()->create(['path' => $path, 'name' => 'profile_picture']);
                }
                break;
            case 'finalize':
                break;
            default:
                abort(404);
                break;
        }
        return redirect()->back()->with('message', __('general.successful_modification'));
    }


    const DELIMETER = '|';

    /**
     * Creates strings from arrays with DELIMETER.
     * @author hamaren2517
     */
    public static function compressData($array)
    {
        if($array === null) return null;
        return join(
            self::DELIMETER,
            array_map(
                function($item) { return str_replace(self::DELIMETER, ' ', $item); },
                array_filter($array, function($item) { return $item !== null; })
            )
        );
    }

    /**
     * Creates an array from a string splitted with DELIMETERs.
     */
    public static function decompressData($string)
    {
        if($string === null) return null;
        return explode(self::DELIMETER, $string);
    }

    public static function getApplicationDeadline() : Carbon
    {
        return Carbon::parse(config('app.application_deadline'));
    }

    public static function isDeadlineExtended() : bool
    {
        return config('app.application_extended');
    }
};
