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
use App\Subject;
use App\CaseList;
use App\AccountList;
use App\Accounttask;
use App\FactorList;
use App\User;
use Session;
use Carbon\Carbon;
use DB;
use App\Target;
use App\File;
use App\Incident;
use App\Group;
class SubjectController extends AdminController
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
        $this->Subject_obj = new Subject();
        $this->CaseList_obj = new CaseList();
        $this->record_per_page=10;
    }
   
    /**
    * Function ajaxSaveSubject 
    *
    * function to Save Subject information
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */

    public function add(Request $request, $caseId=NULL,$subjectId=NULL){       
        if(empty($caseId)){
            return redirect()->route('admin-dashboard');
        }
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$id = $caseId = $caseId;
        if((!empty($subjectId) && ($subjectId>0) )){
        $data['subjectDetails'] = Subject::find($subjectId);            
        }else{
        //$data['subjectDetails'] = Subject::where('case_id',$id)->orderby('created_at','desc')->first();  
        $data['subjectDetails'] = array();
        }
        $data['CaseList'] = CaseList::with(['caseGroup'])->find($caseId);
        if($request->post()){
            if(empty($request->caseId)){
                return redirect()->route('admin-dashboard');
            }           
            
            if($request->subject_id > 0){
                $subjectData = Subject::find($request->subject_id);
            } else {
                $subjectData = new Subject;                    
            }
            $subjectData->account_id  = $account_id;
            $subjectData->created_by     = $user_id;
            $subjectData->case_id = $request->caseId;
            $subjectData->name = $request->name;
            $subjectData->phone_number = $request->phone_number;
            $subjectData->cell_phone = $request->cell_phone;
            $subjectData->address = $request->address;
            $subjectData->state = $request->state;
            $subjectData->city = $request->city;
            $subjectData->zip_code = $request->zip_code;
            $subjectData->save();            
            $msg = 'Subject has been updated successfully.';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('admin-managesubject',[$request->caseId]);
            return redirect()->route('admin-managesubject',[$request->caseId]);
            
        }
        return view('admin.add_subject', ['data' => $data, 'request' => $request,'caseId'=>$caseId]);
    }
    
    public function ajaxSaveSubject( Request $request) {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');                     
        if($request->subject_id > 0){
        //update case
            $subjectData = Subject::find($request->subject_id);
        } else {
            $subjectData = new Subject;                    
        }


                  /*if($_FILES['profile_pic']['size']>0){
                    
                    if($request->subject_id > 0){

                        if($request->profile_pic)
                            @unlink(public_path('uploads/subject/' . $request->profile_pic));
                    }
                    $imagename = ImageUpload($request->profile_pic,'subject');
                    $subjectData->profile_pic = $imagename;
                }*/
                if(isset($request->profile_pic))
                {
                    $image_url=$request->profile_pic;
                    $data = file_get_contents($image_url);
                    $filename = 'subject_'.basename($request->profile_pic);
                    if($request->subject_id > 0){
                    if($subjectData->profile_pic)
                            @unlink(public_path('uploads/subject/' . $subjectData->profile_pic));
                    }

                    $new = public_path('uploads/subject/' . $filename);
                    $upload =file_put_contents($new, $data);
                    $subjectData->profile_pic = $filename;
                }

              

                $subjectData->account_id  = $account_id;
                $subjectData->created_by     = $user_id;
                $subjectData->case_id = $request->case_id;
                $subjectData->name = $request->name;
                $subjectData->phone_number = $request->phone_number;
                $subjectData->cell_phone = $request->cell_phone;
                $subjectData->address = $request->address;
                $subjectData->state = $request->state;
                $subjectData->city = $request->city;
                $subjectData->zip_code = $request->zip_code;
                

                $subjectData->save();


   }    



    /**
    * Function ajaxGetSubjectDetails 
    *
    * function to get Subject Details
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxGetSubjectDetails( Request $request) {
            $account_id = $request->session()->get('account_id');
            
            $subject_id = (isset($request->subject_id))?$request->subject_id:'0';
            if($subject_id>0){
            $subjectDetailsArray = $this->Subject_obj->getSubjectDetails($subject_id);

            $data = array();
            $data['subjectDetailsArray'] =  $subjectDetailsArray;

            $caseId = $subjectDetailsArray->case_id;
          
            
            $data['caseList'] = CaseList::find($caseId);
            
            //dd($data);
            
            }
            else{
            $caseId = $request->case_id;
            $data = array();
            $data['subjectDetailsArray']   =  array();
            $data['caseList'] = CaseList::find($caseId);
           

            }

            return view('admin.ajax_view_subject', ['data' => $data, 'request' => $request]);
    }


      /**
    * Function ajaxAssignSubjectDetails 
    *
    * function to Assign Subject Details
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxAssignSubjectDetails( Request $request) {
           
            
            $subject_id = (isset($request->subject_id))?$request->subject_id:'0';
            if($subject_id>0){
            $taskDetailsArray = $this->Subject_obj->getSubjectDetails($subject_id);
            echo json_encode($taskDetailsArray);
            
            }
    }
    
    public function toGetUserOfGroup(Request $request){

        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');

        switch($request->session()->get('user_role_id')){            
            case '1' :
                 $userList =  DB::table('users')->get();
                 return $userList;
            break;
            case '2' : 
                $userList =  DB::table('users')->where('account_id', $account_id)->get();
                return $userList;
            break;
            default:
                $groupIds = DB::table('user_to_group')->where('user_id',$user_id)->pluck('group_id','group_id');
                $listOfuserBelongToGroups = User::with(['userGroup'])->whereIn('status', [1, 2])->where('account_id', $account_id);
                $listOfuserBelongToGroups->whereHas('userGroup', function ($q) use ($groupIds) {$q->whereIn('group_id',$groupIds);});
                $userList =   $userList = $listOfuserBelongToGroups->get(); 
                return $userList;
            break;
        }
    }
    
    public function deleteSubject(Request $request)
    {   //dd($request->subjectId);
        if((!empty($request->caseId)) && ($request->caseId>0) && (!empty(($request->subjectId)) &&($request->subjectId>0) ) ){
            $subject = Subject::where("id","=",$request->subjectId)->where("case_id","=",$request->caseId)->delete();
            $msg = 'Subject has been deleted successfully.';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('admin-viewCase',[$request->caseId]);
        }
    }
    
    public function subjectCaseList(Request $request){
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
                
                $subjectDetails = Subject::whereIn('case_id',$caseArray);
                if(isset($keyword) && $keyword!="")
                {
                $subjectDetails = $subjectDetails->Where(function ($query) use ($keyword) {
                $query->where('name', 'rlike', $keyword);
                });
                }        
                $subjectDetails = $subjectDetails->orderby('created_at','desc');
                $data['subjects'] = $subjectDetails = $subjectDetails->get();
            }
            $user_group = $request->session()->get('user_group');
            return view('admin.subject_mng',['data'=>$data,'request'=>$request]);
    }
    public function addSubjectInCase(Request $request){
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

            if($request->session()->get('user_role_id') > 2){
                $caseList->where('case_list.case_owner_id', $user_id);
            }         
            $caseList= $caseList->get(); 
            $caseId = 1;
        
            $data['subjectDetails'] = array();
            $data['caseListArray'] = $caseArray = $caseList = $caseList->pluck('title','id')->toArray(); 
        if($request->post()){            
            $subjectData = new Subject; 
            $subjectData->account_id  = $account_id;
            $subjectData->created_by     = $user_id;
            $subjectData->case_id = $request->caseId;
            $subjectData->name = $request->name;
            $subjectData->phone_number = $request->phone_number;
            $subjectData->cell_phone = $request->cell_phone;
            $subjectData->address = $request->address;
            $subjectData->state = $request->state;
            $subjectData->city = $request->city;
            $subjectData->zip_code = $request->zip_code;
            $subjectData->save();            
            $msg = 'Subject has been added successfully.';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('admin-subjectList');
        }
         return view('admin.add_subject_with_case_dropdown', ['data' => $data, 'request' => $request,'caseId'=>$caseId]);
    }
    public function managesubject(Request $request,$caseId){
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
        
        $subjectDetails = Subject::where('case_id',$id);
        if(isset($keyword) && $keyword!="")
        {
             $subjectDetails = $subjectDetails->Where(function ($query) use ($keyword) {
                    $query->where('name', 'rlike', $keyword);
                });
        }        
        $subjectDetails = $subjectDetails->orderby('created_at','desc');
        $data['subjectDetails'] = $subjectDetails = $subjectDetails->get();
        //$data['subjectDetails'] = Subject::where('case_id',$id)->orderby('created_at','desc')->get();
        return view('admin.case_subject_mng',['data'=>$data,'request'=>$request]);
        dd($data);
        echo $caseId;
    }
        
}