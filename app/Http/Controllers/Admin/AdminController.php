<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Route;
use Mail;
use App\AccountList;
use App\CaseList;
use App\Report;
use App\User;
use App\Group;
use Illuminate\Support\Facades\Hash;
use Session;
use Carbon\Carbon;
use DB;
use App\CaseTask;
use App\IncidentTask;
use App\Tasks;
class AdminController extends Controller {

    public $record_per_page;

    /**
     * Function __construct
     *
     * function constructor
     *
     * @Created Date: 12 July, 2017
     * @Modified Date: 12 July, 2017
     * @Created By: Subhendu Das
     * @Modified By: Subhendu Das
     * @param  NULL
     * @return NULL
     */
    
     public function __construct()

   {
        
       $this->record_per_page=10;
       $this->middleware('check_admin_status');
       $this->middleware('revalidate');
       

   }

    /**
     * Function index
     *
     * function to load admin dashboard
     *
     * @Created Date: 12 July, 2017
     * @Modified Date: 12 July, 2017
     * @Created By: Subhendu das
     * @Modified By: Subhendu das
     * @param  ARRAY
     * @return NULL
     */
    public function index(Request $request) {
        $data = array();
		$record_per_page=10;
		$pageNo = trim($request->input('page', 1));
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $group = Group::with(['userGroup'])->with('accountGroup') ;
        $user_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_role_name = $request->session()->get('user_role_name');	
        $user_role_id = $request->session()->get('user_role_id');	
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
            
        }
        $group = $group->orderBy('created_at', 'desc')->get(); 
        $group_filter =  trim($request->input('group_filter')); 
          if(!empty($group) && (count($group)>0)){
            foreach($group as $innerKey=>$innerValue){
                if(!empty($innerValue['userGroup']) ){
                    foreach($innerValue['userGroup'] as $inKey=>$invalue){
                        $userBelongToLoginUserGroup[] = $invalue->user_id;
                        $groupids[] =  $invalue->group_id;
                    }
                }                  
            }
            $groupids = $groupidds = array_unique($groupids);
            if(!empty($request->input('group_id'))){
                $groupids = array($request->input('group_id'));
            }
          }

        $taskIds = CaseTask::join('case_to_group','case_to_group.case_id','=', 'case_tasks.case_id')->whereIn('group_id',$groupidds)->pluck('task_id','task_id');
        $taskIdsAssignedInCases = CaseTask::join('case_to_group','case_to_group.case_id','=', 'case_tasks.case_id')->whereIn('group_id',$groupids)->pluck('task_id','task_id')->toArray();
        $taskIdsAssignedInIncidents = IncidentTask::join('incident_to_group','incident_to_group.incident_id','=', 'incident_task.incident_id')->whereIn('group_id',$groupids)->pluck('task_id','task_id')->toArray();

        if( (count($taskIdsAssignedInCases)>0) && (count($taskIdsAssignedInIncidents)>0) ){
        $taskIds = array_merge($taskIdsAssignedInIncidents,$taskIdsAssignedInCases);                
        }elseif(count($taskIdsAssignedInCases)>0){
        $taskIds = $taskIdsAssignedInCases;  
        }elseif(count($taskIdsAssignedInIncidents)>0){
        $taskIds = $taskIdsAssignedInIncidents;  
        }
        $taskIds = array_merge($taskIdsAssignedInIncidents,$taskIdsAssignedInCases);


        $tasks = Tasks::with(['user'])->where('tasks.status', '!=', '');    

        if($request->session()->get('user_role_id') > 1 )
        {     
            $tasks->where('account_id','=',$request->session()->get('account_id'));
        }

        $task_assigned = $user_id = $request->session()->get('id');
       if($task_assigned)
        {
            $tasks->where('tasks.task_assigned', '=', $task_assigned);
        }elseif($request->session()->get('user_role_id') > 2  ){
            $tasks->where('task_assigned', '=', $request->session()->get('id') ) ;
           // $tasks->orwhereIn('id', $taskIds) ;
        }
        elseif($request->input('group_id') !=''){
            $tasks->whereIn('id', $taskIds) ;
        }
        if ($user_role_name!="superAdmin")
        {
             $tasks->where('tasks.account_id',$account_id);
             
        } 

        $tasks = $tasks->orderby('tasks.created_at','desc');
         $data['getAllAssignedTaskByUserId'] = $taskList =  $tasks->paginate($this->record_per_page);
       // dd($data['getAllAssignedTaskByUserId']);




















        //search fields
        if (isset($_GET) && count($_GET)>0) {
            //dd($_GET);
            $keyword = strtolower(trim($request->input('keyword'))); 
            $group_filter =  trim($request->input('group_filter')); 

            $user_type_id = trim($request->user_type_id);
           }
        
