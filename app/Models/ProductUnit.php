<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'unit_id',
        'image',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
