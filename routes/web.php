<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/env',function(){
    dd(env('DB_DATABASE'));
});

Route::get('/hello',function(){
    return "Hello World";
});

Route::redirect('/redirect','/hello');

Route::any('/tous',function(){
    return "Est accepté pour toutes les méthodes
            get, post, put, delete, etc...";
});

Route::get('/art/{id}',function($id){
    return $id;
});

Route::get('/art/{id}/comment/{author?}',function($id, $author = 'Anonyme'){
    return "$author a écrit un commentaire sur l'article numéro : $id";
});