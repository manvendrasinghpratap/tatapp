<?php

namespace App\Http\Controllers\Admin;

use DB;
use Mail;
use Auth;
Use Config;
use Session;
use App\User;
use App\Site;
use Validator;
use App\Target;
use App\Subject;
use App\CaseList;
use Carbon\Carbon;
use App\FactorList;
use App\AccountList;
use App\Accounttask;
use Illuminate\Http\Request;
use App\Http\Middleware\ResizeImageComp;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\AdminController;
class TargetController extends AdminController
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
        $this->middleware('check_admin_status');
        $this->middleware('revalidate');
        $this->Target_obj = new Target();
        $this->record_per_page=10;
    }
   
    /**
    * Function ajaxSaveTarget 
    *
    * function to Save Target
    *
    * @Created Date: 19 June 2018
    * @Modified Date:  19 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
  
    public function getTargetDetail( Request $request,$caseId) 
    {
            if(empty($caseId)){
                return redirect()->route('admin-dashboard');
            }
            $account_id = $request->session()->get('account_id');
            $user_id = $request->session()->get('id');
            $data = array();
            $id = $caseId = $caseId;        
            $data['targetDetailsArray'] = Target::where('case_id',$id)->orderby('created_at','desc')->first();
            $data['caseList'] = CaseList::find($caseId);
            if($request->post()){
                if($request->target_id > 0){
                    $targetData = Target::find($request->target_id);
                } else {
                    $targetData = new Target;                    
                }                
                    $targetData->account_id  = $account_id;
                    $targetData->created_by     = $user_id;
                    $targetData->case_id = $request->caseId;
                    $targetData->name = $request->name;
                    $targetData->phone_number = $request->phone_number;
                    $targetData->cell_phone = $request->cell_phone;
                    $targetData->address = $request->address;
                    $targetData->state = $request->state;
                    $targetData->city = $request->city;
                    $targetData->zip_code = $request->zip_code;
                    $targetData->save();            
                    $msg = 'Case has been updated successfully.';
                    $request->session()->flash('add_message', $msg);
                    return redirect()->route('admin-viewCase',[$request->caseId]);
            }
            return view('admin.add_target', ['data' => $data, 'request' => $request,'caseId'=>$caseId]);
    }
    
    public function ajaxSaveTarget( Request $request) {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
          
          
        if($request->target_id > 0){

             //update case
                    $targetData = Target::find($request->target_id);
                } else {
                    
                    $targetData = new Target;
                    
                }


                  /*if($_FILES['profile_pic']['size']>0){
                    
                    if($request->target_id > 0){

                        if($request->profile_pic)
                            @unlink(public_path('uploads/target/' . $request->profile_pic));
                    }
                    $imagename = ImageUpload($request->profile_pic,'target');
                    $targetData->profile_pic = $imagename;
                }*/
                if(isset($request->profile_pic))
                {
                    $image_url=$request->profile_pic;
                    $data = file_get_contents($image_url);
                    $filename = 'target_'.basename($request->profile_pic);
                    if($request->subject_id > 0){
                    if($targetData->profile_pic)
                            @unlink(public_path('uploads/target/' . $targetData->profile_pic));
                    }

                    $new = public_path('uploads/target/' . $filename);
                    $upload =file_put_contents($new, $data);
                    $targetData->profile_pic = $filename;
                }

                $targetData->account_id  = $account_id;
                $targetData->created_by     = $user_id;
                $targetData->case_id = $request->case_id;
                $targetData->name = $request->name;
                $targetData->phone_number = $request->phone_number;
                $targetData->cell_phone = $request->cell_phone;
                $targetData->address = $request->address;
                $targetData->state = $request->state;
                $targetData->city = $request->city;
                $targetData->zip_code = $request->zip_code;
                

                $targetData->save();


   }

    /**
    * Function ajaxGetTargetDetails 
    *
    * function to get Target Details
    *
    * @Created Date: 19 June 2018
    * @Modified Date:  19 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxGetTargetDetails( Request $request) {
            $account_id = $request->session()->get('account_id');
            
            $target_id = (isset($request->target_id))?$request->target_id:'0';
            if($target_id>0){
            $targetDetailsArray = $this->Target_obj->getTargetDetails($target_id);

            $data = array();
            $data['targetDetailsArray'] =  $targetDetailsArray;

            $caseId = $targetDetailsArray->case_id;
          
            
            $data['caseList'] = CaseList::find($caseId);
            
            //dd($data);
            
            }
            else{
            $caseId = $request->case_id;
            $data = array();
            $data['targetDetailsArray']   =  array();
            $data['caseList'] = CaseList::find($caseId);
           

            }

            return view('admin.ajax_view_target', ['data' => $data, 'request' => $request]);
    }


      /**
    * Function ajaxAssignTargetDetails 
    *
    * function to Assign Target Details
    *
    * @Created Date: 19 June 2018
    * @Modified Date:  19 Jun e2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxAssignTargetDetails( Request $request) {
           
            
            $target_id = (isset($request->target_id))?$request->target_id:'0';
            if($target_id>0){
            $targetDetailsArray = $this->Target_obj->getTargetDetails($target_id);
            echo json_encode($targetDetailsArray);
            
            }
    }
    
    public function deleteTarget(Request $request)
    {   
        if((!empty($request->caseId)) && ($request->caseId>0)){
            $subject = Target::where("case_id","=",$request->caseId)->delete();
            $msg = 'Case target has been updated successfully.';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('admin-viewCase',[$request->caseId]);
        }
    }
	
	public function managetarget(Request $request,$caseId){
        if(empty($caseId)){
            return redirect()->route('admin-dashboard');
        }
        if (isset($_GET) && count($_GET)>0) {
            $keyword = strtolower(trim($request->input('keyword'))); 
         }
        
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$id = $caseId = $caseId;    
        $data['CaseList'] = CaseList::with(['caseGroup'])->find($caseId);
        
        $targetDetails = Target::where('case_id',$id);
        if(isset($keyword) && $keyword!="")
        {
             $targetDetails = $targetDetails->Where(function ($query) use ($keyword) {
                    $query->where('name', 'rlike', $keyword);
                });
        }        
        $targetDetails = $targetDetails->orderby('created_at','desc');
        $data['targetDetails'] = $targetDetails = $targetDetails->get();
        return view('admin.case_target_mng',['data'=>$data,'request'=>$request]);
    }

	public function add(Request $request, $caseId=NULL,$targetId=NULL){       
        if(empty($caseId)){
            return redirect()->route('admin-dashboard');
        }
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$id = $caseId = $caseId;
		$data['targetDetails'] = array();
        if((!empty($targetId) && ($targetId>0) )){
        $data['targetDetailsArray'] = Target::find($targetId);       
        }
        $data['CaseList'] = CaseList::with(['caseGroup'])->find($caseId);
        if($request->post()){
            if(empty($request->caseId)){
                return redirect()->route('admin-dashboard');
            }           
            
            if($request->target_id > 0){
                $targetData = Target::find($request->target_id);
				 $msg = 'Target has been updated successfully.';
            } else {
                $targetData = new Target;   
				$msg = 'Target has been added successfully.';				
            }
            $targetData->account_id  = $account_id;
            $targetData->created_by     = $user_id;
            $targetData->case_id = $request->caseId;
            $targetData->name = $request->name;
            $targetData->phone_number = $request->phone_number;
            $targetData->cell_phone = $request->cell_phone;
            $targetData->address = $request->address;
            $targetData->state = $request->state;
            $targetData->city = $request->city;
            $targetData->zip_code = $request->zip_code;
            $targetData->save();            
            $msg = 'Target has been updated successfully.';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('admin-managetarget',[$request->caseId]);
            
        }
        return view('admin.add_target', ['data' => $data, 'request' => $request,'caseId'=>$caseId]);
    }
	
	public function targetCaseList(Request $request){
            $data = array();
            $record_per_page=10;
            $account_id = $request->session()->get('account_id');
            $user_id = $request->session()->get('id');
            $user_role_name = $request->session()->get('user_role_name');	
            $user_role_id = $request->session()->get('user_role_id');	       
            $data['subjects'] = array();
             if (isset($_GET) && count($_GET)>0) {
                $keyword = strtolower(trim($request->input('keyword'))); 
             }
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
            $caseList= $caseList->get(); 
            $data['caseList'] = $caseArray = $caseList = $caseList->pluck('id')->toArray(); 
            if(!empty($caseArray) && (count($caseArray)>0)){                
                //$data['subjects'] = $subjects = Subject::whereIn('case_id',$caseArray)->orderBy('created_at', 'desc')->get();
                
                $targetDetails = Target::whereIn('case_id',$caseArray);
                if(isset($keyword) && $keyword!="")
                {
                $targetDetails = $targetDetails->Where(function ($query) use ($keyword) {
                $query->where('name', 'rlike', $keyword);
                });
                }        
                $targetDetails = $targetDetails->orderby('created_at','desc');
                $data['targets'] = $targetDetails = $targetDetails->get();
            }
            $user_group = $request->session()->get('user_group');
            return view('admin.target_mng',['data'=>$data,'request'=>$request]);
    }
	
	 public function addTargetInCase(Request $request){
            $data = array();
            $record_per_page=10;
            $account_id = $request->session()->get('account_id');
            $user_id = $request->session()->get('id');
            $user_role_name = $request->session()->get('user_role_name');	
            $user_role_id = $request->session()->get('user_role_id');	       
        
         
            $caseList = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
            ->Join('users', 'case_list.user_id', '=', 'users.id')
            ->Join('users as u2', 'case_list.case_owner_id', '=', 'u2.id')
            ->select('case_list.*', 'account.name as account_name', 'users.first_name as createrName', 'u2.first_name as caseOwnerId')
            ->orWhereNull('case_list.deleted_at')
            ->whereIn('case_list.status', ['new','active'])
            ->orderby('case_list.created_at','desc')
            ->where('case_list.account_id',$account_id);
            $user_group = $request->session()->get('user_group');
            if($request->session()->get('user_role_id') > 2){
                $caseList->whereHas('caseGroup', function ($q) use ($user_group) {$q->whereIn('group_id',$user_group);});
            }         
            $caseList= $caseList->get(); 
            $caseId = 1;
        
            
            $data['caseListArray'] = $caseArray = $caseList = $caseList->pluck('title','id')->toArray(); 
        if($request->post()){            
            $targetData = new Target; 
            $targetData->account_id  = $account_id;
            $targetData->created_by     = $user_id;
            $targetData->case_id = $request->caseId;
            $targetData->name = $request->name;
            $targetData->phone_number = $request->phone_number;
            $targetData->cell_phone = $request->cell_phone;
            $targetData->address = $request->address;
            $targetData->state = $request->state;
            $targetData->city = $request->city;
            $targetData->zip_code = $request->zip_code;
            $targetData->save();            
            $msg = 'Subject has been added successfully.';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('admin-targetList');
        }
         return view('admin.add_target_with_case_dropdown', ['data' => $data, 'request' => $request,'caseId'=>$caseId]);
    }
    
    
    
}