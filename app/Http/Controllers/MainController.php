<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        return view('home');
    }
    public function articles()
    {
        // récupération de tous les articles
        $articles = Article::all();
        return view('articles', [
            'articles' => $articles
        ]);
    }
}
