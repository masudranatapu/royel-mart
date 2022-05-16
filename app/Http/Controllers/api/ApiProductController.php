<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ApiProductController extends Controller
{

    public function newArrivals(Request $request)
    {


        $products = $this->getDefaultProductList();

        $products = $products->paginate(15);

        $myRe = ['status' => true, 'products' => $products];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    private function getDefaultProductList()
    {

        $products = DB::table('products')
            ->select('products.id','products.product_code','products.name', 'products.regular_price', 'products.sale_price', 'products.discount', 'products.discount_tk', 'products.thumbnail', 'products.product_type')
            ->where('products.status', '=', 1);


        return $products;

    }
    private function getDefaultProductListWithBrand()
    {

        $products = DB::table('products')
            ->select('products.id','products.product_code','products.name', 'products.regular_price', 'products.sale_price', 'products.discount', 'products.discount_tk', 'products.thumbnail', 'products.product_type', 'brands.name as brand_name')
            ->leftJoin('brands', 'brands.id', 'products.brand_id')
            ->where('products.status', '=', 1);


        return $products;

    }
    private function getDefaultProductListWithReviewAvgCount()
    {

        $products = DB::table('products')
            ->select('products.id','products.product_code','products.name', 'products.regular_price', 'products.sale_price', 'products.discount', 'products.discount_tk', 'products.thumbnail', 'products.product_type', DB::raw("IFNULL(AVG(reviews.rating), 0) as avg_rating"),
                DB::raw("IFNULL(COUNT(reviews.rating),0) as count_rating"))
            ->leftJoin('reviews', 'reviews.product_id', 'products.id')
            ->where('products.status', '=', 1);


        return $products;

    }
    private function getDefaultProductListWithReviewAvg()
    {
        $selectColumn=['products.id','products.product_code','products.name', 'products.regular_price', 'products.sale_price', 'products.discount', 'products.discount_tk', 'products.thumbnail', 'products.product_type',  DB::raw("IFNULL(AVG(reviews.rating), 0) as avg_rating")];

        $products = DB::table('products')
            ->select($selectColumn)
            ->leftJoin('reviews', 'reviews.product_id', 'products.id')
            ->where('products.status', '=', 1);


        return $products;

    }

    public function featuredroducts(Request $request)
    {


        $products = $this->getDefaultProductList()
            ->where('products.product_type', '=', "Features")
            ->orderBy('products.created_at', 'DESC')
            ->paginate(15);


        $myRe = ['status' => true, 'products' => $products];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function allproducts(Request $request)
    {


        $products = $this->getDefaultProductList()
            ->orderBy('products.created_at', 'DESC')
            ->paginate(15);

        $myRe = ['status' => true, 'products' => $products];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function productsByBrand(Request $request)
    {


        $validator = Validator()->make($request->all(), [

            'brand_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $products = $this->getDefaultProductListWithBrand()
            ->where('products.brand_id', $request->brand_id)
            ->orderBy('products.created_at', 'DESC')
            ->paginate(15);

        $myRe = ['status' => true, 'products' => $products];

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }


    public function productsByCategory(Request $request)
    {


        $validator = Validator()->make($request->all(), [

            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $products = $this->getDefaultProductList()
            ->where('products.category_id', $request->category_id)
            ->orderBy('products.created_at', 'DESC')
            ->paginate(15);

        $myRe = ['status' => true, 'products' => $products];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function search(Request $request)
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


        $products = DB::table('products')
            ->select('products.name', 'products.regular_price', 'products.sale_price', 'products.discount', 'products.discount_tk', 'products.thumbnail', 'products.product_type', 'products.id')
            ->addSelect(DB::raw("IFNULL( products.regular_price * ( 100 - products.discount ) / 100, products.regular_price) as price_after_calculation"))
            ->where('products.status', '=', 1)
            ->where('products.name', 'LIKE', '%' . $keyword . '%');


        if ($request->has('min_price')) {
            $products = $products->whereraw('IFNULL( products.regular_price * ( 100 - products.discount ) / 100, products.regular_price) >= ' . $request->min_price);

        }


        if ($request->has('max_price')) {

            $products = $products->whereraw('IFNULL( products.regular_price * ( 100 - products.discount ) / 100, products.regular_price) <= ' . $request->max_price);

        }

        if ($request->has('filter_brand_id')) {
            $products = $products->where('products.brand_id', $request->filter_brand_id);
        }

        if ($request->has('order_by_price')) {
            $products->orderBy('price_after_calculation', $request->order_by_price);
        }


        $products = $products->orderBy('products.created_at', 'DESC')->paginate(15);

        $myRe = ['status' => true, 'products' => $products];

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);


    }



    public function productsByPrice(Request $request)
    {


        $validator = Validator()->make($request->all(), [

            'category_id' => 'nullable',
            'from_price' => 'nullable|string',
            'to_price' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $allroducts = DB::table('products')
            ->select('products.*', 'products.id', DB::raw("IFNULL(AVG(reviews.rating), 0) as avg_rating"),
                DB::raw("IFNULL(COUNT(reviews.rating),0) as count_rating"))
            ->leftJoin('reviews', 'reviews.product_id', 'products.id')
            ->groupBy('products.id')
            ->where('products.status', '=', 1)
            ->where('category_id', $request->category_id)
            ->whereBetween('price', [$request->from_price, $request->to_price])
            ->orderBy('products.created_at', 'DESC')
            ->get();

        $myRe = ['status' => true, 'allroducts' => $allroducts];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function productById(Request $request)
    {


        $validator = Validator()->make($request->all(), [

            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        if (Product::where('id', $request->id)->exists()) {

            $product = DB::table('products')
                ->select('products.*', 'products.id', DB::raw("IFNULL(AVG(reviews.rating), 0) as avg_rating"),
                    DB::raw("IFNULL(COUNT(reviews.rating),0) as count_rating"))
                ->leftJoin('reviews', 'reviews.product_id', 'products.id')
                ->groupBy('products.id')
                ->where('products.status', '=', 1)
                ->where('products.id', $request->id)
                ->orderBy('products.created_at', 'DESC')
                ->first();

            $colors = DB::table('product_colors')
                ->select("product_colors.*","colors.*")
                ->where('product_id', $product->id)
                ->leftJoin('colors', 'colors.id', 'product_colors.color_id')
                ->get();
            $sizes = DB::table('product_sizes')
                ->select("product_sizes.*","sizes.*")
                ->where('product_id', $product->id)
                ->leftJoin('sizes', 'sizes.id', 'product_sizes.size_id')
                ->get();
            //$sizes = ProductSize::where('product_id', $product->id)->get();


            $relatedProducts = $this->getDefaultProductList()
                ->where('products.id', '!=', $product->id)
                ->where('products.category_id', $product->category_id)
                ->inRandomOrder()
                ->limit(7)
                ->get();


            $myRe = ['status' => true, 'product' => $product, 'colors' => $colors, 'sizes' => $sizes, 'relatedProducts' => $relatedProducts];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);

        } else {

            $message = ['No Product Found!'];
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


    }

    public function productBySlug(Request $request, $slug)
    {


        if (Product::where('slug', $slug)->exists()) {


            $product = DB::table('products')
                ->where('products.slug', $slug)
                ->select('products.*', 'products.id', DB::raw("IFNULL(AVG(reviews.rating), 0) as avg_rating"),
                    DB::raw("IFNULL(COUNT(reviews.rating),0) as count_rating"))
                ->leftJoin('reviews', 'reviews.product_id', 'products.id')
                ->groupBy('products.id')
                ->where('products.status', '=', 1)
                ->first();


            $colors = ProductColor::where('product_id', $product->id)->get();
            $sizes = ProductSize::where('product_id', $product->id)->get();
            $relatedProducts = $this->getDefaultProductList()
                ->where('products.id', '!=', $product->id)
                ->where('products.category_id', $product->category_id)
                ->inRandomOrder()
                ->limit(7)
                ->get();


            $myRe = ['aaa' => $slug, 'status' => true, 'product' => $product, 'colors' => $colors, 'sizes' => $sizes, 'relatedProducts' => $relatedProducts];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);

        } else {

            $message = 'No Product Found!';
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

    }

    public function topRatedProducts(Request $request)
    {


        /*$topRatedProducts = DB::select("SELECT products.*, products.id,   AVG(rating) as avg_rating FROM `reviews`
                left JOIN products
                ON products.id = reviews.product_id

                GROUP BY reviews.product_id
                HAVING products.status = 1
                ORDER BY avg_rating DESC
                LIMIT 8");*/
        $topRatedProducts = $this->getDefaultProductListWithReviewAvg()
            ->groupBy('products.id')
            ->orderBy('avg_rating', 'DESC')
            ->get();
        $myRe = ['status' => true, 'topRatedProducts' => $topRatedProducts];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function wishlist(Request $request)
    {


        $validator = Validator()->make($request->all(), [

            'product_ids' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $products = Product::whereIn('id', explode(",", $request->product_ids))->orderBy('name', 'ASC')->get();
        $myRe = ['status' => true, 'products' => $products];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }


    public function productsByCampaining(Request $request)
    {


        $validator = Validator()->make($request->all(), [
            'campaining' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $allroducts = Product::where('status', '1')->where('campaigning', $request->campaining)->orderBy('created_at', 'DESC')->get();


        $myRe = ['status' => true, 'allroducts' => $allroducts];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }


}
