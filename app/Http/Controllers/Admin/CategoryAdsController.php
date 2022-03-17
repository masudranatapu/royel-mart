<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryAds;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class CategoryAdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Category Ads";
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number','asc')->latest()->get();
        $categoryads = CategoryAds::with('category')->latest()->get();
        return view('admin.categoryads.index', compact('title', 'categoryads', 'categories'));
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

        $category_image = $request->file('image');
        $slug = 'category-ads';
        if(isset($category_image)) {
            $category_image_name = $slug.'-'.uniqid().'.'.$category_image->getClientOriginalExtension();
            $upload_path = 'media/category-ads/';
            $category_image->move($upload_path, $category_image_name);

            $image_url = $upload_path.$category_image_name;
        }else {
            $image_url = NULL;
        }

        $ads = new CategoryAds();
        if($request->parent_id == '' && $request->child_id == ''){
            $ads->cat_id = $request->category_id;
        }elseif($request->parent_id != '' && $request->child_id == ''){
            $ads->cat_id = $request->parent_id;
        }elseif($request->parent_id != '' && $request->child_id != ''){
            $ads->cat_id = $request->child_id;
        }
        $ads->name = $request->name;
        $ads->link = $request->link;
        $ads->image = $image_url;
        $ads->status = 1;
        $ads->save();

        Toastr::success('Category successfully save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function categoryAdsActive($id)
    {
        //
        CategoryAds::findOrFail($id)->update(['status' => '1']);
        Toastr::success('CategoryAds Successfully Inactive :-)','Success');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function categoryAdsInactive($id)
    {
        //
        CategoryAds::findOrFail($id)->update(['status' => '0']);
        Toastr::info('CategoryAds Successfully Inactive :-)','Success');
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

        $ads = CategoryAds::find($id);

        $category_image = $request->file('image');
        $slug = 'category-ads';
        if(isset($category_image)) {
            if(file_exists($ads->image)){
                unlink($ads->image);
            }
            $category_image_name = $slug.'-'.uniqid().'.'.$category_image->getClientOriginalExtension();
            $upload_path = 'media/category-ads/';
            $category_image->move($upload_path, $category_image_name);

            $category_old_image = CategoryAds::findOrFail($id);
            if ($category_old_image->image) {
                unlink($category_old_image->image);
            }
            $image_url = $upload_path.$category_image_name;
            $ads->image = $image_url;
        }

        $ads->name = $request->name;
        $ads->link = $request->link;
        $ads->save();

        Toastr::info('Category ads successfully updated :-)','Success');
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
        $ads =CategoryAds::findOrFail($id);

        if(file_exists($ads->image)){
            unlink($ads->image);
        }
        $ads->delete();

        Toastr::warning('Category ads successfully delete :-)','Success');
        return redirect()->back();
    }
}
