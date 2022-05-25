<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryShippingChargeVariant;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $cats = Category::all();
        // foreach($cats as $cat){
        //     $catt = Category::find($cat->id);
        //     $catt->serial_number = 0;
        //     $catt->save();
        // }
        $title = "Category";
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number','asc')->get();
        $serial = Category::where('status', '1')->where('is_default', '0')->max('serial_number') + 1;
        return view('admin.category.index', compact('title', 'categories', 'serial'));
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
        // return $request;
        $this->validate($request, [
            'name' => 'required',
        ]);

        if($request->menu) {
            $menuStatus = $request->menu;
        }else{
            $menuStatus = "0";
        }

        if($request->feature) {
            $featureStatus = $request->feature;
        }else {
            $featureStatus = "0";
        }

        if($request->show_hide) {
            $showHideStatus = $request->show_hide;
        }else {
            $showHideStatus = "0";
        }

        $category_image = $request->file('image');
        $slug = 'category';
        if(isset($category_image)) {
            $category_image_name = $slug.'-'.uniqid().'.'.$category_image->getClientOriginalExtension();
            $upload_path = 'media/category/';
            $category_image->move($upload_path, $category_image_name);

            $image_url = $upload_path.$category_image_name;
        }else {
            $image_url = NULL;
        }

        if($request->parent_id == '' && $request->child_id == ''){
            $pre_check_cats = Category::where('serial_number', '<', $request->serial_number)->where('parent_id', NULL)->where('child_id', NULL)->where('status', '1')->where('is_default', '0')->orderBy('serial_number', "ASC")->get();
            $pre_sl = 1;
            if($pre_check_cats->count() > 0){
                foreach($pre_check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->serial_number = $pre_sl;
                    $cat->save();

                    $pre_sl = $pre_sl + 1;
                }
            }
        }elseif($request->parent_id != '' && $request->child_id == ''){
            $pre_check_cats = Category::where('parent_serial', '<', $request->serial_number)->where('parent_id', '!=', NULL)->where('child_id', NULL)->where('status', '1')->where('is_default', '0')->orderBy('parent_serial', "ASC")->get();
            $pre_sl = 1;
            if($pre_check_cats->count() > 0){
                foreach($pre_check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->parent_serial = $pre_sl;
                    $cat->save();

                    $pre_sl = $pre_sl + 1;
                }
            }
        }elseif($request->parent_id != '' && $request->child_id != ''){
            $pre_check_cats = Category::where('child_serial', '<', $request->serial_number)->where('parent_id', '!=', NULL)->where('child_id', '!=', NULL)->where('status', '1')->where('is_default', '0')->orderBy('child_serial', "ASC")->get();
            $pre_sl = 1;
            if($pre_check_cats->count() > 0){
                foreach($pre_check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->child_serial = $pre_sl;
                    $cat->save();

                    $pre_sl = $pre_sl + 1;
                }
            }
        }

        if($request->parent_id == '' && $request->child_id == ''){
            $check_cats = Category::where('serial_number', '>=', $request->serial_number)->where('parent_id', NULL)->where('child_id', NULL)->where('status', '1')->where('is_default', '0')->orderBy('serial_number', "ASC")->get();
            if($check_cats->count() > 0){
                foreach($check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->serial_number = $cat->serial_number + 1;
                    $cat->save();
                }
            }
        }elseif($request->parent_id != '' && $request->child_id == ''){
            $check_cats = Category::where('parent_serial', '>=', $request->serial_number)->where('parent_id', '!=', NULL)->where('child_id', NULL)->where('status', '1')->where('is_default', '0')->orderBy('parent_serial', "ASC")->get();
            if($check_cats->count() > 0){
                foreach($check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->parent_serial = $cat->parent_serial + 1;
                    $cat->save();
                }
            }
        }elseif($request->parent_id != '' && $request->child_id != ''){
            $check_cats = Category::where('child_serial', '>=', $request->serial_number)->where('parent_id', '!=', NULL)->where('child_id', '!=', NULL)->where('status', '1')->where('is_default', '0')->orderBy('child_serial', "ASC")->get();
            if($check_cats->count() > 0){
                foreach($check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->child_serial = $cat->child_serial + 1;
                    $cat->save();
                }
            }
        }

        $cat_slug = strtolower(str_replace(' ', '-', $request->name));

        $category = new Category();
        $category->parent_id = $request->parent_id;
        $category->child_id = $request->child_id;
        $category->name = $request->name;
        $category->slug = $cat_slug;
        $category->image = $image_url;
        $category->menu = $menuStatus;
        $category->feature = $featureStatus;
        if($request->parent_id == '' && $request->child_id == ''){
            $category->serial_number = $request->serial_number;
        }elseif($request->parent_id != '' && $request->child_id == ''){
            $category->parent_serial = $request->serial_number;
        }elseif($request->parent_id != '' && $request->child_id != ''){
            $category->child_serial = $request->serial_number;
        }
        $category->show_hide = $showHideStatus;

        $category->save();

        $check_category = Category::where('slug', $cat_slug)->first();

        $charge_variant = new CategoryShippingChargeVariant();
        $charge_variant->category_id = $check_category->id;
        $charge_variant->qty_one_charge_variant = 0;
        $charge_variant->qty_two_charge_variant = 0;
        $charge_variant->qty_three_charge_variant = 0;
        $charge_variant->qty_four_charge_variant = 0;
        $charge_variant->qty_five_charge_variant = 0;
        $charge_variant->qty_more_than_five_charge_variant = 0;
        $charge_variant->save();

        Toastr::success('Category successfully save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categoryActive($id)
    {
        Category::findOrFail($id)->update(['status' => '1']);
        Toastr::info('Category Successfully Active :-)','Success');
        return redirect()->back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categoryInactive($id)
    {
        Category::findOrFail($id)->update(['status' => '0']);
        Toastr::info('Category Successfully Inactive :-)','Success');
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
        // return $request;
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = Category::find($id);

        if($request->menu) {
            $menuStatus = $request->menu;
        }else{
            $menuStatus = "0";
        }

        if($request->feature) {
            $featureStatus = $request->feature;
        }else {
            $featureStatus = "0";
        }

        if($request->show_hide) {
            $showHideStatus = $request->show_hide;
        }else {
            $showHideStatus = "0";
        }

        if($request->parent_id == '' && $request->child_id == ''){
            $pre_check_cats = Category::where('serial_number', '<', $request->serial_number)->where('parent_id', NULL)->where('child_id', NULL)->where('status', '1')->where('is_default', '0')->orderBy('serial_number', "ASC")->get();
            $pre_sl = 1;
            if($pre_check_cats->count() > 0){
                foreach($pre_check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->serial_number = $pre_sl;
                    $cat->save();

                    $pre_sl = $pre_sl + 1;
                }
            }
        }elseif($request->parent_id != '' && $request->child_id == ''){
            $pre_check_cats = Category::where('parent_serial', '<', $request->serial_number)->where('parent_id', '!=', NULL)->where('child_id', NULL)->where('status', '1')->where('is_default', '0')->orderBy('parent_serial', "ASC")->get();
            $pre_sl = 1;
            if($pre_check_cats->count() > 0){
                foreach($pre_check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->parent_serial = $pre_sl;
                    $cat->save();

                    $pre_sl = $pre_sl + 1;
                }
            }
        }elseif($request->parent_id != '' && $request->child_id != ''){
            $pre_check_cats = Category::where('child_serial', '<', $request->serial_number)->where('parent_id', '!=', NULL)->where('child_id', '!=', NULL)->where('status', '1')->where('is_default', '0')->orderBy('child_serial', "ASC")->get();
            $pre_sl = 1;
            if($pre_check_cats->count() > 0){
                foreach($pre_check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->child_serial = $pre_sl;
                    $cat->save();

                    $pre_sl = $pre_sl + 1;
                }
            }
        }

        if($request->parent_id == '' && $request->child_id == ''){
            $check_cats = Category::where('serial_number', '>=', $request->serial_number)->where('parent_id', NULL)->where('child_id', NULL)->where('status', '1')->where('is_default', '0')->orderBy('serial_number', "ASC")->get();
            if($check_cats->count() > 0){
                foreach($check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->serial_number = $cat->serial_number + 1;
                    $cat->save();
                }
            }
        }elseif($request->parent_id != '' && $request->child_id == ''){
            $check_cats = Category::where('parent_serial', '>=', $request->serial_number)->where('parent_id', '!=', NULL)->where('child_id', NULL)->where('status', '1')->where('is_default', '0')->orderBy('parent_serial', "ASC")->get();
            if($check_cats->count() > 0){
                foreach($check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->parent_serial = $cat->parent_serial + 1;
                    $cat->save();
                }
            }
        }elseif($request->parent_id != '' && $request->child_id != ''){
            $check_cats = Category::where('child_serial', '>=', $request->serial_number)->where('parent_id', '!=', NULL)->where('child_id', '!=', NULL)->where('status', '1')->where('is_default', '0')->orderBy('child_serial', "ASC")->get();
            if($check_cats->count() > 0){
                foreach($check_cats as $check_cat){
                    $cat = Category::find($check_cat->id);
                    $cat->child_serial = $cat->child_serial + 1;
                    $cat->save();
                }
            }
        }

        $category_image = $request->file('image');
        $slug = 'category';
        if(isset($category_image)) {
            if (file_exists($category->image)) {
                unlink($category->image);
            }
            $category_image_name = $slug.'-'.uniqid().'.'.$category_image->getClientOriginalExtension();
            $upload_path = 'media/category/';
            $category_image->move($upload_path, $category_image_name);
            $category->image = $upload_path.$category_image_name;
        }

        $category->parent_id = $request->parent_id;
        $category->child_id = $request->child_id;
        $category->name = $request->name;
        $category->slug = strtolower(str_replace(' ', '-', $request->name));
        $category->menu = $menuStatus;
        $category->feature = $featureStatus;
        if($request->parent_id == '' && $request->child_id == ''){
            $category->serial_number = $request->serial_number;
        }elseif($request->parent_id != '' && $request->child_id == ''){
            $category->parent_serial = $request->serial_number;
        }elseif($request->parent_id != '' && $request->child_id != ''){
            $category->child_serial = $request->serial_number;
        }
        $category->show_hide = $showHideStatus;
        $category->save();

        $variant_decrease_charge = CategoryShippingChargeVariant::where('category_id', $id)->first();

        if($variant_decrease_charge == ''){
            $charge_variant = new CategoryShippingChargeVariant();
            $charge_variant->category_id = $id;
            $charge_variant->qty_one_charge_variant = 0;
            $charge_variant->qty_two_charge_variant = 0;
            $charge_variant->qty_three_charge_variant = 0;
            $charge_variant->qty_four_charge_variant = 0;
            $charge_variant->qty_five_charge_variant = 0;
            $charge_variant->qty_more_than_five_charge_variant = 0;
            $charge_variant->save();
        }


        Toastr::info('Category successfully updated :-)','Success');
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
        $categories = Category::findOrFail($id);

        if(file_exists($categories->image)) {
            unlink($categories->image);
        }

        $default_cat = Category::where('is_default', '1')->first();
        Product::where('category_id', $id)->update([
            'category_id' => $default_cat->id,
        ]);

        $categories->delete();
        Toastr::warning('Category Successfully delete :-)','Info');
        return redirect()->back();
    }

    public function viewParentCategory($slug)
    {
        $main_cat = Category::where('slug', $slug)->first();
        $title = "Parent Category";
        $parentcategories = Category::where('parent_id', $main_cat->id)->where('child_id', NULL)->orderBy('parent_serial','asc')->get();
        $serial = Category::where('status', '1')->where('is_default', '0')->max('parent_serial') + 1;
        return view('admin.category.parentcategory', compact('title', 'main_cat', 'parentcategories', 'serial'));
    }

    public function viewChildCategory($slug)
    {
        $childcategory = Category::where('slug', $slug)->first();
        $main_cat = Category::find($childcategory->parent_id);
        $title = "Child Category";
        $childcategories = Category::where('child_id', $childcategory->id)->orderBy('child_serial','asc')->get();
        $serial = Category::where('status', '1')->where('is_default', '0')->max('child_serial') + 1;
        return view('admin.category.childcategory', compact('title', 'childcategory', 'childcategories', 'main_cat', 'serial'));
    }

}
