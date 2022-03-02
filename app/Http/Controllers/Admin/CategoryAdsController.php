<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $categoryads = CategoryAds::latest()->get();
        return view('admin.categoryads.index', compact('title', 'categoryads'));
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
        $slug = 'categoryads';
        if(isset($category_image)) {
            $category_image_name = $slug.'-'.uniqid().'.'.$category_image->getClientOriginalExtension();
            $upload_path = 'media/categoryads/';
            $category_image->move($upload_path, $category_image_name);
    
            $image_url = $upload_path.$category_image_name;
        }else {
            $image_url = NULL;
        }
        CategoryAds::insert([
            'name' => $request->name,
            'link' => $request->link,
            'image' => $image_url,
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

        $category_image = $request->file('image');
        $slug = 'categoryads';
        if(isset($category_image)) {
            $category_image_name = $slug.'-'.uniqid().'.'.$category_image->getClientOriginalExtension();
            $upload_path = 'media/categoryads/';
            $category_image->move($upload_path, $category_image_name);
            
            $category_old_image = CategoryAds::findOrFail($id);
            if ($category_old_image->image) {
                unlink($category_old_image->image);
            }
            $image_url = $upload_path.$category_image_name;
            CategoryAds::findOrFail($id)->update([
                'name' => $request->name,
                'link' => $request->link,
                'image' => $image_url,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::info('Category ads successfully updated :-)','Success');
            return redirect()->back();
        }else {
            CategoryAds::findOrFail($id)->update([
                'name' => $request->name,
                'link' => $request->link,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::info('Category ads successfully updated :-)','Success');
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
        $categoryads =CategoryAds::findOrFail($id);
        $deleteImage = $categoryads->image;

        if(file_exists($deleteImage)) {
            unlink($deleteImage);
        }
        $categoryads->delete();
        Toastr::warning('Category ads successfully delete :-)','Success');
        return redirect()->back();
    }
}
