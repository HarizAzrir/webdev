<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventController extends Controller
{

    public function edit(Event $event)
    {
        
        return view('event.edit', ['event' => $event]);
        
        
    }
    
    public function homepage(Event $event)
    {
        // Retrieve all events from the "events" table
        $events = Event::with('club')->get();
        return view('eventuser.homepage', ['events' => $events]);
    }

    // ClubController.php
    public function detail(Event $event)
    {
        return view('event.index', compact('event'));
    }
    
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'eventName' => 'nullable',
            'dateStart' => 'nullable|date',
            'dateEnd' => 'nullable|date',
            'timeStart' => 'nullable',
            'timeEnd' => 'nullable',
            'venue' => 'nullable',
            'category' => 'nullable',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            'status' => 'nullable',
        ]);
    
        // Format date fields using Carbon
        $data['dateStart'] = Carbon::parse($data['dateStart'])->format('Y-m-d');
        $data['dateEnd'] = Carbon::parse($data['dateEnd'])->format('Y-m-d');
    
        // Check if the event already has an image
        if ($request->hasFile('image') && $event->image) {
            // Delete the old event image if it exists
            Storage::disk('public')->delete($event->image);
        }
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Store the new event image
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }
    
        // Update the event with the provided data
        $event->update($data);
    
        // Redirect to the event details page
        return redirect(route('event.index', ['event' => $event]))->with('success', 'Event updated successfully');
    }


    public function bookmark(Event $event)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            // Handle the case where the user is not authenticated (redirect to login, show a message, etc.)
            return redirect()->route('login');
        }

        // Check if the user has already bookmarked this event
        if (!$event->bookmarks()->where('user_id', auth()->id())->exists()) {
            // If not, attach the event to the user's bookmarks
            $event->bookmarks()->create(['user_id' => auth()->id()]);
        } else {
            // If already bookmarked, remove the bookmark
            $event->bookmarks()->where('user_id', auth()->id())->delete();
        }

        // Redirect back to the event.index page
        return redirect()->route('event.index', ['event' => $event])->with('success', 'Event bookmarked/unbookmarked successfully!');
    }


    ///////////////////////////admin///////////////////////////
    
    public function admin_index(Request $request)
    {
        $allevents = event::all(); // Replace YourModel with the actual model you are using

        // Get unique event names
        $uniqueeventNames = $allevents->unique('eventname')->pluck('eventname', 'id');

        // Check if there is a filter in the request
        if ($request->has('filter')) {
            $filteredevent = event::find($request->input('filter'));

            // If the filtered event is found, display only that event
            if ($filteredevent) {
                $event = event::where('eventname', $filteredevent->eventname)->get();
            } else {
                // If the filtered event is not found, display all events
                $event = $allevents;
            }
        } else {
            // If there is no filter, display all events
            $event = $allevents;
        }

        return view('eventAdmin.index', ['event' => $event, 'allevents' => $uniqueeventNames]);
    }

    public function create() {
        return view('eventAdmin.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'eventname' => 'required',
            'event_nickname' => 'required',
            'president' => 'required',
            'about' => 'nullable',
            'email' => 'nullable|email',
            'instagram' => 'nullable',
            'contact_number' => 'nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the allowed image types and size
        ]);

        // Check if the event already has an image
        if ($request->hasFile('image') && $request->user()->image) {
            // Delete the old profile picture if it exists
            Storage::disk('public')->delete($request->user()->image);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Store the new profile picture
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }}
    
}