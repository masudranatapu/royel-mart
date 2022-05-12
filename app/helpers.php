<?php

use App\Models\Area;
use App\Models\DefaultDeliveryLocation;
use App\Models\District;
use App\Models\Division;
use App\Models\ExpenseCategory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Review;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

function total_review($product_id)
{
    return Review::where('product_id', $product_id)->where('replay', 0)->count();
}

function final_rating($product_id)
{
    $t_count = Review::where('product_id', $product_id)->where('replay', 0)->count();
    $total_rating = Review::where('product_id', $product_id)->where('replay', 0)->sum('rating');

    if ($total_rating > 0 && $t_count > 0) {
        return $total_rating / $t_count;
    } else {
        return 0;
    }
}

function user_image($user_id)
{
    $user = User::find($user_id);
    if (file_exists($user->image)) {
        return $user->image;
    } else {
        return 'demomedia/demoprofile.png';
    }
}

function review_image($id)
{
    $review = Review::find($id);
    $html = '';
    if ($review->image != NULL) {
        $mult_images = explode("|", $review->image);
        foreach ($mult_images as $key => $image) {
            $html .= '<img loading="eager|lazy" src="' . URL::to($image) . '" width="100px" height="100px" alt="">';
        }
    }

    echo $html;
}

function product_review($product_id)
{
    $ratting = final_rating($product_id);
    if ($ratting == 0) {
        echo '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 0%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
            </div>
        ';
    } else {
        review_rating($ratting);
    }
}

function product_review_details_page($product_id)
{
    $ratting = final_rating($product_id);
    if ($ratting == 0) {
        echo '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 0%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
                <div class="reviews-answer">
                    <span class="count-reviews">( 0 ratings)</span>
                </div>
            </div>
        ';
    } else {
        review_rating_details_page($ratting, $product_id);
    }
}

function review_rating_details_page($ratting, $product_id)
{
    $html = '';
    if ($ratting == 5) {
        $html .= '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 100%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
                <div class="reviews-answer">
                    <span class="count-reviews">( ' . total_review($product_id) . ' ratings)</span>
                </div>
            </div>
        ';
    } elseif ($ratting == 4) {
        $html .= '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 80%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
                <div class="reviews-answer">
                    <span class="count-reviews">( ' . total_review($product_id) . ' ratings)</span>
                </div>
            </div>
        ';
    } elseif ($ratting == 3) {
        $html .= '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 60%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
                <div class="reviews-answer">
                    <span class="count-reviews">( ' . total_review($product_id) . ' ratings)</span>
                </div>
            </div>
        ';
    } elseif ($ratting == 4) {
        $html .= '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 40%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
                <div class="reviews-answer">
                    <span class="count-reviews">( ' . total_review($product_id) . ' ratings)</span>
                </div>
            </div>
        ';
    } elseif ($ratting == 5) {
        $html .= '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 20%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
                <div class="reviews-answer">
                    <span class="count-reviews">( ' . total_review($product_id) . ' ratings)</span>
                </div>
            </div>
        ';
    }

    echo $html;
}

function review_rating($ratting)
{
    $html = '';
    if ($ratting == 5) {
        $html .= '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 100%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
            </div>
        ';
    } elseif ($ratting == 4) {
        $html .= '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 80%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
            </div>
        ';
    } elseif ($ratting == 3) {
        $html .= '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 60%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
            </div>
        ';
    } elseif ($ratting == 4) {
        $html .= '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 40%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
            </div>
        ';
    } elseif ($ratting == 5) {
        $html .= '
            <div class="reviews">
                <div class="reviews-inner">
                    <div class="reviewed" style="width: 20%">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="blanked">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                </div>
            </div>
        ';
    }

    echo $html;
}

function replay_this_review($id)
{
    $html = '';

    $replays = Review::where('replay_review_id', $id)->where('replay', 1)->orderBy('id', 'ASC')->get();
    if ($replays->count() > 0) {
        foreach ($replays as $review) {
            $html .= '
                            <div class="review-head">
                                <div class="user-area">
                                    <div class="user-photo">
                                        <img loading="eager|lazy" src="';
            if ($review->user_id) {
                $html .= ' ' . asset(user_image($review->user_id)) . ' ';
            } else {
                $html .= ' ' . asset('demomedia/demoprofile.png') . ' ';
            }
            $html .= ' " alt="">
                                    </div>
                                    <div class="user-meta">';
            if ($review->name == NULL) {
                $html .= '<h4 class="username">No Name Reviewer</h4>';
            } else {
                $html .= '<h4 class="username">' . $review->name . '</h4>';
            }

            $html .= ' ' . review_rating($review->rating) . '
                                    </div>
                                </div>
                                <div class="date-area">
                                    <span class="date">
                                        ' . $review->created_at->format('d M Y h:i A') . '
                                    </span>
                                </div>
                            </div>
                            <div class="review-body">
                                <p>' . $review->opinion . '</p>
                                ' . review_image($review->id) . '
                            </div>
            ';
        }
    }

    echo $html;
}


