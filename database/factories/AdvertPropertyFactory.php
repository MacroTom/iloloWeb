<?php

namespace Database\Factories;

use App\Models\AdvertProperty;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertPropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdvertProperty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'property' => $this->faker->word,
            'value' => $this->faker->word,
        ];
    }
}
