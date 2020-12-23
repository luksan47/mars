<?php

namespace App\Http\Controllers\Dormitory;

use App\Http\Controllers\Controller;
use App\Models\Fault;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FaultController extends Controller
{
    public function index()
    {
        return view('dormitory.faults.app');
    }

    // TODO: policies
    // TODO: validation
    public function addFault(Request $new)
    {
        $this->authorize('create', Fault::class);

        $fault = Fault::create([
            'reporter_id' => Auth::User()->id,
            'location' => $new['location'],
            'description' => $new['description'],
            'status' => Fault::UNSEEN,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->notifyStaff($fault);

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    public function getFaults(Request $request)
    {
        return json_encode(Fault::all());
    }

    // TODO: policies
    // TODO: validation
    public function updateStatus(Request $request)
    {
        $this->authorize('update', Fault::class);

        $status = $request['status'];
        $auth = Auth::user()->hasRole(Role::STAFF) || Fault::getState($status) === Fault::UNSEEN;
        $fault = Fault::findOrFail($request['id']);
        $fault->update([
            'status' => Fault::getState($status),
        ]);
        if ($status === Fault::UNSEEN) {
            $this->notifyStaff($fault, /* reopen */ true);
        }

        return var_export($auth);
    }

    public function notifyStaff(Fault $fault, bool $reopen = false)
    {
        $staffs = Role::getUsers(Role::STAFF);
        foreach ($staffs as $staff) {
            Mail::to($staff)->queue(new \App\Mail\NewFault($staff->name, $fault, $reopen));
        }
    }
}
