<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionModel extends Model
{
    use HasFactory;

    protected $table = 'positions';

    public function applicants(){
        return $this->hasMany('App\Models\EmployeeModel','position_id','id');
    }

}
