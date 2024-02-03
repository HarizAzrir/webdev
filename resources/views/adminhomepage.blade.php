<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Add your stylesheets and scripts here -->
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-100">

<div class="flex flex-col md:flex-row min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <div class="hidden md:flex flex-col w-64 bg-gray-800">
        <div class="flex items-center justify-center h-16 bg-gray-900">
            <span class="text-white font-bold uppercase">Admin Dashboard</span>
        </div>
        <div class="flex flex-col flex-1 overflow-y-auto">
            <nav class="flex-1 px-2 py-4 bg-gray-800">
                <a href="{{route('home')}}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Home
                </a>
                <a href="{{route('clubs.index')}}" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Clubs
                </a>
                <a href="#" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Events
                </a>

                <a href="{{route('useradmin.index')}}" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Users
                </a>

                 <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button type="submit" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Log Out
        </button>
    </form>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col flex-1 overflow-y-auto">
         <!-- Admin Dashboard -->
<div class="p-4">
    
    <!-- Welcome Section -->
    <h1 class="text-2xl font-bold">Welcome to the Admin Dashboard!</h1>
    <p class="mt-2 text-gray-600">You are now in the admin dashboard for event management.</p>

    <!-- Overview Section -->
    <div class="mt-6">
        <h2 class="text-xl font-bold mb-4">Overview</h2>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Clubs -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">Total Clubs</h3>
                <p class="text-gray-600">23</p>
            </div>

            <!-- Total Events -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">Total Events</h3>
                <p class="text-gray-600">34</p>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">Upcoming Events</h3>
                <p class="text-gray-600">6</p>
            </div>

            <!-- Recently Added Events -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">Recently Added Events</h3>
                <p class="text-gray-600">5</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="mt-6">
            <canvas id="clubEventsChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Quick Actions</h2>

        <!-- Buttons for Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Add Club Button -->
            <a href="#" class="bg-blue-500 text-white p-4 rounded-lg text-center hover:bg-blue-600">
                <span class="text-lg font-semibold">Add Club</span>
            </a>

            <!-- Add Event Button -->
            <a href="#" class="bg-green-500 text-white p-4 rounded-lg text-center hover:bg-green-600">
                <span class="text-lg font-semibold">Add Event</span>
            </a>

            <!-- Manage Users Button -->
            <a href="#" class="bg-purple-500 text-white p-4 rounded-lg text-center hover:bg-purple-600">
                <span class="text-lg font-semibold">Manage Users</span>
            </a>

            <!-- Generate Reports Button -->
            <a href="#" class="bg-orange-500 text-white p-4 rounded-lg text-center hover:bg-orange-600">
                <span class="text-lg font-semibold">Generate Reports</span>
            </a>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Recent Activities</h2>

        <!-- Activity Log -->
        <ul class="divide-y divide-gray-300">
            <li class="py-2">
                <span class="text-gray-600">User John Doe added a new event "Football Tournament."</span>
            </li>
            <li class="py-2">
                <span class="text-gray-600">Club XYZ updated their club information.</span>
            </li>
            <!-- Add more recent activities as needed -->
        </ul>


</div>
</body>
</html>
