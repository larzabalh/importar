<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $guarded = [];

    /**
     * liquidations for a period
     * @return collection relation
     */
    public function period_liquidations()
    {
        return $this->hasMany(PeriodLiquidation::class);
    }

    /**
     * liquidation for a period
     * @param  string $apply_to 'iibb' or 'iva'
     * @return PeriodLiquidation::Class
     */
    public function period_liquidation($apply_to)
    {
        return $this->period_liquidations()
        ->where('apply_to', '=', $apply_to)
        ->first();
    }

    /**
     * previous period
     * @return  Period::Class
     */
    public function previousPeriod()
    {
      return Period::where('code', '='
      , $this->previousPeriodCode())
       ->where('person_id', '=', $this->person_id)
       ->first();
    }

    /**
     * previous code period
     * @return String Year-Month
     */
    public function previousPeriodCode() 
    {
      if($this->period_number>1){
        $month = $this->period_number-1;
        $year = $this->year;
      }else{
        $month = 12;
        $year = $this->year-1;
      }
      return $year.'-'.$month;
    }

}
