<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\CategoryShippingChargeVariant;
use App\Models\DefaultDeliveryLocation;
use App\Models\District;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryLocationController extends Controller
{
    public function get_district(Request $request)
    {
        $division_id = $request->division_id;
        $html = '';

        $districts = District::where('division_id', $division_id)->get();
        if($districts->count() > 0){
            $html .= '<option value="">Select One</option>';
            foreach($districts as $district){
                $html .= '<option value="'.$district->id.'">'.$district->name.'</option>';
            }
        }else{
            $html .= '<option value="">Select One</option>';
        }

        return $html;
    }

    public function get_area(Request $request)
    {
        $district_id = $request->district_id;
        $html = '';

        $areas = Area::where('district_id', $district_id)->get();
        if($areas->count() > 0){
            $html .= '<option value="">Select One</option>';
            foreach($areas as $area){
                $html .= '<option value="'.$area->id.'">'.$area->name.'</option>';
            }
        }else{
            $html .= '<option value="">Select One</option>';
        }

        return $html;
    }

    public function get_final_delivery_location(Request $request)
    {
        $division_id = $request->division_id;
        $district_id = $request->district_id;
        $area_id = $request->area_id;
        
        $area = Area::find($area_id);

        $product_id = $request->product_id;
        $pro_quantity = $request->pro_quantity;

        $shipping_charge = 0;
        $shipping_charge_html = '';

        $product = Product::find($product_id);
        $check_sh_variant = CategoryShippingChargeVariant::where('category_id', $product->category_id)->first();
        if($product->free_shipping_charge == 1){
            if($area->is_inside == 0){

                if($check_sh_variant){
                    $temp_sp_charge = $product->outside_shipping_charge * $pro_quantity;
                    if($pro_quantity == 1){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_one_charge_variant)/100);
                    }elseif($pro_quantity == 2){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_two_charge_variant)/100);
                    }elseif($pro_quantity == 3){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_three_charge_variant)/100);
                    }elseif($pro_quantity == 4){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_four_charge_variant)/100);
                    }elseif($pro_quantity == 5){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_five_charge_variant)/100);
                    }elseif($pro_quantity > 5){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_more_than_five_charge_variant)/100);
                    }
                }else{
                    $sp_charge = $product->outside_shipping_charge * $pro_quantity;
                }

                $shipping_charge_html = '৳ '.($sp_charge);
                $shipping_charge = ($sp_charge);
            }else{
                if($check_sh_variant){
                    $temp_sp_charge = $product->inside_shipping_charge * $pro_quantity;
                    if($pro_quantity == 1){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_one_charge_variant)/100);
                    }elseif($pro_quantity == 2){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_two_charge_variant)/100);
                    }elseif($pro_quantity == 3){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_three_charge_variant)/100);
                    }elseif($pro_quantity == 4){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_four_charge_variant)/100);
                    }elseif($pro_quantity == 5){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_five_charge_variant)/100);
                    }elseif($pro_quantity > 5){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_more_than_five_charge_variant)/100);
                    }
                }else{
                    $sp_charge = $product->inside_shipping_charge * $pro_quantity;
                }

                $shipping_charge_html = '৳ '.($sp_charge);
                $shipping_charge = ($sp_charge);
            }
        }else{
            $shipping_charge_html = 'Free';
            $shipping_charge = 0;
        }

        $request->session()->put('division_id', $division_id);
        $request->session()->put('district_id', $district_id);
        $request->session()->put('area_id', $area_id);

        $html = division_name($division_id).district_name($district_id).area_name($area_id);

        return ['html' => $html, 'shipping_charge_html' => $shipping_charge_html, 'shipping_charge' => $shipping_charge];
    }

    public function quantity_wise_shipping_charge_change(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->area_id == ''){
                $default_location = DefaultDeliveryLocation::latest()->first();
                $area_id = $default_location->area_id;
            }else{
                $area_id = Auth::user()->area_id;
            }

            $area = Area::find($area_id);
        }else{
            $area_id = session()->get('area_id');
            $area = Area::find($area_id);
        }

        $product_id = $request->product_id;
        $pro_quantity = $request->pro_quantity;

        $shipping_charge = 0;
        $shipping_charge_html = '';

        $product = Product::find($product_id);
        $check_sh_variant = CategoryShippingChargeVariant::where('category_id', $product->category_id)->first();
        if($product->free_shipping_charge == 1){
            if($area->is_inside == 0){

                if($check_sh_variant){
                    $temp_sp_charge = $product->outside_shipping_charge * $pro_quantity;
                    if($pro_quantity == 1){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_one_charge_variant)/100);
                    }elseif($pro_quantity == 2){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_two_charge_variant)/100);
                    }elseif($pro_quantity == 3){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_three_charge_variant)/100);
                    }elseif($pro_quantity == 4){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_four_charge_variant)/100);
                    }elseif($pro_quantity == 5){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_five_charge_variant)/100);
                    }elseif($pro_quantity > 5){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_more_than_five_charge_variant)/100);
                    }
                }else{
                    $sp_charge = $product->outside_shipping_charge * $pro_quantity;
                }

                $shipping_charge_html = '৳ '.($sp_charge);
                $shipping_charge = ($sp_charge);
            }else{
                if($check_sh_variant){
                    $temp_sp_charge = $product->inside_shipping_charge * $pro_quantity;
                    if($pro_quantity == 1){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_one_charge_variant)/100);
                    }elseif($pro_quantity == 2){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_two_charge_variant)/100);
                    }elseif($pro_quantity == 3){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_three_charge_variant)/100);
                    }elseif($pro_quantity == 4){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_four_charge_variant)/100);
                    }elseif($pro_quantity == 5){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_five_charge_variant)/100);
                    }elseif($pro_quantity > 5){
                        $sp_charge = $temp_sp_charge - (($temp_sp_charge * $check_sh_variant->qty_more_than_five_charge_variant)/100);
                    }
                }else{
                    $sp_charge = $product->inside_shipping_charge * $pro_quantity;
                }

                $shipping_charge_html = '৳ '.($sp_charge);
                $shipping_charge = ($sp_charge);
            }
        }else{
            $shipping_charge_html = 'Free';
            $shipping_charge = 0;
        }

        return ['shipping_charge_html' => $shipping_charge_html, 'shipping_charge' => $shipping_charge];
    }
}
