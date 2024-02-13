<x-app-layout>  

    <div class="bg-white min-h-screen flex flex-col items-center justify-center" id="navbar">
        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div class="absolute inset-x-0 top-[-20px] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20px]" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%); left: -5%;">
                </div>
            </div>


            <div class="container mx-auto px-6 flex flex-col items-center justify-center py-16 sm:flex-row">
                <div class="sm:w-2/3 lg:w-2/5 flex flex-col items-center justify-center">
                    <span class="w-20 h-2 bg-gray-800 dark:bg-white mb-12"></span>
                    <h1 class="font-bebas-neue uppercase text-6xl sm:text-8xl font-black flex flex-col leading-none dark:text-black text-gray-800">
                        Explore
                        <span class="text-5xl sm:text-7xl">
                            Excitement
                        </span>
                    </h1>
                    <p class="text-sm sm:text-base text-gray-700 dark:text-black text-center mt-4">
                        Discover a world of exciting events and activities brought to you by our vibrant club and society community. Join us in creating unforgettable moments and fostering meaningful connections on your university journey.
                    </p>
                    <div class="flex mt-8">
                       <a href="{{ route('clubuser_hariz.homepage') }}" class="uppercase py-2 px-4 rounded-lg bg-pink-500 border-2 border-transparent text-black text-md mr-4 hover:bg-pink-400">
                            Clubs
                        </a>

                        <a  href="#about-section" class="uppercase py-2 px-4 rounded-lg bg-transparent border-2 border-pink-500 text-pink-500 dark:text-black hover:bg-pink-500 hover:text-white text-md">
                            About us
                        </a>
                    </div>
                </div>
                <div class="sm:w-1/3 lg:w-3/5 relative">
                    <img src="{{ asset('storage/image/homepage.jpg') }}" class="max-w-full h-auto md:max-w-screen-md m-auto"/>
                </div>

            </div>
        </div>

<section class="py-8 bg-white-100 md:py-16">
    <div class="box-content max-w-5xl px-5 mx-auto">
        <div class="flex flex-col items-center -mx-5 md:flex-row">
            <div class="w-full px-5 mb-5 text-center md:mb-0 md:text-left">
                <h6 class="text-xs font-semibold text-indigo-800 uppercase md:text-base">
                    Upcoming Event
                </h6>
               <h3 class="text-2xl font-bold text-black font-heading md:text-4xl">
                    @if(isset($closestEvent))
                        {{$closeeventname }}
                    @else
                        No upcoming events
                    @endif
                </h3>

                <h3 id="countdown" class="text-lg font-bold leading-tight text-black font-heading md:text-xl">
                   @if(isset($closestEvent))
                      {{ \Carbon\Carbon::parse($eventDate)->format('l, F j') }}

                    @else
                        No upcoming events
                    @endif
                </h3>

                <div class="w-full mt-4 md:w-44">
