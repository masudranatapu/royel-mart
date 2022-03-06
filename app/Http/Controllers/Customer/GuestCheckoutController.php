<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use App\Models\Message;
use Auth;
use App\Models\Division;
use App\Models\District;
use App\Models\ShippingAddress;
use App\Models\BillingAddress;
use App\Models\Order;

class GuestCheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Guest Checkout";
        return view('customer.guest.index', compact('title'));
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
            $order_code = "0".sprintf('%04d', $latest_id->id + 1);
        }else {
            $order_code = "0".sprintf('%04d', 1);
        }

        $total = $request->sub_total + $request->shipping_amount ;
        
        $order_id = Order::insertGetId([
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
        // for billing information
        BillingAddress::insert([
            'order_id' => $order_id,
            'billing_name' => $request->shipping_name,
            'billing_email' => $request->shipping_email,
            'billing_division_id' => $request->shipping_division_id,
            'billing_district_id' => $request->shipping_district_id,
            'billing_phone' => $request->shipping_phone,
            'billing_address' => $request->shipping_address,
            'created_at' => Carbon::now(),
        ]);
        // for ShippingAddress info
        ShippingAddress::insert([
            'order_id' => $order_id,
            'shipping_name' => $request->shipping_name,
            'shipping_email' => $request->shipping_email,
            'shipping_division_id' => $request->shipping_division_id,
            'shipping_district_id' => $request->shipping_district_id,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'created_at' => Carbon::now(),
        ]);

        $title = "Success Checkout";

        $otp = $request->shipping_name. " your Royalmart-bd.com order code is ". $order_code . " .Keep this order code for your product delivery";
        $phoneNumber = $request->shipping_phone;
        $messages = Message::latest()->first();
        $allmessages = $messages->message;
        $sentMessages = $messages->sent;

        // check message
        if($allmessages != $sentMessages + 1){
            $smsUrl = "http://66.45.237.70/api.php";
            $data = [
                'username'=>"proit24",
                'password'=>"MHYRNTF5",
                'number'=> "$phoneNumber",
                'message'=> "$otp",
            ];

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $smsUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode('|', $smsresult);
            $sendstatus = $p[0];
            Message::where('id', $messages->id)->update([
                'sent' => $sentMessages + 1,
            ]);
            session()->forget('cart');
            Toastr::success('Order successfully done :-)','Success');
            return view('customer.guest.successcheckout', compact('title'));
        }else {
            return redirect()->back();
        }
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
        //
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
