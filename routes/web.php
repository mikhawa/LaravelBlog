<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;




// contrôleur ressource
Route::resource('articles', ArticleController::class);
