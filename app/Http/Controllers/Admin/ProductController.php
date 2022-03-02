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
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->latest()->get();
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
        //
        $this->validate($request, [
            'name' => 'required',
            'thambnail' => 'required',
            'sale_price' => 'required',
            'product_type' => 'required',
            'status' => 'required',
            'category_id' => 'required',
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
        }else {
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
            'name_en' => $request->name_en,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'thambnail' => $thambnail_name,
            'multi_thambnail' => $multiThamb__photo,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'discount' => $request->discount,
            'discount_tk' => $request->discount_tk,
            'minimum_quantity' => $request->minimum_quantity,
            'description' => $request->description,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
            'outside_delivery' => $request->outside_delivery,
            'return_status' => $request->return_status,
            'cash_delivery' => $request->cash_delivery,
            'inside_delivery' => $request->inside_delivery,
            'warranty_policy' => $request->warranty_policy,
            'schema' => $request->schema,
            'product_type' => $request->product_type,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);
        if(is_array($request->unit_id) || is_object($request->unit_id)){
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
                    'created_at' => Carbon::now(),
                ]);
                $req_subunit_id = 'subunit_id_'.$unit_id;
                foreach($request->$req_subunit_id as $key=>$subunit_id){
                    ProductSubUnit::insert([
                        'product_id' => $product_id,
                        'unit_id' => $unit_id,
                        'subunit_id' => $subunit_id,
                        'created_at' => Carbon::now(),
                    ]);
                }
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
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->latest()->get();
        $subcategory = Category::where('parent_id', '!=', NULL)->where('child_id', NULL)->latest()->get();
        $subsubcategory = Category::where('parent_id', '!=', NULL)->where('child_id', '!=', NULL)->latest()->get();
        $title = "Edit Product";
        $brands = Brand::where('status', 1)->latest()->get();
        $units = Unit::where('status', 1)->latest()->get();
        $products = Product::where('id', $id)->first();
        $productUnits = ProductUnit::where('product_id', $id)->latest()->get();
        $productsubunits = ProductSubUnit::where('product_id', $id)->latest()->get();
        return view('admin.product.edit', compact('title', 'brands', 'units', 'categories', 'subcategory', 'subsubcategory', 'products', 'productUnits', 'productsubunits'));

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
        $this->validate($request, [
            'name' => 'required',
            'sale_price' => 'required',
            'product_type' => 'required',
            'status' => 'required',
            'category_id' => 'required',
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

            // thambnail shhould be deleted if selected another thambnail 
            $old_product_thamb = Product::findOrFail($id);
            $delete_thamb = $old_product_thamb->thambnail;
            if(file_exists($delete_thamb)) {
                unlink($delete_thamb);
            }

        } else {
            $old_product_thamb = Product::findOrFail($id);
            $thambnail_name = $old_product_thamb->thambnail;
        }
        // others photo
        $multiThambnail = $request->file('multi_thambnail');
        $slug2 = "multiproduct";
        if (isset($multiThambnail)) {

            // if multi_thambnails selected then old multi thambnaills will be deleted 
            $old_multi_thamb = Product::findOrFail($id);
            $del_multi_thamb = explode('|', $old_multi_thamb->multi_thambnail) ;
            foreach($del_multi_thamb as $key => $multi_thamb_del) {
                if(file_exists($multi_thamb_del)) {
                    unlink($multi_thamb_del);
                }
            }

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
            $old_multi_thamb = Product::findOrFail($id);
            $multiThamb__photo = $old_multi_thamb->multi_thambnail;
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
        Product::findOrFail($id)->update([
            'user_id' => Auth::user()->id,
            'product_code' => $product_code,
            'category_id' => $category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'name_en' => $request->name_en,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'thambnail' => $thambnail_name,
            'multi_thambnail' => $multiThamb__photo,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'discount' => $request->discount,
            'discount_tk' => $request->discount_tk,
            'minimum_quantity' => $request->minimum_quantity,
            'description' => $request->description,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
            'outside_delivery' => $request->outside_delivery,
            'return_status' => $request->return_status,
            'cash_delivery' => $request->cash_delivery,
            'inside_delivery' => $request->inside_delivery,
            'warranty_policy' => $request->warranty_policy,
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
            ProductUnit::where('product_id', $id)->update([
                'unit_id' => $unit_id,
                'image' => $product_unitImage,
                'updated_at' => Carbon::now(),
            ]);
            $req_subunit_id = 'subunit_id_'.$unit_id;
            foreach($request->$req_subunit_id as $key=>$subunit_id){
                ProductSubUnit::where('unit_id', $unit_id)->update([
                    'unit_id' => $unit_id,
                    'subunit_id' => $subunit_id,
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        Toastr::success('Product Successfully update :-)','Success');
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
        //
        $destroy = Product::findOrFail($id);
        // unit delete
        $productUnitImages = ProductUnit::where('product_id',$id)->get();

     	foreach ($productUnitImages as $productUnitImage) {
            if(file_exists($productUnitImage->image)) {
                unlink($productUnitImage->image);
            }
     		ProductUnit::where('product_id',$id)->delete();
     	}
         // subunit delete
        $productsubunits = ProductSubUnit::where('product_id',$id)->get();
     	foreach ($productsubunits as $productsubunit) {
            ProductSubUnit::where('product_id',$id)->delete();
     	}

        $delete_thamb = $destroy->thambnail;
        if(file_exists($delete_thamb)) {
            unlink($delete_thamb);
        }

        $del_multi_thamb = explode('|', $destroy->multi_thambnail) ;
        foreach($del_multi_thamb as $multi_thamb_del) {
            if(file_exists($multi_thamb_del)) {
                unlink($multi_thamb_del);
            }
        }
        $destroy->delete();
        Toastr::warning('Product Successfully Delete :)', 'Warning');
        return redirect()->back();

    }

    // this is ajax
    public function unitIdAjax(Request $request)
    {
        // return $request->getUnitId;
        $getId = $request->getUnitId;
        $unitId = Unit::findOrFail($getId);
        $subunits = SubUnit::where('unit_id', $unitId->id)->latest()->get();
        $data = NULL;
        $data .= '<div class="row mt-3" id="new_color_area_' . $unitId->id . '">
                    <div class="col-md-3">
                        <input type="hidden" class="form-control" name="unit_id[]" value="' . $unitId->id . '">
                        <label>Unit Name</label>
                        <input type="text" class="form-control" readonly value="' . $unitId->name . '">
                    </div>
                    <div class="col-md-3">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image_'.$unitId->id.'" id="image_' . $unitId->id . '">
                    </div>
                    <div class="col-md-4">
                        <label>Sub Unit</label>
                        <select name="subunit_id_'.$unitId->id.'[]" class="form-control select2" multiple="multiple" data-placeholder="Select Sub Unit">';
                            foreach($subunits as $subunit){
                                $data .= '<option value="'.$subunit->id.'">'. $subunit->name .'</option>';
                            }
        $data .=        '</select>
                    </div>
                    <div class="col-md-2">
                        <label>Action</label><br>
                        <button type="button" class="btn btn-danger" id="' . $unitId->id . '" onclick="removeNewColorAre(this)">
                            <i class="ml-1 fa fa-times"></i>
                        </button>
                    </div>
                </div> ';
        return $data;
    }

    public function productCategory($parent_id)
    {
        $subcategory = Category::where('parent_id', $parent_id)->where('child_id', NULL)->get();
        return json_encode($subcategory);
    }
    public function productSubcategory($subcategory_id)
    {
        $subsubcategory = Category::where('child_id', $subcategory_id)->get();
        return json_encode($subsubcategory);
    }
}
