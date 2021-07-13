<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\Applications;
use App\Models\Uploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\Finalise;

class ApplicantController extends Controller
{


    public function showProfile()
    {
        $user_id = Auth::user()->id;
        $application = Applications::find_prepare($user_id);
        $uploads = Uploads::where('applications_id',$application['id'])->get();

        return view('applicant.profile')->with(['application' => $application, 'uploads' => $uploads]);
    }

    public function editApplication()
    {
        $user_id = Auth::user()->id;
        $application = Applications::find_prepare($user_id);

        return view('applicant.edit')->with(['application' => $application]);
    }

    private $validation_rules = [
        'terms_of_service' => 'accepted',

        'inf_name' => 'nullable|max:255',
        'inf_main_email' => 'nullable|email|max:255',
        'inf_birthdate' => 'nullable|date_format:Y-m-d',
        'inf_mothers_name' => 'nullable|max:255',
        'inf_telephone' => 'nullable|max:255',

        'address_country' => 'nullable|max:255',
        'address_city' => 'nullable|max:255',
        'address_zip' => 'nullable|max:255',
        'address_street' => 'nullable|max:255',

        'school_name' => 'nullable|max:255',
        'school_country' => 'nullable|max:255',
        'school_city' => 'nullable|max:255',
        'school_zip' => 'nullable|max:255',
        'school_street' => 'nullable|max:255',

        'studies_matura_exam_year' => 'nullable|max:255',
        'studies_matura_exam_avrage' => 'nullable|max:255',
        'studies_university_studies_avrages' => 'nullable|max:255',
        'studies_university_courses' => 'nullable|max:255',

        'achivements_language_exams' => 'nullable|max:255',
        'achivements_competitions' => 'nullable|max:255',
        'achivements_publications' => 'nullable|max:255',
        'achivements_studies_abroad' => 'nullable|max:255',

        'question_social' => 'nullable|max:2024',
        'question_why_us' => 'nullable|max:2024',
        'question_plans' => 'nullable|max:2024',

        'misc_status' => 'nullable|max:255',
        'misc_workshops' => 'nullable|max:255',
        'misc_neptun' => 'nullable|max:6',
        'misc_caesar_mail' => 'nullable|email|ends_with:elte.hu|max:255',

    ];
    private $validation_messages = [
        'inf_name.required' => 'nah man...',
    ];
    public function updateApplication(Request $request)
    {
        $this->validate($request, $this->validation_rules/*, $this->validation_messages*/);

        $user_id = Auth::user()->id;
        Applications::where('user_id',$user_id)->update([
            'inf_name' => $request->input('inf_name'),
            'inf_birthdate' => $request->input('inf_birthdate'),
            'inf_mothers_name' => $request->input('inf_mothers_name'),
            'inf_main_email' => $request->input('inf_main_email'),
            'inf_telephone' => $request->input('inf_telephone'),

            'address_country' => $request->input('address_country'),
            'address_city' => $request->input('address_city'),
            'address_zip' => $request->input('address_zip'),
            'address_street' => $request->input('address_street'),

            'school_name' => $request->input('school_name'),
            'school_country' => $request->input('school_country'),
            'school_city' => $request->input('school_city'),
            'school_zip' => $request->input('school_zip'),
            'school_street' => $request->input('school_street'),

            'studies_matura_exam_year' => $request->input('studies_matura_exam_year'),
            'studies_matura_exam_avrage' => $request->input('studies_matura_exam_avrage'),
            'studies_university_studies_avrages' => Applications::compress_data($request->input('studies_university_studies_avrages')),
            'studies_university_courses' => Applications::compress_data($request->input('studies_university_courses')),

            'achivements_language_exams' => Applications::compress_data($request->input('achivements_language_exams')),
            'achivements_competitions' => Applications::compress_data($request->input('achivements_competitions')),
            'achivements_publications' => Applications::compress_data($request->input('achivements_publications')),
            'achivements_studies_abroad' => Applications::compress_data($request->input('achivements_studies_abroad')),

            'question_social' => $request->input('question_social'),
            'question_why_us' => $request->input('question_why_us'),
            'question_plans' => $request->input('question_plans'),

            'misc_status' => $request->input('misc_status'),
            'misc_workshops' => Applications::compress_data($request->input('misc_workshops')),
            'misc_neptun' => $request->input('misc_neptun'),
            'misc_caesar_mail' => $request->input('misc_caesar_mail'),
        ]);

        return redirect( route('applicant.profile') )->with('succes', 'Adatok mentésre kerültek!');
    }

    public function final(){
        $user_id = Auth::user()->id;
        $application = Applications::find_prepare($user_id);
        $uploads = Uploads::where('applications_id',$application['id'])->get();

        return view('applicant.final')->with(['application' => $application, 'uploads' => $uploads]);
    }

    public $required_filds = [
        'inf_name',
        'inf_birthdate',
        'inf_mothers_name',
        'inf_main_email',
        'inf_telephone',

        'address_country',
        'address_city',
        'address_zip',
        'address_street',

        'school_name',
        'school_country',
        'school_city',
        'school_zip',
        'school_street',

        'studies_matura_exam_year',
        'studies_matura_exam_avrage',
        'studies_university_courses',

        'question_why_us',
        'question_plans',

        'misc_status',
        'misc_workshops',
        'misc_neptun',
        'misc_caesar_mail',

        'profile_picture_path',
    ];
    public function finalise(Request $request){

	if( mktime(23,59,59,8,15,2020) < time() ){
		return redirect('home')->with('error','Sajnáljuk, de a jelentkezési határidő lejárt!');
	}

       // throw 'alma';
        $user_id = Auth::user()->id;
       // $data = Applications::find_prepare($user_id);
        $data = Applications::where('user_id',$user_id)->get()[0];

        $valid = true;
        foreach($this->required_filds as $requirement){
            if(!isset($data[$requirement])){
                $valid = false;
                break;
            }
        }

        if($valid){
            Applications::where('user_id',$user_id)->update([
                'status' => Applications::STATUS_FINAL,
            ]);

            $user = auth()->user();
            $user['name'] = $data['inf_name'];
            Mail::to( $user )->queue( new Finalise( $user ) );

            return redirect('home')->with('success','Jelentkezés véglegesítésre került! :)');
        } else{
            return redirect()->back()->with('error','Nincs még minden szükséges mező kitöltve!');
        }
    }

    public function profilePictureUpdate(Request $request){ //TODO: resize picture
        $this->validate($request,[
            'profile_picture_file' => 'required|mimes:jpg,jpeg,png,gif,svg',
        ]);

        $path = $request->file('profile_picture_file')->store('avatars');

        $user_id = auth()->user()->id;
        $preveous_path = Applications::where('user_id', $user_id)->take(1)->get(['id'])[0]['profile_picture_path'];

        if( $preveous_path !== null ){
            Storage::delete($preveous_path);
        }

        Applications::where('user_id',$user_id)->update([
            'profile_picture_path' => $path,
        ]);

        return redirect()->back()->with('success','Kép feltöltésre került');
    }

}
