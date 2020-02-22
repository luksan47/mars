<?php

namespace App\Http\Controllers;

use App\FaultsTable;
use App\Role;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaultsController extends Controller
{
    public function index()
    {
        return view('faults.app');
    }

    public function addRecord(Request $new)
    {
        DB::table('faults')->insert(
            [
                'user_id' => Auth::User()->id,
                'location' => $new['location'],
                'description' => $new['description'],
                'status' => FaultsTable::UNSEEN,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );

        return redirect()->route('faults');
    }

    public function getFaultsTable(Request $request)
    {
        return json_encode(DB::table('faults')->get());
    }

    public function updateStatus(Request $new)
    {
        $auth = Auth::User()->hasRole(Role::INTERNET_ADMIN) || FaultsTable::getState($new['status']) === FaultsTable::UNSEEN;
        
        if ($auth) {
            DB::table('faults')->where('id', $new['id'])->update(['status' => FaultsTable::getState($new['status'])]);
        }

        return var_export($auth);
    }
}