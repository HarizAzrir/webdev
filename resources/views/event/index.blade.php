<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto px-6 sm:px-8 md:px-10 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col sm:flex-row">
                    <!-- First Section - Event Image -->
                    
                    <div class="sm:w-1/2">
                        <img src="{{ $event->getImageURL() }}" alt="Event Image" class="w-full h-auto rounded-lg">
                    </div>

                    <!-- Add the bookmark button here -->
                    <form method="post" enctype="multipart/form-data" action="{{ route('event.bookmark',['event' => $event]) }}">
                        @csrf
                        <button type="submit" class="border-2 rounded-lg p-2.5 text-center inline-flex items-center me-2 transition duration-300" 
                            style="background-color: #8B5CF6;" 
                            onmouseover="this.style.backgroundColor='#FECACA'" 
                            onmouseout="this.style.backgroundColor='#8B5CF6'"
                            onclick="toggleBookmark(this)">
                            <img id="bookmarkIcon" src="{{ asset('images/bookmark_white.png') }}" alt="Bookmark Icon" class="w-5 h-5">
                            <span class="sr-only">Bookmark</span>
                        </button>
                    </form>


                    <!-- Second Section - Slider with Event and Club Details -->
                    <div class="sm:w-1/2 p-4">
                        <!-- Buttons to switch between Event and Club details -->
                        <div class="flex space-x-4 mt-4">
                            <button type="button" onclick="showEventDetails()" class="bg-blue-500 text-white py-2 px-4 rounded-md">Show Event Details</button>
                            <button type="button" onclick="showClubDetails()" class="bg-green-500 text-white py-2 px-4 rounded-md">Show Club Details</button>
                        </div>

                        

                        <br>

                        <div id="eventClubSlider" class="relative">
                            <!-- Slide 1: Event Details -->
                            <div class="slide" id="eventSlide">
                                <h1 class="text-2xl font-semibold mb-4">{{ $event->eventName }}</h1>
                                
                                <!-- Label and Input for Date Start -->
                                <div class="mb-4">
                                    <label for="dateStart" class="block text-sm font-medium leading-6 text-gray-900">Date Start</label>
                                    <input type="text" name="dateStart" id="dateStart" value="{{ $event->date_start_formatted }}" readonly class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
                                </div>

                                <!-- Label and Input for Date End -->
                                <div class="mb-4">
                                    <label for="dateEnd" class="block text-sm font-medium leading-6 text-gray-900">Date End</label>
                                    <input type="text" name="dateEnd" id="dateEnd" value="{{ $event->date_end_formatted }}" readonly class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
                                </div>

                                <!-- Label and Input for Time -->
                                <div class="mb-4">
                                    <label for="time" class="block text-sm font-medium leading-6 text-gray-900">Time</label>
                                    <div class="flex">
                                        <input type="text" name="timeStart" id="timeStart" value="{{ $event->time_start_formatted }}" readonly class="block w-16 rounded-md border-0 py-1.5 pl-2 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="00:00">
                                        <span class="mx-2">-</span>
                                        <input type="text" name="timeEnd" id="timeEnd" value="{{ $event->time_end_formatted }}" readonly class="block w-16 rounded-md border-0 py-1.5 pl-2 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="00:00">
                                    </div>
                                </div>

                                <!-- Label and Input for Venue -->
                                <div class="mb-4">
                                    <label for="venue" class="block text-sm font-medium leading-6 text-gray-900">Venue</label>
                                    <input type="text" name="venue" id="venue" value="{{ $event->venue }}" readonly class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Venue">
                                </div>

                                <!-- Label and Input for Category -->
                                <div class="mb-4">
                                    <label for="category" class="block text-sm font-medium leading-6 text-gray-900">Category</label>
                                    <input type="text" name="category" id="category" value="{{ $event->category }}" readonly class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Category">
                                </div>

                                <!-- Label and Input for Price -->
                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                                    <div class="relative mt-3 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">RM</span>
                                        </div>
                                        <input type="text" name="price" id="price" value="{{ $event->price }}" readonly class="block w-full rounded-md border-0 py-1.5 pl-12 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
                                    </div>
                                </div>
                                

                                <!-- Label and Input for Description -->
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                                    <textarea name="description" id="description" readonly class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Event description">{{ $event->description }}</textarea>
                                </div>
                                                                <!-- ... (event details) ... -->
                                @if(auth()->user()->usertype === 'president')
                                    @php
                                        $userClubId = optional(auth()->user()->club)->id; // Get the club_id of the authenticated user
                                    @endphp

                                    @if($userClubId && $userClubId === $event->club_id)
                                        <div class="flex justify-end mt-4">
                                            <form method="get" enctype="multipart/form-data" action="{{ route('event.edit',['event' => $event]) }}">
                                                <button class="bg-purple-500 text-white py-2 px-4 rounded-md">Edit Page</button>
                                            </form>
                                        </div>
                                    @endif
                                @endif

                            </div>

                            <!-- Slide 2: Club Details -->
                            <div class="slide" id="clubSlide" style="display: none;">

                            <div class="sm:w-1/2">
                               <img src="{{ $event->club->getImageURL() }}" alt="Event Image" class="w-full h-auto rounded-lg">

                            </div>



                                <h1 class="text-2xl font-semibold mb-4">About {{ $event->club->clubname }}</h1>
                                <!-- Display Club Name -->
                                <div class="mb-4">
                                    <label for="club" class="block text-sm font-medium leading-6 text-gray-900">Club</label>
                                    <input type="text" name="club" id="club" value="{{ $event->club->clubname ?? 'N/A' }}" readonly class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Club">
                                </div>

                                <!-- Display Club Information -->
                                <div class="mb-4">
                                    <label for="club" class="block text-sm font-medium leading-6 text-gray-900">About Organiser</label>
                                    <input type="text" name="club" id="club" value="{{ $event->club->about ?? 'N/A' }}" readonly class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Club">
                                </div>

                                <!-- Display Contact -->
                                <div class="mb-4">
                                    <label for="club" class="block text-sm font-medium leading-6 text-gray-900">Visit Us</label>
                                    <input type="text" name="club" id="club" value="{{ $event->club->instagram ?? 'N/A' }}" readonly class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Club">
                                </div>

                                <div class="mb-4">
                                    <label for="club" class="block text-sm font-medium leading-6 text-gray-900">Contact</label>
                                    <input type="text" name="club" id="club" value="{{ $event->club->contact_number ?? 'N/A' }}" readonly class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Club">
                                </div>

                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showEventDetails() {
            const eventSlide = document.getElementById('eventSlide');
            const clubSlide = document.getElementById('clubSlide');

            eventSlide.style.display = 'block';
            clubSlide.style.display = 'none';
        }

        function showClubDetails() {
            const eventSlide = document.getElementById('eventSlide');
            const clubSlide = document.getElementById('clubSlide');

            eventSlide.style.display = 'none';
            clubSlide.style.display = 'block';
        }

        function toggleBookmark(button) {
            const icon = document.getElementById('bookmarkIcon');
            const isBookmarked = document.getElementById('bookmarkStatus').value === 'bookmarked';

            if (isBookmarked) {
                icon.src = "{{ asset('images/bookmark_white.png') }}";
                document.getElementById('bookmarkStatus').value = 'not-bookmarked';
                button.style.backgroundColor = '#8B5CF6';
            } else {
                icon.src = "{{ asset('images/bookmark_black.png') }}";
                document.getElementById('bookmarkStatus').value = 'bookmarked';
                button.style.backgroundColor = '#FECACA';
            }
        }
    </script>
</x-app-layout>
