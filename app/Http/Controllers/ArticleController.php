<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();

        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:15|max:70|unique:articles,title',
            'article_photo' => 'image',
            'body' => 'required',
        ]);

        if ($request->hasFile('article_photo')) {
            $path = $request->article_photo->store('images', 'public');
        }

        Article::create([
            'title' => $request->get('title'),
            'image_url' => $path ?? '',
            'body' => $request->get('body'),
        ]);

        return redirect()->route('article.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|min:15|max:70|unique:articles,title,'.$article->id,
            'article_photo' => 'image',
            'body' => 'required',
        ]);

        if ($request->hasFile('article_photo')) {
            $path = $request->article_photo->store('images', 'public');

            Storage::disk('public')->delete($article->image_url);
        }

        if ($request->hasFile('article_document')) {
            $path = $request->article_document->store('articles', 'documents');

            $article->documents()->create([
                'disk' => 'documents',
                'path' => $path,
            ]);
        }

        $article->update([
            'title' => $request->get('title'),
            'image_url' => $path ?? '',
            'body' => $request->get('body'),
        ]);

        return redirect()->route('article.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        foreach($article->documents as $document)
        {
            if (Storage::disk($document->disk)->exists($document->path)) {
                Storage::disk($document->disk)->delete($document->path);
            }

            $document->delete();
        }

        Storage::disk('public')->delete($article->image_url);
        $article->delete();

        return redirect()->route('article.index');
    }
}
