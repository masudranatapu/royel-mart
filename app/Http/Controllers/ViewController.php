<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryAds;
use App\Models\CategoryBanner;
use App\Models\ProductUnit;
use App\Models\SubUnit;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Review;
use App\Models\ProductSubUnit;

class ViewController extends Controller
{
    public function allCategory()
    {
        $title = "All Category";
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->orderBy('serial_number','asc')->get();
        return view('pages.allcategory', compact('title','categories'));
    }

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
        $relatedcategory = Category::latest()->limit(12)->get();
        $products = Product::where('category_id', $category->id)->latest()->get();
        $latestcategoryads = CategoryAds::latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('category_id', $category->id)->where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        $units = Unit::where('status', 1)->latest()->get();
        $subunits = SubUnit::where('status', 1)->latest()->get();
        return view('pages.categoryproduct', compact('title', 'category', 'products', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands', 'units', 'subunits'));
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
        $units = Unit::where('status', 1)->latest()->get();
        $subunits = SubUnit::where('status', 1)->latest()->get();
        return view('pages.categoryproduct', compact('title', 'units', 'subunits', 'products', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands'));
    }
    
    public function priceProduct(Request $request)
    {
        $title = $request->min_price. ' price ' . ' to '. $request->max_price. ' price product';
        $relatedcategory = Category::latest()->limit(12)->get();
        $latestcategoryads = CategoryAds::latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        $products = Product::whereBetween('sale_price', [$request->min_price, $request->max_price])->latest()->get();
        $units = Unit::where('status', 1)->latest()->get();
        $subunits = SubUnit::where('status', 1)->latest()->get();
        return view('pages.categoryproduct', compact('title', 'units', 'subunits', 'products', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands'));
    }
    
    public function colorProduct($slug)
    {
        $colorunits = Unit::where('slug', $slug)->first();
        $title = $colorunits->name . " Color";
        $productUnits = ProductUnit::where('unit_id', $colorunits->id)->get();

        foreach($productUnits as $unit){
            $unitproduct = Product::find($unit->product_id);
            if(!$unitproduct){

            }else {
                $products[] = $unitproduct;
            }
        }

        $relatedcategory = Category::latest()->limit(12)->get();
        $latestcategoryads = CategoryAds::latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        $units = Unit::where('status', 1)->latest()->get();
        $subunits = SubUnit::where('status', 1)->latest()->get();
        return view('pages.categoryproduct', compact('title', 'units', 'subunits', 'products', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands'));
    }

    public function sizeProduct($slug)
    {
        $sizesubunits = SubUnit::where('slug', $slug)->first();
        $productSubUnits = ProductSubUnit::where('subunit_id', $sizesubunits->id)->get();

        foreach($productSubUnits as $productsubunit) {
            $subunitsallproduct = Product::find($productsubunit->product_id);
            if(!$subunitsallproduct){

            }else {
                $products[] = $subunitsallproduct;
            }
        }

        $title = $sizesubunits->name . " Size";

        $relatedcategory = Category::latest()->limit(12)->get();
        $latestcategoryads = CategoryAds::latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        $units = Unit::where('status', 1)->latest()->get();
        $subunits = SubUnit::where('status', 1)->latest()->get();
        return view('pages.categoryproduct', compact('title', 'units', 'subunits', 'products', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands'));
    }
}