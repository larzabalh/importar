<?php

namespace App\Traits;
use Carbon\Carbon;

trait ConstantPeople
{

  static protected $civilStates = [ 1=>'Soltera/o', 2=>'Casada/o', 3=>'Concubinos',
     4=>'Viuda/o', 5=>'Divorciada/o'];
  static protected $intruccionDegrees = [ 0=>'-->Seleccione<--', 1=>'Básico', 2=> 'Bachiller',
    3=>'Tecnino Medio', 4=>'Tecnico Superior', 5=>'Universitario',
    6=>'PostGrado', 7=>'Diplomado', 8=>'Especialización', 9=>'Maestría',
    10=>'Doctorado', 11=>'PostDoctorado', 99=>'Otro'];
  static protected $dicotomic = [ 1=>'SI', 0=> 'NO'];
  static protected $bloodTypes = [ 0=>'-->Seleccione<--', 1=>'A+', 2=>'B+', 3=>'AB+', 4=>'O+', 5=>'A-',
    6=>'B-', 7=>'AB-', 8=>'O-' ];

  /**
   * Getter for Civil states
   * @return array key=>value
   */
  public static function getCivilStates(){
    return self::$civilStates;
  }

  /**
   * Getter for Dicotomics
   * @return array key=>value
   */
  public static function getDicotomics(){
    return self::$dicotomic;
  }

  /**
   * Getter for intruccionDegrees
   * @return array key=>value
   */
  public static function getIntruccionDegrees(){
    return self::$intruccionDegrees;
  }

  /**
   * Getter for bloodTypes
   * @return array key=>value
   */
  public static function getBloodTypes(){
    return self::$bloodTypes;
  }

  /**
   * The name of Civil State
   * @return string of name for civil state
   */
  public function civilStateName(){
    return self::$civilStates[$this->civilState];
  }

  /**
   * Show dicotomic Alive
   * @return string Yes or No
   */
  public function aliveName(){
    return self::$dicotomic[$this->alive];
  }

  /**
   * The name of instruccionDegree
   * @return string
   */
  public function instruccionDegreeName(){
    return self::$intruccionDegrees[$this->instruccionDegree];
  }

  /**
   * The name of bloodType
   * @return string
   */
  public function bloodTypeName(){
    return self::$bloodTypes[$this->bloodType];
  }


  /**
   * parse a date time to carbon
   * @param  datetime $date
   * @return Carbon DateTime
   */
  public function parseCarbonDate($field){
    return  Carbon::parse($this->$field);
  }




}
