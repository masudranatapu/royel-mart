<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Sold;
use App\Models\Product;
use App\Models\BillingAddress;
use App\Models\Category;
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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class OrderController extends Controller
{
    //
    public function index()
    {
        $title = "All Order";
        $orders =  Order::with('products','customer')->latest()->get();
        return view('admin.order.index',compact('title', 'orders'));
    }

    public function sale_report()
    {
        $from = Carbon::parse(date('Y-m-d'))->format('Y-m-d 00:00:00');
        $to = Carbon::parse(date('Y-m-d'))->format('Y-m-d 23:59:59');
        $title = "Sale Report";
        $sales = Order::where('status', '!=', 'Pending')->where('status', '!=', 'Canceled')->whereBetween('created_at',[$from,$to])->latest()->get();
        return view('admin.report.sale', compact('title', 'from', 'to', 'sales'));
    }

    public function sale_report_search(Request $request)
    {
        $from = Carbon::parse($request->from)->format('Y-m-d 00:00:00');
        $to = Carbon::parse($request->to)->format('Y-m-d 23:59:59');
        $title = "Sale Report";
        $sales = Order::where('status', '!=', 'Pending')->where('status', '!=', 'Canceled')->whereBetween('created_at',[$from,$to])->latest()->get();
        return view('admin.report.sale', compact('title', 'from', 'to', 'sales'));
    }

    public function show($id)
    {
        $title = "Order View";
        $website = Website::latest()->first();
        $order = Order::with('products')->where('id', $id)->latest()->first();
        $customer = User::find($order->user_id);
        return view('admin.order.orderdetails', compact('title', 'website', 'order', 'customer'));
    }

    public function invoice_print($id)
    {
        $title = "Order Print";
        $website = Website::latest()->first();
        $order = Order::with('products')->where('id', $id)->latest()->first();
        $customer = User::find($order->user_id);
        return view('admin.order.invoice', compact('title', 'website', 'order', 'customer'));
    }

    public function edit($id)
    {
        $title = "Order Update";
        $website = Website::latest()->first();
        $order = Order::with('products')->where('id', $id)->latest()->first();
        $customer = User::find($order->user_id);
        $products = Product::where('status', 1)->latest()->get();
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number', 'asc')->get();
        return view('admin.order.edit-order', compact('title', 'products', 'order', 'categories', 'customer'));
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
        $website = Website::latest()->first();
        return view('admin.order.custom-order',compact('title', 'orders', 'website'));
    }

    public function custom_order_status_change(Request $request)
    {
        $order = CustomOrder::find($request->order_id);
        $order->status = $request->status;
        $order->save();

        Toastr::success('Order successfully changed :-)','success');
        return redirect()->back();
    }

    public function new_custom_order()
    {
        $title = "New Custom Order";
        $customer_name = '';
        $customer_phone = '';
        $customer_address = '';
        $products = Product::where('status', 1)->latest()->get();
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number', 'asc')->get();
        return view('admin.order.new-custom-order', compact('title', 'products', 'categories', 'customer_name', 'customer_phone', 'customer_address'));
    }

    public function create_custom_order($id)
    {
        $order = CustomOrder::find($id);
        $title = "New Custom Order";
        $customer_name = $order->name;
        $customer_phone = $order->phone;
        $customer_address = $order->address;
        $products = Product::where('status', 1)->latest()->get();
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number', 'asc')->get();
        return view('admin.order.new-custom-order', compact('title', 'products', 'categories', 'customer_name', 'customer_phone', 'customer_address'));
    }

    public function add_product_custom_order_list(Request $request)
    {
        $product_id = $request->product_id;
        $product = '';

        $chk_product = Product::find($product_id);
        $stock = Stock::where('product_id', $product_id)->where('quantity', '>', 0)->sum('quantity');
        $sale_price = $chk_product->sale_price;
        $quantity = 1;
        if($stock > 0){
            $product .= '
                <tr id="product_tr_'.$chk_product->id.'">
                    <td class="text-center">
                        <button class="btn btn-danger waves-effect" type="button" onclick="removeProductTr('.$chk_product->id.')">
                            <i class="ml-1 fa fa-trash"></i>
                        </button>
                    </td>
                    <td>
                        <img src="';

                        if(file_exists($chk_product->thumbnail)){
                            $product .= ''.URL::to($chk_product->thumbnail).'';
                        }else {
                            $product .= 'asset("media\general-image\no-photo.jpg")';
                        }
            $product .= ' " width="100%" height="60px" alt="banner image">
                    </td>
                    <td>
                        <input type="hidden" class="form-control" name="product_id[]" value="'.$chk_product->id.'">
                        <a href="'.route('productdetails', $chk_product->slug).'" target="_blank">'.$chk_product->name.'</a>
                    </td>
                    <td>
                        <input type="hidden" class="form-control text-center" value="'.$stock.'" id="pro_max_quantity_'.$chk_product->id.'">
                        <input type="text" class="form-control text-center" value="'.$quantity.'" name="pro_quantity[]" id="pro_quantity_'.$chk_product->id.'" onfocus="focusInQuantity('.$chk_product->id.')" onfocusout="focusOutQuantity('.$chk_product->id.')" onpaste="QuantityCng('.$chk_product->id.')" onkeyup="QuantityCng('.$chk_product->id.')" onchange="QuantityCng('.$chk_product->id.')">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-center" name="pro_sale_price[]" value="'.$sale_price.'" id="pro_sale_price_'.$chk_product->id.'" onfocus="focusInSalePrice('.$chk_product->id.')" onfocusout="focusOutSalePrice('.$chk_product->id.')" onpaste="SalePriceCng('.$chk_product->id.')" onkeyup="SalePriceCng('.$chk_product->id.')" onchange="SalePriceCng('.$chk_product->id.')">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-right" readonly name="pro_shipping[]" id="pro_shipping_'.$chk_product->id.'" value="'.$chk_product->shipping_charge.'">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-right" readonly name="pro_total[]" id="pro_total_'.$chk_product->id.'" value="'.($sale_price * $quantity).'">
                    </td>
                </tr>
            ';

        }

        return $product;
    }

    public function new_custom_order_store(Request $request)
    {
        $this->validate($request, [
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'customer_address' => 'required',
            'product_id' => 'required',
        ]);

        // return $request;

        $check_user = User::where('phone', $request->customer_phone)->first();
        if($check_user){
            $user_id = $check_user->id;
        }else{
            $user = new User();
            $user->name = $request->customer_name;
            $user->phone  = $request->customer_phone;
            $user->address = $request->shipping_address;
            $user->password = Hash::make($request->customer_phone);
            $user->save();

            $new_user = User::where('phone', $request->customer_phone)->first();
            $user_id = $new_user->id;
        }

        $new_shipping_address = new ShippingAddress();
        $new_shipping_address->user_id = $user_id;
        $new_shipping_address->shipping_to = 'Home';
        $new_shipping_address->shipping_name = $request->customer_name;
        $new_shipping_address->shipping_phone = $request->customer_phone;
        $new_shipping_address->shipping_address = $request->customer_address;
        $new_shipping_address->save();

        $shipping_to = 'Home';
        $shipping_name = $request->customer_name;
        $shipping_phone = $request->customer_phone;
        $shipping_address = $request->customer_address;

        // create order code
        $order_code = 'R'.mt_rand(111111,999999);

        $order = new Order();
        $order->user_id = $user_id;
        $order->order_code = $order_code;
        $order->sub_total = $request->sub_total;
        $order->shipping_amount = $request->total_shipping;
        $order->discount = $request->total_discount;
        $order->total = $request->total;
        $order->due = $request->due;
        $order->paid = $request->paid;
        $order->payment_method = $request->payment_method;
        $order->shipping_to = $shipping_to;
        $order->shipping_name = $shipping_name;
        $order->shipping_phone = $shipping_phone;
        $order->shipping_address = $shipping_address;
        $order->note = $request->note;
        $order->status = 'Confirmed';
        $order->pending_date = Carbon::now()->format('Y-m-d');
        $order->save();

        foreach($request->product_id as $key=>$product_id){
            $order_product = new OrderProduct();
            $order_product->order_code = $order_code;
            $order_product->product_id = $product_id;
            $order_product->sale_price = $request->pro_sale_price[$key];
            $order_product->quantity = $request->pro_quantity[$key];
            $order_product->save();
        }

        $order_products = OrderProduct::where('order_code', $order_code)->get();
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

        Toastr::success('Order successfully deleted :-)','success');
        return redirect()->back();

    }

    public function custom_order_delete(Request $request, $id)
    {
        $order = CustomOrder::find($id);
        $order->delete();

        Toastr::success('Order successfully deleted :-)','success');
        return redirect()->back();
    }




}
