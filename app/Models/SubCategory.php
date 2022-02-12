<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'image',
        'icon',
        'menu',
        'feature',
        'serial_number',
        'show_hide_status',
        'status',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
