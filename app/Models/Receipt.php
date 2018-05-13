<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{

    protected $guarded = [];

    /**
     * [ description]
     * @return [type] [description]
     */

    public function person_relationated()
    {
       return $this->belongsTo(Person::class, 'person_id_relationed');
    }

    /**
     * [ description]
     * @return [type] [description]
     */

    public function period()
    {
       return $this->belongsTo(Period::class );
    }

    public function periodLiquidationClose()
    {
        return PeriodLiquidation::where('period_id', '=', $this->period_id)
          ->where('status', '<>', 1)
          ->first();
    }

}
