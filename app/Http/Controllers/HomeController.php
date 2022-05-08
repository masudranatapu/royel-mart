<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\MissionVision;
use App\Models\Category;
use App\Models\Product;
use App\Models\About;
use App\Models\CategoryBanner;
use App\Models\Policy;
use App\Models\Website;
use App\Models\Contact;
use App\Models\QuickSale;
use App\Models\QuickSaleProduct;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use Stichoza\GoogleTranslate\GoogleTranslate;

class HomeController extends Controller
{
    public function welcome(Request $request)
    {
        $session_count = $request->session()->get('session_count');

        if($session_count <= 0 || $session_count == ''){
            $request->session()->put('session_count', 0);
            $request->session()->put('lan', 'en');
        }

        $title = "Home";
        $last_id = "";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $sliders = Slider::where('status', 1)->latest()->get();
        $banners = Banner::where('status', 1)->latest()->limit(3)->get();
        $missionvissions = MissionVision::where('status', 1)->latest()->get();
        $feature_categories = Category::where('feature', 1)->where('status', 1)->latest()->limit(12)->get();
        $products = Product::where('product_type', 'Features')->inRandomOrder()->limit(18)->get();
        $newArrivals = Product::where('product_type', 'New Arrival')->inRandomOrder()->limit(18)->get();
        $quick_sale = QuickSale::where('status', '1')->latest()->first();
        if($quick_sale){
            $qs_products = QuickSaleProduct::with('product')->where('quick_sale_id', $quick_sale->id)->where('status', 1)->get();
        }else{
            $qs_products = NULL;
        }
        return view('welcome', compact('title', 'p_cat_id', 'lan', 'sliders', 'banners', 'missionvissions', 'feature_categories', 'products', 'newArrivals', 'qs_products', 'quick_sale'));
    }

    public function load_more_product(Request $request)
    {
        $lan = $request->session()->get('lan');
        $last_id = $request->last_id;
        $products = Product::where('product_type', 'Features')->where('id', '<', $last_id)->latest()->limit(18)->get();
        $html = '';
        if($products->count() > 0){
            foreach($products as $product){
                $html .= '
                        <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                            <div class="single-product">
                                <div class="inner-product">
                                    <figure>
                                        <a href="'.route('productdetails', $product->slug).'"> ';
                                            if(file_exists($product->thumbnail)){
                $html .= '                        <img loading="eager|lazy" src="'.asset($product->thumbnail).'" alt="'.$product->name.'">';
                                            }else{
                $html .= '                        <img loading="eager|lazy" src="media/general-image/no-photo.jpg" alt="'.$product->name.'">';
                                            }
                $html .= '
                                        </a>
                                    </figure>
                                    <div class="product-bottom">
                                        <div class="reviews">
                                            <div class="reviews-inner">
                                                <div class="reviewed" style="width: 60%">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                                <div class="blanked">
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="product-name">
                                            <a href="'.route('productdetails', $product->slug).'">
                                                '.GoogleTranslate::trans($product->name, $lan, 'en').'
                                            </a>
                                        </h3>
                                        <div class="price-cart">
                                            <div class="product-price">
                                                <span class="current-price">৳ '.$product->sale_price.'</span>';
                                                if ($product->discount > 0){
                $html .= '                           <div class="old-price-discount">
                                                        <del class="old-price">৳ '.$product->regular_price.' </del>
                                                    </div>';
                                                }
                $html .= '                   </div>
                                            <a class="cart-btn" href="'.route('productdetails', $product->slug).'">
                                                <i class="bi bi-cart-plus"></i>
                                                '.GoogleTranslate::trans('Shop Now', $lan, 'en').'
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                ';
            }
            $last_id = $product->id;
        }

        return ['html'=>$html, 'last_id'=>$last_id];

    }

    public function language_change(Request $request)
    {
        $request->session()->put('lan', $request->lan);
        $session_count = $request->session()->get('session_count') + 1;
        $request->session()->put('lan', $request->lan);
        $request->session()->put('session_count', $session_count);

        return redirect()->back();
    }

