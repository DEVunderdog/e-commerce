<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Services\StatsService;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    protected $statsService;

    public function __construct(StatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    public function getOrdersWithUserInfo(){
        $orders = $this->statsService->ordersWithUserInfo();

        return response()->json($orders);
    }

    public function getAllUsersWithOrders(){
        $users_orders = $this->statsService->allUsersWithOrders();

        return response()->json($users_orders);
    }

    public function getAllOrdersWithUsers(){
        $order_users = $this->statsService->allUsersWithOrders();

        return response()->json($order_users);
    }

    public function getAllProductOrderCombination(){
        $product_order = $this->statsService->allProductOrderCombinations();

        return response()->json($product_order);
    }

    public function getUserOrdersWithProducts()
    {
        $userId = auth()->user()->id;

        $orders = $this->statsService->userOrderWithProducts($userId);

        return response()->json($orders);
    }

    public function getUserRecentOrders()
    {

        $userId = auth()->user()->id;

        $recentOrders = $this->statsService->userRecentOrders($userId, 10);

        return response()->json($recentOrders);
    }

    public function getTopSellingProducts()
    {
        $topProducts = $this->statsService->topSellingProducts(10);


        return response()->json([
            'top_products' => $topProducts,
        ]);
    }

    public function getUserOrdersByStatus($status)
    {
        $userId = auth()->user()->id;

        $orders = $this->statsService->userOrderByStatus($status, $userId);

        return response()->json($orders);
    }

}
