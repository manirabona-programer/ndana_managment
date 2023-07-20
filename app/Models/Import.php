<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Import extends Model {
        use HasFactory;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'product_id',
            'quantity',
            'imported_at',
        ];

        /**
         * Import Belongs to product
         */
        public function product() {
            return $this->belongsTo(Product::class);
        }
    }
