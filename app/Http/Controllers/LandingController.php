<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $articles = Article::all();

        return view('landing.landing', compact('articles'));
    }

    public function article(Article $article)
    {
        return view('landing.article', compact('article'));
    }
}
