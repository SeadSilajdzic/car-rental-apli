<?php

namespace Database\Factories\Api\Car;

use App\Models\Api\Car\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentCarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand_id = rand(1, 100);
        $car = Car::where('id', $rand_id)->first();

        return [
            'user_id' => rand(1, 51),
            'category_id' => rand(3, 15),
            'registration_license' => $car->registration_license,
            'date_range' => $this->faker->numberBetween(1, 25),
            'date_from' => $this->faker->date,
            'date_to' => $this->faker->date,
            'total_rent_price' => rand(1500, 5000)
        ];
    }
}
