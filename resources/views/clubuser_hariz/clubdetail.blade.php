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
        <!-- Add buttons to switch between About and Events -->
            <div class="flex justify-center mb-8">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md mr-4" onclick="showAbout()">Show About</button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" onclick="showEvents()">Show Events</button>
            </div>
            <!-- Display club image and club nickname -->
            <div class="text-center mb-4">
            <img src="{{ $club->getImageURL() }}" alt="{{ $club->clubname }}" class="w-80 mx-auto mb-2 rounded-lg">
                <p class="text-lg font-semibold">{{ $club->clubname }}</p>
            </div>

             <!-- Display club about text -->
            <div id="aboutSection">
                <h2 class="text-center text-xl mb-6">About</h2>
                <p class="text-center mb-6">{{ $club->about }}</p>
            </div>
            <!-- Display club events (initially hidden) -->
            <div id="eventsSection" class="hidden">
            <h2 class="text-center text-xl mb-6">List of Events</h2>
                <!-- Add events content here -->
                 <!-- ✅ Grid Section - Starts Here 👇 -->
<section id="Projects"
    class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">
    <!-- Loop through each event in the collection -->
    @foreach($club->events as $event)
    <!-- Product card starts here #-->
        <div class="w-72 bg-gradient-to-tr from-[#FFF6E6] via-[#FFDAE7] to-[#C2CCFF] shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
            <a href="{{ route('event.index', ['event' => $event->id]) }}">
                <!-- Use the event's image URL or fallback to a default image -->
                <img src="{{ $event->getImageUrl() }}"
                    alt="{{ $event->eventName }}" class="h-80 w-72 object-cover rounded-t-xl" />

                <div class="px-4 py-3 w-72">
                @php
                    $categoryColor = '';
                    switch ($event->category) {
                        case 'Charity':
                            $categoryColor = 'bg-orange-500';
                            break;
                        case 'Concert':
                            $categoryColor = 'bg-purple-500';
                            break;
                        case 'Workshop':
                            $categoryColor = 'bg-blue-500';
                            break;
                        case 'Entertainment':
                            $categoryColor = 'bg-black text-white';
                            break;
                        case 'Sports':
                            $categoryColor = 'bg-pink-500';
                            break;
                        default:
                            $categoryColor = 'bg-gray-500';
                            break;
                    }
                @endphp

                <span class="text-white font-bold mr-3 uppercase text-xs rounded-lg px-2 py-1 {{ $categoryColor }}">{{ $event->category }}</span>
                <!-- Rest of your card content -->
                    <p class="text-lg font-bold text-black truncate block capitalize">{{ $event->eventName }}</p>
                    <div class="flex items-center">
                        <p class="text-lg font-semibold text-black cursor-auto my-3">RM{{ $event->price }}</p>
                        
                        <p class="text-sm text-gray-600 cursor-auto ml-2">{{ $event->status }}</p>
                        
                        <div class="ml-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-bag-plus" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                                <path
                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Product card ends here -->
    @endforeach

</section>
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