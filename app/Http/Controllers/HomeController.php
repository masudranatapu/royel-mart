<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\MissionVision;

class HomeController extends Controller
{
    public function welcome()
    {
        $title = "Home";
        $sliders = Slider::where('status', 1)->latest()->get();
        $banners = Banner::where('status', 1)->latest()->limit(3)->get();
        $missionvissions = MissionVision::where('status', 1)->latest()->get();
        return view('welcome', compact('title', 'sliders', 'banners', 'missionvissions'));
    }
    
}
