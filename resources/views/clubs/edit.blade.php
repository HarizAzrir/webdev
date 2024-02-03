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
<body class="font-sans antialiased bg-gray-100">

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
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">Edit the Club</h1>
    <div>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
    </div>
      <form method="post" enctype="multipart/form-data" action="{{ route('clubs.update',['club' => $club]) }}" class="max-w-md">
                @csrf
                @method("put")
        <div class="mb-4">
                    <label for="clubname" class="block text-gray-700 text-sm font-bold mb-2">Club Name:</label>
                    <input type="text" name="clubname" id="clubname" placeholder="Enter Club Name"
                           value="{{ $club->clubname }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="club_nickname" class="block text-gray-700 text-sm font-bold mb-2">Club Nickname:</label>
                    <input type="text" name="club_nickname" id="club_nickname" placeholder="Enter Club Nickname"
                           value="{{ $club->club_nickname }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">President:</label>
                    <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select President</option>
                        @foreach($presidents as $president)
                            <option value="{{ $president->id }}" @if($club->user_id == $president->id) selected @endif>{{ $president->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-4">
                    <label for="about" class="block text-gray-700 text-sm font-bold mb-2">About:</label>
                    <input type="text" name="about" id="about" placeholder="Enter About"
                            value="{{ $club->about }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>


                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="text" name="email" id="email" placeholder="Enter Email"
                            value="{{ $club->email }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="instagram" class="block text-gray-700 text-sm font-bold mb-2">Club Instagram:</label>
                    <input type="text" name="instagram" id="instagram" placeholder="Enter Instagram"
                            value="{{ $club->instagram }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="contact_number" class="block text-gray-700 text-sm font-bold mb-2">Contact Number:</label>
                    <input type="text" name="contact_number" id="contact_number" placeholder="Enter Contact Number"
                            value="{{ $club->contact_number }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Add similar styling for other form fields -->

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Profile Picture:</label>
                    <input type="file" name="image" id="image"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <input type="submit" value="Save the new club"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                </div>
            </form>
        </div>
    </div>
</div>

</body>

</html>