        DB::enableQueryLog();
        $data['accountList'] =  DB::table('account')
                ->where('id', $account_id)
                ->get();
            

        //$data['getAllAssignedTaskByUserId'] = CaseList::getAllAssignedTaskByUserId($user_id);

         // dd($data['getAllAssignedTaskByUserId']);
        
        if ($user_role_name=="superAdmin")
            {

          
         /*$data['caseList'] = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
        ->Join('users', 'case_list.user_id', '=', 'users.id')
        ->Join('users as u2', 'case_list.case_owner_id', '=', 'u2.id')
        ->select('case_list.*', 'account.name as account_name', 'users.first_name as createrName', 'u2.first_name as caseOwnerId')
        ->whereIn('case_list.status', ['new','active'])
        ->orderby('case_list.created_at','desc')
        ->get();*/
        $data['caseList'] =  array();
        $data['myCaseList'] = $data['caseList'];

            } 
        else{

        $caseList = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
        ->Join('users', 'case_list.user_id', '=', 'users.id')
        ->Join('users as u2', 'case_list.case_owner_id', '=', 'u2.id')
        ->select('case_list.*', 'account.name as account_name', 'users.first_name as createrName', 'u2.first_name as caseOwnerId')
        ->orWhereNull('case_list.deleted_at')
        ->whereIn('case_list.status', ['new','active'])
        ->orderby('case_list.created_at','desc')
        ->where('case_list.account_id',$account_id);

        if($request->session()->get('user_role_id') > 2){
            $caseList->where('case_list.case_owner_id', $user_id);
        } 
        
        $data['caseList'] = $caseList->get(); 

        $data['myCaseList'] = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
        ->Join('users', 'case_list.user_id', '=', 'users.id')
        ->Join('users as u2', 'case_list.case_owner_id', '=', 'u2.id')
        ->select('case_list.*', 'account.name as account_name', 'users.first_name as createrName', 'u2.first_name as caseOwnerId')
        ->orWhereNull('case_list.deleted_at')
        ->orderby('case_list.created_at','desc')
        ->where('case_list.account_id',$account_id)
        ->whereIn('case_list.status', ['new','active'])
        ->where('case_list.case_owner_id', $user_id)
            
        ->get();

            }
        $user_group = $request->session()->get('user_group');
		$reportListArray = Report::leftJoin('account', 'report.account_id', '=', 'account.id')
        ->orWhereNull('report.deleted_at')
        ->select('report.*', 'account.name as account_name')
        ->with(['reportGroup']);
        $reportListArray->where('report.account_id',$account_id);
        if(!in_array($request->session()->get('user_role_id'), array(1,2)))
        {
           $reportListArray = $reportListArray->whereHas('reportGroup', function ($q) use ($user_group) {$q->whereIn('group_id',$user_group);});
            
        }

        if(isset($group_filter) && $group_filter!="")
        {
            $reportListArray->whereHas('reportGroup', function ($q) use ($group_filter) {$q->where('group_id',$group_filter);});
        }   






        if(isset($keyword) && $keyword!="")
        {
             $reportListArray->Where(function ($query) use ($keyword) {
                    $query->orwhere('report.title', 'rlike', $keyword)
                     ->orwhere('report.email_address', 'rlike', $keyword)
                  ->orwhere('report.name', 'rlike', $keyword)
                  ->orwhere('report.phone_no', 'rlike', $keyword);
                });
        }
		$data['records'] = $reportListArray->orderby('report.created_at','desc')->get();


        //$data['records'] = $reportListArray->paginate($record_per_page);
      
