<?php

namespace App\Services;

use App\Models\Order;

class OrderServices{

    public function create($userId, $total_amount){

        return Order::create([
            'user_id' => $userId,
            'status' => 'requested',
            'total_amount' => $total_amount
        ]);
    }
}