<!-- resources/views/club-president/dashboard.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Club President Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto flex flex-col md:flex-row space-x-4">
            <div class="w-full md:w-2/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                    <h3 class="text-lg font-semibold mb-4">Basic Statistics</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                        <!-- Total Events Card -->
                        <div class="bg-blue-200 p-4 rounded-md shadow-md">
                            <p class="text-xl font-semibold text-blue-800">Total Events</p>
                            <p class="text-3xl font-bold">{{ $eventCount }}</p>
                        </div>

                        <!-- Add more statistics cards as needed -->
                    </div>

                    <h3 class="text-lg font-semibold mb-4 mt-8">Club Information</h3>
                    @if($club)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Club Name Card -->
                            <div class="bg-green-200 p-4 rounded-md shadow-md">
                                <p class="text-lg font-semibold text-green-800">Club Name</p>
                                <p class="text-l font-bold">{{ $club->clubname }}</p>
                            </div>

                            <!-- President Name Card -->
                            <div class="bg-yellow-200 p-4 rounded-md shadow-md">
                                <p class="text-lg font-semibold text-yellow-800">President Name</p>
                                <p class="text-l font-bold">{{ $club->president->name }}</p>
                            </div>

                            <!-- President Email Card -->
                            <div class="bg-orange-200 p-4 rounded-md shadow-md">
                                <p class="text-lg font-semibold text-orange-800">President Email</p>
                                <p class="text-l font-bold">{{ $club->president->email }}</p>
                            </div>

                            <!-- Add more club information cards as needed -->
                        </div>
                    @else
                        <p>No club information available</p>
                    @endif
                    <div class="mt-4">
                        <a href="{{ route('eventPresident.edit', ['club' => $club]) }}" class="py-2 px-4 bg-blue-500 text-white rounded-md">Edit Club Information</a>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Section -->
            <div class="w-full md:w-1/3 mt-6 md:mt-0">
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
    </div>

    <div class="container mx-auto flex flex-col md:flex-row space-x-4">
            <div class="w-full">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="text-center">
                    <h1 class="font-bold text-4xl mb-4">{{ $club->clubname }}</h1>
                    <h1 class="text-3xl">List of Events</h1>
                </div>
                <!-- ✅ Grid Section - Starts Here 👇 -->
<section id="Projects"
    class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">
    <!-- Loop through each event in the collection -->
    @foreach($events as $event)
    <!-- Product card starts here #-->
        <div class="w-72 bg-gradient-to-tr from-[#FFF6E6] via-[#FFDAE7] to-[#C2CCFF] shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
            <a href="{{ route('event.index', ['event' => $event->id]) }}">
                <!-- Use the event's image URL or fallback to a default image -->
                <img src="{{ $event->image }}"
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
<!-- ✅ Grid Section - Ends Here 👆 -->
</x-app-layout>
