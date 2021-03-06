<?php

namespace Database\Seeders;

use App\Models\Api\Car\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Car::factory()->count(100)->create();
    }
}
