


select `pz`.`zone_id`,  sum(case when tr.credit=0 and r.type_id=1 and rt.taxable_iibb=2
and rt.tax_id<1000 and r.zone_id = pz.zone_id then rt.amount else 0 end) as positive_amount,
sum(case when tr.credit=1 and r.type_id=1 and rt.taxable_iibb=2
and rt.tax_id<1000 and r.zone_id = pz.zone_id then rt.amount else 0 end) as negative_amount,
sum(case when tr.credit=0 and r.type_id=1 and rt.taxable_iibb=2
and rt.tax_id<1000 and r.zone_id = pz.zone_id then rt.amount when tr.credit=1 and r.type_id=1 and
rt.taxable_iibb=2 and rt.tax_id<1000 and r.zone_id = pz.zone_id then - rt.amount else 0 end) as base_amount,
sum(case when r.type_id =4 AND r.zone_id = pz.zone_id then r.amount else 0 end) as sircreb_amount,
sum(case when r.type_id =3 and ot.zone_id = pz.zone_id then r.amount else 0 end) as retention_amount,
sum(case when r.type_id=2 and rt.tax_id>1000 and ot.section='iibb' and ot.zone_id = pz.zone_id
then rt.amount else 0 end) as perception_amount,
(select case when positive_amount>0 then positive_amount else 0 end as positive_amount
from period_liquidation_details pa  where pa.zone_id=pz.zone_id
and pa.period_id='') as previous_period_balance
from `person_zones` as `pz`
 left join `receipts` as `r` on  `r`.`period_id` = '4096' and `r`.`status_id` = '1'
 left join `receipt_types` as `tr` on `r`.`type_receipt_id` = `tr`.`id`
 left join `receipt_taxes` as `rt` on `r`.`id` = `rt`.`receipt_id`
 left join `other_taxes` as `ot` on `rt`.`tax_id` = `ot`.`id`
 where `pz`.`person_id` = '1'
 group by 1
