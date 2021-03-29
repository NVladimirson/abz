<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'position', 'salary', 'higher_up', 'date_of_employment', 'admin_updated_id', 'updated_at'
    ];

    public function position(){
        return $this->hasOne('App\Models\PositionModel','id','position_id');
    }

    public function higher_up(){
        return $this->hasOne('App\Models\EmployeeModel','id','higher_up_id');
    }
}
