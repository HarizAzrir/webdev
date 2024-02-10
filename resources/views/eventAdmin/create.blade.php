<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Your Admin Dashboard</title>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navigation -->
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex items-center justify-between">
            <!-- Sidebar Toggle Button -->
            <button id="sidebarToggle" class="text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            
            <div class="text-white">
                <span class="text-xl font-semibold">Admin Dashboard</span>
            </div>
        </div>
    </nav>

    <!-- Container for Sidebar and Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-gray-800 text-white w-64 min-h-screen fixed overflow-y-auto transition-transform duration-300 transform -translate-x-full md:translate-x-0 md:relative">
            <div class="p-4">
                <h2 class="text-2xl font-semibold">Dashboard</h2>
            </div>

            <!-- Sidebar Links -->
            <ul class="pl-4">
                <li>
                    <a href="{{route('home')}}" class="block py-2 px-4 text-gray-400 hover:text-white">Home</a>
                </li>
                <li>
                    <a href="{{route('clubs.index')}}" class="block py-2 px-4 text-gray-400 hover:text-white">Clubs</a>
                </li>
                <li>
                    <a href="{{route('event.admin_index')}}" class="block py-2 px-4 text-gray-400 hover:text-white">Events</a>
                </li>
                <li>
                    <a href="{{route('useradmin.index')}}" class="block py-2 px-4 text-gray-400 hover:text-white">Users</a>
                </li>
              
                        <!-- Logout Button -->
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block py-2 px-4 text-gray-400 hover:text-white">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="flex-1 ml-4 mt-8">
           <!-- Main Content -->
    <div class="flex flex-col flex-1 overflow-y-auto p-4 md:ml-24 mr-12">
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">Create an Event</h1>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form enctype="multipart/form-data" method="post" action="{{ route('event.store') }}" class="max-w-md">
                @csrf
                @method("post")


                            <!-- Second Section - Event Details Text -->
                            <div class="mb-4">
                    <label for="eventname" class="block text-gray-700 text-sm font-bold mb-2">event Name:</label>
                    <input type="text" name="eventName" id="eventName" placeholder="Enter event Name"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                                <!-- Label and Input for Date Start -->
                                <div class="mb-4">
                                    <label for="dateStart" class="block text-sm font-medium leading-6 text-gray-900">Date Start</label>
                                    <input name="dateStart" type="text" id="dateStart" value="" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
                                </div>

                                <!-- Label and Input for Date End -->
                                <div class="mb-4">
                                    <label for="dateEnd" class="block text-sm font-medium leading-6 text-gray-900">Date End</label>
                                    <input name = "dateEnd" type="text" id="dateEnd" value="" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
                                </div>

                                <!-- Label and Input for Time -->
                                <div class="mb-4">
                                    <label for="time" class="block text-sm font-medium leading-6 text-gray-900">Time</label>
                                    <div class="flex">
                                        <input type="text" name="timeStart" id="timeStart" value=""  class="block w-16 rounded-md border-0 py-1.5 pl-2 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="00:00">
                                        <span class="mx-2">-</span>
                                        <input type="text" name="timeEnd" id="timeEnd" value=""  class="block w-16 rounded-md border-0 py-1.5 pl-2 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="00:00">
                                    </div>
                                </div>


                                <!-- Label and Input for Venue -->
                                <div class="mb-4">
                                    <label for="venue" class="block text-sm font-medium leading-6 text-gray-900">Venue</label>
                                    <input type="text" name="venue" id="venue" value="Enter venue here" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Venue">
                                </div>

                                <!-- Label and Input for Category -->

                                <div class="mb-4">
                                    <label for="category" class="block text-sm font-medium leading-6 text-gray-900">Category</label>
                                    <div class="relative w-full">
                                        <select name="category" id="category" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Category">
                                            
                                            <option value="Charity" >Charity</option>
                                            <option value="Concert" >Concert</option>
                                            <option value="Workshop" >Workshop</option>
                                            <option value="Games" >Games</option>
                                            <option value="Sports" >Sports</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12l-8-8H1v17h18v-2h-8zm0-8v4h8v2h-8v4l-8-8h6V2z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="subcategory1" class="block text-sm font-medium leading-6 text-gray-900">Sub-Category</label>
                                    <div class="relative w-full">
                                        <select name="subcategory1" id="subcategory1" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Category">
                                            
                                            <option value="Charity" >Charity</option>
                                            <option value="Concert" >Concert</option>
                                            <option value="Workshop" >Workshop</option>
                                            <option value="Games" >Games</option>
                                            <option value="Sports" >Sports</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12l-8-8H1v17h18v-2h-8zm0-8v4h8v2h-8v4l-8-8h6V2z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                                    <input type="text" name="status" id="status" value="" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Status">
                                </div>
                                <!-- Label and Input for Price -->
                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                                    <div class="relative mt-3 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">RM</span>
                                        </div>
                                        <input type="text" name="price" id="price" value="Enter price here" class="block w-full rounded-md border-0 py-1.5 pl-12 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
                                    </div>
                                </div>

                                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Profile Picture:</label>
                    <input type="file" name="image" id="image"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                            <div class="mb-4">
                            <label for="club_id" class="block text-sm font-medium leading-6 text-gray-900">club_id</label>
                            <input type="integer" name="club_id" id="club_id" value="0" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="club_id">
                            </div>                

                                <!-- Label and Input for Description -->
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                                    <textarea name="description" id="description" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Event description">Description</textarea>
                                </div>

                                <div class="mb-4">
                        <input type="submit" value="Save the new event"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var textarea = document.getElementById('description');
                                        textarea.style.height = 'auto';
                                        textarea.style.height = (textarea.scrollHeight) + 'px';
                                    });

                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Initialize Flatpickr for dateStart input
                                        const dateStartInput = document.getElementById('dateStart');
                                        const dateEndInput = document.getElementById('dateEnd');

                                        flatpickr(dateStartInput, {
                                            enableTime: false,
                                            dateFormat: 'l, d F Y',
                                        });

                                        flatpickr(dateEndInput, {
                                            enableTime: false,
                                            dateFormat: 'l, d F Y',
                                        });

                                        // Add an event listener for the edit button to show the calendar
                                        editDateEndButton.addEventListener('click', function() {
                                            dateEndInput._flatpickr.open();
                                        });
                                    });

                                    document.addEventListener('DOMContentLoaded', function () {
                                        flatpickr("#timeStart, #timeEnd", {
                                            enableTime: true,
                                            noCalendar: true,
                                            dateFormat: "H:i",
                                            time_24hr: true,
                                        });
                                    });
                                    </script>
            </form>
        </div>
    </div>
</div>
</div>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Your Company. All rights reserved.</p>
        </div>
    </footer>

    <!-- JavaScript to toggle sidebar -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>
