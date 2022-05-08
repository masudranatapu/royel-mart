<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function customer_list()
    {
        $title = "Customer";
        $customers = User::where('role_id', '2')->latest()->get();
        return view('admin.customer.index', compact('title', 'customers'));
    }
}
