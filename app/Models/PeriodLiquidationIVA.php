<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodLiquidationIVA extends Model
{
    protected $table = 'period_liquidation_iva';
    protected $guarded = [];

    public function details(){
      return $this->hasMany(PeriodLiquidationIVADetail::Class,
        'period_liquidation_iva_id', 'id');
    }

    public static function toGenerate($period_id, $person_id){

      $sellNCbuy = \DB::table('system_taxes as st')
      ->crossJoin('person_activities as pa')
        ->where('pa.person_id', '=', $person_id)
        ->leftJoin('receipts as r', function($join) use ($period_id){
          $join->where('r.period_id',  '=', $period_id)
          ->where('r.status_id', '=', '1');
        })
        ->leftJoin('receipt_types as tr' , 'r.type_receipt_id', '=', 'tr.id')
        ->leftJoin('receipt_taxes as rt', 'r.id', '=', 'rt.receipt_id')
        ->select(
      \DB::raw("4 as ordr, 1 as type, 2 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
      sum(case when r.type_id=2 and tr.credit=1 and rt.tax_id<1000 and st.id=rt.tax_id
      then rt.amount else 0 end) as taxabled_amount
      "))->groupBy( \DB::raw('1,2,3,4,5,6,7') );

//Factura y Recibo A, Factura M , pero no hay recibo M
      $sell1 = \DB::table('system_taxes as st')
        ->crossJoin('person_activities as pa')
          ->where('pa.person_id', '=', $person_id)
          ->whereNotIn('st.id', [6,7])
          ->leftJoin('receipts as r', function($join) use ($period_id){
            $join->where('r.period_id',  '=', $period_id)
            ->where('r.status_id', '=', '1');
          })
          ->leftJoin('receipt_types as tr' , function($join){
            $join->on('r.type_receipt_id', '=', 'tr.id')
              ->where('tr.agroup_iva_module', '=', '1');
          })
          ->leftJoin('receipt_taxes as rt', function ($join){
            $join->on('r.id', '=', 'rt.receipt_id');
          })
          ->select(
       \DB::raw("1 as ordr, 1 as type, 1 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
      sum(case when r.type_id=1 and tr.credit=0 and rt.tax_id<1000 and st.id=rt.tax_id
      then rt.amount else 0 end) as taxabled_amount
       "))->groupBy( \DB::raw('1,2,3,4,5,6,7') );

//Factura y Recibo A, Factura M , pero no hay recibo M
     $sell2 = \DB::table('system_taxes as st')
       ->crossJoin('person_activities as pa')
         ->where('pa.person_id', '=', $person_id)
         ->whereNotIn('st.id', [6,7])
         ->leftJoin('receipts as r', function($join) use ($period_id){
           $join->where('r.period_id',  '=', $period_id)
           ->where('r.status_id', '=', '1');
         })
         ->leftJoin('receipt_types as tr' , function($join){
           $join->on('r.type_receipt_id', '=', 'tr.id')
           ->where('tr.agroup_iva_module', '=', '2');
         })
         ->leftJoin('receipt_taxes as rt', function ($join){
           $join->on('r.id', '=', 'rt.receipt_id')
           ;
         })
         ->select(
      \DB::raw("2 as ordr, 1 as type, 1 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
     sum(case when r.type_id=1 and tr.credit=0 and rt.tax_id<1000 and st.id=rt.tax_id
     then rt.amount else 0 end) as taxabled_amount
      "))->groupBy( \DB::raw('1,2,3,4,5,6,7') );

//los no gravados
      $sell3 = \DB::table('system_taxes as st')
        ->crossJoin('person_activities as pa')
          ->where('pa.person_id', '=', $person_id)
          ->whereIn('st.id', [7])
          ->leftJoin('receipts as r', function($join) use ($period_id){
            $join->where('r.period_id',  '=', $period_id)
            ->where('r.status_id', '=', '1');
          })
          ->leftJoin('receipt_types as tr', 'r.type_receipt_id', '=', 'tr.id')
          ->leftJoin('receipt_taxes as rt', function ($join){
            $join->on('r.id', '=', 'rt.receipt_id')
            ;
          })
          ->select(
       \DB::raw("3 as ordr, 1 as type, 1 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
      sum(case when r.type_id=1 and tr.credit=0 and rt.tax_id<1000 and st.id=rt.tax_id
      then rt.amount else 0 end) as taxabled_amount
       "))->groupBy( \DB::raw('1,2,3,4,5,6,7') );

       $buyNCsell = \DB::table('system_taxes as st')
         ->crossJoin('person_activities as pa')
           ->where('pa.person_id', '=', $person_id)
           ->leftJoin('receipts as r', function($join) use ($period_id){
             $join->where('r.period_id',  '=', $period_id)
             ->where('r.status_id', '=', '1');
           })
           ->leftJoin('receipt_types as tr' , 'r.type_receipt_id', '=', 'tr.id')
           ->leftJoin('receipt_taxes as rt', 'r.id', '=', 'rt.receipt_id')
           ->select(
        \DB::raw("5 as ordr, 2 as type, 3 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
      sum(case when r.type_id=1 and tr.credit=1 and rt.tax_id<1000 and st.id=rt.tax_id
      then rt.amount else 0 end) as taxabled_amount
        "))->groupBy( \DB::raw('1,2,3,4,5,6,7') );

        $details = \DB::table('system_taxes as st')
          ->crossJoin('person_activities as pa')
            ->where('pa.person_id', '=', $person_id)
            ->leftJoin('receipts as r', function($join) use ($period_id){
              $join->where('r.period_id',  '=', $period_id)
              ->where('r.status_id', '=', '1');
            })
            ->leftJoin('receipt_types as tr' , 'r.type_receipt_id', '=', 'tr.id')
            ->leftJoin('receipt_taxes as rt', 'r.id', '=', 'rt.receipt_id')
            ->select(
         \DB::raw("6 as ordr, 2 as type, 4 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
        sum(case when r.type_id=2 and tr.credit=0 and rt.tax_id<1000 and st.id=rt.tax_id
        then rt.amount else 0 end) as taxabled_amount
         "))->groupBy( \DB::raw('1,2,3,4,5,6,7') )
         ->union($sellNCbuy)->union($buyNCsell)->union($sell1)->union($sell2)->union($sell3)
         ->orderByRaw('1')->orderBy('percent_iva', 'desc')
          ->get();

        return $details;
    }

}
