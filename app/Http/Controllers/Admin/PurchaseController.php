<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchases;
use App\Models\Product;
use App\Models\Unit;
use App\Models\ProductUnit;
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
        //
        $title = "Purchase Product";
        
        $check_stock_product = Purchases::pluck('product_id')->toArray();
        $purchases = Purchases::latest()->get();
        $products = Product::whereNotIn('id', $check_stock_product)->latest()->get();

        $editproducts = Product::latest()->get();
        return view('admin.stock.index', compact('title', 'purchases', 'products', 'editproducts'));
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
        return view('admin.stock.purchase', compact('title', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'product_id' => 'required',
            'quantity' => 'required',
        ]);
        Purchases::insert([
            'product_id' => $request->product_id,
            'product_code' => $request->product_code,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'created_at' => Carbon::now(),
        ]);
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
        $this->validate($request, [
            'product_id' => 'required',
            'quantity' => 'required',
        ]);
        Purchases::findOrFail($id)->update([
            'product_id' => $request->product_id,
            'product_code' => $request->product_code,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'updated_at' => Carbon::now(),
        ]);
        Toastr::info('Purchase product update :-)','Info');
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
    public function productpurchaseAjax(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $result = null;
        if ($product) {
            $result .= '<tr class="purchase-product-table" id="remove_tr_'.$product->id.'">';
                $result .=   '<td>
                                    <input type="hidden" name="product_id[]" value="' . $product->id . '" class="form-control">
                                    ' . $product->title . '
                                </td>';

                $check_colors = ProductUnit::where('product_id', $product->id)->get();
                if ($check_colors->count() > 0) {
                    $result .=   '<td>';
                        foreach ($check_colors as $check_color) {
                            $color = Unit::find($check_color->color_id);
                            $result .=  '<div class="row">
                                            <div class="col-md-12">
                                                <label for="">' . $color->name . '</label>
                                                <input type="hidden" name="product_color_id_'.$product->id.'[]" value="' . $color->id . '" class="form-control">
                                                <input type="hidden" id="product_color_qty_for_check_'.$color->id.'_'.$product->id.'" value="0" readonly class="form-control">
                                                <input type="text" name="product_color_qty_'.$color->id.'_'.$product->id.'" id="product_color_qty_'.$color->id.'_'.$product->id.'" value="0" onpaste="productColorQtyPstChange('.$color->id.','.$product->id.')" onkeyup="productColorQtyChange('.$color->id.','.$product->id.')" class="form-control">
                                            </div>
                                        </div>';
                        }
                    $result .=   '</td>';
                } else {
                    $result .=   '<td> NULL </td>';
                }
                $result .=  '<td>
                                <input type="number" id="product_total_qty_'.$product->id.'" name="product_qty[]" onpaste="productQtyPstChange('.$product->id.')" onkeyup="productQtyChange('.$product->id.')" value="0" class="form-control">
                            </td>';
                $result .=  '<td>
                                <input type="hidden" id="product_purchase_cost_for_check_'.$product->id.'" value="0" class="form-control">
                                <input type="number" id="product_purchase_cost_'.$product->id.'" name="product_purchase_cost[]" onpaste="productPurchaseCostPstChange('.$product->id.')" onkeyup="productPurchaseCostChange('.$product->id.')" value="'.$product->buying_price.'" class="form-control">
                            </td>';
                $result .=  '<td>
                                <input type="number" id="product_sale_price_'.$product->id.'" name="product_sale_price[]" onpaste"productSalePricePstChange('.$product->id.')" onkeyup="productSalePriceChange('.$product->id.')" value="0" class="form-control"></td>';
                $result .=  '<td>
                                <input type="number" id="product_total_cost_'.$product->id.'" name="product_total_cost[]" readonly value="0" class="form-control">
                            </td>';
                $result .=  '<td>
                                <button type="button" onclick="removeProductFromTable(this)" id="'.$product->id.'" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>';
            $result .= '</tr>';
            return $result;
        } else {
            return $result;
        }
    }
}
