<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\EventTrigger;
use App\Models\Semester;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecretariatController extends Controller
{
    public function list()
    {
        return Semester::current()->activeUsers;
    }

    public function rooms()
    {
        return view('secretariat.rooms')
            ->with('timetable', Timetable::all());
    }

    public function addCourseView()
    {
        return view('secretariat.rooms.add')
            ->with('users', User::all());
    }

    public function scheduleCourseView()
    {
        return view('secretariat.rooms.schedule')
            ->with('users', User::all());
    }

    public static function isStatementAvailable()
    {
        $statement_event = EventTrigger::find(EventTrigger::INTERNET_ACTIVATION_SIGNAL)->date;
        $deadline_event = EventTrigger::find(EventTrigger::DEACTIVATE_STATUS_SIGNAL)->date;
        // If the deadline is closer than sending out the request, that means
        // the request has been already sent out.
        return $deadline_event < $statement_event;
    }

    public static function sendStatementMail()
    {
        //TODO: after #219
    }

    /**
     * Those who did not make their statements by now will be inactive
     * next semester.
     */
    public static function finalizeStatements()
    {
        $users = User::all();
        $next_semester = Semester::next();
        foreach ($users as $user) {
            if (! $user->isInSemester($next_semester)) {
                $user->setStatusFor($next_semester, Semester::INACTIVE, 'Failed to make a statement');
            }
        }
    }

    public function addCourse(Request $request)
    {
        // TODO finish validator
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'workshop_id' => 'required',
            'name' => 'required',
            'name_english' => 'required',
            'type' => 'required',
            'credits' => 'required',
            'hours' => 'required',
            'semester_id' => 'required',
            'teacher_id' => 'required',
        ]);
        $validator->validate();

        Course::create([
            'code' => $request->code,
            'workshop_id' => $request->workshop,
            'name' => $request->name,
            'name_english' => $request->name_english,
            'type' => $request->type,
            'credits' => $request->credits,
            'hours' => $request->hours,
            'semester_id' => $request->semester,
            'teacher_id' => $request->teacher,
        ]);

        return self::addCourseView();
    }

    public function scheduleCourse(Request $request)
    {
        // TODO finish validator

        // Timetable::create([
        //     'course_id' => $request->course,
        //     'classroom_id' => $request->classroom,
        // ]);

        return self::addCourseView();
    }
}
