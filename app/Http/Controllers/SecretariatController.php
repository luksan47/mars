<?php

namespace App\Http\Controllers;

use App\Semester;

class SecretariatController extends Controller
{
    public function list()
    {
        return Semester::current()->activeUsers;
    }
}
