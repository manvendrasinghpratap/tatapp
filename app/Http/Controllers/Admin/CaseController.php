<?php
/* copied from account controller */
namespace App\Http\Controllers\Admin;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use PDF;
use Auth;
use App\Site;
use App\Http\Middleware\ResizeImageComp;
use Validator;
use Mail;
use Illuminate\Support\Facades\Hash;
Use Config;
use App\AccountList;
use App\CaseList;
use App\Subject;
use App\Incident;
use App\Target;
use App\File;
use App\FactorList;
use App\Forum;
use App\User;
use App\Tasks;
use App\Group;
use App\CaseTask;
Use App\CaseToGroup;
use App\ReportIncident;
use Session;
use Carbon\Carbon;
use DB;
class CaseController extends AdminController
{
    public $data = array();
    /**
    * Function __construct
    *
    * constructor
    *
    * @Created Date: 29 May 2018
    * @Modified Date: 29 May 2018
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
        $this->CaseList_obj = new CaseList();
        $this->record_per_page=10;
    }
    /**
    * Function index
    *
    * function to get listing of plans
    *
    * @Created Date: 29 May 2018
    * @Modified Date: 29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function index(Request $request) {
        $admin_id = $request->session()->get('id');
        $user_role_name = $request->session()->get('user_role_name');
        
        if ($user_role_name!="superAdmin")
         {                 
           $account_id = $request->session()->get('account_id');
         } 
        $pageNo = trim($request->input('page', 1));
        
        //search fields
        if (isset($_GET) && count($_GET)>0) {
            //dd($_GET);
            $keyword = strtolower(trim($request->input('keyword'))); 
            $status = trim($request->input('status')); 
            $user_type_id = trim($request->user_type_id);
            if ($user_role_name=="superAdmin")
            {
                 $account_id = trim($request->input('account_id'));
            }
            else{
                $account_id = $request->session()->get('account_id');
            } 
         }
        $group_filter =  trim($request->input('group_filter')); 
        
        $account_list = array();
        if ($user_role_name=="superAdmin")
        {
             $account_list = AccountList::get();
        } 
        $user_id = $request->session()->get('id');
        $group = Group::with(['userGroup'])->with('accountGroup') ;
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
            
        }
        $group = $group->orderBy('created_at', 'desc')->get(); 

       


        DB::enableQueryLog();
        $user_group = $request->session()->get('user_group');
       
        $caseListArray = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
        ->orWhereNull('case_list.deleted_at')
        ->select('case_list.*', 'account.name')
        ->with(['caseOwnerName','caseGroup']);
        
        /**
        * @Modified By: Shweta Trivedi * @Modified Date: 17-02-20
        * @Disciption : Globle and Super Admin user can access all cases but Other user can manage and view Case based on their group
        */
        if(!in_array($request->session()->get('user_role_id'), array(1,2)))
        {
           $caseListArray = $caseListArray->whereHas('caseGroup', function ($q) use ($user_group) {$q->whereIn('group_id',$user_group);});
            
        }
        
        if(isset($status) && $status!="")
        {
            $caseListArray->where('case_list.status',$status);
        }
  
        if(isset($account_id) && $account_id!="")
        {
                $caseListArray->where('case_list.account_id',$account_id);
        }
        
        if(isset($group_filter) && $group_filter!="")
        {
            //dd($group_filter);
            $caseListArray->whereHas('caseGroup', function ($q) use ($group_filter) {$q->where('group_id',$group_filter);});
        }

