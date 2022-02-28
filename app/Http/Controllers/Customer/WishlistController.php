<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use App\Models\Review;

class WishlistController extends Controller
{
    //
    public function review(Request $request)
    {
        //
        $validateData = $request->validate([
            'rating'=>'required',
        ]);
        Review::insert([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'opinion' => $request->opinion,
            'rating' => $request->rating,
            'phone' => $request->phone,
            'created_at' => Carbon::now(),
        ]);
        Toastr::success('Your review successfully done :-)','success');
        return redirect()->back();
    }
}
