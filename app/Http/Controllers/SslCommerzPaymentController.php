<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        $post_data = array();
        $post_data['total_amount'] = $request->total;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid();

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->shipping_name;
        $post_data['cus_email'] = $request->shipping_email;
        $post_data['cus_add1'] = division_name($request->division_id ).district_name($request->district_id ).area_name($request->area_id ).', '.$request->shipping_address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->shipping_phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $request->shipping_name;
        $post_data['ship_add1'] = division_name($request->division_id ).district_name($request->district_id ).area_name($request->area_id ).', '.$request->shipping_address;
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

        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'status' => 'Pending',
            ]);

        $sslc = new SslCommerzNotification();

        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {
        $post_data = array();
        $post_data['total_amount'] = $request->total;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid();

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->shipping_name;
        $post_data['cus_email'] = $request->shipping_email;
        $post_data['cus_add1'] = division_name($request->division_id ).district_name($request->district_id ).area_name($request->area_id ).', '.$request->shipping_address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->shipping_phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $request->shipping_name;
        $post_data['ship_add1'] = division_name($request->division_id ).district_name($request->district_id ).area_name($request->area_id ).', '.$request->shipping_address;
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


        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'status' => 'Pending',
            ]);

        $sslc = new SslCommerzNotification();

        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        session()->forget('cart');

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == TRUE) {

                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update([
                        'payment_method' => $request->input('card_issuer'),
                        'status' => 'Paid'
                    ]);

                    Toastr::success('Transaction successfully Completed.' ,'Success');
                    return redirect()->route('customer.order');

            } else {
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);

                Toastr::error('Validation Failed.' ,'Sorry');
                return redirect()->route('customer.order');
            }
        } else if ($order_detials->status == 'Paid' || $order_detials->status == 'Complete') {

            Toastr::success('Transaction is successfully Completed.' ,'Success');
            if ($order_detials->order_type == 'gift') {
                return redirect()->route('home');
            }else {
                return redirect()->route('customer.order');
            }

        } else {

            Toastr::error('Invalid Transaction' ,'Error');
            return redirect()->route('customer.order');
        }


    }

    public function fail(Request $request)
    {
        session()->forget('cart');
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'total','order_type')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            Toastr::error('Transaction is Falied' ,'Error');
            return redirect()->route('customer.order');
        } else if ($order_detials->status == 'Paid' || $order_detials->status == 'Complete') {
            Toastr::success('Transaction is already Successfull' ,'Success');
            return redirect()->route('customer.order');
        } else {
            Toastr::error('Transaction is Invalid' ,'Error');
            return redirect()->route('customer.order');
        }

    }

    public function cancel(Request $request)
    {
        session()->forget('cart');
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'total','order_type')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);

            Toastr::error('Transaction is Canceled' ,'Error');
            return redirect()->route('customer.order');
        } else if ($order_detials->status == 'Paid' || $order_detials->status == 'Complete') {
            Toastr::success('Transaction is already Successfull' ,'Success');
            return redirect()->route('customer.order');
        } else {
            Toastr::error('Transaction is Invalid' ,'Error');
            return redirect()->route('customer.order');
        }


    }

    public function ipn(Request $request)
    {
        if ($request->input('tran_id'))
        {

            $currency = $request->input('currency');
            $tran_id = $request->input('tran_id');

            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {

                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $order_details->total, $currency, $request->all());
                return $validation;

            } else if ($order_details->status == 'Paid' || $order_details->status == 'Complete') {

                Toastr::success('Transaction is successfully Completed.' ,'Success');
                return redirect()->route('customer.order');

            } else {

                Toastr::error('Invalid Transaction' ,'Error');
                return redirect()->route('customer.order');

            }
        } else {
            echo "Invalid Data";
        }
    }

}
