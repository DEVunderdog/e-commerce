<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    public function getUserOrdersWithProducts()
    {
        $userId = auth()->user()->id;

        $orders = Order::where('user_id', $userId)
            ->with('orderItems.product')
            ->get();

        return response()->json($orders);
    }

    public function getUserRecentOrders()
    {

        $userId = auth()->user()->id;

        $recentOrders = Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json($recentOrders);
    }

    public function getTopSellingProducts()
    {
        $topProducts = OrderItems::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        $productIds = $topProducts->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get();


        return response()->json([
            'top_products' => $products,
            'total_sold_per_product' => $topProducts->keyBy('product_id'),
        ]);
    }

    public function getUserOrdersByStatus($status)
    {
        $userId = auth()->user()->id;

        $orders = Order::where('user_id', $userId)
            ->where('status', $status)
            ->get();

        return response()->json($orders);
    }

    public function getUserOrderByExplicitJoin()
    {
        $userId = auth()->user()->id;

        $orders = Order::select('o.*', 'p.name as product_name')
            ->from('order as o')
            ->join('order_item as oi', 'o.id', '=', 'oi.order_id')
            ->join('product as p', 'oi.product_id', '=', 'p.id')
            ->where('o.user_id', $userId)
            ->get();

        return response()->json($orders);
    }

    public function getUserOrderByStatusExplicitJoin($status)
    {
        $userId = auth()->user()->id;

        $orders = DB::table('order as o')
            ->select('o.*')
            ->where('o.user_id', $userId)
            ->where('o.status', $status)
            ->join('order_item as oi', 'o.id', '=', 'oi.order_id')
            ->get();

        return response()->json($orders);
    }
}
