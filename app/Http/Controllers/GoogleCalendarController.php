<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleCalendarController extends Controller
{
    public function index()
    {
        return view('api/index');
    }
}
