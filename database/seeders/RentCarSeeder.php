<?php

namespace Database\Seeders;

use App\Models\Api\Car\RentCar;
use Illuminate\Database\Seeder;

class RentCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RentCar::factory()->count(10)->create();
    }
}