        if(isset($keyword) && $keyword!="")
        {
             $caseListArray->Where(function ($query) use ($keyword) {
                    $query->orwhere('case_list.title', 'rlike', $keyword);
                });
        }
        $caseListArray = $caseListArray->orderby('case_list.created_at','desc');
        $this->data['records'] = $caseListArray->paginate($this->record_per_page);
        $queries = DB::getQueryLog();
        return view('admin.case_mng', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list, 'group'=>$group]);
    }




    /**
    * Function edit_case
    *
    * function to edit case
    *
    * @Created Date: 29 May 2018
    * @Modified Date: 29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
     public function edit_case(Request $request, $id = '') {

        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $accountsList = AccountList::find($account_id);
        $imagenotuploadedmsg = '';
        //echo '<pre>'; print_r($accountsList->accountToStorageSpaceUsed); echo '</pre>'; 
        $defaultSpace = 0 ;
        if($accountsList->accountToStorageSpaceUsed){
            $defaultSpace = $accountsList->accountToStorageSpaceUsed->space_assigned - $accountsList->accountToStorageSpaceUsed->space_used;
        }

        $user_id = $request->session()->get('id');

        $data = array();
        $data = CaseList::with(['caseGroup'])->find($id);
        $groupIds = DB::table('user_to_group')->where('user_id',$user_id)->pluck('group_id','group_id');
        $listOfuserBelongToGroups = User::with(['userGroup'])->whereIn('status', [1, 2])->where('account_id', $account_id);
        $listOfuserBelongToGroups->whereHas('userGroup', function ($q) use ($groupIds) {$q->whereIn('group_id',$groupIds);});
        $userList = $listOfuserBelongToGroups->get(); 
        //$group = Group::with(['accountGroup'])->orderBy('name', 'asc')->get();
        $group = Group::with(['userGroup'])->with('accountGroup') ;
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
        }
        $group = $group->orderBy('created_at', 'desc')->get(); 

        $category = array();
        if ($request->all()) {
             //post
             $picSize = 0;

            //die();
            $title = $request->title; 
            $description = $request->description; 
            $status = $request->status;
            $urgency = $request->urgency;
            $case_owner_id = $request->case_owner_id1;
            $group_id = $request->group;
            
            if ($id) {
            
                //Validate the input
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description' => 'required',
                    'status' => 'required',
                    'urgency' => 'required',
                    'case_owner_id1' => 'required'
                    
                    
                ]);
                }
                else {
                //Validate the input
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description' => 'required',
                    'status' => 'required',
                    'urgency' => 'required',
                    'case_owner_id1' => 'required'
                ]);
            }
            if ($validator->fails()) 
            {
                
                    return redirect()->route('admin-viewCase',$id)
                            ->withErrors($validator)
                            ->withInput();
                
            }
            else {




                //echo $id; die();
                if ($id) { //update case              
                    $caseList = CaseList::find($id);
                } else {                   
                    $caseList = new CaseList;
                    
                }

                  if ($request->default_pic) {    
                             $picSize = round($request->file('default_pic')->getSize()/1024000,3);  
                             if($defaultSpace>=$picSize){
                                if($id)
                                {
                                    if($data->default_pic)
                                        @unlink(public_path('uploads/package/' . $request->default_pic));
                                }

                                $imagename = ImageUpload($request->default_pic,'package');

                            }else{
                                $imagenotuploadedmsg = 'But Image not uploaded due to lack Storage Space';
                            }
                                
                            }

				  if ($request->chart_icon) {                   
                    $imagename_chart_icon = $request->chart_icon;
                }
                $caseList->account_id  = $account_id;
                $caseList->user_id     = $user_id;
                $caseList->title = $title;
                $caseList->description = $description;
                $caseList->status = $status;
                $caseList->urgency = $urgency;
                $caseList->case_owner_id = $case_owner_id;
                $caseList->pic_size = $picSize;

                if(!empty($imagename)){
                    $caseList->default_pic = $imagename;
                }
                 if(!empty($imagename_chart_icon)){
                    $caseList->chart_icon = $imagename_chart_icon;
                }
              
                $caseList->save();
               

                if ($id) {                    
                    $caseGroup = CaseToGroup::where('case_id', '=', $id)->update(['group_id' => $group_id]);
                    if(!$caseGroup)
                    {
                        $caseGroup = CaseToGroup::insertGetId(['case_id' => $id, 'group_id' => $group_id ]);
                    }
                    $msg = 'Case has been updated successfully.';
                    $request->session()->flash('add_message', $msg);
                  //return view('admin.add_case', ['request' => $request, 'data' => $caseList, 'userList' =>  $userList ]);
                  return redirect()->route('admin-caseList');
                }
                else {
                     $caseGroup = CaseToGroup::insertGetId(['case_id' => $caseList->id, 'group_id' => $group_id ]);
                    
                    //send mail

                    ########### HERE I AM creating a default forum as per client requirement ##
                        $this->Forum_obj = new Forum();
                        $this->Forum_obj->account_id  = $account_id;
                        $this->Forum_obj->created_by  = $user_id;
                        $this->Forum_obj->case_id     = $caseList->id;
                        $this->Forum_obj->title        = $title;
                        $this->Forum_obj->description = $description;
                        $this->Forum_obj->save();

                    ######### END OF FORUM ADDITION ##
                   
                    $msg = 'Case has been added successfully.'.$imagenotuploadedmsg;
                    $request->session()->flash('add_message', $msg);                
                    return redirect()->route('admin-caseList');
                }
            }
        }
        else {
            return view('admin.add_case', ['data' => $data, 'request' => $request, 'userList' =>  $userList, 'group' => $group,'defaultSpace'=>$defaultSpace ]);
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

    /**
    * Function view_case
    *
    * function to view plans
    *
    * @Created Date: 29 May 2018
    * @Modified Date: 29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
     public function view_case(Request $request, $id = '') {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$caseId = $id;
        $data['caseDetails'] = CaseList::with(['caseGroup'])->find($id);
        $data['userList'] = $this->toGetUserOfGroup($request);
        $data['subjectDetails'] = Subject::where('case_id',$id)->orderby('created_at','desc')->get();
        $data['targetDetails'] = Target::where('case_id',$id)->orderby('created_at','desc')->get();
        $data['fileDetails'] = File::where('case_id',$id)->orderby('created_at','desc')->get();
		
		  $data['incidentDetails'] = Incident::Join('incident_type','incident_type.id','=','incident.type')
			 ->Join('incident_linkto_report AS c', function($Join) use ($caseId){
					$Join->on('c.incident_id', '=', 'incident.id')->where('c.case_id', '=', $caseId);
			})->orWhereNull('incident.deleted_at')
			->select('c.incident_id','incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident.created_at','c.id as linkedid')->get();
		 $data['add_note'] = DB::table('add_note')->select('*')->where('case_id',$id)->where('user_id', $user_id)->orderby('id','desc')->get();

        $accountsList = AccountList::find($account_id);
        $imagenotuploadedmsg = '';
        //echo '<pre>'; print_r($accountsList->accountToStorageSpaceUsed); echo '</pre>'; 
        $defaultSpace = 0 ;
        if($accountsList->accountToStorageSpaceUsed){
            $defaultSpace = $accountsList->accountToStorageSpaceUsed->space_assigned - $accountsList->accountToStorageSpaceUsed->space_used;
        }


        $group = Group::with(['userGroup'])->with('accountGroup') ;
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
        }
        $group = $group->orderBy('created_at', 'desc')->get(); 
		// $queries = DB::getQueryLog();
            //dd($queries);
		 
        //dd($request->session());
      //  dd($data['incidentDetails']);
     
           
        
        
        $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);

        $arrProp = array();
        $arrProp['sector_name'] = 'Target';
        $arrProp['account_id'] = $account_id;
        $arrProp['user_id']    = $user_id;
        $data['isSectorDataAlreadyExist'] = CaseList::isSectorDataAlreadyExist($arrProp);



        $data['getAllSectorByCaseId'] = CaseList::getAllSectorByCaseId($caseId);
        $data['getAllVisibleSectorByCaseId'] = CaseList::getAllVisibleSectorByCaseId($caseId);
        
        $data['getAllVisibleFactorByCaseId'] = $this->CaseList_obj->getAllVisibleFactorByCaseId($caseId);
        $data['getAllTaskByCaseId'] = CaseList::getAllTaskByCaseId($caseId);
        

        $data['getAllVisibleTimeLineDataByCaseId'] = $this->CaseList_obj->getAllVisibleTimeLineDataByCaseId($caseId);
        
        //dd($data);
                
        
         $category = array();
        if ($id) {
            $data['caseList'] = CaseList::find($id);
        }
        // dd($data['caseDetails']->task); // old view file is view_case_old
        return view('admin.view_case', ['data' => $data, 'request' => $request,'group'=>$group,'defaultSpace'=>$defaultSpace]);
       
    }
    

   /**
    * Function view_target_chart
    *
    * function to view target chart
    *
    * @Created Date: 29 May 2018
    * @Modified Date: 29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
     public function view_target_chart(Request $request, $id = '') {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
        $data['userList'] =  DB::table('users')
                ->where('account_id', $account_id)
                ->get();

       //dd($request->session());
     
           
        
        $caseId = $id;
        $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);

        $arrProp = array();
        $arrProp['sector_name'] = 'Target';
        $arrProp['account_id'] = $account_id;
        $arrProp['user_id']    = $user_id;
        $data['isSectorDataAlreadyExist'] = CaseList::isSectorDataAlreadyExist($arrProp);



        $data['getAllSectorByCaseId'] = CaseList::getAllSectorByCaseId($caseId);
        $data['getAllVisibleSectorByCaseId'] = CaseList::getAllVisibleSectorByCaseId($caseId);
        
        $data['getAllVisibleFactorByCaseId'] = $this->CaseList_obj->getAllVisibleFactorByCaseId($caseId);

        $data['getAllVisibleTimeLineDataByCaseId'] = $this->CaseList_obj->getAllVisibleTimeLineDataByCaseId($caseId);
        
        //dd($data);
                
        
         $category = array();
        if ($id) {
            $data['caseList'] = CaseList::find($id);
        }
        //dd($data);
        if ($request->all()) { //post

           //dd($request);
            $title = $request->title; 
            $description = $request->description; 
            $status = $request->status;
            $summary_rank = $request->summary_rank;
            $urgency = $request->urgency;
            $case_owner_id = $request->case_owner_id;
            $sector_id = $request->sector_id;
            
                if ($id) {
            
                //Validate the input
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description' => 'required',
                    'status' => 'required',
                    'summary_rank' => 'required',
                    'urgency' => 'required',
                    'case_owner_id' => 'required',
                    'sector_id' => 'required'
                    
                ]);
                }
                else {
                //Validate the input
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description' => 'required',
                    'status' => 'required',
                    'summary_rank' => 'required',
                    'urgency' => 'required',
                    'case_owner_id' => 'required',
                    'sector_id' => 'required'
                    
                ]);
            }
            if ($validator->fails()) 
            {
                
                    return redirect()->route('admin-caseList')
                            ->withErrors($validator)
                            ->withInput();
                
            }
            else {

               
                if ($id) { //update case
                    $caseList = CaseList::find($id);
                } else {
                    
                    $caseList = new CaseList;
                    $caseList->status = '1'; //Active default
                }


                  if ($request->plan_image) {
                    
                    if($id)
                    {
                        if($data->plan_image)
                            @unlink(public_path('uploads/package/' . $request->plan_image));
                    }
                    $imagename = ImageUpload($request->plan_image,'package');
                }
                
                $caseList->title = $title;
                $caseList->description = $description;
                $caseList->status = $status;
                $caseList->summary_rank = $summary_rank;
                $caseList->urgency = $urgency;
                $caseList->case_owner_id = $case_owner_id;
                $caseList->sector_id = $sector_id;

                

                

                if(!empty($imagename)){
                    $caseList->plan_image = $imagename;
                }
                
                $caseList->plan_id_stripe = $caseList_id_stripe;
               // dd($caseList);
                $caseList->save();

                if ($id) {
                    $msg = 'Plan has been updated successfully.';
                    $request->session()->flash('add_message', $msg);
                   return view('admin.add_case', ['request' => $request, 'data' => $caseList]);
                }
                else {
                    //send mail
                   
                    $msg = 'Plan has been added successfully.';
                    $request->session()->flash('add_message', $msg);
                    return redirect()->route('admin-addPlan');
                }
            }
        }
        else {
            return view('admin.view_target_chart', ['data' => $data, 'request' => $request]);
        }
    }
    

    
    
    /**
    * Function ajaxGetFactorDetails 
    *
    * function to get Factor Details 
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function addNewFactor( Request $request,$caseId) {
            $account_id = $request->session()->get('account_id');
            $factor_id = (isset($request->factor_id))?$request->factor_id:'0';
			$factorDetailsArray = $this->CaseList_obj->getFactorDetails($factor_id); 
			$data['factorDetailsArray']   =  array();
			if($factor_id>0){
				$factorDetailsArray = $this->CaseList_obj->getFactorDetails($factor_id);
				$data['factorDetailsArray'] =  $factorDetailsArray;
				if(!isset($caseId))  $caseId = $factorDetailsArray->case_id;
				 $data['fileListArray'] =  File::join('factor_files', 'files.id', '=', 'factor_files.case_file_id')
                ->select('files.*', 'factor_files.case_file_id as case_file_id')
                ->where('files.case_id', $caseId)
                ->where('factor_files.factor_id', $factor_id)
                ->groupBy('files.id')
                ->orderby('files.id','desc')
                ->get();
			}			
            $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
			$data['caseList'] = CaseList::find($caseId);
			$data['factor_id'] = $factor_id;
              if($request->post())
              { 
                $validator = Validator::make($request->all(), [
                'title' => 'required',
                'rank_id' => 'required',
                'sector_id' => 'required',
                'source' => 'required',
                'description'=> 'required', 

        ]);

        if ($validator->fails()) {
            return redirect('admin/addNewFactor/65')
                        ->withErrors($validator)
                        ->withInput();
        }



                    $this->saveFactorDetails($request);
                    $msg = 'Factor has been added successfully.';
                    $request->session()->flash('add_message', $msg);
                    return redirect()->route('admin-viewCase',[$request->case_id]);
              }
            return view('admin.add_view_sector', ['data' => $data, 'request' => $request,'caseId'=>$caseId]);
    }
    
    public function getFactorsList(Request $request, $caseId,$type){
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
        $id= $caseId;
        $data['caseDetails'] = CaseList::with(['caseGroup'])->find($caseId);
        $data['userList'] = $this->toGetUserOfGroup($request);		
		$data['incidentDetails'] = Incident::Join('incident_type','incident_type.id','=','incident.type')
			 ->Join('incident_linkto_report AS c', function($Join) use ($caseId){
					$Join->on('c.incident_id', '=', 'incident.id')->where('c.case_id', '=', $caseId);
			})->orWhereNull('incident.deleted_at')
			->select('c.incident_id','incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident.created_at','c.id as linkedid')->get();
		 $data['add_note'] = DB::table('add_note')->select('*')->where('case_id',$id)->where('user_id', $user_id)->orderby('id','desc')->get();

        $accountsList = AccountList::find($account_id);
        $imagenotuploadedmsg = '';
        $defaultSpace = 0 ;
        if($accountsList->accountToStorageSpaceUsed){
            $defaultSpace = $accountsList->accountToStorageSpaceUsed->space_assigned - $accountsList->accountToStorageSpaceUsed->space_used;
        } 
        $arrProp = array();
        $arrProp['account_id'] = $account_id;
        $arrProp['user_id']    = $user_id;
        $data['getAllSectorByCaseId'] = CaseList::getAllSectorByCaseId($caseId);
        $data['getAllVisibleSectorByCaseId'] = CaseList::getAllVisibleSectorByCaseId($caseId);        
        $data['getAllVisibleFactorByCaseId'] = $this->CaseList_obj->getAllVisibleFactorByCaseId($caseId);
        $data['getAllTaskByCaseId'] = CaseList::getAllTaskByCaseId($caseId);
        $data['getAllVisibleTimeLineDataByCaseId'] = $this->CaseList_obj->getAllVisibleTimeLineDataByCaseId($caseId);
         $category = array();
        if ($id) {
            $data['caseList'] = CaseList::find($id);
        }
        if($type=='factors'){
            return view('admin.listfactors', ['data' => $data, 'request' => $request,'defaultSpace'=>$defaultSpace]);            
        }elseif($type=='notes'){
            return view('admin.listCaseNotes', ['data' => $data, 'request' => $request,'defaultSpace'=>$defaultSpace]);            
        }elseif($type=='tasks'){
            return view('admin.listCaseTasks', ['data' => $data, 'request' => $request,'defaultSpace'=>$defaultSpace]);
        }elseif($type == 'incidents'){
            return view('admin.listCaseIncident', ['data' => $data, 'request' => $request,'defaultSpace'=>$defaultSpace]);            
        }
        
    }
    public function Corkboard(Request $request,$caseId){
        $data['casecorkboard'] = CaseList::getAllSectorByCaseId($caseId);
        return view('admin.casecorkboard', ['data' => $data,'request'=>$request]);   

    }

    public function getTasksList(Request $request, $caseId){
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
        $id= $caseId;
        $data['caseDetails'] = CaseList::with(['caseGroup'])->find($caseId);
        $data['userList'] = $this->toGetUserOfGroup($request);		
		$data['incidentDetails'] = Incident::Join('incident_type','incident_type.id','=','incident.type')
			 ->Join('incident_linkto_report AS c', function($Join) use ($caseId){
					$Join->on('c.incident_id', '=', 'incident.id')->where('c.case_id', '=', $caseId);
			})->orWhereNull('incident.deleted_at')
			->select('c.incident_id','incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident.created_at','c.id as linkedid')->get();
		 $data['add_note'] = DB::table('add_note')->select('*')->where('case_id',$id)->where('user_id', $user_id)->orderby('id','desc')->get();

        $accountsList = AccountList::find($account_id);
        $imagenotuploadedmsg = '';
        $defaultSpace = 0 ;
        if($accountsList->accountToStorageSpaceUsed){
            $defaultSpace = $accountsList->accountToStorageSpaceUsed->space_assigned - $accountsList->accountToStorageSpaceUsed->space_used;
        } 
        $arrProp = array();
        $arrProp['account_id'] = $account_id;
        $arrProp['user_id']    = $user_id;
        $data['getAllSectorByCaseId'] = CaseList::getAllSectorByCaseId($caseId);
        $data['getAllVisibleSectorByCaseId'] = CaseList::getAllVisibleSectorByCaseId($caseId);        
        $data['getAllVisibleFactorByCaseId'] = $this->CaseList_obj->getAllVisibleFactorByCaseId($caseId);
        $data['getAllTaskByCaseId'] = CaseList::getAllTaskByCaseId($caseId);
        $data['getAllVisibleTimeLineDataByCaseId'] = $this->CaseList_obj->getAllVisibleTimeLineDataByCaseId($caseId);
         $category = array();
        if ($id) {
            $data['caseList'] = CaseList::find($id);
        }
        return view('admin.listfactors', ['data' => $data, 'request' => $request,'defaultSpace'=>$defaultSpace]);
    }
    
    public function getIncidentsList(Request $request, $caseId){
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
        $id= $caseId;
        $data['caseDetails'] = CaseList::with(['caseGroup'])->find($caseId);
        $data['userList'] = $this->toGetUserOfGroup($request);		
		$data['incidentDetails'] = Incident::Join('incident_type','incident_type.id','=','incident.type')
			 ->Join('incident_linkto_report AS c', function($Join) use ($caseId){
					$Join->on('c.incident_id', '=', 'incident.id')->where('c.case_id', '=', $caseId);
			})->orWhereNull('incident.deleted_at')
			->select('c.incident_id','incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident.created_at','c.id as linkedid')->get();
		 $data['add_note'] = DB::table('add_note')->select('*')->where('case_id',$id)->where('user_id', $user_id)->orderby('id','desc')->get();

        $accountsList = AccountList::find($account_id);
        $imagenotuploadedmsg = '';
        $defaultSpace = 0 ;
        if($accountsList->accountToStorageSpaceUsed){
            $defaultSpace = $accountsList->accountToStorageSpaceUsed->space_assigned - $accountsList->accountToStorageSpaceUsed->space_used;
        } 
        $arrProp = array();
        $arrProp['account_id'] = $account_id;
        $arrProp['user_id']    = $user_id;
        $data['getAllSectorByCaseId'] = CaseList::getAllSectorByCaseId($caseId);
        $data['getAllVisibleSectorByCaseId'] = CaseList::getAllVisibleSectorByCaseId($caseId);        
        $data['getAllVisibleFactorByCaseId'] = $this->CaseList_obj->getAllVisibleFactorByCaseId($caseId);
        $data['getAllTaskByCaseId'] = CaseList::getAllTaskByCaseId($caseId);
        $data['getAllVisibleTimeLineDataByCaseId'] = $this->CaseList_obj->getAllVisibleTimeLineDataByCaseId($caseId);
         $category = array();
        if ($id) {
            $data['caseList'] = CaseList::find($id);
        }
        return view('admin.listfactors', ['data' => $data, 'request' => $request,'defaultSpace'=>$defaultSpace]);
    }
   
    /* Changes in new layout begin its working */
   public function ajaxGetFactorDetails( Request $request) {
            //dd($request->all());
            $account_id = $request->session()->get('account_id');
            $factor_id = (isset($request->factor_id))?$request->factor_id:'0';
			$factorDetailsArray = $this->CaseList_obj->getFactorDetails($factor_id);
			$caseId = $request->case_id;  
			$data['factorDetailsArray']   =  array();
			if($factor_id>0){
				$factorDetailsArray = $this->CaseList_obj->getFactorDetails($factor_id);
				$data['factorDetailsArray'] =  $factorDetailsArray;
				if(!isset($caseId))  $caseId = $factorDetailsArray->case_id;
				 $data['fileListArray'] =  File::join('factor_files', 'files.id', '=', 'factor_files.case_file_id')
                ->select('files.*', 'factor_files.case_file_id as case_file_id')
                ->where('files.case_id', $caseId)
                ->where('factor_files.factor_id', $factor_id)
                ->groupBy('files.id')
                ->orderby('files.id','desc')
                ->get();
			}			
            $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
			$data['caseList'] = CaseList::find($caseId);
			$data['factor_id'] = $factor_id;			
            return view('admin.ajax_view_sector', ['data' => $data, 'request' => $request]);
    }


    public function ajaxGetFactorDetailscorkboard( Request $request) {
        //dd($request->all());
        $account_id = $request->session()->get('account_id');
        $factor_id = (isset($request->factor_id))?$request->factor_id:'0';
        $factorDetailsArray = $this->CaseList_obj->getFactorDetails($factor_id);
        $caseId = $request->case_id;  
        $data['factorDetailsArray']   =  array();
        if($factor_id>0){
            $factorDetailsArray = $this->CaseList_obj->getFactorDetails($factor_id);
            $data['factorDetailsArray'] =  $factorDetailsArray;
            if(!isset($caseId))  $caseId = $factorDetailsArray->case_id;
             $data['fileListArray'] =  File::join('factor_files', 'files.id', '=', 'factor_files.case_file_id')
            ->select('files.*', 'factor_files.case_file_id as case_file_id')
            ->where('files.case_id', $caseId)
            ->where('factor_files.factor_id', $factor_id)
            ->groupBy('files.id')
            ->orderby('files.id','desc')
            ->get();
        }			
        $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
        $data['caseList'] = CaseList::find($caseId);
        $data['factor_id'] = $factor_id;			
        return view('admin.ajax_view_sector_corkboard', ['data' => $data, 'request' => $request]);
}

   

    /**
    * Function ajaxAssignFactorDetails 
    *
    * function to set Factor data
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxAssignFactorDetails( Request $request) {
           
            
            $factor_id = (isset($request->factor_id))?$request->factor_id:'0';
            if($factor_id>0){
            $factorDetailsArray = $this->CaseList_obj->getFactorDetails($factor_id);
            echo json_encode($factorDetailsArray);
            
            }
    }

    
/**
    * Function SaveFactor 
    *
    * function to save Factor data
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function saveFactorDetails( Request $request) {
        //dd($request->all());
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');

        $target_chart_visibility = ($request->target_chart_visibility=="on")?'y':'n';
        $timeline_chart_visibility = ($request->timeline_chart_visibility=="on")?'y':'n';

        if($request->factor_id > 0){   
                DB::table('factor_list')
                  ->where('id', $request->factor_id)
                  ->update([
                    'account_id' => $account_id, 
                    'user_id' => $user_id,
                    'sector_id' => $request->sector_id, 
                    'case_id' => $request->case_id,
                    'title' => $request->title, 
                    'description' => $request->description,
                    'rank_id' => $request->rank_id, 
                    'source' => $request->source,
                    'occurance_date' => $request->occurance_date, 
                    'target_chart_visibility' => $target_chart_visibility,
					'chart_icon' => $request->chart_icon,
                    'timeline_chart_visibility' => $timeline_chart_visibility 
                ]
              );				
            }
            else{
                $arrProp = array();
                $arrProp['case_id'] = $request->case_id;
                $arrProp['sector_id'] = $request->sector_id;
                $arrProp['title'] = $request->title; // factor name
                $arrProp['rank_id'] = $request->rank_id;
                $resp = $this->CaseList_obj->isFactorDataAlreadyExist($arrProp);
                if(!$resp)
                {
                    if($request->factor_id > 0)
                    {
                        DB::table('factor_list')
                          ->where('id', $request->factor_id)
                          ->update(
                        [
                            'account_id' => $account_id, 
                            'user_id' => $user_id,
                            'sector_id' => $request->sector_id, 
                            'case_id' => $request->case_id,
                            'title' => $request->title, 
                            'description' => $request->description,
                            'rank_id' => $request->rank_id, 
                            'source' => $request->source,
                            'occurance_date' => $request->occurance_date, 
                            'target_chart_visibility' => $target_chart_visibility,
                            'chart_icon' => $request->chart_icon,
                            'timeline_chart_visibility' => $timeline_chart_visibility 
                        ]
                      );
                    }
                    else{				
                        $id = DB::table('factor_list')->insertGetId(
                        [
                            'account_id' => $account_id, 
                            'user_id' => $user_id,
                            'sector_id' => $request->sector_id, 
                            'case_id' => $request->case_id,
                            'title' => $request->title, 
                            'description' => $request->description,
                            'rank_id' => $request->rank_id, 
                            'source' => $request->source,
                            'occurance_date' => $request->occurance_date, 
                            'target_chart_visibility' => $target_chart_visibility,
                            'chart_icon' => $request->chart_icon,
                            'timeline_chart_visibility' => $timeline_chart_visibility 
                        ]
                      );
			         if($request->temp_id!='')
                     { 
                            if(!empty($id))
                            {
                                $fileListArray =  DB::table('factor_files')->where('factor_id', '=', $request->temp_id)->get();
                                if($fileListArray && count($fileListArray)>0 && $fileListArray[0]->factor_id){
                                $iid = DB::table('factor_files')->where('factor_id', $request->temp_id)
                                    ->update(
                                [
                                'factor_id' => $id					
                                ]
                                );

                                $fileListArray =  DB::table('factor_files')->where('factor_id', '=', $id)->get();
                                if($fileListArray[0]->profile_pic){
                                $path = get_image_url($fileListArray[0]->profile_pic,'files');
                                $image_url=$path;
                                $data = file_get_contents($image_url);
                                $filename = 'factor_'.basename($image_url);
                                $new = public_path('uploads/package/' . $filename);
                                $upload =file_put_contents($new, $data);
                                DB::table('factor_list')
                                ->where('id', $id)
                                ->update(
                                [
                                'default_pic' => $filename,
                                ]);
                                }
                                }
                            }
                   }
			   
            }
            
        }
     }
        
    }
    
    
    /**
    * Function ajaxSaveFactor 
    *
    * function to save Factor data
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxSaveFactor( Request $request) {

        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');

        $target_chart_visibility = ($request->target_chart_visibility=="on")?'y':'n';
        $timeline_chart_visibility = ($request->timeline_chart_visibility=="on")?'y':'n';



        if($request->factor_id > 0){
                 

                DB::table('factor_list')
                  ->where('id', $request->factor_id)
                  ->update(
                [
                    'account_id' => $account_id, 
                    'user_id' => $user_id,
                    'sector_id' => $request->sector_id, 
                    'case_id' => $request->case_id,
                    'title' => $request->title, 
                    'description' => $request->description,
                    'rank_id' => $request->rank_id, 
                    'source' => $request->source,
                    'occurance_date' => $request->occurance_date, 
                    'target_chart_visibility' => $target_chart_visibility,
					'chart_icon' => $request->chart_icon,
                    'timeline_chart_visibility' => $timeline_chart_visibility 
                ]
              );
				
            }
            else{



        $arrProp = array();
        $arrProp['case_id'] = $request->case_id;
        $arrProp['sector_id'] = $request->sector_id;
        $arrProp['title'] = $request->title; // factor name
        $arrProp['rank_id'] = $request->rank_id;

        $resp = $this->CaseList_obj->isFactorDataAlreadyExist($arrProp);
      
        if(!$resp){


            if($request->factor_id > 0){
                 

                DB::table('factor_list')
                  ->where('id', $request->factor_id)
                  ->update(
                [
                    'account_id' => $account_id, 
                    'user_id' => $user_id,
                    'sector_id' => $request->sector_id, 
                    'case_id' => $request->case_id,
                    'title' => $request->title, 
                    'description' => $request->description,
                    'rank_id' => $request->rank_id, 
                    'source' => $request->source,
                    'occurance_date' => $request->occurance_date, 
                    'target_chart_visibility' => $target_chart_visibility,
					'chart_icon' => $request->chart_icon,
                    'timeline_chart_visibility' => $timeline_chart_visibility 
                ]
              );
            }
            else{
				
                $id = DB::table('factor_list')->insertGetId(
                [
                    'account_id' => $account_id, 
                    'user_id' => $user_id,
                    'sector_id' => $request->sector_id, 
                    'case_id' => $request->case_id,
                    'title' => $request->title, 
                    'description' => $request->description,
                    'rank_id' => $request->rank_id, 
                    'source' => $request->source,
                    'occurance_date' => $request->occurance_date, 
                    'target_chart_visibility' => $target_chart_visibility,
					'chart_icon' => $request->chart_icon,
                    'timeline_chart_visibility' => $timeline_chart_visibility 
                ]
              );
			  if($request->temp_id!=''){
                    
                   
					if(!empty($id)){
					 $fileListArray =  DB::table('factor_files')->where('factor_id', '=', $request->temp_id)->get();
					 if($fileListArray && count($fileListArray)>0 && $fileListArray[0]->factor_id){
					$iid = DB::table('factor_files')->where('factor_id', $request->temp_id)
                            ->update(
					[
						'factor_id' => $id					
					]
					);
					
                  $fileListArray =  DB::table('factor_files')->where('factor_id', '=', $id)->get();
				  if($fileListArray[0]->profile_pic){
				  $path = get_image_url($fileListArray[0]->profile_pic,'files');
					$image_url=$path;
                    $data = file_get_contents($image_url);
                    $filename = 'factor_'.basename($image_url);
                    
                    

                    $new = public_path('uploads/package/' . $filename);
                    $upload =file_put_contents($new, $data);
					DB::table('factor_list')
					  ->where('id', $id)
					  ->update(
					  [
					  'default_pic' => $filename,
					  ]);
					  }
					}
					}
                }
			   /* if($_FILES['profile_pic']['size']>0){
                    
                    $imagename = ImageUpload($request->profile_pic,'files');
					if(!empty($imagename)){
					$iid = DB::table('factor_files')->insertGetId(
					[
						'account_id' => $account_id, 
						'created_by' => $user_id,
						'profile_pic' => $imagename, 
						'description' => '',
						'title' => $request->title,
						'factor_id' => $id,					
					]
					);
                  
					DB::table('factor_list')
					  ->where('id', $id)
					  ->update(
					  [
					  'default_pic' => $imagename,
					  ]);
					}
                }*/
            }
            
        }
     }
    }
  public function ajaxSaveAddNote( Request $request) {

        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');

        $target_chart_visibility = ($request->target_chart_visibility=="on")?'y':'n';
        $timeline_chart_visibility = ($request->timeline_chart_visibility=="on")?'y':'n';




        $arrProp = array();
        $arrProp['add_note'] = $request->add_note;
		$arrProp['case_id'] = $request->case_id;

		if(!empty($arrProp['add_note'])){
				
                $id = DB::table('add_note')->insertGetId(
                [
                   // 'account_id' => $account_id, 
                    'user_id' => $user_id,
                    'add_note' =>  $arrProp['add_note'], 
                    'case_id' => $arrProp['case_id']
                ]
              );
        }
    }

    /**
    * Function ajaSaveSector 
    *
    * function to save sector data
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaSaveSector( Request $request) {
           
            $account_id = $request->session()->get('account_id');
            $user_id = $request->session()->get('id');
            $sector_name = (isset($request->sector_name))?$request->sector_name:'';

            if($sector_name!=""){
            $arrProp = array();
            $arrProp['sector_name'] = $sector_name;
            $arrProp['account_id']  = $account_id;
            $arrProp['case_id']     = $request->case_id;
            $arrProp['user_id']     = $request->user_id;
           
            $resp = $this->CaseList_obj->isSectorDataAlreadyExist($arrProp);

            if(!$resp){


            $id = DB::table('account_sector')->insertGetId(
                [
                    'account_id' => $account_id, 
                    'user_id' => $user_id,
                    'sector_name' => $request->sector_name
                ]
              ); 


             $getAllSectorList = $this->CaseList_obj->getAllSectorList($account_id);
           
             foreach($getAllSectorList as $key=>$row)
             {
                ?>
                 <a href="#" onclick="return set_sector(<?php echo $row->id; ?>,'<?php echo $row->sector_name; ?>');"><?php echo $row->sector_name; ?></a>
                
                <?php
             }
             ?>
             <a href="#" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#add-sector">
                <span class="glyphicon glyphicon-plus"></span> Add Sector 
                </a>
             <?php
           
            }
        } // end if 
    }
    

    /**
    * Function ajaxDeleteFactor 
    *
    * function to delete Factor data
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxDeleteFactor( Request $request) {
           
            
            $factor_id = (isset($request->factor_id))?$request->factor_id:'0';
            
            if($factor_id>0){

              DB::table('factor_list')
              ->where('id', '=', $factor_id)
              ->delete();
           
            }
    }   


    /**
    * Function delete_case 
    *
    * function to delete case
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function delete_case( Request $request) {
           
            
            $case_id = (isset($request->case_id))?$request->case_id:'0';
            
            if($case_id>0){

             DB::table('case_list')
                  ->where('id', $case_id)
                  ->update(
                [
                    
                    'deleted_at' => date("Y-m-d h:i:s") 
                ]
              );

            DB::table('factor_list')
                  ->where('case_id', $case_id)
                  ->update(
                [
                    
                    'deleted_at' => date("Y-m-d h:i:s") 
                ]
              );

           DB::table('tasks')
                  ->where('case_id', $case_id)
                  ->update(
                [
                    
                    'deleted_at' => date("Y-m-d h:i:s") 
                ]
              );

           DB::table('files')
                  ->where('case_id', $case_id)
                  ->update(
                [
                    
                    'deleted_at' => date("Y-m-d h:i:s") 
                ]
              );


           DB::table('forum')
                  ->where('case_id', $case_id)
                  ->update(
                [
                    
                    'deleted_at' => date("Y-m-d h:i:s") 
                ]
              );

            DB::table('case_tasks')->where('case_id', $case_id)->delete();
            }
    }
    /**
    * Function ajax_view_case 
    *
    * function to view case detaisls
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajax_view_case( Request $request) {
           
            
            $account_id = $request->session()->get('account_id');
            $user_id = $request->session()->get('id');
            
            $case_id = (isset($request->case_id))?$request->case_id:'0';
            if($case_id>0){
                $data['case_id'] = $case_id;
                $data['totalSubject'] = Subject::where('case_id',$case_id)->count();
                $data['totalTarget'] = Target::where('case_id',$case_id)->count();
                $data['totalFile'] = File::where('case_id',$case_id)->count();
              
                $getAllSectorByCaseIdArray = CaseList::getAllSectorByCaseId($case_id);
                $data['totalSectorByCaseId'] = count($getAllSectorByCaseIdArray);
                $getAllVisibleFactorByCaseIdArray = $this->CaseList_obj->getAllVisibleFactorByCaseId($case_id);
                $data['totalVisibleFactorByCaseId'] = count($getAllVisibleFactorByCaseIdArray);
                //$getAllTaskByCaseIdArray = CaseList::getAllTaskByCaseId($case_id);
               // $data['TotalTaskByCaseId'] = count($getAllTaskByCaseIdArray);
                $data['TotalTaskByCaseId']= $getAllTaskByCaseIdArray = CaseTask::where('case_id',$case_id)->count();


                $data['TotalForum'] = DB::table('forum')
                ->where('case_id', $case_id)
                ->orderByRaw('id DESC')
                ->get()
                ->count();

            }

            return view('admin.ajax_view_case_details', ['data' => $data, 'request' => $request]);
    }
    /**
    * Function downloadPDF 
    *
    * function to download the PDF of case List
    *
    * @Created Date: 12 July 2018
    * @Modified Date:  12 July 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function downloadPDF(Request $request){
      $admin_id = $request->session()->get('id');
      $user_role_name = $request->session()->get('user_role_name');
        
      if ($user_role_name!="superAdmin")
      {
            $account_id = $request->session()->get('account_id');
      } 
        $pageNo = trim($request->input('page', 1));
        
        //search fields
        if (isset($_GET) && count($_GET)>0) {
            //dd($_GET);
            $keyword = strtolower(trim($request->input('keyword'))); 
            $status = trim($request->input('status')); 
            $user_type_id = trim($request->user_type_id);
            if ($user_role_name=="superAdmin")
            {
                 $account_id = trim($request->input('account_id'));
            }
            else{
                $account_id = $request->session()->get('account_id');
            } 
         }
        
        //get user data
       // $users = CaseList::where('status','!=', '3');
        
        $account_list = array();
           
            if ($user_role_name=="superAdmin")
            {
                 
                 $account_list = AccountList::get();

            } 
         DB::enableQueryLog();

        $caseListArray = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
        ->select('case_list.*', 'account.name')
        ->with('caseOwnerName');

        if(isset($status) && $status!="")
            {
                $caseListArray->where('case_list.status',$status);
            }

        if(isset($account_id) && $account_id!="")
            {
                $caseListArray->where('case_list.account_id',$account_id);
            }

        
        if(isset($keyword) && $keyword!="")
        {
             $caseListArray->Where(function ($query) use ($keyword) {
                    $query->orwhere('case_list.title', 'rlike', $keyword);
                });
        }
        $caseListArray = $caseListArray->orderby('case_list.created_at','desc')
                ->get();


        $this->data['records'] = $caseListArray->paginate($this->record_per_page);

         $queries = DB::getQueryLog();
     // dd_my($queries);
       
         $data   = $this->data; 
         $pageNo = $pageNo;
         $record_per_page = $this->record_per_page; 
         $request = $request;
         $account_list = $account_list;

      $pdf = PDF::loadView('pdf.case_mng', compact("data", "pageNo", "record_per_page","request", "account_list"));
      return $pdf->download('invoice.pdf');

    }

public function downloadCasePDF(Request $request,$id=''){
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$caseId = $id;
        $data['caseDetails'] = CaseList::find($id);
        $pdfFileName = str_replace(" ","-",$data['caseDetails']['title']).'.pdf';

        $data['userList'] =  DB::table('users')
                ->where('account_id', $account_id)
                ->get();
        $data['subjectDetails'] = Subject::where('case_id',$id)->orderby('created_at','desc')->get();
        $data['targetDetails'] = Target::where('case_id',$id)->orderby('created_at','desc')->get();
        $data['fileDetails'] = File::where('case_id',$id)->orderby('created_at','desc')->get();
		
	$data['incidentDetails'] = Incident::Join('incident_type','incident_type.id','=','incident.type')
			 ->Join('incident_linkto_report AS c', function($Join) use ($caseId){
					$Join->on('c.incident_id', '=', 'incident.id')->where('c.case_id', '=', $caseId);
			})->orWhereNull('incident.deleted_at')
			->select('c.incident_id','incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident.created_at','c.id as linkedid')->get();
		 $data['add_note'] = DB::table('add_note')->select('*')->where('case_id',$id)->where('user_id', $user_id)->orderby('id','desc')->get();
           
        $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);

        $arrProp = array();
        $arrProp['sector_name'] = 'Target';
        $arrProp['account_id'] = $account_id;
        $arrProp['user_id']    = $user_id;
        $data['isSectorDataAlreadyExist'] = CaseList::isSectorDataAlreadyExist($arrProp);

        $data['getAllSectorByCaseId'] = CaseList::getAllSectorByCaseId($caseId);
        $data['getAllVisibleSectorByCaseId'] = CaseList::getAllVisibleSectorByCaseId($caseId);
        $data['getAllVisibleFactorByCaseId'] = $this->CaseList_obj->getAllVisibleFactorByCaseId($caseId);
        $data['getAllTaskByCaseId'] = CaseList::getAllTaskByCaseId($caseId);
        
        $data['getAllVisibleTimeLineDataByCaseId'] = $this->CaseList_obj->getAllVisibleTimeLineDataByCaseId($caseId);
        $data['getAllVisibleSectorByCaseId'] = CaseList::getAllVisibleSectorByCaseId($caseId);
         $data['getAllVisibleFactorByCaseId'] = $this->CaseList_obj->getAllVisibleFactorByCaseId($caseId);
        $data['getAllVisibleTimeLineDataByCaseId'] = $this->CaseList_obj->getAllVisibleTimeLineDataByCaseId($caseId);
        
        //dd($data);
                
        
         $category = array();
        if ($id) {
            $data['caseList'] = CaseList::find($id);
        }
        //dd($data);
       //return view('pdf.case_mng_pdf', ['data' => $data, 'request' => $request]);
       //die;
        // $data   = $this->data; 
         //$pageNo = $pageNo;
        // $record_per_page = $this->record_per_page; 
         $request = $request;
        // $account_list = $account_list;
         
           if(count($data['userList'])>0)
           {    
            foreach($data['userList'] as $row) 
            {
                 if($data['caseDetails']->case_owner_id==$row->id) 
                   $data['case_owner_name'] = ucfirst($row->first_name) .' '.ucfirst($row->last_name);
            }
           }
                                                        
      //return view('pdf.case_mng_pdf', compact("data","request")); die();
      $pdf = PDF::loadView('pdf.case_mng_pdf', compact("data","request"));
      //return view('pdf.case_mng_pdf', compact("data","request")); die();
      // $pdf->setOptions(['enable-javascript' => true,'javascript-delay'=>99999999,'enable-smart-shrinking'=>true,'no-stop-slow-scripts'=>true]);->setOption('enable-javascript', true)

	 /*return PDF::setOptions(['enable-javascript' => true,'images'=> true,'javascript-delay'=>999999,'enable-smart-shrinking'=>true,'no-stop-slow-scripts'=>true])
           ->loadHTML(view('pdf.case_mng_pdf', compact("data","request"))
           ->render())->download('case_detail.pdf');*/
      return $pdf->download($pdfFileName);
	//return view('pdf.case_mng_pdf', ['data' => $data, 'request' => $request]);
    }

   
