<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\DefaultDeliveryLocation;
use App\Models\District;
use App\Models\Division;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class DefaultDeliveryLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Default Delivery Location';
        $default_location = DefaultDeliveryLocation::latest()->first();
        $division_id = $default_location->division_id;
        $district_id = $default_location->district_id;
        $area_id = $default_location->area_id;

        $divisions = Division::get();
        $districts = District::where('division_id', $division_id)->get();
        $areas = Area::where('district_id', $district_id)->get();

        return view('admin.location.default-delivery-location', compact('title', 'default_location', 'division_id', 'district_id', 'area_id', 'districts', 'divisions', 'areas'));
    }

    public function get_district(Request $request)
    {
        $division_id = $request->division_id;
        $html = '';

        $districts = District::where('division_id', $division_id)->get();
        if($districts->count() > 0){
            $html .= '<option value="">Select One</option>';
            foreach($districts as $district){
                $html .= '<option value="'.$district->id.'">'.$district->name.'</option>';
            }
        }else{
            $html .= '<option value="">Select One</option>';
        }

        return $html;
    }

    public function get_area(Request $request)
    {
        $district_id = $request->district_id;
        $html = '';

        $areas = Area::where('district_id', $district_id)->get();
        if($areas->count() > 0){
            $html .= '<option value="">Select One</option>';
            foreach($areas as $area){
                $html .= '<option value="'.$area->id.'">'.$area->name.'</option>';
            }
        }else{
            $html .= '<option value="">Select One</option>';
        }

        return $html;
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
        $default_location = DefaultDeliveryLocation::find($id);
        $default_location->division_id = $request->division_id;
        $default_location->district_id = $request->district_id;
        $default_location->area_id = $request->area_id;
        $default_location->save();

        Toastr::success('Location Charge successfully :-)','Success');
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
    }
}
