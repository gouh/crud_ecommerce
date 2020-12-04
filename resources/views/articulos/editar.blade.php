@extends('layouts.app')
@section('content')
	<editar-articulo id="{{ $id }}" url="{{URL::to('/')}}"></editar-articulo>
@endsection
