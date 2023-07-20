<?php

    namespace Database\Factories;

    use App\Models\Product;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Import>
     */
    class ImportFactory extends Factory {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition() {
            return [
                'product_id' => Product::all()->random()->id,
                'quantity' => "10",
            ];
        }
    }
