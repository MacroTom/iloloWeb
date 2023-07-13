<?php

namespace Database\Factories;

use App\Models\Advert;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'source' => $this->faker->imageUrl(),
            'imageable_type' => Advert::class,
        ];
    }
}
