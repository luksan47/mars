<?php

namespace App\Http\Controllers\Secretariat;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class RegistrationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:registration.handle');
    }

    public function index()
    {
        $users = [];
        $user = Auth::user();
        if ($user->hasRole(Role::NETWORK_ADMIN)) {
            $users = User::withoutGlobalScope('verified')->where('verified', false)->with('educationalInformation')->get();
        } elseif ($user->hasAnyRole([Role::SECRETARY, Role::DIRECTOR])) {
            $users = User::withoutGlobalScope('verified')->where('verified', false)
            ->whereHas('roles', function (Builder $query) {
                $query->where('name', Role::COLLEGIST);
            })
            ->with('educationalInformation')
            ->get();
        } elseif ($user->hasRole(Role::STAFF)) {
            $users = User::withoutGlobalScope('verified')->where('verified', false)
            ->whereHas('roles', function (Builder $query) {
                $query->where('name', Role::TENANT);
            })
            ->with('educationalInformation')
            ->get();
        }

        return view('secretariat.registrations.list', ['users' => $users]);
    }

    public function accept(Request $request)
    {
        $user = User::withoutGlobalScope('verified')->findOrFail($request->id);
        if ($user->verified) {
            return redirect()->route('secretariat.registrations');
        }

        $user->update(['verified' => true]);
        if ($user->hasRole(Role::TENANT)) {
            $date = (Carbon::now()->addMonths(6)->gt($user->personalInformation->tenant_until.' 00:00:00')) ? ($user->personalInformation->tenant_until.' 00:00:00') : Carbon::now()->addMonths(6);
            $user->internetAccess()->update(['has_internet_until' => $date]);
        }

        Cache::decrement('user');

        // Send notification mail.
        Mail::to($user)->queue(new \App\Mail\ApprovedRegistration($user->name));
        if ($request->next) {
            $next_user = User::withoutGlobalScope('verified')->where('verified', false)->first();
            if ($next_user != null) {
                return redirect()->route('secretariat.registrations.show', ['id' => $next_user->id]);
            }
        }

        return redirect()->route('secretariat.registrations')->with('message', __('general.successful_modification'));
    }

    public function reject(Request $request)
    {
        $user = User::withoutGlobalScope('verified')->findOrFail($request->id);
        if ($user->verified) {
            return redirect()->route('secretariat.registrations');
        }

        $user->delete();

        Cache::decrement('user');

        if ($request->next) {
            $next_user = User::withoutGlobalScope('verified')->where('verified', false)->first();
            if ($next_user != null) {
                return redirect()->route('secretariat.registrations.show', ['id' => $next_user->id]);
            }
        }

        return redirect()->route('secretariat.registrations')->with('message', __('general.successful_modification'));
    }

    public function show(Request $request)
    {
        $user = User::withoutGlobalScope('verified')->findOrFail($request->id);
        if ($user->verified) {
            return redirect()->route('secretariat.registrations');
        }

        $unverified_users_left = count(User::withoutGlobalScope('verified')->where('verified', false)->get());

        return view('secretariat.registrations.show', ['user' => $user, 'users_left' => $unverified_users_left]);
    }
}
