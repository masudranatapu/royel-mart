<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_code',
        'product_id',
        'size_id',
        'color_id',
        'quantity',
        'shipping_amount',
        'sub_total',
        'total',
        'payment_method',
        'payment_mobile_number',
        'payment_transaction_id',
        'shippingto',
        'status',
        'order_status',
        'order_type',
    ];
}
