<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Club;
Use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        if (Auth::id()){
            $usertype = Auth()->user()->usertype;

            if($usertype == "user"){
                $clubs = Club::all();
            return view("dashboard", ['clubs' => $clubs]);
            }

            else if($usertype == "admin"){
                return view('adminhomepage');   //admin page
            }

            else if($usertype == "president"){
                $clubs = Club::all();
            return view("dashboard", ['clubs' => $clubs]);
            }

            else {
                return redirect()->back();
            }
        }
    }


    public function userhomepage(){
        $clubs = Club::all();
        return view("dashboard", ['clubs' => $clubs]);
    }

    public function adminhomepage(){

        return view("adminhomepage");
    }

    public function post(){
        return view("post");
    }
}
