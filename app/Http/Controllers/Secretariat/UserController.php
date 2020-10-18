<?php

namespace App\Http\Controllers\Secretariat;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function updateEmail(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:225|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user->update([
            'email' => $request->email,
        ]);

        return redirect()->back()->with('message', __('general.successful_modification'));
    }

    public function updatePhone(Request $request)
    {
        $user = Auth::user();

        if ($user->hasPersonalInformation()) {
            $validator = Validator::make($request->all(), [
                'phone_number' => 'required|string|min:16|max:18',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user->personalInformation->update([
                'phone_number' => $request->phone_number,
            ]);
        }

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
        } else {
            return response()->json(null, 400);
        }

        return response()->json(null, 204);
    }

    public function list()
    {
        $this->authorize('viewAny', User::class);
        $users = User::collegists()->sortBy('name');

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

        // TODO
        $this->authorize('view', $user);

        $user->setStatusFor(\App\Models\Semester::find($semester), $status);

        return redirect()->back()->with('message', __('general.successful_modification'));
    }

    public function deleteUserWorkshop($user, $workshop)
    {
        // TODO
        $this->authorize('viewAny', User::class);

        $user = User::findOrFail($user);

        $user->workshops()->detach($workshop);
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

        return redirect()->back()->with('message', __('general.successfully_added'));
    }
}
