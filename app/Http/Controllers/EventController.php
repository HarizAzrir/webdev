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
        $event = Event::all();
        return view('eventuser.homepage', ['event' => $event]);
        
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
    




}