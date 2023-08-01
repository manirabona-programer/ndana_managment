<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class ImportResource extends JsonResource {
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
                'imported_at' => $this->imported_at,
                'created_at' => $this->created_at->toDateTimeString(),
            ];
        }
    }
