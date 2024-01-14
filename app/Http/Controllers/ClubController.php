<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{

    public function homepage(Request $request)
    {
       
        $allClubs = Club::all(); // Replace YourModel with the actual model you are using

        // Get unique club names
        $uniqueClubNames = $allClubs->unique('clubname')->pluck('clubname', 'id');

        // Check if there is a filter in the request
        if ($request->has('filter')) {
            $filteredClub = Club::find($request->input('filter'));

            // If the filtered club is found, display only that club
            if ($filteredClub) {
                $clubs = Club::where('clubname', $filteredClub->clubname)->get();
            } else {
                // If the filtered club is not found, display all clubs
                $clubs = $allClubs;
            }
        } else {
            // If there is no filter, display all clubs
            $clubs = $allClubs;
        }

        return view('clubuser_hariz.homepage', ['clubs' => $clubs, 'allClubs' => $uniqueClubNames]);
    }


    public function index(Request $request)
    {
        $allClubs = Club::all(); // Replace YourModel with the actual model you are using

        // Get unique club names
        $uniqueClubNames = $allClubs->unique('clubname')->pluck('clubname', 'id');

        // Check if there is a filter in the request
        if ($request->has('filter')) {
            $filteredClub = Club::find($request->input('filter'));

            // If the filtered club is found, display only that club
            if ($filteredClub) {
                $clubs = Club::where('clubname', $filteredClub->clubname)->get();
            } else {
                // If the filtered club is not found, display all clubs
                $clubs = $allClubs;
            }
        } else {
            // If there is no filter, display all clubs
            $clubs = $allClubs;
        }

        return view('clubs.index', ['clubs' => $clubs, 'allClubs' => $uniqueClubNames]);
    }


    public function create() {
        return view('clubs.create');
    }


public function store(Request $request)
{
    $data = $request->validate([
        'clubname' => 'required',
        'club_nickname' => 'required',
        'president' => 'required',
        'about' => 'nullable',
        'email' => 'nullable|email',
        'instagram' => 'nullable',
        'contact_number' => 'nullable',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the allowed image types and size
    ]);

    // Check if the club already has an image
    if ($request->hasFile('image') && $request->user()->image) {
        // Delete the old profile picture if it exists
        Storage::disk('public')->delete($request->user()->image);
    }

    // Handle image upload
    if ($request->hasFile('image')) {
        // Store the new profile picture
        $imagePath = $request->file('image')->store('images', 'public');
        $data['image'] = $imagePath;
    }

    // Create a new club with the provided data
    $newClub = Club::create($data);

    return redirect(route('clubs.index'))->with('success', 'Club created successfully');
}

    

    public function edit(Club $club) {
        return view('clubs.edit', ['club'=> $club]);
    }

    public function update(Request $request, Club $club) {
        $data = $request->validate([
            'clubname' => 'required',
            'club_nickname'=> "required",
            'president' => 'required',
            'about' => 'nullable',
            "email"=> "email",
            'instagram' => 'nullable',
            'contact_number'=>'nullable',
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
        $club ->update($data);

        return redirect(route('clubs.index'))->with('success', 'Club Updated Sucessfully');
    }


    public function destroy(Club $club) {
        $club->delete();
        return redirect(route('clubs.index'))->with('success','Club has been deleted');
    }






        // ClubController.php
    public function detail(Club $club)
    {
        return view('clubuser_hariz.clubdetail', compact('club'));
    }
    
}