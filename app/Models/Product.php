<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Patienceman\Filtan\Filterable;

    class Product extends Model {
        use HasFactory,
            Filterable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'investor_id',
            'name',
            'image',
            'type',
            'category',
            'meta_desc',
            'color',
            'description',
            'active_status',
            'quantity',
            'price'
        ];

        /**
         * Product has Many imports
         */
        public function imports() {
            return $this->hasMany(Import::class);
        }

        /**
         * Product has Many exports
         */
        public function exports() {
            return $this->hasMany(Export::class);
        }

        /**
         * Product belongs to investor
         */
        public function investor() {
            return $this->belongsTo(Investor::class);
        }

        /**
         * Product has many purchases
         */
        public function purchases() {
            return $this->hasMany(Purchase::class);
        }
    }
