<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class StoreProduct extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<string, mixed>
         */
        public function rules() {
            return [
                'name' => ['required', 'string'],
                'image' => ['nullable', 'image'],
                'type' => ['string'],
                'category' => ['string'],
                'meta_desc' => ['string'],
                'color' => ['string'],
                'description' => ['string'],
                'investor_id' => ['string'],
                'price' => ['string', 'required'],
                'quantity' => ['string', 'required']
            ];
        }
    }
