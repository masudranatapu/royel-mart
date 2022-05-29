<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $website = Website::latest()->first();
        $title = "Website Update";
        return view('admin.website.index', compact('title', 'website'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function addRemoveRow(Request $request)
    {
        //
        $website_row = $request->id;

        $data = NULL;
        $data .=    '<tr id="website_remove_row_'.$website_row.'">';
        $data .=        '<th>
                            <input type="text" name="icon[]" class="form-control" placeholder="Icon form frontawsome">
                        </th>';
        $data .=        '<td>
                            <input type="text" name="link[]" class="form-control" placeholder="Website link like https://... ">
                        </td>';
        $data .=        '<td class="text-center">
                            <button type="button" onclick="websiteRemovieRow(this)" id="'.$website_row.'" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>';
        $data .=    '</tr>';
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        // for logo
        $logo = $request->file('logo');
        $slug_1 = 'logo';
        if (isset($logo)) {
            // make unique name for image
            $logo_image = $slug_1.'-'.uniqid().'.'.$logo->getClientOriginalExtension();
            $upload_path = 'media/logo/';
            $logo_image_url = $upload_path.$logo_image;
            $website = Website::findOrFail($id);
            if (file_exists($website->logo)) {
                unlink($website->logo);
            }
            $logo->move($upload_path, $logo_image);
        } else {
            $website = Website::findOrFail($id);
            $logo_image_url = $website->logo;
        }

        // for favcion
        $favicon = $request->file('favicon');
        $slug_2 = 'favicon';
        if (isset($favicon)) {
            //make unique name for favicon
            $fav_icon = $slug_2.'-'.uniqid().'.'.$favicon->getClientOriginalExtension();
            $upload_path = 'media/logo/';
            $fav_icon_url = $upload_path.$fav_icon;
            $website = Website::findOrFail($id);
            if (file_exists($website->favicon)) {
                unlink($website->favicon);
            }
            $favicon->move($upload_path, $fav_icon);
        } else {
            $website = Website::findOrFail($id);
            $fav_icon_url = $website->favicon;
        }
        // for footer logo
        $footerLogo = $request->file('footer_logo');
        $slug_3 = "footer";
        if(isset($footerLogo)) {
            //make unique name for footer logo
            $foot_log = $slug_3.'-'.uniqid().'.'.$footerLogo->getClientOriginalExtension();
            $upload_path = 'media/logo/';
            $foot_log_url = $upload_path.$foot_log;
            $website = Website::findOrFail($id);
            if(file_exists($website->footer_logo)) {
                unlink($website->footer_logo);
            }
            $footerLogo -> move($upload_path, $foot_log);
        }else {
            $website = Website::findOrFail($id);
            $foot_log_url = $website->footer_logo;
        }

        if($request->icon) {
            $icon = trim(implode('|', $request->icon), '|');
        }else {
            $icon = NULL;
        }

        if($request->link) {
            $link = trim(implode('|', $request->link), '|');
        }else {
            $link = NULL;
        }

        $website = Website::find($id);
        $website->name = $request->name;
        $website->email = $request->email;
        $website->logo = $logo_image_url;
        $website->favicon = $fav_icon_url;
        $website->footer_logo = $foot_log_url;
        $website->phone = $request->phone;
        $website->another_phone_one = $request->another_phone_one;
        $website->another_phone_two = $request->another_phone_two;
        $website->another_phone_three = $request->another_phone_three;
        $website->another_phone_four = $request->another_phone_four;
        $website->another_phone_five = $request->another_phone_five;
        $website->fax = $request->fax;
        $website->tel = $request->tel;
        $website->description = $request->description;
        $website->meta_keyword = $request->meta_keyword;
        $website->meta_decription = $request->meta_decription;
        $website->address = $request->address;
        $website->google_map = $request->google_map;
        $website->facebook_pixel = $request->facebook_pixel;
        $website->twitter_api = $request->twitter_api;
        $website->google_analytics = $request->google_analytics;
        $website->schema = $request->schema;
        $website->canonical_link = $request->canonical_link;
        $website->icon = $icon;
        $website->link = $link;
        $website->save();

        Toastr::success('Website updated successfully :-)','Success');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
