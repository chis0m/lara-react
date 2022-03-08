<?php

namespace App\Http\Resources;

use App\Models\Cart;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        return [
            'id' => $this->{'id'},
            'status' => $this->{'status'},
            'status_string' => Cart::statusToString($this->{'status'}),
            'count' => $this->{'count'},
            'user_id' => $this->{'user_id'},
            'product_id' => $this->{'product_id'},
            'user' => new ProductResource($this->whenLoaded('user')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'checkout' => new ProductResource($this->whenLoaded('checkout')),
            'created_at' => $this->{'created_at'},
            'updated_at' => $this->{'updated_at'},
        ];
    }
}
