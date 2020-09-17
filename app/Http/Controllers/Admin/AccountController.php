<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use Auth;
use App\Site;
use App\Http\Middleware\ResizeImageComp;
use Validator;
use Mail;
use Illuminate\Support\Facades\Hash;
Use Config;
use App\IncidentType;
use App\AccountList;
use App\AccountSector;
use App\FactorList;
use App\User;
use Session;
use Carbon\Carbon;
use App\Group;
use App\UserGroup;
use App\AccountToGroup;
use App\AccountToStorageSpace;
use App\MembershipType;


use DB;
class AccountController extends AdminController
{
    public $data = array();
    /**
    * Function __construct
    *
    * constructor
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function __construct() {
        //dd($this->record_per_page);
        parent::__construct();
        $this->record_per_page=10;
        $this->middleware('check_admin_status');
        $this->middleware('revalidate');
    }
   

  /**
    * Function accountList
    *
    * function to get listing of account List
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function accountList(Request $request) {


        $admin_id = $request->session()->get('id');
        
        $pageNo = trim($request->input('page', 1));
        //search fields
        $keyword = strtolower(trim($request->input('keyword'))); 
        $status = trim($request->input('status')); 
        $membership_type = trim($request->input('membership_type')); 
        $spaceUploadFiles = array('10'=>'10 MB','25'=>'25 MB','100'=>'100 MB','1000'=>'1 GB','2000'=>'2 GB');
        
        //get user data
        //$account_list = AccountList::all();
        //dd($account_list);
        
        $account_list = AccountList::where('status', '!=', '')->with('users');
        // dd(DB::getQueryLog());
        $count = AccountList::where('status', '!=','')->with('user')->count();
        //dd($account_list);
        if($membership_type)
        {
            $account_list->where('membership_type',$membership_type);
        }
       if($status)
        {
            $account_list->where('status',$status);
        }
        if($keyword)
        {
              $account_list->Where(function ($query) use ($keyword) {
                            $query->orwhere('name', 'rlike', $keyword)
                            ->orwhere('email_address', 'rlike', $keyword)
                            ->orwhere('office_number', 'rlike', $keyword);
                        });           
        }
        $account_list = $account_list->orderby('created_at','desc');
        //dd(DB::getQueryLog());
        $this->data['records'] = $account_list->paginate($this->record_per_page);
         //dd($this->data['records']->toArray());
        return view('admin.account_list', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request,'count' => $count,'spaceUploadFiles'=> $spaceUploadFiles]);
    }

    /**
    * Function add_account
    *
    * function to add account
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function add_account(Request $request,$id = null){
      //dd($id);

    $account_detail = array();
    if(!empty($id)){
        $account_detail = AccountList::find($id);
          //dd($account_detail);
    }
    $noOfFiles = array(10,20,30,40,50,60,100,150);
    $spaceUploadFiles = array('10'=>'10 MB','25'=>'25 MB','100'=>'100 MB','1000'=>'1 GB','2000'=>'2 GB');
    $memberShipPlan = MembershipType::get();
    $extraSpace = array('100'=>'100 MB','500'=>'500 MB','1000'=>'1 GB','1500'=>'1.5 GB','2000'=>'2 GB');

     if ($request->all()) { //post
            $name = $request->name; 
            $address = $request->address; 
            $city = $request->city;
            $state = $request->state;
            $zip_code = $request->zip_code;
            $website = $request->website;
            $contact_person = $request->contact_person;
            $office_number = $request->office_number;
            $cell_phone = $request->cell_phone;
            $email_address = $request->email_address;
            $status = $request->status;
            $membership_type = $request->membership_type;
            $storage_space = $request->storage_space; 
            $totalspace = $request->totalspace; 
            $membertypeId = $request->membertypeId; 
            
            
            ///http://formvalidation.io/validators/zipCode/
            // integer|between:8,12
                        
             if(!empty($request->id)){
               $validator = Validator::make($request->all(), [
                    'name' => 'required|string|min:3|max:255',
                    'address' => 'required|max:250',
                    'city' => 'required|max:50',
                    'state' => 'required|max:50',
                    'zip_code' => 'required|integer|min:5',
                    'website' => 'required|string|min:3|max:255',
                    'contact_person' => 'required|string|min:3|max:255',
                    'office_number' => 'required|string|min:8|max:14',
                    'cell_phone' => 'required|string|min:8|max:14',
                    'storage_space' => 'required|max:25',
                    'membership_type' => 'required|max:25',
                    'status' => 'required'

                ]);

             }
             else{
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|min:3|max:255',
                    'address' => 'required|max:250',
                    'city' => 'required|max:50',
                    'state' => 'required|max:50',
                    'zip_code' => 'required|integer|min:5',
                    'website' => 'required|string|min:3|max:255',
                    'contact_person' => 'required|string|min:3|max:255',
                    'office_number' => 'required|string|min:8|max:14',
                    'cell_phone' => 'required|string|min:8|max:14',
                    'email_address' => 'required|unique:account|max:255',
                    'storage_space' => 'required|max:25',
                    'membership_type' => 'required|max:25',
                    'status' => 'required'

                ]);
             }
            
            if ($validator->fails()) 
            {
                
                    return redirect()->route('admin-add-account')
                            ->withErrors($validator)
                            ->withInput();
                
            }
            else {
                if(!empty($request->id)){
                    $account_list = AccountList::find($request->id);
                    $msg = 'Account has been updated successfully.';
                }else{
                    $account_list = new AccountList;
                    $msg = 'Account has been added successfully.';
                }
               
                $account_list->name = $name;
                $account_list->address = $address;
                $account_list->city = $city; 
                $account_list->state = $state; 
                $account_list->zip_code = $zip_code;              // dd($plan);
                $account_list->website = $website;  
                $account_list->contact_person = $contact_person;
                $account_list->office_number = $office_number;
                $account_list->cell_phone = $cell_phone;
                $account_list->membership_type = $membership_type;
                $account_list->membership_type_id = $membertypeId;

                if(empty($request->id)){  
                $account_list->email_address = $email_address;
                }
                $account_list->status = $status;


                //dd($account_list);
                $account_list->save();
                /* To create a new group at the time of creating Account Start */
                if(empty($request->id)){
                    $groupId = new Group;
                    $groupId->name  = ucfirst(trim($request->name));
                    $groupId->save();
                }

