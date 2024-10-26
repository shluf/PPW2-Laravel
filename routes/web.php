<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'logout'=> false,
    'reset' => false,
    'reset' => false, 
    'verify' => false, 
    'confirm' => false 
]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buku', [BukuController::class, 'index']);
Route::get( '/buku/create', [BukuController::class, 'create' ])->name( 'buku.create');
Route::post('/buku', [BukuController::class, 'store' ])->name( 'buku.store');
Route::delete('/buku/{id}', [BukuController::class, 'destroy' ])->name ( 'buku.destroy');

Route::put('/buku/{id}', [BukuController::class, 'update' ])->name ( 'buku.update');

Route::get( '/buku/search', [BukuController::class, 'search' ])->name( 'buku.search');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
