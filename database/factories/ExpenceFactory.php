<?php

    namespace Database\Factories;

    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expence>
     */
    class ExpenceFactory extends Factory {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition() {
            return [
                'description' => $this->faker->text,
                'cost' => '10000',
                'payment_method' => 'MTN_MOMO'
            ];
        }
    }
