<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Voucher";
        $vouchers = Voucher::latest()->get();
        return view('admin.voucher.index', compact('title', 'vouchers'));
    }

    public function voucher_activity($id)
    {
        $c_v = Voucher::where('id', $id)->first();
        if($c_v->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }

        Voucher::findOrFail($id)->update(['status' => $status]);

        Toastr::success('Status successfully change :-)','Success');
        return redirect()->back();
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
            'code' => 'required|unique:vouchers',
            'useable_time' => 'required',
            'purchase_amount' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
        ]);

        $voucher = new Voucher();
        $voucher->code = $request->code;
        $voucher->useable_time = $request->useable_time;
        $voucher->purchase_amount = $request->purchase_amount;
        $voucher->discount = $request->discount;
        $voucher->discount_type = $request->discount_type;
        $voucher->save();

        Toastr::success('Voucher successfully save :-)','Success');
        return redirect()->back();
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
            'code' => 'required',
            'useable_time' => 'required',
            'purchase_amount' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
        ]);

        $voucher = Voucher::find($id);
        $voucher->code = $request->code;
        $voucher->useable_time = $request->useable_time;
        $voucher->purchase_amount = $request->purchase_amount;
        $voucher->discount = $request->discount;
        $voucher->discount_type = $request->discount_type;
        $voucher->save();

        Toastr::success('Voucher successfully updated :-)','Success');
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
        $voucher = Voucher::find($id);
        $voucher->delete();

        Toastr::success('Voucher successfully deleted :-)','Success');
        return redirect()->back();
    }
}
