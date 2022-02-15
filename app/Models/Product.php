<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_code',
        'category_id',
        'brand_id',
        'name',
        'slug',
        'thambnail',
        'multi_thambnail',
        'buying_price',
        'sale_price',
        'discount',
        'minimum_quantity',
        'description',
        'meta_description',
        'meta_keyword',
        'schema',
        'product_type',
        'status',
    ];
}
