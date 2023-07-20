<?php

    namespace Database\Seeders;

    use App\Models\Expence;
    use App\Models\Export;
    use App\Models\Import;
    use App\Models\Investor;
    use App\Models\Product;
    use App\Models\ProductCategory;
    use App\Models\Purchase;
    use App\Models\Team;
    use App\Models\User;
    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder {
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run() {
            User::factory(10)->create();
            Team::factory(2)->create();
            Investor::factory(4)->create();
            ProductCategory::factory(20)->create();
            Product::factory(40)->create();
            Import::factory(20)->create();
            Export::factory(10)->create();
            Expence::factory(5)->create();
            Purchase::factory(30)->create();
        }
    }
