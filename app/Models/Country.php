<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $table = 'tCountrys';
    protected $primaryKey = 'idCountry';

    /**
     * Get id field.
     *
     * @return integer
     */
    public function idField()
    {
        return $this[$this->primaryKey];
    }

    /**
     * Get the first and last name.
     *
     * @return string
     */
    public function getName()
    {
        return $this['countryName'];
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ ];

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
   protected $guarded = [ ];


}
