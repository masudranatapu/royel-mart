<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use App\Models\Review;
use App\Models\ShippingAddress;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    //
    public function orderIndex(Request $request)
    {
        $title = "Order View";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $orders = Order::with('products')->where('user_id', Auth::user()->id)->latest()->get();
        $search = '';
        return view('customer.order', compact('title', 'lan', 'p_cat_id', 'orders','search'));
    }

    public function orderView(Request $request, $id)
    {
        $title = "Order View";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $orders = Order::find($id);
        $products = OrderProduct::where('order_code', $orders->order_code)->get();
        $search = '';
        return view('customer.orderview', compact('title', 'lan', 'p_cat_id', 'orders', 'products','search'));
    }
}
