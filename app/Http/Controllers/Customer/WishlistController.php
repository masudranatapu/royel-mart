<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use App\Models\Review;
use App\Models\BillingAddress;
use App\Models\ShippingAddress;
use App\Models\Order;
use Auth;

class WishlistController extends Controller
{
    //
    public function orderIndex()
    {
        $title = "Order View";
        $orders = Order::where('user_id', Auth::user()->id)->latest()->get();
        return view('customer.order', compact('title', 'orders'));
    }
    
    public function review(Request $request)
    {
        //
        $validateData = $request->validate([
            'rating'=>'required',
        ]);
        // others photo
        $multiThambnail = $request->file('image');
        $slug2 = "image";
        if (isset($multiThambnail)) {
            foreach ($multiThambnail as $key => $multiThamb) {
                // make unique name for image
                $multiThamb_name = $slug2.'-'.uniqid().'.'.$multiThamb->getClientOriginalExtension();
                $upload_path = 'media/review/';
                $multiThamb_image_url = $upload_path.$multiThamb_name;
                $multiThamb->move($upload_path, $multiThamb_name);
                $img_arr[$key] = $multiThamb_image_url;
            }
            $multiThamb__photo = trim(implode('|', $img_arr), '|');
        }else {
            $multiThamb__photo = NULL;
        }

        if($request->user_id){
            $userId = $request->user_id;
        }else {
            $userId = NULL;
        }

        Review::insert([
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'opinion' => $request->opinion,
            'rating' => $request->rating,
            'phone' => $request->phone,
            'image' => $multiThamb__photo,
            'created_at' => Carbon::now(),
        ]);
        Toastr::success('Your review successfully done :-)','success');
        return redirect()->back();
    }

    public function orderView($id)
    {
        $title = "Order View";
        $orders = Order::where('id', $id)->latest()->first();
        $billinginfo = BillingAddress::where('order_id', $id)->latest()->first();
        return view('customer.orderview', compact('title', 'orders', 'billinginfo'));
    }
}
