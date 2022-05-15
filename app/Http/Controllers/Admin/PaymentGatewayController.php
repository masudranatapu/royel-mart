<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Payment Gateway";
        $gateways = PaymentGateway::latest()->get();
        return view('admin.payment-gateway.index', compact('title', 'gateways'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payment_gateway_active($id)
    {
        $gateway = PaymentGateway::find($id);
        $gateway->status = 1;
        $gateway->save();

        Toastr::info('Gateway Successfully Active :-)','Success');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function payment_gateway_inactive($id)
    {
        $gateway = PaymentGateway::find($id);
        $gateway->status = 0;
        $gateway->save();

        Toastr::info('Gateway Successfully Inactive :-)','Success');
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
            'title' => 'required|unique:payment_gateways',
            'store_id' => 'required',
            'password' => 'required',
        ]);

        $gateway = new PaymentGateway();
        $gateway->title = $request->title;
        $gateway->store_id = $request->store_id;
        $gateway->password = $request->password;
        $gateway->save();

        Toastr::success('Gateway Successfully Save :-)','Success');
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
            'store_id' => 'required',
            'password' => 'required',
        ]);

        $gateway = PaymentGateway::find($id);
        $gateway->store_id = $request->store_id;
        $gateway->password = $request->password;
        $gateway->save();

        Toastr::success('Gateway Successfully Updated :-)','Success');
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
        $gateway = PaymentGateway::find($id);
        $gateway->delete();

        Toastr::success('Gateway Successfully Deleted :-)','Success');
        return redirect()->back();
    }
}
