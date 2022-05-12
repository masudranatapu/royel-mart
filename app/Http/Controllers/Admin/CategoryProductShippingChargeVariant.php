<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryShippingChargeVariant;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CategoryProductShippingChargeVariant extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Category Banner";
        $categories = Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', '0')->orderBy('serial_number','asc')->latest()->get();
        $category_crgs = CategoryShippingChargeVariant::latest()->get();
        return view('admin.category-shipping-variant.index', compact('title', 'category_crgs', 'categories'));
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
            'category_id' => 'required',
        ]);

        $charge_variant = new CategoryShippingChargeVariant();
        if($request->parent_id == '' && $request->child_id == ''){
            $charge_variant->category_id = $request->category_id;
        }elseif($request->parent_id != '' && $request->child_id == ''){
            $charge_variant->category_id = $request->parent_id;
        }elseif($request->parent_id != '' && $request->child_id != ''){
            $charge_variant->category_id = $request->child_id;
        }
        $charge_variant->qty_one_charge_variant = $request->qty_one_charge_variant;
        $charge_variant->qty_two_charge_variant = $request->qty_two_charge_variant;
        $charge_variant->qty_three_charge_variant = $request->qty_three_charge_variant;
        $charge_variant->qty_four_charge_variant = $request->qty_four_charge_variant;
        $charge_variant->qty_five_charge_variant = $request->qty_five_charge_variant;
        $charge_variant->qty_more_than_five_charge_variant = $request->qty_more_than_five_charge_variant;
        $charge_variant->save();

        Toastr::success('Charge successfully save :-)','Success');
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
        $charge_variant = CategoryShippingChargeVariant::find($id);
        $charge_variant->qty_one_charge_variant = $request->qty_one_charge_variant;
        $charge_variant->qty_two_charge_variant = $request->qty_two_charge_variant;
        $charge_variant->qty_three_charge_variant = $request->qty_three_charge_variant;
        $charge_variant->qty_four_charge_variant = $request->qty_four_charge_variant;
        $charge_variant->qty_five_charge_variant = $request->qty_five_charge_variant;
        $charge_variant->qty_more_than_five_charge_variant = $request->qty_more_than_five_charge_variant;
        $charge_variant->save();

        Toastr::success('Charge successfully save :-)','Success');
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
}
