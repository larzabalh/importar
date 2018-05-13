@extends('layouts.template')

@section('title')
	Nueva Película
@endsection

@section('content')
    <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <label for="title">Título</label>
        <input name="title" value="{{ old('title') }}" class="form-control" type="text" placeholder="Ingrese el título">
        <div>
            @if($errors->has('title'))
                @foreach ($errors->get('title') as $error)
                    <span class="text-danger">{{ $error }}</span>
                @endforeach
            @endif
        </div>

        <label for="awards">Premios</label>
        <input name="awards" value="{{ old('awards') }}" class="form-control" type="number" step="1" min="0" placeholder="Premios ">
        <div>
            @if($errors->has('awards'))
                @foreach ($errors->get('awards') as $error)
                    <span class="text-danger">{{ $error }}</span>
                @endforeach
            @endif
        </div>

        <label for="rating">Rating</label>
        <input name="rating" value="{{ old('rating') }}" class="form-control" type="number" step="0.1" placeholder="Rating (1 al 10)">
        <div>
            @if($errors->has('rating'))
                @foreach ($errors->get('rating') as $error)
                    <span class="text-danger">{{ $error }}</span>
                @endforeach
            @endif
        </div>

        <label for="release_date">Fecha de Lanzamiento</label>
        <input name="release_date" value="{{ old('release_date') }}" class="form-control" type="date" placeholder="Fecha de lanzamiento">
        <div>
            @if($errors->has('release_date'))
                @foreach ($errors->get('release_date') as $error)
                    <span class="text-danger">{{ $error }}</span>
                @endforeach
            @endif
        </div>

        <label for="genre_id">Genero</label>
        <select id="genre_id" name="genre_id" class="form-control">
            <option value="">Seleccione</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}"  {{ (old("genre_id") == $genre->id ? "selected":"") }}>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
        <div>
            @if($errors->has('genre_id'))
                @foreach ($errors->get('genre_id') as $error)
                    <span class="text-danger">{{ $error }}</span>
                @endforeach
            @endif
        </div>
        <label for="poster">Poster</label>
        <input name="poster" type="file" class="form-control">

        <button type="submit" class="btn btn-primary">Crear pelicula</button>
    </form>

@endsection
