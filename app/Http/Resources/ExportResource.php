<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class ExportResource extends JsonResource {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
         */
        public function toArray($request) {
            return [
                'id' => $this->id,
                'product' => ProductResource::make($this->product),
                'quantity' => $this->quantity,
                'price' => $this->price,
                'payment_method' => $this->payment_method,
                'exported_at' => $this->exported_at,
                'created_at' => $this->created_at->toDateTimeString(),
            ];
        }
    }
