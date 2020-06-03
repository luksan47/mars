<?php

namespace App\Http\Controllers;

use App\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecretariatController extends Controller
{
    public function list()
    {
        return Semester::current()->activeUsers;
    }
}
