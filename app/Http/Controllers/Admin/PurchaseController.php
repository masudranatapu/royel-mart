<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Models\Purchases;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Unit;
use App\Models\ProductUnit;
use App\Models\PurchaseStock;
use App\Models\Size;
use App\Models\Stock;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Purchase Product";

        $purchases = Purchases::with('products.product','products.color','products.size')->latest()->get();

        return view('admin.stock.index', compact('title', 'purchases'));
    }

    public function purchase_report()
    {
        $from = Carbon::parse(date('Y-m-d'))->format('Y-m-d 00:00:00');
        $to = Carbon::parse(date('Y-m-d'))->format('Y-m-d 23:59:59');
        $title = "Purchase Report";
        $purchases = Purchases::whereBetween('created_at',[$from,$to])->latest()->get();
        return view('admin.report.purchase', compact('title', 'from', 'to', 'purchases'));
    }

    public function purchase_report_search(Request $request)
    {
        $from = Carbon::parse($request->from)->format('Y-m-d 00:00:00');
        $to = Carbon::parse($request->to)->format('Y-m-d 23:59:59');
        $title = "Purchase Report";
        $purchases = Purchases::whereBetween('created_at',[$from,$to])->latest()->get();
        return view('admin.report.purchase', compact('title', 'from', 'to', 'purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Product Purchase";
        $products = Product::where('status', 1)->latest()->get();
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number', 'asc')->get();
        return view('admin.stock.purchase', compact('title', 'products', 'categories'));
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
            'product_id' => 'required',
        ]);

        // return $request;

        $code = mt_rand(111111, 999999);

        $purchase = new Purchases();
        $purchase->purchase_code = $code;
        $purchase->save();

        foreach($request->product_id as $key=>$product_id){
            $product = Product::find($product_id);

            if($request->product_color_id[$key] != '' && $request->product_size_id[$key] != ''){

                $rqs_size_bp = 'buying_price_'.$product_id.'_'.$request->product_color_id[$key].'_'.$request->product_size_id[$key];
                $rqs_size_sp = 'sale_price_'.$product_id.'_'.$request->product_color_id[$key].'_'.$request->product_size_id[$key];
                $rqs_size_qty = 'quantity_'.$product_id.'_'.$request->product_color_id[$key].'_'.$request->product_size_id[$key];

                $p_stock = new PurchaseStock();
                $p_stock->purchase_code = $code;
                $p_stock->product_id = $product_id;
                $p_stock->color_id = $request->product_color_id[$key];
                $p_stock->size_id = $request->product_size_id[$key];
                $p_stock->buying_price = $request->$rqs_size_bp;
                $p_stock->sale_price = $request->$rqs_size_sp;
                $p_stock->quantity = $request->$rqs_size_qty;
                $p_stock->save();

                $stock = new Stock();
                $stock->purchase_code = $code;
                $stock->product_id = $product_id;
                $stock->color_id = $request->product_color_id[$key];
                $stock->size_id = $request->product_size_id[$key];
                $stock->buying_price = $request->$rqs_size_bp;
                $stock->sale_price = $request->$rqs_size_sp;
                $stock->quantity = $request->$rqs_size_qty;
                $stock->save();
            }elseif($request->product_color_id[$key] != '' && $request->product_size_id[$key] == ''){

                $rqs_size_bp = 'buying_price_'.$product_id.'_'.$request->product_color_id[$key];
                $rqs_size_sp = 'sale_price_'.$product_id.'_'.$request->product_color_id[$key];
                $rqs_size_qty = 'quantity_'.$product_id.'_'.$request->product_color_id[$key];

                $p_stock = new PurchaseStock();
                $p_stock->purchase_code = $code;
                $p_stock->product_id = $product_id;
                $p_stock->color_id = $request->product_color_id[$key];
                $p_stock->buying_price = $request->$rqs_size_bp;
                $p_stock->sale_price = $request->$rqs_size_sp;
                $p_stock->quantity = $request->$rqs_size_qty;
                $p_stock->save();

                $stock = new Stock();
                $stock->purchase_code = $code;
                $stock->product_id = $product_id;
                $stock->color_id = $request->product_color_id[$key];
                $stock->buying_price = $request->$rqs_size_bp;
                $stock->sale_price = $request->$rqs_size_sp;
                $stock->quantity = $request->$rqs_size_qty;
                $stock->save();
            }else{

                $rqs_size_bp = 'buying_price_'.$product_id;
                $rqs_size_sp = 'sale_price_'.$product_id;
                $rqs_size_qty = 'quantity_'.$product_id;

                $p_stock = new PurchaseStock();
                $p_stock->purchase_code = $code;
                $p_stock->product_id = $product_id;
                $p_stock->buying_price = $request->$rqs_size_bp;
                $p_stock->sale_price = $request->$rqs_size_sp;
                $p_stock->quantity = $request->$rqs_size_qty;
                $p_stock->save();

                $stock = new Stock();
                $stock->purchase_code = $code;
                $stock->product_id = $product_id;
                $stock->buying_price = $request->$rqs_size_bp;
                $stock->sale_price = $request->$rqs_size_sp;
                $stock->quantity = $request->$rqs_size_qty;
                $stock->save();
            }
        }

        Toastr::success('Purchase product save :-)','Success');
        return redirect()->back();
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
        $title = "Product Purchase Update";
        $purchase = Purchases::find($id);
        $products = PurchaseStock::with('product','color','size')->where('purchase_code', $purchase->purchase_code)->latest()->get();
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number', 'asc')->get();
        return view('admin.stock.purchase-update', compact('title', 'purchase', 'products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        // return $request;
        $this->validate($request, [
            'product_id' => 'required',
        ]);

        foreach($request->product_id as $key=>$product_id){
            $product = Product::find($product_id);

            if($request->product_color_id[$key] != '' && $request->product_size_id[$key] != ''){

                $rqs_size_bp = 'buying_price_'.$product_id.'_'.$request->product_color_id[$key].'_'.$request->product_size_id[$key];
                $rqs_size_sp = 'sale_price_'.$product_id.'_'.$request->product_color_id[$key].'_'.$request->product_size_id[$key];
                $rqs_size_qty = 'quantity_'.$product_id.'_'.$request->product_color_id[$key].'_'.$request->product_size_id[$key];

                $ps_check = PurchaseStock::where('purchase_code', $code)->where('product_id', $product_id)->where('color_id', $request->product_color_id[$key])->where('size_id', $request->product_size_id[$key])->first();
                if($ps_check){
                    $p_stock = PurchaseStock::find($ps_check->id);
                    $p_stock->buying_price = $request->$rqs_size_bp;
                    $p_stock->sale_price = $request->$rqs_size_sp;
                    $p_stock->quantity = $request->$rqs_size_qty;
                }else{
                    $p_stock = new PurchaseStock();
                    $p_stock->purchase_code = $code;
                    $p_stock->product_id = $product_id;
                    $p_stock->color_id = $request->product_color_id[$key];
                    $p_stock->size_id = $request->product_size_id[$key];
                    $p_stock->buying_price = $request->$rqs_size_bp;
                    $p_stock->sale_price = $request->$rqs_size_sp;
                    $p_stock->quantity = $request->$rqs_size_qty;
                }
                $p_stock->save();

                $ps_check = Stock::where('purchase_code', $code)->where('product_id', $product_id)->where('color_id', $request->product_color_id[$key])->where('size_id', $request->product_size_id[$key])->first();
                if($ps_check){
                    $stock = Stock::find($ps_check->id);
                    $stock->buying_price = $request->$rqs_size_bp;
                    $stock->sale_price = $request->$rqs_size_sp;
                    $stock->quantity = $request->$rqs_size_qty;
                }else{
                    $stock = new Stock();
                    $stock->purchase_code = $code;
                    $stock->product_id = $product_id;
                    $stock->color_id = $request->product_color_id[$key];
                    $stock->size_id = $request->product_size_id[$key];
                    $stock->buying_price = $request->$rqs_size_bp;
                    $stock->sale_price = $request->$rqs_size_sp;
                    $stock->quantity = $request->$rqs_size_qty;
                }
                $stock->save();
            }elseif($request->product_color_id[$key] != '' && $request->product_size_id[$key] == ''){

                $rqs_size_bp = 'buying_price_'.$product_id.'_'.$request->product_color_id[$key];
                $rqs_size_sp = 'sale_price_'.$product_id.'_'.$request->product_color_id[$key];
                $rqs_size_qty = 'quantity_'.$product_id.'_'.$request->product_color_id[$key];

                $ps_check = PurchaseStock::where('purchase_code', $code)->where('product_id', $product_id)->where('color_id', $request->product_color_id[$key])->first();
                if($ps_check){
                    $p_stock = PurchaseStock::find($ps_check->id);
                    $p_stock->buying_price = $request->$rqs_size_bp;
                    $p_stock->sale_price = $request->$rqs_size_sp;
                    $p_stock->quantity = $request->$rqs_size_qty;
                }else{
                    $p_stock = new PurchaseStock();
                    $p_stock->purchase_code = $code;
                    $p_stock->product_id = $product_id;
                    $p_stock->color_id = $request->product_color_id[$key];
                    $p_stock->buying_price = $request->$rqs_size_bp;
                    $p_stock->sale_price = $request->$rqs_size_sp;
                    $p_stock->quantity = $request->$rqs_size_qty;
                }
                $p_stock->save();

                $ps_check = Stock::where('purchase_code', $code)->where('product_id', $product_id)->where('color_id', $request->product_color_id[$key])->first();
                if($ps_check){
                    $stock = Stock::find($ps_check->id);
                    $stock->buying_price = $request->$rqs_size_bp;
                    $stock->sale_price = $request->$rqs_size_sp;
                    $stock->quantity = $request->$rqs_size_qty;
                }else{
                    $stock = new Stock();
                    $stock->purchase_code = $code;
                    $stock->product_id = $product_id;
                    $stock->color_id = $request->product_color_id[$key];
                    $stock->buying_price = $request->$rqs_size_bp;
                    $stock->sale_price = $request->$rqs_size_sp;
                    $stock->quantity = $request->$rqs_size_qty;
                }
                $stock->save();
            }else{

                $rqs_size_bp = 'buying_price_'.$product_id;
                $rqs_size_sp = 'sale_price_'.$product_id;
                $rqs_size_qty = 'quantity_'.$product_id;

                $ps_check = PurchaseStock::where('purchase_code', $code)->where('product_id', $product_id)->first();
                if($ps_check){
                    $p_stock = PurchaseStock::find($ps_check->id);
                    $p_stock->buying_price = $request->$rqs_size_bp;
                    $p_stock->sale_price = $request->$rqs_size_sp;
                    $p_stock->quantity = $request->$rqs_size_qty;
                }else{
                    $p_stock = new PurchaseStock();
                    $p_stock->purchase_code = $code;
                    $p_stock->product_id = $product_id;
                    $p_stock->buying_price = $request->$rqs_size_bp;
                    $p_stock->sale_price = $request->$rqs_size_sp;
                    $p_stock->quantity = $request->$rqs_size_qty;
                }
                $p_stock->save();

                $ps_check = Stock::where('purchase_code', $code)->where('product_id', $product_id)->first();
                if($ps_check){
                    $stock = Stock::find($ps_check->id);
                    $stock->buying_price = $request->$rqs_size_bp;
                    $stock->sale_price = $request->$rqs_size_sp;
                    $stock->quantity = $request->$rqs_size_qty;
                }else{
                    $stock = new Stock();
                    $stock->purchase_code = $code;
                    $stock->product_id = $product_id;
                    $stock->buying_price = $request->$rqs_size_bp;
                    $stock->sale_price = $request->$rqs_size_sp;
                    $stock->quantity = $request->$rqs_size_qty;
                }
                $stock->save();
            }
        }

        Toastr::success('Purchase product updated :-)','Success');
        return redirect()->back();
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

    // ajax for proudct parchase

    public function stockPurchase(Request $request)
    {
        $product_id = $request->product_id;

        // return $product_id;
        $product = Product::where('id', $product_id)->latest()->first();
        // return $product;
        $product_code = $product->product_code;
        $product_name = $product->name;
        return $data = [$product_code, $product_name];
    }

    public function add_product_for_purchase(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $html = '';

        $product_sizes = ProductSize::where('product_id', $product_id)->get();
        if($product_sizes->count() > 0){
            foreach($product_sizes as $s_key=>$p_size){
                $color = Color::find($p_size->color_id);
                $size = Size::find($p_size->size_id);
                $html .= '
                    <tr class="tr_exist_'.$product_id.'" id="product_tr_size_'.$product_id.'_'.$p_size->color_id.'_'.$p_size->size_id.'">
                        <td>
                            <input type="hidden" name="product_id[]" value="'.$product_id.'">
                            <input type="hidden" name="product_color_id[]" value="'.$p_size->color_id.'">
                            <input type="hidden" name="product_size_id[]" value="'.$p_size->size_id.'">
                            '.$product->name.'<br> Color: '.$color->name.', Size: '.$size->name.'
                        </td>
                        <td><input type="text" class="form-control" name="quantity_'.$product_id.'_'.$p_size->color_id.'_'.$p_size->size_id.'" value="0" min="0"></td>
                        <td><input type="text" class="form-control" name="buying_price_'.$product_id.'_'.$p_size->color_id.'_'.$p_size->size_id.'" value="'.$product->regular_price.'" min="0"></td>
                        <td><input type="text" class="form-control" name="sale_price_'.$product_id.'_'.$p_size->color_id.'_'.$p_size->size_id.'" value="'.$product->sale_price.'" min="0"></td>
                        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeSizeProduct('.$product_id.','.$p_size->color_id.','.$p_size->size_id.')"><i class="fa fa-trash"></i></button></td>
                    </tr>
                ';
            }
        }else{
            $product_colors = ProductColor::where('product_id', $product_id)->get();
            if($product_colors->count() > 0){
                foreach($product_colors as $s_key=>$p_color){
                    $color = Color::find($p_color->color_id);
                    $html .= '
                        <tr class="tr_exist_'.$product_id.'" id="product_tr_color_'.$product_id.'_'.$p_color->color_id.'">
                            <td>
                                <input type="hidden" name="product_id[]" value="'.$product_id.'">
                                <input type="hidden" name="product_color_id[]" value="'.$p_color->color_id.'">
                                <input type="hidden" name="product_size_id[]" value="">
                                '.$product->name.'<br> Color: '.$color->name.'
                            </td>
                            <td><input type="text" class="form-control" name="quantity_'.$product_id.'_'.$p_color->color_id.'" value="0" min="0"></td>
                            <td><input type="text" class="form-control" name="buying_price_'.$product_id.'_'.$p_color->color_id.'" value="'.$product->regular_price.'" min="0"></td>
                            <td><input type="text" class="form-control" name="sale_price_'.$product_id.'_'.$p_color->color_id.'" value="'.$product->sale_price.'" min="0"></td>
                            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeColorProduct('.$product_id.','.$p_color->color_id.')"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    ';
                }
            }else{
                $html .= '
                        <tr class="tr_exist_'.$product_id.'" id="product_tr_'.$product_id.'">
                            <td>
                                <input type="hidden" name="product_id[]" value="'.$product_id.'">
                                <input type="hidden" name="product_color_id[]" value="">
                                <input type="hidden" name="product_size_id[]" value="">
                                '.$product->name.'
                            </td>
                            <td><input type="text" class="form-control" name="quantity_'.$product_id.'" value="0" min="0"></td>
                            <td><input type="text" class="form-control" name="buying_price_'.$product_id.'" value="'.$product->regular_price.'" min="0"></td>
                            <td><input type="text" class="form-control" name="sale_price_'.$product_id.'" value="'.$product->sale_price.'" min="0"></td>
                            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeProduct('.$product_id.')"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    ';
            }
        }

        return $html;

    }
}
