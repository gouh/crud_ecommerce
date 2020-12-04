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
		$articulo->foto = $foto;

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

	public function get($id) {
		$articulo = Articulos::findOrFail($id);
		$articulo->comentarios;

		return $articulo;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Articulos  $articulos
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		return view('articulos.articulo', [
			'articulo' => Articulos::findOrFail($id)
		]);
	}

	/**
	 * Actualiza un articulo parcial o totalmente
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Articulos  $articulos
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $req, Articulos $articulos) {
		$art = Articulos::findOrFail($req->id);

		$foto = $art->foto;
		if ($req->foto) {
			$validator = Validator::make($req->all(), [
				'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
			]);
			if ($validator->fails()) {
				return [
					'success' => false,
					'message' => 'La imagen no respeta el tipo o tamaño que se establece'
				];
			}

			# Elimina y guarda la siguiente foto
			unlink('public/images/' . $art->foto);
			# Nombra la foto
			$foto = time() . '.' . $req->foto->extension();
			$req->foto->move(public_path('images'), $foto);
		}

		# Actualiza los datos
		$art->propietario = $req->propietario ? $req->propietario : $art->propietario;
		$art->titulo = $req->titulo ? $req->titulo : $art->titulo;
		$art->articulo = $req->articulo ? $req->articulo : $art->articulo;
		$art->likes = $req->likes ? $req->likes : $art->likes;
		$art->foto = $foto;

		if($art->save()){
			return [
				'success' => true,
				'message' => 'Se actualizó correctamente su articulo',
				'data' => $art
			];
		}

		return [
			'success' => false,
			'menssage' => 'No se pudo actualizar el articulo intente de nuevo por favor.',
			'data' => null
		];
	}

	/**
	 * Elimina un articulo
	 *
	 * @param  \App\Models\Articulos  $articulos
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$articulo = Articulos::find($id);
		if($articulo->delete()){
			return [
				'success' => true,
				'message' => 'Se elimino el articulo',
				'data' => $articulo
			];
		}

		return [
			'success' => false,
			'menssage' => 'No se pudo eliminar el articulo intente de nuevo por favor.',
			'data' => null
		];
	}
}
