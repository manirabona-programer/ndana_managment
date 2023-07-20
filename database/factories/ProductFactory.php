<?php

    namespace Database\Factories;

use App\Models\Investor;
use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
     */
    class ProductFactory extends Factory {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition() {
            return [
                'investor_id' => Investor::all()->random()->id,
                'name' => $this->faker->domainName,
                'image' => $this->faker->imageUrl,
                'type' => "Men",
                'category' => "shoes",
                'meta_desc' => "Magazine",
                'color' => $this->faker->colorName,
                'description' => $this->faker->text,
            ];
        }
    }
