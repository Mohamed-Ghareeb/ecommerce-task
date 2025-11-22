<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'order_number' => $this->order_number,
            'customer'     => UserResource::make($this->whenLoaded('user')),
            'total_price'  => $this->total,
            'address'      => $this->address,
            'phone'        => $this->phone,
            'created_at'   => $this->created_at->toDateTimeString(),
            'order_items'  => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
