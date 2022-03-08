<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\SubUnit;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class SubUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Sub Unit";
        $units = Unit::where('status', 1)->latest()->get();
        $subunits = SubUnit::latest()->get();
        return view('admin.unit.subunit', compact('title', 'units', 'subunits'));
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
            'unit_id' => 'required',
            'name' => 'required',
        ]);

        SubUnit::insert([
            'unit_id' => $request->unit_id,
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'status' => "1",
        ]);

        Toastr::success('Sub unit successfully save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function subUnitActive($id)
    {
        //
        SubUnit::findOrFail($id)->update(['status' => '1']);
        Toastr::info('Sub unit successfully Active :-)','Success');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subUnitInactive($id)
    {
        //
        SubUnit::findOrFail($id)->update(['status' => '0']);
        Toastr::info('Sub unit successfully Active :-)','Success');
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
        SubUnit::findOrFaiL($id)->update([
            'unit_id' => $request->unit_id,
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
        ]);
        Toastr::info('Sub unit successfully updated :-)','Success');
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
