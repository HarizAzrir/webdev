<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(){

        $Users = User::all(); 
        return view('useradmin.index', ['Users' => $Users]);
    }


    public function store(Request $request)
{
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'usertype' => ['nullable', 'in:user,president,admin'],
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
        $imagePath = $request->file('image')->store('image', 'public');
        $data['image'] = $imagePath;
    }

    // Create a new club with the provided data
    $newUser = User::create($data);

    return redirect(route('useradmin.index'))->with('success', 'New user created successfully');
}


public function create() {
    return view('useradmin.create');
}

public function edit(User $user) {
    return view('useradmin.edit', ['user'=> $user]);
}


public function update(Request $request, User $user)
{
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'usertype' => ['nullable', 'in:user,president,admin'],
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the allowed image types and size
    ]);

    // Check if the user already has an image
    if ($request->hasFile('image') && $user->image) {
        // Delete the old profile picture if it exists
        Storage::disk('public')->delete($user->image);
    }

    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('image', 'public');
        $data['image'] = $imagePath;
    } else {
        // If no new image is provided, keep the existing image
        $data['image'] = $user->image;
    }

    $user->update($data);

    return redirect(route('useradmin.index'))->with('success', 'User Updated Successfully');
}




public function destroy(User $user) {
    $user->delete();
    return redirect(route('useradmin.index'))->with('success','User has been deleted');
}

public function show($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }


public function bookmarks()
    {
        return $this->hasMany(BookmarkController::class, 'user_id');
    }

}
