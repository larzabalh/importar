<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
  protected $connection = 'finance';
  protected $table = 'tModules';
  protected $primaryKey = 'idModule';
  private $menuParent = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nameModule', 'pathModule', 'idParent', 'classIcon'
  ];

  /**
   * find the parent module
   * @return Module object
   */
  public function parentModule()
  {
    //echo 'Val for this module have a parent->'.$this->idModule. ', parent->'.$this->idParent."\n";
      if( $this->idModule != $this->idParent)
      {
        $this->menuParent = true;
        return Module::find($this->idParent);
      }else
      {
        $this->menuParent = false;
        return false;
      }
  }

  public function isMenuParent(){
    return $this->menuParent;
  }


}
