<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\QuickSale;
use App\Models\QuickSaleProduct;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class QuickSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Quick Sale";
        $sales = QuickSale::latest()->get();
        return view('admin.quick-sale.index', compact('title', 'sales'));
    }

    public function quick_sale_product($quick_sale_id)
    {
        $title = "Quick Sale Products";
        $qs_products = QuickSaleProduct::with('product')->where('quick_sale_id', $quick_sale_id)->latest()->get();
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number', 'asc')->get();
        return view('admin.quick-sale.product', compact('title', 'qs_products', 'quick_sale_id', 'categories'));
    }

    public function quick_sale_activity($id)
    {
        $c_v = QuickSale::where('id', $id)->first();
        if($c_v->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }

        QuickSale::findOrFail($id)->update(['status' => $status]);

        Toastr::success('Status successfully change :-)','Success');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:quick_sales',
            'start_date_time' => 'required',
            'end_date_time' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
        ]);

        $sale = new QuickSale();
        $sale->title = $request->title;
        $sale->slug = strtolower(str_replace(' ', '-', $request->title));

        $banner_image = $request->file('image');
        $slug = strtolower(str_replace(' ', '-', $request->title));
        if($banner_image){
            $banner_image_name = $slug.'-'.uniqid().'.'.$banner_image->getClientOriginalExtension();
            $upload_path = 'media/quick-sale/';
            $banner_image->move($upload_path, $banner_image_name);

            $image_url = $upload_path.$banner_image_name;
        }else{
            $image_url = NULL;
        }

        $sale->image = $image_url;

        $sale->start_date_time = $request->start_date_time;
        $sale->end_date_time = $request->end_date_time;
        $sale->discount = $request->discount;
        $sale->discount_type = $request->discount_type;
        $sale->save();

        Toastr::success('New quick sale create successfully :-)','Success');
        return redirect()->back();
    }

    public function update_quick_sale_product(Request $request)
    {
        $q_sale = QuickSale::find($request->quick_sale_id);
        foreach($request->product_id as $key=>$product_id){
            $check_product = Product::find($product_id);

            if($request->discount_type[$key] == 'Solid'){
                $sale_price = $check_product->regular_price - $request->discount[$key];
            }else{
                $discount = floor(($check_product->regular_price * $request->discount[$key])/100);
                $sale_price = $check_product->regular_price -$discount;
            }

            $check_qs_product = QuickSaleProduct::where('product_id', $product_id)->where('quick_sale_id', $request->quick_sale_id)->first();
            if($check_qs_product){
                $product = QuickSaleProduct::find($check_qs_product->id);
                $product->discount = $request->discount[$key];
                $product->discount_type = $request->discount_type[$key];
                $product->sale_price = $sale_price;
                $product->status = $q_sale->status;
                $product->save();
            }else{
                $product = new QuickSaleProduct();
                $product->product_id = $product_id;
                $product->quick_sale_id = $request->quick_sale_id;
                $product->discount = $request->discount[$key];
                $product->discount_type = $request->discount_type[$key];
                $product->sale_price = $sale_price;
                $product->status = $q_sale->status;
                $product->save();
            }
        }

        Toastr::success('Product added successfully :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'start_date_time' => 'required',
            'end_date_time' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
        ]);

        $sale = QuickSale::find($id);
        $sale->title = $request->title;
        $sale->slug = strtolower(str_replace(' ', '-', $request->title));

        $banner_image = $request->file('image');
        $slug = strtolower(str_replace(' ', '-', $request->title));
        if($banner_image){
            if(file_exists($sale->image)){
                unlink($sale->image);
            }

            $banner_image_name = $slug.'-'.uniqid().'.'.$banner_image->getClientOriginalExtension();
            $upload_path = 'media/quick-sale/';
            $banner_image->move($upload_path, $banner_image_name);

            $sale->image = $upload_path.$banner_image_name;
        }

        $sale->start_date_time = $request->start_date_time;
        $sale->end_date_time = $request->end_date_time;
        $sale->discount = $request->discount;
        $sale->discount_type = $request->discount_type;

        if($request->discount > 0){
            $che_qs_products = QuickSaleProduct::where('quick_sale_id', $id)->get();
            if($che_qs_products->count() > 0){
                foreach($che_qs_products as $qs_product){
                    $che_qs_product = QuickSaleProduct::find($qs_product->id);
                    if($che_qs_product){
                        $che_qs_product->discount = $request->discount;
                        $che_qs_product->discount_type = $request->discount_type;
                        $che_qs_product->save();
                    }
                }
            }
        }

        $sale->save();

        Toastr::success('New quick sale create successfully :-)','Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = QuickSale::with('products')->find($id);

        $sale->products()->delete();

        $sale->delete();

        Toastr::success('Sale successfully deleted :-)','Success');
        return redirect()->back();
    }
}
