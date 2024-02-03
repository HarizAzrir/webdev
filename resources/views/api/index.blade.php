<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Calendar API</title>
    <script>
    var userEmail =@json($email);
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('http://localhost:8000/js/google-calendar.js') }}" defer></script>
    <script src="https://apis.google.com/js/api.js" defer onload="gapiLoaded()"></script>
    <script src="https://accounts.google.com/gsi/client" defer onload="gisLoaded()"></script>
    
    <!-- Include jQuery -->
    
    <!-- Add this to the head section of your HTML -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" defer></script>

    
</head>

<style>
    
  html, nav {
    height: 100%;
    margin: 0;
     /* This allows scrolling */
   
}

html,body {
    margin-bottom: 30px;
    overflow: auto; /* This allows scrolling */
}

#content {
            /* Adjust the height of FullCalendar as needed */
            height: 100%;
            z-index: 1;
              /* Add some margin to the calendar if needed */
        }

#localContent {
            /* Adjust the height of FullCalendar as needed */
            height: 400px;
            z-index: 1;
              /* Add some margin to the calendar if needed */
        }

      p {
          font-size: 24px;
          font-weight: bold;
          margin-top: 20px;
        }

        .g {
            color: #4285F4; /* Google Blue */
        }

        .o1 {
          color: #EA4335; /* Google Red */
        }

        .o2 {
            color: #FBBC05; /* Google Yellow */
        }

        .g2 {
          color: #4285F4; /* Google Blue */
        }
        .l {
          color: #34A853; /* Google Green */
        }

        .e{
          color: #EA4335; /* Google Red */
        }

        body {
        font-family: 'Arial', sans-serif;
        background-color: #f7fafc;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
    section {
        display:none;
        margin-top: 20px;
        width: 80%;
        max-width: 600px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 15px;
    }

    h2 {
        color: #2d3748;
        margin-bottom: 10px;
    }

    nav {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    button {
        margin: 5px;
        padding: 10px 15px;
        font-size: 16px;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        color: #fff;
        transition: background-color 0.4s ease;
    }

    #signin_button {
        background-color: #4CAF50; /* Green */
    }

    #create_button {
        background-color: #008CBA; /* Blue */
    }

    #list_button {
        background-color: #f44336; /* Red */
    }

    #cre_Button {
        background-color: #FFC107; /* Yellow */
    }

    #signout_button {
        background-color: #555; /* Dark Gray */
    }

    button:hover {
        filter: brightness(1.2);
    }

    #calendar {
            max-width: 800px;
            margin: 0 auto;
        }

    .event-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .event-table th, .event-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .event-table th {
        background-color: #f2f2f2;
    }

    .event-table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .event-table .event-name {
        background-color: #e6f7ff; /* Light blue */
    }

    .event-table .start-date {
        background-color: #ffe6e6; /* Light red */
    }

    .event-table .start-time {
        background-color: #faffcb; /* Light yellow */
    }

    .event-table .end-date {
        background-color: #e6fcee; /* Light green */
    }

    .event-table .end-time {
        background-color: #ffd9b3; /* Light orange */
    }
</style>


<body>
    <h1><span class="g">G</span><span class="o1">o</span><span class="o2">o</span><span class="g2">g</span><span class="l">l</span><span class="e">e</span> Calendar API</h1>
    <div id="timer">Time remaining: <span id="timerValue">1:00:00</span></div>
    
    <nav>
    <button id="signin_button" onclick="handleAuthClick()">Sign In</button>
    <button id="list_button" onclick="listBookmarks( userEmail)">Show Upcoming Events in your local profile </button>
    <button id="createAndList_button" onclick="handleCreateAndListClick()">Sync and show your simplified calendar</button>
    <button id="showbookmarks_button" onclick="showBookmarks( userEmail)">Upload ongoing bookmarked events</button>
    <button id="signout_button" onclick="handleSignoutClick()">Sign Out</button>
    </nav>
    
    <p>Local account: {{ $email }}</p>
    

   
    
    <script>
        document.getElementById('signin_button').style.visibility = 'hidden';
        document.getElementById('signout_button').style.visibility = 'hidden';
        document.getElementById('list_button').style.visibility = 'hidden';
        document.getElementById('createAndList_button').style.visibility = 'hidden';
        document.getElementById('showbookmarks_button').style.visibility = 'hidden';
        document.addEventListener("DOMContentLoaded", function() {
            gapiLoaded();
            gisLoaded();
        });
    </script>

    </div>

    <div id="content"></div>
    <div id="localContent"></div>


  

</body>


</html>
