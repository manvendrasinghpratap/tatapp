<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\AccountList;
use App\User;
use App\Role;
use Auth;
use App\Site;
use App\Http\Middleware\ResizeImageComp;
use Validator;
use Mail;
use Illuminate\Support\Facades\Hash;
use App\UserGroup;
use App\DashboardContent;
Use Config;
use DB;

use Stripe\Customer;
use Stripe\Charge;
use Carbon\Carbon;

class UserController extends AdminController
{
    public $data = array();
    /**
    * Function __construct
    *
    * constructor
    *
    * @Created Date: 14th May,2018
    * @Modified Date:  14th May,2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function __construct() {
        parent::__construct();
        $this->record_per_page=10;
        //$this->middleware('check_admin_status');
        //$this->middleware('revalidate');

     
    }
 /**
    * Function __construct
    *
    * constructor
    *
    * @Created Date: 14th May,2018
    * @Modified Date:  14th May,2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function index(Request $request) {
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        
        $pageNo = trim($request->input('page', 1));
        //search fields
        $keyword = strtolower(trim($request->input('keyword'))); 
        $status = trim($request->input('status')); 
        
        $role_id = trim($request->input('role_id')); 
        $user_id = $request->session()->get('id');
        DB::enableQueryLog();

        $user_role_name = $request->session()->get('user_role_name');
        $user_role_id = $request->session()->get('user_role_id');
        $account_list = array();
        $roleList = array();
           
            if ($user_role_id=="1")
            {
                 $role = new Role();
                 $roleList = $role->get();
                 $account_list = AccountList::orderby('account.name','ASC')->get();

            } 

        //get user data
       

       // echo '<pre>'; print_r($userGroup); echo '</pre>';
        $users = User::Join('role_user', 'users.id', '=', 'role_user.user_id')
        ->Join('account', 'account.id', '=', 'users.account_id')
        ->Join('roles', 'roles.id', '=', 'role_user.role_id')
        ->select('users.*', 'role_user.user_id', 'users.id as newUserID', 'roles.display_name as rolesDisplayName','account.name as accountName')
        ->whereIn('users.status', [1,2])
        ->with('caselists')
        ->with('userGroup');
        //$users->where('role_user.role_id','>',($user_role_id-1));
        if($request->session()->get('user_role_id') > 2 )
        {   
        $userGroup = User::where('id',$user_id)->with(['userGroup'])->get();  
        $userAssignedGroup = array();      
        if(!empty($userGroup)){
            $userAssignedGroup = array();
            foreach($userGroup as $innerKey=>$innerValue){
                $userGroupData = $innerValue['userGroup'];
                foreach($userGroupData as $innerKeyData => $innerKeyValue){
                    $userAssignedGroups[] = $innerKeyValue->group_id;
                }

            }
        }
       // die();
        $users->whereHas('userGroup', function ($q) use ($userAssignedGroups) {$q->whereIn('group_id',$userAssignedGroups);});
        }
        $user_role_name = $request->session()->get('user_role_name');
           
        if ($user_role_name!="superAdmin")
        {
             $users->where('users.account_id',$account_id);
             
        } 
        if($status)
        {
            $users->where('users.status',$status);
        }
        $account_id = trim($request->input('account_id')); 
        if($account_id)
        {
            $users->where('users.account_id',$account_id);
        }
        
        if($role_id)
        {
            $users->where('role_user.role_id',$role_id);
        }
        if($keyword)
        {
             $users->Where(function ($query) use ($keyword) {
                    $query->orwhere('users.first_name', 'rlike', $keyword)
                    ->orwhere('users.last_name', 'rlike', $keyword)
                  ->orwhere('users.email', 'rlike', $keyword);
                });
        }
        $users = $users->orderby('users.created_at','desc');
       
        $queries = DB::getQueryLog();
        //dd_my($request->input());
       
       //dd_my($queries);
        //dd_my($users);
        
        $this->data['records'] = $users->paginate($this->record_per_page);
        // /echo '<pre>'; print_r($this->data['records']); echo '</pre>'; die();
        // /dd($this->data['records']->toArray());
        return view('admin.user_mng', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list, 'roleList'=>$roleList,'user_role_id'=>$user_role_id]);
    }

 public function test_user(Request $request) {
dd('test user');
}
    
    /**
    * Function add_user
    *
    * function to add user
    *
    * @Created Date: 14th May,2018
    * @Modified Date: 14th May,2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function add_user(Request $request, $id = '') {

        
       //echo '<pre>'; print_r($request->session()->get('user_group'));  echo '</pre>';
       if($request->session()->get('user_role_id')>20){
        $msg = 'You are not Authorized to Access this Page';
        $request->session()->flash('add_message', $msg); 
        return redirect()->route('admin-dashboard');
        }
        $data = array();
        $loginMemberAssignedGroups = $request->session()->get('user_group');
        $existingUserGroupArray = array();
        $destinationPath = base_path() . '/public/users/images/';
        $account_id = $request->session()->get('account_id');
        $userId = $user_id = $request->session()->get('id');

        $user_role_name = $request->session()->get('user_role_name');
        $user_role_id = $request->session()->get('user_role_id');
        $accountAndGroup = array();
    
        $groupsListAssignedToAccount = AccountList::where('id',$request->session()->get('account_id'))->with('accountGroups')->get();
        foreach($groupsListAssignedToAccount as  $accountList){
            foreach($accountList->accountGroups as $groups)  {
                if($user_role_id>2){
                    if(in_array($groups->group->id,$loginMemberAssignedGroups)){
                        $accountAndGroup[$groups->group->id] = $groups->group->name;
                    }                    
                } else{
                $accountAndGroup[$groups->group->id] = $groups->group->name;
                }
            }
         }



       
        
        $genres = array();
        //get user data
        $totalExistUsers = User::where('account_id',$account_id)->whereIn('status', [1, 2])->get()->count();
        $role = new Role();
        //DB::enableQueryLog();

        $account_list = array();
     
           
            if ($user_role_id=='1')
            {
                 $roleList = $role->get();
                 $account_list = AccountList::where('membership_type', '!=', 'deactive')->get();

            } 
            else{
                 $roleList = $role->whereNotIn('id', [1,2])->get();
            
            }


    
        if(!empty($id)){
      
         $data = User::leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                ->select('users.*', 'role_user.role_id' , 'role_user.id as role_user_id')
                ->with('UserGroup')
                ->where('users.id',$id)->first();
         }
         //if($data[UserGroup])
         if(!empty($data['UserGroup'])){
             foreach($data['UserGroup'] as $existingUserGroup){
                $existingUserGroupArray[] = $existingUserGroup->group_id;
             }
         }
        
        if ($request->all()) { //post
         //dd($request->all());
           
            $email              = strtolower(trim($request->email)); 
            $first_name         = strtolower(trim($request->first_name));
            $last_name          = strtolower(trim($request->last_name));
            $new_password       = trim($request->new_password);
            $confirm_password   = trim($request->confirm_password);
            $account_id         = trim($request->account_id);
            $groupIdArray       = $request->group_id;            
            if ($id) {
               // dd($request->all());
            
                //Validate the input
                $validator = Validator::make($request->all(), [
                    'role_id' => 'required',
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email|unique:users,email,null,null,status,!"3",id,!'.$id
                    
                ]);

                $messages = $validator->messages();
/*
            foreach ($messages->all('<li>:message</li>') as $message)
            {
                echo $message;
            }
            die;*/
            }else {
                //Validate the input
                $validator = Validator::make($request->all(), [
                    'role_id' => 'required',
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email|unique:users,email,null,null,status,!"3"'
                    
                    
                ]);
            }
            if ($validator->fails()) 
            {
                //dd($validator->messages());
                if($id)
                {
                   return redirect()->route('admin-edituser',['id'=>$id])
                            ->withErrors($validator)
                            ->withInput(); 
                }
                else
                {
                    return redirect()->route('admin-adduser')
                            ->withErrors($validator)
                            ->withInput();
                }
            }
            else {
                //dd($request);

                /*if ($request->profile_pic) {
                    
                    if($id)
                    {
                        if($data->profile_pic)
                            @unlink(public_path('uploads/user/' . $data->profile_pic));
                    }
                    $imagename = ImageUpload($request->profile_pic,'user');
                }*/
                if ($id) { //update case
                    $user = User::find($id);
                    if($new_password)
                        $user->password = Hash::make($new_password);
                } else {
                    if(!$new_password)
                        $password = _makePassword(6);
                        
                    else
                    $password = $new_password;
                    
                    $user = new User;
                    /*$user->status = '1'; //Active default
                    $user->user_type = '1';
                    $user->referral_code = '';*/
                    
                    $user->password = Hash::make($password);
                    //dd($user);
                }
                
                $user->account_id = $account_id;
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->email = strtolower($email);
              /*  $user->is_free_member = $is_free_member;
                $user->is_exclusive = $is_exclusive;
                $user->referral_code = $referral_code;*/



                $user->save();

                

                if ($id) {
                    //DB::table('role_user')->where('users.id',$id)->first();
                   // UserGroup::where('group_id',$request->group_id)->where('user_id',$id)->delete();
                    UserGroup::where('user_id',$id)->delete();
                    DB::table('role_user')
                    ->where('id', $data->role_user_id)
                    ->update(['role_id' => $request->role_id]);
                    $msg = 'User has been updated successfully.';
                    $request->session()->flash('add_message', $msg);


                    foreach($groupIdArray as $groupId){
                        DB::table('user_to_group')->insert(
                            ['group_id' => $groupId, 'user_id' => $id]
                        );
                    }                   
                    return redirect()->route('admin-users');
                    
                    //return view('admin.add_user', ['request' => $request, 'data' => $data]);
                }
                else {
        ######### Here I am creating a Agency user with all privillages ######
                    DB::table('role_user')->insert(
                        ['role_id' => $request->role_id, 'user_id' => $user->id]
                    );
                    foreach($groupIdArray as $groupId){
                        DB::table('user_to_group')->insert(
                            ['group_id' => $groupId, 'user_id' => $user->id]
                        );
                    }
                
        ############ END Creating agency user ##############
                    /*//send mail
                    $template = template_by_variable('adduser');

                    $emaildata['site_title'] = get_option('site_title');
                    $emaildata['admin_email'] = get_option('email');
                    $signature = get_option('email_signature');
                    $emaildata['name'] = $email;
                    $emaildata['email'] = $email;groupsListAssignedToAccount
                    //$emaildata['subject'] = $tegroupsListAssignedToAccountect;
                    $emaildata['subject'] = 'SubjgroupsListAssignedToAccount
                    //$body = stripslashes($templgroupsListAssignedToAccounttion);
                    $body = stripslashes("Body");
                
                    $patternFind[0] = '/{NAME}/';
                    $patternFind[1] = '/{EMAIL}/';
                    $patternFind[2] = '/{PASSWORD}/';
                    $patternFind[3] = '/{SIGNATURE}/';
                    
                    //$replaceFind[0] = $name;
                    $replaceFind[0] = 'name';
                    $replaceFind[1] = $email;
                    $replaceFind[2] = $password;
                    $replaceFind[3] = $signature;

                    $ebody 	= nl2br(preg_replace($patternFind, $replaceFind, $body));
                    $emaildata['body'] = html_entity_decode(stripslashes($ebody));*/
                    try{
                        /*Mail::send(['html' => 'emails.template'], ['body' => $emaildata['body']], function($message) use ($emaildata)
                        {
                            $message->from($emaildata['admin_email'],$emaildata['site_title']);
                            $message->subject($emaildata['subject']);
                            $message->to($emaildata['email']);
                        });*/
                    }
                    catch(\Exception $e){
                        //
                    
                    }
                    $msg = 'User has been added successfully.';
                    $request->session()->flash('add_message', $msg);
                    return redirect()->route('admin-users');
                }
            }
        }
        else {
            return view('admin.add_user', ['data' => $data, 'request' => $request, 'roleList' => $roleList, 'totalExistUsers' => $totalExistUsers, 'account_list' =>$account_list,'groupsListAssignedToAccount'=>$groupsListAssignedToAccount,'existingUserGroupArray'=>$existingUserGroupArray,'accountAndGroup'=>$accountAndGroup]);
        }
    }
    /**
    * Function user_delete
    *
    * function to delete user
    *
    * @Created Date: 14th May,2018
    * @Modified Date: 14th May,2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function user_delete($id, Request $request) {
        if ($id) {
            if($request->session()->get('user_role_id')>2){
                $msg = 'You are not Authorized to Access this Page';
                $request->session()->flash('add_message', $msg); 
                return redirect()->route('admin-dashboard');
            }
            $user = User::find($id);
            $user->status = '3';
            if($user->save()){
                $msg = 'User has been deleted successfully.';
                $request->session()->flash('message', $msg);
            }
        }
        return redirect()->route('admin-users');
    }
    /**
    * Function get_user_data
    *
    * function to get user data
    *
    * @Created Date: 14th May,2018
    * @Modified Date: 14th May,2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function get_user_data($id) {
        $users = User::where('id',$id)->where('status','!=','3')->with('caselists')->first();
        return $users;
    }
    /**
    * Function user_detail
    *
    * function to get user details
    *
    * @Created Date: 14th May,2018
    * @Modified Date: 14th May,2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function user_detail($id,Request $request) {
        if ($id) {
            $data = $this->get_user_data($id);
            
            return view('admin.user_detail',['data'=>$data,'request'=>$request]);
        }
        else{
            return redirect()->route('admin-users');
        }
    }

    public function listallgroupbelongstospecificaccount(Request $request){
        if(!empty($request->accountId)){
            $existingUserGroupArray = array();
            $groupsListAssignedToAccount = AccountList::where('id',$account_id = $request->accountId)->with('accountGroups')->get(); 
            if(!empty($request->userId)){
                $users = User::where('id',$request->userId)->with(['userGroup'])->get();
                foreach($users as $usersInnerData){
                    foreach($usersInnerData->UserGroup as $innerdata){
                        $existingUserGroupArray[] = $innerdata->group_id;                        
                    }
                }
            }
        return view('admin.appendgroupinoption',['groupsListAssignedToAccount'=>$groupsListAssignedToAccount,'existingUserGroupArray'=>$existingUserGroupArray]);
        }
        return ;
    }
    

    
}