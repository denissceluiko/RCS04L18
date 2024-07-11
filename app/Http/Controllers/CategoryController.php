<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name',
            'color' => 'nullable',
        ]);

        Category::create($validated);

        return redirect()->route('category.index');
    }

    public function destroy(Category $category)
    {
        $category->articles()->detach();
        $category->delete();

        return redirect()->route('category.index');
    }
}
