@extends('layouts.app')

@section('title', 'Popular Movies')

@section('content')
<div class="container">
    <h1>Popular Movies</h1>
    <!-- Form per cercare film -->
    <form action="{{ route('movies.search') }}" method="GET">
        <input type="text" name="query" placeholder="Search for a movie">
        <button type="submit">Search</button>
    </form>
    <div class="row">
        @foreach($movies as $movie)
            <div class="col-md-4">
                <div class="card mb-4">
                    <!-- Immagine del poster del film -->
                    <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" class="card-img-top" alt="{{ $movie['title'] }}">
                    <div class="card-body">
                        <!-- Titolo del film -->
                        <h5 class="card-title">{{ $movie['title'] }}</h5>
                        <!-- Descrizione del film (limitata a 100 caratteri) -->
                        <p class="card-text">{{ Str::limit($movie['overview'], 100) }}</p>
                        <!-- Pulsante per visualizzare i dettagli del film -->
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
