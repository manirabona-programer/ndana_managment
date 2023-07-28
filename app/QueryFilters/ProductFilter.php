<?php
    namespace App\QueryFilters;

    use Patienceman\Filtan\QueryFilter;

    class ProductFilter extends QueryFilter {
        public function query($query) {
            $this->builder->where('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('type', 'LIKE', '%' . $query . '%')
                        ->orWhere('category', 'LIKE', '%' . $query . '%')
                        ->orWhere('meta_desc', 'LIKE', '%' . $query . '%')
                        ->orWhere('color', 'LIKE', '%' . $query . '%')
                        ->orWhere('description', 'LIKE', '%' . $query . '%')
                        ->orWhere('quantity', 'LIKE', '%' . $query . '%')
                        ->orWhere('price', 'LIKE', '%' . $query . '%');
        }
    }
