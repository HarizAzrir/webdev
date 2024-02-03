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
let timerInterval;
console.log('User email:', userEmail);


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
        document.getElementById('signin_button').style.visibility = 'visible';
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
        document.getElementById('signin_button').style.visibility = 'hidden';
        document.getElementById('signout_button').style.visibility = 'visible';
        document.getElementById('list_button').style.visibility = 'visible';
        document.getElementById('createAndList_button').style.visibility = 'visible';
        document.getElementById('showbookmarks_button').style.visibility = 'visible';
        startTimer(3600);
    };

    if (gapi.client.getToken() === null) {
        // Prompt the user to select a Google Account and ask for consent to share their data
        // when establishing a new session.
        tokenClient.requestAccessToken({ prompt: 'consent' });
    } else {
        // Skip display of account chooser and consent dialog for an existing session.
        tokenClient.requestAccessToken({ prompt: 'none' });
    }
    setTimeout(function () {
        // Assuming authentication is successful
        callback();
    }, 3000);
}

function startTimer(durationInSeconds) {
    let timerDisplay = document.getElementById('timerValue');

    let duration = durationInSeconds;
    let minutes, seconds;

    timerInterval = setInterval(function () {
        minutes = parseInt(duration / 60, 10);
        seconds = parseInt(duration % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        timerDisplay.textContent = minutes + ":" + seconds;

        if (--duration < 0) {
            clearInterval(timerInterval);
            // Call a function or perform actions when the timer reaches zero
            timerDisplay.textContent = "Login Expired";
            handleTimerEnd();
        }
    }, 1000);
}


function handleTimerEnd() {
    // Stop the timer interval
    clearInterval(timerInterval);

    // Perform actions when the timer ends, such as showing an alert
    alert('Login Expired');
}

function showSections() {
    document.getElementById('section1').style.display = 'block';
    document.getElementById('section2').style.display = 'block';
    document.getElementById('section3').style.display = 'block';
    document.getElementById('signout_button').style.visibility = 'visible';
}

async function handleList() {
    await listUpcomingEvents();
}




function displayEventsTable(tableId, events, title) {
    // Find the HTML element where you want to display the table
    const tableContainer = document.getElementById(tableId);

    // Create a table element
    const table = document.createElement('table');
    table.className = 'event-table';

    // Add a title row
    const titleRow = document.createElement('tr');
    const titleCell = document.createElement('th');
    titleCell.colSpan = 3; // Adjust the number of columns as needed
    titleCell.textContent = title;
    titleRow.appendChild(titleCell);
    table.appendChild(titleRow);

    // Add header row
    const headerRow = document.createElement('tr');
    ['User ID', 'Event ID', 'User Details', 'Event Details'].forEach(headerText => {
        const headerCell = document.createElement('th');
        headerCell.textContent = headerText;
        headerRow.appendChild(headerCell);
    });
    table.appendChild(headerRow);

    // Add rows for each event
    events.forEach(event => {
        const row = document.createElement('tr');
        ['user_id', 'event_id', 'user_details', 'event_details'].forEach(key => {
            const cell = document.createElement('td');

            // Handle user_details and event_details objects
            if (key.includes('_details')) {
                const subObjectKeys = Object.keys(event[key]);
                subObjectKeys.forEach(subKey => {
                    const subCell = document.createElement('div');
                    subCell.textContent = `${subKey}: ${event[key][subKey]}`;
                    cell.appendChild(subCell);
                });
            } else {
                cell.textContent = event[key];
            }

            row.appendChild(cell);
        });
        table.appendChild(row);
    });

    // Add the table to the container
    tableContainer.appendChild(table);
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
        document.getElementById('signin_button').innerText = 'Sign In';
        document.getElementById('signin_button').style.visibility = 'visible';
        document.getElementById('list_button').style.visibility = 'hidden';
        document.getElementById('createAndList_button').style.visibility = 'hidden';
        document.getElementById('showbookmarks_button').style.visibility = 'hidden';
        document.getElementById('signout_button').style.visibility = 'hidden';
        clearInterval(timerInterval);
        document.getElementById('timerValue').textContent = '60:00';
    }
}

