<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;

class TrackingOrderController extends Controller
{
    public function trackingOrder(Request $request)
    {
        $title = "Tracking Order";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $search = '';
        return view('pages.trackingorder', compact('title', 'lan', 'p_cat_id','search'));
    }
    public function trackingorderView(Request $request)
    {
        $this->validate($request, [
            'order_code' => 'required',
        ]);

        $title = $request->order_code;
        $lan = $request->session()->get('lan');
        $p_cat_id = '';

        $order = Order::where('order_code', $request->order_code)->latest()->first();
        $products = OrderProduct::where('order_code', $order->order_code)->get();

        if(!$order){
            Toastr::warning('Your order not found form order table :-)','Success');
            return redirect()->back();
        }
        if($order){
            $search = '';
            return view('pages.trackingorderview', compact('title', 'lan', 'p_cat_id', 'order', 'products','search'));
        }
    }
}
