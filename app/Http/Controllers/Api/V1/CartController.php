<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AddToCartRequest;
use App\Http\Requests\Api\V1\UpdateQuantityInCartRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index()
    {
        return response()->json([
            'items' => $this->cartService->getCartDetails(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    public function add(AddToCartRequest $request)
    {
        $this->validateProductStock($request->product_id, $request->quantity);

        $this->cartService->addProduct($request->product_id, $request->quantity);

        return response()->json([
            'message' => 'Product added to cart',
            'cart'    => [
                'items' => $this->cartService->getCartDetails(),
                'total' => $this->cartService->getTotal(),
            ],
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $this->cartService->removeProduct($request->product_id);

        return response()->json([
            'message' => 'Product removed from cart',
            'cart'    => [
                'items' => $this->cartService->getCartDetails(),
                'total' => $this->cartService->getTotal(),
            ],
        ]);
    }

    public function update(UpdateQuantityInCartRequest $request)
    {
        $this->validateProductStock($request->product_id, $request->quantity);

        $this->cartService->updateProduct($request->product_id, $request->quantity);

        return response()->json([
            'message' => 'Cart updated',
            'cart'    => [
                'items' => $this->cartService->getCartDetails(),
                'total' => $this->cartService->getTotal(),
            ],
        ]);
    }

    public function clear()
    {
        $this->cartService->clearCart();

        return response()->json([
            'message' => 'Cart cleared',
        ]);
    }

    private function validateProductStock($productId, $quantity)
    {
        $product = Product::find($productId);

        throw_if(!$product, ValidationException::withMessages([
            'product_id' => ['The selected product does not exist.'],
        ]));

        throw_if($quantity > $product->stock, ValidationException::withMessages([
            'quantity' => ["Cannot add {$quantity} items. Only {$product->stock} in stock."],
        ]));
    }
}
