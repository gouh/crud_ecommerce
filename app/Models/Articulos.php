<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulos extends Model {
		use HasFactory;

		public $timestamps = true;
		protected $table = 'articulos';
		protected $primaryKey = 'id';
		protected $fillable = [
			'propietario', 'titulo', 'articulo', 'foto', 'likes'
		];

		public function comentarios() {
			return $this->hasMany(Comentarios::class);
		}
}
