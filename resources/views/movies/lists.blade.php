@extends('layouts.template')

@section('title')
	Películas Registradas
@endsection

@section('content')

<a href="{{ route('movies.add') }}" class="btn btn-primary">Nueva</a>

<div>
@foreach($list as $pelicula)
	<div>
		<img src="{{ Storage::disk('public')->url( ($pelicula->poster) ?
			 $pelicula->poster : "posters/default.jpg") }}"
		 class="thumbnail miniatura" >
    	<a href="{{ route('movies.edit',
				 ['id' => $pelicula->id ]) }}" >{{ $pelicula->title }}</a>
				  género: {{ $pelicula->genre['name'] }}
    </div>
@endforeach
</div>

@endsection

@section('links')
{{ $list->links() }}
@endsection
