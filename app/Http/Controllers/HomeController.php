<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Club;
use App\Models\Event;
use App\Models\Bookmark;
Use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class HomeController extends Controller
{
    public function index()
{
    if (Auth::id()) {
        $usertype = Auth()->user()->usertype;

        if ($usertype == "user") {
            $clubs = Club::all();
            $events = Event::all();
            // Retrieve the closest upcoming event
            $closestEvent = Event::where('dateStart', '>', now())
                ->orderBy('dateStart')
                ->first();

            // Check if there is a closest event
            if ($closestEvent) {
                // Access the details of the closest event
                $eventDate = $closestEvent->dateStart;
                $eventTime = $closestEvent->timeStart;
                $closeeventname = $closestEvent->eventName;
                // Other event details...
                return view("dashboard", compact('clubs','closeeventname', 'closestEvent','eventDate', 'eventTime', 'events'));
            } else {
                // No upcoming events
                return view("dashboard", compact('clubs', 'events'));
            }
        } elseif ($usertype == "admin") {
            $eventCount = Event::count();
            $clubCount = Club::count();
            $userCount = User::count();
            $bookmarkCount = Bookmark::count();
            $clubs = Club::all();
            $events = Event::all();
            // Retrieve upcoming events (assuming 'dateStart' is a column in your events table)
            $upcomingEvents = Event::where('dateStart', '>', now())->get();

            // Get monthly upcoming events
            $monthlyEvents = $this->getMonthlyEvents();
            return view('adminhomepage', compact('eventCount', 'userCount', 'bookmarkCount', 'clubCount', 'clubs', 'events', 'upcomingEvents','monthlyEvents'));   //admin page
        } 
        
        elseif ($usertype == "president") {
            $clubs = Club::all();
            $events = Event::all();
            // Retrieve the closest upcoming event
            $closestEvent = Event::where('dateStart', '>', now())
                ->orderBy('dateStart')
                ->first();

            // Check if there is a closest event
            if ($closestEvent) {
                // Access the details of the closest event
                $eventDate = $closestEvent->dateStart;
                $eventTime = $closestEvent->timeStart;
                $closeeventname = $closestEvent->eventName;
                // Other event details...
                return view("dashboard", compact('clubs','closeeventname', 'closestEvent','eventDate', 'eventTime', 'events'));
            } else {
                // No upcoming events
                return view("dashboard", compact('clubs', 'events'));
            }
        } else {
            return redirect()->back();
        }
    }
}


    public function userhomepage()
    {
        $clubs = Club::all();
        $events = Event::all();
        // Retrieve the closest upcoming event
        $closestEvent = Event::where('dateStart', '>', now())
            ->orderBy('dateStart')
            ->first();

        // Check if there is a closest event
        if ($closestEvent) {
            // Access the details of the closest event
            $eventDate = $closestEvent->dateStart;
            $eventTime = $closestEvent->timeStart;
            $closeeventname = $closestEvent->eventName;
            // Other event details...
            return view("dashboard", compact('clubs','closeeventname', 'closestEvent','eventDate', 'eventTime', 'events'));
        } else {
            // No upcoming events
            return view("dashboard", compact('clubs', 'events'));
        }
    }

    public function adminhomepage()
    {
        return view("adminhomepage");
    }


    public function getMonthlyEvents()
    {
        $monthlyEvents = [];

        // Get the current month
        $currentMonth = Carbon::now()->format('Y-m');

        // Group upcoming events by month
        $upcomingEvents = Event::where('dateStart', '>', now())
            ->orderBy('dateStart')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->dateStart)->format('Y-m');
            });

        // Populate monthlyEvents array
        foreach ($upcomingEvents as $month => $events) {
            $monthlyEvents[] = [
                'month' => $month,
                'eventCount' => count($events),
            ];
        }

        return $monthlyEvents;
    }
}


