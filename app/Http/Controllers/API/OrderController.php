<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request){


        $request -> validate([
            'total_amount' => 'required|numeric|min:1'
        ]);

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'status' => 'requested',
            'total_amount' => $request->total_amount
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ]);
    }
}
