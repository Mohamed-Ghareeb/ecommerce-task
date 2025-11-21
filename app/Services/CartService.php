<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class CartService
{
    protected function getCartKey(): string
    {
        return 'cart:user:' . Auth::id();
    }

    public function getCart(): array
    {
        return Cache::get($this->getCartKey(), []);
    }

    protected function cacheTTL()
    {
        return now()->addDays(5);
    }

    public function addProduct(int $productId, int $quantity = 1)
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        Cache::put($this->getCartKey(), $cart, $this->cacheTTL());

        return $cart;
    }

    public function removeProduct(int $productId)
    {
        $cart = $this->getCart();

        throw_if(!isset($cart[$productId]), ValidationException::withMessages([
            'product_id' => ['the cart does not contain this product.'],
        ]));

        unset($cart[$productId]);

        Cache::put($this->getCartKey(), $cart, $this->cacheTTL());

        return $cart;
    }

    public function updateProduct(int $productId, int $quantity)
    {
        $cart = $this->getCart();

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }

        Cache::put($this->getCartKey(), $cart, $this->cacheTTL());

        return $cart;
    }

    public function clearCart()
    {
        Cache::forget($this->getCartKey());
    }

    public function getCartDetails(): array
    {
        $cart = $this->getCart();
        $details = [];

        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);
            if (!$product) continue;

            $details[] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => number_format($product->price, 2),
                'quantity'   => $qty,
                'subtotal'   => number_format($product->price * $qty, 2),
                'status'     => $product->status->value,
            ];
        }

        return $details;
    }

    public function getTotal(): float
    {
        return number_format(collect($this->getCartDetails())->sum('subtotal'), 2);
    }
}