let existingTable;
let uniqueEventNames = new Set();
async function listUpcomingEvents(currentEventDetails) {
    try {

        if (typeof currentEventDetails !== 'object' || Array.isArray(currentEventDetails)) {
            throw new Error('Invalid data format for currentEventDetails');
        }

        const eventsArray = [currentEventDetails];

        // Check if there are any events
        if (!eventsArray || eventsArray.length === 0) {
            document.getElementById('content').innerHTML = '<p>No events found.</p>';
            return;
        }

        // Create a styled table
        console.log("33445",eventsArray);
        if (!existingTable) {
            existingTable = document.createElement('table');
            existingTable.className = 'event-table';
            existingTable.innerHTML = `
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
            document.getElementById('content').innerHTML = '<p>Events:</p>';
            document.getElementById('content').appendChild(existingTable);
        }

        const tbody = existingTable.querySelector('tbody');

        // Populate the table with events
        eventsArray.forEach(event => {
            // Check for duplicate event name
            if (uniqueEventNames.has(event.eventName)) {
                // Display alert for duplicate event
                alert(`Duplicate event found: ${event.eventName}`);
            } else {
            const row = document.createElement('tr');

            const eventNameCell = document.createElement('td');
            eventNameCell.className = 'event-name';
            eventNameCell.textContent = event.eventName;

            const startDateCell = document.createElement('td');
            startDateCell.className = 'start-date';
            startDateCell.textContent = formatDate(event.dateStart);

            const startTimeCell = document.createElement('td');
            startTimeCell.className = 'start-time';
            startTimeCell.textContent = formatTime(event.timeStart);

            const endDateCell = document.createElement('td');
            endDateCell.className = 'end-date';
            endDateCell.textContent = formatDate(event.dateEnd);

            const endTimeCell = document.createElement('td');
            endTimeCell.className = 'end-time';
            endTimeCell.textContent = formatTime(event.timeEnd);

            row.appendChild(eventNameCell);
            row.appendChild(startDateCell);
            row.appendChild(startTimeCell);
            row.appendChild(endDateCell);
            row.appendChild(endTimeCell);

            tbody.appendChild(row);

            // Add the event name to the set
            uniqueEventNames.add(event.eventName);
            }
        });
    } catch (err) {
        console.error('Error displaying events:', err.message);
        document.getElementById('content').innerText = 'Error displaying events.';
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



function formatDate(dateTimeString) {
    const date = new Date(dateTimeString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

function formatTime(timeString) {
    const [hours, minutes, seconds] = timeString.split(':');
    const formattedHours = parseInt(hours, 10) % 12 || 12; // Convert 24-hour format to 12-hour format
    const period = parseInt(hours, 10) < 12 ? 'AM' : 'PM';

    return `${formattedHours}:${minutes} ${period}`;
}




async function createEvent(eventData) {
    let responses = [];

    // Check if eventData is valid
    if (!eventData || !eventData.eventName) {
        console.log('Invalid eventData:', eventData);
        return responses;
    }

    try {
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

        const existingEvent = await findExistingEvent(eventName);
        if (existingEvent) {
            // Display alert if an event with the same eventName already exists
            alert(`An event with the name "${eventName}" already exists in your Google Calendar.`);
            return responses;
        }

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
    } catch (err) {
        console.log('Error: ' + err.message);
        return responses;
    }

    return responses;
}

async function findExistingEvent(eventName) {
    try {
        const request = {
            'calendarId': 'primary',
            'q': eventName,
            'singleEvents': true,
            'orderBy': 'startTime',
        };

        const response = await gapi.client.calendar.events.list(request);
        const events = response.result.items;

        return events.length > 0 ? events[0] : null;
    } catch (err) {
        console.error('Error finding existing event:', err.message);
        return null;
    }
}




async function listLocalEvents() {
    try {
         // Set timeMin to the beginning of the year before the current year
         const currentTime = new Date();
         const beginningOfPreviousYear = new Date(currentTime.getFullYear() - 1, 0, 1, 0, 0, 0);
         
        const localEvents = await gapi.client.calendar.events.list({
            'calendarId': 'primary',
            'timeMin': beginningOfPreviousYear.toISOString(),
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

function handleEventClick(info) {
    console.log('info.event:', info.event);
    
}

let currentView = null;
let fullCalendarInstance;
async function handleCreateAndListClick() {
    destroyCurrentView();


    // Remove the existing #localContent element
    const localContentElement = document.getElementById('localContent');
    if (localContentElement) {
       localContentElement.parentNode.removeChild(localContentElement);
    }
    // if (fullCalendarInstance) {
    //     fullCalendarInstance.fullCalendar('destroy');
    // }

      // Create a new container for FullCalendar
    const newLocalContentElement = document.createElement('div');
    newLocalContentElement.id = 'localContent';
    document.body.appendChild(newLocalContentElement);

//     const newLocalContentElement = $('<div id="localContent"></div>').appendTo('body');
//   // Remove the #localContent element from the DOM
//   const localContentElement = document.getElementById('localContent');
//   localContentElement.parentNode.removeChild(localContentElement);

//    // Recreate the #localContent element
//    const newLocalContentElement = document.createElement('div');
//    newLocalContentElement.id = 'localContent';
//    document.body.appendChild(newLocalContentElement);

    // Recall the function to list local events
    await listLocalEvents().then((localEvents) => {
        // Display local events in the HTML
        displayLocalEvents(localEvents, 'localContent');
        currentView = 'calendar';
    });

    // List local events
    const localEvents = await listLocalEvents();
    console.log('Local events:', localEvents);

    // Display local events in the HTML
    displayLocalEvents(localEvents,'localContent');
    currentView = 'calendar';
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
        
    });
}


// Function to destroy the current view
function destroyCurrentView() {
    if (currentView === 'table') {
        // Destroy the table 
        destroyTable();
    } else if (currentView === 'calendar') {
        // Destroy the FullCalendar instance
        destroyCalendarInstance('localContent');
    }

    // Reset the current view
    currentView = null;
}

// Function to destroy the table
function destroyTable() {
    const tableElement = document.getElementById('content');
    if (tableElement) {
        tableElement.innerHTML = ''; // Remove the table content
    }
}

function destroyCalendarInstance() {
    const fullCalendarInstance = document.getElementById('localcontent');
if (fullCalendarInstance) {
    fullCalendarInstance.innerHTML = '';;
    }
}

function redirectToEventDate(eventDate) {
    const localCalendar = $('#localContent').fullCalendar();

    // Format the date using moment.js (make sure to include the moment.js library)
    const formattedDate = moment(eventDate).format('YYYY-MM-DD');

    // Automatically switch to 'agendaDay' view for the clicked date
    localCalendar.fullCalendar('changeView', 'agendaDay');
    localCalendar.fullCalendar('gotoDate', formattedDate);
}



async function showBookmarks(userEmail) {
    const googleAccountEmail = await getEmail();

    const response = await fetch('http://127.0.0.1:8000/api/show-bookmarks');
    const data = await response.json();

    // Extract past and current events from the data
    const { past_events, current_events } = data;

    // Compare emails and perform actions
    if (userEmail === googleAccountEmail) {
        // Pass current_events to createEvent
        console.log ("This This This", current_events);
        if (Array.isArray(current_events)) {
            current_events.forEach(async currentEvent => {
                if (currentEvent.user_details && currentEvent.user_details.email) {
                    const userEventEmail = currentEvent.user_details.email;
        
                    // Check if the user email matches the provided userEmail
                    if (userEventEmail === userEmail) {
                        // Perform event synchronization for the specific user
                        console.log ("22222", currentEvent.event_details);
                        await createEvent(currentEvent.event_details);
                    }
                }
            });
        } else {
            console.error('Current events is not an array:', current_events.event_details);
        }
    } else {
        console.log(googleAccountEmail);
        console.log(userEmail);
        const confirmation = window.confirm(`The Google account email '${googleAccountEmail}' you selected is not the same as your local email account '${userEmail}'. Do you want to proceed anyway?`);
        if (confirmation) {
            // Proceed with the code
            if (Array.isArray(current_events)) {
                current_events.forEach(async currentEvent => {
                    if (currentEvent.user_details && currentEvent.user_details.email) {
                        const userEventEmail = currentEvent.user_details.email;
            
                        // Check if the user email matches the provided userEmail
                        if (userEventEmail === userEmail) {
                            // Perform event synchronization for the specific user
                            console.log ("22222", currentEvent.event_details);
                            await createEvent(currentEvent.event_details);
                        }
                    }
                });
            } else {
                console.error('Current events is not an array:', current_events.event_details);
            }
        } else {
            // Cancel execution
            console.log("User canceled the operation");
        }
    }
}
 

async function listBookmarks(userEmail) {
    const googleAccountEmail = await getEmail();

    const response = await fetch('http://127.0.0.1:8000/api/show-bookmarks');
    const data = await response.json();

    // Extract past and current events from the data
    const { past_events, current_events } = data;

    // Compare emails and perform actions
    if (userEmail === googleAccountEmail) {
        // Pass current_events to createEvent
        console.log ("This This This", current_events);
        if (Array.isArray(current_events)) {
            current_events.forEach(async currentEvent => {
                if (currentEvent.user_details && currentEvent.user_details.email) {
                    const userEventEmail = currentEvent.user_details.email;
        
                    // Check if the user email matches the provided userEmail
                    if (userEventEmail === userEmail) {
                        destroyCurrentView();
                        // Perform event synchronization for the specific user
                        console.log ("22222", currentEvent.event_details);
                        await listUpcomingEvents(currentEvent.event_details);
                        currentView = 'table';
                    }
                }
            });
        } else {
            console.error('Current events is not an array:', current_events.event_details);
        }
    } else {
        console.log(googleAccountEmail);
        console.log(userEmail);
        const confirmation = window.confirm(`The Google account email '${googleAccountEmail}' you selected is not the same as your local email account '${userEmail}'. Do you want to proceed anyway?`);
        if (confirmation) {
            // Proceed with the code
            if (Array.isArray(current_events)) {
                current_events.forEach(async currentEvent => {
                    if (currentEvent.user_details && currentEvent.user_details.email) {
                        const userEventEmail = currentEvent.user_details.email;
            
                        // Check if the user email matches the provided userEmail
                        if (userEventEmail === userEmail) {
                            destroyCurrentView();
                            // Perform event synchronization for the specific user
                            console.log ("22222", currentEvent.event_details);
                            return listUpcomingEvents(currentEvent.event_details);
                            currentView = 'table';
                        }
                    }
                });
            } else {
                console.error('Current events is not an array:', current_events.event_details);
            }
        } else {
            // Cancel execution
            console.log("User canceled the operation");
        }
    }
}

