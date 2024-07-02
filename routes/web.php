<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.landing');
// });

Route::get('/', [LandingController::class, 'index']);
Route::get('/post/{article}', [LandingController::class, 'article'])->name('landing.article');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::prefix('article')->group(function() {
    //     Route::get('/', [ArticleController::class, 'index'])->name('article.index');
    //     Route::post('/', [ArticleController::class, 'store'])->name('article.store');
    //     Route::get('/create', [ArticleController::class, 'create'])->name('article.create');
    //     Route::get('/{article}', [ArticleController::class, 'show'])->name('article.show');
    //     Route::patch('/{article}', [ArticleController::class, 'update'])->name('article.update');
    //     Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('article.edit');
    // });

    Route::resource('article', ArticleController::class);
});

require __DIR__.'/auth.php';
