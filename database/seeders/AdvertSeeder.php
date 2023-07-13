<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Advert::factory(28)->create()
            ->each(function ($advert) {
                \App\Models\Image::factory(3)->create([
                    'imageable_id' => $advert->id,
                ]);
            })
            ->each(function ($advert) {
                $properties = $advert->category->properties->map(function($property){
                    return $property->only(['label','values']);
                });
                $advert_properties = [];
                foreach ($properties as $property) {
                    $advert_properties[] = [
                        'advert_id' => $advert->id,
                        'property' => $property['label'],
                        'value' => $property['values'][array_rand($property['values'])],
                    ];
                }
                $advert->properties()->createMany($advert_properties);
            });
    }
}
