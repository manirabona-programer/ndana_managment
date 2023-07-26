<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class ExpenceRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<string, mixed>
         */
        public function rules() {
            return [
                'cost' => ['required', 'string'],
                'description' => ['required', 'string'],
                'payment_method' => ['required', 'string']
            ];
        }
    }
