<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickSale extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'image',
        'start_date_time',
        'end_date_time',
        'discount',
        'discount_type',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(QuickSaleProduct::class, 'quick_sale_id', 'id');
    }
}
