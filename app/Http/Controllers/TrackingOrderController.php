<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\BillingAddress;
use App\Models\ShippingAddress;
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

        $orders = Order::where('order_code', $request->order_code)->first();
        if($orders) {
            $billinginfo = BillingAddress::where('order_id', $orders->id)->latest()->first();
            $shippinginfo = ShippingAddress::where('order_id', $orders->id)->latest()->first();
            return view('pages.trackingorderview', compact('title', 'orders', 'billinginfo', 'shippinginfo'));
        }else {
            Toastr::error('Your product order code was not defind :-)','info');
            return redirect()->back();
        }
    }
}
