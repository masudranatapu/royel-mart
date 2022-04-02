<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;

class SearchController extends Controller
{
    //
    public function searching(Request $request)
    {
        // return $request;
        $title = $request->search_product;
        $p_cat_id = '';
        $lan = $request->session()->get('lan');
        $searching = $request->search_product;
        $create_url = "search_product=".$searching;
        if(isset($searching)) {
            $products = Product::where('name', 'LIKE', '%'.$searching.'%')->orWhere('name_en', 'LIKE', '%'.$searching.'%')->orWhere('slug', 'LIKE', '%'.$searching.'%')->latest()->paginate(24);
        }else {
            $products = "";
            Toastr::warning('You have no name for search product:-)','warning');
            return redirect()->back();
        }
		Toastr::success('Your searching products is !', 'success');
        return view('pages.searchproduct', compact('title', 'p_cat_id', 'lan', 'products'));
    }
}
