<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\ApiProductController;
use App\Models\Ad;
use App\Models\Area;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Campaigning;
use App\Models\Category;
use App\Models\Color;
use App\Models\ContactUs;
use App\Models\District;
use App\Http\Controllers\Controller;

use App\Models\Division;
use App\Models\Product;

use App\Models\Settings;

use App\Models\Size;
use App\Models\Slider;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Image;
use Validator;

class ApiController extends Controller
{


    public function settings(Request $request)
    {

        $status = true;
        //$settings = Settings::pluck('value', 'name')->toArray();

        $settings=[
            "websiteName"=>"royalmart",
            "companyEmail"=>"royalmartbd2020@gmail.com",
            "companyPhone"=>"8801798820017",
            "companyAddress"=>"Address : 24 North Goran, Khilgaon, Dhaka- 1219",
            "fbLink"=>"facebook.com",
            "youtubeLink"=>"youtube.com",
            "liLink"=>"google.com",
            "androidLink"=>"google.com",
            "iosLink"=>"google.com",
            "logo"=>"google.com",
            "companyRegKey"=>"google.com",
            "instaLink"=>"google.com",
            "lOgo"=>"google.com",
        ];

        $myRe = ['status' => $status, 'settings' => $settings];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);
    }


    public function slider(Request $request)
    {


        $status = true;
        $sliders = Slider::where("status","=","1")->get();
        $myRe = ['status' => $status, 'sliders' => $sliders];

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }
    public function banner(Request $request)
    {


        $status = true;
        $banner = Banner::where("status","=","1")->get();
        $myRe = ['status' => $status, 'banner' => $banner];

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function slider_bottom_banner(Request $request)
    {


        $status = true;
        $sliders = DB::table('slider_bottom_banners')
            //->leftjoin('products', 'products.slugs', '=',DB::raw("substring_index(slider_bottom_banners.link,'/',-1)"))
            //->select('slider_bottom_banners.*','products.*')
            ->select('slider_bottom_banners.*')
            ->where('live', 1)
            ->limit(3)
            ->get();


        $myRe = ['status' => $status, 'sliders' => $sliders];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);


    }


    public function productsByPrice(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'category_id' => 'nullable',
            'from_price' => 'nullable|string',
            'to_price' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;

        $allroducts = \DB::table('products')
            ->select('products.*', 'products.id', \DB::raw("IFNULL(AVG(ratings.rating), 0) as avg_rating"),
                \DB::raw("IFNULL(COUNT(ratings.rating),0) as count_rating"))
            ->leftJoin('ratings', 'ratings.product_id', 'products.id')
            ->groupBy('products.id')
            ->where('products.status', '=', 1)
            ->where('category_id', $request->category_id)
            ->whereBetween('price', [$request->from_price, $request->to_price])
            ->orderBy('products.created_at', 'DESC')
            ->get();

        $myRe = ['status' => $status, 'allroducts' => $allroducts];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }





    public function brands(Request $request)
    {


        //$brands = Brand::orderBy('created_at', 'DESC')->get();
        //$brands = Brand::inRandomOrder()->where('is_featured', 1)->get();
        $brands = Brand::where('status', 1)
            ->get(["id", "name", "image"]);
        $myRe = ['status' => true, 'brands' => $brands];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }
    public function searchFilterOption(Request $request)
    {
        log::channel('my')->info(json_encode($request->input()));

        $validator = Validator()->make($request->all(), [

            'key_word' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $keyword = $request->key_word;


        $brands = DB::table('brands')
            ->select('brands.*')
            ->leftJoin('products', 'brands.id', 'products.brand_id')
            ->where('products.name', 'LIKE', '%' . $keyword . '%');


        $brands = $brands->distinct()->get();

        $myRe = ['status' => true, "brands" => $brands];

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);


    }





    public function categories(Request $request)
    {


        $categories = Category::select("*")
            ->whereNull('parent_id')
            ->where('show_hide','=','1')
            ->where('status','=','1')
            ->orderBy('serial_number', 'Asc')
            ->get();
        $myRe = ['status' => true, 'categories' => $categories];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }


    public function categoriesNew(Request $request)
    {



        $categories = Category::select("*")->where('status','=','1');

        if($request->has("category_id"))
        {
            $categories->where('parent_id','=', $request->category_id);
            if($request->level==1)
            {
                $categories->where('child_id', NULL)->orderBy('parent_serial', 'ASC');
            }
            else if($request->level==2)
            {
                $categories->orderBy('child_serial', 'ASC');
            }
        }
        else
        {
            $categories->where('parent_id', NULL)->where('child_id', NULL)->where('is_default', 0)->orderBy('serial_number', 'Asc');     // level 0
        }

        $categories=$categories->get();

        $myRe = ['status' => true, 'categories' => $categories];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }
    public function subCategoriesOrProducts(Request $request)
    {

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" );


        $categories = Category::select("*")->where('status','=','1');

        if($request->has("category_id"))
        {

            if($request->level==1)
            {
                $categories=$categories->where('parent_id','=', $request->category_id);
                $categories=$categories->where('child_id', NULL)->orderBy('parent_serial', 'ASC');
                $categories=$categories->get();
                $count = $categories->count();
                If($count==0)
                {
                    $productController=new ApiProductController();
                    return $productController->productsByCategory($request);

                }
            }
            else if($request->level==2)
            {
                $categories=$categories->where('child_id','=', $request->category_id);
                $categories=$categories->orderBy('child_serial', 'ASC');
                $categories=$categories->get();

                $count = $categories->count();
                If($count==0)
                {
                    $productController=new ApiProductController();
                    return $productController->productsByCategory($request);

                }


            }
            else
            {
                $productController=new ApiProductController();
                return $productController->productsByCategory($request);

            }
        }
        else
        {
            $categories->where('parent_id', NULL)->where('child_id', NULL)->where('is_default', 0)->orderBy('serial_number', 'Asc');
            $categories=$categories->get();// level 0
        }



        $myRe = ['status' => true, 'categories' => $categories];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function subCategories(Request $request)
    {
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" );


        $status = false;
        $validator = Validator()->make($request->all(), [

            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;
        $subCategories = Category::select("*")->where('parent_id','=', $request->category_id)->orderBy('name', 'ASC')->get();
        $myRe = ['status' => $status, 'categories' => $subCategories];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function wishlist(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'product_ids' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;
        $products = Product::whereIn('id', explode(",", $request->product_ids))->orderBy('name', 'ASC')->get();
        $myRe = ['status' => $status, 'products' => $products];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function ads(Request $request)
    {


        $ads = Ad::inRandomOrder()->limit(2)->get();
        $myRe = ['status' => true, 'ads' => $ads];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function campaining(Request $request)
    {


        $campaining = Campaigning::all()->first();
        $myRe = ['status' => true, 'campaining' => $campaining];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function campain(Request $request)
    {


        $campain = Campaigning::where('live', '1')->get();
        $myRe = ['status' => true, 'campain' => $campain];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function testGal(Request $request)
    {


        $subCategories = SubCategory::whereIn('id', explode(",", $request->ids));
        if ($subCategories->count() != 0) {
            $subCategories = $subCategories->get();
        } else {
            return response()->json(['status' => false, 'subCategories' => []]);
        }
        $myRe = ['status' => true, 'subCategories' => $subCategories];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function productsByCampaining(Request $request)
    {


        /*$allroducts = \DB::table('products')
            ->select('products.*', 'products.id', \DB::raw("IFNULL(AVG(ratings.rating), 0) as avg_rating"),
                \DB::raw("IFNULL(COUNT(ratings.rating),0) as count_rating"))
            ->leftJoin('ratings', 'ratings.product_id', 'products.id')
            ->groupBy('products.id')
            ->where('products.status', '=' , 1)
            ->where('products.campaigning','=', 'heart-attack')
            ->orderBy('products.created_at', 'DESC')
            ->take(30)
            ->get();*/
        $allroducts = Product::where('status', '1')->where('campaigning', $request->campaining)->orderBy('created_at', 'DESC')->get();


        $myRe = ['status' => true, 'allroducts' => $allroducts];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }


    public function allReviewsByProduct(Request $request)
    {

        $validator = Validator()->make($request->all(), [

            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $allReviews = \DB::table('ratings')
            ->select('ratings.id', 'ratings.*', 'users.first_name', 'users.last_name', 'users.image')
            ->leftJoin('users', 'users.id', 'ratings.customer_id')
            ->where('product_id', $request->product_id)
            ->orderBy('ratings.created_at', 'DESC')
            ->get();
        $myRe = ['status' => true, 'reviews' => $allReviews];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function contact(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'name' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;
        $contact = new ContactUs();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->is_seen = 0;
        $contact->save();

        $myRe = ['status' => $status, 'message' => 'Request sent successfully!'];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function divisions(Request $request)
    {


        $divisions=Division::all();

        $myRe = ['status' => true, 'divisions' => $divisions];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }
    public function districts(Request $request)
    {
        $status = false;
        $validator = Validator()->make($request->all(), [

            'division_id' => 'required',

        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

        $districts=District::select("*")->where("division_id","=",$request->division_id)->get();

        $myRe = ['status' => true, 'districts' => $districts];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }







}
