<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        // Retrieve all events from the "events" table
        //$events = Event::all();
        $event = Event::where('id', 1)->first();
        //$event = Event::where('id', 1)->where('eventName', 'Project Stellar')->first();

        // Pass the events data to the view
        return view('event.index', ['event' => $event]);

        
    }

    

}