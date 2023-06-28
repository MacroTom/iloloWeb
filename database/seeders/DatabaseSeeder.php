<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(100)->create();

        \App\Models\User::factory()->create([
            'firstname' => 'Okeoghene',
            'lastname' => 'Esieba',
            'email' => 'okecoc1@gmail.com',
            'phone' => '09078533114',
            'avatar' => 'https://lineone.piniastudio.com/images/avatar/avatar-12.jpg',
            'role' => 1,
            'password' => Hash::make('test1234'),
        ]);

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

        //
        //
        // Plans Seed

        \App\Models\Plan::factory()->create([
            'title' => 'Health & Beauty',
            'category_type' => 'O'
        ]);
    }
}