                if ( !empty($groupId->id) && ( !empty($account_list->id) ) ) { 
                    $accountToGroupInsert = new AccountToGroup;
                    $accountToGroupInsert->account_id  = $account_list->id;
                    $accountToGroupInsert->group_id    = $groupId->id;
                    $accountToGroupInsert->save();                  
                }  
                if(!empty($membertypeId) && (!empty($request->id))  ){
                   $membertypeData = MembershipType::find($membertypeId);
                   $storageAmount = $membertypeData['storage_amount'];
                   $groupIdStorage = $account_list->accountGroup->group_id;                    
                    $userIdStorage  = $account_list->users[0]['id'];
                 $countAccountToStorageSpace = AccountToStorageSpace::where('account_id',$account_list->id)->where('group_id',$groupIdStorage)->where('user_id',$userIdStorage)->update(['space_size' => $totalspace,'membertype_id' => $membertypeId]);
                if($countAccountToStorageSpace==0){
                  $accountToStorageSpace = new AccountToStorageSpace;
                    $accountToStorageSpace->account_id      = $account_list->id;
                    $accountToStorageSpace->group_id        = $groupIdStorage;
                    $accountToStorageSpace->user_id         = $userIdStorage;
                    $accountToStorageSpace->membertype_id   = $membertypeId;
                    $accountToStorageSpace->space_size      = $totalspace;
                    $accountToStorageSpace->save();  
                }
                }
                
                /* To create a new group at the time of creating Account Ends */

