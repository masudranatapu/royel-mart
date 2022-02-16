<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\ProductSubUnit;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\SubUnit;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Auth;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Product";
        $products = Product::latest()->get();
        return view('admin.product.index', compact('title', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Create Product";
        $categories = Category::where('status', 1)->latest()->get();
        $units = Unit::where('status', 1)->latest()->get();
        $subunits = SubUnit::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        return view('admin.product.create', compact('title', 'categories', 'units', 'subunits', 'brands',));
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
            'sale_price' => 'required',
            'product_type' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required',
        ]);
        
        $product_thambnail = $request->file('thambnail');
        $slug1 = "product";
        if (isset($product_thambnail)) {
            //make unique name for cover_photo
            $thambnail_name = $slug1.'-'.uniqid().'.'.$product_thambnail->getClientOriginalExtension();

            $upload_path = 'media/product/';
            $image_url = $upload_path.$thambnail_name;
            $product_thambnail->move($upload_path, $thambnail_name);
            $thambnail_name = $image_url;
        } else {
            $thambnail_name = NULL;
        }

        // others photo
        $multiThambnail = $request->file('multi_thambnail');
        $slug2 = "multiproduct";
        if (isset($multiThambnail)) {
            foreach ($multiThambnail as $key => $multiThamb) {
                // make unique name for image
                $multiThamb_name = $slug2.'-'.uniqid().'.'.$multiThamb->getClientOriginalExtension();
                $upload_path = 'media/multiproduct/';
                $multiThamb_image_url = $upload_path.$multiThamb_name;
                $multiThamb->move($upload_path, $multiThamb_name);
                $img_arr[$key] = $multiThamb_image_url;
            }

            $multiThamb__photo = trim(implode('|', $img_arr), '|');
        } else {
            $multiThamb__photo = NULL;
        }
        // uniq product code setup 
        $product_last = Product::select('id')->latest()->first();

        if (isset($product_last)) {
            $product_code = 'PP'.sprintf('%03d', $product_last->id + 1);
        } else {
            $product_code = 'PP'.sprintf('%03d', 1);
        }
        if(isset($request->subsubcategory_id)) {
           $category_id = $request->subsubcategory_id; 
        }elseif (isset($request->subcategory_id)) {
            $category_id = $request->subcategory_id;
        }else {
            $category_id = $request->category_id;
        }

        $product_id = Product::insertGetId([
            'user_id' => Auth::user()->id,
            'product_code' => $product_code,
            'category_id' => $category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'thambnail' => $thambnail_name,
            'multi_thambnail' => $multiThamb__photo,
            'buying_price' => $request->buying_price,
            'sale_price' => $request->sale_price,
            'discount' => $request->discount,
            'minimum_quantity' => $request->minimum_quantity,
            'description' => $request->description,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
            'schema' => $request->schema,
            'product_type' => $request->product_type,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);
        
        foreach($request->unit_id as $key=>$unit_id){
            // unit Image photo
            $unitImageGet = 'image_'.$unit_id;
            $getUnitImage = $request->file($unitImageGet);
            $slug3 = "unitimage";
            
            if (isset($getUnitImage)) {
                $unitImage_name = $slug3.'-'.uniqid().'.'.$getUnitImage->getClientOriginalExtension();
                $upload_path = 'media/unitimage/';
                $unitImage_image_url = $upload_path.$unitImage_name;
                $getUnitImage->move($upload_path, $unitImage_name);
                $product_unitImage = $unitImage_image_url;
            }else {
                $product_unitImage = NULL;
            }

            ProductUnit::insert([
                'product_id' => $product_id,
                'unit_id' => $unit_id,
                'image' => $product_unitImage,
            ]);
            
            $req_subunit_id = 'subunit_id_'.$unit_id;

            foreach($request->$req_subunit_id as $key=>$subunit_id){
                ProductSubUnit::insert([
                    'product_id' => $product_id,
                    'unit_id' => $unit_id,
                    'subunit_id' => $subunit_id,
                ]);
            }

        }

        Toastr::success('Product Successfully Save :-)','Success');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function unitIdAjax(Request $request)
    {
        // return $request->getUnitId;
        $getId = $request->getUnitId;
        $unitId = Unit::findOrFail($getId);
        $subunits = SubUnit::where('unit_id', $unitId->id)->latest()->get();
        $data = NULL;
        $data .= '<div class="row mt-3" id="new_color_area_' . $unitId->id . '">
                    <div class="col-md-4">
                        <input type="hidden" class="form-control" name="unit_id[]" value="' . $unitId->id . '">
                        <label>Unit Name</label>
                        <input type="text" class="form-control" readonly value="' . $unitId->name . '">
                    </div>
                    <div class="col-md-3">
                        <label>Unit Image</label>
                        <input type="file" class="form-control" name="image_'.$unitId->id.'" id="image_' . $unitId->id . '">
                    </div>
                    <div class="col-md-4">
                        <label>Unit Image</label>
                        <select name="subunit_id_'.$unitId->id.'[]" class="form-control select2" multiple="multiple" data-placeholder="Select Sub Unit">';
                            foreach($subunits as $subunit){
                                $data .= '<option value="'.$subunit->id.'">'. $subunit->name .'</option>';
                            }
        $data .=        '</select>
                    </div>
                    <div class="col-md-1">
                        <label>Action</label><br>
                        <button type="button" class="btn btn-danger" id="' . $unitId->id . '" onclick="removeNewColorAre(this)">
                            <i class="ml-1 fa fa-times"></i>
                        </button>
                    </div>
                </div> ';
        return $data;
    }

    public function productCategory($category_id)
    {
        $subcategory = SubCategory::where('category_id', $category_id)->latest()->get();
        return json_encode($subcategory);
    }
    public function productSubcategory($subcategory_id)
    {
        $subsubcategory = SubSubCategory::where('subcategory_id', $subcategory_id)->latest()->get();
        return json_encode($subsubcategory);
    }
}
