<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bookmark Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($bookmarks && $bookmarks->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bookmark ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Event ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Event Name
                                    </th>
                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($bookmarks as $bookmark)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $bookmark->bookmark_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $bookmark->event_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ optional($bookmark->event)->eventName }}
                                            <!-- Use optional() to prevent error if event is null -->
                                        </td>
                                        <!-- Add more cells for additional columns -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">No bookmarks found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
