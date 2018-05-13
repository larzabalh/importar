<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodLiquidationDetail extends Model
{
    protected $table = 'period_liquidation_details';
    protected $guarded = [];

    public static function zonesAmountsReceipts($period_id, $prev_period_id){
      return \DB::table('person_zones as pz')
        ->where('pz.person_id', '=', session('current_person_id'))
        ->leftJoin('receipts as r', function($join) use ($period_id){
          //$join->on('pz.zone_id', '=', 'r.zone_id')
          $join
          ->where('r.period_id',  '=', $period_id)
          ->where('r.status_id', '=', '1');
        })
        ->leftJoin('retention_types as ret' , 'ret.id', '=', 'r.retention_type_id')
        ->leftJoin('receipt_types as tr' , 'r.type_receipt_id', '=', 'tr.id')
        ->leftJoin('receipt_taxes as rt', 'r.id', '=', 'rt.receipt_id')
        ->leftJoin('other_taxes as ot', 'rt.tax_id', '=', 'ot.id')
        ->select('pz.zone_id',
     \DB::raw(" sum(case when tr.credit=0 and r.type_id=1 and rt.taxable_iibb=2 and r.zone_id=pz.zone_id
     and rt.tax_id<1000 then rt.amount else 0 end) as positive_amount,
    sum(case when tr.credit=1 and r.type_id=1 and rt.taxable_iibb=2 and r.zone_id=pz.zone_id
     and rt.tax_id<1000 then rt.amount else 0 end) as negative_amount,
    sum(case when tr.credit=0 and r.type_id=1 and rt.taxable_iibb=2 and r.zone_id=pz.zone_id
     and rt.tax_id<1000 then rt.amount when tr.credit=1 and r.type_id=1 and
      rt.taxable_iibb=2 and r.zone_id=pz.zone_id and rt.tax_id<1000 then - rt.amount else 0 end) as base_amount,
    sum(case when r.type_id=4 and r.zone_id=pz.zone_id then r.amount else 0 end) as sircreb_amount,
    sum(case when r.type_id=3 and ret.zone_id = pz.zone_id then r.amount else 0 end) as retention_amount,
    sum(case when r.type_id=2 and rt.tax_id>1000 and ot.section='iibb'
     and ot.zone_id = pz.zone_id then rt.amount else 0 end) as perception_amount,
    (select case when positive_amount>0 then positive_amount else 0 end as positive_amount
      from period_liquidation_details pa  where pa.zone_id=pz.zone_id
       and pa.period_id=".$prev_period_id.") as previous_period_balance
     "))->groupBy( \DB::raw('1') )
        ->get()->keyBy('zone_id');
    }

    public static function generalBaseAmount($period_id, $ins){
      return \DB::table('receipts as r')->where('r.period_id',  '=',  $period_id)
        ->whereIn('r.zone_id', $ins)->where('r.status_id', '=', '1')
        ->leftJoin('retention_types as ret' , 'ret.id', '=', 'r.retention_type_id')
        ->leftJoin('receipt_types as tr' , 'r.type_receipt_id', '=', 'tr.id')
        ->leftJoin('receipt_taxes as rt', 'r.id', '=', 'rt.receipt_id')
        ->select(
    \DB::raw("sum(case when tr.credit=0 and r.type_id=1 and rt.taxable_iibb=2
     and rt.tax_id<1000 then rt.amount else 0 end) as positive"),
    \DB::raw("sum(case when tr.credit=1 and r.type_id=1 and rt.taxable_iibb=2
     and rt.tax_id<1000 then rt.amount else 0 end) as negative"),
    \DB::raw("sum(case when tr.credit=0 and r.type_id=1 and rt.taxable_iibb=2
     and rt.tax_id<1000 then rt.amount when tr.credit=1 and r.type_id=1 and
      rt.taxable_iibb=2 and rt.tax_id<1000 then - rt.amount else 0 end) as amount")
      )->first();
    }
}
