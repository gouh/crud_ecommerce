<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use Illuminate\Http\Request;

class ComentariosController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $req) {
		$comentario = new Comentarios();
		$comentario->propietario = $req->propietario;
		$comentario->comentario = $req->comentario;
		$comentario->articulos_id = $req->articulo_id;

		if($comentario->save()){
			return [
				'success' => true,
				'message' => 'Se guardo correctamente su comentario',
				'data' => $comentario
			];
		}

		return [
			'success' => false,
			'menssage' => 'No se pudo guardar el comentario intente de nuevo por favor.',
			'data' => null
		];
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Comentarios  $comentarios
	 * @return \Illuminate\Http\Response
	 */
	public function show($idArticulo) {
		return Comentarios::where(['articulos_id' => $idArticulo])->get();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Comentarios  $comentarios
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Comentarios $comentarios) {
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Comentarios  $comentarios
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Comentarios $comentarios) {
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Comentarios  $comentarios
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Comentarios $comentarios) {
	}
}
