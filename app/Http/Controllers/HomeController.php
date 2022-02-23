<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\MissionVision;
use App\Models\Category;
use App\Models\Product;
use App\Models\About;

class HomeController extends Controller
{
    public function welcome()
    {
        $title = "Home";
        $sliders = Slider::where('status', 1)->latest()->get();
        $banners = Banner::where('status', 1)->latest()->limit(3)->get();
        $missionvissions = MissionVision::where('status', 1)->latest()->get();
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->latest()->get();
        $products = Product::where('product_type', 'Features')->latest()->get();
        $newArrivals = Product::where('product_type', 'New Arrival')->latest()->get();
        return view('welcome', compact('title', 'sliders', 'banners', 'missionvissions', 'categories', 'products', 'newArrivals'));
    }
    public function aboutUs()
    {
        $title = "About Us";
        $about = About::latest()->first();
        return view('pages.aboutus', compact('title', 'about'));
    }
}
