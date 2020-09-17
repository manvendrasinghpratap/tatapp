<?php
namespace App\Http\Controllers\User;

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
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Carbon\Carbon;
use App\Http\Controllers\CommonController;



class PaymentController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct(MasterRepository $master)
  {
      $this->master=$master;
      $this->middleware('auth');
      $this->middleware('payment');//This controller is acccesssible only initial payment has been done,otherwise redirect to payment page.
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

      $this->paypal_app_id = 'AY98XaorJ3fDkV3vc4M6_tmtGUbc2iythdm3bFbVwhH72fRW0B_IatZLhzNjTqHgYon-zq7hLHJhisSu';//for auth login user
     
  }


   /**
  * Function index
  *
  * function to get you to dashboard page.
  *
  * @Created Date: 16 March 2018
  * @Modified Date: 16 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function index($id=null)
  {
    $id = base64_decode($id);
    $plan_detail = Plans::find($id);
    $current_language = \Lang::getLocale();
    $user = Auth::user();
    $starter_payment = Payment::where('user_id', '=', $user->id)
                              ->where('plan_id','=',0)
                              ->where('created_at', '>=', Carbon::now()->subDays(14)->toDateTimeString())
                              ->first();

    if(!empty($starter_payment)){
      $plan_price = $plan_detail->price - 7;
    }else{
      $plan_price = $plan_detail->price;
    }
    return view('users.buy_plan',['plan_detail' => $plan_detail,
                                  'user_detail'=>$user,
                                  'current_language' => $current_language,
                                  'publishable_key' => $this->stripe_publishable_key,
                                  'plan_price' => $plan_price
                                ]);
  }
 /**
  * Function paypal_buy
  *
  * function to handle paypal payment.
  *
  * @Created Date: 19 March 2018
  * @Modified Date: 19 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function paypal_buy(Request $request)
  {
  
           $plan_detail = Plans::find($request->plan_id);
           $user = Auth::user();
           // /dd($plan_detail);
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

              $starter_payment = Payment::where('user_id', '=', $user->id)
                              ->where('plan_id','=',0)
                              ->where('created_at', '>=', Carbon::now()->subDays(14)->toDateTimeString())
                              ->first();

              $PayFlow = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');
             // dd($PayFlow);

              $PayFlow->setEnvironment('test');                           // test or live
              $PayFlow->setTransactionType('R');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
              $PayFlow->setPaymentMethod('C');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
              $PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.

              // Only used for recurring transactions
              $PayFlow->setProfileAction('A');
              $PayFlow->setProfileName($user->first_name." ".$user->last_name);
              $profile_start_date = date('Y-m-d', strtotime("+1 day"));
              $PayFlow->setProfileStartDate(date('mdY', strtotime("+1 day")));
              $PayFlow->setProfilePayPeriod('MONT');
              $PayFlow->setProfileTerm(0);

             
              $PayFlow->setCCNumber($_POST['cardNumber']);
              $PayFlow->setCVV($_POST['CVV2']);
              $month_padded = sprintf("%02d", $_POST['month']);
              $PayFlow->setExpiration($month_padded.substr( $_POST['year'], -2 ));
              $PayFlow->setCreditCardName($_POST['BILLTOFIRSTNAME']." ".$_POST['BILLTOLASTNAME']);

              $PayFlow->setCustomerFirstName($_POST['BILLTOFIRSTNAME']);
              $PayFlow->setCustomerLastName($_POST['BILLTOLASTNAME']);
              //$PayFlow->setCustomerAddress('589 8th Ave Suite 10');
              //$PayFlow->setCustomerCity('New York');
             // $PayFlow->setCustomerState('NY');
              //$PayFlow->setCustomerZip('10018');
             // $PayFlow->setCustomerCountry('US');
             // $PayFlow->setCustomerPhone('212-123-1234');
              $PayFlow->setCustomerEmail($user->email);
              $PayFlow->setPaymentComment($plan_detail->plan_name_en);

              if(!empty($starter_payment)){

                $plan_price = $plan_detail->price - 7;
                $plan_price = number_format((float)$plan_price, 2, '.', '');
                


              }else{

                $plan_price = $plan_detail->price;
                $plan_price = number_format((float)$plan_price, 2, '.', '');

              }
              $PayFlow->setAmount($plan_detail->price,FALSE);
              $PayFlow->setOptionalTransaction('S');
              $PayFlow->setOptionalTransactionAmount($plan_price);

              if($PayFlow->processTransaction()){

                    $response = $PayFlow->getResponse();
                    //dd($response);die;
                    $user_id = Auth::user()->id;
                    $payment = new Payment;
                    $payment->user_id = $user_id;
                    $payment->plan_id = $plan_detail->id;
                    $payment->net_amount = $plan_detail->price;
                    $payment->transaction_id = $response['RPREF'];
                    $payment->status = 1;
                    $payment->transaction_status = $response['RESPMSG'];
                    $payment->transaction_type = '1';
                    $payment->payment_date = date('Y-m-d');
                    $payment->save();

                    $next_billing_date = strtotime(date("Y-m-d", strtotime($profile_start_date)) . " +1 month");

                    $user = User::find($user_id);
                    $user->paypal_profile_id = $response['PROFILEID'];
                    $user->profile_start_date = $profile_start_date;
                    $user->next_billing_date = date('Y-m-d',$next_billing_date);
                    $user->save();

                    $user_plan = new UserPlan;
                    $user_plan->user_id = $user_id;
                    $user_plan->plan_id = $plan_detail->id;
                    $user_plan->payment_id = $payment->id;
                    $user_plan->transaction_id = $response['RPREF'];
                    $user_plan->amount = $plan_detail->price;
                    $user_plan->status = '1';
                    $user_plan->save();

                    $this->genrate_invoice_pdf($user,$payment,$plan_detail->plan_name_fr);
                    $current_language = \Lang::getLocale();
                    $msg = $current_language == 'en' ? 'Plan subscribed successfully' : 'Plan souscrit avec succès';
                    
                    Session::put('pay_success_package', 'Payment success');
                    $request->session()->flash('add_message', $msg);

                    //save user's data on awebewr
                    
                    $list_id = 'awlist4929048';
                    $post = array(
                        'meta_required' => 'name,email',
                        'name' => $user->first_name.' '.$user->last_name,
                        'email' =>$user->email
                    );
                    //
                     $common_controller = new CommonController();
                     $status = $common_controller->add_to_aweber_list($post,$list_id);
                 if($status){
                  return redirect()->route('profile');
                 }
                    
                   // return ['status' => 'success','transaction_id'=> $response['RPREF'], 'msg' => 'plan has been subscribed to you successfully.'];
              }else{

                    //                 echo('<h2>Name Value Pair String:</h2>');
                    // echo('<pre>');
                    // print_r($PayFlow->debugNVP('array'));
                    // echo('</pre>');
                     
                    // echo('<h2>Response From Paypal:</h2>');
                    // echo('<pre>');
                    // print_r($PayFlow->getResponse());
                    // echo('</pre>');
                     
                    // unset($PayFlow);die;
                     $error = 'Some error occured. Please try again';
                     $request->session()->flash('add_message', $error);
                     return redirect()->route('profile');
              }

    
  }
   /**
  * Function stripe_buy
  *
  * function to handle stripe payment.
  *
  * @Created Date: 19 March 2018
  * @Modified Date: 19 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function stripe_buy(Request $request)
  {
   $plan_detail = Plans::find($request->plan_id);
   $user = Auth::user();
      try {
               
           Stripe::setApiKey($this->stripe_api_key);

            // Token is created using Checkout or Elements!
            // Get the payment token ID submitted by the form:
            $token = $_POST['stripeToken'];
            //dd($token);
            $starter_payment = Payment::where('user_id', '=', $user->id)
                              ->where('plan_id','=',0)
                              ->where('created_at', '>=', Carbon::now()->subDays(14)->toDateTimeString())
                              ->first();


            $customer = \Stripe\Customer::create(array(
              'email' => $user->email,
              'source'  => $token,
            ));
           // dd($customer);
            if(empty($starter_payment)){// if $7 payment excedd 14 days
                  $subscription = \Stripe\Subscription::create(array(
                  'customer' => $customer->id,
                  'items' => array(array('plan' => $plan_detail->plan_id_stripe)),
                ));

              $plan_price =  $plan_detail->price;
            }else{//if refund period running, deduct 7 dollar less

              $subscription = \Stripe\Subscription::create(array(
              'customer' => $customer->id,
              'items' => array(array('plan' => $plan_detail->plan_id_stripe)),
              'coupon' => 'first_plan_purchased_in_refund_period',
            ));

              $plan_price =  $plan_detail->price - 7;

            }
            



            if(isset($subscription->id) && $subscription->status == 'active'){

                //$user_id = Auth::user()->id;
                    $user_id = Auth::user()->id;
                    $payment = new Payment;
                    $payment->user_id = $user_id;
                    $payment->plan_id = $plan_detail->id;
                    $payment->net_amount = $plan_price;
                    $payment->transaction_id = $subscription->id;
                    $payment->status = 1;
                    $payment->transaction_status = 'Approved';
                    $payment->transaction_type = '2';
                    $payment->payment_date = date('Y-m-d');
                   // $payment->save();

                    $user = User::find($user_id);
                    $user->stripe_profile_id = $subscription->id;
                    $user->stripe_customer_id = $customer->id;
                    $user->save();

                    $user_plan = new UserPlan;
                    $user_plan->user_id = $user_id;
                    $user_plan->plan_id = $plan_detail->id;
                    //$user_plan->payment_id = $payment->id;
                    $user_plan->transaction_id = $subscription->id;
                    $user_plan->amount = $plan_detail->price;
                    $user_plan->status = '1';
                   
                    $user_plan->save();

                    $this->genrate_invoice_pdf($user,$payment,$plan_detail->plan_name_fr);
                    //$msg = 'Plan subscribed successfully.';
                    $current_language = \Lang::getLocale();
                    $msg = $current_language == 'en' ? 'Plan subscribed successfully' : 'Plan souscrit avec succès';
                    $request->session()->flash('add_message', $msg);
                    // save subuscripber data on aweber
                    $list_id = 'awlist4929048';
                    $post = array(
                        'meta_required' => 'name,email',
                        'name' => $user->first_name.' '.$user->last_name,
                        'email' =>$user->email
                    );
                    //
                     $common_controller = new CommonController();
                     $status = $common_controller->add_to_aweber_list($post,$list_id);
                 if($status){
                   Session::put('pay_success_package', 'Payment success');
                  return redirect()->route('profile');
                 }
                //return ['status' => 'success','transaction_id'=> $subscription->id, 'msg' => 'plan has been subscribed to you successfully'];
            }

            }catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
                $request->session()->flash('add_message', 'some error in form fields');
              return redirect()->back()->with('error','some error in form fields'); 
            }


  }


 /**
  * Function refund
  *
  * function to handle  refunding of start plan within 14 days.
  *
  * @Created Date: 19 March 2018
  * @Modified Date: 19 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function refund(Request $request)
  {
        $user = Auth::user();
        
        $starter_payment = Payment::where('user_id', '=', $user->id)
                                  ->where('plan_id','=',0)
                                  ->where('created_at', '>=', Carbon::now()->subDays(14)->toDateTimeString())
                                  ->first();
        
        if(!empty($starter_payment)){
          if($starter_payment->transaction_type==1){

            $status = $this->paypal_refund($starter_payment->transaction_id,$starter_payment->id);
            if($status){
              return redirect()->route('dashboard')->send();
            }

          }else{
          $status = $this->stripe_refund($starter_payment->transaction_id,$starter_payment->id);
          if($status){
              return redirect()->route('dashboard')->send();
            }

          }

        }else{
           $current_language = \Lang::getLocale();
           $msg = $current_language == 'en' ? 'you can only refund amount in 14 days only.' : 'vous pouvez seulement rembourser le montant en 14 jours seulement.';

           return redirect()->back()->with('error',$msg);

        }





  }



 /**
  * Function stripe_refund
  *
  * function to handle stripe refunding of start plan within 14 days.
  *
  * @Created Date: 19 March 2018
  * @Modified Date: 19 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function stripe_refund($transaction_id = null,$payment_id = null)
  {
        $user = Auth::user();
        $payment = Payment::find($payment_id);

       try {
               
           Stripe::setApiKey($this->stripe_api_key);

            $re = \Stripe\Refund::create(array(
              "charge" => $transaction_id
            ));
            if(isset($re->id) && $re->status == 'succeeded'){
                $user = User::find($user->id);
                $user->status = '3';
                //$user->save();

                $payment->refund_status = '1';
                $payment->save();
                sendrefundEmail($user->id);
                return true;
                //return redirect()->route('profile')->send();
            }

            }catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
                $request->session()->flash('add_message', 'some error in refunding');
              return redirect()->back()->with('error','some error in form fields'); 
            }


  }


   /**
  * Function paypal_refund
  *
  * function to handle paypal refunding of start plan within 14 days.
  *
  * @Created Date: 19 March 2018
  * @Modified Date: 19 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function paypal_refund($transaction_id = null,$payment_id = null)
  {

      $payment = Payment::find($payment_id);
      $user = Auth::user();
      //dd($user);
        
       try {
               
              $user_name = $this->paypal_user_name; // API User Username
              $password = $this->paypal_password; // API User Password
              $vendor = $this->paypal_vendor; // Merchant Login ID
              // Reseller who registered you for Payflow or 'PayPal' if you registered
              // directly with PayPal
              $partner = $this->paypal_partner; 

              $sandbox = $this->paypal_sandbox;

              $transactionId = $payment->transaction_id; // The PNREF # returned when the card was charged
              $amount = $payment->net_amount;
              $currency = 'USD';

              $url = $sandbox ? 'https://pilot-payflowpro.paypal.com'
                : 'https://payflowpro.paypal.com';

              $params = array(
                'USER' => $user_name,
                'VENDOR' => $vendor,
                'PARTNER' => $partner,
                'PWD' => $password,
                'TENDER' => 'C', // C = credit card, P = PayPal
                'TRXTYPE' => 'C', //  S=Sale, A= Auth, C=Credit, D=Delayed Capture, V=Void                        
                'ORIGID' => $transactionId,
                'AMT' => $amount,
                'CURRENCY' => $currency
              );

              $data = '';
              $i = 0;
              foreach ($params as $n=>$v) {
                  $data .= ($i++ > 0 ? '&' : '') . "$n=" . urlencode($v);
              }

              $headers = array();
              $headers[] = 'Content-Type: application/x-www-form-urlencoded';
              $headers[] = 'Content-Length: ' . strlen($data);

              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
              curl_setopt($ch, CURLOPT_HEADER, $headers);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

              $result = curl_exec($ch);
              curl_close($ch);

              // Parse results
              $response = array();
              $result = strstr($result, 'RESULT');    
              $valArray = explode('&', $result);
              foreach ($valArray as $val) {
                $valArray2 = explode('=', $val);
                $response[$valArray2[0]] = $valArray2[1];
              }
              //print_r($response);
              if (isset($response['RESULT']) && $response['RESULT'] == 0) {
                       //dd($user);
                      $user = User::find($user->id);
                      $user->status = '3';
                     // $user->save();

                      $payment->refund_status = '1';
                      $payment->save();
                     // Auth::logout();
                      sendrefundEmail($user->id);
                      return true;
                 
              } else {
                return redirect()->back()->with('error','some error in refunding'); 
              }

         
       
            }catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
              return redirect()->back()->with('error','some error in refunding'); 
            }


  }
 /**
  * Function change_plan
  *
  * function to handle  switching of plan.
  *
  * @Created Date: 20 March 2018
  * @Modified Date: 20 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function change_plan(Request $request,$id = null)
  {

         $id = base64_decode($id);
         $user = Auth::user();
         $plan_to_switch = Plans::find($id);
         //dd($id);
         $current_plan  = UserPlan::where('user_id','=',$user->id)
                                  ->where('status','=','1')
                                  ->with('payment')
                                  ->first();
         $current_plan_payment = $current_plan->payment;

          if(empty($current_plan_payment)){
            //$msg = 'Payment not processed yet.Please try again later.';
            $current_language = \Lang::getLocale();
            $msg = $current_language == 'en' ? 'Payment not processed yet. Please try again later.' : 'Le paiement na pas encore été traité. Veuillez réessayer plus tard.';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('profile');
         }


         if($current_plan_payment->transaction_type == '1'){
          
          $status = $this->paypal_switching($plan_to_switch);
          if(!$status){
            $current_language = \Lang::getLocale();
             $msg = $current_language == 'en' ? 'Payment not processed yet. Please try again later' : 'Le paiement na pas encore été traité. Veuillez réessayer plus tard';
          $request->session()->flash('error_message', $msg);
          return redirect()->route('profile');
          }


          //session(['add_message' => 'Plan changed successfully']);
          return redirect()->route('profile');

         }

         if($current_plan_payment->transaction_type == '2'){

          $status = $this->stripe_switching($plan_to_switch);

          //session(['add_message' => 'Plan changed successfully']);
          return redirect()->route('profile');
              

         }

        
}


 /**
  * Function paypal_switching
  *
  * function to switch plans (upgrade and downgrade) plans with paypal.
  *
  * @Created Date: 21 March 2018
  * @Modified Date: 21 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function paypal_switching($plan_detail = null)
  {

      
      $user = Auth::user();
      $user_id = Auth::user()->id;
      //dd($user);die;
     
       try {

          // $PayFlow = new PayFlow('digitalkheops511','PayPal', 'digitalkheops511', 'digitalkheops511', 'digitalkheops511', 'recurring');
            $current_plan_detail = UserPlan::where('user_id','=',$user_id)
                                                ->where('status','=','1')
                                                ->first();

            $refund_amount = $current_plan_detail->amount > $plan_detail->price ? true : false;//refund the difference
            $plan_price = $plan_detail->price;
            //dd($plan_detail->price);
             $PayFlow = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');
             // dd($PayFlow);

              $PayFlow->setEnvironment('test');                           // test or live
              $PayFlow->setTransactionType('R');                      // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.

              // Only used for recurring transactions
              $PayFlow->setProfileAction('M');
              $PayFlow->setPaymentComment($plan_detail->plan_name_en);
              $PayFlow->setAmount($plan_detail->price,FALSE);

              if(!$refund_amount){

                $diffrence_to_charge =  $plan_detail->price - $current_plan_detail->amount;
                $PayFlow->setOptionalTransaction('S');
                $PayFlow->setOptionalTransactionAmount($diffrence_to_charge);
                
                $plan_price = number_format((float)$diffrence_to_charge, 2, '.', '');;
                //dd($plan_price);
              }

              $PayFlow->setProfileId($user->paypal_profile_id);

              if($PayFlow->processTransaction()){
                    
                    $response = $PayFlow->getResponse();

                    if($refund_amount){ // refund the amount in case of downgrade the plan
                        $amount_to_refund =  $current_plan_detail->amount - $plan_detail->price;
                        $PayFlowNew = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');

                        $PayFlowNew->setEnvironment('test');  
                        $PayFlowNew->setTransactionType('R');
                        $PayFlowNew->setProfileAction('I');
                        $PayFlowNew->setProfileId($user->paypal_profile_id);
                        $PayFlowNew->setPaymentHistory('O');

                        if($PayFlowNew->processTransaction()){
                              $responseNew = $PayFlowNew->getResponse();
                              //dd($responseNew);
                              if($responseNew['RESULT'] == '0'){

                                      unset($responseNew['RESULT'],$responseNew['RPREF'],$responseNew['PROFILEID']);
                                       if(empty($responseNew)){
                                        return false;
                                       }
                                      $final_array = [];
                                      foreach($responseNew as $keys=>$values){
                                          $index = substr($keys, -1);
                                          $keys = substr($keys, 0, -1);    
                                          $final_array[$index][$keys] = $values; 
                                      }
                                      
                                      end($final_array);// move the internal pointer to the end of the array
                                      $keyy = key($final_array);
                                      $last_payment = $final_array[$keyy];
                                     
                                      if($last_payment['P_RESULT'] != '0' ){
                                        return false;
                                      }

                                      
                                      if($last_payment['P_RESULT'] == 0){

                                            $refunded = $this->refund_pay_pal_transaction($last_payment['P_PNREF'],$plan_detail,null,$amount_to_refund);
                                            //dd($refunded);
                                            if(!$refunded){
                                                return false;
                                              }

                                            }else{

                                           return false;
                                      }
                                      

                                 

                              }else{
                                return true;
                                 $responseNew = $PayFlowNew->getResponse();
                                 dd($responseNew);
                              }

                             
                              
                             
                             // return ['status' => 'success','transaction_id'=> $response['RPREF'], 'msg' => 'plan has been subscribed to you successfully.'];
                        }else{
                            // $response = $PayFlow->getResponse();
                            //   dd($response);
                             return false;
                        }
                        
                    }


                    $current_plan = UserPlan::where('user_id','=',$user_id)
                                            ->where('status','=','1')
                                            ->first()
                                            ->update(['status'=>'0']);

                    
                    $payment = new Payment;
                    $payment->user_id = $user_id;
                    $payment->plan_id = $plan_detail->id;
                    $payment->net_amount = $plan_price;
                    $payment->transaction_id = $response['RPREF'];
                    $payment->status = 1;
                    $payment->transaction_status = $response['RESPMSG'];
                    $payment->transaction_type = '1';
                    $payment->payment_date = date('Y-m-d');
                    $payment->save();

                    $user_plan = new UserPlan;
                    $user_plan->user_id = $user_id;
                    $user_plan->plan_id = $plan_detail->id;
                    $user_plan->payment_id = $current_plan_detail->payment_id;
                    $user_plan->transaction_id = $response['RPREF'];
                    $user_plan->amount = $plan_detail->price;
                    $user_plan->status = '1';
                    $user_plan->save();

                    

                    if(!$refund_amount){
                    $this->update_again($plan_detail);
                    $this->genrate_invoice_pdf($user,$payment,$plan_detail->plan_name_fr);
                    }
                    

                    //$this->genrate_invoice_pdf($user,$payment);
                    return true;
                   // return ['status' => 'success','transaction_id'=> $response['RPREF'], 'msg' => 'plan has been subscribed to you successfully.'];
              }else{

                   return true;
              }

       }catch (Exception $e) {
            return false;
        }


  }


   /**
  * Function update_again
  *
  * function to update paypal plan again.
  *
  * @Created Date: 26 april 2018
  * @Modified Date: 21 april 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function update_again($plan_detail = null)
  {

      
      $user = Auth::user();
      $user_id = Auth::user()->id;
      //dd($user);die;
     
       try {

          // $PayFlow = new PayFlow('digitalkheops511','PayPal', 'digitalkheops511', 'digitalkheops511', 'digitalkheops511', 'recurring');
            $current_plan_detail = UserPlan::where('user_id','=',$user_id)
                                                ->where('status','=','1')
                                                ->first();
            $plan_price = $plan_detail->price;
            //dd($plan_detail->price);
             $PayFlow = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');
             // dd($PayFlow);

              $PayFlow->setEnvironment('test');                           // test or live
              $PayFlow->setTransactionType('R');                      // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.

              // Only used for recurring transactions
              $PayFlow->setProfileAction('M');
              $PayFlow->setPaymentComment($plan_detail->plan_name_en);
              $PayFlow->setAmount($plan_detail->price,FALSE);
              $PayFlow->setProfileId($user->paypal_profile_id);
              $next_billing_date = date('mdY', strtotime("+1 month"));
              $PayFlow->setProfileStartDate($next_billing_date);
              
             // dd($next_billing_date);

              if($PayFlow->processTransaction()){
                    
                    $response = $PayFlow->getResponse();

                    $user = User::find($user_id);
                    $user->next_billing_date = date('Y-m-d',$next_billing_date);
                    $user->save();
                    
                    //$this->genrate_invoice_pdf($user,$payment);
                    return true;
                   // return ['status' => 'success','transaction_id'=> $response['RPREF'], 'msg' => 'plan has been subscribed to you successfully.'];
              }else{

                   return true;
              }

       }catch (Exception $e) {
            return false;
        }


  }

   /**
  * Function stripe_switching
  *
  * function to switch plans (upgrade and downgrade) plans with stripe.
  *
  * @Created Date: 21 March 2018
  * @Modified Date: 21 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function stripe_switching($plan_detail = null)
  {
      $user = Auth::user();
      $user_id = Auth::user()->id;  
       try {

          Stripe::setApiKey($this->stripe_api_key);

          $subscription = \Stripe\Subscription::retrieve($user->stripe_profile_id);

          $change_status = \Stripe\Subscription::update($user->stripe_profile_id, [
              'items' => [
                  [
                      'id' => $subscription->items->data[0]->id,
                      'plan' => $plan_detail->plan_id_stripe
                  ],
              ],
              'prorate' => true,
          ]);
           $invoice =  \Stripe\Invoice::create(array(
              'customer' => $user->stripe_customer_id
          ));
        //dd($change_status);

            if(isset($change_status->id) && $change_status->status == 'active'){

              $current_plan_detail = UserPlan::where('user_id','=',$user_id)
                                            ->where('status','=','1')
                                            ->first();

               $current_plan = UserPlan::where('user_id','=',$user_id)
                                       ->where('status','=','1')
                                       ->first()
                                       ->update(['status'=>'0']);
               $amount =  0;
               if($current_plan_detail->amount < $plan_detail->price ){

                  $amount = $plan_detail->price - $current_plan_detail->amount;

               }                       

                   
                    $payment = new Payment;
                    $payment->user_id = $user_id;
                    $payment->plan_id = $plan_detail->id;
                    $payment->net_amount = $amount;
                    $payment->transaction_id = $subscription->id;
                    $payment->status = 1;
                    $payment->transaction_status = 'Approved';
                    $payment->transaction_type = '2';
                    $payment->payment_date = date('Y-m-d');
                    //$payment->save();

                    $user = User::find($user_id);
                    $user->stripe_profile_id = $subscription->id;
                    $user->save();

                    $user_plan = new UserPlan;
                    $user_plan->user_id = $user_id;
                    $user_plan->plan_id = $plan_detail->id;
                    $user_plan->payment_id = $current_plan_detail->payment_id;
                    $user_plan->transaction_id = $subscription->id;
                    $user_plan->amount = $plan_detail->price;
                    $user_plan->status = '1';
                    $user_plan->save();
                    if($amount){
                      
                      $this->genrate_invoice_pdf($user,$payment,$plan_detail->plan_name_fr);
                    }
                    
                  return true;
            }else{
              return false;
            }

       }catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
              return redirect()->back()->with('error','some error in refunding'); 
        }


  }

  /**
  * Function cancel_plan
  *
  * function to handle  cancel of plan.
  *
  * @Created Date: 20 March 2018
  * @Modified Date: 20 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function cancel_plan(Request $request)
  {

         $user = Auth::user();
         $current_plan  = UserPlan::where('user_id','=',$user->id)
                                  ->where('status','=','1')
                                  ->with('payment')
                                  ->with('plan')
                                  ->first();
         $current_plan_payment = $current_plan->payment;
         $current_plan_detail = $current_plan->plan;
         //dd($current_plan_detail);

         if(empty($current_plan_payment)){
            //$msg = 'Payment not processed yet.Please try again later.';
             $current_language = \Lang::getLocale();
            $msg = $current_language == 'en' ? 'Payment not processed yet. Please try again later.' : 'Le paiement na pas encore été traité. Veuillez réessayer plus tard.';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('profile');
         }


         if($current_plan_payment->transaction_type == '1'){
          
          $status = $this->paypal_cancel_plan($current_plan_detail);

             if($status){
               // $msg = 'Plan cancelled successfully.';

                 $current_language = \Lang::getLocale();
                 $msg = $current_language == 'en' ? 'Plan cancelled successfully.' : 'Plan annulé avec succès.';
                $request->session()->flash('add_message', $msg);
                return redirect()->route('profile');
              }else{
                $msg = 'Something went wrong. Please try again';
                $request->session()->flash('add_message', $msg);
                return redirect()->route('profile');
              }

         }

         if($current_plan_payment->transaction_type == '2'){
          $status = $this->stripe_cancel_plan($current_plan_detail);

          if($status){
                $current_language = \Lang::getLocale();
                $msg = $current_language == 'en' ? 'Plan cancelled successfully.' : 'Plan annulé avec succès.';
                $request->session()->flash('add_message', $msg);
                return redirect()->route('profile');
          }else{
            $msg = 'Something went wrong. Please try again';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('profile');
          }


        }

        
}


 /**
  * Function paypal_cancel_plan
  *
  * function to switch plans (upgrade and downgrade) plans with paypal.
  *
  * @Created Date: 21 March 2018
  * @Modified Date: 21 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function paypal_cancel_plan($plan_detail = null)
  {

      
      $user = Auth::user();
      //dd($user);die;
     
       try {

         // $PayFlow = new PayFlow('digitalkheops511','PayPal', 'digitalkheops511', 'digitalkheops511', 'digitalkheops511', 'recurring');
             // dd($PayFlow);

             $PayFlow = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');

              $PayFlow->setEnvironment('test');                           // test or live
              $PayFlow->setTransactionType('R');                      // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.

              // Only used for recurring transactions
              $PayFlow->setProfileAction('C');

              $PayFlow->setAmount($plan_detail->price,FALSE);
              $PayFlow->setPaymentComment($plan_detail->plan_name_en);
              $PayFlow->setProfileId($user->paypal_profile_id);

              if($PayFlow->processTransaction()){
                    $user_id = Auth::user()->id;
                    $response = $PayFlow->getResponse();
                    $current_plan = UserPlan::where('user_id','=',$user_id)
                                            ->where('user_id','=',$user_id)
                                            ->where('status','=','1')
                                            ->first()
                                            ->update(['status'=>'0']);
                     $list_id = 'awlist4929048';
                      $post = array(
                          'email' =>$user->email
                      );
                    //
                     $common_controller = new CommonController();
                     //$status = $common_controller->delete_from_aweber_list($post,$list_id);
                    
                    return true;
                   // return ['status' => 'success','transaction_id'=> $response['RPREF'], 'msg' => 'plan has been subscribed to you successfully.'];
              }else{
                  //dd($response = $PayFlow->getResponse());
                   return false;
              }

       }catch (Exception $e) {
            return false;
        }


  }



 /**
  * Function stripe_cancel_plan
  *
  * function to handle stripe  canceleation plan.
  *
  * @Created Date: 21 March 2018
  * @Modified Date: 21 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function stripe_cancel_plan($plan_detail = null)
  {
        $user = Auth::user();

       try {
               
           Stripe::setApiKey($this->stripe_api_key);

            $subscription = \Stripe\Subscription::retrieve($user->stripe_profile_id);
            $re = $subscription->cancel();

            if(isset($re->id) && $re->status == 'canceled'){
               $current_plan = UserPlan::where('user_id','=',$user->id)
                                       ->where('status','=','1')
                                       ->first()
                                       ->update(['status'=>'0']);
               $list_id = 'awlist4929048';
                $post = array(
                    'email' =>$user->email
                );
              //
               $common_controller = new CommonController();
             //  $status = $common_controller->delete_from_aweber_list($post,$list_id);
               return true;
            }else{
              return false;
            }

            }catch (Exception $e) {
              return false;
            }


  }


    /**
  * Function cancel_refund_plan
  *
  * function to handle  cancel and refund of plan.
  *
  * @Created Date: 20 March 2018
  * @Modified Date: 20 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function cancel_refund_plan(Request $request)
  {

         $user = Auth::user();
         $current_language = \Lang::getLocale();
         $current_plan  = UserPlan::where('user_id','=',$user->id)
                                  ->where('status','=','1')
                                  ->with('payment')
                                  ->with('plan')
                                  ->first();
         $current_plan_payment = $current_plan->payment;
         $current_plan_detail = $current_plan->plan;
         

         if(empty($current_plan_payment)){
            $msg = 'Payment not processed yet. Please try again later.';
            $request->session()->flash('error_message', $msg);
            return redirect()->route('profile');
         }


         if($current_plan_payment->transaction_type == '1'){
          
          $status = $this->paypal_cancel_refund_plan($current_plan_detail,$current_plan_payment);
          //dd($status);
             if($status){
              $msg = $current_language == 'en' ? 'Plan cancelled and refunded successfully.' : 'Plan annulé et remboursé avec succès.';
                $request->session()->flash('add_message', $msg);
                return redirect()->route('profile');
              }else{
                $msg = $current_language == 'en' ? 'Payment not processed yet. Please try again later' : 'Le paiement na pas encore été traité. Veuillez réessayer plus tard';

                $request->session()->flash('error_message', $msg);
                return redirect()->route('profile');
              }

         }

         if($current_plan_payment->transaction_type == '2'){
          $status = $this->stripe_cancel_refund_plan($current_plan_detail);

          if($status){
                 $msg = $current_language == 'en' ? 'Plan cancelled and refunded successfully.' : 'Plan annulé et remboursé avec succès.';
                $request->session()->flash('add_message', $msg);
                return redirect()->route('profile')->send();
          }else{
           $msg = $current_language == 'en' ? 'Payment not processed yet. Please try again later' : 'Le paiement na pas encore été traité. Veuillez réessayer plus tard';
          $request->session()->flash('error_message', $msg);
          return redirect()->route('profile');
          }


        }

        
}

 /**
  * Function paypal_cancel_refund_plan
  *
  * function to cancle paypal plans and refund amount to user.
  *
  * @Created Date: 18 April 2018
  * @Modified Date: 18 April 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function paypal_cancel_refund_plan($plan_detail = null,$current_plan_payment = null)
  {

      
      $user = Auth::user();
      //dd($user);die;
     
       try {


             $PayFlow = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');

              $PayFlow->setEnvironment('test');  
              $PayFlow->setTransactionType('R');
              $PayFlow->setProfileAction('I');
              $PayFlow->setProfileId($user->paypal_profile_id);
              $PayFlow->setPaymentHistory('O');

              if($PayFlow->processTransaction()){
                    $response = $PayFlow->getResponse();
                   
                    if($response['RESULT'] == '0'){

                            unset($response['RESULT'],$response['RPREF'],$response['PROFILEID']);
                           if(empty($response)){
                            return false;
                           }
                            $final_array = [];
                            foreach($response as $keys=>$values){
                                $index = substr($keys, -1);
                                $keys = substr($keys, 0, -1);    
                                $final_array[$index][$keys] = $values; 
                            }
                            
                           // end($final_array);// move the internal pointer to the end of the array
                            $keyy = key($final_array);

                           
                            $last_payment = $final_array[$keyy];

                            if(count($final_array) > 1){
                              end($final_array);
                               $key = key($final_array);
                              $previous_payment =   $final_array[$key];
                            }else{
                             //dd($last_payment);
                              $previous_payment = $last_payment;
                            }
                            
                            if($last_payment['P_RESULT'] == 0){
                              
                             //var_dump($status);die;
                              

                                if(!empty($previous_payment) && $plan_detail->id == 2){
                                  $refunded = $this->refund_pay_pal_transaction($last_payment['P_PNREF'],$plan_detail,$current_plan_payment,$last_payment['P_AMT']);
                                  if(!$refunded){
                                      return false;
                                    }

                                    if($previous_payment == $last_payment){

                                      $current_plan = UserPlan::where('user_id','=',$user->id)
                                                                      ->where('status','=','1')
                                                                      ->first()
                                                                      ->update(['status'=>'0']);
                                      return true;//return from here if both have same value.
                                    }

                                    // switch to previous plan

                                     $plan_id = $plan_detail->id == 1 ? 2 : 1;
                                      //dd($current_plan_detail);
                                      $plan_detail_to = Plans::find($plan_id);
                                      $current_plan_detail = UserPlan::where('user_id','=',$user->id)
                                                                            ->where('status','=','1')
                                                                            ->first();

                                      $PayFlowNew = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');
                                       // dd($PayFlow);

                                        $PayFlowNew->setEnvironment('test');                           // test or live
                                        $PayFlowNew->setTransactionType('R');                      // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.

                                        // Only used for recurring transactions
                                        $PayFlowNew->setProfileAction('M');
                                        $PayFlowNew->setPaymentComment($plan_detail_to->plan_name_en);
                                        $PayFlowNew->setAmount($plan_detail_to->price,FALSE);

                                        
                                        $PayFlowNew->setProfileId($user->paypal_profile_id);

                                        if($PayFlowNew->processTransaction()){
                                              
                                              $responseNew = $PayFlowNew->getResponse();
                                              //dd($responseNew['RPREF']);
                                              $current_plan = UserPlan::where('user_id','=',$user->id)
                                                                      ->where('status','=','1')
                                                                      ->first()
                                                                      ->update(['status'=>'0']);

                                              $user_plan = new UserPlan;
                                              $user_plan->user_id = $user->id;
                                              $user_plan->plan_id = $plan_detail_to->id;
                                              $user_plan->payment_id = $current_plan_detail->payment_id;
                                              $user_plan->transaction_id = @$responseNew['RPREF'];
                                              $user_plan->amount = $plan_detail_to->price;
                                              $user_plan->status = '1';
                                              $user_plan->save();
                                              return true;
                                             // return ['status' => 'success','transaction_id'=> $response['RPREF'], 'msg' => 'plan has been subscribed to you successfully.'];
                                        }else{
                                              $response = $PayFlow->getResponse();
                                              //dd($response);
                                             return false;
                                        }
                                    
                                }else{

                                  $starter_payment = Payment::where('user_id', '=', $user->id)
                                                              ->where('plan_id','=',0)
                                                              ->where('created_at', '>=', Carbon::now()->subDays(14)->toDateTimeString())
                                                              ->first();

                                    $current_plan_detail = UserPlan::where('user_id','=',$user->id)
                                                                            ->where('status','=','1')
                                                                            ->first();
                                    if(!empty($starter_payment)){
                                        $refund_amount = $current_plan_detail->amount - 7;
                                        $refund_amount = number_format((float)$refund_amount, 2, '.', '');
                                    }else{
                                        $refund_amount = $current_plan_detail->amount;
                                        $refund_amount = number_format((float)$refund_amount, 2, '.', '');
                                    }

                                  $refunded = $this->refund_pay_pal_transaction($previous_payment['P_PNREF'],$plan_detail,$current_plan_payment,$refund_amount);

                                    if(!$refunded){
                                      return false;
                                    }

                                    


                                   $PayFlowNew = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');

                                    $PayFlowNew->setEnvironment('test');                           // test or live
                                    $PayFlowNew->setTransactionType('R');                      // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.

                                    // Only used for recurring transactions
                                    $PayFlowNew->setProfileAction('C');

                                    $PayFlowNew->setAmount($plan_detail->price,FALSE);
                                    $PayFlowNew->setPaymentComment($plan_detail->plan_name_en);
                                    $PayFlowNew->setProfileId($user->paypal_profile_id);

                                    if($PayFlowNew->processTransaction()){
                                        
                                          $user_id = Auth::user()->id;
                                          $response = $PayFlowNew->getResponse();
                                          $current_plan = UserPlan::where('user_id','=',$user_id)
                                                                  ->where('status','=','1')
                                                                  ->first()
                                                                  ->update(['status'=>'0']);
                                          return true;
                                         // return ['status' => 'success','transaction_id'=> $response['RPREF'], 'msg' => 'plan has been subscribed to you successfully.'];
                                    }else{
                                       //dd($responseNew = $PayFlow->getResponse());
                                         return false;
                                    }

                                }

                                   


                              
                              

                            }else{

                                 return false;
                            }
                            

                       

                    }else{
                      return false;
                    }

                   
                    
                   
                   // return ['status' => 'success','transaction_id'=> $response['RPREF'], 'msg' => 'plan has been subscribed to you successfully.'];
              }else{
                  // $response = $PayFlow->getResponse();
                  //   dd($response);
                   return false;
              }



       }catch (Exception $e) {
            return false;
        }


  }


  public function refund_pay_pal_transaction($origid = null,$plan_detail=null,$current_plan_payment=null,$amount = null){
              $user = Auth::user();
              $PayFlow = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');
              $PayFlow->setEnvironment('test');                           // test or live
              $PayFlow->setTransactionType('C');
              $PayFlow->setPaymentMethod('C');                      // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
              // Only used for recurring transactions
              $PayFlow->setProfileAction('C');
              $PayFlow->setPaymentComment('Refund');
              $PayFlow->setOrigid($origid);
             //dd($amount);

              // $starter_payment = Payment::where('user_id', '=', $user->id)
              //                 ->where('plan_id','=',0)
              //                 ->where('created_at', '>=', Carbon::now()->subDays(14)->toDateTimeString())
              //                 ->first();
              //   if(!empty($starter_payment)){

              //       $plan_price = $plan_detail->price - 7;
              //       $plan_price = number_format((float)$plan_price, 2, '.', '');
                                
              //   }else{

              //     $plan_price = $plan_detail->price;
              //     $plan_price = number_format((float)$plan_price, 2, '.', '');

              //   }
             // dd($amount);
              $PayFlow->setAmount($amount,FALSE);

              if($PayFlow->processTransaction()){
                    $response = $PayFlow->getResponse();
                    //dd($response);
                    if($response['RESULT'] == '0'){
                       return true;
                       
                      }else{
                      return false;
                    }

                   
                    
                   
                   // return ['status' => 'success','transaction_id'=> $response['RPREF'], 'msg' => 'plan has been subscribed to you successfully.'];
              }else{
                   $response = $PayFlow->getResponse();
                  //dd($response);
                   return false;
              }

  }



 /**
  * Function stripe_cancel_refund_plan
  *
  * function to handle stripe  canceleationn and refund of  plan.
  *
  * @Created Date: 18 April 2018
  * @Modified Date: 21 April 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function stripe_cancel_refund_plan($plan_detail = null)
  {
        $user = Auth::user();

       try {

         Stripe::setApiKey($this->stripe_api_key);
         $subscriptionId = $user->stripe_profile_id;
         $objInvoiceCollection = \Stripe\Invoice::all([
            'subscription' => $subscriptionId
        ]);


        //dd($objInvoiceCollection->data);
        $invoices = $objInvoiceCollection->data;
        foreach ($invoices as $key => $value) {
          # code...
           $charge = $value->charge;
           $refund = \Stripe\Refund::create(array(
              "charge" => $charge
            ));
        }
        $subscription = \Stripe\Subscription::retrieve($user->stripe_profile_id);
        $subscription_cancel = $subscription->cancel();

        if(isset($subscription_cancel->id) && $subscription_cancel->status == 'canceled'){
           $current_plan = UserPlan::where('user_id','=',$user->id)
                                   ->where('status','=','1')
                                   ->first()
                                   ->update(['status'=>'0']);
           return true;
        }else{
          return false;
        }

        }catch (Exception $e) {
          return false;
        }


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
        $file_name = $user->first_name.time().'_invoice.pdf';
        $pdf->save(public_path().'/invoice/'.$file_name);
        $pathToFile = public_path().'/invoice/'.$file_name;

        $userEmailID = $user->email; 
        $userName = $user->first_name; 

        if ($user) { 

                    $template = template_by_variable('paymentcompleted');
                    $emaildata['site_title'] = get_option('site_title'); 
                    $emaildata['admin_email'] = get_option('email'); 
                    $signature = get_option('email_signature'); 
                     
                    $emaildata['subject'] = $template->subject; 
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
                        $message->subject($emaildata['subject']); 
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
    * Function authenticate_user
    *
    * Function to authentication users paypal and stripe (UI)
    *
    *
    * @Created Date: 27 March 2018
    * @Modified Date: 27 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    */
    public function authenticate_user(Request $request) {


    $current_language = \Lang::getLocale();
    $user = Auth::user();
    if(Auth::user()->is_free_member == '1'){
      $user_plan = get_free_plan();
      
    }else{
      $user_plan = get_my_plan();  
    }
    
    $current_paypal_detail = PaypalDetail::where('user_id','=',Auth::user()->id)->where('status','=','1')->first();

    $current_stripe_detail = StripeDetail::where('user_id','=',Auth::user()->id)->where('status','=','1')->first();

    $redirect_url = route('paypal_auth');

    return view('users.account-verify',['my_plan'=>$user_plan,'user_detail'=>$user,'current_language' => $current_language,'redirect_url'=>$redirect_url,'current_paypal_detail'=>$current_paypal_detail,'current_stripe_detail'=>$current_stripe_detail,'stripe_client_secret_key'=>$this->stripe_client_secret_key,'paypal_app_id' => $this->paypal_app_id]);

    }
    


    /**
    * Function delete_paypal_account
    *
    * Function to delete paypal account detail
    *
    *
    * @Created Date: 27 March 2018
    * @Modified Date: 27 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    */
    public function delete_paypal_account(Request $request) {

          $current_paypal_detail = PaypalDetail::where('user_id','=',Auth::user()->id)
                                                ->where('status','=','1')
                                                ->first();
                    
                    if(!empty($current_paypal_detail)){
                        $current_paypal_detail = PaypalDetail::where('user_id','=',Auth::user()->id)
                                                             ->where('status','=','1')
                                                             ->first()
                                                             ->update(['status'=>'3']);
                    }


         $msg = 'Paypal account deleted successfully.';
         $current_language = \Lang::getLocale();
         $msg = $current_language == 'en' ? 'Paypal account deleted successfully.' : 'Compte Paypal supprimé avec succès.';
         $request->session()->flash('add_message', $msg);
         
         return redirect()->route('profile');

    }
  

      /**
    * Function delete_stripe_account
    *
    * Function to delete stripe account detail
    *
    *
    * @Created Date: 27 March 2018
    * @Modified Date: 27 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    */
    public function delete_stripe_account(Request $request) {

        $current_stripe_detail = StripeDetail::where('user_id','=',Auth::user()->id)
                                             ->where('status','=','1')
                                             ->first();
            
        if(!empty($current_stripe_detail)){
            $current_stripe_detail = StripeDetail::where('user_id','=',Auth::user()->id)
                                                 ->where('status','=','1')
                                                 ->first()
                                                 ->update(['status'=>'3']);
        }

         $current_language = \Lang::getLocale();
         $msg = $current_language == 'en' ? 'Stripe account deleted successfully.' : 'Compte Stripe supprimé avec succès.';
         $request->session()->flash('add_message', $msg);

         return redirect()->route('profile');

    }
 /**
    * Function stripe_card_update
    *
    * Function to updtae stripe account detail
    *
    *
    * @Created Date: 17 April 2018
    * @Modified Date: 27 April 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    */
    public function stripe_card_update(Request $request){
      $user = Auth::user();

      Stripe::setApiKey($this->stripe_api_key);

      // Token is created using Checkout or Elements!
      // Get the payment token ID submitted by the form:
     
      if (isset($_POST['stripeToken'])){
          try {
            $cu = \Stripe\Customer::retrieve($user->stripe_customer_id); // stored in your application
            $cu->source = $_POST['stripeToken']; // obtained with Checkout
            $cu->save();

            //$msg = 'Stripe account updated successfully.';
            $current_language = \Lang::getLocale();
            $msg = $current_language == 'en' ? 'Stripe account updated successfully.' : 'Stripe compte mis à jour avec succès.';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('profile');
          }
          catch(\Stripe\Error\Card $e) {

            // Use the variable $error to save any errors
            // To be displayed to the customer later in the page
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $error = $err['message'];
            $request->session()->flash('add_message', $error);
            return redirect()->route('profile');
          }
          // Add additional error handling here as needed
        }

    }


     /**
    * Function paypal_card_update
    *
    * Function to updtae paypal account detail
    *
    *
    * @Created Date: 17 April 2018
    * @Modified Date: 17 April 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    */
    public function paypal_card_update(Request $request){
      $user = Auth::user();


      // Token is created using Checkout or Elements!
      // Get the payment token ID submitted by the form:
     
           // /dd($plan_detail);
           $current_plan  = UserPlan::where('user_id','=',$user->id)
                                    ->where('status','=','1')
                                    ->with('plan')
                                    ->first();
           $current_plan_detail = $current_plan->plan;
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

              $PayFlow = new PayFlow($this->paypal_vendor,$this->paypal_partner, $this->paypal_user_name, $this->paypal_password, 'recurring');
             // dd($PayFlow);

              $PayFlow->setEnvironment('test');                           // test or live
              $PayFlow->setTransactionType('R');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
              $PayFlow->setPaymentMethod('C');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
              $PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
              // Only used for recurring transactions
              $PayFlow->setProfileAction('M');// modify
              $PayFlow->setProfileId($user->paypal_profile_id);
              $PayFlow->setCCNumber($_POST['cardNumber']);
              $PayFlow->setCVV($_POST['CVV2']);
              $PayFlow->setCreditCardName($_POST['BILLTOFIRSTNAME']." ".$_POST['BILLTOLASTNAME']);

              $PayFlow->setCustomerFirstName($_POST['BILLTOFIRSTNAME']);
              $PayFlow->setCustomerLastName($_POST['BILLTOLASTNAME']);
              $month_padded = sprintf("%02d", $_POST['month']);
              $PayFlow->setExpiration($month_padded.substr( $_POST['year'], -2 ));
              $PayFlow->setCustomerEmail($user->email);
              $PayFlow->setAmount($current_plan_detail->price,FALSE);

              if($PayFlow->processTransaction()){
                 $response = $PayFlow->getResponse();
                  //dd($response);die;
                 // $msg = 'Card Detail updated successfully.';
                 $current_language = \Lang::getLocale();
                 $msg = $current_language == 'en' ? 'Paypal account updated successfully.' : 'Paypal compte mis à jour avec succès.';
                 $request->session()->flash('add_message', $msg);
                 return ['status' => 'true', 'msg' => 'Card updated successfully.'];
              }else{
                     return ['status' => 'false', 'msg' => 'Something went wrong'];

              }

    }
  

  

  

}
