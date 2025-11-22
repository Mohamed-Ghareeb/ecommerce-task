<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        if (isset($data['stock'])) {
            $data['status'] = $data['stock'] > 0 ? 'in_stock' : 'out_of_stock';
        }

        $product->update($data);

        return $product;
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}
