<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;

class MovieController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function index()
    {
        $movies = $this->tmdbService->getPopularMovies();

        return view('movies.index', ['movies' => $movies['results']]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $movies = $this->tmdbService->searchMovies($query);

        return view('movies.index', ['movies' => $movies['results']]);
    }

    public function show($id)
    {
        $movie = $this->tmdbService->getMovieDetails($id);
        return view('movies.show', compact('movie'));
    }
}
