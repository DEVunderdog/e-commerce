<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatsService{

    public function getOrdersWithUserInfo(){
        return Order::select('order.*', 'users.name', 'users.email')
            ->join('users', 'order.user_id', '=', 'users.id')
            ->get();
    }

    public function getAllUsersWithOrders(){
        return User::with('orders')
            ->get();
    }

    public function getAllOrdersWithUsers()
    {
        return Order::with('user')
                    ->get();
    }


    public function getAllProductOrderCombinations()
    {
        return Order::select('order.*', 'product.*')
                    ->join('product', 'order.id', '=', DB::raw('product.id'))
                    ->get();
    }
}