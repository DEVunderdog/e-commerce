<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    protected $fillable = ['user_id', 'total_amount'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItems::class);
    }

    public function product() {
        return $this->hasMany(Product::class, 'order_id', 'id'); // Specify foreign keys
      }
    
}
