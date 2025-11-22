<?php

namespace App\Services;

use App\Enums\ProductStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function __construct(private CartService $cartService) {}

    public function processCheckout(string $address, string $phone): array
    {
        $cartDetails = $this->cartService->getCartDetails();

        throw_if(empty($cartDetails), ValidationException::withMessages([
            'cart' => ['Cart is empty.'],
        ]));

        return DB::transaction(function () use ($cartDetails, $address, $phone) {
            $total = $this->cartService->getTotal();

            $order = Order::create([
                'user_id'      => auth()->id(),
                'order_number' => $this->generateOrderNumber(),
                'address'      => $address,
                'phone'        => $phone,
                'total'        => $total,
            ]);

            $products = Product::whereIn('id', collect($cartDetails)->pluck('product_id'))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $orderItemsData = [];
            $itemsSummary = [];

            foreach ($cartDetails as $item) {
                $product = $products[$item['product_id']] ?? null;

                throw_if(!$product || $product->stock < $item['quantity'], ValidationException::withMessages([
                    'stock' => ["Product {$item['name']} is out of stock or insufficient quantity."],
                ]));

                $product->decrement('stock', $item['quantity']);

                $product->updateQuietly([
                    'status' => $product->stock - $item['quantity'] <= 0 ? ProductStatus::OUT_OF_STOCK : ProductStatus::IN_STOCK,
                ]);

                $orderItemsData[] = [
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $itemsSummary[] = [
                    'product_id' => $product->id,
                    'name'       => $product->name,
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'subtotal'   => $item['subtotal'],
                ];
            }

            OrderItem::insert($orderItemsData);

            $this->cartService->clearCart();

            return [
                'order_number' => $order->order_number,
                'total'        => $total,
                'items'        => $itemsSummary,
            ];
        });
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = Str::upper(Str::random(20));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
