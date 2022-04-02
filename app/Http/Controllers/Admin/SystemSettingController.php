<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = SystemSetting::latest()->first();
        $title = "System Setting";
        return view('admin.website.system-setting', compact('title', 'setting'));
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
        $this->validate($request, [
            'time_zone' => 'required',
            'date_format' => 'required',
            'time_format' => 'required',
            'currency' => 'required',
            'shipping_charge' => 'required',
            'vat' => 'required',
        ]);

        $setting = SystemSetting::find($id);
        $setting->time_zone = $request->time_zone;
        $setting->date_format = $request->date_format;
        $setting->time_format = $request->time_format;
        $setting->currency = $request->currency;
        $setting->shipping_charge = $request->shipping_charge;
        $setting->vat = $request->vat;
        $setting->save();

        Toastr::success('Setting updated successfully :-)','Success');
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