                ######### Here I am creating a Agency user with all privillages ######

                if(empty($request->id)){                   
                
                $email_array = explode("@", $email_address);

                $user = new User;
                $user->password = Hash::make($email_array[0]);
                $user->account_id = $account_list->id;
                $user->first_name = $name;
                $user->last_name = '';
                $user->email = strtolower($email_address);
                $user->phone = $office_number;
                $user->cell_phone = $cell_phone;  

                $user->save();
                if (!empty($groupId->id)&&!empty($user->id)) { 
                    UserGroup::insert(['group_id' =>$groupId->id, 'user_id' => $user->id]);

                    $accountToStorageSpace = new AccountToStorageSpace;
                    $accountToStorageSpace->account_id      = $account_list->id;
                    $accountToStorageSpace->group_id        = $groupId->id;
                    $accountToStorageSpace->user_id         = $user->id;
                    $accountToStorageSpace->membertype_id   = $membertypeId;
                    $accountToStorageSpace->space_size      = $totalspace;
                    $accountToStorageSpace->save();
                }  
                  
                 if (!empty($account_list->id)&&!empty($user->id)) {                    

					$vtype=array('Threat','Assault','Disturbance','Theft','Accident','Destruction of Property');
					foreach($vtype as $vt){
					$incidenttype = new IncidentType;

					$incidenttype->account_id  = $account_list->id;
					$incidenttype->user_id     = $user->id;
					$incidenttype->type = $vt;
					$incidenttype->description = $vt;
				   
					$incidenttype->updated_at =date('Y-m-d H:i:s');
					$incidenttype->save();
					}
				}
                ############ END Creating agency user ##############


                ######### Here I am creating a Agency user with all privillages ######
                DB::table('role_user')->insert(
                        ['role_id' => 2, 'user_id' => $user->id]
                    );


                $default_sector_array  =  array(
                    array('sector_name' => 'Status', 'description' => 'The overall current well-being of subject that relates to their stability such as their employment, relationships and health.'),
                    array('sector_name' => 'History', 'description' => 'Any incident or circumstances such as previous violent history, criminal record and any other concerning behaviors.'),
                    array('sector_name' => 'Threat', 'description' => 'The nature of the initial report, documentation of written, verbal or online threats, weapons capability or access and any information on the direct danger posed.'),
                    array('sector_name' => 'Social Media', 'description' => 'Social Media.'),
                    array('sector_name' => 'Relationships', 'description' => 'Relationships.'),
                    array('sector_name' => 'Weapons', 'description' => 'Weapons.')
                );
                   foreach ($default_sector_array as $key => $value) {

                               $sector_name =  $value['sector_name']; 
                               $description =  $value['description'];      

                    DB::table('account_sector')->insert(
                        [
                            'account_id' => $account_list->id, 
                            'user_id' => $user->id, 
                            'sector_name' => $sector_name, 
                            'description' => $description, 
                            'created_at' => date("Y-m-d")
                        ]
                    );
                   }
                } // end checking 
 
