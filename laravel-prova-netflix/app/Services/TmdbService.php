<?php

namespace App\Services;

use GuzzleHttp\Client;

class TmdbService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
        ]);
        $this->apiKey = env('TMDB_API_KEY');
    }

    public function getPopularMovies()
    {
        $response = $this->client->get('https://api.themoviedb.org/3/movie/popular', [
            'query' => [
                'api_key' => $this->apiKey,
                'append_to_response' => 'videos,credits'
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        foreach ($data['results'] as &$movie) {
            // Aggiungi un URL del video completo per esempio
            $movie['full_video_url'] = 'https://www.example.com/path/to/full/movie.mp4';
        }

        return $data;
    }

    public function getMovieDetails($movieId)
    {
        $response = $this->client->get("https://api.themoviedb.org/3/movie/{$movieId}", [
            'query' => [
                'api_key' => $this->apiKey,
                'append_to_response' => 'videos,credits'
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        // Aggiungi un URL del video completo per esempio
        $data['full_video_url'] = 'https://www.example.com/path/to/full/movie.mp4';

        return $data;
    }
}
