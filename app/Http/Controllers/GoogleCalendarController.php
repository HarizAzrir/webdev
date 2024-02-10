<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleCalendarController extends Controller
{
    public function index(Request $request, $email = null)
{
    // Check if the user is authenticated
    if (auth()->check()) {
        // Get the authenticated user's bookmarks
        $bookmarks = auth()->user()->bookmarks;
    } else {
        // If the user is not authenticated, handle it accordingly (e.g., redirect to login)
        // You can customize this part based on your application's logic
        return redirect()->route('login')->with('error', 'Please log in to view your events.');
    }

    // Rest of your code...

    return view('api/index', ['email' => $email, 'bookmarks' => $bookmarks]);
}


}
