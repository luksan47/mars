<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
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
        $collegist_role = Role::firstWhere('name', Role::COLLEGIST);
        $user = User::findOrFail($request->user_id);

        $this->authorize('updatePermission', [$user, $collegist_role->id]);

        if ($request->has('resident') && $user->hasRoleBase(Role::COLLEGIST)) {
            $user->roles()->detach($collegist_role);
            if ($request->resident == true) {
                $object_id = Role::getObjectIdByName(Role::COLLEGIST, 'resident');
            } else {
                $object_id = Role::getObjectIdByName(Role::COLLEGIST, 'extern');
            }
            $user->roles()->attach($collegist_role, ['object_id' => $object_id]);
        } else {
            return response()->json(null, 400);
        }

        return response()->json(null, 204);
    }

    public function list()
    {
        $this->authorize('viewAny', User::class);
        $users = User::all()->sortBy('name');

        return view('admin.user.list')->with('users', $users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('view', $user);

        return view('admin.user.show')->with('user', $user);
    }

    public function semesters($id)
    {
        $user = User::findOrFail($id);

        // TODO
        $this->authorize('view', $user);

        $semesters = $user->allSemesters->sortByDesc(function ($semester) {
            return $semester->getStartDate();
        });

        return view('admin.user.semesters')->with('user', $user)->with('semesters', $semesters);
    }

    public function updateSemesterStatus($id, $semester, $status)
    {
        $user = User::findOrFail($id);

        // TODO
        $this->authorize('view', $user);

        $user->setStatusFor(\App\Models\Semester::find($semester), $status);

        return redirect()->back()->with('message', __('general.successful_modification'));
    }
}
