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
        return view('customer.order', compact('title', 'lan', 'p_cat_id', 'orders'));
    }

    public function review(Request $request)
    {
        //
        $validateData = $request->validate([
            'rating'=>'required',
        ]);
        Review::insert([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'opinion' => $request->opinion,
            'rating' => $request->rating,
            'phone' => $request->phone,
            'created_at' => Carbon::now(),
        ]);
        Toastr::success('Your review successfully done :-)','success');
        return redirect()->back();
    }

    public function orderView(Request $request, $id)
    {
        $title = "Order View";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $orders = Order::find($id);
        $products = OrderProduct::where('order_code', $orders->order_code)->get();
        return view('customer.orderview', compact('title', 'lan', 'p_cat_id', 'orders', 'products'));
    }
}
