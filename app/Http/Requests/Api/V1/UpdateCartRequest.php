<?php

namespace App\Http\Requests\Api\V1;

class UpdateCartRequest extends AddToCartRequest
{
    public function rules(): array
    {
        return [
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
        ];
    }
}
