<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CheckoutRequest;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function __invoke(CheckoutRequest $request, CheckoutService $checkoutService)
    {
        $data = $request->validated();

        $result = $checkoutService->processCheckout($data['address'], $data['phone']);

        return response()->json([
            'message' => 'Checkout completed successfully',
            'data'    => [
                'order_number' => $result['order_number'],
                'total'        => $result['total'],
                'items'        => $result['items'],
            ],
        ]);
    }
}