       /*  $queries = DB::getQueryLog();
         dd($queries);*/
        return view('admin.dashboard', ['data' => $data, 'request' => $request,'pageNo' => @$pageNo, 'record_per_page' => $record_per_page,'group'=>$group]);

        
    }

  
     /**
     * Function access_denied_page
     *
     * function to create access denied
     *
     * @Created Date: 04 Apr, 2017
     * @Modified Date: 04 Apr, 2017
     * @Created By: Subhendu Das
     * @Modified By: Subhendu Das
     * @param  ARRAY
     * @return NULL
     */
    public function access_denied_page(Request $request) {
        
        $data = array();
        return view('admin.access_denied', ['data' => $data, 'request' => $request]);
     }


    /**
     * Function get_records
     *
     * function to fetch records per page
     *
     * @Created Date: 04 Apr, 2017
     * @Modified Date: 04 Apr, 2017
     * @Created By: Subhendu Das
     * @Modified By: Subhendu Das
     * @param  ARRAY
     * @return NULL
     */
    public function get_records() {
        $val = get_option('record_per_page');
        $this->record_per_page = (int) $val;
    }

    /**
     * Function edit_profile
     *
     * edit User profile for admin
     *
     * @Created Date: 07 June, 2017
     * @Modified Date: 07 June, 2017
     * @Created By: Subhendu Das
     * @Modified By: Subhendu Das
     * @param  ARRAY
     * @return ARRAY
     */
    public function edit_profile(Request $request) {

        //get country data
        $countries = array();
        $admin_data = $request->session()->get('ADMIN_LOGIN_DATA');
        $currentuser_id =  $admin_data['id'];
        $data = array();
       
        $data = User::where('id', $currentuser_id)->first();
       // dd($data);
        if ($request->all()) { //post
           
            $email = trim($request->email);
            $first_name = ucwords(trim($request->first_name));
            $last_name = ucwords(trim($request->last_name));
            $street = trim($request->street);
            $postcode = trim($request->postcode);
            $phone = trim($request->phone);
            $cell_phone = trim($request->cell_phone);
            $website = trim($request->website);     
            $additional_info = trim($request->about_info);

            //Validate the input
            $validator = Validator::make($request->all(), [
                       'first_name' => 'required',
                       'last_name' => 'required',
                        'email' => 'required|email|unique:users,email,null,null,status,!"4",id,!' . $currentuser_id,
                        'street' => 'required',
                        'postcode' => 'required',
                        'phone' => 'required',
                        'website' => 'required',
                        'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5021',         
                      
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin-profile')
                                ->withErrors($validator)
                                ->withInput();
            } else {
                if ($request->profile_pic) {
                    //delete previous image if edit case
                    if ($data->profile_pic) {
                        @unlink(public_path('uploads/user/' . $data->profile_pic));
                        
                    }
                    $imageName = ImageUpload($request->profile_pic, 'user');
                }
                $user = User::find($currentuser_id);

                if ($request->profile_pic && @$imageName){
                    $user->profile_pic = $imageName;
					session(['profile_pic' => $imageName]);
				}
                    
                $user->first_name = ucwords($first_name);
                $user->last_name = ucwords($last_name);
                $user->email = strtolower($email);
                $user->phone = $phone;
                $user->cell_phone = $cell_phone;
                $user->address = $street.'~~'.$postcode;
                $user->website = $website;
                $user->additional_info = $additional_info;
                $user->save();
                $namesession = $request->first_name.' '.$request->last_name;
                session(['name' => $namesession]);
                $data = User::where('id', $currentuser_id)->first();

                $msg = 'Profile has been updated successfully.';
                $request->session()->flash('message', $msg);
				
                return view('admin.profile', [ 'request' => $request, 'data' => $data, 'countries' => $countries]);
            }
        }
        else{
            return view('admin.profile', ['data' => $data, 'request' => $request, 'countries' => $countries]);
        }
    }
    /**
    * Function check_username
    *
    * ajax function To check unique username
    *
    * @Created Date: 29 June, 2017
    * @Modified Date: 29 June, 2017
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function check_username(Request $request) {

        $username = strtolower(trim($request->username));
        $id = $request->id;
        $user = User::where('username', '=', $username);
        if ($id != '') {
            $user = $user->where('_id', '!=', $id);
        }
        $user = $user->where('status', '!=', '4')->first();
        if (!empty($user)) {
            return 'false';
        }
        return 'true';
    }

    /**
     * Function check_email
     *
     * ajax function To check unique username
     *
     * @Created Date: 29 June, 2017
     * @Modified Date: 29 June, 2017
     * @Created By: Subhendu Das
     * @Modified By: Subhendu Das
     * @param  ARRAY
     * @return STRING
     */
    public function check_email(Request $request) {

        $email = strtolower(trim($request->email));
        $id = $request->id;
        $user = User::where('email', '=', $email);
        if ($id != '') {
            $user = $user->where('_id', '!=', $id);
        }
        $user = $user->where('status', '!=', '4')->first();
        if (!empty($user)) {
            return 'false';
        }
        return 'true';
    }

    /**
     * Function send_message
     *
     * ajax function to send message to user
     *
     * @Created Date: 30 June, 2017
     * @Modified Date: 30 June, 2017
     * @Created By: Subhendu Das
     * @Modified By: Subhendu Das
     * @param  ARRAY
     * @return STRING
     */
    public function send_message(Request $request) {

        $currentuser_id = $request->session()->get('id');
        $admin_name = $request->session()->get('username');
        $admin_email = $request->session()->get('email');

        $title = trim($request->title);
        $user_id = $request->user_id;
        if ($user_id) {
            //find user details
            $user = User::where('_id', $user_id)->first();

            if (!empty($user)) {
                //save message for user
                $message = new Message();
                $message->sender_id = $currentuser_id;
                $message->receiver_id = $user->id;
                $message->title = strtolower($title);
                $message->message_type_id = '2'; //for contact
                $message->status = '1';
                $message->save();
                if ($user->email) {
                    //send mail to user
                    $template = template_by_variable('message_user');
                    $emaildata['site_title'] = get_option('site_title');
                    $emaildata['admin_email'] = get_option('email');
                    $emaildata['admin_name'] = $admin_name;
                    $signature = get_option('email_signature');
                    $emaildata['name'] = $user->username;
                    $emaildata['email'] = $user->email;
                    $emaildata['subject'] = $template->subject;
                    $body = stripslashes($template->description);

                    $patternFind[0] = '/{NAME}/';
                    $patternFind[1] = '/{EMAIL}/';
                    $patternFind[2] = '/{MESSAGE}/';
                    $patternFind[3] = '/{SIGNATURE}/';

                    $replaceFind[0] = $emaildata['name'];
                    $replaceFind[1] = $admin_name . ' / ' . $admin_email;
                    $replaceFind[2] = $title;
                    $replaceFind[3] = $signature;

                    $ebody = nl2br(preg_replace($patternFind, $replaceFind, $body));
                    $emaildata['body'] = html_entity_decode(stripslashes($ebody));

                    try{
                        Mail::send(['html' => 'emails.template'], ['body' => $emaildata['body']], function($message) use ($emaildata) {
                            $message->from($emaildata['admin_email'], $emaildata['site_title']);
                            $message->subject($emaildata['subject']);
                            $message->to($emaildata['email']);
                        });
                    }catch(\Exception $e){
                                return 'Some error occurred';
                        }
                    
                }
                return '200';
            } else {
                return 'User is no longer available.';
            }
        } else {
            return 'Some error occurred';
        }
    }

    /**
     * Function general_settings
     *
     * function to load and update general settings
     *
     * @Created Date: 20 July, 2017
     * @Modified Date: 20 July, 2017
     * @Created By: Subhendu Das
     * @Modified By: Subhendu Das
     * @param  ARRAY
     * @return STRING
     */
    public function general_settings(Request $request) {
        if ($request->all()) {
            //Validate the input
            $validator = Validator::make($request->all(), [
                        'site_title' => 'required',
                        'email' => 'required|email',
                        'contactus_email' => 'required|email',
                        'address' => 'required',
                        'contact_number' => 'required',
                        'social_facebook' => 'required|url',
                        'social_twitter' => 'required|url',
                        'social_googleplus' => 'required',
                         'social_instagram' => 'required',
                         'social_pinterest' => 'required',
                         'email_signature' => 'required',
                        
                        
                            ], [
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin-generalsettings')
                                ->withErrors($validator)
                                ->withInput();
            } else {
              
                foreach ((array) $request->all() as $key => $val) {
                   if($key!='_token'){
  $user = General_option::where('option_name', $key)
                            ->update(['option_value' => ($val)]);

                        }
                    
                }
                $request->session()->flash('message', 'General Settings has been updated successfully.');
            }
            return redirect()->route('admin-generalsettings');
        } else {
            //fetch general options data
            $old_values = General_option::where('id_status', '1')->get();
            $data = array();
            foreach ($old_values as $val) {
                $data[$val['option_name']] = $val->option_value;
            }
            return view('admin.general_settings', ['request' => $request, 'data' => $data]);
        }
    }

    public function change_password(Request $request) {
        //print_r($request->session()->all());
        if ($request->all()) {

            $user_id = $request->session()->get('id');
            $current_password = trim($request->input('current_password'));
            $new_password = trim($request->input('new_password'));
            $confirm_password = trim($request->input('confirm_password'));
            $validator = Validator::make($request->all(), [
                        'current_password' => 'required',
                        'new_password' => 'required|min:6',
                        'confirm_password' => 'required|same:new_password',
            ]);
            if ($validator->fails()) {
                
                return redirect()->route('admin-changepassword')
                                ->withErrors($validator)
                                ->withInput();
            } else {
                $user = User::find($user_id);
                $check = Hash::check($current_password, $user->password);
                if (!$check) {
                    $validator->errors()->add('current_password', 'Invalid current Password.');
                    return redirect()->route('changepassword')
                                ->withErrors($validator)
                                ->withInput();
                }
                else{
                    //update values
                    $uservalues = User::find($user_id);
                    $uservalues->password = Hash::make($new_password);
					$uservalues->password_changed_at = Carbon::now()->toDateTimeString();
					
                    $uservalues->save();
                    $request->session()->flash('message', 'Password has been changed successfully.');
                    return redirect()->route('admin-changepassword');
                }
            }
        } else {
           
            return view('admin.change_password', ['request' => $request]);
        }
    }

    /**
     * Function check_current_password
     *
     * ajax function To check current password
     *
     * @Created Date: 29 June, 2017
     * @Modified Date: 29 June, 2017
     * @Created By: Subhendu Das
     * @Modified By: Subhendu Das
     * @param  ARRAY
     * @return STRING
     */
    public function check_current_password(Request $request) {
        $user_id = $request->session()->get('id');
        $current_password = (trim($request->current_password));
        $user = User::find($user_id);
        $check = Hash::check($current_password, $user->password);
        if (!$check) {
            return 'false';
        }
        return 'true';
    }

    /**
     * Function check_category_name
     *
     * ajax function To check unique category name
     *
     * @Created Date: 28 July, 2017
     * @Modified Date: 28 July, 2017
     * @Created By: Subhendu Das
     * @Modified By: Subhendu Das
     * @param  ARRAY
     * @return STRING
     */
    public function check_category_name(Request $request) {

        $category = strtolower(trim($request->category));
        $id = $request->id;
        $user = Category::where('name', '=', $category);
        if ($id != '') {
            $user = $user->where('_id', '!=', $id);
        }
        $user = $user->where('status', '!=', '4')->first();
        if (!empty($user)) {
            return 'false';
        }
        return 'true';
    }
    /**
     * Function check_forumcategory
     *
     * ajax function To check unique forum category
     *
     * @Created Date: 16 Oct, 2017
     * @Modified Date: 16 Oct, 2017
     * @Created By: Subhendu Das
     * @Modified By: Subhendu Das
     * @param  ARRAY
     * @return STRING
     */
    public function check_forumcategory(Request $request) {

        $name = strtolower(trim($request->name));
        $id = $request->id;
        $user = ChatterCategory::where('name', '=', $name);
        if ($id != '') {
            $user = $user->where('_id', '!=', $id);
        }
        $user = $user->where('status', '!=', '4')->first();
        if (!empty($user)) {
            return 'false';
        }
        return 'true';
    }
     public function general_newsletters(Request $request) {
        if ($request->all()) {
            //Validate the input
            $validator = Validator::make($request->all(), [
                        'site_title' => 'required',
                        'email' => 'required|email',
                        'contactus_email' => 'required|email',
                        'address' => 'required',
                        'contact_number' => 'required',
                        'social_facebook' => 'required|url',
                        'social_twitter' => 'required|url',
                        'record_per_page_admin' => 'required',
                        'trending_videos' => 'required',
                        'latest_news' => 'required',
                        'upcoming_events' => 'required',
                        'email_signature' => 'required',
                        'record_per_page_admin' => 'required',
                        'admin_price' => 'required',
                        'ad_expiry' => 'required',
                        'admin_paypal_username' => 'required',
                        'admin_paypal_password' => 'required',
                        'admin_paypal_signature' => 'required',
                            ], [
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin-generalsettings')
                                ->withErrors($validator)
                                ->withInput();
            } else {
                foreach ((array) $request->all() as $key => $val) {
                    if($key=='admin_paypal_username' || $key=='admin_paypal_password' )
                    {
                        $user = General_option::where('option_name', $key)
                            ->update(['option_value' => base64_encode($val)]);
                    }
                    else
                    {
                        $user = General_option::where('option_name', $key)
                            ->update(['option_value' => removeHtmlFromRequest($val)]);

                    }
                    
                }
                $request->session()->flash('message', 'General Settings has been updated successfully.');
            }
            return redirect()->route('admin-generalsettings');
        } else {
            //fetch general options data
            $old_values = General_option::where('id_status', '1')->get();
            $data = array();
            foreach ($old_values as $val) {
                $data[$val['option_name']] = $val->option_value;
            }
            return view('admin.news_letters', ['request' => $request, 'data' => $data]);
        }
    }

 /**
     * Function get_state
     *
     * ajax function To get state using country Id
     *
     * @Created Date: 18 Jan, 2018
     * @Modified Date: 18 Jan, 2018
     * @Created By: Anurag Lyall
     * @Modified By: Anurag Lyall
     * @param  ARRAY
     * @return STRING
     */
 public function get_state(){
    die("ok");
 }
 public function pp($data, $die = 0){
    echo '<pre>'; print_r($data); echo '</pre>';
    if($die){
        die();
    }
 }

}