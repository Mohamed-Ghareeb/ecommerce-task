<?php

namespace App\Http\Requests\Api\V1;

class UpdateProductRequest extends CreateProductRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'name'        => 'sometimes|string|max:255',
            'description' => 'sometimes|string|nullable',
            'price'       => 'sometimes|numeric|min:0',
            'stock'       => 'sometimes|integer|min:0',
        ]);
    }
}
