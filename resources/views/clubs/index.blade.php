<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Add your stylesheets and scripts here -->

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<div class="flex h-screen bg-gray-100">

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


        <!-- Main Content Area -->
       <body class="font-sans antialiased bg-gray-100">
    <div class="container mx-auto p-4">
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

        <div class="overflow-x-auto">
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
</body>
    </div>
</div>

</html>
