<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Log\Logger;


class BookmarkController extends Controller
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
    public function index()
{
    // Retrieve all bookmarks for the authenticated user
    $bookmarks = auth()->user()->bookmarks;

    // Retrieve events based on the bookmarks
    $events = $bookmarks->map(function ($bookmark) {
        return $bookmark->event;
    });

    return view('event.index', ['events' => $events]);
}

    public function view()
    {
        $bookmarks = auth()->user()->bookmarks;

        // Retrieve events based on the bookmarks
        

        return view('bookmarks.view', ['bookmarks' => $bookmarks]);

    }

    public function create() {
        return view('bookmark.create');
    }

    public function store(Request $request, $eventId)
    {
        // Validate the request
        $request->validate([
            // Validation rules here
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Create a new bookmark
        $bookmark = new Bookmark();
        $bookmark->user_id = $user->id;
        $bookmark->event_id = $eventId; // Use the event ID from the route parameter
        $bookmark->save();

        // Redirect back to the event.index page
        return redirect()->route('event.index', ['event' => $eventId])->with('success', 'Event bookmarked successfully!');
    }



    



    public function edit(Bookmark $bookmark)
    {
        return view('bookmark.edit', ['bookmark' => $bookmark]);
        
    }

    public function update(Request $request, Bookmark $bookmark)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
        ]);

        // Update the bookmark with the provided data
        $bookmark->update($data);

        // Redirect to the event details page
        return redirect(route('event.index', ['bookmark' => $bookmark->event_id]))->with('success', 'Bookmark updated successfully');
    }


    public function destroy(Bookmark $bookmark)
    {
        // Delete a bookmark
        $bookmark->delete();

        return redirect()->route('bookmarks.index')->with('success', 'Bookmark deleted successfully!');
    }

    public function getBookmarks()
{
    try {
        // Fetch data from the 'bookmarks' table
        $bookmarks = DB::table('bookmarks')->select('user_id', 'event_id')->get();

        // Fetch additional information from the 'users' and 'events' tables based on user id and event id
        $finishedBookmarks = [];
        $ongoingBookmarks = [];

        foreach ($bookmarks as $bookmark) {
            $user = DB::table('users')->select('id', 'name', 'email')->where('id', $bookmark->user_id)->first();
            $event = DB::table('events')->select('id', 'eventName','dateStart','dateEnd','timeStart','timeEnd','venue','description','status')->where('id', $bookmark->event_id)->first();

            // Include only those bookmarks where the associated event's status is 'Finished' or 'Ongoing'
            if ($event) {
                $bookmarkDetails = [
                    'user_id' => $bookmark->user_id,
                    'event_id' => $bookmark->event_id,
                    'user_details' => $user,
                    'event_details' => $event,
                ];

                if ($event->status === 'Finished') {
                    $finishedBookmarks[] = $bookmarkDetails;
                } elseif ($event->status === 'Ongoing') {
                    $ongoingBookmarks[] = $bookmarkDetails;
                }
            }
        }

         // Log the success message
         $this->logger->info('getBookmarks operation was successful');

         // Return the filtered bookmarks data with user and event details as JSON
         return response()->json([
             'past_events' => $finishedBookmarks,
             'current_events' => $ongoingBookmarks,
         ]);
     } catch (\Exception $e) {
         // Log the error message
         $this->logger->error('Error in getBookmarks: ' . $e->getMessage());

         // Return an error response
         return response()->json(['error' => $e->getMessage()], 500);
     }
 }
}