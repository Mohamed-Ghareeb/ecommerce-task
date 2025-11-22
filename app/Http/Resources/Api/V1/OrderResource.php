<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'order_number'  => $this->order_number,
            'customer_name' => $this->whenLoaded('user', $this->user->name),
            'total_price'   => $this->total,
            'address'       => $this->address,
            'phone'         => $this->phone,
            'created_at'    => $this->created_at->toDateTimeString(),
        ];
    }
}
