<?php

namespace Database\Seeders;

use App\Models\EmployeeModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class EmployeeModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        $salaries = [];
        for($i = 50000; $i <= 100000; $i = $i + 500){
            $salaries[] = $i . '.00';
        }
        Cache::set('entry_salaries',$salaries);

        $salaries = [];
        for($i = 100000; $i <= 200000; $i = $i + 500){
            $salaries[] = $i . '.00';
        }
        Cache::set('manager_salaries',$salaries);

        $salaries = [];
        for($i = 200000; $i <= 300000; $i = $i + 500){
            $salaries[] = $i . '.00';
        }
        Cache::set('director_salaries',$salaries);

        $salaries = [];
        for($i = 300000; $i <= 500000; $i = $i + 500){
            $salaries[] = $i . '.00';
        }  
        Cache::set('vice_president_salaries',$salaries);

        EmployeeModel::factory(50000)->create();

        Cache::pull('entry_salaries');
        Cache::pull('manager_salaries');
        Cache::pull('director_salaries');
        Cache::pull('vice_president_salaries');
        Cache::pull('employee_id');
        

    }
}
