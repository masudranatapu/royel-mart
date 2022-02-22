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
        'name_bg',
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
        'outside_delivery',
        'return_status',
        'inside_delivery',
        'warranty_policy',
        'schema',
        'product_type',
        'status',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id', 'id');
    }
    public function subsubcategory()
    {
        return $this->belongsTo(Category::class, 'subsubcategory_id', 'id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
