<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function review_list()
    {
        $title = "Product Review";
        $reviews = Review::where('replay', '0')->latest()->get();
        return view('admin.product-review.index', compact('title', 'reviews'));
    }

    public function replay(Request $request, $id)
    {
        $review_image = $request->file('image');
        $slug = "review";
        if (isset($review_image)) {
            foreach ($review_image as $key => $image) {
                $image_name = $slug . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $upload_path = 'media/multi-product/';
                $image_image_url = $upload_path . $image_name;
                $image->move($upload_path, $image_name);
                $img_arr[$key] = $image_image_url;
            }
            $image_name = trim(implode('|', $img_arr), '|');
        } else {
            $image_name = NULL;
        }

        $ck_review = Review::find($id);
        $review = new Review();
        $review->user_id = Auth::user()->id;
        $review->product_id = $ck_review->product_id;
        $review->name = Auth::user()->name;
        $review->email = Auth::user()->email;
        $review->opinion = $request->replay_opinion;
        $review->rating = 5;
        $review->phone = Auth::user()->phone;
        $review->replay_review_id = $id;
        $review->image = $image_name;
        $review->replay = 1;
        $review->save();

        Toastr::success('Your replay successfully done :-)','success');
        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $review = Review::find($id);
        if($review->image != NULL){
            $mult_images = explode("|", $review->image);
            foreach ($mult_images as $key => $image) {
                if(file_exists($image)){
                    unlink($image);
                }
            }
        }

        $review->delete();

        Toastr::success('Your review successfully deleted :-)','success');
        return redirect()->back();
    }
}
