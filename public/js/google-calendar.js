/* exported gapiLoaded */
/* exported gisLoaded */
/* exported handleAuthClick */
/* exported handleSignoutClick */

// TODO(developer): Set to client ID and API key from the Developer Console
const CLIENT_ID = '391196511334-58aalenmf6dd08i0krsldnh4d1ss5lb2.apps.googleusercontent.com';
const API_KEY = 'AIzaSyDJgqnj54hmYCA5LrQoWLUPcGTc_x5TAEM';

// Discovery doc URL for APIs used by the quickstart
const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest';

// Authorization scopes required by the API; multiple scopes can be
// included, separated by spaces.
const SCOPES = 'https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/userinfo.email';

let tokenClient;
let gapiInited = false;
let gisInited = false;



/**
 * Callback after api.js is loaded.
 */
function gapiLoaded() {
    gapi.load('client:auth2', initializeGapiClient);
}

/**
 * Callback after the API client is loaded. Loads the
 * discovery doc to initialize the API.
 */
async function initializeGapiClient() {
    await gapi.client.init({
        apiKey: API_KEY,
        discoveryDocs: [DISCOVERY_DOC],
    });
    gapiInited = true;
    maybeEnableButtons();
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

async function getEmail() {
    const response = await fetch('https://www.googleapis.com/oauth2/v2/userinfo', {
        headers: {
            Authorization: `Bearer ${gapi.client.getToken().access_token}`
        }
    });
    const data = await response.json();
    return data.email;
}

/**
 * Sign in the user upon button click.
 */
async function handleAuthClick() {
    tokenClient.callback = async (resp) => {
        if (resp.error !== undefined) {
            throw resp;
        }
        document.getElementById('signout_button').style.visibility = 'visible';
        document.getElementById('create_button').style.visibility = 'visible';
        document.getElementById('list_button').style.visibility = 'visible';
        document.getElementById('cre_button').style.visibility = 'visible';
        document.getElementById('createAndList_button').style.visibility = 'visible';
    };

    if (gapi.client.getToken() === null) {
        // Prompt the user to select a Google Account and ask for consent to share their data
        // when establishing a new session.
        tokenClient.requestAccessToken({ prompt: 'consent' });
    } else {
        // Skip display of account chooser and consent dialog for an existing session.
        tokenClient.requestAccessToken({ prompt: 'none' });
    }
}

async function handleList() {
    await listUpcomingEvents();
}

async function handleCreateClick() {
    tokenClient.callback = async (resp) => {
        if (resp.error !== undefined) {
            throw resp;
        }
        await createEvent();
    };

    getEmail().then(email => {
        if (gapi.client.getToken() === null) {
            // Prompt the user to select a Google Account and ask for consent to share their data
            // when establishing a new session.
            tokenClient.requestAccessToken({ prompt: 'consent', login_hint: email });
        } else {
            // Skip display of account chooser and consent dialog for an existing session.
            tokenClient.requestAccessToken({ prompt: 'none', login_hint: email });
        }
    });
}

/**
 * Sign out the user upon button click.
 */
function handleSignoutClick() {
    const token = gapi.client.getToken();
    if (token !== null) {
        google.accounts.oauth2.revoke(token.access_token);
        gapi.client.setToken('');
        document.getElementById('content').innerText = '';
        document.getElementById('authorize_button').innerText = 'Authorize';
        document.getElementById('signout_button').style.visibility = 'hidden';
    }
}

async function listUpcomingEvents() {
    try {
        const request = {
            'calendarId': 'primary',
            'timeMin': (new Date()).toISOString(),
            'showDeleted': false,
            'singleEvents': true,
            'maxResults': 10,
            'orderBy': 'startTime',
        };

        const response = await gapi.client.calendar.events.list(request);
        const events = response.result.items;

        if (!events || events.length === 0) {
            document.getElementById('content').innerHTML = '<p>No upcoming events found.</p>';
            return;
        }

        // Create a styled table
        const table = document.createElement('table');
        table.className = 'event-table';
        table.innerHTML = `
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Start Date</th>
                    <th>Start Time</th>
                    <th>End Date</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody></tbody>
        `;

        const tbody = table.querySelector('tbody');

        // Populate the table with events
        events.forEach(event => {
            const row = document.createElement('tr');
        
            const eventNameCell = document.createElement('td');
            eventNameCell.className = 'event-name';
            eventNameCell.textContent = event.summary;

            eventNameCell.setAttribute('contenteditable', 'true');
            eventNameCell.addEventListener('input', function() {
            updateEventData(events, eventNameCell.textContent);
            });

            eventNameCell.onclick = () => redirectToEventDate(event.start.dateTime);
            eventNameCell.style.cursor = 'pointer'; // Change cursor to pointer

            // Add styles for hover effect
            eventNameCell.onmouseover = function() {
            eventNameCell.style.color = 'blue';
            };

            eventNameCell.onmouseout = function() {
            eventNameCell.style.color = ''; // Reset to default color
            };
        
            const startDateCell = document.createElement('td');
            startDateCell.className = 'start-date';
            startDateCell.textContent = formatDate(event.start.dateTime);
        
            const startTimeCell = document.createElement('td');
            startTimeCell.className = 'start-time';
            startTimeCell.textContent = formatTime(event.start.dateTime);
        
            const endDateCell = document.createElement('td');
            endDateCell.className = 'end-date';
            endDateCell.textContent = formatDate(event.end.dateTime);
        
            const endTimeCell = document.createElement('td');
            endTimeCell.className = 'end-time';
            endTimeCell.textContent = formatTime(event.end.dateTime);

            row.appendChild(eventNameCell);
            row.appendChild(startDateCell);
            row.appendChild(startTimeCell);
            row.appendChild(endDateCell);
            row.appendChild(endTimeCell);

            tbody.appendChild(row);
        });

        // Display the table in the 'content' element
        const contentElement = document.getElementById('content');
        contentElement.innerHTML = '<p>Upcoming Events:</p>';
        contentElement.appendChild(table);
        return events;
    } catch (err) {
        console.error('Error fetching upcoming events:', err.message);
        document.getElementById('content').innerText = 'Error fetching upcoming events.';
        return [];
    }
}

async function updateEventData(eventIds, updatedEvent) {
    if (!Array.isArray(eventIds)) {
        console.error('Error: eventIds is not an array');
        return;
    }

    try {
        // Fetch event details for each event ID
        const events = await Promise.all(
            eventIds.map(async eventId => {
                const response = await gapi.client.calendar.events.get({
                    'calendarId': 'primary',
                    'eventId': eventId,
                });

                return response.result;
            })
        );

        // Update each event
        events.forEach(async event => {
            // Update the properties of the event
            event.summary = updatedEvent.title;
            event.start.dateTime = updatedEvent.start;
            event.end.dateTime = updatedEvent.end;

            // Add additional properties or update as needed

            // Call a function to sync the updated data back to Google Calendar
            await syncUpdatedDataToGoogleCalendar(event);
        });
    } catch (error) {
        console.error('Error fetching event details:', error.message);
    }
}


// Function to sync updated data back to Google Calendar
async function syncUpdatedDataToGoogleCalendar(updatedEvent) {
    try {
        const request = {
            'calendarId': 'primary',
            'eventId': updatedEvent.id,
            'resource': updatedEvent
        };

        // Update the event on Google Calendar
        const response = await gapi.client.calendar.events.update(request);

        console.log('Event updated:', response);

        // Optionally, you can re-fetch the updated events from Google Calendar
        // and update your local view if needed
        // const updatedEvents = await listUpcomingEvents();
        // displayUpdatedEvents(updatedEvents);
    } catch (err) {
        console.error('Error updating event:', err.message);
        // Handle error as needed
    }
}


function formatDate(dateTimeString) {
    const date = new Date(dateTimeString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

function formatTime(dateTimeString) {
    const date = new Date(dateTimeString);
    return date.toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric' });
}



async function createEvent(dataArray) {
    let responses = [];
    try {
        for (const eventData of dataArray) {
            let eventName = eventData.eventName;
            let dateStart = eventData.dateStart;
            let dateEnd = eventData.dateEnd;
            let timeStart = eventData.timeStart;
            let timeEnd = eventData.timeEnd;
            let venue = eventData.venue;
            let description = eventData.description;

            console.log('Event Name:', eventName);
            console.log('Date Start:', dateStart);
            console.log('Date End:', dateEnd);
            console.log('Time Start:', timeStart);
            console.log('Time End:', timeEnd);
            console.log('Venue:', venue);
            console.log('Description:', description);

            const event = {
                'summary': eventName,
                'location': venue,
                'description': description,
                'start': {
                    'dateTime': `${dateStart}T${timeStart}`,
                    'timeZone': 'Asia/Kuala_Lumpur',
                },
                'end': {
                    'dateTime': `${dateEnd}T${timeEnd}`,
                    'timeZone': 'Asia/Kuala_Lumpur',
                },
                'reminders': {
                    'useDefault': false,
                    'overrides': [
                        {'method': 'email', 'minutes': 24 * 60},
                        {'method': 'popup', 'minutes': 60},
                    ],
                },
            };

            const request = gapi.client.calendar.events.insert({
                'calendarId': 'primary',
                'resource': event,
            });

            const response = await request.execute(event => console.log('Event created: ' + event.htmlLink));
            responses.push(response);
        }
    } catch (err) {
        console.log('Error: ' + err.message);
        return;
    }
    return responses;
}


async function fetchEventData() {
    try {
        let response = await fetch('http://localhost:8000/scripts/fetch_event.php');

        if (!response.ok) {
            alert(`Could not connect to the database. Status: ${response.status}`);
            return `Could not connect to the database. Status: ${response.status}`;
        } else {
            let data = await response.text();
            console.log('Received data:', data);
            let dataArray;
            try {
                dataArray = JSON.parse(data);
            } catch (parseError) {
                console.error('Error parsing JSON:', parseError);
                return 'Error parsing JSON';
            }
            if (!Array.isArray(dataArray)) {
                console.error('Data is not an array:', dataArray);
                return 'Data is not an array';
            }
            return dataArray;
        }
    } catch (error) {
        alert('Fetch failed: ' + error);
        return 'Fetch failed: ' + error;
    }
}


async function handleCreClick() {
    try {
        const email = await getEmail();
        tokenClient.callback = async (resp) => {
            if (resp.error !== undefined) {
                throw resp;
            }

            document.getElementById('signout_button').style.visibility = 'visible';

            const accessToken = gapi.client.getToken().access_token;

            let dataArray = await fetchEventData();
            await createEvent(dataArray);
        };

        
        if (gapi.client.getToken() === null) {
            await tokenClient.requestAccessToken({ prompt: 'consent', login_hint: email });
        } else {
            await tokenClient.requestAccessToken({ prompt: 'none', login_hint: email });
        }
    } catch (error) {
        console.error('Error in handleCreClick:', error);
        // Handle the error, e.g., show an error message to the user
    }
}

async function listLocalEvents() {
    try {
        const localEvents = await gapi.client.calendar.events.list({
            'calendarId': 'primary',
            'timeMin': (new Date()).toISOString(),
            'showDeleted': false,
            'singleEvents': true,
            'maxResults': 10,
            'orderBy': 'startTime',
        });

        return localEvents.result.items;
    } catch (err) {
        console.log('Error fetching local events: ' + err.message);
        return [];
    }
}

async function handleCreateAndListClick() {
    

    // List local events
    const localEvents = await listLocalEvents();
    console.log('Local events:', localEvents);

    // Display local events in the HTML
    displayLocalEvents(localEvents);
}

function displayLocalEvents(events) {
    const eventArray = events.map(event => ({
        title: event.summary,
        start: event.start.dateTime || event.start.date,
        end: event.end.dateTime || event.end.date,
        id: event.id // Add the event ID for referencing (not used for deletion)
    }));

    // Initialize FullCalendar
    $('#localContent').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'month',
        events: eventArray,
        eventClick: handleEventClick, // Attach the event click handler
        eventRender: function (event, element) {
            // Make the event name clickable
            element.find('.fc-title').css('cursor', 'pointer').on('click', function () {
                redirectToEventDate(event.start.format());
            });
        },
        editable: true,
        eventDrop: function (event, delta, revertFunc) {
            // Handle event drop if needed
        }
    });
}

function redirectToEventDate(eventDate) {
    const localCalendar = $('#localContent').fullCalendar();

    // Format the date using moment.js (make sure to include the moment.js library)
    const formattedDate = moment(eventDate).format('YYYY-MM-DD');

    // Automatically switch to 'agendaDay' view for the clicked date
    localCalendar.fullCalendar('changeView', 'agendaDay');
    localCalendar.fullCalendar('gotoDate', formattedDate);
}

function handleEventClick(info) {
    console.log('info.event:', info.event);
    // Handle click event if needed, but don't include deletion logic
}

   
