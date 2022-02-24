<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;

class CartController extends Controller
{
    //
    public function cart()
    {
        $title = "Cart";
        return view('customer.cart', compact('title'));
    }
    // add to cart with product id 
    public function addToCart($product_id)
    {
        $product = Product::findOrFail($product_id);
        // check for if product exist
        if(!$product) {
            abort(404);
        }
        // create a session for cart 
        $cart = session()->get('cart');
        // if cart empty then this is the first product 
        if(!$cart) {
            $cart = [
                $product_id => [
                    'name' => $product->name,
                    'quantity' => 1,
                    'size_id' => NULL,
                    'color_id' => NULL,
                    'price' => $product->sale_price,
                    'image' => $product->thambnail,
                ]
            ];
            session()->put('cart', $cart);
            Toastr::success('Product add on cart successfully :-)','Success');
            return redirect()->back();
        }
        // if cart already has and add to cart again then just quantity incressing
        if(isset($cart[$product_id])) {
            $cart[$product_id]['quantity']++;

            session()->put('cart', $cart);

            Toastr::success('Product add on cart successfully :-)','Success');
            return redirect()->back();
        }
        // if cart is empty then it will be add to cart wtih quantity 1
        $cart[$product_id] = [
            'name' => $product->name,
            'quantity' => 1,
            'size_id' => NULL,
            'color_id' => NULL,
            'price' => $product->sale_price,
            'image' => $product->thambnail,
        ];
        session()->put('cart', $cart);
        Toastr::success('Product add on cart successfully :-)','Success');
        return redirect()->back();
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
