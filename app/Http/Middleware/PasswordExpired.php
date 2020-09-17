<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;
use Carbon\Carbon;

use App\User;
class PasswordExpired
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
		//Auth::user();
		
		
		
		//dd($request->session());
		
		  $user_role_name = $request->session()->get('user_role_name') ;
		  //dd($user_role_name);
		
		$user=User::where('id',$request->session()->get('id'))->first();
		//dd($user);
       // $password_changed_at = Carbon::parse(($user->password_changed_at) ? $user->password_changed_at : $user->created_at);
	   if($request->session()->get('id')){
		   if(!$user->password_changed_at) return redirect()->route('admin-changepassword');
	   }
	   

       /*  if (Carbon::now()->diffInDays($password_changed_at) >= config('auth.password_expires_days')) {
            return redirect()->route('password.expired');
        } */
        return $next($request);
    }
}
