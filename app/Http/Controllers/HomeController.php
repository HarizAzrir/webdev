<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
Use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        if (Auth::id()){
            $usertype = Auth()->user()->usertype;

            if($usertype == "user"){
                return view('dashboard');
            }

            else if($usertype == "admin"){
                return view('adminhomepage');   //admin page
            }

            else {
                return redirect()->back();
            }
        }
    }


    public function userhomepage(){

        return view("dashboard");
    }

    public function adminhomepage(){

        return view("adminhomepage");
    }

    public function post(){
        return view("post");
    }
}
