<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use DB;

class DemoController extends Controller
{
    public function index()
    {
        return view('demo.index');
    }
}
