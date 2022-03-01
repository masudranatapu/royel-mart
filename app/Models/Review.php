<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'opinion',
        'rating',
        'email',
        'phone',
    ];
    
    public function reviewuser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
