<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;

class TrackingOrderController extends Controller
{
    public function trackingOrder()
    {
        $title = "Tracking Order";
        return view('pages.trackingorder', compact('title'));
    }
    public function trackingorderView(Request $request)
    {
        $this->validate($request, [
            'order_code' => 'required',
        ]);

        $title = $request->order_code;

        $orders = Order::where('order_code', $request->order_code)->latest()->first();

        if(!$orders){
            Toastr::warning('Your order not found form order table :-)','Success');
            return redirect()->back();
        }
        if($orders){
            return view('pages.trackingorderview', compact('title', 'orders'));
        }
    }
}
