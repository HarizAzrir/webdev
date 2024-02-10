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
        <div class="flex flex-col flex-1 overflow-y-auto p-4 md:ml-12 mr-12">
        <!-- Welcome Section -->
        <h1 class="text-2xl font-bold">Welcome to the Admin Dashboard!</h1>
        <p class="mt-2 text-gray-600">You are now in the admin dashboard for event management.</p>


        <h1 class="text-2xl font-bold mb-4">Clubs</h1>

        @if(session()->has('success'))
        <div class="bg-green-200 p-4 mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('clubs.create') }}" class="text-blue-500">Create a Club</a>
        </div>

        <!-- Add dropdown filter form -->
        <form method="get" action="{{ route('clubs.index') }}" class="mb-4">
            <label for="filter" class="block">Filter by Name:</label>
            <select id="filter" name="filter" class="border p-2">
                <option value="">All Clubs</option>
                @foreach($allClubs as $clubId => $clubname)
                <option value="{{ $clubId }}" @if(request('filter') == $clubId) selected @endif>{{ $clubname }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white p-2 ml-2">Filter</button>
        </form>

       
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border">ID</th>
                        <th class="py-2 px-4 border">Club name</th>
                        <th class="py-2 px-4 border">Club nickname</th>
                        <th class="py-2 px-4 border">Club president</th>
                        <th class="py-2 px-4 border">About</th>
                        <th class="py-2 px-4 border">Email</th>
                        <th class="py-2 px-4 border">Instagram</th>
                        <th class="py-2 px-4 border">Contact Number</th>
                        <th class="py-2 px-4 border">Picture</th>
                        <th class="py-2 px-4 border">Edit</th>
                        <th class="py-2 px-4 border">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clubs as $club)
                    <tr>
                        <td class="py-2 px-4 border">{{ $club->id }}</td>
                        <td class="py-2 px-4 border">{{ $club->clubname }}</td>
                        <td class="py-2 px-4 border">{{ $club->club_nickname }}</td>
                        <td class="py-2 px-4 border">{{ $club->user->name }}</td>
                        <td class="py-2 px-4 border">{{ $club->about }}</td>
                        <td class="py-2 px-4 border">{{ $club->email }}</td>
                        <td class="py-2 px-4 border">{{ $club->instagram }}</td>
                        <td class="py-2 px-4 border">{{ $club->contact_number }}</td>
                        <td class="py-2 px-4 border"><img style="max-width: 100px; height: auto;"
                                src="{{ $club->getImageURL() }}" alt="Profile Picture"></td>
                        <td class="py-2 px-4 border"><a href="{{ route('clubs.edit', ['club' => $club]) }}"
                                class="text-blue-500">Edit</a></td>
                        <td class="py-2 px-4 border">
                            <form method="post" action="{{ route('clubs.destroy', ['club' => $club]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
