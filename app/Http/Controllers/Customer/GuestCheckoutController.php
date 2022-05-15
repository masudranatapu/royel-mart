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
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductOrderColor;
use App\Models\ProductOrderColorSize;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Hash;

class GuestCheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "Guest Checkout";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $search = '';
        return view('customer.guest.index', compact('title', 'lan', 'p_cat_id','search'));
    }

    // for getDivDis informaiton
    public function getDivDis(Request $request)
    {
        $div_id = $request->billing_div_id;
        $districts = District::where('division_id', $div_id)->latest()->get();
        // return $districts;

        $divisions = Division::findOrFail($div_id);
        $divCharge = $divisions->charge;

        // return $divCharge;
        return $data = [$districts, $divCharge];
    }

    // for getDivDis informaiton
    public function getDisDiv(Request $request)
    {
        $dis_id = $request->billing_dis_id;;
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

    public function voucher_check_with_guest(Request $request)
    {
        $shipping_phone = $request->shipping_phone;
        $code = $request->voucher_code;
        $discount_amount = $request->discount_amount;
        $total = $request->total;

        $user = User::where('phone', $shipping_phone)->first();
        $voucher = Voucher::where('code', $code)->first();

        $use_time = 0;
        $real_code = 0;
        $code_applicable = 0;
        $min_p_amount = 0;
        if($voucher){
            $use_time = $voucher->useable_time;
            $real_code = 1;
            $min_p_amount = $voucher->purchase_amount;

            if($voucher->purchase_amount <= $total){
                $code_applicable = 1;
            }
        }

        if($user){
            $user_id = $user->id;

            $used_voucher = Order::where('user_id', $user_id)->where('voucher', $code)->count();
            if($used_voucher < $use_time){
                if($voucher->discount_type == 'Solid'){
                    $discount_amount += $voucher->discount;
                    $total -= $voucher->discount;
                }else{
                    $voucher_dis = floor(($total*$voucher->discount)/100);
                    $discount_amount += $voucher_dis;
                    $total -= $voucher_dis;
                }
            }
        }else{
            if($voucher->discount_type == 'Solid'){
                $discount_amount += $voucher->discount;
                $total -= $voucher->discount;
            }else{
                $voucher_dis = floor(($total*$voucher->discount)/100);
                $discount_amount += $voucher_dis;
                $total -= $voucher_dis;
            }
        }


        return ['code_applicable'=>$code_applicable, 'min_p_amount'=>$min_p_amount, 'real_code'=>$real_code, 'use_time'=>$use_time, 'discount_amount'=>$discount_amount, 'total'=>$total];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            // order table
            'shipping_to' => 'required',
            'payment_method' => 'required',
            // shipping table
            'shipping_name' => 'required',
            'shipping_email' => 'required',
            'shipping_phone' => 'required',
            'shipping_address' => 'required',

        ]);

        $check_user = User::where('phone', $request->shipping_phone)->first();
        if($check_user){
            $user_id = $check_user->id;
        }else{
            $user = new User();
            $user->name = $request->shipping_name;
            $user->email  = $request->shipping_email;

            $three_ch = substr($request->input('shipping_phone'), 0, 3);
            $two_ch = substr($request->input('shipping_phone'), 0, 2);
            if($three_ch == '+88'){
                $user->phone = substr($request->input('shipping_phone'), 3);
            }elseif($two_ch == '+8' || $two_ch == '88'){
                $user->phone = substr($request->input('shipping_phone'), 2);;
            }else{
                $user->phone = $request->shipping_phone;
            }

            $user->division_id = $request->division_id;
            $user->district_id = $request->district_id;
            $user->area_id = $request->area_id;
            $user->address = $request->shipping_address;
            $user->password = Hash::make($request->shipping_phone);
            $user->save();

            $new_user = User::where('phone', $request->shipping_phone)->first();
            $user_id = $new_user->id;
        }

        $shipping_address = new ShippingAddress();
        $shipping_address->user_id = $user_id;
        $shipping_address->shipping_to = $request->shipping_to;
        $shipping_address->shipping_name = $request->shipping_name;
        $shipping_address->shipping_phone = $request->shipping_phone;
        $shipping_address->shipping_email = $request->shipping_email;
        $shipping_address->shipping_division_id = $request->division_id;
        $shipping_address->shipping_district_id = $request->district_id;
        $shipping_address->shipping_area_id = $request->area_id;
        $shipping_address->shipping_address = division_name($request->division_id ).district_name($request->district_id ).area_name($request->area_id ).', '.$request->shipping_address;
        $shipping_address->save();

        // create order code

        $order_code = 'R'.mt_rand(111111,999999);

        $order = new Order();
        $order->user_id = $user_id;
        $order->order_code = $order_code;
        $order->sub_total = $request->sub_total;
        $order->shipping_amount = $request->shipping_amount;
        $order->discount = $request->discount;
        $order->total = $request->total;
        $order->due = $request->total;
        $order->payment_method = $request->payment_method;
        $order->payment_transaction_id = $request->payment_transaction_id;
        $order->shipping_to = $request->shipping_to;
        $order->shipping_name = $request->shipping_name;
        $order->shipping_phone = $request->shipping_phone;
        $order->shipping_address = division_name($request->division_id ).district_name($request->district_id ).area_name($request->area_id ).', '.$request->shipping_address;
        $order->voucher = $request->voucher_code;
        $order->note = $request->note;
        $order->pending_date = Carbon::now()->format('Y-m-d');
        $order->save();

        foreach($request->product_id as $key=>$product_id){
            $order_product = new OrderProduct();
            $order_product->order_code = $order_code;
            $order_product->product_id = $product_id;
            $order_product->sale_price = $request->sale_price[$key];
            $order_product->quantity = $request->quantity[$key];
            $order_product->save();

            if($request->color_id[$key]){
                $order_product_color = new ProductOrderColor();
                $order_product_color->order_code = $order_code;
                $order_product_color->product_id = $product_id;
                $order_product_color->color_id = $request->color_id[$key];
                $order_product_color->quantity = $request->quantity[$key];
                $order_product_color->save();

                if($request->size_id[$key]){
                    $order_product_color_size = new ProductOrderColorSize();
                    $order_product_color_size->order_code = $order_code;
                    $order_product_color_size->product_id = $product_id;
                    $order_product_color_size->color_id = $request->color_id[$key];
                    $order_product_color_size->size_id = $request->size_id[$key];
                    $order_product_color_size->quantity = $request->quantity[$key];
                    $order_product_color_size->save();
                }
            }
        }

        $title = "Success Checkout";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';

        $otp = $request->shipping_name. " your Royalmart-bd.com order code is ". $order_code . " .Keep this order code for your product delivery";
        $phoneNumber = $request->shipping_phone;
        $messages = Message::latest()->first();
        $allmessages = $messages->message;
        $sentMessages = $messages->sent;

        // check message
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

        $search = '';
        Toastr::success('Order successfully done :-)','Success');
        return view('customer.guest.successcheckout', compact('title', 'lan', 'p_cat_id', 'search', 'order_code'));
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
