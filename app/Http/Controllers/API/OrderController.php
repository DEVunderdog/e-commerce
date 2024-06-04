<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderServices;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderServices $orderServices)
    {
        $this->orderService = $orderServices;
    }

    public function create(Request $request){


        $request -> validate([
            'total_amount' => 'required|numeric|min:1'
        ]);

        $order = $this->orderService->create(
            auth()->user()->id,
            $request->input('total_amount')
        );

        return response()->json([
            'status' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ]);
    }
}
