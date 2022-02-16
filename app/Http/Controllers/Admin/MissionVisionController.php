<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\MissionVision;
use Carbon\Carbon;

class MissionVisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Mission Vision";
        $missionvisions = MissionVision::latest()->get();
        return view('admin.missionvision.index', compact('title', 'missionvisions'));
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
            'image' => 'required',
            'details' => 'required',
        ]);

        $missionvision_image = $request->file('image');

        $slug = 'missionvision';
        if(isset($missionvision_image)) {
            $missionvision_image_name = $slug.'-'.uniqid().'.'.$missionvision_image->getClientOriginalExtension();
            $upload_path = 'media/missionvision/';
            $missionvision_image->move($upload_path, $missionvision_image_name);
    
            $image_url = $upload_path.$missionvision_image_name;
        }else {
            $image_url = NULL;
        }

        MissionVision::insert([
            'name' => $request->name,
            'image' => $image_url,
            'details' => $request->details,
            'status'=> '1',
            'created_at' => Carbon::now(),
        ]);
        Toastr::success('Mission vision successfully save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function missionVisionActive($id)
    {
        //
        MissionVision::findOrFail($id)->update(['status' => '1']);
        Toastr::success('MissionVision Successfully active :-)','Success');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function missionVisionInactive($id)
    {
        //
        MissionVision::findOrFail($id)->update(['status' => '0']);
        Toastr::success('MissionVision Successfully inactive :-)','Success');
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

        $missionvision_image = $request->file('image');
        $slug = 'missionvision';
        if(isset($missionvision_image)) {
            $missionvision_image_name = $slug.'-'.uniqid().'.'.$missionvision_image->getClientOriginalExtension();
            $upload_path = 'media/missionvision/';
            $missionvision_image->move($upload_path, $missionvision_image_name);
            
            $old_missionvision_image = MissionVision::findOrFail($id);
            if($old_missionvision_image->image){
                unlink($old_missionvision_image->image);
            }

            $image_url = $upload_path.$missionvision_image_name;
        
            MissionVision::findOrFail($id)->update([
                'name' => $request->name,
                'image' => $image_url,
                'details' => $request->details,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::success('Mission Visions successfully with iamge :-)','Success');
            return redirect()->back();
        }else {
            MissionVision::findOrFail($id)->update([
                'name' => $request->name,
                'details' => $request->details,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::success('Mission Visions successfully save without iamge :-)','Success');
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
        $missionvision = MissionVision::findOrFail($id);
        $delteImage = $missionvision->image;

        if(file_exists($delteImage)) {
            unlink($delteImage);
        }
        
        $missionvision->delete();
        Toastr::info('Mission vision successfully delete :-)','Success');
        return redirect()->back();
    }
}
