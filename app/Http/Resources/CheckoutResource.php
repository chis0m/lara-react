<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->{'id'},
            'cart_id' => $this->{'cart_id'},
            'cart' => new CartResource($this->whenLoaded('cart')),
            'created_at' => $this->{'created_at'},
            'updated_at' => $this->{'updated_at'},

        ];
    }
}
