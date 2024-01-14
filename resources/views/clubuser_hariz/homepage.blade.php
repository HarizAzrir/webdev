<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clubs & Societies') }}
        </h2>
    </x-slot>

    <!-- Include Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- clubs/show.blade.php -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Add dropdown filter form -->
                <form method="get" action="{{ route('clubuser_hariz.homepage') }}" class="mb-4">
                    <label for="filter" class="block">Filter:</label>
                    <select id="filter" name="filter" class="border p-2">
                        <option value="">All Clubs</option>
                        @foreach($allClubs as $clubId => $clubname)
                            <option value="{{ $clubId }}" @if(request('filter') == $clubId) selected @endif>{{ $clubname }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-500 text-black p-2 ml-2">Filter</button>

                    <!-- Add a button to clear the filter -->
                    <a href="{{ route('clubuser_hariz.homepage') }}" class="bg-red-500 text-white p-2 ml-2">Clear Filter</a>
                </form>

                @php
                    // Store club data in an array
                    $clubDataArray = $clubs->toArray();
                @endphp

               <!-- Swiper Container -->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <!-- ✅ Grid Section - Starts Here 👇 -->
            <!-- ✅ Grid Section - Starts Here 👇 -->
            @for($i = 0; $i < min(8, count($clubDataArray)); $i++)
                <!-- Product card starts here -->
                <div class="swiper-slide"> <!-- Add swiper-slide class here -->
                    <div class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                        <a href="#">
                            <!-- Use the club's image URL or fallback to a blank profile image -->
                            <img src="{{ $clubDataArray[$i]['image'] ? url('storage/' . $clubDataArray[$i]['image']) : 'images/blankprofile.png' }}"
                                alt="{{ $clubDataArray[$i]['clubname'] }}" class="h-80 w-72 object-cover rounded-t-xl" />

                            <div class="px-4 py-3 w-72">
                                <span class="text-gray-400 mr-3 uppercase text-xs">Brand</span>
                                <p class="text-lg font-bold text-black truncate block capitalize">{{ $clubDataArray[$i]['clubname'] }}</p>
                                <div class="flex items-center">
                                    <p class="text-lg font-semibold text-black cursor-auto my-3">$149</p>
                                    <del>
                                        <p class="text-sm text-gray-600 cursor-auto ml-2">$199</p>
                                    </del>
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
        slidesPerView: 4, // Display 4 slides at a time
        slidesPerGroup: 4, // Group slides in sets of 4
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        loop: true, // Enable if you want the slides to loop
    });
</script>






            </div>
        </div>
    </div>
</x-app-layout>
