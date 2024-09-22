<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

Route::get('/buku', [BukuController::class, 'index']);
Route::get( '/buku/create', [BukuController::class, 'create' ])->name( 'buku.create');
Route::post('/buku', [BukuController::class, 'store' ])->name( 'buku.store');
Route::delete('/buku/{id}', [BukuController::class, 'destroy' ])->name ( 'buku.destroy');

Route::put('/buku/{id}', [BukuController::class, 'update' ])->name ( 'buku.update');


