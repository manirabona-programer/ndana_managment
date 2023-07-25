<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('investor_id');
                $table->string('name');
                $table->string('image');
                $table->string('type');
                $table->string('category');
                $table->string('meta_desc');
                $table->string('color');
                $table->longText('description');
                $table->string('quantity');
                $table->string('price');
                $table->boolean('active_status')->default(true);
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('products');
        }
    };
