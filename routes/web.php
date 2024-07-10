<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DocumentController;
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

    Route::resource('article', ArticleController::class);
    Route::get('download/{document}', [DocumentController::class, 'download'])->name('document.download');
    Route::delete('document/{document}', [DocumentController::class, 'destroy'])->name('document.destroy');
});

require __DIR__.'/auth.php';
