<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatsService{

    public function ordersWithUserInfo(){
        return Order::select('order.*', 'users.name', 'users.email')
            ->join('users', 'order.user_id', '=', 'users.id')
            ->get();
    }

    public function allUsersWithOrders(){
        return User::with('orders')
            ->get();
    }

    public function allOrdersWithUsers()
    {
        return Order::with('user')
                    ->get();
    }


    public function allProductOrderCombinations()
    {
        return Order::select('order.*', 'product.*')
                    ->join('product', 'order.id', '=', DB::raw('product.id'))
                    ->get();
    }

    public function userOrderWithProducts($userId){
        return Order::where('user_id', $userId)
            ->with('orderItems.product')
            ->get();
        
    }

    public function userRecentOrders($userId, $limit){

        return Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function topSellingProducts($limit){

        $topProducts = OrderItems::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit($limit)
            ->get();
        
        $productIds = $topProducts->pluck('product_id');
        return Product::whereIn('id', $productIds)->get();
        
    }

    public function userOrderByStatus($status, $userId){
        return Order::where('user_id', $userId)
            ->where('status', $status)
            ->get();
    }

    
}