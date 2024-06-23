<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $movie['title'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-wrap">
                        <div class="w-full lg:w-1/2">
                            <h1>{{ $movie['title'] }}</h1>
                            <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}">
                            <p>{{ $movie['overview'] }}</p>
                            <p><strong>Original Language:</strong> {{ $movie['original_language'] }}</p>
                            <p><strong>Director:</strong> 
                                @foreach($movie['credits']['crew'] as $crew)
                                    @if($crew['job'] == 'Director')
                                        {{ $crew['name'] }}
                                    @endif
                                @endforeach
                            </p>
                            <p><strong>Cast:</strong> 
                                @foreach($movie['credits']['cast'] as $actor)
                                    {{ $actor['name'] }}@if (!$loop->last), @endif
                                @endforeach
                            </p>
                        </div>
                        <div class="w-full lg:w-1/2 lg:pl-6 mt-6 lg:mt-0">
                            @php
                                $videoKey = '';
                                if (isset($movie['videos']['results']) && !empty($movie['videos']['results'])) {
                                    foreach($movie['videos']['results'] as $video) {
                                        if($video['type'] == 'Trailer') {
                                            $videoKey = $video['key'];
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            @if($videoKey)
                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{ $videoKey }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @else
                                <p>No trailer available</p>
                            @endif
                            @if(isset($movie['full_video_url']) && $movie['full_video_url'])
                                <video width="100%" height="400" controls>
                                    <source src="{{ $movie['full_video_url'] }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <p>No full movie available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
