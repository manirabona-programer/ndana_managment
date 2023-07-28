<?php
    namespace App\QueryFilters;

    use Patienceman\Filtan\QueryFilter;

    class InvestorFilter extends QueryFilter {
        public function query($query) {
            $this->builder->where('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('email', 'LIKE', '%' . $query . '%')
                        ->orWhere('phone_number', 'LIKE', '%' . $query . '%');
        }
    }
