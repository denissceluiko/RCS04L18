<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class CreateComment extends Component
{
    public Article $article;

    public ?string $author;
    public string $body;

    public function mount()
    {
        $this->author = auth()->user()?->name;
    }

    public function save()
    {
        $validated = $this->validate([
            'author' => 'required',
            'body' => 'required',
        ]);

        $this->article->comments()->create($validated);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.create-comment');
    }
}
