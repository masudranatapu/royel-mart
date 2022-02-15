<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Banner";
        $banners = Banner::latest()->get();
        return view('admin.banner.index', compact('title', 'banners'));
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
            'link' => 'required',
            'image' => 'required',
        ]);

        $banner_image = $request->file('image');
        $slug = 'banner';
        $banner_image_name = $slug.'-'.uniqid().'.'.$banner_image->getClientOriginalExtension();
        $upload_path = 'media/banner/';
        $banner_image->move($upload_path, $banner_image_name);

        $image_url = $upload_path.$banner_image_name;
        
        Banner::insert([
            'link'=> $request->link,
            'image' => $image_url,
            'status' => "1",
            'created_at' => Carbon::now(),
        ]);
        Toastr::success('Banner Successfully Save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function bannerActive($id)
    {
        //
        Banner::findOrFail($id)->update(['status' => '1']);
        Toastr::success('Banner Successfully Inactive :-)','Success');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function bannerInactive($id)
    {
        //
        Banner::findOrFail($id)->update(['status' => '0']);
        Toastr::info('Banner Successfully Inactive :-)','Success');
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
            'link' => 'required',
        ]);
        
        $banner_image = $request->file('image');
        $slug = 'banner';
        if(isset($banner_image)) {
            $banner_image_name = $slug.'-'.uniqid().'.'.$banner_image->getClientOriginalExtension();
            $upload_path = 'media/banner/';
            $banner_image->move($upload_path, $banner_image_name);

            $bannerimage = banner::findOrFail($id);
            if ($bannerimage->image) {
                unlink($bannerimage->image);
            }
            $image_url = $upload_path.$banner_image_name;
            Banner::findOrFail($id)->update([
                'link'=> $request->link,
                'image' => $image_url,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::success('banner Successfully Save :-)','Success');
            return redirect()->back();
        }else {
            Banner::findOrFail($id)->update([
                'link'=> $request->link,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::success('banner successfully save without image :-)','Success');
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
        $banner =Banner::findOrFail($id);
        $deleteImage = $banner->image;

        if(file_exists($deleteImage)) {
            unlink($deleteImage);
        }
        $banner->delete();
        Toastr::warning('banner Successfully delete :-)','Info');
        return redirect()->back();
    }
}
