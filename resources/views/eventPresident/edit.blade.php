<!-- resources/views/club-president/dashboard.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Club President Dashboard') }}
        </h2>
    </x-slot>

     <!-- Content Section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
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
        <form method="post" enctype="multipart/form-data" action="{{ route('eventPresident.update',['club' => $club]) }}" class="max-w-md">
                @csrf
                @method("put")
      


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
        </div>
    </div>

</x-app-layout>
