<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class ProductResource extends JsonResource {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
         */
        public function toArray($request) {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'image' => env('APP_URL')."/storage/".$this->image,
                'type' => $this->type,
                'investor' => $this->investor,
                'category' => $this->category,
                'meta_desc' => $this->meta_desc,
                'color' => $this->color,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'price' => $this->price
            ];
        }
    }
