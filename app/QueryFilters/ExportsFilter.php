<?php
    namespace App\QueryFilters;

    use Patienceman\Filtan\QueryFilter;

    class ExportsFilter extends QueryFilter {
        public function query($query) {
            $this->builder->whereHas('products', function($model) use ($query) {
                $model->Where('name', 'LIKE', '%' . $query . '%')
                    ->orWhere('category', 'LIKE', '%' . $query . '%')
                    ->orWhere('meta_desc', 'LIKE', '%' . $query . '%')
                    ->orWhere('color', 'LIKE', '%' . $query . '%')
                    ->orWhere('description', 'LIKE', '%' . $query . '%')
                    ->orWhere('quantity', 'LIKE', '%' . $query . '%')
                    ->orWhere('price', 'LIKE', '%' . $query . '%');
            });
        }
    }
