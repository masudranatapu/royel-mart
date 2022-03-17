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
use App\Models\Color;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $title = "Create Product";
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number', 'asc')->get();
        $units = Unit::where('status', 1)->latest()->get();
        $colors = Color::latest()->get();
        $subunits = SubUnit::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->where('is_default', 0)->latest()->get();
        return view('admin.product.create', compact('title', 'categories', 'units', 'subunits', 'brands', 'colors'));
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
            'thumbnail' => 'required',
            'sale_price' => 'required',
            'product_type' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);
        $product_thumbnail = $request->file('thumbnail');
        $slug1 = "product";
        if (isset($product_thumbnail)) {
            //make unique name for cover_photo
            $thumbnail_name = $slug1 . '-' . uniqid() . '.' . $product_thumbnail->getClientOriginalExtension();

            $upload_path = 'media/product/';
            $image_url = $upload_path . $thumbnail_name;
            $product_thumbnail->move($upload_path, $thumbnail_name);
            $thumbnail_name = $image_url;
        } else {
            $thumbnail_name = NULL;
        }
        // others photo
        $more_images = $request->file('more_image');
        $slug2 = "multi-product";
        if (isset($more_images)) {
            foreach ($more_images as $key => $more_image) {
                // make unique name for image
                $more_image_name = $slug2 . '-' . uniqid() . '.' . $more_image->getClientOriginalExtension();
                $upload_path = 'media/multi-product/';
                $more_image_image_url = $upload_path . $more_image_name;
                $more_image->move($upload_path, $more_image_name);
                $img_arr[$key] = $more_image_image_url;
            }
            $more_image_photo = trim(implode('|', $img_arr), '|');
        } else {
            $more_image_photo = NULL;
        }
        // uniq product code setup
        $product_last = Product::select('id')->latest()->first();
        if (isset($product_last)) {
            $product_code = 'P' . sprintf('%03d', $product_last->id + 1);
        } else {
            $product_code = 'P' . sprintf('%03d', 1);
        }
        if (isset($request->subsubcategory_id)) {
            $category_id = $request->subsubcategory_id;
        } elseif (isset($request->subcategory_id)) {
            $category_id = $request->subcategory_id;
        } else {
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
            'thumbnail' => $thumbnail_name,
            'more_image' => $more_image_photo,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'discount' => $request->discount,
            'discount_tk' => $request->discount_tk,
            'alert_quantity' => $request->alert_quantity,
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

        if ($request->unit_id != '') {
            ProductUnit::insert([
                'product_id' => $product_id,
                'unit_id' => $request->unit_id,
                'created_at' => Carbon::now(),
            ]);
        }

        if (is_array($request->color_id) || is_object($request->color_id)) {
            foreach ($request->color_id as $key => $color_id) {
                // unit Image photo
                $colorImageGet = 'image_' . $color_id;
                $getUnitImage = $request->file($colorImageGet);
                $slug3 = "color-image";
                if (isset($getcolorImage)) {
                    $colorImage_name = $slug3 . '-' . uniqid() . '.' . $getcolorImage->getClientOriginalExtension();
                    $upload_path = 'media/color-image/';
                    $colorImage_image_url = $upload_path . $colorImage_name;
                    $getcolorImage->move($upload_path, $colorImage_name);
                    $product_colorImage = $colorImage_image_url;
                } else {
                    $product_colorImage = NULL;
                }
                ProductColor::insert([
                    'product_id' => $product_id,
                    'color_id' => $color_id,
                    'image' => $product_colorImage,
                    'created_at' => Carbon::now(),
                ]);
                $req_size_id = 'size_id_' . $color_id;
                if ($request->$req_size_id) {
                    foreach ($request->$req_size_id as $key => $size_id) {
                        ProductSize::insert([
                            'product_id' => $product_id,
                            'color_id' => $color_id,
                            'size_id' => $size_id,
                            'created_at' => Carbon::now(),
                        ]);
                    }
                }
            }
        }
        Toastr::success('Product Successfully Save :-)', 'Success');
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
        $product = Product::find($id);
        $check_cat = Category::find($product->category_id);

        if($check_cat->parent_id != NULL && $check_cat->child_id != NULL){
            $main_cat = $check_cat->parent_id;
            $parent_cat = $check_cat->child_id;
            $child_cat = $check_cat->id;
        }elseif($check_cat->parent_id != NULL && $check_cat->child_id == NULL){
            $main_cat = $check_cat->parent_id;
            $parent_cat = $check_cat->id;
            $child_cat = NULL;
        }elseif($check_cat->parent_id == NULL && $check_cat->child_id == NULL){
            $main_cat = $check_cat->id;
            $parent_cat = NULL;
            $child_cat = NULL;
        }else{
            $main_cat = NULL;
            $parent_cat = NULL;
            $child_cat = NULL;
        }


        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number', 'asc')->get();
        $subcategory = Category::where('parent_id', '!=', NULL)->where('child_id', NULL)->latest()->get();
        $subsubcategory = Category::where('parent_id', '!=', NULL)->where('child_id', '!=', NULL)->latest()->get();
        $title = "Edit Product";
        $brands = Brand::where('status', 1)->where('is_default', '0')->latest()->get();
        $colors = Color::latest()->get();
        $units = Unit::where('status', 1)->latest()->get();
        $products = Product::where('id', $id)->first();
        $productUnits = ProductUnit::where('product_id', $id)->latest()->get();
        $productColors = ProductColor::where('product_id', $id)->latest()->get();
        return view('admin.product.edit', compact('title', 'brands', 'units', 'categories', 'subcategory', 'main_cat', 'parent_cat', 'child_cat', 'subsubcategory', 'products', 'productUnits', 'colors', 'productColors'));
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
        // return $request;
        $this->validate($request, [
            'name' => 'required',
            'sale_price' => 'required',
            'product_type' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        $product = Product::findOrFail($id);

        $product_thumbnail = $request->file('thumbnail');
        $slug1 = "product";
        if (isset($product_thumbnail)) {
            $old_product_thamb = Product::findOrFail($id);
            $delete_thamb = $old_product_thamb->thumbnail;
            if (file_exists($delete_thamb)) {
                unlink($delete_thamb);
            }

            //make unique name for cover_photo
            $thumbnail_name = $slug1 . '-' . uniqid() . '.' . $product_thumbnail->getClientOriginalExtension();

            $upload_path = 'media/product/';
            $image_url = $upload_path . $thumbnail_name;
            $product_thumbnail->move($upload_path, $thumbnail_name);
            $product->thumbnail = $image_url;
        }

        // others photo
        $more_images = $request->file('more_image');
        $slug2 = "multi-product";
        if (isset($more_images)) {

            $old_multi_thamb = Product::findOrFail($id);
            $del_multi_thamb = explode('|', $old_multi_thamb->more_image);
            foreach ($del_multi_thamb as $key => $multi_thamb_del) {
                if (file_exists($multi_thamb_del)) {
                    unlink($multi_thamb_del);
                }
            }

            foreach ($more_images as $key => $more_image) {
                // make unique name for image
                $more_image_name = $slug2 . '-' . uniqid() . '.' . $more_image->getClientOriginalExtension();
                $upload_path = 'media/multi-product/';
                $more_image_url = $upload_path . $more_image_name;
                $more_image->move($upload_path, $more_image_name);
                $img_arr[$key] = $more_image_url;
            }
            $more_image_photo = trim(implode('|', $img_arr), '|');
            $product->more_image = $more_image_photo;
        }

        if (isset($request->child_id)) {
            $category_id = $request->child_id;
        } elseif (isset($request->parent_id)) {
            $category_id = $request->parent_id;
        } else {
            $category_id = $request->category_id;
        }

        $product->category_id = $category_id;
        $product->brand_id = $request->brand_id;
        $product->name = $request->name;
        $product->name_en = $request->name_en;
        $product->slug = strtolower(str_replace(' ', '-', $request->name));
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->discount = $request->discount;
        $product->discount_tk = $request->discount_tk;
        $product->alert_quantity = $request->alert_quantity;
        $product->description = $request->description;
        $product->meta_description = $request->meta_description;
        $product->meta_keyword = $request->meta_keyword;
        $product->outside_delivery = $request->outside_delivery;
        $product->return_status = $request->return_status;
        $product->cash_delivery = $request->cash_delivery;
        $product->inside_delivery = $request->inside_delivery;
        $product->warranty_policy = $request->warranty_policy;
        $product->schema = $request->schema;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->save();

        if ($request->unit_id != '') {
            ProductUnit::insert([
                'product_id' => $id,
                'unit_id' => $request->unit_id,
                'created_at' => Carbon::now(),
            ]);
        }

        // return $request->color_id;

        if ($request->color_id) {
            foreach ($request->color_id as $key => $color_id) {
                // unit Image photo
                $unitImageGet = 'image_' . $color_id;
                $getUnitImage = $request->file($unitImageGet);
                $slug3 = "color-mage";
                if (isset($getUnitImage)) {
                    $unitImage_name = $slug3 . '-' . uniqid() . '.' . $getUnitImage->getClientOriginalExtension();
                    $upload_path = 'media/color-image/';
                    $unitImage_image_url = $upload_path . $unitImage_name;
                    $getUnitImage->move($upload_path, $unitImage_name);
                    $product_colorImage = $unitImage_image_url;
                } else {
                    $product_colorImage = NULL;
                }
                $check_color = ProductColor::where('product_id', $id)->where('color_id', $color_id)->first();
                if ($check_color) {
                    $pro_color = ProductColor::find($check_color->id);
                    $pro_color->color_id = $color_id;
                    $pro_color->image = $product_colorImage;
                    $pro_color->save();
                } else {
                    $pro_color = new ProductColor();
                    $pro_color->product_id = $id;
                    $pro_color->color_id = $color_id;
                    $pro_color->image = $product_colorImage;
                    $pro_color->save();
                }
                $req_size_id = 'size_id_' . $color_id;

                // return $request->$req_size_id;

                if ($request->$req_size_id) {
                    foreach ($request->$req_size_id as $key => $size_id) {
                        $check_size = ProductSize::where('product_id', $id)->where('color_id', $color_id)->where('size_id', $size_id)->first();
                        if ($check_size) {
                            $pro_size = ProductSize::find($check_size->id);
                            $pro_size->color_id = $color_id;
                            $pro_size->size_id = $size_id;
                            $pro_size->save();
                        } else {
                            $pro_size = new ProductSize();
                            $pro_size->product_id = $id;
                            $pro_size->color_id = $color_id;
                            $pro_size->size_id = $size_id;
                            $pro_size->save();
                        }
                    }
                }
            }
        }


        Toastr::success('Product Successfully update :-)', 'Success');
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
        $productUnitImages = ProductUnit::where('product_id', $id)->get();

        foreach ($productUnitImages as $productUnitImage) {
            if (file_exists($productUnitImage->image)) {
                unlink($productUnitImage->image);
            }
            ProductUnit::where('product_id', $id)->delete();
        }
        // subunit delete
        $productsubunits = ProductSubUnit::where('product_id', $id)->get();
        foreach ($productsubunits as $productsubunit) {
            ProductSubUnit::where('product_id', $id)->delete();
        }

        $delete_thamb = $destroy->thumbnail;
        if (file_exists($delete_thamb)) {
            unlink($delete_thamb);
        }

        $del_multi_thamb = explode('|', $destroy->multi_thumbnail);
        foreach ($del_multi_thamb as $multi_thamb_del) {
            if (file_exists($multi_thamb_del)) {
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
                        <input type="file" class="form-control" name="image_' . $unitId->id . '" id="image_' . $unitId->id . '">
                    </div>
                    <div class="col-md-4">
                        <label>Sub Unit</label>
                        <select name="subunit_id_' . $unitId->id . '[]" class="form-control select2" multiple="multiple" data-placeholder="Select Sub Unit">';
        foreach ($subunits as $subunit) {
            $data .= '<option value="' . $subunit->id . '">' . $subunit->name . '</option>';
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

    // this is ajax
    public function colorIdAjax(Request $request)
    {
        // return $request->getUnitId;
        $getId = $request->getColorId;
        $colorId = Color::findOrFail($getId);
        $sizes = Size::where('color_id', $colorId->id)->latest()->get();
        $data = NULL;
        $data .= '<div class="row mt-3" id="new_color_area_' . $colorId->id . '">
                    <div class="col-md-3">
                        <input type="hidden" class="form-control" name="color_id[]" value="' . $colorId->id . '">
                        <label>Unit Name</label>
                        <input type="text" class="form-control" readonly value="' . $colorId->name . '">
                    </div>
                    <div class="col-md-3">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image_' . $colorId->id . '" id="image_' . $colorId->id . '">
                    </div>
                    <div class="col-md-4">
                        <label>Sub Unit</label>
                        <select name="size_id_' . $colorId->id . '[]" class="form-control select2 multiple" multiple data-placeholder="Select Sub Unit">';
        foreach ($sizes as $size) {
            $data .= '<option value="' . $size->id . '">' . $size->name . '</option>';
        }
        $data .=        '</select>
                    </div>
                    <div class="col-md-2">
                        <label>Action</label><br>
                        <button type="button" class="btn btn-danger" id="' . $colorId->id . '" onclick="removeNewColorAre(this)">
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
