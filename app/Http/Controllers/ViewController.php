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
    // ajax for product details
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

    public function categoryProduct($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $title = $category->name;

        if($category->parent_id != NULL && $category->child_id != NULL){
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        }elseif($category->parent_id != NULL && $category->child_id == NULL){
            $relatedcategory = Category::where('child_id', $category->id)->where('is_default', '0')->orderBy('child_serial', 'ASC')->limit(12)->get();
        }elseif($category->parent_id == NULL && $category->child_id == NULL){
            $relatedcategory = Category::where('parent_id', $category->id)->where('child_id', NULL)->where('is_default', '0')->orderBy('parent_serial', 'ASC')->limit(12)->get();
        }else{
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        }
        $products = Product::where('category_id', $category->id)->latest()->get();
        $latestcategoryads = CategoryAds::where('cat_id', $category->id)->latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('cat_id', $category->id)->where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        return view('pages.categoryproduct', compact('title', 'category', 'products', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands'));
    }

    public function brandProduct($slug)
    {
        $findBrands = Brand::where('slug', $slug)->first();
        $title =  $findBrands->name;
        $products = Product::where('brand_id', $findBrands->id)->latest()->get();
        $relatedcategory = Category::latest()->limit(12)->get();
        $latestcategoryads = CategoryAds::latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        return view('pages.categoryproduct', compact('title', 'products', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands'));
    }

    public function priceProduct(Request $request)
    {
        $title = $request->min_price. ' price ' . ' to '. $request->max_price. ' price product';
        $relatedcategory = Category::latest()->limit(12)->get();
        $latestcategoryads = CategoryAds::latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        $products = Product::whereBetween('sale_price', [$request->min_price, $request->max_price])->get();
        return view('pages.categoryproduct', compact('title', 'products', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands'));
    }

}
