<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        // $cats = Category::get();
        // foreach($cats as $cat){
        //     $category = Category::find($cat->id);
        //     $category->serial_number = NULL;
        //     $category->parent_serial = NULL;
        //     $category->child_serial = NULL;
        //     $category->save();
        // }

        $title = "Admin Dashboard";
        return view('admin.index', compact('title'));
    }

    public function profile()
    {
        $users = User::find(Auth::user()->id);
        $title = $users->name. ' ' .' Profile ';
        return view('admin.profile.index', compact('users', 'title'));
    }

    public function profileUpdate(Request $request, $id)
    {
        $validateData = $request->validate([
            'name'=>'required',
            'email'=>'required',
            'address'=>'required',
            'phone'=>'required',
        ]);
        $profile_image = $request->file('image');
        $slug_1 = "profile";
        if (isset($profile_image)) {
            //make unique name for profile image
            $profile_image_name = $slug_1.'-'.uniqid().'.'.$profile_image->getClientOriginalExtension();
            $upload_path = 'media/profile/';
            $profile_image_url = $upload_path.$profile_image_name;

            // unlink profile image
            $image = User::findOrFail($id);
            if ($image->image) {
                unlink($image->image);
            }

            $profile_image->move($upload_path, $profile_image_name);
        }else {
            $image = User::findOrFail($id);
            $profile_image_url = $image->image;
        }

        $coverImage = $request->file('cover_image');
        $slug_2 = "CoverImage";
        if (isset($coverImage)) {
            //make unique name for profile image
            $coverImage_name = $slug_2.'-'.uniqid().'.'.$coverImage->getClientOriginalExtension();
            $upload_path = 'media/profile/';
            $coverImage_url = $upload_path.$coverImage_name;

            // unlink profile image
            $image = User::findOrFail($id);
            if ($image->cover_image) {
                unlink($image->cover_image);
            }

            $coverImage->move($upload_path, $coverImage_name);
        }else {
            $image = User::findOrFail($id);
            $coverImage_url = $image->cover_image;
        }

        User::findOrFail($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $profile_image_url,
            'cover_image' => $coverImage_url,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now(),
        ]);
        Toastr::success('Your Profile Updated successfully :-)','Success');
        return redirect()->back();
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

            Toastr::success('Your password updated successfully :-)','Success');
            return redirect()->route('login');

        }else {
            Toastr::warning('something is worng. Please try agian :-)','warning');
            return redirect()->back();
        }
    }

    public function contactMassage()
    {
        $title = "Contact Massage";
        $contacts = Contact::latest()->get();
        return view('admin.contact.index', compact('title', 'contacts'));
    }
    public function contactDelete($id)
    {
        //
        Contact::findOrFail($id)->delete();
        Toastr::info('Contact successfully delete :-)','Success');
        return redirect()->back();
    }
}
