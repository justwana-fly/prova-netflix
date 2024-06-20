<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

// Rotta principale che reindirizza alla pagina dei film popolari
Route::get('/', [MovieController::class, 'index'])->name('movies.index');

// Modifica la rotta dashboard per reindirizzare alla pagina dei film popolari
Route::get('/dashboard', function () {
    return redirect()->route('movies.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotte protette da autenticazione per il profilo utente
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotte per i film popolari
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');

require __DIR__.'/auth.php';
