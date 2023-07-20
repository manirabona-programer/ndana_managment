<?php

    namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
     */
    class PurchaseFactory extends Factory {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition() {
            return [
                'product_id' => Product::all()->random()->id,
                'price' => "12000",
                'final_price' => "10000",
                'discount' => "11000",
            ];
        }
    }
