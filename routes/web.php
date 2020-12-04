<?php

use Illuminate\Support\Facades\Route;

// Ruta para ingresar un nuevo articulo
Route::get('articulo', function () {
	return view('articulos.nuevo');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
