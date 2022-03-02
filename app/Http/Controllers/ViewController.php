<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryAds;
use App\Models\CategoryBanner;
use App\Models\ProductUnit;
use App\Models\SubUnit;
use App\Models\Brand;
use App\Models\Review;
use App\Models\ProductSubUnit;

class ViewController extends Controller
{

    public function productDetails($slug)
    {
        $products = Product::where('slug', $slug)->first();
        $title = $products->name;
        $productsunits = ProductUnit::where('product_id', $products->id)->latest()->get();
        $reviews = Review::where('product_id', $products->id)->latest()->get();
        $fiveStarReviews = Review::where('product_id', $products->id)->where('rating', 5)->latest()->get();
        $fourStarReviews = Review::where('product_id', $products->id)->where('rating', 4)->latest()->get();
        $threeStarReviews = Review::where('product_id', $products->id)->where('rating', 3)->latest()->get();
        $twoStarReviews = Review::where('product_id', $products->id)->where('rating', 2)->latest()->get();
        $oneStarReviews = Review::where('product_id', $products->id)->where('rating', 1)->latest()->get();
        return view('pages.productdetails', compact('title', 'products', 'productsunits', 'reviews', 'fiveStarReviews', 'fourStarReviews', 'threeStarReviews', 'twoStarReviews', 'oneStarReviews'));
    }

    public function categoryProduct($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $title = $category->name;
        $relatedcategory = Category::latest()->limit(12)->get();
        $products = Product::where('category_id', $category->id)->latest()->get();
        $latestcategoryads = CategoryAds::latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        return view('pages.categoryproduct', compact('title', 'category', 'products', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands'));
    }
    public function colorSizeAjax(Request $request)
    {
        $sizes = ProductSubUnit::where('product_id', $request->p_id)->where('unit_id', $request->id)->get();

        $html = null;

        foreach($sizes as $size){
            $html .= '
                    <option value="'.$size->subunit_id.'">'.SubUnit::find($size->subunit_id)->name.'</option>
            ';
        }
        return $html;
    }
}