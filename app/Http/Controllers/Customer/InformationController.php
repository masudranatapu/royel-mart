<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $title = "Customer Profile";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $shipping_information = ShippingAddress::where('user_id', Auth::user()->id)->latest()->first();
        return view('customer.index', compact('title', 'lan', 'p_cat_id','shipping_information'));
    }
    public function passChangeView(Request $request)
    {
        $title = "Change Password";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        return view('customer.password', compact('title', 'lan', 'p_cat_id'));
    }
    public function updatePass(Request $request, $id)
    {
        $validateData = $request->validate([
            'oldpassword'=>'required',
            'password'=>'required|confirmed',
        ]);

        $hasPassword = User::findOrFail($id)->password;

        if(Hash::check($request->oldpassword, $hasPassword)) {
            $userData = User::findOrFail($id);
            $userData->password = Hash::make($request->password);
            $userData->save();
            Auth::logout();

            Toastr::success('Your Password update successfully :-)','Success');
            return redirect()->route('login');

        }else {
            Toastr::warning('Something is worng. Please try agian :-)','warning');
            return redirect()->back();
        }
    }

    public function update_personal_information(Request $request)
    {
        $validateData = $request->validate([
            'name'=>'required',
            'address'=>'required',
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->save();

        Toastr::success('Your information update successfully :-)','Success');
        return redirect()->back();
    }

















}
