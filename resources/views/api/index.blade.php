<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Events') }}
        </h2>
    </x-slot>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include FullCalendar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" defer></script>
    <script src="https://apis.google.com/js/api.js" defer onload="gapiLoaded()"></script>
    <script src="https://accounts.google.com/gsi/client" defer onload="gisLoaded()"></script>
   

    <script type="text/javascript">
    /* exported gapiLoaded */
    /* exported gisLoaded */
    /* exported handleAuthClick */
    /* exported handleSignoutClick */
    var userEmail = @json($email);
    // TODO(developer): Set to client ID and API key from the Developer Console
    const CLIENT_ID = '651798684763-1d509geubus5v03j3qqock8rl0mc0093.apps.googleusercontent.com';
    const API_KEY = 'AIzaSyCBMeFD99_xMKbCqvCYLCFT-cqLfUGKHq0';

    // Discovery doc URL for APIs used by the quickstart
    const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest';

    // Authorization scopes required by the API; multiple scopes can be included, separated by spaces.
    const SCOPES = 'https://www.googleapis.com/auth/calendar';

    let tokenClient;
    let gapiInited = false;
    let gisInited = false;

    document.getElementById('authorize_button').style.visibility = 'hidden';
    document.getElementById('signout_button').style.visibility = 'hidden';

    /**
     * Callback after api.js is loaded.
     */
    function gapiLoaded() {
        gapi.load('client', initializeGapiClient);
    }

    /**
     * Callback after the API client is loaded. Loads the discovery doc to initialize the API.
     */
    async function initializeGapiClient() {
        try {
            await gapi.client.init({
                apiKey: API_KEY,
                discoveryDocs: [DISCOVERY_DOC],
            });
            gapiInited = true;
            maybeEnableButtons();
        } catch (error) {
            console.error('Error initializing Google API client:', error);
        }
    }

    /**
     * Callback after Google Identity Services are loaded.
     */
    function gisLoaded() {
        tokenClient = google.accounts.oauth2.initTokenClient({
            client_id: CLIENT_ID,
            scope: SCOPES,
            callback: '', // defined later
        });
        gisInited = true;
        maybeEnableButtons();
    }

    /**
     * Enables user interaction after all libraries are loaded.
     */
    function maybeEnableButtons() {
        if (gapiInited && gisInited) {
            document.getElementById('authorize_button').style.visibility = 'visible';
        }
    }

    /**
     * Sign in the user upon button click.
     */
    async function handleAuthClick() {
        try {
            tokenClient.callback = async (resp) => {
                if (resp.error !== undefined) {
                    throw resp;
                }
                document.getElementById('signout_button').style.visibility = 'visible';
                document.getElementById('authorize_button').innerText = 'Refresh';
                await fetchAndRenderBookmarkedEvents();
            };

            if (gapi.client.getToken() === null) {
                // Prompt the user to select a Google Account and ask for consent to share their data
                // when establishing a new session.
                tokenClient.requestAccessToken({ prompt: 'consent' });
            } else {
                // Skip the display of the account chooser and consent dialog for an existing session.
                tokenClient.requestAccessToken({ prompt: '' });
            }
        } catch (error) {
            console.error('Error handling authentication click:', error);
        }
    }

    /**
     * Sign out the user upon button click.
     */
    function handleSignoutClick() {
        try {
            const token = gapi.client.getToken();
            if (token !== null) {
                google.accounts.oauth2.revoke(token.access_token);
                gapi.client.setToken('');
                document.getElementById('content').innerText = '';
                document.getElementById('authorize_button').innerText = 'Authorize';
                document.getElementById('signout_button').style.visibility = 'hidden';
            }
        } catch (error) {
            console.error('Error handling signout click:', error);
        }
    }

    /**
     * Function to fetch and render bookmarked events in the table.
     */
    async function fetchAndRenderBookmarkedEvents() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/show-bookmarks');
            const data = await response.json();
            const { current_events } = data;

            if (!Array.isArray(current_events)) {
                throw new Error('Current events data is not an array');
            }

            // Clear the previous contents of the table body
            const bookmarkListBody = document.getElementById('bookmarkListBody');
            bookmarkListBody.innerHTML = '';

            // Iterate through the current events
            for (const currentEvent of current_events) {
                try {
                    // Fetch user details using user ID
                    const userResponse = await fetch(`http://127.0.0.1:8000/api/users/${currentEvent.user_id}`);
                    const userData = await userResponse.json();

                    if (userData.email === userEmail) {
                        // Fetch event details using event ID
                        const eventResponse = await fetch(`http://127.0.0.1:8000/api/events/${currentEvent.event_id}`);
                        const eventData = await eventResponse.json();

                        // Render the event in the table
                        renderEventInTable(eventData);
                    } else {
                        console.log('User email does not match or user details not found.');
                    }
                } catch (error) {
                    console.error('Error fetching user or event details:', error);
                }
            }
        } catch (error) {
            console.error('Error fetching bookmarked events:', error);
        }
    }

    /**
     * Function to render an event in the table.
     */
    function renderEventInTable(eventData) {
        // Construct a table row for the event
        const eventRow = document.createElement('tr');
        eventRow.innerHTML = `
            <td>${eventData.eventName}</td>
            <td>${eventData.dateStart}</td>
            <td>${eventData.timeStart}</td>
            <td>${eventData.venue}</td>
            <!-- Add more columns as needed -->
        `;
        // Append the row to the table body
        const bookmarkListBody = document.getElementById('bookmarkListBody');
        bookmarkListBody.appendChild(eventRow);
    }

    /**
     * Function to add bookmarked events to Google Calendar.
     */
    async function addBookmarkedEventsToCalendar() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/show-bookmarks');
            const data = await response.json();
            const { current_events } = data;

            if (!Array.isArray(current_events)) {
                throw new Error('Current events data is not an array');
            }

            // Iterate through the current events
            for (const currentEvent of current_events) {
                try {
                    // Fetch user details using user ID
                    const userResponse = await fetch(`http://127.0.0.1:8000/api/users/${currentEvent.user_id}`);
                    const userData = await userResponse.json();

                    if (userData.email === userEmail) {
                        // Fetch event details using event ID
                        const eventResponse = await fetch(`http://127.0.0.1:8000/api/events/${currentEvent.event_id}`);
                        const eventData = await eventResponse.json();

                        // Add the bookmarked event to Google Calendar
                        await addBookmarkEventToCalendar(eventData);
                    } else {
                        console.log('User email does not match or user details not found.');
                    }
                } catch (error) {
                    console.error('Error fetching user or event details:', error);
                }
            }
            console.log('Bookmarked events added to Google Calendar successfully.');
        } catch (error) {
            console.error('Error fetching bookmarked events:', error);
        }
    }

    /**
     * Function to add a bookmarked event to Google Calendar.
     */
    async function addBookmarkEventToCalendar(eventData) {
        try {
            console.log('Adding bookmarked event to Google Calendar...');
            // Check if the Google Calendar API client is loaded
            if (!gapi.client.calendar) {
                console.error('Google Calendar API client not loaded.');
                return;
            }

            // Create the event in Google Calendar
            await createEvent(eventData);
        } catch (error) {
            console.error('Error adding bookmarked event to Google Calendar:', error);
        }
    }

    /**
     * Function to create an event in Google Calendar.
     */
    async function createEvent(eventData) {
        try {
            console.log('Creating event...');
            // Check if the Google Calendar API client is loaded
            if (!gapi.client.calendar) {
                console.error('Google Calendar API client not loaded.');
                return;
            }

            // Extract event details from eventData
            const {
                eventName,
                venue,
                description,
                dateStart,
                timeStart,
                dateEnd,
                timeEnd
            } = eventData;

            // Construct the event object in the required format
            const event = {
                'summary': eventName,
                'location': venue,
                'description': description,
                'start': {
                    'dateTime': `${dateStart}T${timeStart}`,
                    'timeZone': 'Asia/Kuala_Lumpur', // Update with the appropriate time zone
                },
                'end': {
                    'dateTime': `${dateEnd}T${timeEnd}`,
                    'timeZone': 'Asia/Kuala_Lumpur', // Update with the appropriate time zone
                },
                'reminders': {
                    'useDefault': false,
                    'overrides': [
                        { 'method': 'email', 'minutes': 24 * 60 },
                        { 'method': 'popup', 'minutes': 60 },
                    ],
                },
            };

            // Make a request to insert the event into Google Calendar
            const request = gapi.client.calendar.events.insert({
                'calendarId': 'primary', // Use 'primary' for the user's primary calendar
                'resource': event,
            });

            // Execute the request and handle the response
            const response = await request.execute();
            console.log('Event created:', response);
        } catch (error) {
            console.error('Error creating event:', error);
        }
    }

    // Call the fetchAndRenderBookmarkedEvents function on page load
    document.addEventListener('DOMContentLoaded', fetchAndRenderBookmarkedEvents);

    /**
     * Function to handle the click event for adding bookmarked events to Google Calendar.
     */
    async function handleAddToCalendarClick() {
        try {
            await addBookmarkedEventsToCalendar();
        } catch (error) {
            console.error('Error handling "Add to Calendar" click:', error);
        }
    }
