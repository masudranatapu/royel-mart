<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function reset_password(Request $request)
    {
        $title = "Guest Checkout";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';
        $search = '';
        return view('auth.passwords.email', compact('title', 'lan', 'p_cat_id','search'));
    }

    public function otp_send_for_password_reset(Request $request)
    {
        $phone = $request->phone;
        $user = User::where('phone', $phone)->first();

        if($user){
            $otpCode = rand(11111, 99999);
            $request->session()->put('otp_code', $otpCode);
            $request->session()->put('recoveryPhone', $request->input('phone'));

            $otp = "Your Royalmart-bd.com password reset OTP code id ". $otpCode . ". Do not share your pin to others.";
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
                return redirect()->route('otp-send-for-password-reset');
            }else {
                session()->flush();

                Toastr::error('Something is problem, please try again :(','Error');
                return redirect()->back();
            }
        }else{
            Toastr::error('You have no account.', 'Error');
            return redirect()->back();
        }

    }

    public function otp_send_for_reset(Request $request)
    {
        if ($request->session()->get('otp_code')) {
            $title = "Check OTP";
            $lan = $request->session()->get('lan');
            $p_cat_id = '';
            $search = '';
            $recoveryPhone = $request->session()->get('recoveryPhone');
            return view('auth.passwords.recovery-otp-check', compact('title', 'lan', 'p_cat_id','search','recoveryPhone'));
        } else {
            return redirect()->back();
        }
    }

    public function otp_resend_for_reset(Request $request)
    {
        $otpCode = rand(11111, 99999);
        $request->session()->put('otp_code', $otpCode);

        $otp = "Your Royalmart-bd.com Register OTP code id ". $otpCode . ". Do not share your pin to others.";
        $phoneNumber = $request->session()->get('recoveryPhone');
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

    public function recovery_otp_check(Request $request)
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

        $title = "Recovery password";
        $lan = $request->session()->get('lan');
        $p_cat_id = '';

        $getOtpCode = $code_one.''.$code_tow.''.$code_three.''.$code_four.''.$code_five;
        $otpCode = $request->session()->get('otp_code');
        $recoveryPhone = $request->session()->get('recoveryPhone');

        if($getOtpCode != $otpCode){
            Toastr::warning('OTP code not  matched. Please give right otp code for next step :-)','success');
            return redirect()->back();
        }else {
            Toastr::success('Now checkout your cart products:-)','success');
            $search = '';
            return view('auth.passwords.reset', compact('title', 'lan', 'p_cat_id','recoveryPhone','search'));
        }
    }

    public function password_recovery_done(Request $request)
    {
        $password = $request->password;
        $recoveryPhone = $request->session()->get('recoveryPhone');

        $user = User::where('phone', $recoveryPhone)->first();

        if($user){
            $check_user = User::find($user->id);
            $check_user->password = Hash::make($password);
            $check_user->save();

            return redirect()->route('login');
        }else{
            Toastr::error('You have no account.', 'Error');
            return redirect()->back();
        }
    }

}
