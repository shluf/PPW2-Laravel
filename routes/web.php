<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'logout'=> true,
    'reset' => false,
    'reset' => false, 
    'verify' => false, 
    'confirm' => false 
]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buku', [BukuController::class, 'index'])->name('buku');
Route::get( '/buku/create', [BukuController::class, 'create' ])->name( 'buku.create');
Route::post('/buku', [BukuController::class, 'store' ])->name( 'buku.store');
Route::delete('/buku/{id}', [BukuController::class, 'destroy' ])->name ( 'buku.destroy');

// Route::get('/buku/review/{id}', [ReviewController::class, 'get'])->name( 'review.get');
Route::get('/buku/review/create', [ReviewController::class, 'create'])->name( 'review.create');
Route::get('/buku/review', [ReviewController::class, 'index'])->name( 'review');
Route::get('/buku/review/data', [ReviewController::class, 'data'])->name( 'review.data');
Route::post('/buku/review', [ReviewController::class, 'store'])->name( 'review.store');
Route::get('/tags/search', [ReviewController::class, 'searchTags'])->name('tags.search');


Route::put('/buku/{id}', [BukuController::class, 'update' ])->name ( 'buku.update');

Route::get( '/buku/search', [BukuController::class, 'search' ])->name( 'buku.search');

Route::delete('gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');