</script>

    

    <!-- Your existing HTML content (without <html>, <head>, and <body> tags) goes here -->
    <br>
    <br>

    <!-- Add custom CSS for gradient header -->
<style>
    #calendarContainer .fc-toolbar {
        background: linear-gradient(to right, #C8453D, #FF66B0);
        color: white; /* Text color for better visibility */
        font-weight: bold;
    }

    #calendarContainer .fc-view-container {
        background-color: white; /* Calendar background color */
    }

    #calendarContainer .fc-day-header {
        background-color: #7B3DC8;
        color: white; /* Text color for day headers */
    }

    #localContent th,
    #localContent td {
        border: 1px solid #e5e7eb; /* Add a border to both headers and data cells */
        text-align: center;
        border-radius: 5px;
    }

    #localContent th {
        background-color: #7B3DC8;
        color: white; /* Text color for better visibility */
        padding: 10px; /* Add padding for better appearance */
        font-weight: bold;
    }

    #localContent td {
        background-color: #f3f4f6; /* Grey background color for table data */
        color: #4b5563; /* Text color for table data */
        padding: 10px; /* Add padding for better appearance */
    }

    .glass-button {
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.3), #E9EDFA);
        border: none;
        color: #555; /* Adjust text color as needed */
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .glass-button:hover {
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.15), #B6C0E1);
    }

