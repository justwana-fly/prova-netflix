<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

// Rotta per visualizzare i film popolari
Route::get('/', [MovieController::class, 'index'])->name('movies.index');

// Rotta per cercare i film
Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');