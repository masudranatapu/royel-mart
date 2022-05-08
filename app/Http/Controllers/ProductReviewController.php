<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function review(Request $request)
    {
        $validateData = $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'rating'=>'required',
        ]);

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

        $review = new Review();
        if (Auth::user()){
            $review->user_id = Auth::user()->id;
        }
        $review->product_id = $request->product_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->opinion = $request->opinion;
        $review->rating = $request->rating;
        $review->phone = $request->phone;
        $review->image = $image_name;
        $review->save();

        Toastr::success('Your review successfully done :-)','success');
        return redirect()->back();
    }

    public function replay_review(Request $request, $id)
    {
        $validateData = $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'rating'=>'required',
        ]);

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

        $review = new Review();
        if (Auth::user()){
            $review->user_id = Auth::user()->id;
        }
        $review->product_id = $request->product_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->opinion = $request->opinion;
        $review->rating = $request->rating;
        $review->phone = $request->phone;
        $review->image = $image_name;
        $review->replay_review_id = $id;
        $review->replay = 1;
        $review->save();

        Toastr::success('Your replay successfully done :-)','success');
        return redirect()->back();
    }
}
