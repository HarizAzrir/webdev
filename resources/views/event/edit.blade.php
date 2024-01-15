<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto px-6 sm:px-8 md:px-10 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                 @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
                    <form method="post" enctype="multipart/form-data" action="{{ route('event.update', ['event' => $event]) }}" class="max-w-md">
                    @csrf
                    @method("put")
                        
                        <div class="flex flex-col sm:flex-row">
                            <!-- First Section - Event Image -->
                            <div class="sm:w-1/2">
                                <img src="{{ $event->getImageURL() }}" alt="Event Image" class="w-90 h-auto rounded-lg mx-auto sm:mx-0">
                            </div>

                            <!-- Second Section - Event Details Text -->
                            <div class="sm:w-1/2 p-4">
                                <h3 class="text-2xl font-semibold mb-4">{{ $event->eventName }}</h3>

                                <!-- Label and Input for Date Start -->
                                <div class="mb-4">
                                    <label for="dateStart" class="block text-sm font-medium leading-6 text-gray-900">Date Start</label>
                                    <input name="dateStart" type="text" id="dateStart" value="{{ $event->date_start_formatted }}" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
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
                                    <input type="text" name="venue" id="venue" value="{{ $event->venue }}" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Venue">
                                </div>

                                <!-- Label and Input for Category -->

                                <div class="mb-4">
                                    <label for="category" class="block text-sm font-medium leading-6 text-gray-900">Category</label>
                                    <div class="relative w-full">
                                        <select name="category" id="category" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Category">
                                            
                                            <option value="Charity" {{ $event->category === 'Charity' ? 'selected' : '' }}>Charity</option>
                                            <option value="Concert" {{ $event->category === 'Concert' ? 'selected' : '' }}>Concert</option>
                                            <option value="Workshop" {{ $event->category === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                            <option value="Games" {{ $event->category === 'Games' ? 'selected' : '' }}>Games</option>
                                            <option value="Sports" {{ $event->category === 'Sports' ? 'selected' : '' }}>Sports</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12l-8-8H1v17h18v-2h-8zm0-8v4h8v2h-8v4l-8-8h6V2z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Label and Input for Price -->
                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                                    <div class="relative mt-3 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">RM</span>
                                        </div>
                                        <input type="text" name="price" id="price" value="{{ $event->price }}" class="block w-full rounded-md border-0 py-1.5 pl-12 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
                                    </div>
                                </div>

                                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Profile Picture:</label>
                    <input type="file" name="image" id="image"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                                <!-- Label and Input for Description -->
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                                    <textarea name="description" id="description" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Event description">{{ $event->description }}</textarea>
                                </div>

                                <div class="flex justify-end mt-4">
                                    <button class="bg-purple-500 text-white py-2 px-4 rounded-md">Save Edits</button>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var textarea = document.getElementById('description');
                                        textarea.style.height = 'auto';
                                        textarea.style.height = (textarea.scrollHeight) + 'px';
                                    });

                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Initialize Flatpickr for dateStart input
                                        const dateStartInput = document.getElementById('dateStart');
                                        const dateEndInput = document.getElementById('dateEnd');

                                        flatpickr(dateStartInput, {
                                            enableTime: false,
                                            dateFormat: 'l, d F Y',
                                        });

                                        flatpickr(dateEndInput, {
                                            enableTime: false,
                                            dateFormat: 'l, d F Y',
                                        });

                                        // Add an event listener for the edit button to show the calendar
                                        editDateEndButton.addEventListener('click', function() {
                                            dateEndInput._flatpickr.open();
                                        });
                                    });

                                    document.addEventListener('DOMContentLoaded', function () {
                                        flatpickr("#timeStart, #timeEnd", {
                                            enableTime: true,
                                            noCalendar: true,
                                            dateFormat: "H:i",
                                            time_24hr: true,
                                        });
                                    });
                                </script>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>