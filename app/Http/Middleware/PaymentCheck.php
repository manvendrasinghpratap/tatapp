<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use URL;
use Illuminate\Support\Facades\Input;
use App\Repositories\MasterRepository;
use Route;
class PaymentCheck
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

            $r_status = Auth::user()->r_status;
            if($r_status == 1){
                \Session::put('user_id', Auth::user()->id);

                return redirect()->route('start');
            }
        }
        

        return $next($request);
    }
}
