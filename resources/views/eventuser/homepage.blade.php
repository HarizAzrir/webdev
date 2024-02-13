<x-app-layout>  

    <div class="bg-white">
  

  
    

            <!-- source: https://github.com/mfg888/Responsive-Tailwind-CSS-Grid/blob/main/index.html -->
<div class="text-center p-10">
    <h1 class="font-bold text-4xl mb-4">Upcoming Events</h1>
    <h1 class="text-3xl">See What is Happening in MMU</h1>
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
                <img src="{{ $event->getImageURL() }}"
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
                        
                    </div>
                </div>
            </a>
        </div>
        <!-- Product card ends here -->
    @endforeach

</section>
<!-- ✅ Grid Section - Ends Here 👆 -->




<!-- credit -->
<footer class="bg-white w-full py-8">
    <div class="max-w-screen-xl px-4 mx-auto">
        <ul class="flex flex-wrap justify-between max-w-screen-md mx-auto text-lg font-light">
            <li class="my-2">
                 <a href="{{ route('home') }}" class="text-black hover:text-gray-800 dark:hover:text-gray-300 transition-colors duration-200">
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


<!-- Support Me 🙏🥰 -->
<script src="https://storage.ko-fi.com/cdn/scripts/overlay-widget.js"></script>
<script>
    kofiWidgetOverlay.draw('mohamedghulam', {
            'type': 'floating-chat',
            'floating-chat.donateButton.text': 'Support me',
            'floating-chat.donateButton.background-color': '#323842',
            'floating-chat.donateButton.text-color': '#fff'
        });
</script>
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