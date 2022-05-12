<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\District;
use App\Models\Division;
use Carbon\Carbon;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "District";
        $districts = District::with('division')->orderBy('division_id', 'ASC')->get();
        $divisions = Division::latest()->get();
        return view('admin.location.indexdis', compact('title', 'districts', 'divisions'));
    }

    public function districts_areas($id)
    {
        $district = District::find($id);
        $title = "Area of ".$district->name;
        $areas = Area::where('district_id', $id)->latest()->get();
        return view('admin.location.districts-area', compact('title', 'district', 'areas'));
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
        $this->validate($request, [
            'name' => 'required',
            'division_id' => 'required',
        ]);

        $district = new District();
        $district->division_id = $request->division_id;
        $district->name = $request->name;
        $district->status = 1;
        $district->save();

        Toastr::success('District Successfully Save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function districtActive($id)
    {
        //
        District::findOrFail($id)->update(['status' => '1']);
        Toastr::info('District successfully inactive :-)','Success');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function districtInactive($id)
    {
        District::findOrFail($id)->update(['status' => '0']);
        Toastr::info('District successfully inactive :-)','Success');
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
        $this->validate($request, [
            'name' => 'required',
        ]);

        $district = District::find($id);
        $district->name = $request->name;
        $district->save();

        Toastr::info('District Successfully updated :-)','Success');
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
        $district = District::find($id);

        Area::where('district_id', $id)->delete();

        $district->delete();

        Toastr::info('District Successfully deleted :-)','Success');
        return redirect()->back();
    }
}
