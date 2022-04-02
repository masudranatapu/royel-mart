<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_code',
        'total',
        'paid',
        'due'
    ];

    public function products()
    {
        return $this->hasMany(PurchaseStock::class, 'purchase_code', 'purchase_code');
    }
}
