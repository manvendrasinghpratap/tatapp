<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Mail;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
//use App\Background;

class ForgotController extends Controller {

    /**
    * Function forgot_password
    *
    * function to load forgot password page and send reset link
    *
    * @Created Date: 17 Apr, 2017
    * @Modified Date: 17 Apr, 2017
    * @Created By: Diksha Srivastava
    * @Modified By: Diksha Srivastava
    * @param  ARRAY
    * @return STRING
    */
    function forgot_password(Request $request) {
       
        //$imagePath = get_background('forgot_password',''); 
        if ($request->isMethod('post')) {
            $msg = '';
            $email = strtolower(trim($request->email));
            //Validate the input
            $validator = Validator::make($request->all(), [
                        'email' => 'required|email'
            ]);
            if ($validator->fails()) {
                return redirect()->route('forgotpasswordpage')
                                ->withErrors($validator)
                                ->withInput();
            } else {
                $error = '';
                $check = User::where('email', $email)->first();
                if (!$check) {
                    $error = 'Email does not exist';
                } 
                elseif ($check->status == '2') {
                    $error = 'Your account is inactive. Please verify your email address';
                } 
                elseif ($check->status == '3') {
                    $error = 'Your account is blocked. Please contact administrator';
                } 
                elseif ($check->status == '4') {
                    $error = 'Your account is permanently blocked and cannot be restored back';
                }
                if ($error) {
                    $validator->errors()->add('email', $error);

                    return redirect()->route('forgotpasswordpage')
                                    ->withErrors($validator)
                                    ->withInput();
                } else {
                    $code = '';
                    while (true) {
                        $code = md5(microtime() . '-' . rand(4, 10));
                        $DB_Temp = User::where('password_reset_code', $code)->first();

                        if (empty($DB_Temp))
                            break;
                    }
                    User::where('email', $email)
                            ->update(['password_reset_code' => $code]);

                    $activation_link = '<a href="' . route('resetpassword', ['code' => $code]) . '" >Reset Your Password</a>';
                    $template = template_by_variable('forgotpassword');
                   
                    $emaildata['site_title'] = get_option('site_title');
                    $emaildata['admin_email'] = env('MAIL_USERNAME');
                    $signature = get_option('email_signature');
                    $emaildata['name'] = $check->name;
                    $emaildata['email'] = $email;
                    $emaildata['subject'] = $template->title;
                    $body = stripslashes($template->description);
                    $patternFind[0] = '/{NAME}/';
                    $patternFind[1] = '/{RESETCODE}/';
                    $patternFind[2] = '/{SIGNATURE}/';

                    $replaceFind[0] = $emaildata['name'];
                    $replaceFind[1] = $activation_link;
                    $replaceFind[2] = $signature;

                    $ebody = nl2br(preg_replace($patternFind, $replaceFind, $body));
                    $emaildata['body'] = html_entity_decode(stripslashes($ebody));
                 
                    try{

                        Mail::send(['html' => 'emails.template'], ['body' => $emaildata['body']], function($message) use ($emaildata) {
                            $message->from($emaildata['admin_email'], $emaildata['site_title']);
                            $message->subject($emaildata['subject']);
                            $message->to($emaildata['email']);
                        });
                    }
                    catch(\Exception $e){
                        //
                    }
                    $msg = " Password reset request has been successfully sent to your registered email address.";
                    $request->session()->flash('status', $msg);
                    return view('frontend.User.forgotpassword', ['msg' => $msg]);
                }
            }
        } 
        else {
            return view('frontend.User.forgotpassword');
        }
    }
    /**
    * Function reset_password
    *
    * function to reset password using link
    *
    * @Created Date: 17 Apr, 2017
    * @Modified Date: 17 Apr, 2017
    * @Created By: Diksha Srivastava
    * @Modified By: Diksha Srivastava
    * @param  ARRAY
    * @return STRING
    */
    function reset_password($code='', Request $request) {
        $imagePath ="";
        //$imagePath = get_background('reset_password',''); 
        $code = Input::get('code', false);
        if ($request->isMethod('post')) {
        $msg = '';
        $key_error = '';

        if ($code) {
            //check if code exist for user_error
            $data = User::where('password_reset_code', '=', $code)->first();
            if (empty($data)) {
                $msg = 'Link is already expired.';
                $key_error = 1;
            } else {
                if ($request->all()) {
                    $password = $request->password;
                    $password_confirmation = $request->password_confirmation;
                    //Validate the input
                    $validator = Validator::make($request->all(), [
                                'password' => 'required|min:6',
                                'password_confirmation' => 'required|same:password',
                    ]);

                    if ($validator->fails()) {

                        return redirect()->route('resetpassword', ['code' => $code,'imagePath'=>$imagePath])
                                        ->withErrors($validator)
                                        ->withInput();
                    } else {
                $user = User::find($data->id);
                     
                        $user->password = Hash::make($password);
                        $user->password_reset_code = '';
                        $user->save();

                        $msg = 'Password has been changed successfully.';
                        $request->session()->flash('msg', $msg);
                        return redirect('/admin');
                    }
                } else {
                    return view('frontend.User.reset', ['request' => $request, 'key' => $code, 'msg' => $msg, 'key_error' => $key_error,'imagePath'=>$imagePath]);
                }
            }
        } else {
            $msg = 'Invalid link';
        }
        return view('frontend.User.reset', ['msg' => $msg, 'key'=>$code, 'key_error' => $key_error,'imagePath'=>$imagePath]);
        }else{
            return view('frontend.User.reset', ['key' => $code]);
        }
    }
    
