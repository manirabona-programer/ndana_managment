<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Patienceman\Filtan\Filterable;

    class Investor extends Model {
        use HasFactory, Filterable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'name',
            'email',
            'phone_number',
            'active_status'
        ];

        public function products() {
            return $this->hasMany(Product::class);
        }
    }
