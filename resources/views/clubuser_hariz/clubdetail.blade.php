<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clubs & Societies') }}
        </h2>
    </x-slot>
    @vite('resources/css/app.css')

 <!-- clubs/show.blade.php -->
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <!-- Display club image and club nickname -->
            <div class="text-center mb-4">
<img src="{{ $club->getImageURL() }}" alt="{{ $club->clubname }}" class="w-80 mx-auto mb-2 rounded-lg">
                <p class="text-lg font-semibold">{{ $club->club_nickname }}</p>
            </div>

             <!-- Display club about text -->
            <div id="aboutSection">
                <p class="text-lg mb-6">{{ optional($club->user)->name }}</p>

                <p class="text-lg mb-6">{{ $club->about }}</p>
            </div>

            <!-- Display club events (initially hidden) -->
            <div id="eventsSection" class="hidden">
                <!-- Add events content here -->
                <p class="text-lg mb-6">Club Events</p>
            </div>

            <!-- Add buttons to switch between About and Events -->
            <div class="flex justify-center">
                <button class="bg-blue-500 text-black px-4 py-2 rounded-md mr-4" onclick="showAbout()">Show About</button>
                <button class="bg-blue-500 text-black px-4 py-2 rounded-md" onclick="showEvents()">Show Events</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showAbout() {
        document.getElementById('aboutSection').classList.remove('hidden');
        document.getElementById('eventsSection').classList.add('hidden');
    }

    function showEvents() {
        document.getElementById('aboutSection').classList.add('hidden');
        document.getElementById('eventsSection').classList.remove('hidden');
    }
</script>




</x-app-layout>