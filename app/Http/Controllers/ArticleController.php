<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Article::class);

        $filters = $request->validate([
            'c' => 'nullable|exists:categories,id',
        ]);

        if (isset($filters['c'])) {
            $articles = Category::findOrFail($filters['c'])->articles()->get();
        } else {
            $articles = Article::all();
        }

        $categories = Category::all();
        return view('article.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('update', Article::class);

        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('update', Article::class);

        $request->validate([
            'title' => 'required|min:15|max:70|unique:articles,title',
            'article_photo' => 'image',
            'body' => 'required',
        ]);

        if ($request->hasFile('article_photo')) {
            $path = $request->article_photo->store('images', 'public');
        }

        $request->user()->articles()->create([
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
        Gate::authorize('update', $article);

        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);

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
            'image_url' => $path ?? $article->image_url,
            'body' => $request->get('body'),
        ]);

        return redirect()->route('article.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('destroy', $article);

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

    public function attach(Article $article, Request $request)
    {
        Gate::authorize('update', $article);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $article->categories()->attach($request->category_id);

        return back();
    }

    public function detach(Article $article, Request $request)
    {
        Gate::authorize('update', $article);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $article->categories()->detach($request->category_id);

        return back();
    }
}
