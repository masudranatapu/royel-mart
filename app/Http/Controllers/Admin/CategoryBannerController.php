<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryBanner;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class CategoryBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Category Banner";
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number','asc')->latest()->get();
        $categorybanners = CategoryBanner::with('category')->latest()->get();
        return view('admin.categorybanner.index', compact('title', 'categorybanners', 'categories'));
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
            'image' => 'required',
        ]);

        $categorybanner_image = $request->file('image');
        $slug = 'categorybanner';
        $categorybanner_image_name = $slug.'-'.uniqid().'.'.$categorybanner_image->getClientOriginalExtension();
        $upload_path = 'media/categorybanner/';
        $categorybanner_image->move($upload_path, $categorybanner_image_name);

        $image_url = $upload_path.$categorybanner_image_name;

        $cat_banner = new CategoryBanner();
        if($request->parent_id == '' && $request->child_id == ''){
            $cat_banner->cat_id = $request->category_id;
        }elseif($request->parent_id != '' && $request->child_id == ''){
            $cat_banner->cat_id = $request->parent_id;
        }elseif($request->parent_id != '' && $request->child_id != ''){
            $cat_banner->cat_id = $request->child_id;
        }
        $cat_banner->link = $request->link;
        $cat_banner->image = $image_url;
        $cat_banner->status = 1;
        $cat_banner->save();

        Toastr::success('Category banner successfully save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categoryBannerActive($id)
    {
        //
        CategoryBanner::findOrFail($id)->update(['status' => '1']);
        Toastr::success('Category banner successfully active :-)','Success');
        return redirect()->back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categoryBannerInactive($id)
    {
        //
        CategoryBanner::findOrFail($id)->update(['status' => '0']);
        Toastr::success('Category banner successfully inactive :-)','Success');
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
        $cat_banner = CategoryBanner::find($id);

        $categorybanner_image = $request->file('image');

        $slug = 'categorybanner';
        if($categorybanner_image){
            if(file_exists($cat_banner->image)){
                unlink($cat_banner->image);
            }
            $categorybanner_image_name = $slug.'-'.uniqid().'.'.$categorybanner_image->getClientOriginalExtension();
            $upload_path = 'media/categorybanner/';
            $categorybanner_image->move($upload_path, $categorybanner_image_name);

            $image_url = $upload_path.$categorybanner_image_name;
            $cat_banner->image = $image_url;
        }

        $cat_banner->link = $request->link;
        $cat_banner->save();

        Toastr::success('Category banner successfully save :-)','Success');
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
        $categorybanner = CategoryBanner::findOrFail($id);

        if(file_exists($categorybanner->image)) {
            unlink($categorybanner->image);
        }

        $categorybanner->delete();
        Toastr::info('Category Banner Successfully delete :-)','Success');
        return redirect()->back();
    }
}
