<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleCalendarController extends Controller
{
    public function index(Request $request, $email = null)
    {
        return view('api/index', ['email' => $email]);
    }
}
