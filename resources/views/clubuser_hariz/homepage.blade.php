<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clubs & Societies') }}
        </h2>
    </x-slot>
    @vite('resources/css/app.css')
    <!-- Add this to the <head> section -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative">
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

            <!-- Swiper Container -->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($clubs as $club)
                        <div class="swiper-slide">
                        <a href="{{ route('clubuser_hariz.clubdetail', ['club' => $club]) }}">
                            <div class="flex flex-col items-center p-4">
                                <img class="inline mb-2" src="{{ $club->getImageURL() }}" alt="{{ $club->clubname }}"
                                    style="max-width: 20%; height: auto;">
                                <span class="py-2">{{ $club->clubname }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Add Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Add Pagination if needed -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>



    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 10,
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


</x-app-layout>
