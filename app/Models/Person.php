<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $guarded = [];
    protected $table = 'persons';

    protected static $documentTypes = [ 'CUIT', 'CUIL', 'DNI' ];

    public static function getDocumentTypes(){
      return self::$documentTypes;
    }

    /**
     * return a instance of the relations from periods of a person
     * @return collection of bellongs to Periods
     */
    public function periods()
    {
      return $this->hasMany(Period::class);
    }


    /**
     * return a instance the zones of the person
     * @return collection of zones
     */
    public function zones(){
        return $this->hasMany(PersonZone::class);
    }

    /**
     * liquidations details by zone
     * @return collection of zones left liquidatios_details
     */
    public function periodLiquidation($id){
        return $this->zones()
        ->leftJoin('period_liquidation_details as pl', function($join)
          use($id){
            $join->on('person_zones.person_id','=', 'pl.person_id')
            ->where('pl.period_liquidation_id', '=', $id)
            ->on('person_zones.zone_id', '=', 'pl.zone_id');
          })
        ->select('person_zones.*', 'pl.coef', 'pl.aliquot', 'pl.base_amount'
        , 'pl.tax_amount', 'pl.balance', 'pl.previous_period_balance'
        , 'pl.sircreb_amount', 'pl.perception_amount', 'pl.retention_amount'
        , 'pl.positive_amount', 'pl.negative_amount',
        \DB::raw('pl.id as period_liquidation_detail_id'))
        //->toSql();
        ->get()->keyBy('zone_id');
    }

    /**
     * return a instance of the relations from configurations of a person
     * @return collection of bellongs to configurations
     */
    public function configuration()
    {
      return $this->hasMany(PersonConfiguration::class);
    }


    public function defaultZone(){
      return $this->belongsTo(Zone::class);
    }

    public function defaultActivity(){
      return $this->belongsTo(Activity::class);
    }

    public function personType()
    {
      return $this->belongsTo(PersonType::class);
    }


    public function activities(){
        return $this->hasMany(PersonActivity::class)
          ->join('activities as a', 'activity_id', '=', 'a.id')
          ->select('person_activities.*', 'a.name')
          ->get();
    }
    public function liquidators(){
        return $this->hasMany(PersonLiquidator::class)
          ->join('liquidators as l', 'liquidator_id', '=', 'l.id')
          ->select('person_liquidators.*', 'l.name')
          ->get();
    }
    public function payMethods(){
        return $this->hasMany(PersonPayMethod::class)
          ->join('pay_methods as pm', 'pay_method_id', '=', 'pm.id')
          ->select('person_pay_methods.*', 'pm.description')
          ->get();
    }
    public function zones2(){
      return $this->hasMany(PersonZone::class)
        ->join('zones as z', 'zone_id', '=', 'z.id')
        ->select('person_zones.*', 'z.name')
        ->get();
    }

    public static function getListBusiness($status){
      return Person::
        join('person_configurations as pc',  function($join) use ($status){
          $join->on('persons.id', '=', 'pc.person_id')
          //->where('person_configurations.status', '=', $status)
          ;
        })

        ->leftJoin('activities as a', 'persons.activity_id', '=', 'a.id')
        ->leftJoin('zones as z', 'persons.zone_id', '=', 'z.id')
        ->select('persons.id', 'persons.field_name1', 'persons.document'
          , 'persons.document_type', 'pc.month_close', 'pc.active'
          , \DB::raw(" a.name as activity_name,
          z.name as zone_name") )
        ->orderBy('persons.id', 'asc')
        ->get();
    }

    public static function onlyPersons(){
      return Person::doesntHave('configuration')
        ->leftJoin('zones as z', 'persons.state_id', '=', 'z.id')
        ->select('persons.id', 'persons.field_name1', 'persons.document'
          , 'persons.document_type', \DB::raw('z.name as state_name') )
        ->orderBy('persons.id', 'asc')
        ->get();
    }

    public function assignNewPeriods($year, $month){
      $ret = []; $year=intval($year); $month=intval($month);
      //verifico si tienes periodos
      if( count($this->periods) > 0){
        // no se hara nada
      }else{
        //asigno los periodos segun en donde inicie hasta la fecha actual.
        for($i = $year; $i<=date('Y'); $i++){
          $initialMonth = ($year!=date('Y') && $i!=$year)?1 : $month;
          //corregir aqui
          $endMonth = ($i!=date('Y') )?12 : intval(date('m'));
          //$ret[] = [$i, $initialMonth , $endMonth];

          \DB::statement("
           insert Into periods (code, year, period_number, date_from, date_to, person_id)
           select concat('".$i."','-',m.month), '".$i."', m.month,
            concat('".$i."','-',m.month,'-01'), concat('".$i."',m.date_to),
            p.id from persons p, months m
            where p.id = '".$this->id."'
            and (m.month >= '".$initialMonth."' and m.month <= '".$endMonth."')
             order by 2,3;");
        }
      }
      //return $ret;
    }


    public function assignBusinessToUsers(){

      $users = Person::join('user_types as ut', 'ut.user_type_id', '=', 'persons.id')
        ->where('ut.can_view_business', '=', '1');

      \DB::statement("
      insert into user_persons (user_id, parent_person_id, person_id, created_at, updated_at)
      select t1.idUser,  (select person_id from user_persons up1
        where up1.user_id=t1.idUser and parent_person_id is null ),
       t1.person_id, now(), now()
      from
       (select u1.idUser, p1.id as person_id  from persons p1, tUsers u1 ) as t1
      left join (select u.idUser, up.person_id
       from tUsers u
       join user_types ut on u.user_type_id = ut.id
       join user_persons up on u.idUser = up.user_id
         where ut.cas_view_business=1) as t2
       on t1.idUser = t2.idUser and t1.person_id = t2.person_id
         where t2.idUser is null  and t2.person_id is null
      order by 1,2");

       }

}
