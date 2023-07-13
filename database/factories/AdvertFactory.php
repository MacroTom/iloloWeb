<?php

namespace Database\Factories;

use App\Models\Advert;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Subcategory;

class AdvertFactory extends Factory
{
    protected $model = Advert::class;

    public function definition()
    {
        $states = getStates();
        $state = $this->faker->randomElement($states);
        $lgas = $state->lgas;
        $lga = $this->faker->randomElement($lgas);
        $subcategory = Subcategory::inRandomOrder()->first();
        return [
            'user_id' => 1,
            'title' => $this->faker->sentence(3),
            // 'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(6),
            'type' => $this->faker->randomElement(['', 'special']),
            'price' => $this->faker->numberBetween(1000, 500000),
            'negotiable' => $this->faker->boolean(),
            'state' => $state->state,
            'lga' => $lga,
            // 'status' => $this->faker->randomElement(['active', 'review', 'closed']),
            'status' => 'active',
            'category_id' => $subcategory->category_id,
            'subcategory_id' => $subcategory->id,
        ];
    }
}
