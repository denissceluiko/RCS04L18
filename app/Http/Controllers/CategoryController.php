<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        Gate::authorize('create', Category::class);

        return view('category.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Category::class);

        $validated = $request->validate([
            'name' => 'required|unique:categories,name',
            'color' => 'nullable',
        ]);

        Category::create($validated);

        return redirect()->route('category.index');
    }

    public function destroy(Category $category)
    {
        Gate::authorize('destroy', $category);

        $category->articles()->detach();
        $category->delete();

        return redirect()->route('category.index');
    }
}
