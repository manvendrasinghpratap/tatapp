<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Static_pages;
use App\Cycle;
class PageController extends Controller
{
    //
     public function aboutus()
    {
        
        return view('home');
    }
    public function index($name)
    {
    	$pages = Static_pages::where('status','=', '1')->where('slugs','=',$name)->get();
        if($name=="terms-and-conditions")
        {
            $bannerimage='Velo_Diskussion.jpg';
            $bannerhead='<h1>'._i('Terms').' <br />'._i('&').' <br /> &nbsp; '._i('Conditions').'</h1>';
            $pagename = 'terms_and_condtitions';
        }
        elseif($name=="privacy-policy")
        {
            $bannerimage='Velo_Diskussion.jpg';
            $bannerhead='<h1>'._i('Privacy').' <br /> &nbsp; '._i('Policy').'</h1>';
            $pagename = 'privacy_policy';
        }
        elseif($name=="selling-tips")
        {
            $bannerimage='Velo_Diskussion.jpg';
            $bannerhead='<h1>'._i('Selling').' <br />&nbsp; '._i('Tips').'</h1>';
            $pagename = 'selling_tips';
        }
        elseif($name=="disclaimer")
        {
            $bannerimage='Velo_Diskussion.jpg';
            $bannerhead='<h1>'._i('Disclaimer').'</h1>';
            $pagename = 'disclaimer';
        }
        $bannerpera='';
	   //Get cycle data for slider.
        $cycle = Cycle::orderBy('name','asc')->get();
       
        return view($pagename,['bannerimage' => $bannerimage,'bannerhead' => $bannerhead,'bannerpera'=>$bannerpera,'pcontant'=>$pages,'cycle' => $cycle]);
    }
}
