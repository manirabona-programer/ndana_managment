<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Patienceman\Filtan\Filterable;

    class Expence extends Model {
        use HasFactory,
            Filterable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'description',
            'cost',
            'payment_method'
        ];
    }
