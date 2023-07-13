<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::factory()->create([
            'id' => 1,
            'title' => 'Land & Properties',
            'category_type' => 'L'
        ]);

        \App\Models\Category::factory()->create([
            'id' => 2,
            'title' => 'Vehicles',
            'category_type' => 'C'
        ]);
        \App\Models\Category::factory()->create([
            'id' => 3,
            'title' => 'Electronics',
            'category_type' => 'O'
        ]);

        \App\Models\Category::factory()->create([
            'id' => 4,
            'title' => 'Home, Furnitures & Appliances',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'id' => 5,
            'title' => 'Fashion',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'id' => 6,
            'title' => 'Mobile Phones & Tablets',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'id' => 7,
            'title' => 'Services',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'id' => 8,
            'title' => 'Animals & Pets',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'id' => 9,
            'title' => 'Jobs',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'id' => 10,
            'title' => 'Babies & Kids',
            'category_type' => 'O'
        ]);

        \App\Models\Category::factory()->create([
            'id' => 11,
            'title' => 'Health & Beauty',
            'category_type' => 'O'
        ]);
    }
}
