<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MinuteCounterController extends Controller
{
    public function index()
    {
        return view('layouts.main');
    }

    public function detail($id)
    {
        return view('layouts.main');
    }
}
