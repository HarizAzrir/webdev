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
                    Event
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col flex-1 overflow-y-auto">
        <!-- Top Bar -->
        <div class="flex items-center justify-between h-16 bg-white border-b border-gray-200">
            <div class="flex items-center px-4">
                <button class="text-gray-500 focus:outline-none focus:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <input class="mx-4 w-full border rounded-md px-4 py-2" type="text" placeholder="Search">
            </div>
            <div class="flex items-center pr-4">
                <button class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l-7-7 7-7m5 14l7-7-7-7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Main Content Area -->
       <body class="font-sans antialiased bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Users</h1>

        @if(session()->has('success'))
        <div class="bg-green-200 p-4 mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('useradmin.create') }}" class="text-blue-500">Create new User</a>
        </div>


        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border">Name</th>
                        <th class="py-2 px-4 border">Email</th>
                        <th class="py-2 px-4 border">Password</th>
                        <th class="py-2 px-4 border">User Type</th>
                        <th class="py-2 px-4 border">image</th>
                        <th class="py-2 px-4 border">Edit</th>
                        <th class="py-2 px-4 border">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Users as $User)
                    <tr>
                        <td class="py-2 px-4 border">{{ $User->name }}</td>
                        <td class="py-2 px-4 border">{{ $User->email }}</td>
                        <td class="py-2 px-4 border">{{ $User->password }}</td>
                        <td class="py-2 px-4 border">{{ $User->usertype }}</td>
                         <td class="py-2 px-4 border"><img style="max-width: 100px; height: auto;"
                                src="{{ $User->getImageURL() }}" alt="Profile Picture"></td>
                        <td class="py-2 px-4 border"><a href="{{ route('useradmin.edit', ['user' => $User]) }}"
                                class="text-blue-500">Edit</a></td>
                        <td class="py-2 px-4 border">
                            <form method="post" action="{{ route('useradmin.destroy', ['user' => $User]) }}">
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
