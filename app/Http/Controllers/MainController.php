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
        // récupération de tous les articles avec pagination (paginate(int nombre de pages))
        $articles = Article::paginate(4);
        return view('articles', [
            'articles' => $articles
        ]);
    }
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        // on vérifie si on récupère bien l'article
        dd($article);
        return view('article', [
            'article' => $article
        ]);
    }
}
