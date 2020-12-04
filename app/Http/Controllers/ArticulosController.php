<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulos;
use Illuminate\Support\Facades\Validator;

class ArticulosController extends Controller {
	/**
	 * Muestra un listado de articulos
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return Articulos::orderBy('id', 'DESC')->paginate(5);
	}

	/**
	 * Almacena un nuevo articulo
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $req) {
		# Valida la imagen
		$validator = Validator::make($req->all(), [
			'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
		]);
		if ($validator->fails()) {
			return [
				'success' => false,
				'message' => 'La imagen no respeta el tipo o tamaño que se establece'
			];
		}

		# Nombra la foto
		$foto = time() . '.' . $req->foto->extension();
		# Almacena un nuevo articulo
		$articulo = new Articulos;
		$articulo->propietario = filter_var($req->propietario, FILTER_SANITIZE_STRING);
		$articulo->titulo = filter_var($req->titulo, FILTER_SANITIZE_STRING);
		$articulo->articulo = filter_var($req->articulo);
		$articulo->foto = filter_var($foto);

		if($articulo->save()){
			$req->foto->move(public_path('images'), $foto);
			return [
				'success' => true,
				'message' => 'Se guardo correctamente su articulo',
				'data' => $articulo
			];
		}

		return [
			'success' => false,
			'menssage' => 'No se pudo guardar el articulo intente de nuevo por favor.',
			'data' => null
		];
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Articulos  $articulos
	 * @return \Illuminate\Http\Response
	 */
	public function show(Articulos $articulos) {
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Articulos  $articulos
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Articulos $articulos) {
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Articulos  $articulos
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Articulos $articulos) {
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Articulos  $articulos
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Articulos $articulos) {
	}
}
