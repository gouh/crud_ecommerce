<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model {
	use HasFactory;

	public $timestamps = true;
	protected $table = 'comentarios';
	protected $primaryKey = 'id';
	protected $foreignKey = 'articulo_id';
	protected $fillable = [
		'propietario', 'comentario', 'articulo_id'
	];

	public function articulo() {
		return $this->belongsTo(Articulos::class);
	}
}
