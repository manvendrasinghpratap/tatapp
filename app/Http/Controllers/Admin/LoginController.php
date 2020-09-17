<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Site;
use Illuminate\Support\Facades\Hash;
use Validator;
use Session;
use Illuminate\Cookie\CookieJar;
use Illuminate\Cookie\CookieServiceProvider;
use Cookie;
use DB;

class LoginController extends Controller
{
    /**
    * Function __construct
    *
    * function CONSTRUCTOR
    *
    * @Created Date: 12 July, 2018
    * @Modified Date: 12 July, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  INT
    * @return NULL
    */
    public function __construct(Request $request) {
        
       
    }
    /**
    * Function login
    *
    * function to load login page
    *
    * @Created Date: 12 July, 2018
    * @Modified Date: 12 July, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  INT
    * @return NULL
    */
    public function login(Request $request)
    {


        $temp = @$request->session()->has('admin_login');
        if($temp && $temp==1){
            return redirect('admin/dashboard');
        }
        $AdminLoginDetails = Cookie::get('loginAdminData', array());

        return view('admin.login',['AdminLoginDetails'=>$AdminLoginDetails]); 
    }
    /**
    * Function authenticate
    *
    * function to authenticate login 
    *
    * @Created Date: 12 July, 2018
    * @Modified Date: 12 July, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  INT
    * @return NULL
    */
    function authenticate(Request $request)
    {
        
        $email = strtolower(trim($request->email));
        $password = trim($request->password);

        //Validate the input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin-login')
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $user = User::where('email',$email)->with('accountInfo')->first();
 

            


            
            
            if($user)
            {

                $roleDetails = DB::table('role_user')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('roles.id', 'roles.name', 'roles.display_name')
            ->where('role_user.user_id', $user->id)
            ->get();

                 $check = Hash::check($password, $user->password);
                
                if(!$check)
                {


                    $validator->errors()->add('password', 'Invalid email or password!');
                    return redirect()->route('admin-login')
                            ->withErrors($validator)
                            ->withInput();
                }
                else
                {
                   
                    $remember_me = $request->has('remember_me') ? true : false;
                    $userData = array(
                        'email' => $email,
                        'password' => $password,
                        'status' => '1',
                    );
                   
                    if($remember_me == true)
                    {
                        Cookie::queue('loginAdminData', $userData, 43200);
                    }
                    else{
                        Cookie::queue('loginAdminData', array(), 1);
                    }

                    $user_full_name = $user->first_name." ".$user->last_name;
                    $admin_data = array();
                    $admin_data = array('id'=>$user->id,'email'=>$user->email,'name'=>$user_full_name,'user_type'=>$roleDetails[0]->id);
                    $userGroup = \App\UserGroup::where('user_id',$user->id)->pluck('group_id')->toArray();
                   //do login & start session
                    $space = 0;
                    if(!empty($user['accountInfo']->accountStorageSize->space_size)){
                        if($user['accountInfo']->accountStorageSize->space_size>=1000){
                           $space = round($user['accountInfo']->accountStorageSize->space_size/1000,3).' GB'; 
                        }else{
                            $space =$user['accountInfo']->accountStorageSize->space_size .' MB'; 
                        }
                    }
                    $request->session()->put('admin_login', '1');
                    session(['account_id' => $user->account_id]);
                    session(['account_name' => $user['accountInfo']->name]);
                    session(['account_email' => $user['accountInfo']->email_address]);
                    session(['account_membership_type' => $user['accountInfo']->membership_type]);
                    session(['storage_space' => $space]);
                    session(['account_status' => $user['accountInfo']->status]);
                    session(['email' => $user->email]);
                    session(['id' => $user->id]);
                    session(['name' => $user_full_name]);
                    session(['profile_pic' => $user->profile_pic]);
                    session(['user_type' => $roleDetails[0]->id]);// role id
                    session(['user_role_id' => $roleDetails[0]->id]);
                    session(['user_role_name' => $roleDetails[0]->name]);
                    session(['user_role_display_name' => $roleDetails[0]->display_name]);
                    session(['ADMIN_LOGIN_DATA'=>$admin_data]);
                    session(['user_group' => $userGroup]);
                    return redirect()->route('admin-dashboard'); 
                }
            }
            else{
                $validator->errors()->add('password', 'Invalid email or password!');
                return redirect()->route('admin-login')
                            ->withErrors($validator)
                            ->withInput();
            }
        }
    }
    /**
    * Function logout
    *
    * function to logout
    *
    * @Created Date: 12 July, 2018
    * @Modified Date: 12 July, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  INT
    * @return NULL
    */
    public function logout(Request $request)
    {
        

        $request->session()->forget('account_id');
        $request->session()->forget('account_name');
        $request->session()->forget('account_email');
        $request->session()->forget('account_membership_type');
        $request->session()->forget('account_status');
        $request->session()->forget('admin_login');
        $request->session()->forget('id');
        $request->session()->forget('name');
        $request->session()->forget('email');
  
        $request->session()->forget('user_type');
        $request->session()->forget('user_role_id');
        $request->session()->forget('user_role_name');
        $request->session()->forget('user_role_display_name');
        $request->session()->forget('ADMIN_LOGIN_DATA');
        //$request->session()->flush();
        //$request->session()->regenerate();
        return redirect()->route('admin-login');
    }
}
