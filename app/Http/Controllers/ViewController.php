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
use App\Models\Color;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Review;
use App\Models\ProductSubUnit;
use App\Models\QuickSale;
use App\Models\QuickSaleProduct;
use App\Models\Size;
use App\Models\Unit;

class ViewController extends Controller
{

    public function productDetails(Request $request, $slug)
    {
        $products = Product::with('user','brand','unit')->where('slug', $slug)->first();
        $colors = ProductColor::with('color')->where('product_id', $products->id)->get();
        $relatedProducts = Product::where('category_id', $products->category_id)->where('id', '!=', $products->id)->limit(12)->get();
        $latestproducts = Product::where('id', '!=', $products->id)->latest()->limit(5)->get();
        $title = $products->name;
        $p_cat_id = '';
        $lan = $request->session()->get('lan');
        $productsunits = ProductUnit::where('product_id', $products->id)->latest()->get();
        $reviews = Review::where('product_id', $products->id)->latest()->get();
        $fiveStarReviews = Review::where('product_id', $products->id)->where('rating', 5)->latest()->get();
        $fourStarReviews = Review::where('product_id', $products->id)->where('rating', 4)->latest()->get();
        $threeStarReviews = Review::where('product_id', $products->id)->where('rating', 3)->latest()->get();
        $twoStarReviews = Review::where('product_id', $products->id)->where('rating', 2)->latest()->get();
        $oneStarReviews = Review::where('product_id', $products->id)->where('rating', 1)->latest()->get();
        return view('pages.productdetails', compact('title', 'lan', 'p_cat_id', 'products', 'colors', 'relatedProducts', 'latestproducts', 'productsunits', 'reviews', 'fiveStarReviews', 'fourStarReviews', 'threeStarReviews', 'twoStarReviews', 'oneStarReviews'));
    }

    public function quick_sale_product_details(Request $request, $qs_slug, $slug)
    {
        $products = Product::with('user','brand','unit')->where('slug', $slug)->first();

        $quick_sale = QuickSale::where('slug', $qs_slug)->first();
        $quick_sale_product = QuickSaleProduct::where('product_id', $products->id)->where('quick_sale_id', $quick_sale->id)->first();

        $colors = ProductColor::with('color')->where('product_id', $products->id)->get();
        $relatedProducts = Product::where('category_id', $products->category_id)->where('id', '!=', $products->id)->limit(12)->get();
        $latestproducts = Product::where('id', '!=', $products->id)->latest()->limit(5)->get();
        $title = $products->name;
        $p_cat_id = '';
        $lan = $request->session()->get('lan');
        $productsunits = ProductUnit::where('product_id', $products->id)->latest()->get();
        $reviews = Review::where('product_id', $products->id)->latest()->get();
        $fiveStarReviews = Review::where('product_id', $products->id)->where('rating', 5)->latest()->get();
        $fourStarReviews = Review::where('product_id', $products->id)->where('rating', 4)->latest()->get();
        $threeStarReviews = Review::where('product_id', $products->id)->where('rating', 3)->latest()->get();
        $twoStarReviews = Review::where('product_id', $products->id)->where('rating', 2)->latest()->get();
        $oneStarReviews = Review::where('product_id', $products->id)->where('rating', 1)->latest()->get();
        return view('pages.quick-sale-product-details', compact('title', 'lan', 'p_cat_id', 'products', 'quick_sale', 'quick_sale_product', 'colors', 'relatedProducts', 'latestproducts', 'productsunits', 'reviews', 'fiveStarReviews', 'fourStarReviews', 'threeStarReviews', 'twoStarReviews', 'oneStarReviews'));
    }



    // ajax for product details
    public function colorSizeAjax(Request $request)
    {
        $sizes = ProductSize::where('product_id', $request->p_id)->where('color_id', $request->id)->get();

        if($sizes->count() <= 0){
            $html = null;
        }else{
            $html = null;
            $html .= '
                    <label for="">Size: </label>
                    <select name="size_id" class="form-select" id="size_id" required>
                        <option value="">Select</option>
                ';
            foreach ($sizes as $size) {
                $html .= '
                        <option value="' . $size->size_id . '">' . Size::find($size->size_id)->name . '</option>
                ';
            }
            $html .=' </select>';
        }
        return $html;
    }

