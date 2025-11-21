<?php

namespace App\Http\Requests\Api\V1;

class UpdateQuantityInCartRequest extends AddToCartRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), []);
    }
}
