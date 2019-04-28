<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'sex', 'department_id', 'rating',
    ];
    
    public function indicators()
    {
        return $this->hasMany('App\EmployeeIndicator');
    }
}