                ############ END Creating agency user ##############

                
                $request->session()->flash('add_message', $msg);
                return redirect()->route('admin-AccountList');
                
            }
        }
       
    return view('admin.add_account',['data'=>$account_detail,'noOfFiles'=>$noOfFiles,'spaceUploadFiles'=>$spaceUploadFiles,'memberShipPlan'=>$memberShipPlan,'extraSpace'=>$extraSpace]);
  }


  public function ajax_add_account(Request $request){
    $id = $request->accountId;
    $account_detail = array();
    if(!empty($id)){
        $account_detail = AccountList::find($id);
    }
    $memberShipPlan = MembershipType::get();
    $extraSpace = array('100'=>'100 MB','500'=>'500 MB','1000'=>'1 GB','1500'=>'1.5 GB','2000'=>'2 GB');
      if ($request->save == 1 ) { 
         $membershipId   = $request->membershipId;
         $membershipType = $request->membershipType;
         $totalspace = $request->totalspace;

                if(!empty($request->accountId)){
                    $account_list = AccountList::find($request->accountId);
                    $msg = 'Account has been updated successfully.';
                }else{
                    $account_list = new AccountList;
                    $msg = 'Account has been added successfully.';
                }
                $account_list->membership_type = $membershipType;
                $account_list->membership_type_id = $membershipId;
                $account_list->save();
                $membertypeData = MembershipType::find($membershipId);
                $storageAmount = $membertypeData['storage_amount'];
                $groupIdStorage = $account_list->accountGroup->group_id;                    
                $userIdStorage  = $account_list->users[0]['id'];

                $countAccountToStorageSpace = AccountToStorageSpace::where('account_id',$account_list->id)->where('group_id',$groupIdStorage)->where('user_id',$userIdStorage)->update(['space_size' => $totalspace,'membertype_id' => $membershipId]);
                if($countAccountToStorageSpace==0){
                  $accountToStorageSpace = new AccountToStorageSpace;
                    $accountToStorageSpace->account_id      = $account_list->id;
                    $accountToStorageSpace->group_id        = $groupIdStorage;
                    $accountToStorageSpace->user_id         = $userIdStorage;
                    $accountToStorageSpace->membertype_id   = $membershipId;
                    $accountToStorageSpace->space_size      = $totalspace;
                    $accountToStorageSpace->save();  
                }
                $request->session()->flash('add_message', $msg); 

      } 

    return view('admin.ajax_view_account',['account_detail'=>$account_detail,'memberShipPlan'=>$memberShipPlan,'extraSpace'=>$extraSpace]);
  }

   /**
    * Function change_account_status 
    *
    * function to get change starter Sector status
    *
    * @Created Date: 29 May, 2018
    * @Modified Date:  29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function change_account_status($account_id,$status, Request $request) {
        if ($account_id) {
            $status = base64_decode($status);
            //get user details
            $account_detail = AccountList::where('id',$account_id)->first();

            $account_detail->status = $status;
            $account_detail->save();

            if ($status == 'y') {
                $msg = 'Account has been activated successfully.';
            } else {
                $msg = 'Account has been Blocked successfully.';
            }

            $request->session()->flash('message', $msg);
        }
        return redirect()->route('admin-AccountList');
    }

    /**
    * Function account_delete
    *
    * function to delete account
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function account_delete($account_id, Request $request) {
        if ($account_id) {
            $resp = AccountList::where('id', '=', $account_id)->delete();
            if($resp){
                
                //delete all user of account
                $user = User::where('account_id',$account_id)->delete(); 
                $msg = 'Account and all the users in that account has been deleted successfully.';
                $request->session()->flash('message', $msg);
            }
        }
       return redirect()->route('admin-AccountList');
    }
    



 /**
    * Function sectorList
    *
    * function to get listing of sector
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function sectorList(Request $request) {
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        
        $pageNo = trim($request->input('page', 1));
        DB::enableQueryLog();
        //search fields
        $keyword = strtolower(trim($request->input('keyword'))); 
        $isActive = trim($request->input('isActive')); 
        //get user data
        //$account_list = AccountList::all();
        $exclusive_plan_Sectors = AccountSector::where('account_id','=', $account_id);

        $count = AccountSector::where('account_id','=', $account_id)->where('user_id', '=', $user_id)->count();
       // dd($count);
       if($isActive)
        {
            $exclusive_plan_Sectors->where('isActive', '=', $isActive);
        }
        if($keyword)
        {
             $exclusive_plan_Sectors->Where(function ($query) use ($keyword) {
                    $query->orwhere('sector_name', 'rlike', $keyword);
                });
        }
        $exclusive_plan_Sectors = $exclusive_plan_Sectors->orderby('created_at','desc');

       
        $this->data['records'] = $exclusive_plan_Sectors->paginate($this->record_per_page);
        // dd($this->data['records']->toArray());
        

        $queries = DB::getQueryLog();
        
        //dd($queries);
       
        return view('admin.sectorList', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request,'count'=>$count]);
    }


  /**
    * Function add_sector
    *
    * function to add Sectors 
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function add_sector(Request $request,$id = null){

        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
      //dd($id);
    $Sector_detail = array();
    if(!empty($id)){
        $Sector_detail = AccountSector::find($id);
    }
//dd($Sector_detail);
     if ($request->all()) { //post
       //dd($request->all());
           
            $sector_name = $request->sector_name; 
            $description = $request->description; 
            $isActive    = $request->isActive;
           

             $validator = Validator::make($request->all(), [
                    'sector_name' => 'required',
                    'isActive' => 'required'
                    
                ]);
            
            if ($validator->fails()) 
            {
                
                    return redirect()->route('admin-add-sector')
                            ->withErrors($validator)
                            ->withInput();
                
            }
            else {
                if(!empty($request->id)){
                    $account_Sector = AccountSector::find($request->id);
                    $msg = 'Sector has been updated successfully.';
                }else{
                    $account_Sector = new AccountSector;
                    $msg = 'Sector has been added successfully.';
                }
                
                $account_Sector->account_id  = $account_id;
                $account_Sector->user_id     = $user_id;
                $account_Sector->sector_name = $sector_name;
                $account_Sector->description = $description;
                $account_Sector->isActive    = $isActive;
                

                //dd($account_list);
                $account_Sector->save();

                
                $request->session()->flash('add_message', $msg);
                return redirect()->route('admin-sector-list');
                
            }
        }
       
    return view('admin.add_sector',['data'=>$Sector_detail]);
  }


    /**
    * Function sector_status 
    *
    * function to change Sector status
    *
    * @Created Date: 29 May, 2018
    * @Modified Date:  29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function sector_status($Sector_id,$isActive, Request $request) {
        if ($Sector_id) {
            $isActive = $isActive;
            //get user details
            $Sector_detail = AccountSector::where('id',$Sector_id)->first();

            $Sector_detail->isActive = $isActive;
            $Sector_detail->save();

            if ($isActive == 'y') {
                $msg = 'Sector has been activated successfully.';
            } else {
                $msg = 'Sector has been Blocked successfully.';
            }

            $request->session()->flash('message', $msg);
        }
        return redirect()->route('admin-sector-list');
    }


     /**
    * Function sector_delete
    *
    * function to delete Sectors
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function sector_delete($Sector_id, Request $request) {

        if ($Sector_id) {
            $resp = AccountSector::where('id', '=', $Sector_id)->delete();
            if($resp){
                $msg = 'Sector has been deleted successfully.';
                $request->session()->flash('message', $msg);
            }
        }
      return redirect()->route('admin-sector-list');
    }
    


    #############  Added By Subhendu on dated 21-05-2018 ###########
   
     

 /**
    * Function factorList
    *
    * function to get listing of factor
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function factorList(Request $request) {
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        
        $pageNo = trim($request->input('page', 1));
        DB::enableQueryLog();
        //search fields
        $keyword = strtolower(trim($request->input('keyword'))); 
        $target_chart_visibility = trim($request->input('target_chart_visibility')); 
        $timeline_chart_visibility = trim($request->input('timeline_chart_visibility')); 
        //get user data
        //$account_list = AccountList::all();
        $factorListArray = FactorList::where('account_id','=', $account_id)->where('user_id', '=', $user_id);

        $count = FactorList::where('account_id','=', $account_id)->where('user_id', '=', $user_id)->count();
       // dd($count);
       if($target_chart_visibility)
        {
            $factorListArray->where('target_chart_visibility', '=', $target_chart_visibility);
        }
        if($timeline_chart_visibility)
        {
            $factorListArray->where('timeline_chart_visibility', '=', $timeline_chart_visibility);
        }
        if($keyword)
        {
             $factorListArray->Where(function ($query) use ($keyword) {
                    $query->orwhere('title', 'rlike', $keyword);
                });
        }
        $factorListArray = $factorListArray->orderby('created_at','desc');

       
        $this->data['records'] = $factorListArray->paginate($this->record_per_page);
        // dd($this->data['records']->toArray());
        

        $queries = DB::getQueryLog();
        /*echo "<pre>";
        print_r($queries);
        echo "</pre>";*/
        //dd_my($queries);
        //dd(DB::getQueryLog());
        return view('admin.factorList', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request,'count'=>$count]);
    }


  /**
    * Function add_factor
    *
    * function to add factor
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function add_factor(Request $request,$id = null){
      //dd($id);
    $Sector_detail = array();
    if(!empty($id)){
        $Sector_detail = FactorList::find($id);
    }
//dd($Sector_detail);
     if ($request->all()) { //post
       //dd($request->all());
           
            $sector_name = $request->sector_name; 
            $isActive = $request->isActive;
           

             $validator = Validator::make($request->all(), [
                    'sector_name' => 'required',
                    'isActive' => 'required'
                    
                ]);
            
            if ($validator->fails()) 
            {
                
                    return redirect()->route('admin-add-sector')
                            ->withErrors($validator)
                            ->withInput();
                
            }
            else {
                if(!empty($request->id)){
                    $account_Sector = FactorList::find($request->id);
                    $msg = 'Sector has been updated successfully.';
                }else{
                    $account_Sector = new FactorList;
                    $msg = 'Sector has been added successfully.';
                }
                
                $account_Sector->sector_name = $sector_name;
                $account_Sector->isActive = $isActive;
                

                //dd($account_list);
                $account_Sector->save();

                
                $request->session()->flash('add_message', $msg);
                //return redirect()->route('admin-sector-list');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }
       
    return view('admin.add_factor',['data'=>$Sector_detail]);
  }


    /**
    * Function timeline_chart_visibility_status 
    *
    * function to change the timeline chart visibility
    *
    * @Created Date: 29 May, 2018
    * @Modified Date:  29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function timeline_chart_visibility_status($factor_id,$timeline_chart_visibility, Request $request) {
        if ($factor_id) {
            $timeline_chart_visibility = $timeline_chart_visibility;
            //get user details
            $factor_details = FactorList::where('id',$factor_id)->first();

            $factor_details->timeline_chart_visibility = $timeline_chart_visibility;
            $factor_details->save();

            if ($timeline_chart_visibility == 'y') {
                $msg = 'Timeline Chart Visibility Status has been activated successfully.';
            } else {
                $msg = 'Timeline Chart Visibility Status has been Blocked successfully.';
            }

            $request->session()->flash('message', $msg);
        }
        //return redirect()->route('admin-factor-list');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }


     /**
    * Function target_chart_visibility_status 
    *
    * function to change the visibility status of target chart
    *
    * @Created Date: 29 May, 2018
    * @Modified Date:  29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function target_chart_visibility_status($factor_id,$target_chart_visibility, Request $request) {
        if ($factor_id) {
            $target_chart_visibility = $target_chart_visibility;
            //get user details
            $factor_details = FactorList::where('id',$factor_id)->first();

            $factor_details->target_chart_visibility = $target_chart_visibility;
            $factor_details->save();

            if ($target_chart_visibility == 'y') {
                $msg = 'Target Chart Visibility Status has been activated successfully.';
            } else {
                $msg = 'Target Chart Visibility Status has been Blocked successfully.';
            }

            $request->session()->flash('message', $msg);
        }
       
        //return redirect()->route('admin-factor-list');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }


     /**
    * Function factor_delete
    *
    * function to delete factor
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function factor_delete($factor_id, Request $request) {
        if ($factor_id) {
            $resp = FactorList::where('id', '=', $factor_id)->delete();
            if($resp){
                $msg = 'Factor has been deleted successfully.';
                $request->session()->flash('message', $msg);
            }
        }
       //return redirect()->route('admin-factor-list');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
    

    

    
    
}