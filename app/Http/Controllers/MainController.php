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
        // récupération de tous les articles avec pagination
        $articles = Article::paginate(6);
        return view('articles', [
            'articles' => $articles
        ]);
    }
}
