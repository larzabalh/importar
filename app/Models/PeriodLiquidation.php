<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodLiquidation extends Model
{
    protected $table = 'period_liquidations';
    protected $guarded = [];

    protected static $applys_to = [ 'iibb', 'iva' ];

    protected static $type_iva = [ 1=>'Ventas', 2=>'Compras'];

    protected static $groups_iva = [1=>'Gravadas', 2=>'B', 3=>'No Grav',
      4=>'NC Compras', 5=>'NC Ventas', 6=>'Alicuotas'];

    //protected $titles = ['Concepto', 'Gravado', 'IVA'];
    protected static $titles_table_iva = [ 1=>['Concepto', 'Gravado', 'IVA'],
      2=>['Concepto', 'Gravado + IVA', 'IVA'], 3=>['Concepto', 'Importe', ''],
      4=>['Concepto', 'Gravado', 'IVA'], 5=>['Concepto', 'Gravado', 'IVA'],
      6=>['Concepto', 'Gravado', 'IVA']];

    public static function getApplys(){
      return self::$applys_to;
    }
    public static function getTypesIVA(){
      return self::$type_iva;
    }
    public static function getTypeIVA($type){
      return self::$type_iva[$type];
    }
    public static function getGroupIVA($group){
      return self::$groups_iva[$group];
    }
    public static function getTitlesIVA($group){
      return self::$titles_table_iva[$group];
    }
    /**
     * period to belongs to
     * @return Period::Class
     */
    public function period()
    {
      return $this->belongsTo(Period::Class);
    }

    /**
     *
     * @return PeriodLiquidationIVA::Class
     */
    public function periodLiquidationIVA()
    {
      return $this->hasOne(PeriodLiquidationIVA::Class);
    }

    /**
     *
     * @return Collection of Retencion Receipts
     */
    public function liquidationIVARetPerComp()
    {
      //aqui entran para las percepciones, notas de debito suman y credito restan
        return \DB::table('receipts as r')
          ->where('period_id', '=', $this->period_id)
          ->where('status_id', '=', '1')
          ->leftJoin('receipt_taxes as rt', 'r.id', '=', 'rt.receipt_id')
          ->leftJoin('receipt_types as tr', 'r.type_receipt_id', '=', 'tr.id')
          ->leftJoin('other_taxes as ot', 'rt.tax_id', '=', 'ot.id')
          ->leftJoin('retention_types as ret', 'r.retention_type_id', '=', 'ret.id')
          ->select(
       \DB::raw("
      sum(case when r.type_id=5 then r.amount else 0 end) as compensation_amount,
      sum(case when r.type_id=3 and ret.apply_to='iva' then r.amount else 0 end) as retention_amount,
      sum(case when r.type_id=2 and rt.tax_id>=1000 and ot.section='iva' and tr.credit=0 then rt.amount
when r.type_id=2 and rt.tax_id>=1000 and ot.section='iva' and tr.credit=1 then -rt.amount
 else 0 end) as perception_amount") )
          ->first();
    }

    /**
     * [previousPeriodLiquidation description]
     * @return [type] [description]
     */
    public function previousPeriodLiquidation()
    {
      return ($this->period->previousPeriod())!==null ?
      PeriodLiquidation::where('period_id', '='
      , $this->period->previousPeriod()->id)
      ->where('apply_to', '=', $this->apply_to)
      ->first() : null;
    }

}
