<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;




// contrôleur ressource
Route::resource('articles', ArticleController::class);

// pour tester un middleware par défaut (guest => non connecté)
Route::get('/test', function () {
    return response("Hello World", 200);
})->middleware('guest');

// pour tester un middleware par défaut (auth.basic => connecté basique)
Route::get('/test2', function () {
    return response("Hello World", 200);
})->middleware('auth.basic');

// pour tester un middleware fait main
Route::get('/test3', function () {
    return response("Hello World", 200);
})->middleware('custom.auth');