public function caselinkwithtask(Request $request,$id=''){
        $type = 'edit';
        if($request->id){
        $data = CaseList::find($request->id);
        $tasks = Tasks::with(['user'])->where('tasks.status', '!=', '');
        if($request->session()->get('user_role_id') > 1 )
        {     
            $tasks->where('account_id', '=', $request->session()->get('account_id') ) ;
        }
        $taskListArray = $tasks->WhereNull('.deleted_at')->get();
      // die();
         if($request->all()){
                        if( !empty($request->existingtaskId) ) {
                            $existingtaskIdArray = explode(',',$request->existingtaskId );
                            if(count($existingtaskIdArray)>0){
                                foreach($existingtaskIdArray as $key){
                                    CaseTask::where('task_id', $key)->where('case_id',$request->id)->delete();
                                }
                            }
                        }
                        if(!empty($request->taskId)){
                            foreach(array_filter($request->taskId) as $value){                        
                                    $casetask = new CaseTask;
                                    $casetask->task_id             =  $value;
                                    $casetask->case_id              =  $request->id;
                                    $casetask->save();
                            }
                        }          
                        $msg = 'Tasks are linked successfully.';
                        $request->session()->flash('add_message', $msg);                
                        return redirect()->route('admin-caseList');
                    }

         return view('admin.add_case_task', ['data'=>$data,'request' => $request,'taskListArray'=>$taskListArray,'type'=>$type]);
        
     }
}
    public function linkcase_totask_action(Request $request){
   // echo '<pre>'; print_r($request->all()); die();
    if(!empty($request->casetaskid)){
        CaseTask::where('task_id', $request->taskid)->where('case_id',$request->casetaskid)->delete();
    }
            $msg = 'Tasks unlinked successfully.';
            $request->session()->flash('add_message', $msg);    
    return redirect()->route('admin-editCase',$request->casetaskid);
}   


     public function ajaxGetIncidentDetailsWithCase( Request $request) {
            $case_id = $id = (isset($request->case_id))?$request->case_id:'0'; 
            if($case_id>0){
                    $account_id = $request->session()->get('account_id');
                    $admin_id = $request->session()->get('id');
                    $incidentListArray = Incident::with(['incidentType'])->where('account_id',$account_id)->get();   
                    //die();
                    $admin_id = $request->session()->get('id');
                    $type = 'add';
                    $imagenotuploadedmsg = '';
                    $user_id = $request->session()->get('id');
                    $data = array();
                    $data = CaseList::find($id);
                   // echo '<pre>'; print_r($data->reportCaseId); echo '</pre>'; die();
            }       
            return view('admin.ajax_incident_linked_case', ['data'=>$data,'incidentListArray'=>$incidentListArray]);

    }

    public function ajaxLinkIncidentAndCaseId(Request $request){ 
    $return = 0;    
        if(!empty($request->caseId)){
            if(!empty($request->existingincidentIds)){
                $existingincidentIdsArray = explode(',', $request->existingincidentIds);
                foreach($existingincidentIdsArray as $incident_id){
                 ReportIncident::where('case_id',$request->caseId)->where('incident_id',$incident_id)->delete();
                }
            }

            if(!empty($request->incidentIds) && ( count($request->incidentIds)>0)){
                foreach($request->incidentIds as $incidentId)
                {
                        $reportincident = new ReportIncident;
                        $reportincident->case_id  = $request->caseId;
                        $reportincident->incident_id  = $incidentId;
                        $reportincident->created_at  = date('Y-m-d H:i:s');
                        $reportincident->save();
                }
                 $return = 1;
            }
        }
            $msg = 'Case linked with Incident successfully.';
            $request->session()->flash('add_message', $msg);    
        return $return;
    }
    
    public function getDescription( Request $request,$caseId) 
    {        
           $data['caseDetails'] = CaseList::with(['caseGroup'])->find($caseId);
            if($request->post()){
                $caseGroup = CaseList::where('id', '=', $request->caseId)->update(['description' => $request->description]);
                $msg = 'Case description has been updated successfully.';
                $request->session()->flash('add_message', $msg);
                return redirect()->route('admin-viewCase',[$request->caseId]);
            }
           return view('admin.add_description', ['data' => $data, 'request' => $request,'caseId'=>$caseId]);
    }    
   
    public function ajaxGetDescriptionDetails( Request $request) 
    {        
          $data['caseDetails'] = CaseList::with(['caseGroup'])->find($request->case_id);
           return view('admin.ajax_view_description', ['data' => $data, 'request' => $request]);
    }

    public function ajaxSaveDescription(Request $request){
        
         $caseGroup = CaseList::where('id', '=', $request->case_id)->update(['description' => $request->description]);

    }
    public function deleteDescription(Request $request)
    {   
        if((!empty($request->caseId)) && ($request->caseId>0)){
            $caseGroup = CaseList::where('id', '=', $request->caseId)->update(['description' => '']);
            $msg = 'Case description has been updated successfully.';
            $request->session()->flash('add_message', $msg);
            return redirect()->route('admin-viewCase',[$request->caseId]);
        }
    }
    
    public function targetchart(Request $request, $id = '') {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$caseId = $id;
        $accountsList = AccountList::find($account_id);
        $imagenotuploadedmsg = '';
        $defaultSpace = 0 ;
        if($accountsList->accountToStorageSpaceUsed){
            $defaultSpace = $accountsList->accountToStorageSpaceUsed->space_assigned - $accountsList->accountToStorageSpaceUsed->space_used;
        }

        $group = Group::with(['userGroup'])->with('accountGroup') ;
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
        }
        $group = $group->orderBy('created_at', 'desc')->get(); 

        $arrProp = array();
        $arrProp['sector_name'] = 'Target';
        $arrProp['account_id'] = $account_id;
        $arrProp['user_id']    = $user_id;
        $data['getAllVisibleSectorByCaseId'] = CaseList::getAllVisibleSectorByCaseId($caseId);        
        $data['getAllVisibleFactorByCaseId'] = $this->CaseList_obj->getAllVisibleFactorByCaseId($caseId);
        $data['getAllVisibleTimeLineDataByCaseId'] = $this->CaseList_obj->getAllVisibleTimeLineDataByCaseId($caseId);

         $category = array();
        if ($id) {
            $data['caseList'] = CaseList::find($id);
        }
        return view('admin.target_chart', ['data' => $data, 'request' => $request,'group'=>$group,'defaultSpace'=>$defaultSpace]);
       
    }
    
    public function timelinechart(Request $request, $id = '') {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$caseId = $id;
        $accountsList = AccountList::find($account_id);
        $imagenotuploadedmsg = '';
        $defaultSpace = 0 ;
        if($accountsList->accountToStorageSpaceUsed){
            $defaultSpace = $accountsList->accountToStorageSpaceUsed->space_assigned - $accountsList->accountToStorageSpaceUsed->space_used;
        }

        $group = Group::with(['userGroup'])->with('accountGroup') ;
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
        }
        $group = $group->orderBy('created_at', 'desc')->get(); 

        $arrProp = array();
        $arrProp['sector_name'] = 'Target';
        $arrProp['account_id'] = $account_id;
        $arrProp['user_id']    = $user_id;
        $data['getAllVisibleSectorByCaseId'] = CaseList::getAllVisibleSectorByCaseId($caseId);        
        $data['getAllVisibleFactorByCaseId'] = $this->CaseList_obj->getAllVisibleFactorByCaseId($caseId);
        $data['getAllVisibleTimeLineDataByCaseId'] = $this->CaseList_obj->getAllVisibleTimeLineDataByCaseId($caseId);

         $category = array();
        if ($id) {
            $data['caseList'] = CaseList::find($id);
        }
        return view('admin.timeline_chart', ['data' => $data, 'request' => $request,'group'=>$group,'defaultSpace'=>$defaultSpace]);
       
    }
	
	public function downloadSubjectPDF(Request $request,$id=''){
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$caseId = $id;
        $data['caseDetails'] = CaseList::find($id);
        $pdfFileName = str_replace(" ","-",$data['caseDetails']['title']).'.pdf';
        $data['userList'] =  DB::table('users')
                ->where('account_id', $account_id)
                ->get();
        $data['subjectDetails'] = Subject::where('case_id',$id)->orderby('created_at','desc')->get();
        $request = $request; 

        $pdf = PDF::loadView('pdf.subject_mng_pdf', compact("data","request"));
      return $pdf->download($pdfFileName);
    }
	public function downloadTargetPDF(Request $request,$id=''){
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$caseId = $id;
        $data['caseDetails'] = CaseList::find($id);
        $pdfFileName = str_replace(" ","-",$data['caseDetails']['title']).'.pdf';
        $data['userList'] =  DB::table('users')
                ->where('account_id', $account_id)
                ->get();
		$data['targetDetails'] = Target::where('case_id',$id)->orderby('created_at','desc')->get();
        $request = $request; 

        $pdf = PDF::loadView('pdf.target_mng_pdf', compact("data","request"));
      return $pdf->download($pdfFileName);
    }
	public function downloadFactorPDF(Request $request,$id=''){
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$caseId = $id;
        $data['caseDetails'] = CaseList::find($id);
        $pdfFileName = str_replace(" ","-",$data['caseDetails']['title']).'.pdf';
        $data['userList'] =  DB::table('users')
                ->where('account_id', $account_id)
                ->get();
		 $data['getAllSectorByCaseId'] = CaseList::getAllSectorByCaseId($caseId);
        $request = $request; 

        $pdf = PDF::loadView('pdf.factor_mng_pdf', compact("data","request"));
      return $pdf->download($pdfFileName);
    }
	
	public function downloadTaskPDF(Request $request,$id=''){
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$caseId = $id;
        $data['caseDetails'] = CaseList::find($id);
        $pdfFileName = str_replace(" ","-",$data['caseDetails']['title']).'.pdf';
        $data['userList'] =  DB::table('users')
                ->where('account_id', $account_id)
                ->get();
		$data['getAllTaskByCaseId'] = CaseList::getAllTaskByCaseId($caseId);
        $request = $request; 

        $pdf = PDF::loadView('pdf.task_mng_pdf', compact("data","request"));
      return $pdf->download($pdfFileName);
    }
	
	public function downloadIncidentPDF(Request $request,$id=''){
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        $data = array();
		$caseId = $id;
        $data['caseDetails'] = CaseList::find($id);
        $pdfFileName = str_replace(" ","-",$data['caseDetails']['title']).'.pdf';
        $data['userList'] =  DB::table('users')
                ->where('account_id', $account_id)
                ->get();
		$data['incidentDetails'] = Incident::Join('incident_type','incident_type.id','=','incident.type')
			 ->Join('incident_linkto_report AS c', function($Join) use ($caseId){
					$Join->on('c.incident_id', '=', 'incident.id')->where('c.case_id', '=', $caseId);
			})->orWhereNull('incident.deleted_at')
			->select('c.incident_id','incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident.created_at','c.id as linkedid')->get();
        $request = $request; 

        $pdf = PDF::loadView('pdf.incident_mng_pdf', compact("data","request"));
      return $pdf->download($pdfFileName);
    }

    public function updatecoordinate(Request $request){
        $factorListId = $request->factorListId;
        $incident = FactorList::find($factorListId);
        $incident->top = $request->top;
        $incident->lefts = $request->left;
        $incident->save();
}

    
}