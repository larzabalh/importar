<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModule extends Model
{

    protected $connection = 'finance';
    protected $table = 'tUserModules';
    protected $primaryKey = 'idUserModule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idUser', 'idModule'
    ];

    /**
     * Return the relaltion to user
     * @return object of type User
     */
    public function user()
    {
      return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    /**
     * Return the relaltion to module
     * @return object of type Module
     */
    public function module()
    {

      return $this->belongsTo(Module::class, 'idModule', 'idModule');
    }


}
