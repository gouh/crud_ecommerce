@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<!-- Articulos -->
			<div class="col-md-12">
				<div class="mt-2 card">
					<div class="card-body">

						<div class="row">
							<div class="col-sm-12 text-center">
								<img src="{{ URL::to('images/' . $articulo->foto) }}" class="img-thumbnail align-content-center" width="500">
							</div>

							<div class="col-sm-12 text-center">
								<h2><u>{{ $articulo->titulo }}</u></h2>
								<small>Por <b>{{ $articulo->propietario }}</b> {{ $articulo->created_at }}</small>
							</div>
						</div>

						<div class="row ql-snow">
							<div class="col-sm-12 ql-editor">{!! $articulo->articulo !!}</div>
						</div>

						<comentarios id="{{ $articulo->id }}"></comentarios>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
