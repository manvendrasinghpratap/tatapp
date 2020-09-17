<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use URL;
use Illuminate\Support\Facades\Input;
use App\Repositories\MasterRepository;
use Route;
class RedirectIfAuthenticated
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @param  string|null  $guard
    * @return mixed
    */
     public function __construct(MasterRepository $master)
    {
        if(Auth::check())
        {
            $this->master=$master;
        }
        
    }
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::check()) {
            return redirect('/user/dashboard');
        }
        if (Auth::guard($guard)->check()) {
            
        $data=$request->input();
       
        if (Input::hasFile('commision_fee_doc'))
        {
            $data['commision_fee_doc']=$request->file('commision_fee_doc');
        }
        if (Input::hasFile('market_rules'))
        {
            $data['market_rules']=$request->file('market_rules');
        }
        $validator=$this->master->validation($data);

        if ($validator->fails()) {

            return redirect()->route('publish-bike-sale')
                                    ->withErrors($validator)
                                    ->withInput();
                
            }
            $this->master->add_market($data, Auth::user()->id);
            $a=url()->previous();
            $b=substr($a, strrpos($a, '/') + 1);
                
                if($b=="publish-bike-sale"){
                    return redirect()->route('publish-bike-sale');
                }else{
                    
                    return redirect('/user/dashboard');
                }
        }

        return $next($request);
    }
}
