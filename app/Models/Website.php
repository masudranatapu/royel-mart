<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'description',
        'meta_keyword',
        'meta_decription',
        'phone',
        'fax',
        'tel',
        'logo',
        'favicon',
        'address',
        'footer_logo',
        'twitter_api',
        'google_map',
        'facebook_pixel',
        'google_analytics',
        'schema',
        'canonical_link',
        'icon',
        'link',
    ];
}
