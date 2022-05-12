<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        $title = "Cart";
        $lan = $request->session()->get('lan');
        // return $request->session()->get('cart');
        $p_cat_id = '';
        $search = '';
        return view('customer.cart', compact('title', 'lan', 'p_cat_id','search'));
    }

    // product add on cart with  size color and quantity
    public function addToCartWithSizeColorQuantity(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'quantity' => 'required',
        ]);

        if($request->size_id){
            $sizeId = $request->size_id;
        }else {
            $sizeId = NULL;
        }

        if($request->color_id){
            $colorId = $request->color_id;
        }else {
            $colorId = NULL;
        }

        $product_id = $request->product_id;
        $regular_price = $request->regular_price;
        $sale_price = $request->sale_price;
        $shipping_charge = $request->shipping_charge;
        $discount = $request->discount;

        $product = Product::findOrFail($product_id);
        // check for if product exist
        if(!$product) {
            abort(404);
        }
        // create a session for cart
        $cart = session()->get('cart');
        // if cart empty then this is the first product with size and color and quantity by request
        if(!$cart) {
            $cart = [
                $product_id => [
                    'name' => $product->name,
                    'quantity' => $request->quantity,
                    'size_id' => $sizeId,
                    'color_id' => $colorId,
                    'regular_price' => $regular_price,
                    'price' => $sale_price,
                    'discount' => $discount,
                    'shipping_charge' => $shipping_charge,
                    'image' => $product->thumbnail,
                ]
            ];
            session()->put('cart', $cart);

            if($request->cart_type == 'Add to cart'){
                Toastr::success('Product add on cart successfully :-)','Success');
                return redirect()->back();
            }elseif($request->cart_type == 'Buy now'){
                Toastr::success('Product add on cart successfully :-)','Success');
                if (Auth::check()){
                    return redirect()->route('customer.checkout.index');
                }else{
                    return redirect()->route('customer.guest-checkout.index');
                }
            }
        }

        if(isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] + $request->quantity;
            session()->put('cart', $cart);

            if($request->cart_type == 'Add to cart'){
                Toastr::success('Product add on cart successfully :-)','Success');
                return redirect()->back();
            }elseif($request->cart_type == 'Buy now'){
                Toastr::success('Product add on cart successfully :-)','Success');
                if (Auth::check()){
                    return redirect()->route('customer.checkout.index');
                }else{
                    return redirect()->route('customer.guest-checkout.index');
                }
            }
        }

        $cart[$product_id] = [
            'name' => $product->name,
            'quantity' => $request->quantity,
            'size_id' => $sizeId,
            'color_id' => $colorId,
            'regular_price' => $regular_price,
            'price' => $sale_price,
            'discount' => $discount,
            'shipping_charge' => $shipping_charge,
            'image' => $product->thumbnail,
        ];
        session()->put('cart', $cart);

        if($request->cart_type == 'Add to cart'){
            Toastr::success('Product add on cart successfully :-)','Success');
            return redirect()->back();
        }elseif($request->cart_type == 'Buy now'){
            Toastr::success('Product add on cart successfully :-)','Success');
            if (Auth::check()){
                return redirect()->route('customer.checkout.index');
            }else{
                return redirect()->route('customer.guest-checkout.index');
            }
        }

    }

	public function cartUpdate(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);

            Toastr::success('Cart updated successfully!','Success');
        }
    }


    public function cartRemove($id)
    {
        if($id) {
            $cart = session()->get('cart');
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            Toastr::warning('Product remove form cart successfully :-)','Success');
            return redirect()->back();
        }
    }
}
