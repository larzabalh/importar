<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
	protected $connection = 'movies_db';

   //ocultar campos
	protected $hidden = ['created_at', 'updated_at'];

   public function movie()
   {
      return $this->hasMany(Movie::class);
   }

}
