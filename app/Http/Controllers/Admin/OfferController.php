<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Offer";
        $sales = Offer::latest()->get();
        return view('admin.offer.index', compact('title', 'sales'));
    }

    public function offer_product($offer_id)
    {
        $title = "Offer Products";
        $qs_products = OfferProduct::with('product')->where('offer_id', $offer_id)->latest()->get();
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number', 'asc')->get();
        return view('admin.offer.product', compact('title', 'qs_products', 'offer_id', 'categories'));
    }

    public function offer_sale_activity($id)
    {
        $c_v = Offer::where('id', $id)->first();
        if($c_v->status == 1){
            $offer = Offer::find($id);
            $offer->status = 0;
            $offer->save();
        }else{
            $offer = Offer::find($id);
            $offer->status = 1;
            $offer->save();
        }

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
    public function update_offer_product(Request $request)
    {
        $q_sale = Offer::find($request->offer_id);
        foreach($request->product_id as $key=>$product_id){
            $check_product = Product::find($product_id);

            if($request->discount_type[$key] == 'Solid'){
                $sale_price = $check_product->regular_price - $request->discount[$key];
            }else{
                $discount = floor(($check_product->regular_price * $request->discount[$key])/100);
                $sale_price = $check_product->regular_price -$discount;
            }

            $check_qs_product = OfferProduct::where('product_id', $product_id)->where('offer_id', $request->offer_id)->first();
            if($check_qs_product){
                $product = OfferProduct::find($check_qs_product->id);
                $product->discount = $request->discount[$key];
                $product->discount_type = $request->discount_type[$key];
                $product->sale_price = $sale_price;
                $product->status = $q_sale->status;
                $product->save();
            }else{
                $product = new OfferProduct();
                $product->product_id = $product_id;
                $product->offer_id = $request->offer_id;
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

    public function offer_product_delete(Request $request){
        $offer_pro_id = $request->offer_pro_id;
        $offer_product = OfferProduct::find($offer_pro_id);
        $offer_product->delete();

        return 'Done';
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:offers',
            'discount' => 'required',
            'discount_type' => 'required',
        ]);

        $sale = new Offer();
        $sale->title = $request->title;
        $sale->slug = strtolower(str_replace(' ', '-', $request->title));

        $banner_image = $request->file('image');
        $slug = strtolower(str_replace(' ', '-', $request->title));
        if($banner_image){
            $banner_image_name = $slug.'-'.uniqid().'.'.$banner_image->getClientOriginalExtension();
            $upload_path = 'media/offer/';
            $banner_image->move($upload_path, $banner_image_name);

            $image_url = $upload_path.$banner_image_name;
        }else{
            $image_url = NULL;
        }

        $sale->image = $image_url;

        $sale->discount = $request->discount;
        $sale->discount_type = $request->discount_type;
        $sale->save();

        Toastr::success('New offer create successfully :-)','Success');
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
            'discount' => 'required',
            'discount_type' => 'required',
        ]);

        $sale = Offer::find($id);
        $sale->title = $request->title;
        $sale->slug = strtolower(str_replace(' ', '-', $request->title));

        $banner_image = $request->file('image');
        $slug = strtolower(str_replace(' ', '-', $request->title));
        if($banner_image){
            if(file_exists($sale->image)){
                unlink($sale->image);
            }

            $banner_image_name = $slug.'-'.uniqid().'.'.$banner_image->getClientOriginalExtension();
            $upload_path = 'media/offer/';
            $banner_image->move($upload_path, $banner_image_name);

            $sale->image = $upload_path.$banner_image_name;
        }

        $sale->discount = $request->discount;
        $sale->discount_type = $request->discount_type;

        if($request->discount > 0){
            $che_qs_products = OfferProduct::where('offer_id', $id)->get();
            if($che_qs_products->count() > 0){
                foreach($che_qs_products as $qs_product){
                    $che_qs_product = OfferProduct::find($qs_product->id);
                    if($che_qs_product){
                        $che_qs_product->discount = $request->discount;
                        $che_qs_product->discount_type = $request->discount_type;
                        $che_qs_product->save();
                    }
                }
            }
        }

        $sale->save();

        Toastr::success('Offer updated successfully :-)','Success');
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
        $sale = Offer::with('products')->find($id);

        $sale->products()->delete();

        $sale->delete();

        Toastr::success('Offer successfully deleted :-)','Success');
        return redirect()->back();
    }
}
