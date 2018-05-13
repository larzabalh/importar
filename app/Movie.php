<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
	protected $connection = 'movies_db';

	protected $fillable = [
		'title', 'rating', 'release_date' , 'awards', 'genre_id', 'poster'
	];


    public function genre()
	{
		return $this->belongsTo(Genre::class);
	}

	//hacer que la api me retorne automaticamente el genero solo cuando tenga que retornar Json

	public function toJson($options = 0){
		$this->load( 'genre' );
		return parent::toJson(JSON_PRETTY_PRINT);
	}

}
