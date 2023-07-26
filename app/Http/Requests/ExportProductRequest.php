<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class ExportProductRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<string, mixed>
         */
        public function rules() {
            return [
                'product_id' => ['required', 'string'],
                'price' => ['required', 'string'],
                'quantity' => ['required', 'string'],
                'payment_method' => ['required', 'string']
            ];
        }
    }