function ordered_product($order_id)
{
    $order = Order::find($order_id);
    $html = '';

    $products = OrderProduct::where('order_code', $order->order_code)->get();
    if ($products->count() > 0) {
        foreach ($products as $order_product) {
            $product = Product::find($order_product->product_id);
            $stock = Stock::where('product_id', $order_product->product_id)->where('quantity', '>', 0)->sum('quantity');
            $sale_price = $order_product->sale_price;
            $quantity = $order_product->quantity;

            $html .= '
                <tr id="product_tr_' . $product->id . '">
                    <td class="text-center">
                        <button class="btn btn-danger waves-effect" type="button" onclick="removeProductTr(' . $product->id . ')">
                            <i class="ml-1 fa fa-trash"></i>
                        </button>
                    </td>
                    <td>
                        <img src="';

            if (file_exists($product->thumbnail)) {
                $html .= '' . URL::to($product->thumbnail) . '';
            } else {
                $html .= 'asset("media\general-image\no-photo.jpg")';
            }
            $html .= ' " width="100%" height="60px" alt="banner image">
                    </td>
                    <td>
                        <input type="hidden" class="form-control" name="product_id[]" value="' . $product->id . '">
                        <a href="' . route('productdetails', $product->slug) . '" target="_blank">' . $product->name . '</a>
                    </td>
                    <td>
                        <input type="hidden" class="form-control text-center" value="' . $stock . '" id="pro_max_quantity_' . $product->id . '">
                        <input type="text" class="form-control text-center" value="' . $quantity . '" name="pro_quantity[]" id="pro_quantity_' . $product->id . '" onfocus="focusInQuantity(' . $product->id . ')" onfocusout="focusOutQuantity(' . $product->id . ')" onpaste="QuantityCng(' . $product->id . ')" onkeyup="QuantityCng(' . $product->id . ')" onchange="QuantityCng(' . $product->id . ')">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-center" name="pro_sale_price[]" value="' . $sale_price . '" id="pro_sale_price_' . $product->id . '" onfocus="focusInSalePrice(' . $product->id . ')" onfocusout="focusOutSalePrice(' . $product->id . ')" onpaste="SalePriceCng(' . $product->id . ')" onkeyup="SalePriceCng(' . $product->id . ')" onchange="SalePriceCng(' . $product->id . ')">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-right" readonly name="pro_shipping[]" id="pro_shipping_' . $product->id . '" value="' . $product->shipping_charge . '">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-right" readonly name="pro_total[]" id="pro_total_' . $product->id . '" value="' . ($sale_price * $quantity) . '">
                    </td>
                </tr>
            ';
        }
    }

    echo $html;
}

function product_name($id)
{
    $product = Product::find($id);
    if($product){
        return $product->name;
    }else{
        return 'N/A';
    }
}

function expense_category($id)
{
    $category = ExpenseCategory::find($id);
    if($category){
        return $category->name;
    }else{
        return 'N/A';
    }
}

function user_name($id)
{
    $user = User::find($id);
    if($user){
        return $user->name;
    }else{
        return 'N/A';
    }
}

function division_name($id)
{
    $data = Division::find($id);
    if($data){
        return $data->name.', ';
    }else{
        $default_location = DefaultDeliveryLocation::latest()->first();
        $data = Division::find($default_location->division_id);
        return $data->name.', ';
    }
}

function district_name($id)
{
    $data = District::find($id);
    if($data){
        return $data->name.', ';
    }else{
        $default_location = DefaultDeliveryLocation::latest()->first();
        $data = District::find($default_location->district_id);
        return $data->name.', ';
    }
}

function area_name($id)
{
    $data = Area::find($id);
    if($data){
        return $data->name;
    }else{
        $default_location = DefaultDeliveryLocation::latest()->first();
        $data = Area::find($default_location->area_id);
        return $data->name;
    }
}

function pro_shipping_charge($id)
{
    $product = Product::find($id);
    if($product->free_shipping_charge == 1){
        if(Auth::user()){
            $area = Area::find(Auth::user()->area_id);
        }else{
            $area = Area::find(session()->get('area_id'));
        }
        if($area){
            if($area->is_inside == 0){
                return '৳ '.$product->outside_shipping_charge;
            }else{
                return '৳ '.$product->inside_shipping_charge;
            }
        }else{
            $default_location = DefaultDeliveryLocation::latest()->first();
            $area = Area::find($default_location->area_id);
            if($area->is_inside == 0){
                return '৳ '.$product->outside_shipping_charge;
            }else{
                return '৳ '.$product->inside_shipping_charge;
            }
        }
    }else{
        return 'Free';
    }
}

function shipping_charge($id)
{
    $product = Product::find($id);
    if($product->free_shipping_charge == 1){
        if(Auth::user()){
            $area = Area::find(Auth::user()->area_id);
        }else{
            $area = Area::find(session()->get('area_id'));
        }
        if($area){
            if($area->is_inside == 0){
                return $product->outside_shipping_charge;
            }else{
                return $product->inside_shipping_charge;
            }
        }else{
            $default_location = DefaultDeliveryLocation::latest()->first();
            $area = Area::find($default_location->area_id);
            if($area->is_inside == 0){
                return $product->outside_shipping_charge;
            }else{
                return $product->inside_shipping_charge;
            }
        }
    }else{
        return 'Free';
    }
}

