<?php

namespace Database\Seeders;

use App\Models\Api\Category\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Test Cat 1',
            'parent_id' => null
        ]);

        Category::create([
           'name' => 'Test Cat 2',
           'parent_id' => null,
        ]);

        Category::factory()->count(13)->create();
    }
}
