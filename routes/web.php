<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticulosController;

// Ruta para ingresar un nuevo articulo
Route::get('/', function () {
	return view('articulos.listado');
});

Route::get('articulos', [ArticulosController::class, 'index']);
Route::get('articulo', function () {
	return view('articulos.nuevo');
});

Route::post('articulo', [ArticulosController::class, 'store']);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
