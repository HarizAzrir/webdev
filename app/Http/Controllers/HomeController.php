<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Club;
use App\Models\Event;
use App\Models\Bookmark;
Use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        if (Auth::id()){
            $usertype = Auth()->user()->usertype;

            if($usertype == "user"){
                $clubs = Club::all();
                $events = Event::all();
            return view("dashboard", ['clubs' => $clubs], ['event' => $events]);
            }

            

            else if($usertype == "admin"){
                $eventCount = Event::count();
                $clubCount = Club::count();
                $userCount = User::count();
                $bookmarkCount = Bookmark::count();
                $clubs = Club::all();    
                $events = Event::all();
                 // Retrieve upcoming events (assuming 'dateStart' is a column in your events table)
                $upcomingEvents = Event::where('dateStart', '>', now())->get();

                return view('adminhomepage', compact('eventCount','userCount', 'bookmarkCount', 'clubCount', 'clubs', 'events', 'upcomingEvents'));   //admin page
            }

            else if($usertype == "president"){
                $clubs = Club::all();
                $events = Event::all();
            return view("dashboard", ['clubs' => $clubs], ['event' => $events]);
            }

            else {
                return redirect()->back();
            }
        }
    }


    public function userhomepage(){
        $clubs = Club::all();
        $events = Event::all();
        return view("dashboard", ['clubs' => $clubs], ['event' => $events]);
    }

    public function adminhomepage(){

        return view("adminhomepage");
    }

    public function post(){
        return view("post");
    }
}
