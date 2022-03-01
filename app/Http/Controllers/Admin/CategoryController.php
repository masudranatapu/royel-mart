<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
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
        $title = "Category";
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->latest()->get();
        return view('admin.category.index', compact('title', 'categories'));
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
        //
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
        Category::insert([
            'parent_id' => $request->parent_id,
            'child_id' => $request->child_id,
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'image' => $image_url,
            'menu' => $menuStatus,
            'feature' => $featureStatus,
            'category_color' => $request->category_color,
            'serial_number' => $request->serial_number,
            'show_hide' => $showHideStatus,
            'status' => "1",
            'created_at' => Carbon::now(),
        ]);
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
        //
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
        //
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
        //
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
            
            $category_old_image = Category::findOrFail($id);
            if ($category_old_image->image) {
                unlink($category_old_image->image);
            }
            $image_url = $upload_path.$category_image_name;
            Category::findOrFail($id)->update([
                'parent_id' => $request->parent_id,
                'child_id' => $request->child_id,
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'image' => $image_url,
                'menu' => $menuStatus,
                'feature' => $featureStatus,
                'category_color' => $request->category_color,
                'serial_number' => $request->serial_number,
                'show_hide' => $showHideStatus,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::info('Category successfully updated :-)','Success');
            return redirect()->back();
        }else {
            Category::findOrFail($id)->update([
                'parent_id' => $request->parent_id,
                'child_id' => $request->child_id,
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'menu' => $menuStatus,
                'feature' => $featureStatus,
                'category_color' => $request->category_color,
                'serial_number' => $request->serial_number,
                'show_hide' => $showHideStatus,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::info('Category successfully updated :-)','Success');
            return redirect()->back();
        }
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
        $categories =Category::findOrFail($id);
        $deleteImage = $categories->image;
        if(file_exists($deleteImage)) {
            unlink($deleteImage);
        }
        Product::where('category_id', $id)->update([
            'category_id' => '1',
        ]);
        
        $categories->delete();
        Toastr::warning('Category Successfully delete :-)','Info');
        return redirect()->back();
    }
    
    public function viewParentCategory($id)
    {
        //
        $parentcategory = Category::findOrFail($id);
        $title = "Parent Category";
        $parentcategories = Category::where('parent_id', $id)->where('child_id', NULL)->latest()->get();
        return view('admin.category.parentcategory', compact('title', 'parentcategory', 'parentcategories'));
    }
    public function viewChildCategory($id)
    {
        //
        $childcategory = Category::findOrFail($id);
        // return $childcategory;
        $title = "Child Category";
        $childcategories = Category::where('child_id', $id)->latest()->get();
        return view('admin.category.childcategory', compact('title', 'childcategory', 'childcategories'));
    }
}