<a href="{{ route('event.index', ['event' => $closestEvent->id]) }}">
                    <button type="button" class="py-2 px-4  bg-white hover:bg-gray-100 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-500 text-black w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                        Early bird
                    </button>
                    </a>
                </div>
            </div>
            <div class="w-full px-5 md:w-auto">
                <div class="flex justify-center text-center text-black">
                    <!-- Countdown Timer -->
                    <div id="days" class="w-20 py-3 mx-2 border rounded-lg md:w-24 border-light-300 bg-light-100 md:py-4">
                        <div class="text-2xl font-semibold md:text-3xl"></div>
                        <div class="mt-3 text-xs uppercase">Day</div>
                    </div>
               
                    <div id="hours" class="w-20 py-3 mx-2 border rounded-lg md:w-24 border-light-300 bg-light-100 md:py-4">
                        <div class="text-2xl font-semibold md:text-3xl"></div>
                        <div class="mt-3 text-xs uppercase opacity-75">Hour</div>
                    </div>
                    <div id="minutes" class="w-20 py-3 mx-2 border rounded-lg md:w-24 border-light-300 bg-light-100 md:py-4">
                        <div class="text-2xl font-semibold md:text-3xl"></div>
                        <div class="mt-3 text-xs uppercase opacity-75">Min</div>
                    </div>
                    <div id="seconds" class="w-20 py-3 mx-2 border rounded-lg md:w-24 border-light-300 bg-light-100 md:py-4">
                        <div class="text-2xl font-semibold md:text-3xl"></div>
                        <div class="mt-3 text-xs uppercase opacity-75">Second</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    @if($closestEvent)
        // Set the date of the closest upcoming event
        var eventDate = "{{ \Carbon\Carbon::parse($eventDate)->format('Y-m-d') }}";

                // Convert the date string to a Date object
        var countDownDate = new Date(eventDate).getTime();

    @else
        // Set a default date or handle the case when there are no upcoming events
        var countDownDate = new Date("Feb 17, 2024 10:00:00").getTime();
    @endif

    // Update the countdown every 1 second
    var x = setInterval(function() {
        // Get the current date and time
        var now = new Date().getTime();

        // Calculate the remaining time
        var distance = countDownDate - now;

        // Calculate days, hours, minutes, and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the countdown in the element with id="countdown"
        document.getElementById("days").innerHTML = (days < 10) ? '0' + days : days ;
        document.getElementById("hours").innerHTML = (hours < 10) ? '0' + hours : hours;
        document.getElementById("minutes").innerHTML = (minutes < 10) ? '0' + minutes : minutes;
        document.getElementById("seconds").innerHTML = (seconds < 10) ? '0' + seconds : seconds;

        // If the countdown is over, display a message
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
</section>

        <div class="text-center p-10">
            <h1 class="font-bold text-4xl mb-4">Explore Exciting Events at MMU</h1>
            <h1 class="text-3xl">Discover the Diverse Range of Clubs</h1>
        </div>

@php
    // Store club data in an array
    $eventdataArray = $events->toArray();
@endphp

<!-- ✅ Grid Section - Starts Here 👇 -->
<section id="Projects"
    class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">

    <!-- Loop through each club in the array -->
    @foreach($eventdataArray as $event)
        <!-- Product card starts here -->
        <div class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
             <a href="{{ route('event.index', ['event' => $event['id']]) }}">
                <!-- Use the club's image URL or fallback to a blank profile image -->
                <img src="{{ $event['image'] ? url('storage/' . $event['image']) : 'images/blankprofile.png' }}"
                    alt="{{ $event['eventName'] }}" class="h-80 w-72 object-cover rounded-t-xl" />

                    <div class="px-4 py-3 w-72">
            
                    <p class="text-lg font-bold text-black truncate block capitalize">{{ $event['eventName'] }}</p>
                
                </div>
            </a>
        </div>
        <!-- Product card ends here -->
    @endforeach

</section>
<!-- ✅ Grid Section - Ends Here 👆 -->


<div class="sm:flex items-center max-w-screen-xl">
    <div class="sm:w-1/2 p-10">
        <div class="image object-center text-center">
            <img src="{{ asset('storage/image/aboutus.png') }}">
        </div>
    </div>
    <div class="sm:w-1/2 p-5" id="about-section">
        <div class="text">
            <span class="text-gray-500 border-b-2 border-indigo-600 uppercase">About us</span>
            <h2 class="my-4 font-bold text-3xl  sm:text-4xl ">About <span class="text-indigo-600">About us</span>
            </h2>
           <p class="text-black">
   <p class="text-black">
    Discover and join a variety of engaging events on our campus platform. From academic sessions to social gatherings, Our Event Management Plaform brings you closer to a vibrant university experience. Explore, connect, and make the most of your time with us!
</p>
</p>
        </div>
    </div>
</div>


<!-- credit -->
<footer class="bg-white w-full py-8">
    <div class="max-w-screen-xl px-4 mx-auto">
        <ul class="flex flex-wrap justify-between max-w-screen-md mx-auto text-lg font-light">
            <li class="my-2">
                 <a href="#navbar" class="text-black hover:text-gray-800 dark:hover:text-gray-300 transition-colors duration-200">
                    Homepage
                </a>
            </li>
            <li class="my-2">
                <a class="text-black hover:text-gray-800 dark:hover:text-gray-300 transition-colors duration-200" href="https://github.com/HarizAzrir">
                    Github
                </a>
            </li>
            <li class="my-2">
                <a class="text-black hover:text-gray-800 dark:hover:text-gray-300 transition-colors duration-200" href="https://www.linkedin.com/in/hariz-azrir-3478b4207/">
                    LinkedIn
                </a>
            </li>
        </ul>
    </div>
</footer>



            <!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->
        </div>
         <script src="chrome-extension://kgejglhpjiefppelpmljglcjbhoiplfn/shadydom.js"></script>
        <script>
            if (!window.ShadyDOM) window.ShadyDOM = { force: true, noPatch: true };
        </script>
    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
      <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
      
    </div>
  </div>
</div>
</x-app-layout>