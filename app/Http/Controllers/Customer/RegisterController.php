<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Division;

class RegisterController extends Controller
{
    //
    public function customerRegister()
    {
        $title = "Customer Register";
        return view('auth.register', compact('title'));
    }
    public function customerRegisterConfirm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|max:20|unique:users',
        ]);
        // get name and phone in session
        $request->session()->put('name', $request->name);
        $request->session()->put('phone', $request->phone);
        $request->session()->put('email', $request->email);
        $request->session()->put('address', $request->address);

        $otpCode = rand(11111, 99999);
        $request->session()->put('otp_code', $otpCode);

        $otp = "Your Royalmart-bd.com Register OTP code id ". $otpCode . ". Do not share your pin to others.";
        $phoneNumber = $request->phone;
        $messages = Message::latest()->first();
        $allmessages = $messages->message;
        $sentMessages = $messages->sent;

        // check message
        if($allmessages != $sentMessages + 1){
            $smsUrl = "http://66.45.237.70/api.php";
            $data = [
                'username'=>"proit24",
                'password'=>"MHYRNTF5",
                'number'=> "$phoneNumber",
                'message'=> "$otp",
            ];

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $smsUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode('|', $smsresult);
            $sendstatus = $p[0];
            Message::where('id', $messages->id)->update([
                'sent' => $sentMessages + 1,
            ]);
            Toastr::success('OTP send on your phone number. Please put your OTP and go to next step :-)','success');
            return redirect()->route('customer.otp.send');
        }else {
            session()->flush();
            return redirect()->back();
        }
    }

    public function customerOtpSend(Request $request)
    {
        $title = "OTP Check";
        $getName = $request->session()->get('name');
        $getPhone = $request->session()->get('phone');

        if($request->session()->get('otp_code')){
            return view('auth.register-otp-check', compact('getName', 'getPhone', 'title'));
        }else{
            return redirect()->back();
        }
    }

    public function customerOtpCheck(Request $request)
    {
        $validatedData = $request->validate([
            'code_one' => 'required',
            'code_tow' => 'required',
            'code_three' => 'required',
            'code_four' => 'required',
            'code_five' => 'required',
        ]);
        
        $code_one = $request->code_one;
        $code_tow = $request->code_tow;
        $code_three = $request->code_three;
        $code_four = $request->code_four;
        $code_five = $request->code_five;
        
        $title = "Crate Your Account";

        $getOtpCode = $code_one.''.$code_tow.''.$code_three.''.$code_four.''.$code_five;
        $otpCode = $request->session()->get('otp_code');
        
        $getName = $request->session()->get('name');
        $getPhone = $request->session()->get('phone');
        $getEmail = $request->session()->get('email');
        $getAddress = $request->session()->get('address');

        if($getOtpCode != $otpCode){
            Toastr::warning('OTP code not  matched. Please give right otp code for next step :-)','success');
            return redirect()->back();
        }else {
            Toastr::info('Give password for create your account :-)','success');
            return view('auth.register-confirm', compact('title', 'getName', 'getPhone', 'getEmail', 'getAddress'));
        }
    }
    
    public function customerOtpResend(Request $request)
    {
        $otpCode = rand(11111, 99999);
        $request->session()->put('otp_code', $otpCode);
        
        $otp = "Your Royalmart-bd.com Register OTP code id ". $otpCode . ". Do not share your pin to others.";
        $phoneNumber = $request->session()->get('phone');
        $messages = Message::latest()->first();
        $allmessages = $messages->message;
        $sentMessages = $messages->sent;

        // check message
        if($allmessages != $sentMessages + 1){
            $smsUrl = "http://66.45.237.70/api.php";
            $data = [
                'username'=>"proit24",
                'password'=>"MHYRNTF5",
                'number'=> "$phoneNumber",
                'message'=> "$otp",
            ];

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $smsUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode('|', $smsresult);
            $sendstatus = $p[0];
            Message::where('id', $messages->id)->update([
                'sent' => $sentMessages + 1,
            ]);
            Toastr::success('OTP send on your phone number. Please put your OTP and go to next step :-)','success');
            return redirect()->back();
        }else {
            session()->flush();
            return redirect()->back();
        }
    }
    public function customerInfoSave(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $userlogin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
        ]);
        
        Auth::login($userlogin);
        
        Toastr::success('Welcome to your profile :-)','Success');
        return redirect()->route('customer.information');
    }
    public function customerGuestRegisterSend(Request $request)
    {
        
        $validatedData = $request->validate([
            'phone' => 'required|max:20|unique:users',
        ]);
        // get name and phone in session
        $request->session()->put('phone', $request->phone);

        $otpCode = rand(11111, 99999);
        $request->session()->put('otp_code', $otpCode);

        $otp = "Your Royalmart-bd.com Register OTP code id ". $otpCode . ". Do not share your pin to others.";
        $phoneNumber = $request->phone;
        $messages = Message::latest()->first();
        $allmessages = $messages->message;
        $sentMessages = $messages->sent;

        // check message
        if($allmessages != $sentMessages + 1){
            $smsUrl = "http://66.45.237.70/api.php";
            $data = [
                'username'=>"proit24",
                'password'=>"MHYRNTF5",
                'number'=> "$phoneNumber",
                'message'=> "$otp",
            ];

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $smsUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode('|', $smsresult);
            $sendstatus = $p[0];
            Message::where('id', $messages->id)->update([
                'sent' => $sentMessages + 1,
            ]);
            Toastr::success('OTP send on your phone number. Please put your OTP and go to next step :-)','success');
            return redirect()->route('customer.guestotp.send');
        }else {
            session()->flush();
            return redirect()->back();
        }
    }
    public function customerGuestOtpConfirm(Request $request)
    {
        $title = "Guest OTP Check";
        $getPhone = $request->session()->get('phone');

        if($request->session()->get('otp_code')){
            return view('customer.guest.checkotp', compact('title', 'getPhone'));
        }else{
            return redirect()->back();
        }
    }
    public function customerGuestOtpResend(Request $request)
    {
        //
        $validatedData = $request->validate([
            'phone' => 'required|max:20|unique:users',
        ]);
        // get name and phone in session
        $request->session()->put('phone', $request->phone);

        $otpCode = rand(11111, 99999);
        $request->session()->put('otp_code', $otpCode);

        $otp = "Your Royalmart-bd.com Register OTP code id ". $otpCode . ". Do not share your pin to others.";
        $phoneNumber = $request->phone;
        $messages = Message::latest()->first();
        $allmessages = $messages->message;
        $sentMessages = $messages->sent;

        // check message
        if($allmessages != $sentMessages + 1){
            $smsUrl = "http://66.45.237.70/api.php";
            $data = [
                'username'=>"proit24",
                'password'=>"MHYRNTF5",
                'number'=> "$phoneNumber",
                'message'=> "$otp",
            ];

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $smsUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode('|', $smsresult);
            $sendstatus = $p[0];
            Message::where('id', $messages->id)->update([
                'sent' => $sentMessages + 1,
            ]);
            Toastr::success('OTP send on your phone number. Please put your OTP and go to next step :-)','success');
            return redirect()->back();
        }else {
            session()->flush();
            return redirect()->back();
        }
    }
    public function customerGuestOtpCheck(Request $request)
    {
        $validatedData = $request->validate([
            'code_one' => 'required',
            'code_tow' => 'required',
            'code_three' => 'required',
            'code_four' => 'required',
            'code_five' => 'required',
        ]);
        
        $code_one = $request->code_one;
        $code_tow = $request->code_tow;
        $code_three = $request->code_three;
        $code_four = $request->code_four;
        $code_five = $request->code_five;
        
        $title = "Guest Checkout Product";

        $getOtpCode = $code_one.''.$code_tow.''.$code_three.''.$code_four.''.$code_five;
        $otpCode = $request->session()->get('otp_code');
        $getPhone = $request->session()->get('phone');

        if($getOtpCode != $otpCode){
            Toastr::warning('OTP code not  matched. Please give right otp code for next step :-)','success');
            return redirect()->back();
        }else {
            $divisions = Division::latest()->get();
            Toastr::success('Now checkout your cart products:-)','success');
            return view('customer.guest.guestcheckout', compact('title','getPhone', 'divisions'));
        }
    }
}
