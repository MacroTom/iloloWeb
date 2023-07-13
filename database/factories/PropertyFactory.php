<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word(),
            'label' => $this->faker->word(),
            'values' => implode(',', $this->faker->words()),
        ];
    }
}
