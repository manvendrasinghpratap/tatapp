<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\StartPlan;
use App\Plans;
use App\PaypalDetail;
use App\StripeDetail;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MasterRepository;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Payment;
use App\PayFlow;
use App\UserPlan;
use Session;
use App;
use Mail;
use DB;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Carbon\Carbon;
use App\Http\Controllers\CommonController;
use Paypal;
use PayPal\Api\OpenIdSession;


class WebhookController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct(MasterRepository $master)
  {
      $this->master=$master; /* Paypal App Client Id */
        define('PAYPAL_CLIENT_ID', 'AY98XaorJ3fDkV3vc4M6_tmtGUbc2iythdm3bFbVwhH72fRW0B_IatZLhzNjTqHgYon-zq7hLHJhisSu');//for payment

        /* Paypal App Client Secret */
        define('PAYPAL_CLIENT_SECRET', 'EG5fN17HflYASrjDw-VueYTR5GT1zFZZEMx3yrqeGUr5h7RNbDc7ZI-LZC9IAmeX-X-9F82el7_2Jhfj');//for access token

        /* Paypal App Redirect Url */
        $redirect_url = route('paypal_auth');
        define('PAYPAL_CLIENT_REDIRECT_URL', $redirect_url);//for auth call back 

        define('STRIPE_CLIENT_SECRET','ca_CZPLXs8V3Dvi77cdQLXbuxiFfw1sgpvb');// for auth login of user

        $this->paypal_user_name = 'digitalkheops511'; // API User Username
        $this->paypal_password = 'digitalkheops511'; // API User Password
        $this->paypal_vendor = 'digitalkheops511'; // Merchant Login ID
        // Reseller who registered you for Payflow or 'PayPal' if you registered
        // directly with PayPal
        $this->paypal_partner = 'PayPal'; 
        $this->paypal_sandbox = true;

        $stripe_keys = getstripekey();
        $this->stripe_api_key = $stripe_keys->stripe_api_key;//for payment
        $this->stripe_publishable_key = $stripe_keys->stripe_publishable_key;// for payment button 
        $this->stripe_client_secret_key = $stripe_keys->stripe_client_secret_key;//for auth connect

        $this->apiContext = new \PayPal\Rest\ApiContext(
                          new \PayPal\Auth\OAuthTokenCredential(
                              'AY98XaorJ3fDkV3vc4M6_tmtGUbc2iythdm3bFbVwhH72fRW0B_IatZLhzNjTqHgYon-zq7hLHJhisSu',     // ClientID
                              'EG5fN17HflYASrjDw-VueYTR5GT1zFZZEMx3yrqeGUr5h7RNbDc7ZI-LZC9IAmeX-X-9F82el7_2Jhfj'      // ClientSecret
                          )
                      );
  }


 /**
    * Function  paypal_auth
    *
    * paypal auth callback
    *
    *
    * @Created Date: 26 March 2018
    * @Modified Date: 26 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */

    public function paypal_auth(Request $request)
    {
        //dd($request->all());

        if(isset($_GET['code'])) {
            try {
                // Get access token via an API call
                $access_token = $this->GetAccessToken($_GET['code']);

                
                // Get user details (Paypal ID included) via an API Call
                $user_info = $this->GetUserInfo($access_token); 
                $user_info = json_decode($user_info);
                //dd($user_info);

                if($user_info){
                    $current_paypal_detail = PaypalDetail::where('user_id','=',Auth::user()->id)->where('status','=','1')->first();

                    if(!empty($current_paypal_detail)){
                        $current_paypal_detail = PaypalDetail::where('user_id','=',Auth::user()->id)->where('status','=','1')->first()->update(['status'=>'3']);
                    }
                    

                    $paypal_detail = new PaypalDetail; 
                    $paypal_detail->user_id = Auth::user()->id;
                    $paypal_detail->paypal_user_id = $user_info->user_id;
                    $paypal_detail->status = '1';
                    $paypal_detail->save();

                    $msg = 'Paypal account added successfully.';
                    $request->session()->flash('add_message', $msg);
                    return redirect()->route('profile');


                }
                
            }
            catch(Exception $e) {
                echo $e->getMessage();
                exit();
            }
        }
    }


       /**
    * Function  stripe_auth
    *
    * stripe_auth  callback
    *
    *
    * @Created Date: 26 March 2018
    * @Modified Date: 26 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */

    public function stripe_auth(Request $request)
    {
        if (isset($_GET['code'])) { 

            $code = $_GET['code'];

            $post = array('client_secret'=>$this->stripe_api_key,
                          'code' => $code,
                          'grant_type' => 'authorization_code'
                        );
            $strPost = ''; 

            foreach($post as $key => $val) 
            { 
                $strPost .= $key . '=' . urlencode(trim($val)) . '&'; 
            } 

            $strPost = substr($strPost, 0, -1);  
            $strUrl = 'https://connect.stripe.com/oauth/token';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $strUrl); 
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, false);              
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOBODY, FALSE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $strPost);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            $response = curl_exec($ch);
            curl_close($ch);
            $response =json_decode($response);
             //dd($response);


             if(isset($response->error)){
                $request->session()->flash('add_message', 'Could not verify account. Please Try Again.');
                return redirect()->route('profile');
             }

             $current_stripe_detail = StripeDetail::where('user_id','=',Auth::user()->id)->where('status','=','1')->first();

                    if(!empty($current_stripe_detail)){
                        $current_paypal_detail = StripeDetail::where('user_id','=',Auth::user()->id)->where('status','=','1')->first()->update(['status'=>'3']);
                    }
                    

                    $stripe_detail = new StripeDetail; 
                    $stripe_detail->user_id = Auth::user()->id;
                    $stripe_detail->stripe_user_id = $response->stripe_user_id;
                    $stripe_detail->status = '1';
                    $stripe_detail->save();
                    //return redirect('user/authenticate_user'); 
                    $request->session()->flash('add_message', 'Stripe account added successfully.');
                    return redirect()->route('profile');


            }else if(isset($_GET['error'])) { // Error

               return redirect()->route('profile');

            } 

    }

          /**
    * Function  stripe_callback
    *
    * stripe_callback  callback
    *
    *
    * @Created Date: 28  March 2018
    * @Modified Date: 28 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */

    public function stripe_callback(Request $request)
    {
       // Retrieve the request's body and parse it as JSON

     Stripe::setApiKey($this->stripe_api_key);
     $input = file_get_contents("php://input");
     
     $event_json = json_decode($input);
     //mail("realcakephp@gmail.com","My subject",'callback recieved');


     
      
      if ($event_json->type == "invoice.payment_succeeded") {

           $data = $event_json->data->object->lines->data;
            foreach ($data as $key => $value) {
             
             //$stripe_profile_id = $value->id;
             $plan = $value->plan;
             //var_dump($plan);die;
             $stripe_profile_id = $value->type == 'subscription' ? $value->id : $value->subscription;
             
            }
            
            $plan_detail = Plans::where('plan_id_stripe','=',$plan->id)->first();
            $user_detail = User::where('stripe_profile_id','=',$stripe_profile_id)->first();
            

            $plan_amount = $value->type == 'subscription' ? $plan_detail->price : $event_json->data->object->amount_paid;

            $payment = new Payment;
            $payment->user_id = $user_detail->id;
            $payment->plan_id = $plan_detail->id;
            $payment->net_amount = $plan_detail->price;
            $payment->transaction_id = $stripe_profile_id;
            $payment->status = 1;
            $payment->transaction_status = 'Approved';
            $payment->transaction_type = '2';
            $payment->payment_date = date('Y-m-d');
            $payment->is_recurring = '1';
            $payment->save();
            // this code was updated after dual payment issue. 
            $user_plan = UserPlan::where('user_id','=',$user_detail->id)->where('plan_id','=',$plan_detail->id)->orderby('created_at','desc')->where('status','=','1')->first();
            $user_plan->payment_id = $payment->id;
            $user_plan->save();
            echo "success";die;

      }

      if ($event_json->type == "invoice.payment_failed") {

            $data = $event_json->data->object->lines->data;
      
            foreach ($data as $key => $value) {
             
             $stripe_profile_id = $value->id;
             $plan = $value->plan;
            }

            $plan_detail = Plans::where('plan_name_en','=',$plan->id)->first();
            $user_detail = User::where('stripe_profile_id','=',$stripe_profile_id)->first();
            //var_dump($user_detail);die;

            $current_plan = UserPlan::where('user_id','=',$user_detail->id)->where('status','=','1')->first()->update(['status'=>'0']);
            echo "success";die;

      }



    }

        /**
    * Function  paypal_track
    *
    * track the recuuring transactions
    *
    *
    * @Created Date: 04  March 2018
    * @Modified Date: 04 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  ARRAY
    * @return STRING
    */

    public function paypal_track(Request $request)
    {

        //DB::connection()->enableQueryLog();
        // Retrieve the request's body and parse it as JSON
        $due_profiles  = User::where('next_billing_date', '=', Carbon::now()->subDays(1)->toDateString())->where('status', '!=', '3')->get();
        //dd($due_profiles);
        foreach ($due_profiles as $key => $value) {

                try {

                  $PayFlow = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');

                  $PayFlow->setEnvironment('test');                           // test or live
                  $PayFlow->setTransactionType('R');       

                  $PayFlow->setProfileAction('I');
                  $PayFlow->setProfileId($value->paypal_profile_id);
                  $PayFlow->setPaymentHistory('Y');

                  if($PayFlow->processTransaction()){
                        $response = $PayFlow->getResponse();
                             
                        if($response['RESULT'] == '0'){

                            unset($response['RESULT'],$response['RPREF'],$response['PROFILEID']);
                            $final_array = [];
                            foreach($response as $keys=>$values){
                                $index = substr($keys, -1);
                                $keys = substr($keys, 0, -1);    
                                $final_array[$index][$keys] = $values; 
                            }
                            
                            end($final_array);// move the internal pointer to the end of the array
                            $lastkey = key($final_array);
                            $last_payment = $final_array[$lastkey];

                            //dd($last_payment);
                            if($last_payment['P_RESULT'] == 0){

                                $current_plan = UserPlan::where('user_id','=',$value->id)->where('status','=','1')->first();
                               //echo date('y-m-d',strtotime($last_payment['P_TRANSTIME']));
                                $payment = new Payment;
                                $payment->user_id = $value->id;
                                $payment->plan_id = $current_plan->id;
                                $payment->net_amount = $last_payment['P_AMT'];
                                $payment->transaction_id = $value->paypal_profile_id;
                                $payment->status = 1;
                                $payment->transaction_status = 'Approved';
                                $payment->transaction_type = '1';
                                $payment->payment_date = date('Y-m-d',strtotime($last_payment['P_TRANSTIME']));
                                $payment->is_recurring = '1';
                                $payment->save();

                                $user = User::find($value->id);
                                $previous_next_date = $user->next_billing_date;
                                $next_billing_date = strtotime(date("Y-m-d", strtotime($previous_next_date)) . " +1 month");
                                $user->next_billing_date = date('Y-m-d',$next_billing_date);
                                //dd($user);
                                $user->save();
                            }else{//cancel the plan

                                 $current_plan = UserPlan::where('user_id','=',$value->id)->where('status','=','1')->first()->update(['status'=>'0']);
                            }
                            }
                       // return ['status' => 'success','transaction_id'=> $response['RPREF'], 'msg' => 'plan has been subscribed to you successfully.'];
                  }else{
                      //dd($response = $PayFlow->getResponse());
                       return false;
                  }

           }catch (Exception $e) {
                return false;
            }
    }
        


    }


