<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeIndicator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'indicator_id', 'indicator_value',
    ];

    public function name()
    {
        return $this->hasOne('App\IndicatorType','id', 'indicator_id');
    }
}
