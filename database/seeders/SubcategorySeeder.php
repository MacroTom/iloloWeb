<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Land & Properties Subcategories
        Subcategory::factory()->create([
            'category_id' => 1,
            'title' => 'Land'
        ]);

        Subcategory::factory()->create([
            'category_id' => 1,
            'title' => 'Houses & Apartments'
        ]);

        // Vehicles Subcategories
        Subcategory::factory()->create([
            'category_id' => 2,
            'title' => 'Cars'
        ]);

        Subcategory::factory()->create([
            'category_id' => 2,
            'title' => 'Motorcycles & Scooters'
        ]);

        // Electronics Subcategories
        Subcategory::factory()->create([
            'category_id' => 3,
            'title' => 'Computers & Laptops'
        ]);

        Subcategory::factory()->create([
            'category_id' => 3,
            'title' => 'TV, Audio & Video'
        ]);

        // Home, Furnitures & Appliances Subcategories
        Subcategory::factory()->create([
            'category_id' => 4,
            'title' => 'Furniture'
        ]);

        Subcategory::factory()->create([
            'category_id' => 4,
            'title' => 'Home Appliances'
        ]);

        // Fashion Subcategories
        Subcategory::factory()->create([
            'category_id' => 5,
            'title' => 'Clothing'
        ]);

        Subcategory::factory()->create([
            'category_id' => 5,
            'title' => 'Shoes'
        ]);

        // Mobile Phones & Tablets Subcategories
        Subcategory::factory()->create([
            'category_id' => 6,
            'title' => 'Phones'
        ]);

        Subcategory::factory()->create([
            'category_id' => 6,
            'title' => 'Tablets'
        ]);

        // Services Subcategories
        Subcategory::factory()->create([
            'category_id' => 7,
            'title' => 'Cleaning Services'
        ]);

        Subcategory::factory()->create([
            'category_id' => 7,
            'title' => 'Catering Services'
        ]);

        // Animals & Pets Subcategories
        Subcategory::factory()->create([
            'category_id' => 8,
            'title' => 'Dogs'
        ]);

        Subcategory::factory()->create([
            'category_id' => 8,
            'title' => 'Cats'
        ]);

        // Jobs Subcategories
        Subcategory::factory()->create([
            'category_id' => 9,
            'title' => 'Accounting & Finance Jobs'
        ]);

        Subcategory::factory()->create([
            'category_id' => 9,
            'title' => 'IT & Software Jobs'
        ]);

        // Babies & Kids Subcategories
        Subcategory::factory()->create([
            'category_id' => 10,
            'title' => 'Toys & Games'
        ]);

        Subcategory::factory()->create([
            'category_id' => 10,
            'title' => 'Baby Gear & Furniture'
        ]);

        // Health & Beauty Subcategories
        Subcategory::factory()->create([
            'category_id' => 11,
            'title' => 'Makeup'
        ]);

        Subcategory::factory()->create([
            'category_id' => 11,
            'title' => 'Skin Care'
        ]);
    }
}