function GetUserInfo($access_token) {
   // $api_url = 'https://api.paypal.com/v1/oauth2/token/userinfo?schema=openid';//live
    $api_url = 'https://api.sandbox.paypal.com/v1/oauth2/token/userinfo?schema=openid';//sandbox

    $ch = curl_init();      
    //curl_setopt($ch, CURLOPT_HEADER, 1);
    //curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_URL, $api_url);        
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token, 'Content-Type: application/json')); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
    //$data = json_decode(curl_exec($ch), true);
    //$info = curl_getinfo($ch);
    $data = curl_exec($ch);
   // dd($data);
   // var_dump(curl_getinfo($ch));die;
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($http_code == 200) 
        return $data;
    else if($http_code == 404) 
        return false;
    else
        return false;
}

// $client_id - Paypal App Client ID 
// $redirect_uri - Paypal App Return URL
// $client_secret - Paypal App Secret key
// $code - OAuth code
function GetAccessToken($code) {


    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID.":".PAYPAL_CLIENT_SECRET);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

    $result = curl_exec($ch);
    curl_close($ch);

    if(empty($result))die("Error: No response.");
    else
    {
        //dd($result);
        $json = json_decode($result);
        //dd($json);
        return $json->access_token;
    }
   

  
}

public function UserConsentRedirect(Request $request){

    dd($request->all());

}
  

}
