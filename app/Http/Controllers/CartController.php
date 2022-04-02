<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function cart(Request $request)
    {
        $title = "Cart";
        $lan = $request->session()->get('lan');
        // return $request->session()->get('cart');
        $p_cat_id = '';
        return view('customer.cart', compact('title', 'lan', 'p_cat_id'));
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

    // add to cart with quantity in product id
    public function addToCartWithQuantity(Request $request)
    {
        //
        $this->validate($request, [
            'quantity' => 'required',
        ]);

        $product_id = $request->product_id;

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
                    'quantity' => $request->quantity,
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

            // only one time will be product quantity  be add to cart

            // $cart[$product_id]['quantity']++;

            // session()->put('cart', $cart);

            Toastr::info('Product already on cart :-)','info');
            return redirect()->back();
        }
        // another product will be add to cart if cart is empty and quantity will be requested
        $cart[$product_id] = [
            'name' => $product->name,
            'quantity' => $request->quantity,
            'size_id' => NULL,
            'color_id' => NULL,
            'price' => $product->sale_price,
            'image' => $product->thambnail,
        ];
        session()->put('cart', $cart);
        Toastr::success('Product add on cart successfully :-)','Success');
        return redirect()->back();
    }

    // product add on cart with  size color and quantity
    public function addToCartWithSizeColorQuantity(Request $request)
    {
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
        $sale_price = $request->sale_price;
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
                    'price' => $sale_price,
                    'discount' => $discount,
                    'shipping_charge' => $product->shipping_charge,
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
            'price' => $sale_price,
            'discount' => $discount,
            'shipping_charge' => $product->shipping_charge,
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

    // buy now with quantity in product id
    public function buyNowWithQuantity(Request $request)
    {
        //
        $product_id = $request->product_id;

        $product = Product::findOrFail($product_id);
        // check for if product exist
        if(!$product) {
            abort(404);
        }
        // create a session for cart
        $cart = session()->get('cart');
        // if buy now  cart empty then this is the first product
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
            return redirect()->route('customer.checkout.index');
        }
        // if cart already in buy now cart add to cart again then just quantity incressing
        if(isset($cart[$product_id])) {

            // only one time will be product quantity  be add to buy now cart

            // $cart[$product_id]['quantity']++;

            // session()->put('cart', $cart);

            Toastr::info('Product already on cart :-)','info');
            return redirect()->route('customer.checkout.index');
        }
        // another product will be add to buy now cart if cart is empty and quantity will be requested
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
        return redirect()->route('customer.checkout.index');
    }

    public function buyNowWithSizeColorQuantity(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required',
        ]);

        $product_id = $request->product_id;

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
                    'size_id' => $request->size_id,
                    'color_id' => $request->color_id,
                    'price' => $product->sale_price,
                    'image' => $product->thambnail,
                ]
            ];
            session()->put('cart', $cart);
            Toastr::success('Product add on cart successfully :-)','Success');
            return redirect()->back();
        }
        // never add to cart if this product allready have in cart
        if(isset($cart[$product_id])) {

            // $cart[$product_id]['quantity']++;

            // session()->put('cart', $cart);

            Toastr::info('Product already on cart :-)','info');
            return redirect()->back();
        }
        // if cart is empty then it will be add to cart wtih quantity 1
        $cart[$product_id] = [
            'name' => $product->name,
            'quantity' => $request->quantity,
            'size_id' => $request->size_id,
            'color_id' => $request->color_id,
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
