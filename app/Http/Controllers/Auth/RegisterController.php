<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use App\Repositories\MasterRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/publish-bike-sale';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MasterRepository $master)
    {
        $this->master=$master;
        $this->middleware('guest');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
           // 'name' => 'required|string|max:255',
            /*'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',*/
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
       /* if($user = Auth::user())
{
    echo"login";

}else{
    echo "not";
}
        exit;*/
        if(isset($data['commision_fee_doc'])){
             $commision_fee_doc=$data['commision_fee_doc'];
        }
        if(isset($data['market_rules'])){
             $market_rules=$data['market_rules'];
        }
        $mdate=$data['marketdt'];
         unset($data['marketdt']);
     $result = array_map('trim', $data);
    
     $pass=str_random(8);

 $validator=$this->master->validation($data);

 
            if ($validator->fails()) {


                    return redirect()->route('publish-bike-sale')
                                    ->withErrors($validator)
                                    ->withInput();
                
            }



       $user=  User::create([
            'name' => $result['name'],
            'email' => $result['email'],
            'street' => $result['street'],
            'postcode' => $result['postcode'],
            'phone' => $result['phone'],
            'website' => $result['website'],
             'additional_info' => $result['add_info'],
            'password' => Hash::make($pass),
            'user_type_id'=>'1',
            'status'=>'1',
            'email_verified'=>'',
            'verification_code'=>'',
        ]);

$result['marketdt']=$mdate;
 if(isset($data['commision_fee_doc'])){
            $result['commision_fee_doc']=$commision_fee_doc;
        }
if(isset($data['market_rules'])){
           $result['market_rules']=$market_rules;
        }

         $this->master->add_market($result, $user->id);
         $this->sendverificationEmail($user->id,$pass);
    }
       /**
    * Function sendverificationEmail
    *
    * function to add user
    *
    * @Created Date: 06 Sep, 2017
    * @Modified Date: 06 Sep, 2017
    * @Created By: Diksha Srivastava
    * @Modified By: Diksha Srivastava
    * @param  ARRAY
    * @return STRING
    */
    
    public function  sendverificationEmail($id=null,$pass=null) { 
         
        $userID = trim($id); 
        $strVerifyCode = md5(uniqid()); 
        $user = new User; 
        $user = User::find($userID); 
        $userEmailID = $user->email; 
        $userName = $user->username; 
        $user->verification_code = $strVerifyCode; 
        $user = $user->save(); 
        
        if ($user) { 
         
            $verifyLink = '';  

                    $template = template_by_variable('accountregistration'); 
                    $emaildata['site_title'] = get_option('site_title'); 
                    $emaildata['admin_email'] = get_option('email'); 
                    $signature = get_option('email_signature'); 
                     
                    $emaildata['subject'] = $template->subject; 
                    $body = stripslashes($template->description); 
                 
                    $patternFind[0] = '/{NAME}/'; 
                    $patternFind[1] = '/{ACTIVATIONLINK}/'; 
                    $patternFind[2] = '/{SIGNATURE}/';
                     $patternFind[3] = '/{EMAIL}/';
                      $patternFind[4] = '/{PASSWORD}/'; 
                     
                    $replaceFind[0] = $userName;  
                    $replaceFind[1] = $verifyLink; 
                    $replaceFind[2] = $signature; 
                     $replaceFind[3] = $userEmailID; 
                      $replaceFind[4] = $pass; 

                    $ebody     = nl2br(preg_replace($patternFind, $replaceFind, $body)); 
                    $emaildata['body'] = html_entity_decode(stripslashes($ebody)); 
                     
                    //$userEmailID = "sdd.sdei@gmail.com"; 
         
        try{ 
         Mail::send(['html' => 'emails.template'], ['body' => $emaildata['body']], function($message) use ($emaildata,$userEmailID) 
                    { 
                        $message->from($emaildata['admin_email'],$emaildata['site_title']); 
                        $message->subject($emaildata['subject']); 
                        $message->to($userEmailID); 
                    }); 
                    $msg = "Email Has been sent successfully.";
                 
                   return ;
        } catch(\Exception $e){
            
          echo  $msg = "Something Went wrong, Please try Again."; 
                  return;    
                   
                    
        }           
        }else{ 

            echo  $msg = "Something Went wrong, Please try Again."; 
              return;        
                   
                       
                }             
         
    }

}
