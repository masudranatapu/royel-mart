<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\District;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Division;
use Carbon\Carbon;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Division";
        $divisions = Division::latest()->get();
        return view('admin.location.indexdiv', compact('title', 'divisions'));
    }

    public function divisions_districts($id)
    {
        $division = Division::find($id);
        $title = "District of ".$division->name;
        $districts = District::where('division_id', $id)->latest()->get();
        return view('admin.location.divisions-district', compact('title', 'division', 'districts'));
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
        ]);

        $division = new Division();
        $division->name = $request->name;
        $division->status = 1;
        $division->save();

        Toastr::success('Division Successfully Save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function divisionActive($id)
    {
        Division::findOrFail($id)->update(['status' => '1']);
        Toastr::info('Division successfully inactive :-)','Success');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function divisionInactive($id)
    {
        Division::findOrFail($id)->update(['status' => '0']);
        Toastr::info('Division successfully inactive :-)','Success');
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

        $division = Division::find($id);
        $division->name = $request->name;
        $division->save();

        Toastr::info('Division Successfully update :-)','Success');
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
        $division = Division::find($id);

        $districts = District::where('division_id', $id)->get();
        foreach($districts as $c_district){
            $district = District::find($c_district->id);

            Area::where('district_id', $c_district->id)->delete();

            $district->delete();
        }

        $division->delete();

        Toastr::info('Division Successfully delete :-)','Success');
        return redirect()->back();
    }
}
