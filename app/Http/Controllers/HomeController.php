<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\ResizeImageComp;
use App\User;
use App\Report;
use App\ReportMedia;
use App\AccountList;
use App\Repositories\MasterRepository;

use Illuminate\Support\Facades\DB;
use Mail;
use Validator;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Illuminate\Support\Facades\Auth;
use Session;
use App;
use App\Group;
use App\ReportToGroup;

use AWeberAPI;
use App\Http\Controllers\CommonController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $data = array();
    public function __construct(MasterRepository $master)
    {

        $this->master=$master;
       // $this->middleware('auth');

     
     $this->Report_obj = new Report();
     $this->ReportMedia_obj = new ReportMedia();

     $this->record_per_page=10;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   
    /**
    * Function index
    *
    * function to get home page
    *
    * @Created Date: 09 March 2018
    * @Modified Date: 09 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    public function index(Request $request, $id = '')
    {


        $account_list = AccountList::orderby('account.name','ASC')->get();
        if ($request->all()) { //post
    
            //dd($_FILES);
           //dd($request->files->all());
      //dd($request->files->img);
    
             //dd($request->all());
            
       if(isset($request->title) && $request->title!=""){
        
                    $this->Report_obj->account_id  = $request->account_id;
                    $this->Report_obj->title  = $request->title;
                    $this->Report_obj->details  = $request->details;
                    $this->Report_obj->name  = $request->name;
                    $this->Report_obj->phone_no  = $request->phone_no;
                    $this->Report_obj->email_address  = $request->email_address;
            // validation false message set here...
                if($this->Report_obj->save())
                            {
                                $report_id = $this->Report_obj->id;
                                $reportGroup = new ReportToGroup();
                                $reportGroup->report_id     =   $report_id ;
                                $reportGroup->group_id      =   $request->group_id;
                                $reportGroup->save();
                               // dd($request->file('img'));   
                               if (!empty($request->file('img'))) {
                                foreach($request->file('img') as $key=>$val){
                                $this->ReportMedia_obj = new ReportMedia();
                                $imagename = ImageUpload($val,'report');
                                $this->ReportMedia_obj->report_id = $report_id;
                                $this->ReportMedia_obj->file_name = $imagename;
                                $this->ReportMedia_obj->save();
                                }
                            }
       
                                echo '<div class="alert alert-success"> Your report has been successfully submitted.</div>';
                            }
            
                        exit;
                 }
               }
               else{
                  return view('outer.home', ['account_list'=>$account_list]);       
               }                  
    }

     public function agaxCaptchaResponse(Request $request)
    {


      
             $captch_val = $_POST["g-recaptcha-response"];

            $secretKey = env('GOOGLE_CLIENT_SECRET'); //Your-Secret-Key;
            $ip = $_SERVER['REMOTE_ADDR'];
            $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captch_val."&remoteip=".$ip);
            $responseKeys = json_decode($response,true);
            //dd($responseKeys);
            if(intval($responseKeys["success"]) == 1) {   
            return "matched"; 
            }
            else{
                return "not matched";
            }
            exit;
        }

    public function report_home(Request $request, $id = '')
    {
        $reportGroup = new ReportToGroup();
        $user_role_id = $request->session()->get('user_role_id');
        //$account_list = AccountList::orderby('account.name','ASC')->get();
		$account_list = AccountList::where('id','=',$request->session()->get('account_id') )->get();
		//dd($account_list);
        $group = Group::with(['userGroup'])->with('accountGroup') ;
        $user_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');	
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
            
        }
        $group = $group->orderBy('created_at', 'desc')->get(); 

        if ($request->all()) {   
            if(isset($request->title) && $request->title!=""){
                    $this->Report_obj->account_id  = $request->account_id;
                    $this->Report_obj->title  = $request->title;
                    $this->Report_obj->details  = $request->details;
                    $this->Report_obj->name  = $request->name;
                    $this->Report_obj->phone_no  = $request->phone_no;
                    $this->Report_obj->email_address  = $request->email_address;
                    if($this->Report_obj->save())
                        {
                                $report_id = $this->Report_obj->id;                               
                                if (!empty($request->file('img'))) 
                                {
                                    foreach($request->file('img') as $key=>$val)
                                    {
                                        $this->ReportMedia_obj = new ReportMedia();
                                        $imagename = ImageUpload($val,'report');
                                        $this->ReportMedia_obj->report_id = $report_id;
                                        $this->ReportMedia_obj->file_name = $imagename;
                                        $this->ReportMedia_obj->save();
                                    }
                                }
                        }
                        echo '<div class="alert alert-success">
                        Your report has been successfully submitted.
                        </div>';
                        exit;
                 }
               }
               else{
                  return view('outer.report-home', ['account_list'=>$account_list, 'report_id'=>base64_decode($id),'group'=>$group,'user_role_id'=>$user_role_id]);       
               }   
    }

      /**
    * Function affi
    *
    * function to get optin page
    *
    * @Created Date: 25 April 2018
    * @Modified Date: 25 April 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    public function affi(Request $request)
    {

        //$current_language = \Lang::getLocale();
       // dd($current_language);
        //return view('home'); old theme
        return view('outer.aff');
        
    }

    
    /**
    * Function  privacy
    *
    * privacy policy
    *
    *
    * @Created Date: 26 March 2018
    * @Modified Date: 26 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */

    public function privacy(Request $request)
    {
        return view('outer.privacy');
    }


/**
    * Function  agreement
    *
    *agreement
    *
    *
    * @Created Date: 26 March 2018
    * @Modified Date: 26 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */

    public function agreement(Request $request)
    {
        return view('outer.agreement');
    }

    /**
    * Function  coming_soon
    *
    *agreement
    *
    *
    * @Created Date: 02 April 2018
    * @Modified Date: 02 April 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */

    public function coming_soon(Request $request)
    {
        return view('outer.coming_soon');
    }




    /**
    * Function to handle call back from aweber
    *
    * function to get home page
    *
    * @Created Date: 08 March 2018
    * @Modified Date: 08 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    public function callback(Request $request)
    {
        if(empty($request->email) || empty($request->reference) || empty($request->name)){
             return redirect()->route('home');
        }
        $is_reference_exits = User::where('referral_code', '=', $request->reference)->where('status', '!=', '3')->first();
        
        if(empty($request->reference)){
          return redirect()->route('home');
         }

         $user = User::where('email', '=', $request->email)->first();

         if(empty($user)){
            $user = new User;
            $user->link_expire = '0';
         }

         if($user->r_status == '0'){

             $user->link_expire = '0';
        }
         // save refrence of user if reference exist
         if(!empty($request->reference)){
            $is_reference_exits = User::where('referral_code', '=', $request->reference)->where('status', '!=', '3')->first();
            //dd($user);
            if(!empty($is_reference_exits)){
                $user->refer_by = $is_reference_exits->id;
            }else{
                $user->refer_by = 0;
            }
         }
         
         $user->status = '2'; //Active default
         $user->user_type = '1';
         $user->first_name = strtolower($request->name);
         $user->email = strtolower($request->email);
         $user->r_status = '0';
         $user->status = '1';

         $user->save();
         
         //$this->sendverificationEmail($user->id);
         
         //return redirect('/thankyou');
         //dd($request->all());

        //return view('thankyou',['data' => $request->all(),'id' => $user->id]);

    return view('outer.thankyou',['data' => $request->all(),'id' => $user->id]);         
    }
    /**
    * Function to handle vsl_page
    *
    * function to get home page
    *
    * @Created Date: 08 March 2018
    * @Modified Date: 08 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    public function vsl_page(Request $request){


        $email =  $request->email;
        $user = User::where('email', '=', $email)->where('r_status', '=', '0')->where('status', '!=', '4')->first();
        //return view('vsldk',['data' => $user]);
        return view('outer.vsl',['data' => $user]);
        
    }

    
    /**
     * Changes the current language and returns to previous page
     * @return Redirect
     */
    public function changeLang($locale=null)
    {

        //\LaravelGettext::setLocale('fr-CH');
        //dd($locale);
        \LaravelGettext::setLocale($locale);
        //$route = route(Route::currentRouteName());
        $route = url()->previous();

        //save locale in session
        return redirect($route);
        //return redirect('home');
    }
    
   /**
    * Function to register user on front end
    *
    *
    * @Created Date: 08 March 2018
    * @Modified Date: 08 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
     public function register(Request $request) {
       
        return view('register',['data' => $request->all()]);
        
    }


      /**
    * Function to thankyoupage
    *
    *thankyou page after optin page
    * @Created Date: 14 March 2018
    * @Modified Date:  14 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
     public function thankyou(Request $request) {
        //dd($request->all());

        //return view('thankyou'); //old theme

        return view('outer.thankyou');

        
    }



     /**
    * Function check_email
    *
    * ajax function To check unique username
    *
    * @Created Date: 27 Nov, 2017
    * @Modified Date: 27 Nov, 2017
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    public function check_for_email(Request $request) {
        $email = strtolower(trim($request->email));
        
        $user = User::where('email', '=', $email)->where('r_status')->where('status', '!=', '4')->first();
        //dd($user->id);
        if (!empty($user->id)) {
            return 'false';
        }
        return 'true';
    } 

      /**
    * Function ch
    *
    * ajax function To check user status
    *
    * @Created Date: 27 Nov, 2017
    * @Modified Date: 27 Nov, 2017
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    public function check_user_status(Request $request) {
        $email = strtolower(trim($request->email));
       
        $user = User::where('email', '=', $email)->where('status','!=','3')->first();
        //dd($user);
        if(empty($user)){
            return 'true';
        }

        if($user->r_status == '1' ||$user->r_status == '2'){
            return "false";
        }

        return "true";
        
    } 

       /**
    * Function check_user_reference
    *
    * ajax function To check user status
    *
    * @Created Date: 27 Nov, 2017
    * @Modified Date: 27 Nov, 2017
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    public function check_user_reference(Request $request) {
        $reference = strtolower(trim($request->title));
       //dd($reference);
        $user = User::where('referral_code', '=', $reference)->where('status','!=','3')->first();
        //dd($user);
        if(empty($user)){
            return 'false';
        }
        return "true";
        
    } 


      /**
    * Function ch
    *
    * ajax function To check if user exist in database
    *
    * @Created Date: 27 Nov, 2017
    * @Modified Date: 27 Nov, 2017
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    public function is_user_exist(Request $request) {
        $email = strtolower(trim($request->email));
       
        $user = User::where('email', '=', $email)->where('r_status', '=', '0')->first();
        //dd($user);
        if(!empty($user)){
            return 'true';
        }

        

        return "false";
        
    } 
         /**
    * Function register_user 
    *
    * ajax function To register user
    *
    * @Created Date: 08 March 2018
    * @Modified Date: 08 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav MAlik
    * @param  ARRAY
    * @return STRING
    */

    public function register_user(Request $request){
    
       //dd($request->all());

        if ($request->all()) { //post
            $id = trim($request->user_id);
            $user_type = '1';
            $email = strtolower(trim($request->email)); 
            $first_name = strtolower(trim($request->first_name));
            $last_name = strtolower(trim($request->last_name));
            $new_password = trim($request->mdp);
            $refereal_code = $this->generate_random_number();
            $user = User::where('email','=',$email)->where('status','!=','3')->first();
            if(empty($user)){
                $user = new User;
            }    
                    $user->status = '1'; //Active default
                    $user->user_type = '1';
                    $user->r_status = '1';
                    $user->referral_code = $refereal_code;
                    $user->password = Hash::make($new_password);
                    $user->first_name = strtolower($first_name);
                    $user->last_name = strtolower($last_name);
                    $user->email = strtolower($email);

                    //dd($user);
                    $user->save();

                    Session::put('user_id', $user->id);
                    return redirect()->route('start');
                
            
        }
        else {
            return view('register',['data' => $request->all()]);
        }
    
    }


         /**
    * Function sendverificationEmail
    *
    * function to sendverificationEmail
    *
    * @Created Date:13 march 2018
    * @Modified Date: 13 march 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    
    public function  sendverificationEmail($id=null,$pass=null) { 
        $userID = trim($id); 
        $strVerifyCode = md5(uniqid());  
        $user = User::find($userID); 
        $userEmailID = $user->email; 
        $userName = $user->first_name; 
        $user->verification_code = $strVerifyCode; 
        $user->save(); 
        //dd($user);
        
        if ($user) { 
            $verifyLink = route('verify-link');
           
            $verifyLink .= '?email='.$userEmailID.'&verification_code='.$strVerifyCode;

             

                    $template = template_by_variable('accountregistration');
                   
                    $emaildata['site_title'] = get_option('site_title'); 
                    $emaildata['admin_email'] = get_option('email'); 
                    $signature = get_option('email_signature'); 
                     
                    $emaildata['subject'] = $template->title; 
                    $body = stripslashes($template->description); 
                 
                    $patternFind[0] = '/{NAME}/'; 
                    $patternFind[1] = '/{ACTIVATIONLINK}/'; 
                    $patternFind[2] = '/{SIGNATURE}/';
                    $patternFind[3] = '/{EMAIL}/';
                    //$patternFind[4] = '/{PASSWORD}/'; 
                     
                    $replaceFind[0] = $userName;  
                    $replaceFind[1] = $verifyLink; 
                    $replaceFind[2] = $signature; 
                    $replaceFind[3] = $userEmailID; 
                    //$replaceFind[4] = $pass; 

                    $ebody     = nl2br(preg_replace($patternFind, $replaceFind, $body)); 
                    $emaildata['body'] = html_entity_decode(stripslashes($ebody)); 
                     
                    //$userEmailID = "sdd.sdei@gmail.com"; 
         
            try{ 
                    Mail::send(['html' => 'emails.template'], ['body' => $emaildata['body']], function($message) use ($emaildata,$userEmailID) 
                    { 
                        $message->from($emaildata['admin_email'],$emaildata['site_title']); 
                        $message->title($emaildata['subject']); 
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


         /**
    * Function verify_link
    *
    * function to verify link sent to email
    *
    * @Created Date:13 march 2018
    * @Modified Date: 13 march 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    public function verify_link(Request $request){
        $email = $request->email;
        $verification_code = $request->verification_code;
        
        $user = User::where('email', '=', $email)->where('status', '!=', '3')->where('verification_code','=',$verification_code)->where('link_expire','0')->first();

         if(empty($user->id)){
            return redirect()->route('verification-failed');
         }else{
            $user->email_verify = '1';
            $user->link_expire = '1';
            $user->status = '1';
            $user->save();
            return redirect()->route('vsl-page',['id' => base64_encode($user->id)])->with('message', 'Email verified successfully!!!');
         }

         
    }
             /**
    * Function to handle case if verification email failed
    *
    * Function to handle case if verification email failed
    *
    *
    * @Created Date: 08 March 2018
    * @Modified Date: 08 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
    public function verification_failed(){
        return view('verification-failed');
    }

         /**
    * Function to genearte random numbers
    *
    * Function to genearte random numbers
    *
    *
    * @Created Date: 08 March 2018
    * @Modified Date: 08 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */

    public function generate_random_number(){

        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        $random_string_length = 6;
        $max = strlen($characters) - 1;
         for ($i = 0; $i < $random_string_length; $i++) {
              $string .= $characters[mt_rand(0, $max)];
         }

         $user = User::where('referral_code', '=', $string)->first();
         if(!empty($user)){
            $this->generate_random_number();
         }

         return $string;

        }


     /**
    * Function to get started on payment
    *
    * Function to get started on payment
    *
    *
    * @Created Date: 09 March 2018
    * @Modified Date: 09 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */

    public function start(Request $request){
        $user_id = Session::get('user_id');
        $user = User::find($user_id); 
        if(empty($user_id)){
            return redirect()->route('register');
        }
        return view('starthere',['data' => $request->all(),'email' => $user->email,'name' => $user->first_name.' '.$user->last_name,'publishable_key' => $this->stripe_publishable_key]);

    }


    /**
    * Function genrate_invoice_pdf
    *
    * Function to genrate invoice pdf and send to email
    *
    *
    * @Created Date: 12 March 2018
    * @Modified Date: 12 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    */
    public function genrate_invoice_pdf($user = null,$payment = null,$plan_name = null) {
        //dd($user);

        if(empty($plan_name)){
        $plan_name = 'Starter Plan';
        }
        $pdf = App::make('dompdf.wrapper');
        $html = \View::make(
                            'invoice/invoice',
                            array(
                                'user_name' => ucwords($user->first_name)." ".ucwords($user->last_name) ,
                                'payment' => $payment->net_amount ,
                                'transaction_id'=> $payment->transaction_id ,
                                'transaction_type' => $payment->transaction_type,
                                'plan_name' => $plan_name
                                )
                            )->render();
       
        $pdf->loadHTML($html);
        //file_put_contents("test.pdf", $pdf->output());
        $file_name = $user->first_name.time().'_invoice.pdf';
        $pdf->save(public_path().'/invoice/'.$file_name);
        $pathToFile = public_path().'/invoice/'.$file_name;

        $userEmailID = $user->email; 
        $userName = $user->first_name; 

        if ($user) { 

                    $template = template_by_variable('firstpaymentcompleted');
                    $emaildata['site_title'] = get_option('site_title'); 
                    $emaildata['admin_email'] = get_option('email'); 
                    $signature = get_option('email_signature'); 
                     
                    $emaildata['subject'] = $template->title; 
                    $body = stripslashes($template->description); 
                 
                    $patternFind[0] = '/{USER_NAME}/'; 
                    $patternFind[1] = '/{TRANSACTION_ID}/'; 
                    //$patternFind[4] = '/{PASSWORD}/'; 
                     
                    $replaceFind[0] = ucwords($user->first_name)." ".ucwords($user->last_name);  
                    $replaceFind[1] = $payment->transaction_id; 
                    //$replaceFind[4] = $pass; 

                    $ebody     = nl2br(preg_replace($patternFind, $replaceFind, $body)); 

                    $emaildata['body'] = html_entity_decode(stripslashes($ebody)); 
                     //dd($emaildata);
                    //$userEmailID = "sdd.sdei@gmail.com"; 
         
            try{ 
            Mail::send(['html' => 'emails.template'], ['body' => $emaildata['body']], function($message) use ($emaildata,$userEmailID,$pathToFile) 
                    { 
                        $message->from($emaildata['admin_email'],$emaildata['site_title']); 
                        $message->title($emaildata['subject']); 
                        $message->to($userEmailID); 
                        $message->attach($pathToFile);

                    }); 
                    $msg = "Email Has been sent successfully.";
                 
                   return ;
            } catch(\Exception $e){
             // dd($e);  
              echo  $msg = "Something Went wrong, Please try Again."; 
                      return;    
                       
                        
            }           
        }else{ 
            //dd($e);
            echo  $msg = "Something Went wrong, Please try Again."; 
              return;
          }      
        //return $pdf->stream(); 
       // return $pdf->download('invoice.pdf');

    }

     /**
    * Function to payment for 7 dollar
    *
    * Function to payment for 7 dollar
    *
    *
    * @Created Date: 12 March 2018
    * @Modified Date: 12 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */

    public function first_payment(Request $request){
    Session::pull('payment_error');
    if ($request->all()) { //post
    //dd($request->all());
    $user_id = Session::get('user_id');
    $user = User::find($user_id);
    if($request->paymentType == "paypal"){ // paypalpayment handling


              $arrValMsgs = [
            'cardNumber.required' => 'Card number is required.',
            'CVV2.required' => 'Security code is required.',
            'BILLTOFIRSTNAME.required' => 'First Name is required.',
            'BILLTOLASTNAME.required' => 'Last Name is required.'

                ];
                $arrRules = [
                    'cardNumber' => 'required|max:16',
                    'CVV2' => 'required',
                    'BILLTOFIRSTNAME' => 'required', 
                    'BILLTOLASTNAME' => 'required'
                ];
            $validator = Validator::make($request->all(), $arrRules, $arrValMsgs);
                if ($validator->fails()) {
                    $strMessage = '';
                    $arrValidatorMsg = (array) json_decode($validator->messages());
                    foreach ($arrValidatorMsg as $arrValidMsg) {
                        foreach ($arrValidMsg as $strValidMsg) {
                            $strMessage .= $strValidMsg . '<br />';
                        }
                    }
                    return ['status' => 'notValid', 'msg' => $strMessage];
                }

                 $month_padded = sprintf("%02d", $_POST['month']);

                 $data = array(
                "PARTNER" => "PayPal",
                "VENDOR" => "digitalkheops511",
                "USER" => "digitalkheops511",
                "PWD" => "digitalkheops511",
                "TENDER" => "C",
                "TRXTYPE" => "S",
                "CURRENCY" => "USD",
                "AMT" =>  "7.00",
                "EMAIl" => $user->email,
                "ACCT" => $_POST['cardNumber'],
                "EXPDATE" => $month_padded.substr( $_POST['year'], -2 ),
                "CVV2" => $_POST['CVV2'],

                "BILLTOFIRSTNAME" => $_POST['BILLTOFIRSTNAME'],
                "BILLTOLASTNAME" => $_POST['BILLTOLASTNAME']

              );

               //  dd($data);


            try {
                  $response = $this->run_payflow_call($data);

                  if (isset($response['RESULT']) && $response['RESULT'] == 0){

                        //$user_id = Auth::user()->id;
                        $payment = new Payment;
                        $payment->user_id = $user_id;
                        $payment->plan_id = 0;
                        $payment->net_amount = "7.00";
                        $payment->transaction_id = $response['PNREF'];
                        $payment->status = 1;
                        $payment->transaction_status = 'Approved';
                        $payment->transaction_type = '1';
                        $payment->payment_date = date('Y-m-d');

                        $payment->save();

                        $user = User::find($user_id);
                        $user->r_status = '2';
                        $user->save();
                        $this->genrate_invoice_pdf($user,$payment,null);

                        Auth::login($user);
                        //Aweber data to send
                        $list_id = 'awlist4929030';
                        $post = array(
                            'meta_required' => 'name,email',
                            'name' => $user->first_name.' '.$user->last_name,
                            'email' =>$user->email
                        );
                        //
                         $common_controller = new CommonController();
                         $status = $common_controller->add_to_aweber_list($post,$list_id);
                        if($status){
                            
                           Session::put('pay_success_7', 'Payment success');
                           return redirect('user/dashboard'); 
                        }
                        

                        //return ['status' => 'success','transaction_id'=> $response['PNREF'], 'msg' => 'Your Trial period has been successfully started, you can ask for refund in 14 days. Dashboard Page is in progress'];

                        //==========================================


                        //===========================================
                    
                    }else{
               // if payment fails redirect to credit card page
                        $error = isset($response['RESPMSG']) ? $response['RESPMSG'] : 'Some error occured. Please try again';
                        $request->session()->flash('add_message', $error);
                        return redirect()->back()->withInput();
                    }

            }catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
             return ['status' => 'error','msg' => 'Something went wrong.'];
            }
    }else{// stripe payment handling


           try {
             $user = User::find($user_id);
               
           Stripe::setApiKey($this->stripe_api_key);

            // Token is created using Checkout or Elements!
            // Get the payment token ID submitted by the form:
            $token = $_POST['stripeToken'];

            // Charge the user's card:
            $charge = Charge::create(array(
              "amount" => 700,
              "currency" => "usd",
              "description" => "Example charge",
              "source" => $token,
              'receipt_email' => $user->email
            ));


            if(isset($charge->id) && $charge->paid == '1'){

                //$user_id = Auth::user()->id;
                $payment = new Payment;
                $payment->user_id = $user_id;
                $payment->plan_id = 0;
                $payment->net_amount = 7;
                $payment->transaction_id = $charge->id;
                $payment->status = $charge->paid;
                $payment->transaction_status = $charge->status;
                $payment->transaction_type = '2';
                $payment->payment_date = date('Y-m-d');

                $payment->save();

               
                $user->r_status = '2';
                $user->save();

                $this->genrate_invoice_pdf($user,$payment,null);
                 Auth::login($user);
                $list_id = 'awlist4929030';
                $post = array(
                    'meta_required' => 'name,email',
                    'name' => $user->first_name.' '.$user->last_name,
                    'email' =>$user->email
                );
                //
                 $common_controller = new CommonController();
                 $status = $common_controller->add_to_aweber_list($post,$list_id);
                if($status){
                   Session::put('pay_success_7', 'Payment success');
                   return redirect('user/dashboard'); 
                }

                //return ['status' => 'success','transaction_id'=> $charge->id, 'msg' => 'Your Trial period has been successfully started, you can ask for refund in 14 days.Dashboard Page is in progress'];
            }

            }catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
                $request->session()->flash('add_message', 'some error in form fields');
              return redirect()->back()->with('error','some error in form fields'); 
            }

           

        }

       
                
            
        }
        else {
            return 'false';
        }

    }

    


   
 /**
    * Function  parse_payflow_string
    *
    * paypal gateway function
    *
    *
    * @Created Date: 12 March 2018
    * @Modified Date: 12 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
 public function parse_payflow_string($str) {
    $workstr = $str;
    $out = array();
    
    while(strlen($workstr) > 0) {
        $loc = strpos($workstr, '=');
        if($loc === FALSE) {
            // Truncate the rest of the string, it's not valid
            $workstr = "";
            continue;
        }
        
        $substr = substr($workstr, 0, $loc);
        $workstr = substr($workstr, $loc + 1); // "+1" because we need to get rid of the "="
        
        if(preg_match('/^(\w+)\[(\d+)]$/', $substr, $matches)) {
            // This one has a length tag with it.  Read the number of characters
            // specified by $matches[2].
            $count = intval($matches[2]);
            
            $out[$matches[1]] = substr($workstr, 0, $count);
            $workstr = substr($workstr, $count + 1); // "+1" because we need to get rid of the "&"
        } else {
            // Read up to the next "&"
            $count = strpos($workstr, '&');
            if($count === FALSE) { // No more "&"'s, read up to the end of the string
                $out[$substr] = $workstr;
                $workstr = "";
            } else {
                $out[$substr] = substr($workstr, 0, $count);
                $workstr = substr($workstr, $count + 1); // "+1" because we need to get rid of the "&"
            }
        }
    }
    return $out;
}
 /**
    * Function  run_payflow_call
    *
    * paypal gateway function
    *
    *
    * @Created Date: 12 March 2018
    * @Modified Date: 12 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */
public function run_payflow_call($params) {
    $environment = 'pilot';
    
    $paramList = array();
    foreach($params as $index => $value) {
        $paramList[] = $index . "[" . strlen($value) . "]=" . $value;
    }
    
    $apiStr = implode("&", $paramList);
    
    // Which endpoint will we be using?
    if($environment == "pilot" || $environment == "sandbox")
      $endpoint = "https://pilot-payflowpro.paypal.com/";
    else $endpoint = "https://payflowpro.paypal.com";

    // Initialize our cURL handle.
    $curl = curl_init($endpoint);
    
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    
    // If you get connection errors, it may be necessary to uncomment
    // the following two lines:
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $apiStr);
    curl_setopt($curl, CURLOPT_CAINFO, '/var/www/html/cacert.pem');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    
    $result = curl_exec($curl);
    if($result === FALSE) {
      echo curl_error($curl);
      return FALSE;
    }
    else return $this->parse_payflow_string($result);
}



}
