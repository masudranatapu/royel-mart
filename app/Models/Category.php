<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
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
}