    // User forgot password url 
    /**
     * 
     */
    
     public function user_forgot_pass(Request $request){

        if ($request->all()) {

            $msg = $error = '';
            $email = strtolower(trim($request->email));
            //Validate the input
            $validator = Validator::make($request->all(), [
                        'email' => 'required|email'
            ]);
            if ($validator->fails()) {
                return redirect()->route('forgotpasswordpage')
                                ->withErrors($validator)
                                ->withInput();
            } else {
                
                $check = User::where('email', $email)->first();
             //   dd($check);
                if (!$check) {
                    $error = 'Email does not exist';
                } elseif ($check->status == '2') {
                    $error = 'Your account is inactive. Please verify your email address';
                } elseif ($check->status == '3') {
                    $error = 'Your account is blocked. Please contact administrator';
                } 
                if ($error) {
                    //dd("D");
                    $validator->errors()->add('email', $error);

                    return redirect()->route('userforgotpasswordpage')
                                    ->withErrors($validator)
                                    ->withInput();
                } else {
                    $code = '';
                    while (true) {
                        $code = md5(microtime() . '-' . rand(4, 10));
                        $DB_Temp = User::where('password_reset_code', $code)->first();

                        if (empty($DB_Temp))
                            break;
                    }
                    User::where('email', $email)
                            ->update(['password_reset_code' => $code]);

                    $activation_link = '<a href="' . route('usersetpasswordpage', ['code' => $code]) . '" >Reset Your Password</a>';
                    $template = template_by_variable('forgotpassword');
                   
                    $emaildata['site_title'] = get_option('site_title');
                     $emaildata['admin_email'] = env('MAIL_USERNAME'); 
                    $signature = get_option('email_signature');
                    $emaildata['name'] = $check->first_name;
                    $emaildata['email'] = $email;
                    $emaildata['subject'] = $template->title;
                    $body = stripslashes($template->description);
                    $patternFind[0] = '/{NAME}/';
                    $patternFind[1] = '/{RESETCODE}/';
                    $patternFind[2] = '/{SIGNATURE}/';

                    $replaceFind[0] = $emaildata['name'];
                    $replaceFind[1] = $activation_link;
                    $replaceFind[2] = $signature;

                    $ebody = nl2br(preg_replace($patternFind, $replaceFind, $body));
                    $emaildata['body'] = html_entity_decode(stripslashes($ebody));
					
                    try{                    
                        Mail::send(['html' => 'emails.template'], ['body' => $emaildata['body']], function($message) use ($emaildata) {
                            $message->from($emaildata['admin_email'], $emaildata['site_title']);
                            $message->subject($emaildata['subject']);
                            $message->to($emaildata['email']);
                        });
                    }
                    catch(\Exception $e){
						 //dd($emaildata);
                        dd($e);
                    }
                    $msg = " Password reset request has been successfully sent to your registered email address.";
                    $request->session()->flash('status', $msg);
                    return view('auth.passwords.email', ['msg' => $msg]);
                }
            }
        } 
        else {
            return view('auth.passwords.email');
        }
    }
    
    public function user_reset_pass(Request $request){

        $code = Input::get('code', false);

        if ($request->isMethod('post')) {
        $msg = $key_error = '';
        if ($code) {
            //check if code exist for user_error
            $data = User::where('password_reset_code', '=', $code)->first();
            
            if (empty($data)) {
                $msg = 'Link is already expired.';
                $key_error = 1;
            } else {
                if ($request->all()) {
                    $password = $request->password;
                    $password_confirmation = $request->password_confirmation;
                    //Validate the input
                    $validator = Validator::make($request->all(), [
                                'password' => 'required|min:6',
                                'password_confirmation' => 'required|same:password',
                    ]);

                    if ($validator->fails()) {
                        return redirect()->route('usersetpasswordpage', ['code' => $code])
                                        ->withErrors($validator)
                                        ->withInput();
                    } else {
                        $user = User::find($data->id);
                     
                        $user->password = Hash::make($password);
                        $user->password_reset_code = '';
                        $user->save();

                        $msg = 'Password has been changed successfully.';
                        $request->session()->flash('status', $msg);
                        return redirect('/login');
                    }
                } else {
                    return view('auth.passwords.reset', ['request' => $request, 'key' => $code, 'msg' => $msg, 'key_error' => $key_error]);
                }
            }
        } else {
            $msg = 'Invalid link';
        }
        return view('auth.passwords.reset', ['msg' => $msg, 'key'=>$code, 'key_error' => $key_error]);
        }else{
            return view('auth.passwords.reset', ['key' => $code]);
        }
    }
    
}
