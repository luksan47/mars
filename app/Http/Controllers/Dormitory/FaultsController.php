<?php

namespace App\Http\Controllers\Dormitory;

use App\Models\Faults;
use App\Models\Role;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FaultsController extends Controller
{
    public function index()
    {
        return view('faults.app');
    }

    public function addFault(Request $new)
    {
        DB::table('faults')->insert(
            [
                'reporter_id' => Auth::User()->id,
                'location' => $new['location'],
                'description' => $new['description'],
                'status' => Faults::UNSEEN,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    public function getFaults(Request $request)
    {
        return json_encode(DB::table('faults')->get());
    }

    public function updateStatus(Request $new)
    {
        $auth = Auth::user()->hasRole(Role::STAFF) || Faults::getState($new['status']) === Faults::UNSEEN;

        if ($auth) {
            DB::table('faults')->where('id', $new['id'])->update(['status' => Faults::getState($new['status'])]);
        }

        return var_export($auth);
    }
}
