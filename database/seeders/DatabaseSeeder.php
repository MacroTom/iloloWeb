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
        // Admin seeders
        $this->call(AdminSeeder::class);

        // User seeders
        // $this->call(UserSeeder::class);

        // Category seeders
        $this->call(CategorySeeder::class);

        // Subcategory seeders
        $this->call(SubcategorySeeder::class);

        // Advert seeders
        $this->call(AdvertSeeder::class);

        // Plan seeders
        $this->call(PlanSeeder::class);
    }
}
