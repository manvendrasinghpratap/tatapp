<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class CheckAdminStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $temp = $request->session()->get('admin_login');
        
        //If not session redirect to logout
        if(!$temp || $temp!=1){
           $request->session()->forget('admin_login');
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect('/admin/login');
        }
        return $response;
    }
}
