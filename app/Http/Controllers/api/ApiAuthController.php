<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\BillingAddress;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PasswordRequest;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductOrderColor;
use App\Models\ProductOrderColorSize;
use App\Models\ShippingAddress;
use App\Models\ShippingMethod;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;


class ApiAuthController extends Controller
{

    public function details(Request $request)
    {

        $user = $request->user();
        $myRe = ['status' => true, 'user' => $user];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);


    }

    public function phoneVerifyForsignUp(Request $request)
    {


        $status = false;
        $validator = Validator()->make($request->all(), [

            'name' => 'required',
            'phone' => 'required|regex:/[0-9]{10}/|min:11|max:11',
            'password' => 'required',
        ], [
            'phone.unique' => 'User already exists with this phone number!'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $user = User::where('phone', $request->phone);

        // Check Condition Mobile No. Found or Not
        if (!$user->exists()) {

            $new_sent = 0;
            $hasMsg = Message::latest()->first();
            $msg_id = $hasMsg->id;
            $msg_stock = $hasMsg->message;
            $msg_sent = $hasMsg->sent;
            $new_sent = $new_sent + 1;
            $total_sent = $msg_sent + $new_sent;

            if ($msg_stock < $total_sent) {
                $myRe = ['status' => false, 'message' => ['OTP has error!']];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            } else {

                $otp_code = mt_rand(1111, 9999);


                $url = "http://66.45.237.70/api.php";
                $number = $request->phone;
                $text = "Your www.royalmart-bd.com OTP code is " . $otp_code;
                $data = array(
                    'username' => "proit24",
                    'password' => "MHYRNTF5",
                    'number' => $number,
                    'message' => $text
                );

                $ch = curl_init(); // Initialize cURL
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $smsresult = curl_exec($ch);
                $p = explode("|", $smsresult);
                $sendstatus = $p[0];

                $data = array();
                $data['sent'] = $total_sent;
                $msg_sent_up = DB::table('messages')->where('id', $msg_id)->update($data);

                $ref_id = uniqid();
                DB::table('otps')->updateOrInsert(
                    ['phone' => $number],
                    [
                        'otp' => $otp_code,
                        "ref_id" => $ref_id,
                        "updated_at" => Carbon::now()
                    ]
                );

                //$request->session()->put('number', $request->input('phone'));
                $myRe = ['status' => true, 'message' => ['OTP code sent to phone number'], "ref_id" => $ref_id];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
                //return redirect()->route('verify-phone')->with('success', 'Password reset code sent successfully!');
            }
        } else {
            $myRe = ['status' => false, 'message' => ['User with this phone number Already Exits']];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

    }

    public function signUp(Request $request)
    {

        $status = false;
        $validator = Validator::make($request->all(), [

            'otp' => 'required',
            'ref_id' => 'required',
            'name' => 'required',

            'phone' => 'required|unique:users|max:11|min:11',
            'password' => 'required',
        ], [
            'phone.unique' => 'User already exists with this phone number!'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $otp_details = DB::table('otps')->where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('ref_id', $request->ref_id)
            ->first();

        Log::channel('my')->info('otp_details : ' . json_encode($otp_details));

        if ($otp_details != null) {
            if (Carbon::now()->diffInMinutes($otp_details->updated_at) < 3) {

                $status = true;
                $user = new User();
                $user->name = $request->name;

                //$user->gender = $request->gender;
                $user->phone = $request->phone;
                $user->password = Hash::make($request->password);
                $user->save();

                $accessToken = $user->createToken('authToken')->accessToken;

                $myRe = ['status' => $status, 'message' => ["otp matched"], 'token' => $accessToken];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);


            } else {
                $message = ['OTP Not Match or Expired'];
                $myRe = ['status' => false, 'message' => $message];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            }

        } else {
            $message = ['OTP not match'];
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


    }

    public function signIn(Request $request)
    {

        $status = false;
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $user = User::where('phone', $request->phone);

        if ($user->exists()) {
            if (Auth::attempt(['phone' => request('phone'), 'password' => request('password')])) {

                //$accessToken = $user->createToken('authToken')->accessToken;
                $accessToken = auth()->user()->createToken('authToken')->accessToken;

                $myRe = ['status' => true, 'message' => ['Login Success!'], 'user' => $user->get(['name', 'phone', 'role_id'])->first(), 'token' => $accessToken];

                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            } else {
                $myRe = ['status' => false, 'message' => ['Credentials not match!']];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            }
        } else {
            $myRe = ['status' => false, 'message' => ['No user exists with this phone!']];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


    }

    public function signOut(Request $request)
    {


        auth()->user()->token()->revoke();

        $myRe = ['status' => true, 'message' => ['SignOut Successfully'],];

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);


    }


    public function profileDetails(Request $request)
    {
        $user = User::find($request->user()->id);

        if ($user != null) {
            $myRe = ['status' => true, 'user' => $user];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        } else {
            $myRe = ['status' => false, 'message' => ["Please Sign In"]];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }
    }

    public function updateProfile(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'user_id' => 'required',
            'name' => 'required',
            'email' => 'nullable',
            'image' => 'nullable|mimes:jpg,png,jpeg,svg',
            'phone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

        $users = User::all();

        foreach ($users as $user) {
            if ($user->phone == $request->phone && $user->id != $request->user_id) {
                $myRe = ['status' => false, 'message' => 'Sorry! This phone number already taken!'];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            }
        }


        $status = true;
        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . rand() . '.' . $image->getClientOriginalExtension();
            $uploadPath = 'upload/user/';
            Image::make($image)->save(public_path('upload/user/') . $imageName);
            $user->image = $uploadPath . $imageName;
        }
        $user->email = $request->email;
        $user->save();
        $myRe = ['status' => $status, 'user' => $user];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function updateProfileImage(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [
            'user_id' => 'required',
            'image' => 'nullable',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;

        $user = User::find($request->user_id);
        $uploadPath = 'upload/user/';
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = time() . rand() . '.' . $image_type;
        $file = public_path('upload/user/') . $fileName;

        file_put_contents($file, $image_base64);

        $user->image = $uploadPath . $fileName;
        $user->save();

        $myRe = ['status' => $status, 'message' => 'Image updated!', 'image_url' => $user->image];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);


    }


    public function saveShippingAddress(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [


            'shipping_name' => 'required',
            'shipping_phone' => 'required',
            'shipping_division_id' => 'required',
            'shipping_district_id' => 'required',
            'shipping_address' => 'required',
            'shipping_to' => 'nullable',

        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;
        $shippingDetails = new ShippingAddress();
        $shippingDetails->shipping_name = $request->shipping_name;
        $shippingDetails->shipping_phone = $request->shipping_phone;
        $shippingDetails->shipping_division_id = $request->shipping_division_id;
        $shippingDetails->shipping_district_id = $request->shipping_district_id;
        $shippingDetails->shipping_address = $request->shipping_address;
        $shippingDetails->shipping_to = $request->shipping_to;
        $shippingDetails->user_id = $request->user()->id;
        $shippingDetails->save();

        $myRe = ['status' => $status, 'message' => ['Request sent successfully!'], 'id' => $shippingDetails->id];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function shippingAddresses(Request $request)
    {


        $status = true;
        $addresses = DB::table('shipping_addresses')
            ->select('shipping_addresses.*', 'divisions.name as division', 'districts.name as district', 'districts.charge')
            ->where('user_id', $request->user()->id)
            ->leftjoin('divisions', 'divisions.id', 'shipping_addresses.shipping_division_id')
            ->leftjoin('districts', 'districts.id', 'shipping_addresses.shipping_district_id')
            ->orderBy('shipping_addresses.id', 'DESC')->get();
        $myRe = ['status' => $status, 'addresses' => $addresses];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function billingAddresses(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;
        $addresses = BillingAddress::where('user_id', $request->user_id)->orderBy('name', 'ASC')->get();
        $myRe = ['status' => $status, 'addresses' => $addresses];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function shippingMethods(Request $request)
    {

        $methods = ShippingMethod::all();
        $myRe = ['status' => true, 'methods' => $methods];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function saveBillingAddress(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [


            'name' => 'required',
            'country' => 'required',
            'city' => 'required',
            'full_address' => 'required',
            'post_code' => 'nullable',
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;
        $billingDetails = new BillingAddress();
        $billingDetails->billing_name = $request->name;

        $billingDetails->country = $request->country;
        $billingDetails->city = $request->city;
        $billingDetails->full_address = $request->full_address;
        $billingDetails->post_code = $request->post_code;
        $billingDetails->phone_number = $request->phone_number;
        $billingDetails->user_id = $request->user_id;
        $billingDetails->save();

        $myRe = ['status' => $status, 'message' => 'Request sent successfully!', 'id' => $billingDetails->id];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }


    public function deleteShippingAddress(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'shipping_id' => 'required',

        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $shippingDetails = ShippingAddress::find($request->shipping_id);
        if ($shippingDetails == null) {
            $myRe = ['status' => false, 'message' => ["Please Sign In"]];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);

        }
        if ($shippingDetails->user_id == $request->user()->id) {
            $shippingDetails->delete();

            $myRe = ['status' => true, 'message' => ['Address Deleted Successfully']];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        } else {
            $myRe = ['status' => false, 'message' => ["Please Sign In"]];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);

        }


    }


    public function changePassword(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $user = User::find($request->user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            if ($request->old_password != $request->new_password) {
                if ($request->new_password == $request->confirm_password) {
                    $user->password = Hash::make($request->new_password);
                    $user->save();
                    $myRe = ['status' => true, 'message' => ['Password changed successfully!']];
                    log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                    return response()->json($myRe);
                } else {
                    $myRe = ['status' => false, 'message' => ['Confirm password not matched with new password!']];
                    log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                    return response()->json($myRe);
                }
            } else {
                $myRe = ['status' => false, 'message' => ['New Password cannot be same as old password!']];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            }
        } else {
            $myRe = ['status' => false, 'message' => ['Old password not matched with stored password!']];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

    }

    public function placeOrderOld(Request $request)
    {

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . "\n");

        $status = false;
        $validator = Validator()->make($request->all(), [

            'order_note' => 'nullable',
            //'billing_address_id' => 'required',
            'shipping_address_id' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
            //'is_urgent' => 'required',
            'payment_method_id' => 'required',
            //'shipping_method_id' => 'required',
            'trx_id' => 'nullable',
            'sender_num' => 'nullable'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

        $shippingAddress = ShippingAddress::find($request->shipping_address_id);

        $billingDetails = new BillingAddress();
        $billingDetails->user_id = $request->user()->id;
        $billingDetails->billing_name = $shippingAddress->shipping_name;
        $billingDetails->billing_phone = $shippingAddress->shipping_phone;
        $billingDetails->billing_email = $shippingAddress->shipping_email;
        $billingDetails->billing_division_id = $shippingAddress->shipping_division_id;
        $billingDetails->billing_district_id = $shippingAddress->shipping_district_id;
        $billingDetails->billing_address = $shippingAddress->shipping_address;
        $billingDetails->save();


        $status = true;
        $order = new Order();

        $order->user_id = $request->User()->id;

        $order->shipping_to = $shippingAddress->shipping_to;
        $order->shipping_name = $shippingAddress->shipping_name;
        $order->shipping_phone = $shippingAddress->shipping_phone;
        $order->shipping_address = $shippingAddress->shipping_address;

        $order->voucher = $request->voucher;

        $order->shipping_amount = $request->shipping_amount;
        $order->sub_total = $request->sub_total;
        $order->discount = $request->discount;
        $order->total = $request->total;

        $order->is_urgent = 0;
        $order->payment_method_id = $request->payment_method_id;
        $order->shipping_method_id = $request->shipping_method_id;
        if ($request->payment_method_id == "4") {
            $trx_id = uniqid();

        } else {
            $trx_id = $request->trx_id;

        }
        $order->trx_id = $trx_id;
        $order->sender_num = $request->sender_num;
        $order->note = $request->order_note;
        $order->save();

        $product_list = json_decode($request->product_list);

        $total_cashback = 0;

        log::channel('my')->info($product_list);
        if (count($product_list) != 0) {
            for ($i = 0; $i < count($product_list); $i++) {

                $product_item = $product_list[$i];
                $orderDetails = new OrderProduct();
                $orderDetails->order_code = $order->order_code;
                $orderDetails->product_id = $product_item->id;


                $orderDetails->quantity = $product_item->quantity;
                $orderDetails->sale_price = $product_item->priceAfterCalculation;

                $product = Product::find($product_item->id);

                $product->quantity = ($product->quantity - $product_item->quantity);
                $product->save();

                if ($request->payment_method_id == 4) {
                    $orderDetails->cashback_per = 0;
                    $orderDetails->cashback = 0;
                    $total_cashback = 0;
                } else {
                    $orderDetails->cashback_per = $product->cashback_per;
                    $orderDetails->cashback = $product->cashback;
                    $total_cashback = ($total_cashback + $product->cashback);
                }

                $orderDetails->save();
                //}
            }
        }
        $order->t_cashback = $total_cashback;
        $order->save();

        $myRe = ['status' => true, 'trx_id' => $trx_id, 'message' => ['Order Placed successfully!']];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);


    }


    public function placeOrder(Request $request)
    {
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n");

        $validator = Validator()->make($request->all(), [

            'product_list' => 'required',
            'shipping_address_id' => 'required',
            'shipping_amount' => 'required',
            'discount' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
            //'is_urgent' => 'required',
            'payment_method' => 'required',
            //'shipping_method_id' => 'required',
            'trx_id' => 'nullable',
            'sender_num' => 'nullable',
            'order_note' => 'nullable',
        ]);


        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }
        // return $request;

        $check_shipping_address = ShippingAddress::find($request->shipping_address_id);

        $shipping_to = $check_shipping_address->shipping_to;
        $shipping_name = $check_shipping_address->shipping_name;
        $shipping_phone = $check_shipping_address->shipping_phone;
        $shipping_address = $check_shipping_address->shipping_address;

        // create order code
        $order_code = 'R' . mt_rand(111111, 999999);

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->order_code = $order_code;
        $order->sub_total = $request->sub_total;
        $order->shipping_amount = $request->shipping_amount;
        $order->discount = $request->discount;
        $order->total = $request->total;
        $order->due = $request->total;
        $order->payment_method = $request->payment_method;
        $order->payment_transaction_id = $request->payment_transaction_id;
        $order->shipping_to = $shipping_to;
        $order->shipping_name = $shipping_name;
        $order->shipping_phone = $shipping_phone;
        $order->shipping_address = $shipping_address;
        $order->voucher = $request->voucher_code;
        $order->note = $request->note;
        $order->pending_date = Carbon::now()->format('Y-m-d');
        $order->save();

        /*foreach($request->product_id as $key=>$product_id){
            $order_product = new OrderProduct();
            $order_product->order_code = $order_code;
            $order_product->product_id = $product_id;
            $order_product->sale_price = $request->sale_price[$key];
            $order_product->quantity = $request->quantity[$key];
            $order_product->save();

            if($request->color_id[$key]){
                $order_product_color = new ProductOrderColor();
                $order_product_color->order_code = $order_code;
                $order_product_color->product_id = $product_id;
                $order_product_color->color_id = $request->color_id[$key];
                $order_product_color->quantity = $request->quantity[$key];
                $order_product_color->save();

                if($request->size_id[$key]){
                    $order_product_color_size = new ProductOrderColorSize();
                    $order_product_color_size->order_code = $order_code;
                    $order_product_color_size->product_id = $product_id;
                    $order_product_color_size->color_id = $request->color_id[$key];
                    $order_product_color_size->size_id = $request->size_id[$key];
                    $order_product_color_size->quantity = $request->quantity[$key];
                    $order_product_color_size->save();
                }
            }
        }*/

        $product_list = json_decode($request->product_list);

        log::channel('my')->info($product_list);
        if (count($product_list) != 0) {
            for ($i = 0; $i < count($product_list); $i++) {

                $product_item = $product_list[$i];
                $orderDetails = new OrderProduct();
                $orderDetails->order_code = $order_code;
                $orderDetails->product_id = $product_item->id;
                $orderDetails->quantity = $product_item->quantity;
                $orderDetails->sale_price = $product_item->salePrice;
                $orderDetails->save();

                /*$product = Product::find($product_item->id);

                $product->quantity = ($product->quantity - $product_item->quantity);
                $product->save();*/

                if($product_item->selectedColor){
                    $order_product_color = new ProductOrderColor();
                    $order_product_color->order_code = $order_code;
                    $order_product_color->product_id = $product_item->id;
                    $order_product_color->color_id = $product_item->selectedColor;
                    $order_product_color->quantity = $product_item->quantity;
                    $order_product_color->save();

                    if($product_item->selectedSize){
                        $order_product_color_size = new ProductOrderColorSize();
                        $order_product_color_size->order_code = $order_code;
                        $order_product_color_size->product_id = $product_item->id;
                        $order_product_color_size->color_id = $product_item->selectedColor;
                        $order_product_color_size->size_id = $product_item->selectedSize;
                        $order_product_color_size->quantity = $product_item->quantity;
                        $order_product_color_size->save();
                    }
                }


                //}
            }
        }


        $otp = $request->shipping_name . " your Royalmart-bd.com order code is " . $order_code . " .Keep this order code for your product delivery";
        $phoneNumber = $request->shipping_phone;
        $messages = Message::latest()->first();
        $allmessages = $messages->message;
        $sentMessages = $messages->sent;

        // check message
        $smsUrl = "http://66.45.237.70/api.php";
        $data = [
            'username' => "proit24",
            'password' => "MHYRNTF5",
            'number' => "$phoneNumber",
            'message' => "$otp",
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

        //Toastr::success('Order successfully done :-)','Success');
        //return redirect()->route('customer.order');

        $myRe = ['status' => true, 'trx_id' => $order_code, 'message' => ['Order Placed successfully!']];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);
    }

    public function resetPass_Old(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;
        $user = User::where('phone', $request->phone);
        // Check Condition Mobile No. Found or Not
        if ($user->exists()) {
            if ($user->first()->status != 'active') {
                $myRe = ['status' => 'false', 'message' => 'This account is now deactivated! Please try later.'];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            } else {
                $passwordRequests = new PasswordRequest();
                $passwordRequests->phone = $request->phone;
                $passwordRequests->save();
                $myRe = ['status' => 'false', 'message' => 'Password reset request sent successfully! We will notify you soon!'];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            }
        } else {
            $myRe = ['status' => 'false', 'message' => 'User with this phone number not exists!'];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


    }

    public function resetPass(Request $request)
    {


        $status = false;
        $validator = Validator()->make($request->all(), [

            'phone' => 'required|regex:/[0-9]{10}/|min:11|max:11',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $user = User::where('phone', $request->phone);

        // Check Condition Mobile No. Found or Not
        if ($user->exists()) {
            if ($user->first()->status != 'active') {
                $myRe = ['status' => false, 'message' => ['This account is now deactivated! Please try later.']];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            } else {

                $new_sent = 0;
                $hasMsg = SendMessage::latest()->first();
                $msg_id = $hasMsg->id;
                $msg_stock = $hasMsg->msg_stock;
                $msg_sent = $hasMsg->msg_sent;
                $new_sent = $new_sent + 1;
                $total_sent = $msg_sent + $new_sent;

                if ($msg_stock < $total_sent) {
                    $myRe = ['status' => false, 'message' => ['OTP has error!']];
                    log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                    return response()->json($myRe);
                } else {

                    $otp_code = mt_rand(1111, 9999);


                    $url = "http://66.45.237.70/api.php";
                    $number = $request->phone;
                    $text = "Your www.easymarketing.com.bd OTP code is " . $otp_code;
                    $data = array(
                        'username' => "proit24",
                        'password' => "MHYRNTF5",
                        'number' => $number,
                        'message' => $text
                    );

                    $ch = curl_init(); // Initialize cURL
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $smsresult = curl_exec($ch);
                    $p = explode("|", $smsresult);
                    $sendstatus = $p[0];

                    $data = array();
                    $data['msg_sent'] = $total_sent;
                    $msg_sent_up = DB::table('send_messages')->where('id', $msg_id)->update($data);

                    $ref_id = uniqid();
                    DB::table('otps')->updateOrInsert(
                        ['phone' => $number],
                        [
                            'otp' => $otp_code,
                            "ref_id" => $ref_id,
                            "updated_at" => Carbon::now()
                        ]
                    );

                    //$request->session()->put('number', $request->input('phone'));
                    $myRe = ['status' => true, 'message' => ['OTP code sent to phone number'], "ref_id" => $ref_id];
                    log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                    return response()->json($myRe);
                    //return redirect()->route('verify-phone')->with('success', 'Password reset code sent successfully!');
                }
            }
        } else {
            $myRe = ['status' => false, 'message' => ['User with this phone number not exists!']];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

    }

    public function resetPasswordByOtp(Request $request)
    {


        $status = false;
        $validator = Validator()->make($request->all(), [

            'phone' => 'required',
            'ref_id' => 'required',
            'otp' => 'required',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $otp_details = DB::table('otps')
            ->where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('ref_id', $request->ref_id)
            ->first();

        Log::channel('my')->info('otp_details : ' . json_encode($otp_details));

        if ($otp_details != null) {
            if (Carbon::now()->diffInMinutes($otp_details->updated_at) < 3) {
                $data = array();
                $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
                $phone = $request->phone;

                $check = DB::table('users')->where('phone', $phone)->update($data);
                if ($check) {
                    $myRe = ['status' => true, 'message' => ['Password changed successfully!']];
                    log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                    return response()->json($myRe);
                } else {
                    $request->session()->put('number', $phone);
                    $myRe = ['status' => false, 'message' => ['Have some error!']];
                    log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                    return response()->json($myRe);
                }
            } else {
                $message = ['OTP Not Match or Expired'];
                $myRe = ['status' => false, 'message' => $message];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            }

        } else {
            $message = ['OTP not match'];
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


    }

    public function verifyOtp(Request $request)
    {

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n");

        $status = false;
        $validator = Validator()->make($request->all(), [

            'phone' => 'required',
            'otp' => 'required',
            'ref_id' => 'required',

        ]);
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n  1   \n\n");

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n  2  \n\n");
        $otp_details = DB::table('otps')
            ->where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('ref_id', $request->ref_id)
            ->first();

        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n  3  \n\n");
        Log::channel('my')->info('otp_details : ' . json_encode($otp_details));

        if ($otp_details != null) {
            if (Carbon::now()->diffInMinutes($otp_details->updated_at) < 3) {

                $myRe = ['status' => true, 'message' => ["otp matched"]];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);

            } else {
                $message = ['OTP Not Match or Expired'];
                $myRe = ['status' => false, 'message' => $message];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            }

        } else {
            $message = ['OTP not match'];
            $myRe = ['status' => false, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


    }

    public function placseOrderOne(Request $request)
    {

        $total_cashback = 0;
        if ($request->checkbox_new_acc) {

            $user = User::where('phone', $request->billing_phone_number)->exists();

            if ($user) {
                $myRe = ['status' => false, 'message' => 'There is already an account with this phone number! Please login first!'];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            }

            $user = new User();
            $user->name = $request->name;

            $user->phone = $request->billing_phone_number;
            $user->password = Hash::make($request->new_password);
            $user->save();

            $user_id = $user->id;

        }

        $billingDetails = new BillingAddress();
        $billingDetails->billing_name = $request->name;
        $billingDetails->country = $request->billing_country;
        $billingDetails->city = $request->billing_city;
        $billingDetails->full_address = $request->billing_full_address;
        $billingDetails->post_code = $request->billing_post_code;
        $billingDetails->phone_number = $request->billing_phone_number;
        $billingDetails->user_id = $user_id;
        $billingDetails->save();

        if ($request->name != null) {
            $shippingDetails = new ShippingAddress();
            $shippingDetails->shipping_name = $request->name;

            $shippingDetails->country = $request->shipping_country;
            $shippingDetails->city = $request->shipping_city;
            $shippingDetails->full_address = $request->shipping_full_address;
            $shippingDetails->post_code = $request->shipping_post_code;
            $shippingDetails->phone_number = $request->shipping_phone_number;
            $shippingDetails->user_id = $user_id;
            $shippingDetails->save();
        } else {
            $shippingDetails = new ShippingAddress();
            $shippingDetails->shipping_name = $request->name;

            $shippingDetails->country = $request->billing_country;
            $shippingDetails->city = $request->billing_city;
            $shippingDetails->full_address = $request->billing_full_address;
            $shippingDetails->post_code = $request->billing_post_code;
            $shippingDetails->phone_number = $request->billing_phone_number;
            $shippingDetails->user_id = $user_id;
            $shippingDetails->save();
        }

        $order = new Order();
        $order->order_note = $request->order_note;
        $order->user_id = $user_id;
        $order->billing_id = $billingDetails->id;
        $order->shipping_id = $shippingDetails->id;
        $order->sub_total = $request->sub_total;
        $order->total = $request->total;
        $order->is_urgent = $request->is_urgent;
        $order->payment_method_id = $request->payment_method_id;
        $order->shipping_method_id = $request->shipping_method_id;
        if ($request->payment_method_id == "4") {
            $trx_id = uniqid();

        } else {
            $trx_id = $request->trx_id;

        }
        $order->trx_id = $trx_id;
        $order->sender_num = $request->sender_num;
        $order->save();

        if (count($request->product_id) != 0) {
            for ($i = 0; $i < count($request->product_id); $i++) {
                if ($request->product_id[$i] != '' && $request->quantity[$i] != '' && $request->sale_price[$i] != '') {
                    $orderDetails = new OrderProduct();
                    $orderDetails->order_code = $order->order_code;
                    $orderDetails->product_id = $request->product_id[$i];

                    $orderDetails->quantity = $request->quantity[$i];
                    $orderDetails->sale_price = $request->sale_price[$i];


                    $product = Product::where('id', $request->product_id[$i])->first();
                    /*foreach ($products as $product) {
                        $product->quantity = ($product->quantity - $request->quantity[$i]);
                        $product->save();
                    }*/
                    if ($product->id) {
                        $product->quantity = ($product->quantity - $request->quantity[$i]);
                        if ($request->payment_method_id == 4) {
                            $orderDetails->cashback_per = 0;
                            $orderDetails->cashback = 0;
                            $total_cashback = 0;
                        } else {
                            $orderDetails->cashback_per = $product->cashback_per;
                            $orderDetails->cashback = $product->cashback;
                            $total_cashback = ($total_cashback + $product->cashback);
                        }

                        //$product->save();
                    }
                    $orderDetails->save();
                }
            }
        }
        $order->t_cashback = $total_cashback;
        $order->save();

        $myRe = ['status' => true, 'trx_id' => $trx_id, 'message' => 'Order Placed successfully!'];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);
    }

    public function placseOrderTwo(Request $request)
    {

        $total_cashback = 0;

        $this->validate($request, [
            'phone' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if ($user == '') {
            $myRe = ['status' => false, 'message' => 'User with this phone number not exists!'];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

        if (Hash::check($request->password, $user->password)) {

            if ($user->status != 'active') {
                $myRe = ['status' => false, 'message' => 'This account is now deactivated! Please try later!'];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            } else {
                $user_id = $user->id;
            }

        } else {
            $myRe = ['status' => false, 'message' => 'Given phone or password not match with our records!'];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

        $billingDetails = new BillingAddress();
        $billingDetails->billing_name = $request->name;

        $billingDetails->country = $request->billing_country;
        $billingDetails->city = $request->billing_city;
        $billingDetails->full_address = $request->billing_full_address;
        $billingDetails->post_code = $request->billing_post_code;
        $billingDetails->phone_number = $request->billing_phone_number;
        $billingDetails->user_id = $user_id;
        $billingDetails->save();

        if ($request->name != null) {
            $shippingDetails = new ShippingAddress();
            $shippingDetails->shipping_name = $request->name;

            $shippingDetails->country = $request->shipping_country;
            $shippingDetails->city = $request->shipping_city;
            $shippingDetails->full_address = $request->shipping_full_address;
            $shippingDetails->post_code = $request->shipping_post_code;
            $shippingDetails->phone_number = $request->shipping_phone_number;
            $shippingDetails->user_id = $user_id;
            $shippingDetails->save();
        } else {
            $shippingDetails = new ShippingAddress();
            $shippingDetails->shipping_name = $request->name;
            $shippingDetails->country = $request->billing_country;
            $shippingDetails->city = $request->billing_city;
            $shippingDetails->full_address = $request->billing_full_address;
            $shippingDetails->post_code = $request->billing_post_code;
            $shippingDetails->phone_number = $request->billing_phone_number;
            $shippingDetails->user_id = $user_id;
            $shippingDetails->save();
        }

        $order = new Order();
        $order->order_note = $request->order_note;
        $order->user_id = $user_id;
        $order->billing_id = $billingDetails->id;
        $order->shipping_id = $shippingDetails->id;
        $order->sub_total = $request->sub_total;
        $order->total = $request->total;
        $order->is_urgent = $request->is_urgent;
        $order->payment_method_id = $request->payment_method_id;
        $order->shipping_method_id = $request->shipping_method_id;


        if ($request->payment_method_id == "4") {
            $trx_id = uniqid();

        } else {
            $trx_id = $request->trx_id;

        }
        $order->trx_id = $trx_id;

        $order->sender_num = $request->sender_num;
        $order->save();

        if (count($request->product_id) != 0) {
            for ($i = 0; $i < count($request->product_id); $i++) {
                if ($request->product_id[$i] != '' && $request->quantity[$i] != '' && $request->sale_price[$i] != '') {
                    $orderDetails = new OrderProduct();
                    $orderDetails->order_code = $order->order_code;
                    $orderDetails->product_id = $request->product_id[$i];

                    $orderDetails->quantity = $request->quantity[$i];
                    $orderDetails->sale_price = $request->sale_price[$i];


                    $product = Product::where('id', $request->product_id[$i])->first();
                    /*foreach ($products as $product) {
                        $product->quantity = ($product->quantity - $request->quantity[$i]);
                        $product->save();
                    }*/
                    if ($product->id) {
                        $product->quantity = ($product->quantity - $request->quantity[$i]);
                        if ($request->payment_method_id == 4) {
                            $orderDetails->cashback_per = 0;
                            $orderDetails->cashback = 0;
                            $total_cashback = 0;
                        } else {
                            $orderDetails->cashback_per = $product->cashback_per;
                            $orderDetails->cashback = $product->cashback;
                            $total_cashback = ($total_cashback + $product->cashback);
                        }
                        //$product->save();
                    }
                    $orderDetails->save();
                }
            }
        }
        $order->t_cashback = $total_cashback;
        $order->save();

        $myRe = ['status' => true, 'trx_id' => $trx_id, 'message' => 'Order Placed successfully!'];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);
    }

    public function placseOrderThree(Request $request)
    {


        $total_cashback = 0;

        if ($request->is_different_shipping == 0) {

            $billingDetails = BillingAddress::find($request->billing_id);

            $shippingDetails = new ShippingAddress();
            $shippingDetails->shipping_name = $billingDetails->billing_name;
            $shippingDetails->country = $billingDetails->country;
            $shippingDetails->city = $billingDetails->city;
            $shippingDetails->full_address = $billingDetails->full_address;
            $shippingDetails->post_code = $billingDetails->post_code;
            $shippingDetails->phone_number = $billingDetails->phone_number;
            $shippingDetails->user_id = $request->user_id;
            $shippingDetails->save();

            $shipping_id = $shippingDetails->id;

        } else {

            $shipping_id = $request->shipping_id;

        }

        $order = new Order();
        $order->order_note = $request->order_note;
        $order->user_id = $request->user_id;
        $order->billing_id = $request->billing_id;
        $order->shipping_id = $shipping_id;
        $order->sub_total = $request->sub_total;
        $order->total = $request->total;
        $order->is_urgent = $request->is_urgent;
        $order->payment_method_id = $request->payment_method_id;
        $order->shipping_method_id = $request->shipping_method_id;
        if ($request->payment_method_id == "4") {
            $trx_id = uniqid();

        } else {
            $trx_id = $request->trx_id;

        }
        $order->trx_id = $trx_id;
        $order->sender_num = $request->sender_num;
        $order->save();


        if (count($request->product_id) != 0) {
            for ($i = 0; $i < count($request->product_id); $i++) {
                if ($request->product_id[$i] != '' && $request->quantity[$i] != '' && $request->sale_price[$i] != '') {
                    $orderDetails = new OrderProduct();
                    $orderDetails->order_code = $order->order_code;
                    $orderDetails->product_id = $request->product_id[$i];

                    $orderDetails->quantity = $request->quantity[$i];
                    $orderDetails->sale_price = $request->sale_price[$i];


                    $product = Product::where('id', $request->product_id[$i])->first();
                    /*foreach ($products as $product) {
                        $product->quantity = ($product->quantity - $request->quantity[$i]);
                        $product->save();
                    }*/
                    if ($product->id) {
                        $product->quantity = ($product->quantity - $request->quantity[$i]);
                        if ($request->payment_method_id == 4) {
                            $orderDetails->cashback_per = 0;
                            $orderDetails->cashback = 0;
                            $total_cashback = 0;
                        } else {
                            $orderDetails->cashback_per = $product->cashback_per;
                            $orderDetails->cashback = $product->cashback;
                            $total_cashback = ($total_cashback + $product->cashback);
                        }
                        //$product->save();
                    }

                    $orderDetails->save();
                }

            }
        }
        $order->t_cashback = $total_cashback;
        $order->save();


        $myRe = ['status' => true, 'trx_id' => $trx_id, 'message' => 'Order Placed successfully!'];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);
    }

    public function orderHistory(Request $request)
    {

        $status = true;
        $orders = DB::table('orders')
            ->select('orders.*')
            ->where('user_id', $request->user()->id)
            //->leftjoin('payment_methods', 'payment_methods.id', 'payment_method_id')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);
        $myRe = ['status' => $status, 'orders' => $orders];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function eWalletBalance(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;
        $userBalance = User::select('balance')->where('id', $request->user_id)->first();
        $myRe = ['status' => $status, 'user_balance' => $userBalance];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function orderDetails(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'order_code' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;
        $orderDetails = \DB::table('order_products')

            ->select('products.name', 'products.thumbnail', 'order_products.*')
            //->select('products.name', 'products.thumbnail', 'order_products.*','product_order_colors.color_id','colors.name as color_name','colors.code as color_code')
            //->select('products.name', 'products.thumbnail', 'order_products.*','product_order_colors.color_id','colors.name as color_name','colors.code as color_code','product_order_color_sizes.size_id','sizes.name as size_name')
            //->select('products.name', 'products.thumbnail', 'order_products.*','product_order_colors.id as color_id','product_order_color_sizes.id as size_id')
            //->select('products.id','products.name', 'products.thumbnail', 'order_products.*')
            ->join('products', 'products.id', 'order_products.product_id')
            //->leftjoin('product_order_colors','product_order_colors.order_code','order_products.order_code' )
            /*->leftjoin('product_order_colors', function ($leftjoin) use ($request) {
                $leftjoin
                    //->on('product_order_colors.order_code', '=', 'order_products.order_code');
                ->on('product_order_colors.product_id', '=', 'order_products.product_id')
                    ->where('product_order_colors.order_code',  $request->order_code);
                //->where('product_order_colors.product_id', '=', 'products.id');

                    //$leftjoin->where('product_order_colors.product_id', '=', 'order_products.product_id');
            })*/
            //->leftjoin('colors','colors.id','product_order_colors.color_id')

            /*->leftjoin('product_order_color_sizes', function ($leftjoin) {
                $leftjoin->on('product_order_color_sizes.order_code', '=', 'order_products.order_code')
                    ->on('product_order_color_sizes.product_id', '=', 'products.id')
                    ->on('product_order_color_sizes.color_id', '=', 'product_order_colors.color_id');
                //$leftjoin->where('product_order_colors.product_id', '=', 'order_products.product_id');
            })
            ->leftjoin('sizes','sizes.id','product_order_color_sizes.size_id')*/

            /*->leftjoin('product_order_color_sizes', function ($leftjoin) {
                $leftjoin->on('product_order_color_sizes.order_code', '=', 'order_products.order_code')
                    ->where('product_order_color_sizes.product_id', '=', 'products.id')
                    ->where('product_order_color_sizes.color_id', '=', 'product_order_colors.id');
            })*/
            //->leftjoin('product_order_color_sizes', 'product_order_color_sizes.order_code', 'product_order_color_sizes.order_code')
            ->where('order_products.order_code', $request->order_code)
            ->get();
        //->paginate(15);

        //$order = Order::find($request->order_code);

        $order = DB::table('orders')
            ->select('orders.*')
            /*->leftJoin('shipping_details','shipping_details.id','orders.shipping_id')
            ->leftJoin('billing_details','billing_details.id','orders.billing_id')
            ->leftJoin('shipping_methods','shipping_methods.id','orders.shipping_method_id')
            ->leftJoin('payment_methods','payment_methods.id','orders.payment_method_id')*/
            ->where('orders.order_code', $request->order_code)
            ->where('orders.user_id', $request->user()->id)
            ->first();


        /*$shipping_details = DB::table('shipping_details')
            ->select('shipping_details.*', 'districts.dis_name', 'areas.area_name')
            ->leftjoin('districts', 'districts.id', 'shipping_details.country')
            ->leftjoin('areas', 'areas.id', 'shipping_details.city')
            ->where('shipping_details.id', $order->shipping_id)
            ->first();*/
        /*$billing_details = DB::table('billing_details')
            ->select('billing_details.*', 'districts.dis_name', 'areas.area_name')
            ->leftjoin('districts', 'districts.id', 'billing_details.country')
            ->leftjoin('areas', 'areas.id', 'billing_details.city')
            ->where('billing_details.id', $order->billing_id)
            ->first();*/
        //$shipping_methods = DB::table('shipping_methods')->where('id', $order->shipping_method_id)->first();
        //$payment_methods = DB::table('payment_methods')->where('id', $order->payment_method_id)->first();
        //$shippingAmount = $order->shippingMethod->amount;
        //$myRe = [/*'status' => true,*/ 'orderDetails' => $orderDetails];
        $myRe = [
            'status' => $status,
            'order'=>$order,
            'product_list' => $orderDetails,
            //'shipping_details' => $shipping_details,
            //000'billing_details' => $billing_details,
            //'shipping_methods' => $shipping_methods,
            //'payment_methods' => $payment_methods,
        ];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function updateOrderSeen(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'order_code' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


        $status = true;
        $order = Order::find($request->order_code);
        $order->is_seen_cus = 1;
        $order->save();
        $myRe = ['status' => $status, 'message' => 'Seen updated!'];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }

    public function paymentMethods(Request $request)
    {
        $status = true;
        $methods = PaymentMethod::all();
        $myRe = ['status' => $status, 'methods' => $methods];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);
    }


    public function payment_success(Request $request)
    {


        $status = false;
        $validator = Validator()->make($request->all(), [

            'tran_id' => 'required',
            'amount' => 'required',
            'val_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }
        Log::channel("my")->info("payment_success 1");


        Log::channel("my")->info("payment_success 2");

        // return "Transaction is Successful";

        $tran_id = $request->tran_id;
        $amount = $request->amount;
        $currency = 'BDT';
        Log::channel("my")->info("payment_success 3");
        $sslc = new SslCommerzNotification();
        Log::channel("my")->info("payment_success 4");
        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('orders')
            ->where('trx_id', $tran_id)
            ->select('trx_id', 'status', 'total')->first();
        Log::channel("my")->info("payment_success 5");
        $order_detials_status = strtolower($order_detials->status);
        if ($order_detials_status == 'pending') {
            //$validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);
            $validation = true;
            //$validation = $sslc->verifyPayment($order_detials->trx_id, $order_detials->total, $currency,$request->all() );

            //$validation = $this->verifyPayment($order_detials,$request->all());
            Log::channel("my")->info("payment_success 6");


            if ($validation == TRUE) {
                Log::channel("my")->info("payment_success 6 validation == TRUE");
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('trx_id', $tran_id)
                    ->update(['status' => 'Processing']);

                $status = true;

                Log::channel('my')->info(json_encode(['status' => $status, 'tran_id' => $tran_id, 'msg' => 'Payment Done']));
                $myRe = ['status' => $status, 'tran_id' => $tran_id, 'msg' => 'Payment Done'];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            } else {
                Log::channel("my")->info("payment_success 6 validation == FALSE");
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('trx_id', $tran_id)
                    ->update(['status' => 'Failed']);

                $status = false;
                Log::channel('my')->info(json_encode(['status' => $status, 'tran_id' => $tran_id, 'message' => 'Payment Failed']));
                $myRe = ['status' => $status, 'tran_id' => $tran_id, 'message' => 'Payment Failed'];
                log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
                return response()->json($myRe);
            }
        } else if ($order_detials_status == 'processing' || $order_detials_status == 'complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            $status = true;
            Log::channel('my')->info(json_encode(['status' => $status, 'tran_id' => $tran_id, 'message' => 'Payment Done']));
            $myRe = ['status' => $status, 'tran_id' => $tran_id, 'message' => 'Payment Done'];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            //echo "Invalid Transaction";
            $status = false;
            Log::channel('my')->info(json_encode(['status' => $status, 'tran_id' => $tran_id, 'message' => 'Invalid Transaction']));
            $myRe = ['status' => $status, 'tran_id' => $tran_id, 'message' => 'Invalid Transaction'];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }


    }

    public function voucherCheck(Request $request)
    {

        $status = false;
        $validator = Validator()->make($request->all(), [

            'voucher_code' => 'required',
            'discount_amount' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $myRe = ['status' => $status, 'message' => $message];
            log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
            return response()->json($myRe);
        }

        $code = $request->voucher_code;
        $discount_amount = $request->discount_amount;
        $total = $request->total;

        $voucher = Voucher::where('code', $code)->first();

        $message = '';
        $use_time = 0;
        $real_code = 0;
        $code_applicable = false;
        $min_p_amount = 0;
        if ($voucher) {
            $use_time = $voucher->useable_time;
            $real_code = 1;
            $min_p_amount = $voucher->purchase_amount;

            if ($voucher->purchase_amount <= $total) {

                $user_id = Auth::user()->id;

                $used_voucher = Order::where('user_id', $user_id)->where('voucher', $code)->count();
                if ($used_voucher < $use_time) {
                    $code_applicable = true;
                    if ($voucher->discount_type == 'Solid') {
                        //$discount_amount += $voucher->discount;
                        $discount_amount = $voucher->discount;
                        $total -= $voucher->discount;
                    } else {
                        $voucher_dis = floor(($total * $voucher->discount) / 100);
                        //$discount_amount += $voucher_dis;
                        $discount_amount = $voucher_dis;
                        $total -= $voucher_dis;
                    }
                } else {
                    $message = 'Voucher usage limit over';
                }
            }
        } else {
            $message = 'Voucher Not Valid';
        }


        //return ['code_applicable'=>$code_applicable, 'min_p_amount'=>$min_p_amount, 'real_code'=>$real_code, 'use_time'=>$use_time, 'discount_amount'=>$discount_amount, 'total'=>$total];
        $myRe = ['status' => $code_applicable, 'message' => $message, 'min_p_amount' => $min_p_amount, 'real_code' => $real_code, 'use_time' => $use_time, 'discount_amount' => $discount_amount . "", 'total' => $total . ""];
        log::channel('my')->info("#####( " . __FUNCTION__ . " )##### in ApiController at " . __LINE__ . "----------------------------------------\n\n" . json_encode($request->input()) . "\n\n" . json_encode($myRe) . "\n");
        return response()->json($myRe);

    }


}
