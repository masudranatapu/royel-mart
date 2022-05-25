<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Area;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use App\Models\Division;
use App\Models\District;
use App\Models\ShippingAddress;
use App\Models\BillingAddress;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductOrderColor;
use App\Models\ProductOrderColorSize;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //
    public function index(Request $request)
    {
        $title = "Checkout";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $divisions = Division::orderBy('name')->get();
        $districts = District::where('division_id', Auth::user()->division_id)->orderBy('name')->get();
        $areas = Area::where('district_id', Auth::user()->district_id)->orderBy('name')->get();
        $shipping_addresses = ShippingAddress::where('user_id', Auth::user()->id )->latest()->get();
        $search = '';
        return view('customer.checkout', compact('title', 'lan', 'p_cat_id', 'divisions', 'shipping_addresses', 'districts', 'areas','search'));
    }
    // for getDivDis informaiton
    public function getDivDis($div_id)
    {
        // return $div_id;
        $districts = District::where('division_id', $div_id)->orderBy('name')->get();
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

    public function voucher_check_with_auth(Request $request)
    {
        $code = $request->voucher_code;
        $discount_amount = $request->discount_amount;
        $total = $request->total;

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
        $user_id = Auth::user()->id;

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

        return ['code_applicable'=>$code_applicable, 'min_p_amount'=>$min_p_amount, 'real_code'=>$real_code, 'use_time'=>$use_time, 'discount_amount'=>$discount_amount, 'total'=>$total];
    }

    public function store(Request $request)
    {
        // return $request;
        if($request->shipp_to_id){
            $check_shipping_address = ShippingAddress::find($request->shipp_to_id);

            $ck_user = User::find(Auth::user()->id);
            if(Auth::user()->division_id == NULL){
                $ck_user->division_id = $check_shipping_address->shipping_division_id;
            }
            if(Auth::user()->district_id == NULL){
                $ck_user->district_id = $check_shipping_address->shipping_district_id;
            }
            if(Auth::user()->area_id == NULL){
                $ck_user->area_id = $check_shipping_address->shipping_area_id;
            }
            $ck_user->save();

            $shipping_to = $check_shipping_address->shipping_to;
            $shipping_name = $check_shipping_address->shipping_name;
            $shipping_phone = $check_shipping_address->shipping_phone;
            $shipping_address = division_name($check_shipping_address->shipping_division_id ).district_name($check_shipping_address->shipping_district_id ).area_name($check_shipping_address->shipping_area_id ).', '.$check_shipping_address->shipping_address;
        }else{
            // return $request;
            $this->validate($request, [
                'new_shipping_to' => 'required',
                'new_shipping_name' => 'required',
                'new_shipping_email' => 'required',
                'new_shipping_phone' => 'required',
                'new_shipping_division_id' => 'required',
                'new_shipping_district_id' => 'required',
                'new_shipping_area_id' => 'required',
                'new_shipping_address' => 'required',
            ]);

            $ck_user = User::find(Auth::user()->id);
            if(Auth::user()->division_id == NULL){
                $ck_user->division_id = $request->new_shipping_division_id;
            }
            if(Auth::user()->district_id == NULL){
                $ck_user->district_id = $request->new_shipping_district_id;
            }
            if(Auth::user()->area_id == NULL){
                $ck_user->area_id = $request->new_shipping_area_id;
            }
            $ck_user->save();

            $new_shipping_address = new ShippingAddress();
            $new_shipping_address->user_id = Auth::user()->id;
            $new_shipping_address->shipping_to = $request->new_shipping_to;
            $new_shipping_address->shipping_name = $request->new_shipping_name;

            $three_ch = substr($request->input('new_shipping_phone'), 0, 3);
            $two_ch = substr($request->input('new_shipping_phone'), 0, 2);
            if($three_ch == '+88'){
                $new_shipping_address->shipping_phone = substr($request->input('new_shipping_phone'), 3);
            }elseif($two_ch == '+8' || $two_ch == '88'){
                $new_shipping_address->shipping_phone = substr($request->input('new_shipping_phone'), 2);;
            }else{
                $new_shipping_address->shipping_phone = $request->new_shipping_phone;
            }

            $new_shipping_address->shipping_email = $request->new_shipping_email;
            $new_shipping_address->shipping_division_id = $request->new_shipping_division_id;
            $new_shipping_address->shipping_district_id = $request->new_shipping_district_id;
            $new_shipping_address->shipping_area_id = $request->new_shipping_area_id;
            $new_shipping_address->shipping_address = $request->new_shipping_address;
            $new_shipping_address->save();

            $shipping_to = $request->shipping_to;
            $shipping_name = $request->shipping_name;
            $shipping_phone = $request->shipping_phone;
            $shipping_address = division_name($request->shipping_division_id ).district_name($request->shipping_district_id ).area_name($request->shipping_area_id ).', '.$request->shipping_address;
        }

        // create order code
        $order_code = 'R'.mt_rand(111111,999999);

        if ($request->payment_method=="Cash") {
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->order_code = $order_code;
            $order->sub_total = $request->sub_total;
            $order->shipping_amount = $request->shipping_amount;
            $order->discount = $request->discount;
            $order->total = $request->total;
            $order->due = $request->total;
            $order->payment_method = $request->payment_method;
            $order->payment_transaction_id = $request->payment_transaction_id;
            $order->shipping_to = $shipping_to;
            $order->shipping_name = $shipping_name;
            $order->shipping_phone = $shipping_phone;
            $order->shipping_address = $shipping_address;
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

            session()->forget('cart');

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

            Toastr::success('Order successfully done :-)','Success');
            return redirect()->route('customer.order');
        } elseif($request->payment_method=="Online") {

            $transaction_id = uniqid();

            // for sslcommerz
            $post_data = array();
            $post_data['total_amount'] = $request->total;
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = $transaction_id;

            # CUSTOMER INFORMATION
            $post_data['cus_name'] = $request->shipping_name;
            $post_data['cus_email'] = $request->shipping_email;
            $post_data['cus_add1'] = division_name($request->shipping_division_id ).district_name($request->shipping_district_id ).area_name($request->shipping_area_id ).', '.$request->shipping_address;
            $post_data['cus_add2'] = "";
            $post_data['cus_city'] = "";
            $post_data['cus_state'] = "";
            $post_data['cus_postcode'] = "";
            $post_data['cus_country'] = "Bangladesh";
            $post_data['cus_phone'] = $request->shipping_phone;
            $post_data['cus_fax'] = "";

            # SHIPMENT INFORMATION
            $post_data['ship_name'] = $request->shipping_name;
            $post_data['ship_add1'] = division_name($request->shipping_division_id ).district_name($request->shipping_district_id ).area_name($request->shipping_area_id ).', '.$request->shipping_address;
            $post_data['ship_add2'] = "";
            $post_data['ship_city'] = "";
            $post_data['ship_state'] = "";
            $post_data['ship_postcode'] = "";
            $post_data['ship_phone'] = "";
            $post_data['ship_country'] = "Bangladesh";

            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "Computer";
            $post_data['product_category'] = "Goods";
            $post_data['product_profile'] = "physical-goods";

            # OPTIONAL PARAMETERS
            $post_data['value_a'] = "ref001";
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";
            // sslcommerz end

            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->order_code = $order_code;
            $order->sub_total = $request->sub_total;
            $order->shipping_amount = $request->shipping_amount;
            $order->discount = $request->discount;
            $order->total = $request->total;
            $order->due = $request->total;
            $order->payment_method = $request->payment_method;
            $order->payment_transaction_id = $request->payment_transaction_id;
            $order->shipping_to = $shipping_to;
            $order->shipping_name = $shipping_name;
            $order->shipping_phone = $shipping_phone;
            $order->shipping_address = $shipping_address;
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

            $sslc = new SslCommerzNotification();
            $payment_options = $sslc->makePayment($post_data, 'hosted');

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();

                Toastr::error('Order failed.' ,'Error');
                return redirect()->back();
            }

            session()->forget('cart');

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

            Toastr::success('Order successfully done :-)','Success');
            return redirect()->route('customer.order');
        }

    }

    public function shippingAddressUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'shipping_name' => 'required',
            'shipping_email' => 'required',
            'shipping_phone' => 'required',
            'update_division_id' => 'required',
            'update_district_id' => 'required',
            'update_area_id' => 'required',
            'shipping_address' => 'required',
        ]);

        $shipping_address = ShippingAddress::find($id);
        $shipping_address->shipping_to = $request->shipping_to;
        $shipping_address->shipping_name = $request->shipping_name;
        $shipping_address->shipping_phone = $request->shipping_phone;
        $shipping_address->shipping_email = $request->shipping_email;
        $shipping_address->shipping_division_id = $request->update_division_id;
        $shipping_address->shipping_district_id = $request->update_district_id;
        $shipping_address->shipping_area_id = $request->update_area_id;
        $shipping_address->shipping_address = $request->shipping_address;
        $shipping_address->save();

        Toastr::info('Shipping address successfully updated :-)','Success');
        return redirect()->back();
    }

    // delete shipping address
    public function deleteShippingAddress($id)
    {
        ShippingAddress::where('id', $id)->delete();
        Toastr::warning('Shipping address successfully delete :-)','Success');
        return redirect()->back();
    }
}
