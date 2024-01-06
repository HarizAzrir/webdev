<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>
    @vite('resources/css/app.css')

    <style>

        body {
            margin: 0;
            background: url('{{ asset('images/EventBackground.png') }}') center/cover no-repeat fixed;
        }

        .main-container {
            display: flex;
            flex-wrap: wrap;
            background: linear-gradient(to right, #e6f7ff, #d8b4fe); /* Light blue to light purple */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 800px;
        }       

        .event-name {
            font-size: 35px; 
            font-weight: bold;
            margin-bottom: 10px;
            width: 100%;
        }

        .container-flex {
            display: flex;
            width: 100%;
            justify-content: space-between;
        }

        .image-container {
            margin-top: 10px;
            margin-right: 20px; /* Add padding between containers */
            width: 48%; 
        }

        .image-container img {
            width: 100%;
            max-width: 100%; 
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .details-container {
            background-color: #F2ECE7; /* Light yellow*/
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
            width: 48%; 
        }

        .details-container p {
            margin-bottom: 10px;
            font-size: 16px; 
            color: #333;
        }

        .details-container strong {
            font-weight: bold; 
        }

        .additional-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; /* Arrange additional details next to each other */
            padding: 20px;
            border-radius: 8px;
            margin-top: 10px;
            width: 50%; 
        }

        .additional-details p {
            font-size: 16px; 
            color: #333;
            margin: 0;
        }

        .additional-details strong {
            font-weight: bold; 
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="event-name"> {{ $event->eventName }}</div>

        <div class="container-flex">
            <div class="image-container">
                <img src="{{ asset('images/projectstellar.png') }}" alt="Event Image">
            </div>

            <div class="details-container">
                <p><strong>Date Start:</strong> {{ $event->dateStartFormatted }}</p>
                <p><strong>Date End:</strong> {{ $event->dateEndFormatted }}</p>
                <p><strong>Time :</strong> {{ $event->timeStartFormatted }} - {{ $event-> timeEndFormatted }}</p>
                <p><strong>Description:</strong> {{ $event->description }}</p>
                <p><strong>Price:</strong> RM {{ $event->price }}</p>

            </div>
        </div>

        <div class="additional-details">
            <p><strong>Category:</strong> #{{ $event->category }} #{{ $event->subcategory1 }}</p>
            <p><strong>Status:</strong> {{ $event->status }}</p>
        </div>
    </div>
</body>

</x-app-layout>
