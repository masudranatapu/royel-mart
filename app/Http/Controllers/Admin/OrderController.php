<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Sold;
use App\Models\Product;
use App\Models\BillingAddress;
use App\Models\CustomOrder;
use App\Models\OrderProduct;
use App\Models\ProductOrderColor;
use App\Models\ProductOrderColorSize;
use App\Models\SaleStock;
use App\Models\ShippingAddress;
use App\Models\Stock;
use App\Models\User;
use App\Models\Website;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class OrderController extends Controller
{
    //
    public function index()
    {
        $title = "All Order";
        $orders =  Order::with('products','customer')->latest()->get();
        return view('admin.order.index',compact('title', 'orders'));
    }

    public function show($id)
    {
        $title = "Order View";
        $website = Website::latest()->first();
        $order = Order::with('products')->where('id', $id)->latest()->first();
        $customer = User::find($order->user_id);
        return view('admin.order.edit-order', compact('title', 'website', 'order', 'customer'));
    }

    public function edit($id)
    {
        $title = "Order View";
        $website = Website::latest()->first();
        $order = Order::with('products')->where('id', $id)->latest()->first();
        $customer = User::find($order->user_id);
        return view('admin.order.orderdetails', compact('title', 'website', 'order', 'customer'));
    }

    // order pending
    public function ordersPending()
    {
        $title = "Pending Orders";
        $orders =  Order::with('products')->where('status', 'Pending')->latest()->get();
        return view('admin.order.index',compact('title', 'orders'));
    }
    // order confirmed
    public function ordersConfirmed()
    {
        $title = "Confirmed Orders";
        $orders =  Order::with('products')->where('status', 'Confirmed')->latest()->get();
        return view('admin.order.index',compact('title', 'orders'));
    }
    // order processing
    public function ordersProcessing()
    {
        $title = "Processing Orders";
        $orders =  Order::with('products')->where('status', 'Processing')->latest()->get();
        return view('admin.order.index',compact('title', 'orders'));
    }
    // orders delivered
    public function ordersDelivered()
    {
        $title = "Delivered Orders";
        $orders =  Order::with('products')->where('status', 'Delivered')->latest()->get();
        return view('admin.order.index',compact('title', 'orders'));
    }
    // orders successed
    public function ordersSuccessed()
    {
        $title = "Successed Orders";
        $orders =  Order::with('products')->where('status', 'Successed')->latest()->get();
        return view('admin.order.index',compact('title', 'orders'));
    }
    // orders canceled
    public function ordersCanceled()
    {
        $title = "Canceled Orders";
        $orders =  Order::with('products')->where('status', 'Canceled')->latest()->get();
        return view('admin.order.index',compact('title', 'orders'));
    }

    // order status with paid and delivar processing canceled pending and confirm
    public function order_status_change(Request $request)
    {
        $ordersId = $request->order_id;
        $orderStatus = $request->status;

        if($orderStatus == "Pending"){
            Order::findOrFail($ordersId)->update([
                'status' => 'Pending',
                'pending_date' => Carbon::now(),
            ]);

        }elseif($orderStatus == "Confirmed") {

            $order = Order::find($ordersId);

            $order_products = OrderProduct::where('order_code', $order->order_code)->get();
            foreach($order_products as $order_product){
                $product = Product::find($order_product->product_id);
                $color_id = '';
                $size_id = '';
                $check_pro_color = ProductOrderColor::where('order_code', $order->order_code)->where('product_id', $order_product->product_id)->first();
                if($check_pro_color){
                    $color_id = $check_pro_color->color_id;
                    $check_pro_color_size = ProductOrderColorSize::where('order_code', $order->order_code)->where('product_id', $order_product->product_id)->where('color_id', $check_pro_color->color_id)->first();
                    if($check_pro_color_size){
                        $size_id = $check_pro_color_size->size_id;
                    }
                }


                $stocks = Stock::where('product_id', $order_product->product_id)->where('quantity', '>', 0)->get();
                $qty = $order_product->quantity;
                foreach($stocks as $stock){
                    $st_qty = $stock->quantity;
                    if($qty > 0){

                        if($size_id != '' && $color_id != ''){
                            $check_stock = Stock::where('product_id',$order_product->product_id)->where('color_id', $color_id)->where('size_id', $size_id)->where('purchase_code', $stock->purchase_code)->first();
                            if($check_stock){
                                $sale_stock = new SaleStock();
                                $sale_stock->order_code = $order->order_code;
                                $sale_stock->purchase_code = $stock->purchase_code;
                                $sale_stock->product_id = $order_product->product_id;
                                $sale_stock->color_id = $color_id;
                                $sale_stock->size_id = $size_id;
                                $sale_stock->buying_price = $stock->buying_price;
                                $sale_stock->sale_price = $order_product->sale_price;
                                $sale_stock->quantity = $order_product->product_id;
                                $sale_stock->save();

                                $up_stock = Stock::find($check_stock->id);
                                $up_stock->quantity = $up_stock->quantity - $qty;
                                $up_stock->save();
                            }
                        }elseif($size_id == '' && $color_id != ''){
                            $check_stock = Stock::where('product_id',$order_product->product_id)->where('color_id', $color_id)->where('purchase_code', $stock->purchase_code)->first();
                            if($check_stock){
                                $sale_stock = new SaleStock();
                                $sale_stock->order_code = $order->order_code;
                                $sale_stock->purchase_code = $stock->purchase_code;
                                $sale_stock->product_id = $order_product->product_id;
                                $sale_stock->color_id = $color_id;
                                $sale_stock->size_id = $size_id;
                                $sale_stock->buying_price = $stock->buying_price;
                                $sale_stock->sale_price = $order_product->sale_price;
                                $sale_stock->quantity = $order_product->product_id;
                                $sale_stock->save();

                                $up_stock = Stock::find($check_stock->id);
                                $up_stock->quantity = $up_stock->quantity - $qty;
                                $up_stock->save();
                            }
                        }elseif($size_id == '' && $color_id == ''){
                            $check_stock = Stock::where('product_id',$order_product->product_id)->where('purchase_code', $stock->purchase_code)->first();
                            if($check_stock){
                                $sale_stock = new SaleStock();
                                $sale_stock->order_code = $order->order_code;
                                $sale_stock->purchase_code = $stock->purchase_code;
                                $sale_stock->product_id = $order_product->product_id;
                                $sale_stock->color_id = $color_id;
                                $sale_stock->size_id = $size_id;
                                $sale_stock->buying_price = $stock->buying_price;
                                $sale_stock->sale_price = $order_product->sale_price;
                                $sale_stock->quantity = $qty;
                                $sale_stock->save();

                                $up_stock = Stock::find($check_stock->id);
                                $up_stock->quantity = $up_stock->quantity - $qty;
                                $up_stock->save();
                            }
                        }

                        if($st_qty >= $qty){
                            $qty = $qty - $qty;
                        }else{
                            $qty = $qty - $st_qty;
                        }
                    }

                }
            }

            // return "dfghdfg";

            Order::findOrFail($ordersId)->update([
                'status' => 'Confirmed',
                'confirmed_date' => Carbon::now(),
            ]);



        }elseif($orderStatus == "Processing") {
            Order::findOrFail($ordersId)->update([
                'status' => 'Processing',
                'processing_date' => Carbon::now(),
            ]);

        }elseif($orderStatus == "Delivered") {
            Order::findOrFail($ordersId)->update([
                'status' => 'Delivered',
                'delivered_date' => Carbon::now(),
            ]);

        }elseif($orderStatus == "Successed") {

            Order::findOrFail($ordersId)->update([
                'status' => 'Successed',
                'successed_date' => Carbon::now(),
            ]);

        }elseif($orderStatus == "Canceled") {

            Order::findOrFail($ordersId)->update([
                'status' => 'Canceled',
                'canceled_date' => Carbon::now(),
            ]);

        }else {
            Toastr::error('Select your order status :-)','info');
            return redirect()->back();
        }
        Toastr::success('Order successfully '. $orderStatus . ' :-)','success');
        return redirect()->back();
    }


    public function order_due_payment(Request $request, $id)
    {
        $this->validate($request, [
            'paid' => 'required',
        ]);

        $order = Order::find($id);
        $order->paid = $order->paid + $request->paid;
        $order->due = $order->due - $request->paid;
        $order->save();

        Toastr::success('Payment successfully done :-)','success');
        return redirect()->back();
    }

    public function adjust_order_shipping_charge(Request $request, $id)
    {
        $this->validate($request, [
            'shipping_amount' => 'required',
        ]);

        $pre_order = Order::find($id);
        $pre_order->total -= $pre_order->shipping_amount;
        $pre_order->shipping_amount = 0;
        $pre_order->save();

        $order = Order::find($id);
        $order->total += $request->shipping_amount;
        $order->shipping_amount = $request->shipping_amount;
        $order->due = $order->total - $order->paid;
        $order->save();

        Toastr::success('Adjust shipping charge successfully done :-)','success');
        return redirect()->back();
    }


    public function custom_order()
    {
        $title = "Custom Order";
        $orders =  CustomOrder::latest()->get();
        return view('admin.order.custom-order',compact('title', 'orders'));
    }
    public function custom_order_status_change(Request $request)
    {
        $order = CustomOrder::find($request->order_id);
        $order->status = $request->status;
        $order->save();

        Toastr::success('Order successfully changed :-)','success');
        return redirect()->back();
    }




}