    public function categoryProduct(Request $request, $slug)
    {
        $lan = $request->session()->get('lan');
        $category = Category::where('slug', $slug)->first();
        $p_cat_id = $category->id;
        $title = $category->name;

        if ($category->parent_id != NULL && $category->child_id != NULL) {
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        } elseif ($category->parent_id != NULL && $category->child_id == NULL) {
            $relatedcategory = Category::where('child_id', $category->id)->where('is_default', '0')->orderBy('child_serial', 'ASC')->limit(12)->get();
        } elseif ($category->parent_id == NULL && $category->child_id == NULL) {
            $relatedcategory = Category::where('parent_id', $category->id)->where('child_id', NULL)->where('is_default', '0')->orderBy('parent_serial', 'ASC')->limit(12)->get();
        } else {
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        }

        $latestproducts = Product::latest()->limit(5)->get();
        $products = Product::where('category_id', $category->id)->latest()->paginate(20);

        $colors = Color::all();
        $color_id = '';
        $sizes = Size::all();
        $size_id = '';
        $units = Product::where('category_id', $category->id)->groupBy('unit_id')->select('unit_id')->latest()->get();
        $unit_id = '';
        $brands = Product::where('category_id', $category->id)->groupBy('brand_id')->select('brand_id')->latest()->get();
        $brand_id = '';

        $check_price = '';
        $min_price = 0;
        $max_price = 0;

        $latestcategoryads = CategoryAds::where('cat_id', $category->id)->latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('cat_id', $category->id)->where('status', 1)->latest()->get();
        return view('pages.categoryproduct', compact('title', 'lan', 'category', 'p_cat_id', 'check_price', 'min_price', 'max_price', 'colors', 'color_id', 'sizes', 'size_id', 'units', 'unit_id', 'products', 'latestproducts', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands', 'brand_id'));
    }


    public function brandProduct(Request $request)
    {
        $lan = $request->session()->get('lan');
        $findBrand = Brand::where('slug', $request->slug)->first();
        $title =  $findBrand->name;

        $category = Category::find($request->category);
        $p_cat_id = $category->id;
        $products = Product::where('brand_id', $findBrand->id)->where('category_id', $category->id)->latest()->paginate(20);

        if ($category->parent_id != NULL && $category->child_id != NULL) {
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        } elseif ($category->parent_id != NULL && $category->child_id == NULL) {
            $relatedcategory = Category::where('child_id', $category->id)->where('is_default', '0')->orderBy('child_serial', 'ASC')->limit(12)->get();
        } elseif ($category->parent_id == NULL && $category->child_id == NULL) {
            $relatedcategory = Category::where('parent_id', $category->id)->where('child_id', NULL)->where('is_default', '0')->orderBy('parent_serial', 'ASC')->limit(12)->get();
        } else {
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        }

        $latestcategoryads = CategoryAds::where('cat_id', $category->id)->latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('cat_id', $category->id)->where('status', 1)->latest()->get();
        $latestproducts = Product::latest()->limit(5)->get();

        $colors = Color::all();
        $color_id = '';
        $sizes = Size::all();
        $size_id = '';
        $units = Product::where('category_id', $category->id)->groupBy('unit_id')->select('unit_id')->latest()->get();
        $unit_id = '';
        $brands = Product::where('category_id', $category->id)->groupBy('brand_id')->select('brand_id')->latest()->get();
        $brand_id = $findBrand->id;

        $check_price = '';
        $min_price = 0;
        $max_price = 0;

        return view('pages.categoryproduct', compact('title', 'lan', 'check_price', 'min_price', 'max_price', 'colors', 'color_id', 'sizes', 'size_id', 'units', 'unit_id', 'category', 'p_cat_id', 'products', 'latestproducts', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands', 'brand_id'));
    }

    public function unit_product(Request $request)
    {
        $lan = $request->session()->get('lan');
        $unit = Unit::find($request->unit);
        $title =  $unit->name;

        $category = Category::find($request->category);
        $p_cat_id = $category->id;
        $products = Product::where('unit_id', $unit->id)->where('category_id', $category->id)->latest()->paginate(20);

        if ($category->parent_id != NULL && $category->child_id != NULL) {
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        } elseif ($category->parent_id != NULL && $category->child_id == NULL) {
            $relatedcategory = Category::where('child_id', $category->id)->where('is_default', '0')->orderBy('child_serial', 'ASC')->limit(12)->get();
        } elseif ($category->parent_id == NULL && $category->child_id == NULL) {
            $relatedcategory = Category::where('parent_id', $category->id)->where('child_id', NULL)->where('is_default', '0')->orderBy('parent_serial', 'ASC')->limit(12)->get();
        } else {
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        }

        $latestcategoryads = CategoryAds::where('cat_id', $category->id)->latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('cat_id', $category->id)->where('status', 1)->latest()->get();
        $latestproducts = Product::latest()->limit(5)->get();

        $colors = Color::all();
        $color_id = '';
        $sizes = Size::all();
        $size_id = '';
        $units = Unit::all();
        $units = Product::where('category_id', $category->id)->groupBy('unit_id')->select('unit_id')->latest()->get();
        $unit_id = $unit->id;
        $brands = Product::where('category_id', $category->id)->groupBy('brand_id')->select('brand_id')->latest()->get();
        $brand_id = '';

        $check_price = '';
        $min_price = 0;
        $max_price = 0;

        return view('pages.categoryproduct', compact('title', 'lan', 'check_price', 'min_price', 'max_price', 'colors', 'color_id', 'sizes', 'size_id', 'units', 'unit_id', 'category', 'p_cat_id', 'products', 'latestproducts', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands', 'brand_id'));
    }

    public function filter_with_color(Request $request)
    {
        $lan = $request->session()->get('lan');
        $color = Color::find($request->color_id);
        $pro_colors = ProductColor::where('color_id', $color->id)->get();
        $title =  $color->name;

        $category = Category::find($request->category);
        $p_cat_id = $category->id;
        return $products = Product::where('category_id', $category->id)
                                    ->where(function($q) use ($pro_colors){
                                        foreach ($pro_colors as $color) {
                                            $q->where('id', $color->product_id);
                                        }
                                    })
                                    ->select('id')
                                    ->latest()->paginate(20);

        if ($category->parent_id != NULL && $category->child_id != NULL) {
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        } elseif ($category->parent_id != NULL && $category->child_id == NULL) {
            $relatedcategory = Category::where('child_id', $category->id)->where('is_default', '0')->orderBy('child_serial', 'ASC')->limit(12)->get();
        } elseif ($category->parent_id == NULL && $category->child_id == NULL) {
            $relatedcategory = Category::where('parent_id', $category->id)->where('child_id', NULL)->where('is_default', '0')->orderBy('parent_serial', 'ASC')->limit(12)->get();
        } else {
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        }

        $latestcategoryads = CategoryAds::where('cat_id', $category->id)->latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('cat_id', $category->id)->where('status', 1)->latest()->get();
        $latestproducts = Product::latest()->limit(5)->get();

        $colors = Color::all();
        $color_id = $request->color_id;
        $sizes = Size::all();
        $size_id = '';
        $units = Unit::all();
        $units = Product::where('category_id', $category->id)->groupBy('unit_id')->select('unit_id')->latest()->get();
        $unit_id = '';
        $brands = Product::where('category_id', $category->id)->groupBy('brand_id')->select('brand_id')->latest()->get();
        $brand_id = '';

        $check_price = '';
        $min_price = 0;
        $max_price = 0;

        return view('pages.categoryproduct', compact('title', 'lan', 'check_price', 'min_price', 'max_price', 'colors', 'color_id', 'sizes', 'size_id', 'units', 'unit_id', 'category', 'p_cat_id', 'products', 'latestproducts', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands', 'brand_id'));
    }

    public function priceProduct(Request $request)
    {
        $lan = $request->session()->get('lan');
        $title = $request->min_price . ' price ' . ' to ' . $request->max_price . ' price product';
        $category = Category::find($request->category);
        $p_cat_id = $category->id;

        if ($category->parent_id != NULL && $category->child_id != NULL) {
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        } elseif ($category->parent_id != NULL && $category->child_id == NULL) {
            $relatedcategory = Category::where('child_id', $category->id)->where('is_default', '0')->orderBy('child_serial', 'ASC')->limit(12)->get();
        } elseif ($category->parent_id == NULL && $category->child_id == NULL) {
            $relatedcategory = Category::where('parent_id', $category->id)->where('child_id', NULL)->where('is_default', '0')->orderBy('parent_serial', 'ASC')->limit(12)->get();
        } else {
            $relatedcategory = Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->where('is_default', '0')->orderBy('serial_number', 'ASC')->limit(12)->get();
        }

        $latestcategoryads = CategoryAds::where('cat_id', $category->id)->latest()->limit(3)->get();
        $categorybanners = CategoryBanner::where('cat_id', $category->id)->where('status', 1)->latest()->get();
        $latestproducts = Product::latest()->limit(5)->get();

        $colors = Color::all();
        $color_id = '';
        $sizes = Size::all();
        $size_id = '';
        $units = Product::where('category_id', $category->id)->groupBy('unit_id')->select('unit_id')->latest()->get();
        $unit_id = '';
        $brands = Product::where('category_id', $category->id)->groupBy('brand_id')->select('brand_id')->latest()->get();
        $brand_id = '';

        $check_price = 'Has';
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $products = Product::whereBetween('sale_price', [$request->min_price, $request->max_price])->where('category_id', $category->id)->paginate(20);
        return view('pages.categoryproduct', compact('title', 'lan', 'category', 'p_cat_id', 'products', 'latestproducts', 'check_price', 'min_price', 'max_price', 'colors', 'color_id', 'sizes', 'size_id', 'units', 'unit_id', 'relatedcategory', 'latestcategoryads', 'categorybanners', 'brands', 'brand_id'));
    }
}
