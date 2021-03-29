<?php

namespace Database\Factories;

use App\Models\EmployeeModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

class EmployeeModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        // $table->id();
        // $table->string('first_name', 255);
        // $table->string('last_name', 255);
        // $table->unsignedBigInteger('position_id');
        // $table->foreign('position_id')->references('id')->on('positions');
        // $table->dateTime('recruitment_date')->useCurrent();
        // $table->text('email');
        // $table->text('photo');
        // $table->decimal('price',10,2);
        // $table->unsignedBigInteger('admin_created_id');
        // $table->unsignedBigInteger('admin_updated_id');
        // $table->timestamps();

        // 'description' => $this->faker->sentences(2, true),
        // 'category_id' => $category,
        // 'article' => $this->faker->unique()->ean8,
        // 'created_at' => now(),
        // 'updated_at' => now(),


        if(Cache::get('employee_id') == null){
            Cache::set('employee_id', 1);
        }

        $employee_id = Cache::get('employee_id');
        Cache::set('employee_id', $employee_id+1);

        // 1 Chief Executive Officer
        if($employee_id == 1){
            $position_id = 1;
            $salary = '500000.00';
            $higher_up_id = 1;
        }

        // 4 Vice Presidents 
        if($employee_id > 1 && $employee_id <= 5){
            $position_id = 2;
            $salary = Arr::random(Cache::get('vice_president_salaries'));
            $higher_up_id = 1;
        }

        // 45 Directors
        if($employee_id > 5 && $employee_id <= 50){
            $position_id = 3;
            $salary = Arr::random(Cache::get('director_salaries'));
            $higher_up_id = rand(2,5);
        }

        // 450 Managers
        if($employee_id > 50 && $employee_id <= 500){
            $position_id = 4;
            $salary = Arr::random(Cache::get('manager_salaries'));
            $higher_up_id = rand(6,50);
        }

        // 49500 Entry Levels
        if($employee_id > 500 && $employee_id <= 50000){
            $position_id = 5;
            $salary = Arr::random(Cache::get('entry_salaries'));
            $higher_up_id = rand(51,500);
        }        

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'position_id' => $position_id,
            'recruitment_date' => $this->faker->dateTimeThisYear(),
            'email' => $this->faker->email,
            'higher_up_id' => $higher_up_id,
            'phone' => '+38'.Arr::random(['099','050','066','063','067','068','093']).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9),
            'photo' => 'dist/img/user2-160x160.jpg',
            'salary' => $salary,
            'admin_created_id' => 1,
            'admin_updated_id' => 1,
        ];
    }
}
