<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use App\Models\Club;

class ClubPresidentController extends Controller
{
    public function dashboard()
    {
        // Retrieve the club associated with the authenticated user
        $club = Club::with('president', 'events')
            ->where('user_id', Auth::user()->id)
            ->first();

        // Check if the club is found
        if ($club) {
            // Fetch basic statistics
            $events = $club->events;
            $eventCount = $club->events->count();

            // Retrieve upcoming events (assuming 'dateStart' is a column in your events table)
            $upcomingEvents = $club->events()->where('dateStart', '>', now())->get();

            return view('event.dashboard', compact('eventCount', 'club', 'upcomingEvents', 'events'));
        } else {
            // Club not found, handle accordingly (redirect, show a message, etc.)
            return redirect()->route('home')->with('error', 'Club not found for the authenticated user.');
        }
    }

    public function edit(Club $club)
    {
        // Retrieve the club associated with the authenticated user
        $club = Club::with('president', 'events')
            ->where('user_id', Auth::user()->id)
            ->first();

        // Check if the club is found
        if ($club) {
            return view('eventPresident.edit', compact('club'));
        } else {
            // Club not found, handle accordingly (redirect, show a message, etc.)
            return redirect()->route('home')->with('error', 'Club not found for the authenticated user.');
        }
    }


    public function update(Request $request, Club $club) {
        $data = $request->validate([
            'about' => 'nullable',
            'email' => 'nullable|email',
            'instagram' => 'nullable',
            'contact_number' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the allowed image types and size
        ]);
    
        // Check if the user already has an image
        if ($request->hasFile('image') && $club->image) {
            // Delete the old profile picture if it exists
            Storage::disk('public')->delete($club->image);
        }
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        } else {
            // If no new image is provided, keep the existing image
            $data['image'] = $club->image;
        }
    
        // Update the club data
        $club->update($data);
    
        $club->save();
    
        return redirect(route('event.dashboard'))->with('success', 'Club Updated Successfully');
    }
}
