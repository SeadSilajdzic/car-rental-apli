<?php

namespace Database\Factories\Api\Car;

use App\Models\Api\Brand\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $brand_id = rand(1, 10);
        $brand = Brand::where('id', $brand_id)->first();
        $model = $this->faker->word;
        $regNum = $this->faker->randomNumber(6);
        return [
            'brand_id' => $brand_id,
            'category_id' => rand(5,15),
            'registration_license' => $regNum,
            'model' => $this->faker->uuid,
            'price' => $this->faker->randomNumber('5'),
            'isAvailable' => 1,
            'slug' => Str::slug($brand->name . '_' . $model . '_' . $regNum),
            'manufacture_date' => $this->faker->date,
            'description' => $this->faker->sentences(4, true),
            'fuel_capacity' => $this->faker->numberBetween(100, 800),
            'number_of_seats' => $this->faker->numberBetween(2, 4),
            'truck_volume' => null
        ];
    }
}
