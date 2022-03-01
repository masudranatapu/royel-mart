<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Auth;
use App\Models\Division;
use App\Models\District;
use App\Models\Vat;
use App\Models\Order;

class CheckoutController extends Controller
{
    //
    public function index()
    {
        $title = "Checkout";
        $divisions = Division::latest()->get();
        return view('customer.checkout', compact('title', 'divisions'));
    }
}
