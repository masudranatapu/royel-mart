<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryBanner;
use App\Models\Category;
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
        //
        $title = "Category Banner";
        $categorybanners = CategoryBanner::latest()->get();
        $categories = Category::where('status', 1)->latest()->get();
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
        //
        $this->validate($request, [
            'category_id' => 'required',
            'image' => 'required',
        ]);
        
        $categorybanner_image = $request->file('image');
        $slug = 'categorybanner';
        $categorybanner_image_name = $slug.'-'.uniqid().'.'.$categorybanner_image->getClientOriginalExtension();
        $upload_path = 'media/categorybanner/';
        $categorybanner_image->move($upload_path, $categorybanner_image_name);

        $image_url = $upload_path.$categorybanner_image_name;
        
        CategoryBanner::insert([
            'category_id' => $request->category_id,
            'image' => $image_url,
            'status' => "1",
            'created_at' => Carbon::now(),
        ]);
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
        //
        $this->validate($request, [
            'category_id' => 'required',
        ]);
        
        $categorybanner_image = $request->file('image');
        $slug = 'categorybanner';
        if(isset($categorybanner_image)) {
            $categorybanner_image_name = $slug.'-'.uniqid().'.'.$categorybanner_image->getClientOriginalExtension();
            $upload_path = 'media/categorybanner/';
            $categorybanner_image->move($upload_path, $categorybanner_image_name);
            
            $old_categorybanner_image = CategoryBanner::findOrFail($id);
            if($old_categorybanner_image->image){
                unlink($old_categorybanner_image->image);
            }
            $image_url = $upload_path.$categorybanner_image_name;

            CategoryBanner::findOrFail($id)->update([
                'category_id' => $request->category_id,
                'image' => $image_url,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::success('Category banner successfully save :-)','Success');
            return redirect()->back();
        }else {
            CategoryBanner::findOrFail($id)->update([
                'category_id' => $request->category_id,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::success('Category banner successfully save without image :-)','Success');
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
        $categorybanner = CategoryBanner::findOrFail($id);
        $delteImage = $categorybanner->image;

        if(file_exists($delteImage)) {
            unlink($delteImage);
        }

        $categorybanner->delete();
        Toastr::info('Category Banner Successfully delete :-)','Success');
        return redirect()->back();
    }
}
