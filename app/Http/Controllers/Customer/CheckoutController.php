<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Auth;
use App\Models\Division;
use App\Models\District;
use App\Models\ShippingAddress;
use App\Models\Vat;
use App\Models\Order;

class CheckoutController extends Controller
{
    //
    public function index()
    {
        $title = "Checkout";
        $divisions = Division::latest()->get();
        return view('customer.checkout', compact('title', 'divisions'));
    }
    // for getDivDis informaiton
    public function getDivDis($div_id)
    {
        // return $div_id;
        $districts = District::where('division_id', $div_id)->latest()->get();
        // return $districts;

        $divisions = Division::findOrFail($div_id);
        $divCharge = $divisions->charge;

        // return $divCharge;
        return $data = [$districts, $divCharge];
    }

    // for getDivDis informaiton
    public function getDisDiv($dis_id)
    {
        $district = District::findOrFail($dis_id);
        
        $disCharge = $district->charge;

        return $data = [$disCharge];
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            // order table
            'shippingto' => 'required',
            'payment_method' => 'required',
            // shipping table
            'shipping_name' => 'required',
            'shipping_email' => 'required',
            'shipping_phone' => 'required',
            'shipping_division_id' => 'required',
            'shipping_district_id' => 'required',
            'shipping_address' => 'required',

        ]);
        // for product id
        if($request->product_id){
            $product_id = trim(implode(',', $request->product_id), ',');
        }else {
            $product_id = NULL;
        }
        // for product quantity
        if($request->quantity) {
            $quantity = trim(implode(',', $request->quantity), ',');
        }else {
            $quantity = NULL;
        }
        // for product size
        if($request->size_id) {
            $size_id = trim(implode(',', $request->size_id), ',');
        }else {
            $size_id = NULL;
        }
        // for product color
        if($request->color_id) {
            $color_id = trim(implode(',', $request->color_id), ',');
        }else {
            $color_id = NULL;
        }
        // create order code
        $latest_id = Order::select('id')->latest()->first();

        if(isset($latest_id)) {
            $order_code = "O-".sprintf('%04d', $latest_id->id + 1);
        }else {
            $order_code = "O-".sprintf('%04d', 1);
        }

        $total = $request->sub_total + $request->shipping_amount ;
        
        $order_id = Order::insertGetId([
            'user_id' => Auth::user()->id,
            'order_code' => $order_code,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'size_id' => $size_id,
            'color_id' => $color_id,
            'shipping_amount' => $request->shipping_amount,
            'sub_total' => $request->sub_total,
            'payment_method' => $request->payment_method,
            'shippingto' => $request->shippingto,
            'total' => $total,
            'payment_mobile_number' => $request->payment_mobile_number,
            'payment_transaction_id' => $request->payment_transaction_id,
            'payment_transaction_id' => $request->payment_transaction_id,
            'created_at' => Carbon::now(),
        ]);
        // for ShippingAddress info
        ShippingAddress::insert([
            'user_id' => Auth::user()->id,
            'order_id' => $order_id,
            'shipping_name' => $request->shipping_name,
            'shipping_email' => $request->shipping_email,
            'shipping_division_id' => $request->shipping_division_id,
            'shipping_district_id' => $request->shipping_district_id,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'created_at' => Carbon::now(),
        ]);

        session()->forget('cart');
        Toastr::success('Order successfully done :-)','Success');
        return redirect()->route('customer.order');
    }
}