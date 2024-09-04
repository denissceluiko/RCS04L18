<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class LandingArticles extends Component
{
    public function render()
    {
        $articles = Article::all();
        
        return view('livewire.landing-articles', compact('articles'));
    }
}
