<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\StatController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'public',
], function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);

});

Route::group([
    "middleware" => ["auth:api"]
], function () {
    Route::get("logout", [UserController::class, "logout"]);
    Route::group([
        'prefix' => 'user'
    ], function(){
        Route::get('orders', [StatController::class, 'getUserOrdersWithProducts']);
        Route::get('orders/recent', [StatController::class, 'getUserRecentOrders']);
        Route::get('orders/{status}', [StatController::class, 'getUserOrdersByStatus']);
    });
    Route::get("product/top", [StatController::class, 'getTopSellingProducts']);
});