</style>

<!-- ... (your existing HTML code) ... -->
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- View Your Favourited Events and Save and Update button -->
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">View My Saved Events</h3>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('bookmarks.view') }}" class="py-2 px-4 bg-blue-500 text-white rounded-md">Edit My Events</a>
                    </div>
                </div>
                <br><br>

                <!-- Add buttons to initiate auth sequence, sign out, and add event to calendar -->
                <div class="flex justify-between items-center mb-4">
                    <button id="authorize_button" onclick="handleAuthClick()" class="glass-button flex-grow">Authorize</button>
                    <button id="add_event_button" onclick="addBookmarkedEventsToCalendar()" class="glass-button flex-grow" >Add Event</button>
                    <button id="refresh_calendar_button" onclick="refreshCalendar()" class="glass-button flex-grow">Refresh Calendar</button>
                    <button id="signout_button" onclick="handleSignoutClick()" class="glass-button flex-grow">Sign Out</button>
                </div>

                <!-- Table Container -->
                <div id="localContent" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">
                <table class="min-w-full divide-y divide-gray-200", >
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Event Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Time
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Venue
                            </th>
                        </tr>
                    </thead>
                    <tbody class="px-6 py-4 whitespace-nowrap" id="bookmarkListBody" class="bg-white divide-y divide-gray-200" class="bg-white divide-y divide-gray-200">
                        <!-- Bookmarks will be dynamically populated here -->
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <br>
        <br>

<!-- Updated Code -->

<!-- FullCalendar Container -->
<div id="calendarContainer"></div>

<script>
    // Function to create FullCalendar
    function createFullCalendar() {
        $('#calendarContainer').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'month', // Initial view
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: [], // initialize with an empty array, events will be added dynamically
        });
    }

    // Function to add events to FullCalendar
    function addEventToFullCalendar(eventData) {
        $('#calendarContainer').fullCalendar('renderEvent', eventData, true);
    }

    // Function to refresh the FullCalendar
    function refreshCalendar() {
        // Clear existing events from the calendar
        $('#calendarContainer').fullCalendar('removeEvents');

        // Fetch and render bookmarked events
        fetchAndRenderBookmarkedEvents();
    }

    // Function to fetch and render bookmarked events in the table and FullCalendar
    async function fetchAndRenderBookmarkedEvents() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/show-bookmarks');
            const data = await response.json();
            const { current_events } = data;

            if (!Array.isArray(current_events)) {
                throw new Error('Current events data is not an array');
            }

            // Clear the previous contents of the table body
            const bookmarkListBody = document.getElementById('bookmarkListBody');
            bookmarkListBody.innerHTML = '';

            // Iterate through the current events
            for (const currentEvent of current_events) {
                try {
                    // Fetch user details using user ID
                    const userResponse = await fetch(`http://127.0.0.1:8000/api/users/${currentEvent.user_id}`);
                    const userData = await userResponse.json();

                    if (userData.email === userEmail) {
                        // Fetch event details using event ID
                        const eventResponse = await fetch(`http://127.0.0.1:8000/api/events/${currentEvent.event_id}`);
                        const eventData = await eventResponse.json();

                        // Render the event in the table
                        renderEventInTable(eventData);

                        // Add the event to FullCalendar
                        addEventToFullCalendar({
                            title: eventData.eventName,
                            start: eventData.dateStart, // You may need to format the date accordingly
                            // Add more properties as needed
                        });
                    } else {
                        console.log('User email does not match or user details not found.');
                    }
                } catch (error) {
                    console.error('Error fetching user or event details:', error);
                }
            }
        } catch (error) {
            console.error('Error fetching bookmarked events:', error);
        }
    }

    // Call the createFullCalendar function on page load
    document.addEventListener('DOMContentLoaded', createFullCalendar);
</script>

    <br><br>
</x-app-layout>
