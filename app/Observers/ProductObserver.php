<?php

    namespace App\Observers;

    use App\Models\Product;
    use Carbon\Carbon;

    class ProductObserver {
        /**
         * Handle the Product "created" event.
         *
         * @param  \App\Models\Product  $product
         * @return void
         */
        public function created(Product $product) {
            $product->imports()->create([
                'quantity' => $product->quantity,
                'imported_at' => Carbon::now(),
            ]);
        }
    }
