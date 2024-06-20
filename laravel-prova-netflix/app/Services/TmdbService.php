<?php

namespace App\Services;

use GuzzleHttp\Client;

class TmdbService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        // Crea un'istanza del client Guzzle per effettuare richieste HTTP
        $this->client = new Client([
            'verify' => false,  // Disabilita la verifica del certificato SSL
        ]);
        // Recupera la chiave API da variabili di ambiente
        $this->apiKey = env('TMDB_API_KEY');
    }

    // Metodo per ottenere i film popolari
    public function getPopularMovies()
    {
        // Effettua una richiesta GET all'endpoint "movie/popular" di TMDb
        $response = $this->client->get('https://api.themoviedb.org/3/movie/popular', [
            'query' => [
                'api_key' => $this->apiKey
            ]
        ]);

        // Decodifica la risposta JSON in un array associativo PHP
        return json_decode($response->getBody(), true);
    }

    // Metodo per cercare film
    public function searchMovies($query)
    {
        // Effettua una richiesta GET all'endpoint "search/movie" di TMDb con il parametro di ricerca
        $response = $this->client->get('https://api.themoviedb.org/3/search/movie', [
            'query' => [
                'api_key' => $this->apiKey,
                'query' => $query
            ]
        ]);

        // Decodifica la risposta JSON in un array associativo PHP
        return json_decode($response->getBody(), true);
    }
}
