<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\AccountList;
use App\User;
use App\Group;
use App\UserGroup;
use App\Role;
use Auth;
use App\Site;
use Validator;
use App\DashboardContent;
Use Config;
use DB;
use App\AccountToGroup;
use Carbon\Carbon;
use App\Zone;

class GroupController extends AdminController
{
    public $data = array();
    /**
    * Function __construct
    *
    * constructor
    *
    * @Created Date: 13th Feb,2020
    * @Created By: Shweta Trivedi
    * @param  ARRAY
    * @return STRING
    */
    public function __construct() {
        parent::__construct();
        $this->record_per_page=10;
    }
 
    public function index(Request $request) {
       
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        
        $pageNo = trim($request->input('page', 1));
        //search fields
        $keyword = strtolower(trim($request->input('keyword'))); 
        $status = trim($request->input('status')); 
        
        $role_id = trim($request->input('role_id')); 
       
        DB::enableQueryLog();
        $user_role_name = $request->session()->get('user_role_name');
        $user_role_id = $request->session()->get('user_role_id');
        $account_list = array();
        $roleList = array();
          
        if(in_array($request->session()->get('user_role_id'), array(1,2)))
        {
            $role = new Role();
            $roleList = $role->get();
            $account_list = AccountList::orderby('account.name','ASC')->get();            
        }
        /*echo '<pre>'; print_r($account_list); echo '</pre>';
        if ($user_role_name=="superAdmin")
        {
             $role = new Role();
             $roleList = $role->get();
             $account_list = AccountList::orderby('account.name','ASC')->get();

        } */

        //get user data
         $group = Group::with(['userGroup'])->with('accountGroup') ;
       
//        $user_role_name = $request->session()->get('user_role_name');
//           
//        if ($user_role_name!="superAdmin")
//        {
//             $users->where('users.account_id',$account_id);
//        } 
//        if($status)
//        {
//            $users->where('users.status',$status);
//        }
//        $account_id = trim($request->input('account_id')); 
//        if($account_id)
//        {
//            $users->where('users.account_id',$account_id);
//        }
//        
//        if($role_id)
//        {
//            $users->where('role_user.role_id',$role_id);
//        }
        if($keyword)
        {
            $group = $group->Where(function ($query) use ($keyword) {
                   $query->orwhere('name', 'rlike', $keyword);
        });
       }
       //echo '<pre>'; print_r($request->session()); echo '</pre>';
       $user_id = $request->session()->get('id');
       if(!in_array($request->session()->get('user_role_id'), array(1))){
       if($request->session()->get('account_id')){
        $account_id  = $request->session()->get('account_id');
        $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
        if($request->session()->get('user_role_id') > 2 )
        {       
        $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
        }
       }

    }

        $group->whereNull('deleted_at'); 
        $group = $group->orderBy('created_at', 'desc'); 

       $this->data['records'] = $group->paginate($this->record_per_page);
      //dd(DB::getQueryLog());
       //echo '<pre>'; print_r($this->data['records']); echo '</pre>'; die();
       return view('admin.groupList', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list, 'roleList'=>$roleList,'user_role_id'=>$user_role_id]);
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
    public function add(Request $request, $id = '') {
        $zones = Zone::orderBy('name')->pluck('name','name');
        $disable = 'disabled';
        $data = array();
        $users = array();
        $destinationPath = base_path() . '/public/users/images/';
        $account_id = $request->session()->get('account_id');
        $request->session()->get('user_role_id');
        if($request->session()->get('user_role_id')>10){
            $msg = 'You are not Authorized to Access this Page';
            $request->session()->flash('add_message', $msg); 
            return redirect()->route('admin-dashboard');
        }

        $request->session()->get('user_role_id');
        $genres = array();
        
        //get user data
        $account_to_group_id = $account_to_group_name = '';
        $userIds = array() ;
        $actionType = 'none';  
        if(!empty($id)){
             $actionType = '';   
             $data = Group::with(['userGroup.users'])->where('id',$id)->first();
             foreach($data->userGroup as $row)
             {
                 $userIds[] = $row->user_id ;
             }
             if(!empty($id) && ($request->session()->get('account_id')==1) ){
                $disable = '';
             }
             if(!empty($data->accountGroup)){
              $account_to_group_id = $data->accountGroup->account_id;
              $account_to_group_name = $data->accountGroup->account->name;
              //echo '<pre>'; print_r($account_to_group_name); echo '</pre>'; die();
              $users = User::whereIn('status', [1, 2])->where('account_id',$account_to_group_id)->orderBy('first_name', 'asc')->get();
             }
        }elseif($request->session()->get('user_role_id')>1){
            $account_to_group_id = $request->session()->get('account_id');
            $accountData = AccountList::select('name')->where('id',$account_to_group_id)->first();
            $account_to_group_name = $accountData->name;
            $role_id = 2;
            $user = User::with('roles')->whereIn('status', [1, 2])->where('account_id',$account_to_group_id)->orderBy('first_name', 'asc');
            $user->whereHas('roles', function ($q) use ($role_id) {$q->where('role_id',$role_id);});
            $users = $user->get();
            $userIds[] = $users[0]['id'] ;
        }elseif($request->session()->get('account_id')==1){
            $disable = '';
        }
        else{
            
        }
        //die('1111s');
        $account_list =array();
        if(in_array($request->session()->get('user_role_id'), array(1,2)))
        {
            $role = new Role();
            $roleList = $role->get();
            $account_list = AccountList::orderby('account.name','ASC')->get();            
        }
        if ($request->all()) { //post
          $id = $request->id;
          $users_id = $request->users;
          
          $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'account' => 'required',
                ]);
          //dd($validator);
            if ($validator->fails()) 
            {
                if($id)
                {
                   return redirect()->route('admin-add-group',['id'=>$id])
                            ->withErrors($validator)
                            ->withInput(); 
                }
                else
                {
                    return redirect()->route('admin-add-group')
                            ->withErrors($validator)
                            ->withInput();
                }
            }
            else {
               
                if ($id) {
                    AccountToGroup::where('group_id',$request->id)->where('account_id',$request->account)->delete();
                    $accountToGroupInsert = new AccountToGroup;
                    $accountToGroupInsert->account_id  = $request->account;
                    $accountToGroupInsert->group_id    = $request->id;
                    $accountToGroupInsert->save();
                    $group = Group::find($id);
                    $group->name = ucfirst(trim($request->name));
                    $group->timezone = $request->zone;
                    $group->location = $request->location;
                    $group->latitude = $request->latitude;
                    $group->longitude = $request->longitude;
                    
                    $group->save();
                    if(!empty($users_id)){
                    UserGroup::where('group_id',$id)->delete();
                    $groupZone = $request->zone;
                    for($i=0;$i<count($users_id);$i++)
                    {
                        UserGroup::insert(['group_id' =>$id, 'user_id' =>$users_id[$i],'zone'=>$groupZone]);
                    }
                      }  
                    $msg = 'Group has been updated successfully.';
                    $request->session()->flash('add_message', $msg);
                     
                    return redirect()->route('admin-groups');
               
                }
                else {
                    $group_id = Group::insertGetId(['name' => ucfirst(trim($request->name)), 'timezone'=>$request->zone,'location'=>$request->location,'latitude'=>$request->latitude,'longitude'=>$request->longitude]);
                    $accountToGroupInsert = new AccountToGroup;
                    $accountToGroupInsert->account_id  = $request->account;
                    $accountToGroupInsert->group_id    = $group_id;
                    $accountToGroupInsert->save();
                    $groupZone = $request->zone;
                    if($group_id)
                    {
                        for($i=0;$i<count($users_id);$i++)
                        {
                            UserGroup::insert(['group_id' =>$group_id, 'user_id' =>$users_id[$i],'zone'=>$groupZone]);
                        }
                    }    
                    $msg = 'Group has been created successfully.';
                    $request->session()->flash('add_message', $msg);
                    return redirect()->route('admin-groups');
                }
            }
        }
        else {            
            return view('admin.add_group', ['data' => $data, 'userIds'=>$userIds, 'request' => $request, 'users' => $users,'account_list'=>$account_list,'account_to_group_id'=>$account_to_group_id,'account_to_group_name'=>$account_to_group_name,'disable'=>$disable,'actionType'=>$actionType,'zones'=>$zones]);
        }
    }
    /**
    * Function user_delete
    * function to delete group
    *
    * @Created Date: 14 Feb,2020
    * @Created By: Shweta Trivedi
    * @Modified By: Shweta Trivedi
    * @param  ARRAY
    * @return STRING
    */
    public function destroy($id,Request $request) {
        if($request->session()->get('user_role_id')>2){
            $msg = 'You are not Authorized to Access this Page';
            $request->session()->flash('add_message', $msg); 
            return redirect()->route('admin-dashboard');
        }
        if ($id) {
            $group = Group::find($id);           
            if($group->delete()){
                UserGroup::where('group_id',$id)->delete();
                AccountToGroup::where('group_id',$id)->delete();
                $msg = 'User Group has been deleted successfully.';
                $request->session()->flash('message', $msg);
            }
        }
        return redirect()->route('admin-groups');
    }

    public function listallusersbelongstospecificaccount(Request $request){
        $request->account;
        $groupId = $request->groupId;
        $users = $userIds = array();
        if(!empty($groupId)){
        $data = Group::with(['userGroup.users'])->where('id',$groupId)->first();
         foreach($data->userGroup as $row)
         {
             $userIds[] = $row->user_id ;
         }
        }
        $role_id = 2;
         //echo '<pre>'; print_r($userIds); echo '</pre>'; die();
        if( !empty($request->account)){
            $user = User::with('roles')->whereIn('status', [1, 2])->where('account_id',$request->account)->whereNull('deleted_at')->orderBy('first_name', 'asc');
            $user->whereHas('roles', function ($q) use ($role_id) {$q->where('role_id',$role_id);});
            $users = $user->get();
            $userIds[] = $users[0]['id'] ;
        }        
        return view('admin.appenduserinoption',['users'=>$users,'userIds'=>$userIds]);

    }

    
}