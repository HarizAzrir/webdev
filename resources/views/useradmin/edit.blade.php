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
            <h1 class="text-2xl font-bold mb-4">Edit User</h1>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form enctype="multipart/form-data" method="post" action="{{ route('useradmin.update',['user' => $user]) }}" class="max-w-md">
                @csrf
                @method("put")

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text" name="name" id="name" placeholder="Enter Name"  value="{{ $user->name }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="text" name="email" id="email" placeholder="Enter Email" value="{{ $user->email }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="usertype" class="block text-gray-700 text-sm font-bold mb-2">User Type:</label>
                    <select name="usertype" id="usertype"  value="{{ $user->usertype }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" selected disabled>Select User Type</option>
                        <option value="user">User</option>
                        <option value="president">President</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>




                <!-- Add similar styling for other form fields -->

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Profile Picture:</label>
                    <input type="file" name="image" id="image"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <input type="submit" value="Save the new User"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                </div>
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
