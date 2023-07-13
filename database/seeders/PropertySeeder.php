<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Property::factory()->create([
            'title' => 'Beautiful House in the Suburbs',
            'label' => 'House',
            'category_id' => 1
        ]);

        Property::factory()->create([
            'title' => 'Luxury Apartment in the City',
            'label' => 'Apartment',
            'category_id' => 1
        ]);

        Property::factory()->create([
            'title' => 'Spacious Land in the Countryside',
            'label' => 'Land',
            'category_id' => 1
        ]);
    }
}
