(select 6 as ordr, 2 as type, 4 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
sum(case when r.type_id=2 and tr.credit=0 and rt.tax_id<1000 and st.id=rt.tax_id
then rt.amount else 0 end) as taxabled_amount
from `system_taxes` as `st` cross join `person_activities` as `pa` left join `receipts` as `r` on `r`.`period_id` = '3' and `r`.`status_id` = '1' left join `receipt_types` as `tr` on `r`.`type_receipt_id` = `tr`.`id` left join `receipt_taxes` as `rt` on `r`.`id` = `rt`.`receipt_id` where `pa`.`person_id` = '1' group by 1,2,3,4,5,6,7) union (select 4 as ordr, 1 as type, 2 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
sum(case when r.type_id=2 and tr.credit=1 and rt.tax_id<1000 and st.id=rt.tax_id
then rt.amount else 0 end) as taxabled_amount
from `system_taxes` as `st` cross join `person_activities` as `pa` left join `receipts` as `r` on `r`.`period_id` = '3' and `r`.`status_id` = '1' left join `receipt_types` as `tr` on `r`.`type_receipt_id` = `tr`.`id` left join `receipt_taxes` as `rt` on `r`.`id` = `rt`.`receipt_id` where `pa`.`person_id` = '1' group by 1,2,3,4,5,6,7) union (select 5 as ordr, 2 as type, 3 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
sum(case when r.type_id=1 and tr.credit=1 and rt.tax_id<1000 and st.id=rt.tax_id
then rt.amount else 0 end) as taxabled_amount
from `system_taxes` as `st` cross join `person_activities` as `pa` left join `receipts` as `r` on `r`.`period_id` = '3' and `r`.`status_id` = '1' left join `receipt_types` as `tr` on `r`.`type_receipt_id` = `tr`.`id` left join `receipt_taxes` as `rt` on `r`.`id` = `rt`.`receipt_id` where `pa`.`person_id` = '1' group by 1,2,3,4,5,6,7) union (select 1 as ordr, 1 as type, 1 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
sum(case when r.type_id=1 and tr.credit=0 and rt.tax_id<1000 and st.id=rt.tax_id
then rt.amount else 0 end) as taxabled_amount
from `system_taxes` as `st` cross join `person_activities` as `pa` left join `receipts` as `r` on `r`.`period_id` = '3' and `r`.`status_id` = '1' left join `receipt_types` as `tr` on `r`.`type_receipt_id` = `tr`.`id` left join `receipt_taxes` as `rt` on `r`.`id` = `rt`.`receipt_id` where `pa`.`person_id` = '1' and `tr`.`agroup_iva_module` = '1' and `st`.`id` not in ('6', '7') group by 1,2,3,4,5,6,7) union (select 2 as ordr, 1 as type, 1 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
sum(case when r.type_id=1 and tr.credit=0 and rt.tax_id<1000 and st.id=rt.tax_id
then rt.amount else 0 end) as taxabled_amount
from `system_taxes` as `st` cross join `person_activities` as `pa` left join `receipts` as `r` on `r`.`period_id` = '3' and `r`.`status_id` = '1' left join `receipt_types` as `tr` on `r`.`type_receipt_id` = `tr`.`id` and `tr`.`agroup_iva_module` = '2' left join `receipt_taxes` as `rt` on `r`.`id` = `rt`.`receipt_id` where `pa`.`person_id` = '1' and `st`.`id` not in ('6', '7') group by 1,2,3,4,5,6,7) union (select 3 as ordr, 1 as type, 1 as origin, pa.activity_id ,st.id, st.name, st.percent_iva,
sum(case when r.type_id=1 and tr.credit=0 and rt.tax_id<1000 and st.id=rt.tax_id
then rt.amount else 0 end) as taxabled_amount
from `system_taxes` as `st` cross join `person_activities` as `pa` left join `receipts` as `r` on `r`.`period_id` = '3' and `r`.`status_id` = '1' left join `receipt_types` as `tr` on `r`.`type_receipt_id` = `tr`.`id` left join `receipt_taxes` as `rt` on `r`.`id` = `rt`.`receipt_id` where `pa`.`person_id` = '1' and `st`.`id` in ('7') group by 1,2,3,4,5,6,7)
 order by 1, `percent_iva` desc