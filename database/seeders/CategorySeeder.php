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
            'title' => 'Land & Properties',
            'category_type' => 'L'
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Vehicles',
            'category_type' => 'C'
        ]);
        \App\Models\Category::factory()->create([
            'title' => 'Electronics',
            'category_type' => 'O'
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Home, Furnitures & Appliances',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'title' => 'Fashion',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'title' => 'Mobile Phones & Tablets',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'title' => 'Services',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'title' => 'Animals & Pets',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'title' => 'Jobs',
            'category_type' => 'O'
        ]);
        \App\Models\Category::factory()->create([
            'title' => 'Babies & Kids',
            'category_type' => 'O'
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Health & Beauty',
            'category_type' => 'O'
        ]);
    }
}
