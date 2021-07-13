<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\Applications;
use App\Models\User;

class ListController extends Controller
{
    public function index_inprogress_applications()
    {
        return view('list.applications')->with([
            'title' => 'Folyamatbanlévő jelentkezések',
            'applications' => Applications::where_prepare('status', Applications::STATUS_UNFINAL),
        ]);
    }

    public function index_final_applications()
    {
        return view('list.applications')->with([
            'title' => 'Végelegesített jelentkezések',
            'applications' => Applications::where_prepare('status', Applications::STATUS_FINAL),
        ]);
    }

    public function index_users()
    {
        return view('list.users')->with([
            'users' => User::with('permissions')->get(),
        ]);
    }
}
