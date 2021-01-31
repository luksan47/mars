<?php

namespace App\Http\Controllers\Secretariat;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Semester;
use App\Models\User;
use App\Models\WorkshopBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('auth.user', ['user' => $user]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            //only one should exist at a time
            'email' => 'email|max:225|unique:users',
            'phone_number' => 'string|min:16|max:18',
            'mothers_name' => 'string|max:225',
            'place_of_birth' => 'string|max:225',
            'date_of_birth' => 'string|max:225',
            'country' => 'string|max:255',
            'county' => 'string|max:255',
            'zip_code' => 'string|max:31',
            'city' => 'string|max:255',
            'street_and_number' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->has('email')) {
            $user->update(['email' => $request->email]);
        }
        if ($user->hasPersonalInformation() && $request->hasAny(
            ['place_of_birth', 'date_of_birth', 'mothers_name', 'phone_number', 'country', 'county', 'zip_code', 'city', 'street_and_number']
        )) {
            $user->personalInformation->update($request->all());
        }
        //TODO: educational information

        return redirect()->back()->with('message', __('general.successful_modification'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->except('_token'), [
            'old_password' => 'required|string|password',
            'new_password' => 'required|string|min:8|confirmed|different:old_password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('message', __('general.successful_modification'));
    }

    public function setCollegistType(Request $request)
    {
        $this->authorize('viewAny', User::class);

        if ($request->has('resident')) {
            $user = User::findOrFail($request->user_id);

            if ($request->resident === 'true') {
                $user->setResident();
            } else {
                $user->setExtern();
            }

            WorkshopBalance::generateBalances(Semester::current()->id);
        } else {
            return response()->json(null, 400);
        }

        return response()->json(null, 204);
    }

    public function list()
    {
        $this->authorize('viewAny', User::class);
        $users = User::role(Role::COLLEGIST)
            ->with(['roles', 'workshops', 'educationalInformation', 'allSemesters'])->orderBy('name')->get();

        return view('secretariat.user.list')->with('users', $users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('view', $user);

        return view('secretariat.user.show')->with('user', $user);
    }

    public function semesters($id)
    {
        $user = User::findOrFail($id);

        // TODO
        $this->authorize('view', $user);

        $semesters = $user->allSemesters->sortByDesc(function ($semester) {
            return $semester->getStartDate();
        });

        return view('secretariat.user.semesters')->with('user', $user)->with('semesters', $semesters);
    }

    public function updateSemesterStatus($id, $semester, $status)
    {
        $user = User::findOrFail($id);
        $semester = Semester::find($semester);

        // TODO
        $this->authorize('view', $user);

        $user->setStatusFor($semester, $status);

        WorkshopBalance::generateBalances($semester->id);

        return redirect()->back()->with('message', __('general.successful_modification'));
    }

    public function deleteUserWorkshop($user, $workshop)
    {
        // TODO
        $this->authorize('viewAny', User::class);

        $user = User::findOrFail($user);

        $user->workshops()->detach($workshop);

        WorkshopBalance::generateBalances(Semester::current()->id);
    }

    public function addUserWorkshop(Request $request, $user)
    {
        // TODO
        $this->authorize('viewAny', User::class);

        $user = User::findOrFail($user);

        $validator = Validator::make($request->except('_token'), [
            'workshop_id' => 'required|exists:workshops,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user->workshops()->attach($request->workshop_id);

        WorkshopBalance::generateBalances(Semester::current()->id);

        return redirect()->back()->with('message', __('general.successfully_added'));
    }
}
