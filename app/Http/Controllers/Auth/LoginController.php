<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;


    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        return $input = $request->all();

        $this->validate($request, [
            'phone' => 'required',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('phone' => $input['phone'], 'password' => $input['password']))){
            if(auth()->user()->role_id == 1 ) {
                Toastr::success('Welcome to Admin Panel :-)','Success');
                return redirect()->route('admin.dashboard');
            }elseif(auth()->user()->role_id == 2 ) {
                Toastr::success('Welcome to your profile :-)','Success');
                return redirect()->route('customer.information');
            }else {
                $this->redirectTo = route('login');
            }
        }elseif(auth()->attempt(array('email' => $input['phone'], 'password' => $input['password']))){
            if(auth()->user()->role_id == 1 ) {
                Toastr::success('Welcome to Admin Panel :-)','Success');
                return redirect()->route('admin.dashboard');
            }elseif(auth()->user()->role_id == 2 ) {
                Toastr::success('Welcome to your profile :-)','Success');
                return redirect()->route('customer.information');
            }else {
                $this->redirectTo = route('login');
            }
        }else{
            Toastr::error('Credentials not match :(','Error');
            return redirect()->route('login');
        }

    }
}
