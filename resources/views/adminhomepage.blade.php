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
            <div class="flex flex-col flex-1 overflow-y-auto p-4 md:ml-24 mr-12">
        <!-- Welcome Section -->
        <h1 class="text-2xl font-bold">Welcome to the Admin Dashboard!</h1>
        <p class="mt-2 text-gray-600">You are now in the admin dashboard for event management.</p>

        <!-- Overview and Upcoming Events Section -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Overview Section -->
            <div class="col-span-3">
                <h2 class="text-xl font-bold mb-4">Overview</h2>
                <!-- Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Clubs -->
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Total Clubs</h3>
                        <p class="text-gray-600">{{$clubCount}}</p>
                    </div>
                    <!-- Total Events -->
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Total Events</h3>
                        <p class="text-gray-600">{{ $eventCount }}</p>
                    </div>
                    <!-- Total Users -->
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Total Users</h3>
                        <p class="text-gray-600">{{ $userCount }}</p>
                    </div>
                    <!-- Total Bookmarks -->
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Total Bookmarks</h3>
                        <p class="text-gray-600">{{ $bookmarkCount }}</p>
                    </div>
                </div>
                 <!-- Bar Chart Section -->
                    <div class="bg-white p-4 mt-8 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Monthly Events Overview</h2>
                    <div class="mt-6" style="max-width: 75%;">
                        <canvas id="monthlyEventsChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Section -->
            <div class="col-span-1 md:mt-11">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Upcoming Events</h3>
                    @if($upcomingEvents->count() > 0)
                        <ul class="list-disc pl-4">
                            @foreach($upcomingEvents as $upcomingEvent)
                                <li class="mb-2">
                                    <span class="text-lg font-semibold">{{ $upcomingEvent->eventName }}</span>
                                    <br>
                                    <span class="text-sm">{{ $upcomingEvent->dateStart }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No upcoming events</p>
                    @endif
                </div>
            </div>
        </div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Fetch the data from your controller
    const monthlyEventsData = {!! json_encode($monthlyEvents) !!};

    // Extract labels and data from the fetched data
    const labels = monthlyEventsData.map(month => month.month);
    const data = monthlyEventsData.map(month => month.eventCount);

    // Create a bar chart
    const ctx = document.getElementById('monthlyEventsChart').getContext('2d');
    const monthlyEventsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Monthly Events',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            maintainAspectRatio: false, // Set to false to make the chart responsive
            responsive: true // Enable responsiveness
        }
    });
</script>

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
