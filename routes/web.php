<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.landing');
// });

Route::get('/', [LandingController::class, 'index']);
Route::get('/post/{article}', [LandingController::class, 'article'])->name('landing.article');
Route::post('/post/{article}/comment', [CommentController::class, 'store'])->name('comment.store');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('article', ArticleController::class);
    Route::post('article/{article}/attach', [ArticleController::class, 'attach'])->name('article.attach');
    Route::patch('article/{article}/detach', [ArticleController::class, 'detach'])->name('article.detach');
    Route::resource('category', CategoryController::class);
    Route::get('download/{document}', [DocumentController::class, 'download'])->name('document.download');
    Route::delete('document/{document}', [DocumentController::class, 'destroy'])->name('document.destroy');
});

require __DIR__.'/auth.php';
