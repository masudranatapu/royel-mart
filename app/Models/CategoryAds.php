<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAds extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'link',
        'image',
        'status',
    ];
}
