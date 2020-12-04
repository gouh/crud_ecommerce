<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticulosController;
use App\Http\Controllers\ComentariosController;

// Ruta para ingresar un nuevo articulo
Route::get('/', function () {
	return view('articulos.listado', [
		'links' => [
			'nuevo' => 'articulo'
		]
	]);
});

// Lista todos los articulos
Route::get('articulos', [ArticulosController::class, 'index']);

// Almacena un nuevo articulo
Route::post('articulo', [ArticulosController::class, 'store']);

// Obtiene un articulo en especifico y muestra una vista
Route::get('articulo/{id}', [ArticulosController::class, 'show']);

// Muestra una vista para poder registrar un articulo nuevo
Route::get('articulo', function () {
	return view('articulos.nuevo');
});

// Muestra la vista de edicion de un articulo
Route::get('update/articulo/{id}',  function ($id) {
	return view('articulos.editar', ['id' => $id]);
});

// Actualiza un articulo (Debido aque la acción PATCH no acepta form-data se cambio a POST)
Route::post('update/articulo', [ArticulosController::class, 'update']);

// Elimina un articulo
Route::delete('articulo/{id}', [ArticulosController::class, 'destroy']);

// Obtiene un articulo con todo y sus comentarios
Route::get('articulo_comentarios/{idArticulo}', [ArticulosController::class, 'get']);

// Agrega un nuevo comentario a un articulo
Route::post('comentario', [ComentariosController::class, 'store']);
