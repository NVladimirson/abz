<?php

namespace Database\Seeders;

use App\Models\PositionModel;
use Illuminate\Database\Seeder;

class PositionModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PositionModel::create([
            'position' => 'Chief Executive Officer',
            'priority' => 1
        ]);

        PositionModel::create([
            'position' => 'Vice President',
            'priority' => 2
        ]);

        PositionModel::create([
            'position' => 'Director',
            'priority' => 3
        ]);

        PositionModel::create([
            'position' => 'Manager',
            'priority' => 4
        ]);

        PositionModel::create([
            'position' => 'Entry Level',
            'priority' => 5
        ]);
    }
}
