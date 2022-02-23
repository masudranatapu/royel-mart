<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Client;
use Carbon\Carbon;

class HappyClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Happy Clients";
        $clients = Client::latest()->get();
        return view('admin.happyclient.index', compact('title', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required',
            'link' => 'required',
        ]);
        $client_image = $request->file('image');
        $slug = 'client';
        if(isset($client_image)) {
            $client_image_name = $slug.'-'.uniqid().'.'.$client_image->getClientOriginalExtension();
            $upload_path = 'media/client/';
            $client_image->move($upload_path, $client_image_name);
    
            $image_url = $upload_path.$client_image_name;
        }else {
            $image_url = NULL;
        }
        Client::insert([
            'name' => $request->name,
            'link' => $request->link,
            'image' => $image_url,
            'status'=> '1',
            'created_at' => Carbon::now(),
        ]);
        Toastr::success('Happy clients Successfully Save :-)','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clientActive($id)
    {
        //
        Client::findOrFail($id)->update(['status' => '1']);
        Toastr::success('Client Successfully active :-)','Success');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function clientInactive($id)
    {
        //
        Client::findOrFail($id)->update(['status' => '0']);
        Toastr::success('Client Successfully inactive :-)','Success');
        return redirect()->back();
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
        //
        $this->validate($request, [
            'name' => 'required',
        ]);

        $client_image = $request->file('image');
        $slug = 'client';
        if(isset($client_image)) {
            $client_image_name = $slug.'-'.uniqid().'.'.$client_image->getClientOriginalExtension();
            $upload_path = 'media/client/';
            $client_image->move($upload_path, $client_image_name);
            
            $old_client_image = Client::findOrFail($id);
            if($old_client_image->image){
                unlink($old_client_image->image);
            }

            $image_url = $upload_path.$client_image_name;
        
            Client::findOrFail($id)->update([
                'name' => $request->name,
                'link' => $request->link,
                'image' => $image_url,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::success('Happy Client Successfully Save :-)','Success');
            return redirect()->back();
        }else {
            Client::findOrFail($id)->update([
                'name' => $request->name,
                'link' => $request->link,
                'updated_at' => Carbon::now(),
            ]);
            Toastr::success('Happy Client Successfully Save Without Iamge :-)','Success');
            return redirect()->back();
        }
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
        $clients = Client::findOrFail($id);
        $delteImage = $clients->image;

        if(file_exists($delteImage)) {
            unlink($delteImage);
        }
        
        $clients->delete();
        Toastr::info('Client Successfully delete :-)','Success');
        return redirect()->back();
    }
}
