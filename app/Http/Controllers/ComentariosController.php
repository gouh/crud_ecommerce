<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use Illuminate\Http\Request;

class ComentariosController extends Controller {

	/**
	 * Almacena un nuevo comentario
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
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Comentarios  $comentarios
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Comentarios $comentarios) {
	}
}
