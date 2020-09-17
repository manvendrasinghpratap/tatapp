<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Cookie;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('guest')->except(['logout', 'testCookie']);
    }
protected function credentials(Request $request)
{

            $remember_me = $request->has('remember') ? true : false;

                if($remember_me == true)
                    {
                         $userData = array(
                        'email' => $request->email,
                        'password' => $request->password,
                        'status' => '1',
                    );

                    Cookie::queue(Cookie::make('userData', $userData, 60));
                }
            else{
               
                 Cookie::queue(Cookie::forget('userData'));
            }
    return array_merge($request->only($this->username(), 'password'), ['status' => '1','user_type' => '1']);
    
}
protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

    }
   
   public function logout(Request $request)
{
    
   $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
}
public function testCookie(Request $req){
    Cookie::queue(Cookie::make('name', 'value', 60));
}
}
