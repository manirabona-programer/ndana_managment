<?php
    namespace App\QueryFilters;

    use Patienceman\Filtan\QueryFilter;

    class ExpenceFilter extends QueryFilter {
        public function query($query) {
            $this->builder->where('description', 'LIKE', '%' . $query . '%')
                        ->orWhere('cost', 'LIKE', '%' . $query . '%')
                        ->orWhere('payment_method', 'LIKE', '%' . $query . '%');
        }
    }
