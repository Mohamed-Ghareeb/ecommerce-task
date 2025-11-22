<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardStatisticsController extends Controller
{
    public function __invoke()
    {
        $orders = Order::select(
            DB::raw('COUNT(*) as total_orders_count'),
            DB::raw('SUM(total) as total_revenues')
        )->first();

        $products = Product::select(
            DB::raw('SUM(CASE WHEN status = "in_stock" THEN 1 ELSE 0 END) as active_products'),
            DB::raw('SUM(CASE WHEN status = "out_of_stock" THEN 1 ELSE 0 END) as out_of_stock_products')
        )->first();

        $statistics = [
            'total_orders_count'    => $orders->total_orders_count,
            'total_revenues'        => $orders->total_revenues,
            'out_of_stock_products' => $products->out_of_stock_products,
            'active_products'       => $products->active_products,
        ];

        return response()->json([
            'status' => 'success',
            'data'   => $statistics,
        ]);
    }
}
