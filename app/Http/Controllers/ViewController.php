<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryBanner;
use App\Models\ProductUnit;
use App\Models\ProductSubUnit;

class ViewController extends Controller
{

    public function productDetails($slug)
    {
        $products = Product::where('slug', $slug)->first();
        $title = $products->name;
        $productsunits = ProductUnit::where('product_id', $products->id)->latest()->get();
        return view('pages.productdetails', compact('title', 'products', 'productsunits'));
    }

    public function categoryProduct($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $title = $category->name;
        $relatedcategory = Category::latest()->limit(12)->get();
        $products = Product::where('category_id', $category->id)->latest()->get();
        $latestcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('status', 1)->latest()->get();
        return view('pages.categoryproduct', compact('title', 'category', 'products', 'relatedcategory', 'latestcategory', 'categorybanners'));
    }
}