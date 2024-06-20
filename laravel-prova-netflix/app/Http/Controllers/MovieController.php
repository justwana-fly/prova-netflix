<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;

class MovieController extends Controller
{
    protected $tmdbService;

    // Inietta il servizio TMDb nel controller tramite il costruttore
    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    // Metodo per mostrare i film popolari
    public function index()
    {
        // Utilizza il servizio TMDb per ottenere i film popolari
        $movies = $this->tmdbService->getPopularMovies();
        // Passa i dati dei film alla vista
        return view('movies.index', ['movies' => $movies['results']]);
    }

    // Metodo per cercare film
    public function search(Request $request)
    {
        // Recupera il parametro di ricerca dalla richiesta
        $query = $request->input('query');
        // Utilizza il servizio TMDb per cercare i film
        $movies = $this->tmdbService->searchMovies($query);
        // Passa i dati dei film alla vista
        return view('movies.index', ['movies' => $movies['results']]);
    }
}
