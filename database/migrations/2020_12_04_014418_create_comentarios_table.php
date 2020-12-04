<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('comentarios', function (Blueprint $table) {
			$table->id();
			$table->string('propietario', 50);
			$table->text('comentario');
			$table->unsignedBigInteger('articulos_id');
			$table->timestamps();
		});

		Schema::table('comentarios', function($table) {
			$table->foreign('articulos_id')
			->references('id')->on('articulos')
      ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('comentarios');
	}
}
