<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Brand";
        $brands = Brand::where('is_default', 0)->latest()->get();
        return view('admin.brand.index', compact('title', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'name' => 'required',
        ]);

        $brand_image = $request->file('image');
        $slug = 'brand';
        if($brand_image){
            $brand_image_name = $slug.'-'.uniqid().'.'.$brand_image->getClientOriginalExtension();
            $upload_path = 'media/brand/';
            $brand_image->move($upload_path, $brand_image_name);

            $image_url = $upload_path.$brand_image_name;
        }else{
            $image_url = NULL;
        }

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = strtolower(str_replace(' ', '-', $request->name));
        $brand->image = $image_url;
        $brand->save();

        Toastr::success('Category successfully save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function brandActive($id)
    {

        Brand::findOrFail($id)->update(['status' => '1']);
        Toastr::info('Brand Successfully Active :-)','Success');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function brandInactive($id)
    {
        Brand::findOrFail($id)->update(['status' => '0']);
        Toastr::info('Brand Successfully Inactive :-)','Success');
        return redirect()->back();
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
            'name' => 'required',
        ]);

        $brand = Brand::find($id);

        $brand_image = $request->file('image');
        $slug = 'brand';
        if($brand_image){
            if(file_exists($brand->image)){
                unlink($brand->image);
            }
            $brand_image_name = $slug.'-'.uniqid().'.'.$brand_image->getClientOriginalExtension();
            $upload_path = 'media/brand/';
            $brand_image->move($upload_path, $brand_image_name);

            $image_url = $upload_path.$brand_image_name;
            $brand->image = $image_url;
        }

        $brand->name = $request->name;
        $brand->slug = strtolower(str_replace(' ', '-', $request->name));
        $brand->save();

        Toastr::success('Category successfully updated :-)','Success');
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
        $brand =Brand::findOrFail($id);

        if(file_exists($brand->image)) {
            unlink($brand->image);
        }

        $check_default_brand = Brand::where('is_default', 1)->first();
        $check_products = Product::where('brand_id', $id)->get();
        if($check_products->count() > 0){
            foreach($check_products as $check_product){
                $check_product = Product::first($check_product->id);
                $check_product->brand_id = $check_default_brand->id;
            }
        }

        $brand->delete();
        Toastr::warning('Brand successfully delete :-)','Success');
        return redirect()->back();
    }
}
