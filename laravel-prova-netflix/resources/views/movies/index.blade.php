<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Popular Movies') }}
        </h2>
    </x-slot>

    <div class="py-0">
        <div class="max-w-full mx-auto sm:px-0 lg:px-0">
            <div class="bg-black dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-none">
                <div class="text-gray-900 dark:text-gray-100" style="padding:0;">
                    @if(!empty($movies))
                        <div class="jumbotron text-white bg-dark position-relative" style="padding:0;">
                            @foreach($movies as $index => $movie)
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
                                    <iframe class="movie-trailer"
                                            src="https://www.youtube.com/embed/{{ $videoKey }}?enablejsapi=1&controls=0&showinfo=0&modestbranding=1&rel=0&autoplay=1&mute=0"
                                            frameborder="0"
                                            allowfullscreen
                                            style="display:none;"
                                            data-title="{{ $movie['title'] }}"
                                            data-url="{{ route('movies.show', $movie['id']) }}">
                                    </iframe>
                                @endif
                            @endforeach
                            <p id="no-trailer" class="text-center" style="display: none;">Nessun trailer disponibile</p>
                            <button class="arrow arrow-left" onclick="prevTrailer()">&#9664;</button>
                            <button class="arrow arrow-right" onclick="nextTrailer()">&#9654;</button>
                            <div class="movie-info" id="movie-info">
                                <h1 id="movie-title"></h1>
                                <a href="#" id="movie-link">View Details</a>
                            </div>
                        </div>
                        <div class="volume-control text-white text-center mt-2">
                            <label for="volume">Volume:</label>
                            <input type="range" id="volume" name="volume" min="0" max="100" value="100">
                        </div>
                    @endif

                    <h1>Popular Movies</h1>
                    <form action="{{ route('movies.search') }}" method="GET" class="mb-4">
                        <input type="text" name="query" placeholder="Search for a movie" class="p-2 border rounded">
                        <button type="submit" class="p-2 bg-blue-500 text-white rounded">Search</button>
                    </form>
                    <div class="row">
                        @foreach($movies as $movie)
                            <div class="col-md-3 mb-4">
                                <div class="card bg-dark text-white h-100">
                                    <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" class="card-img-top" alt="{{ $movie['title'] }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $movie['title'] }}</h5>
                                        <p class="card-text">{{ \Illuminate\Support\Str::limit($movie['overview'], 100) }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('movies.show', $movie['id']) }}" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var trailers = document.querySelectorAll('.movie-trailer');
            var currentTrailer = 0;
            var players = [];
            var volumeControl = document.getElementById('volume');
            var movieInfo = document.getElementById('movie-info');
            var movieTitle = document.getElementById('movie-title');
            var movieLink = document.getElementById('movie-link');

            if (trailers.length === 0) {
                document.getElementById('no-trailer').style.display = 'block';
                return;
            }

            function stopAllTrailers() {
                players.forEach(player => {
                    player.stopVideo();
                });
            }

            function playTrailer(index) {
                stopAllTrailers();

                trailers.forEach((trailer, i) => {
                    trailer.style.display = i === index ? 'block' : 'none';
                });

                movieTitle.textContent = trailers[index].dataset.title;
                movieLink.href = trailers[index].dataset.url;

                if (!players[index]) {
                    players[index] = new YT.Player(trailers[index], {
                        events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange
                        }
                    });
                } else {
                    players[index].playVideo();
                }
            }

            function onPlayerReady(event) {
                event.target.playVideo();
                event.target.setVolume(volumeControl.value);
            }

            function onPlayerStateChange(event) {
                if (event.data === YT.PlayerState.ENDED) {
                    nextTrailer();
                }
            }

            volumeControl.addEventListener('input', function () {
                if (players[currentTrailer]) {
                    players[currentTrailer].setVolume(volumeControl.value);
                }
            });

            function nextTrailer() {
                currentTrailer = (currentTrailer + 1) % trailers.length;
                playTrailer(currentTrailer);
            }

            function prevTrailer() {
                currentTrailer = (currentTrailer - 1 + trailers.length) % trailers.length;
                playTrailer(currentTrailer);
            }

            window.nextTrailer = nextTrailer;
            window.prevTrailer = prevTrailer;

            if (window.YT) {
                playTrailer(currentTrailer);
            } else {
                var tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                window.onYouTubeIframeAPIReady = function () {
                    playTrailer(currentTrailer);
                };
            }
        });
    </script>
</x-app-layout>