    public function aboutUs(Request $request)
    {
        $title = "About Us";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $about = About::latest()->first();
        return view('pages.aboutus', compact('title', 'p_cat_id', 'lan', 'about'));
    }
    public function contact(Request $request)
    {
        $title = "Contact Us";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $website = Website::latest()->first();
        return view('pages.contact', compact('title', 'p_cat_id', 'lan', 'website'));
    }
    public function contactStore(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);
        Toastr::success('Your message successfully received :-)','Success');
        return redirect()->back();

    }
    public function policy(Request $request, $slug)
    {
        $policy = Policy::where('slug', $slug)->first();
        $title = $policy->name;
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        return view('pages.policy', compact('title', 'p_cat_id', 'lan', 'policy'));
    }
    public function newArrival(Request $request)
    {
        $title = "New Arrival Products";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $products = Product::where('product_type', 'New Arrival')->inRandomOrder()->limit(18)->get();
        return view('pages.newarrival', compact('title', 'p_cat_id', 'lan', 'products'));
    }

    public function load_more_newarrival_product(Request $request)
    {
        $lan = $request->session()->get('lan');
        $last_id = $request->last_id;
        $products = Product::where('product_type', 'New Arrival')->where('id', '<', $last_id)->latest()->limit(18)->get();
        $html = '';
        if($products->count() > 0){
            foreach($products as $product){
                $html .= '
                        <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                            <div class="single-product">
                                <div class="inner-product">
                                    <figure>
                                        <a href="'.route('productdetails', $product->slug).'"> ';
                                            if(file_exists($product->thumbnail)){
                $html .= '                        <img loading="eager|lazy" src="'.asset($product->thumbnail).'" alt="'.$product->name.'">';
                                            }else{
                $html .= '                        <img loading="eager|lazy" src="media/general-image/no-photo.jpg" alt="'.$product->name.'">';
                                            }
                $html .= '
                                        </a>
                                    </figure>
                                    <div class="product-bottom">
                                        <div class="reviews">
                                            <div class="reviews-inner">
                                                <div class="reviewed" style="width: 60%">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                                <div class="blanked">
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="product-name">
                                            <a href="'.route('productdetails', $product->slug).'">
                                                '.GoogleTranslate::trans($product->name, $lan, 'en').'
                                            </a>
                                        </h3>
                                        <div class="price-cart">
                                            <div class="product-price">
                                                <span class="current-price">৳ '.$product->sale_price.'</span>';
                                                if ($product->discount > 0){
                $html .= '                           <div class="old-price-discount">
                                                        <del class="old-price">৳ '.$product->regular_price.' </del>
                                                    </div>';
                                                }
                $html .= '                   </div>
                                            <a class="cart-btn" href="'.route('productdetails', $product->slug).'">
                                                <i class="bi bi-cart-plus"></i>
                                                '.GoogleTranslate::trans('Shop Now', $lan, 'en').'
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                ';
            }
            $last_id = $product->id;
        }

        return ['html'=>$html, 'last_id'=>$last_id];

    }

    public function more_quick_sale_product(Request $request, $slug)
    {
        $quick_sale = QuickSale::where('slug', $slug)->first();
        $title = $quick_sale->title;
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $qs_products = QuickSaleProduct::with('product')->where('quick_sale_id', $quick_sale->id)->where('status', 1)->paginate(24);
        return view('pages.quick-sale-product', compact('title', 'p_cat_id', 'lan', 'quick_sale', 'qs_products'));
    }
    public function allProduct(Request $request)
    {
        $title = "All Product";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $products = Product::inRandomOrder()->limit(18)->get();
        return view('pages.allproduct', compact('title', 'p_cat_id', 'lan', 'products'));
    }

    public function load_more_all_product(Request $request)
    {
        $lan = $request->session()->get('lan');
        $last_id = $request->last_id;
        $products = Product::where('id', '<', $last_id)->latest()->limit(18)->get();
        $html = '';
        if($products->count() > 0){
            foreach($products as $product){
                $html .= '
                        <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                            <div class="single-product">
                                <div class="inner-product">
                                    <figure>
                                        <a href="'.route('productdetails', $product->slug).'"> ';
                                            if(file_exists($product->thumbnail)){
                $html .= '                        <img loading="eager|lazy" src="'.asset($product->thumbnail).'" alt="'.$product->name.'">';
                                            }else{
                $html .= '                        <img loading="eager|lazy" src="media/general-image/no-photo.jpg" alt="'.$product->name.'">';
                                            }
                $html .= '
                                        </a>
                                    </figure>
                                    <div class="product-bottom">
                                        <div class="reviews">
                                            <div class="reviews-inner">
                                                <div class="reviewed" style="width: 60%">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                                <div class="blanked">
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="product-name">
                                            <a href="'.route('productdetails', $product->slug).'">
                                                '.GoogleTranslate::trans($product->name, $lan, 'en').'
                                            </a>
                                        </h3>
                                        <div class="price-cart">
                                            <div class="product-price">
                                                <span class="current-price">৳ '.$product->sale_price.'</span>';
                                                if ($product->discount > 0){
                $html .= '                           <div class="old-price-discount">
                                                        <del class="old-price">৳ '.$product->regular_price.' </del>
                                                    </div>';
                                                }
                $html .= '                   </div>
                                            <a class="cart-btn" href="'.route('productdetails', $product->slug).'">
                                                <i class="bi bi-cart-plus"></i>
                                                '.GoogleTranslate::trans('Shop Now', $lan, 'en').'
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                ';
            }
            $last_id = $product->id;
        }

        return ['html'=>$html, 'last_id'=>$last_id];

    }

    public function more_category(Request $request, $slug)
    {
        $title = "All Category";
        $lan = $request->session()->get('lan');
        $category = Category::where('slug', $slug)->first();
        $cat_id = $category->id;
        $p_cat_id = $category->id;
        $title = $category->name;

        if ($category->parent_id != NULL && $category->child_id != NULL) {
            return redirect()->route('category', $slug);
        } elseif ($category->parent_id != NULL && $category->child_id == NULL) {
            $categories = Category::where('child_id', $category->id)->where('is_default', '0')->orderBy('child_serial', 'ASC')->get();
        } elseif ($category->parent_id == NULL && $category->child_id == NULL) {
            $categories = Category::where('parent_id', $category->id)->where('child_id', NULL)->where('is_default', '0')->orderBy('parent_serial', 'ASC')->get();
        }

        $categorybanners = CategoryBanner::where('cat_id', $category->id)->where('status', 1)->latest()->get();
        return view('pages.more-category', compact('title', 'p_cat_id', 'lan', 'categories', 'categorybanners'));
    }

    public function all_category(Request $request)
    {
        $title = "All Category";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $categories = Category::latest()->paginate(24);
        return view('pages.all-category', compact('title', 'p_cat_id', 'lan', 'categories'));
    }
}
