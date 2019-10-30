<?php

namespace App\Http\Controllers;
use App\Utils\TabulatorPaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Role;
use DB;

class FaultsController extends Controller
{
    public function index()
    {
        return view('faults.app');
    }

    public function addRecord(Request $new)
    {
        DB::table('faults')->insert(
            array(
                'description' => $new['description'],
                'status' => 'unseen',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );
        return redirect()->route('faults');
    }

    public function getFaultsTable(Request $request)
    {
        return json_encode(DB::table('faults')->get());
    }

    public function updateStatus(Request $new)
    {
        if (Auth::User()->hasRole(Role::INTERNET_ADMIN)) {
            DB::table('faults')->where('id', $new['id'])->update(['status' => $new['status']]);
        }
        return var_export(Auth::User()->hasRole(Role::INTERNET_ADMIN));
    }
}