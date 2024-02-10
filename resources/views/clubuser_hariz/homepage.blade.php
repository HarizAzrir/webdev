<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clubs & Societies') }}
        </h2>
    </x-slot>

    <!-- Include Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Content Section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            
                <!-- Add a title and description with improved styling -->
                <div class="text-center mb-8">
                    <h3 class="text-4xl font-extrabold text-gray-800">Explore Clubs & Societies Organizing Events</h3>
                    <p class="text-gray-600 mt-2">Discover a variety of clubs and societies that organize exciting events. Join in and become a part of engaging activities hosted by these communities.</p>
                </div>


                <!-- Add dropdown filter form -->
                <form method="get" action="{{ route('clubuser_hariz.homepage') }}" class="mb-4 flex items-center justify-end pt-10">
                    <label for="filter" class="text-gray-700 mr-2">Filter:</label>
                    <div class="relative">
                        <select id="filter" name="filter" class="border p-2 rounded-md focus:outline-none focus:ring focus:border-blue-300">
                            <option value="">All Clubs</option>
                            @foreach($allClubs as $clubId => $clubname)
                                <option value="{{ $clubId }}" @if(request('filter') == $clubId) selected @endif>{{ $clubname }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 7l3-3 3 3m0 6l-3 3-3-3"></path></svg>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white p-2 ml-2 rounded-md">Filter</button>

                    <!-- Add a button to clear the filter -->
                    <a href="{{ route('clubuser_hariz.homepage') }}" class="bg-red-500 text-white p-2 ml-2 rounded-md">Clear Filter</a>
                </form>

                @php
                    // Store club data in an array
                    $clubDataArray = $clubs->toArray();
                @endphp

               <!-- Swiper Container -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <!-- ✅ Grid Section - Starts Here 👇 -->
                        @for($i = 0; $i < min(8, count($clubDataArray)); $i++)
                            <!-- Product card starts here -->
                            <div class="swiper-slide w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 mb-4 px-2">
                                <div class="bg-white shadow-md rounded-md p-4 hover:shadow-lg">
                                    <a href="{{ route('clubuser_hariz.clubdetail', ['club' => $clubDataArray[$i]['id']]) }}">
                                      <img src="{{ $clubs[$i]->getImageURL() }}"
                                            alt="{{ $clubDataArray[$i]['clubname'] }}" class="h-60 w-full mx-auto object-cover rounded-t-md" />
    
                                        <div class="mt-4">
                                            <p class="text-sm font-semibold text-gray-600">{{ $clubDataArray[$i]['clubname'] }}</p>
                                            <div class="flex items-center">
                                                
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <!-- Product card ends here -->
                        @endfor
                        <!-- ✅ Grid Section - Ends Here 👆 -->
                    </div>
                    <!-- Swiper Navigation -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>

                    <!-- Swiper Pagination if needed -->
                    <div class="swiper-pagination"></div>
                </div>

                <!-- Initialize Swiper -->
                <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
                <script>
                    var swiper = new Swiper('.swiper-container', {
                        slidesPerView: 4,
                        slidesPerGroup: 4,
                        spaceBetween: 10,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        loop: true,
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
