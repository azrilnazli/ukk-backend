<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'category_id' => rand(1, 5),
            'title' => $this->faker->sentence(),
            'synopsis' => $this->faker->text(),
            'original_filename' => $this->faker->imageUrl(),
            'processing' => 0,
            'created_at' => \Carbon\Carbon::now(),
        	'updated_at' => \Carbon\Carbon::now(),

        ];
    }
}
