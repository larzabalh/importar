<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonZone extends Model
{
    protected $guarded = [];
    protected $table = 'person_zones';

    public function zone()
    {
      return $this->belongsTo(Zone::class);
    }

}
