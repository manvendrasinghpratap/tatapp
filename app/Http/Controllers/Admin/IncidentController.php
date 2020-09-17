<?php
/* copied from account controller */
namespace App\Http\Controllers\Admin;

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
use App\ReportIncident;
use App\Incident;
use App\CaseList;
use App\Report;
use App\Subject;
use App\Target;
use App\File;
use App\Forum;
use App\User;
use App\Group;
use App\Tasks;
use App\TaskIncident;
use App\IncidentToGroup;
use Session;
use Carbon\Carbon;
use DB;
class IncidentController extends AdminController
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
        $this->IncidentList_obj = new Incident();
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
		$account_id = $request->session()->get('account_id');		
        $user_role_name = $request->session()->get('user_role_name');
        $user_role_id = $request->session()->get('user_role_id');
        if ($user_role_name!="superAdmin")
        {
            $account_id = $request->session()->get('account_id');
        } 
        $pageNo = trim($request->input('page', 1));        
        //search fields
        $user_group = $request->session()->get('user_group');
        $group = Group::with(['userGroup'])->with('accountGroup') ;
        $user_id = $request->session()->get('id');
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
            
        }
        $group = $group->orderBy('created_at', 'desc')->get(); 
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
        
        $incident_type =  DB::table('incident_type')->orWhereNull('incident_type.deleted_at')->where('incident_type.account_id',$account_id)->get();
		
		$incident_min_time =  DB::table('incident')->orWhereNull('incident.deleted_at')->where('incident.account_id',$account_id)->min('incident_datetime');
		
		$incident_max_time =  DB::table('incident')->orWhereNull('incident.deleted_at')->where('incident.account_id',$account_id)->max('incident_datetime');
		
		//dd_my($incident_max_time);
        $account_list = array();
           
            if ($user_role_name=="superAdmin")
            {
                 
                 $account_list = AccountList::get();

            } 
         

     /*    $incident = DB::table('incident')->orWhereNull('incident.deleted_at')
		->select('incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type')
		->join('incident_type','incident_type.id','=','incident.type')->get(); */

		
		
		 $incidentArray = Incident::Join('incident_type','incident_type.id','=','incident.type')
        ->orWhereNull('incident.deleted_at')
        ->select('incident.id','incident.location','incident.latitude','incident.longitude','incident.incident_datetime','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident_type.type' ,'incident.created_at')
        ->with(['caseOwnerName','incidentGroup']);
  
        if(!in_array($request->session()->get('user_role_id'), array(1,2)))
        {
           $incidentArray = $incidentArray->whereHas('incidentGroup', function ($q) use ($user_group) {$q->whereIn('group_id',$user_group);});
            
        }
            if(isset($account_id) && $account_id!="")
                {
                    $incidentArray->where('incident.account_id',$account_id);
                }
        $group_filter =  trim($request->input('group_filter')); 
        if(isset($group_filter) && $group_filter!="")
        {
            $incidentArray->whereHas('incidentGroup', function ($q) use ($group_filter) {$q->where('group_id',$group_filter);});
        }
        if(isset($keyword) && $keyword!="")
        {
             $incidentArray->Where(function ($query) use ($keyword) {
                    $query->orwhere('incident.title', 'rlike', $keyword);
                });
        }

		$incidentArray = $incidentArray->orderby('incident.created_at','desc');


        $this->data['records'] = $incidentArray->paginate($this->record_per_page);
       
		$this->data['incident_min_time']=date('Y/m/d',strtotime($incident_min_time));
		$this->data['incident_max_time']=date('Y/m/d',strtotime($incident_max_time.'+1 day'));
         $queries = DB::getQueryLog();
    //dd_my($queries);
        return view('admin.incident', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list,'incident_type' =>  $incident_type,'group'=>$group,'user_role_id'=>$user_role_id]);
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
     public function edit_incident(Request $request, $id = '') {   
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
       // $group = Group::orderBy('name', 'asc')->get();

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
       // echo '<pre>'; print_r($group); echo '</pre>';

		$record_numbers = DB::table('incident')->where('incident.id',$id)->max('record_number');
		if(!empty($record_numbers)){
			$record_number = $record_numbers;
		}else{
		$record_numbers = DB::table('incident')->max('record_number');
			if(!empty($record_numbers)){
				$record_number = $record_numbers+1;
			}else{
				$record_number = '100';
			}
		}
        $user_role_name = $request->session()->get('user_role_name');
		
        $data = array();
        $data = Incident::find($id);
         $incident_type =  DB::table('incident_type')->orWhereNull('incident_type.deleted_at')->where('incident_type.account_id',$account_id)->get();
        if ($request->all() && isset($request->_token)) { //post
            //echo '<pre>'; print_r($request->all()); echo '</pre>'; die();
            $title = $request->title; 
            $description = $request->description; 
            $incidentdatetimepicker = $request->incidentdatetimepicker;
			
			$incident_datetime = $request->incidentdatetimepicker;
            $group_id = $request->group;
            $record_number = $request->record_number;
			$reported_by = $request->reported_by;
			$date_of_report = $request->date_of_report;
			$location = $request->location;
			$latitude = $request->latitude;
			$longitude = $request->longitude;
			$place_id = $request->place_id;
			$law_enforcement_contacted = $request->law_enforcement_contacted;
			$medical_assistance_required = $request->medical_assistance_required;
			$follow_up_actions = $request->follow_up_actions;
			$victim_name_and_contact_info = $request->victim_name_and_contact_info;			
			$persons_of_concern_name_and_contact_info = $request->persons_of_concern_name_and_contact_info;
			$witnesses_names_and_contact_info = $request->witnesses_names_and_contact_info;
		   if($incident_datetime) $incident_datetime=date('Y-m-d H:i:s', strtotime($incident_datetime));
		    if($date_of_report) $date_of_report=date('Y-m-d H:i:s', strtotime($date_of_report));

            $type = $request->type;     
            
                if ($id) {
            
                //Validate the input
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description' => 'required',
					'incidentdatetimepicker' => 'required',
					'date_of_report' => 'required',
                    'type' => 'required',
                    'group' => 'required'
                ]);
                }
                else {
                //Validate the input
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description' => 'required',
					'incidentdatetimepicker' => 'required',
					'date_of_report' => 'required',
                    'type' => 'required',
                    'group' => 'required'                   
                ]);
            }
            if ($validator->fails()) 
            {
				
                    return redirect()->route('admin-incidentList')
                            ->withErrors($validator)
                            ->withInput();
                
            }
            else {

                if ($id) { //update case
                    $incident = Incident::find($id);
                } else {
                    
                    $incident = new Incident;
                    
                }                 

                $incident->account_id  = $account_id;
                $incident->user_id     = $user_id;
                $incident->title = $title;
                $incident->description = $description;
                $incident->type = $type;
                $incident->incident_datetime = $incident_datetime;
                $incident_datetime = $incidentdatetimepicker;
                $incident->record_number = $record_number;
                $incident->reported_by = $reported_by;
                $incident->date_of_report = $date_of_report;
                $incident->location = $location;
                $incident->latitude = $latitude;
                $incident->longitude = $longitude;
                $incident->place_id = $place_id;
                $incident->law_enforcement_contacted = $law_enforcement_contacted;
                $incident->medical_assistance_required = $medical_assistance_required;
                $incident->follow_up_actions = $follow_up_actions;
                $incident->victim_name_and_contact_info = serialize($victim_name_and_contact_info);			
                $incident->persons_of_concern_name_and_contact_info = serialize($persons_of_concern_name_and_contact_info);
                $incident->witnesses_names_and_contact_info = serialize($witnesses_names_and_contact_info);
            
            if ($id) {
                    $incident->save();
                     
                    $incidentGroup = IncidentToGroup::where('incident_id', '=', $id)->update(['group_id' => $group_id]);
                    if(!$incidentGroup)
                    {
                        $incidentGroup = IncidentToGroup::insertGetId(['incident_id' => $id, 'group_id' => $group_id ]);
                    }
                    $msg = 'Incident has been updated successfully.';
                    $request->session()->flash('add_message', $msg);
                  //return view('admin.add_case', ['request' => $request, 'data' => $caseList, 'userList' =>  $userList ]);
          
                  return redirect()->route('admin-incidentList');
                }
                else {
                    //$incident->incident_datetime = date('Y-m-d H:i:s');
                   $incident->save();
                   $incidentId = $incident->id;
                        if(isset($request->caseId)){
                        $request->caseId;
                        $reportincident = new ReportIncident;
                        $reportincident->case_id  = $request->caseId;
                        $reportincident->incident_id  = $incidentId;
                        $reportincident->created_at  = date('Y-m-d H:i:s');
                        $reportincident->save();
                        }
					$incidentGroup = IncidentToGroup::insertGetId(['incident_id' => $incident->id, 'group_id' => $group_id ]);
                    $msg = 'Incident has been added successfully.';
                    $request->session()->flash('add_message', $msg);
                      if(isset($request->caseId)){
                            $msg = 'Incident has been added and Linked successfully.';
                            $request->session()->flash('add_message', $msg);
                            return redirect()->route('admin-viewCase',$request->caseId);
                        }

                    return redirect()->route('admin-incidentList');
                }
            }
        }
        else {
			
			 $reportListArray = Report::leftJoin('account', 'report.account_id', '=', 'account.id')->join('incident_linkto_report','incident_linkto_report.report_id','=','report.id')
        ->orWhereNull('report.deleted_at')->Where('incident_linkto_report.incident_id',$id)
        ->select('report.*', 'account.name as account_name')->orderby('report.created_at','desc')->get();
		
		$caseListArray = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')->join('incident_linkto_report','incident_linkto_report.case_id','=','case_list.id')->orWhereNull('case_list.deleted_at')->Where('incident_linkto_report.incident_id',$id)
        ->select('case_list.*', 'account.name','incident_linkto_report.case_id as linked_caseid')
        ->with('caseOwnerName')->get();
            return view('admin.add_incident', ['data' => $data,'reportdata'=>$reportListArray,'caselistdata'=>$caseListArray, 'request' => $request, 'incident_type' =>  $incident_type,'group'=>$group ]);
        }
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
     public function view_incident(Request $request, $id = '') {        
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
       // $group = Group::orderBy('name', 'asc')->get();

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
       // echo '<pre>'; print_r($group); echo '</pre>';

		$record_numbers = DB::table('incident')->where('incident.id',$id)->max('record_number');
		if(!empty($record_numbers)){
			$record_number = $record_numbers;
		}else{
		$record_numbers = DB::table('incident')->max('record_number');
			if(!empty($record_numbers)){
				$record_number = $record_numbers+1;
			}else{
				$record_number = '100';
			}
		}
        $user_role_name = $request->session()->get('user_role_name');
		
        $data = array();
        $data = Incident::find($id);
         $incident_type =  DB::table('incident_type')->orWhereNull('incident_type.deleted_at')->where('incident_type.account_id',$account_id)->get();
        if ($request->all()) { //post
            
            $title = $request->title; 
            $description = $request->description; 
            $incidentdatetimepicker = $request->incidentdatetimepicker;
			
			$incident_datetime = $request->incidentdatetimepicker;
            $group_id = $request->group;
            $record_number = $request->record_number;
			$reported_by = $request->reported_by;
			$date_of_report = $request->date_of_report;
			$location = $request->location;
			$law_enforcement_contacted = $request->law_enforcement_contacted;
			$medical_assistance_required = $request->medical_assistance_required;
			$follow_up_actions = $request->follow_up_actions;
			$victim_name_and_contact_info = $request->victim_name_and_contact_info;			
			$persons_of_concern_name_and_contact_info = $request->persons_of_concern_name_and_contact_info;
			$witnesses_names_and_contact_info = $request->witnesses_names_and_contact_info;
		   if($incident_datetime) $incident_datetime=date('Y-m-d H:i:s', strtotime($incident_datetime));
		    if($date_of_report) $date_of_report=date('Y-m-d H:i:s', strtotime($date_of_report));

            $type = $request->type;            
            
            
                if ($id) {
            
                //Validate the input
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description' => 'required',
					'incidentdatetimepicker' => 'required',
					'date_of_report' => 'required',
                    'type' => 'required',
                    'group' => 'required'
                ]);
                }
                else {
                //Validate the input
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description' => 'required',
					'incidentdatetimepicker' => 'required',
					'date_of_report' => 'required',
                    'type' => 'required',
                    'group' => 'required'                   
                ]);
            }
            if ($validator->fails()) 
            {
				
                    return redirect()->route('admin-incidentList')
                            ->withErrors($validator)
                            ->withInput();
                
            }
            else {

                if ($id) { //update case
                    $incident = Incident::find($id);
                } else {
                    
                    $incident = new Incident;
                    
                }                 

                $incident->account_id  = $account_id;
                $incident->user_id     = $user_id;
                $incident->title = $title;
                $incident->description = $description;
                $incident->type = $type;
                $incident->incident_datetime = $incident_datetime;
                $incident_datetime = $incidentdatetimepicker;
                $incident->record_number = $record_number;
                $incident->reported_by = $reported_by;
                $incident->date_of_report = $date_of_report;
                $incident->location = $location;
                $incident->law_enforcement_contacted = $law_enforcement_contacted;
                $incident->medical_assistance_required = $medical_assistance_required;
                $incident->follow_up_actions = $follow_up_actions;
                $incident->victim_name_and_contact_info = serialize($victim_name_and_contact_info);			
                $incident->persons_of_concern_name_and_contact_info = serialize($persons_of_concern_name_and_contact_info);
                $incident->witnesses_names_and_contact_info = serialize($witnesses_names_and_contact_info);
            
            if ($id) {
                    $incident->save();
                     
                    $incidentGroup = IncidentToGroup::where('incident_id', '=', $id)->update(['group_id' => $group_id]);
                    if(!$incidentGroup)
                    {
                        $incidentGroup = IncidentToGroup::insertGetId(['incident_id' => $id, 'group_id' => $group_id ]);
                    }
                    $msg = 'Incident has been updated successfully.';
                    $request->session()->flash('add_message', $msg);
                  //return view('admin.add_case', ['request' => $request, 'data' => $caseList, 'userList' =>  $userList ]);
          
                  return redirect()->route('admin-incidentList');
                }
                else {
                    //$incident->incident_datetime = date('Y-m-d H:i:s');
                   $incident->save();
                   $incidentId = $incident->id;
                        if(isset($request->caseId)){
                        $request->caseId;
                        $reportincident = new ReportIncident;
                        $reportincident->case_id  = $request->caseId;
                        $reportincident->incident_id  = $incidentId;
                        $reportincident->created_at  = date('Y-m-d H:i:s');
                        $reportincident->save();
                        }
					$incidentGroup = IncidentToGroup::insertGetId(['incident_id' => $incident->id, 'group_id' => $group_id ]);
                    $msg = 'Incident has been added successfully.';
                    $request->session()->flash('add_message', $msg);
                      if(isset($request->caseId)){
                            $msg = 'Incident has been added and Linked successfully.';
                            $request->session()->flash('add_message', $msg);
                            return redirect()->route('admin-viewCase',$request->caseId);
                        }

                    return redirect()->route('admin-incidentList');
                }
            }
        }
        else {
			
			 $reportListArray = Report::leftJoin('account', 'report.account_id', '=', 'account.id')->join('incident_linkto_report','incident_linkto_report.report_id','=','report.id')
        ->orWhereNull('report.deleted_at')->Where('incident_linkto_report.incident_id',$id)
        ->select('report.*', 'account.name as account_name')->orderby('report.created_at','desc')->get();
		
		$caseListArray = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')->join('incident_linkto_report','incident_linkto_report.case_id','=','case_list.id')->orWhereNull('case_list.deleted_at')->Where('incident_linkto_report.incident_id',$id)
        ->select('case_list.*', 'account.name','incident_linkto_report.case_id as linked_caseid')
        ->with('caseOwnerName')->get();
            return view('admin.view_incident', ['data' => $data,'reportdata'=>$reportListArray,'caselistdata'=>$caseListArray, 'request' => $request, 'incident_type' =>  $incident_type,'group'=>$group ]);
        }
    }

	public function ajax_add_incident(Request $request) {
		 if ($request->all()) { //post
			$account_id = $request->session()->get('account_id');
			$user_id = $request->session()->get('id');
			//dd($request->all());
			$record_number = '';
			$record_numbers = DB::table('incident')->max('record_number');
			if(!empty($record_numbers)){
				$record_number = $record_numbers+1;
			}else{
				$record_number = '100';
			}
			$titlearray = $request->title; 
			$description = $request->description; 
			$incident_datetime = $request->incidentdatetimepicker;
			$reported_by = $request->reported_by;
			$date_of_report = $request->date_of_report;
			$location = $request->location;
			$law_enforcement_contacted = $request->law_enforcement_contacted;
			$medical_assistance_required = $request->medical_assistance_required;
			$follow_up_actions = $request->follow_up_actions;
			$victim_name_and_contact_info = $request->victim_name_and_contact_info;			
			$persons_of_concern_name_and_contact_info = $request->persons_of_concern_name_and_contact_info;
			$witnesses_names_and_contact_info = $request->witnesses_names_and_contact_info;
			/* $validator  = $request->validate([
				
				"title"    => "required|array|min:0",
				"title.*"  => "required|string|min:0",
				
				"description"    => "required|array|min:2",
				"description.*"  => "required|string|min:2",
				
				"type"    => "required|array",
				"type.*"  => "required",
				
                 
			]);
			 if ($validator->fails()) {
				 $message='Validate Failed.';
				 $status='error';
				  echo json_encode(array('message'=>$message,'status'=>$status));
				  exit;
				
			} */


			$type = $request->type;
			foreach($titlearray as $row=>$val){
				$incident = new Incident;
				$incident->account_id  = $account_id;
				$incident->user_id     = $user_id;
				$incident->title = $titlearray[$row];
				$incident->description = $description[$row];
				$incident->type = $type[$row];
				$incident->incident_datetime = (isset($incident_datetime[$row]))?date('Y-m-d H:i:s', strtotime($incident_datetime[$row])):null;
				$incident->record_number = $record_number[$row];
				$incident->date_of_report = (isset($date_of_report[$row]))?date('Y-m-d H:i:s', strtotime($date_of_report[$row])):null;
				$incident->location = $location[$row];
				$incident->law_enforcement_contacted = $law_enforcement_contacted[$row];
				$incident->medical_assistance_required = $medical_assistance_required[$row];
				$incident->follow_up_actions = $follow_up_actions[$row];
				$incident->victim_name_and_contact_info = (isset($victim_name_and_contact_info[$row]))?serialize($victim_name_and_contact_info[$row]):null;
				$incident->persons_of_concern_name_and_contact_info =  (isset($victim_name_and_contact_info[$row]))?serialize($victim_name_and_contact_info[$row]):null;
				$incident->witnesses_names_and_contact_info =  (isset($victim_name_and_contact_info[$row]))?serialize($victim_name_and_contact_info[$row]):null;
				$incident->save();
				
			}
			$message = 'Incident has been added successfully.';
            $request->session()->flash('add_message', $message);
			
			$status='success';
			echo json_encode(array('message'=>$message,'status'=>$status));
		}
		exit;
	}
    /**
    * Function add_incidenttype
    *
    * function to add type of incident.
    *
    * @Created Date: 26 November 2018
  
    * @Created By: Nikhil
    
    
    */
	
	 public function add_incidenttype(Request $request) {
		 if ($request->all()) { //post
			 
           //dd($request->all());
            $incidentType = $request->incidentType; 
			$incidentTypeDesc = $request->incidentTypeDesc; 
			
			$incident_count=  DB::table('incident_type')
                ->where('type', $incidentType)->groupBy('type')->count();
                
			if($incident_count==0){
				 $id = DB::table('incident_type')->insertGetId(
                [
                    'type' => $incidentType ,
					'description' => $incidentTypeDesc ,
					'created_at' => date('Y-m-d H:i:s') 
                    
                ]
              ); 
			  $message='Incident Type added successfully';
			  $status='Success';
			  
			}
			else{
				$message='Incident Type '.$incidentType.' already exist.';
				$status='Error';
			}
           Session::flash('add_message', $message); 
			  
			   echo json_encode(array('message'=>$message,'status'=>$status));
		 }
	 }
	 
	 /**
    * Function ajax_view_incident 
    *
    * function to view incident details
    *
   
    * @param  ARRAY
    * @return STRING
    */
	
	public function ajax_view_incident_chart( Request $request) {
		//dd($request->all());
		$account_id = $request->session()->get('account_id');
        $incyear = (isset($request->incyear))?$request->incyear:'';
		$incmon = (isset($request->incmon))?$request->incmon:'';
		$inctype = (isset($request->inctype))?$request->inctype:'';
		
		$incmon = date('m',strtotime($incmon));
		$incidentArray = Incident::Join('incident_type','incident_type.id','=','incident.type')
        ->orWhereNull('incident.deleted_at')
        ->select('incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident.created_at')->where(DB::raw("Year(incident_datetime)"),$incyear)->where(DB::raw("month(incident_datetime)"),$incmon);
  
            
        $incidentArray->where('incident.account_id',$account_id);
		$incidentArray->where('incident.type',$inctype);
		
		
      $data=  $incidentArray->orderby('incident.incident_datetime','desc')->get();

		
		
		
		
		echo json_encode($data,JSON_UNESCAPED_SLASHES);
	}
	
	
    public function ajax_view_incident_by_type( Request $request) {
            $subQuery = ''; 
            $account_id = $request->session()->get('account_id');
            $user_id = $request->session()->get('id');
            $incidentlist=array();
            $incident_type_array = array();
            $incident_type = 0;
            $incyear = ''; $condi1='';
            if(isset($request->incident_type)){
                //echo $incident_type = (isset($request->incident_type))?$request->incident_type:'0';
                $incident_type_array = array_filter($request->incident_type);
                $incident_type = count(array_filter($request->incident_type));
                $incident_type_implode = implode(',',array_filter($request->incident_type));

            }
			 if(isset($request->incident_year) && ($request->incident_year != null)){
			// $incyear = (isset($request->incident_year))?$request->incident_year:'';
                $incident_year_array = array_filter($request->incident_year);
                $incident_year = count(array_filter($request->incident_year));
                if($incident_year>0){ 
                    $incident_year_implode = implode(',',array_filter($request->incident_year));
                    $condi1 = " and year(incident_datetime) in ($incident_year_implode)";
                }
            }

            $daterange = (isset($request->daterange))?$request->daterange:'';


           // $condi1 = " and year(incident_datetime)=$incyear";
          //  if($incyear=='all'){ $incyear = ''; $condi1='';}
			$query=DB::table('incident')->select('incident_datetime' ,'title', 'description','id','type');
			
            if($incident_type>0) {$query->whereIn('type', $incident_type_array); $subQuery = " and incident.type in ($incident_type_implode) ";
         } 
        // echo $subQuery; die();
			if($daterange!='') {
				$daterangearray=explode('-',$daterange);
				$mindate=date('Y-m-d',strtotime($daterangearray[0]));
				$maxdate=date('Y-m-d',strtotime($daterangearray[1]));
				
				$query->whereDate('incident_datetime','>=', $mindate);
				$query->whereDate('incident_datetime','<=', $maxdate);
			}
			
            $incidentlist = $query->where('account_id',$account_id)->WhereNull('incident.deleted_at')->orderByRaw('incident_datetime ASC')->get(); 
				

               /*  $incidentlist = DB::table('incident')->select('incident_datetime' ,'title', 'description','id')
                ->where('type', $incident_type)
                ->orderByRaw('id DESC')
                ->get();
                 */

            
			//dd($incidentlist);
		
		
		//$results = DB::select( DB::raw("SELECT * FROM some_table WHERE some_col = '$someVariable'") );
		//$results = DB::select( DB::raw("SELECT count(*) as inccount,title,month(incident_datetime) as incmonth,incident_type.type FROM `incident`  join incident_type on incident_type.id=incident.type  and incident.deleted_at is null  GROUP by incident.type,month(incident_datetime) order by month(incident_datetime)"));
		DB::statement("drop view if exists incident_count");
		  
		   $statement="Create   VIEW `incident_count` AS select 
                incident.type as inctype_id, 
                year(`incident`.`incident_datetime`) AS `incyear`,
                count(0) AS `inccount`,
                `incident`.`account_id` AS `account_id`,
                `incident`.`title` AS `title`,
                month(`incident`.`incident_datetime`) AS `incmonth`,
                `incident_type`.`type` AS `type` 
                from (`incident` join `incident_type` on(((`incident_type`.`id` = `incident`.`type`)
                and isnull(`incident`.`deleted_at`) 
                and incident_datetime>='$mindate'  
                and incident_datetime<='$maxdate' 
                ". $condi1  ."
                ". $subQuery ."
                and incident.account_id=$account_id))) 
                group by `incident`.`type`,year(`incident`.`incident_datetime`),
                month(`incident`.`incident_datetime`)
                order by month(`incident`.`incident_datetime`)";	
 
		//$statement = "INSERT INTO tableName(id, name) VALUES ('".$id."', '".$name."', ".$geom.");";
		DB::statement($statement);
		
	//	die();
		//$query2 = DB::table('incident_count')->where('account_id', $account_id)->where('incyear', $incyear)
		
		$query2 = DB::table('incident_count')
		 
        ->groupBy('type')
        
        ->select('type','inctype_id')
        ->selectRaw('GROUP_CONCAT(inccount) as inccount,GROUP_CONCAT(incmonth) as incmonth')
        ->get();
		
		
		//$query3=DB::select("call  incident_linechart('$mindate','$maxdate',$incyear,$account_id)");
		//dd($query3);
		$jsonincident_count_data=array();
		foreach($query2 as $row1){ 
			$jsonincident_count['name']=$row1->type;
			$jsonincident_count['inctype_id']=$row1->inctype_id;
			$inccount=explode(',',$row1->inccount);
			$incmonth=explode(',',$row1->incmonth);
			$ca=array(0,0,0,0,0,0,0,0,0,0,0,0);
			foreach($incmonth as $key1=>$val){
				$ca[$val-1]=(int)$inccount[$key1];
			}
			//$jsonincident_count['data']=json_encode($ca,JSON_UNESCAPED_SLASHES);
			$jsonincident_count['data'] = $ca;
			//$jsonincident_count['data']['inctype_id'] = $row1->inctype_id;
			$jsonincident_count_data[]=$jsonincident_count;
		}
		
			$jsonincident_string=array();
			foreach($incidentlist as $row){ 
			$incident_id=$row->id;
			$rurl= route('admin-editIncident',['id'=>@$incident_id]);
				$jsonincident_data['date']=date("F j, Y H:i", strtotime($row->incident_datetime));
										$jsonincident_data['label']='<a href="'.$rurl.'">'.$row->title.'</a>';
										$jsonincident_data['description']=$row->description;
										
										
										$jsonincident_string[]=$jsonincident_data;
			}
			$data['timeline']=$jsonincident_string;
			$data['line']=$jsonincident_count_data;
			echo json_encode($data,JSON_UNESCAPED_SLASHES);
			//$data['incident_id']=$incident_id;
           // return view('admin.ajax_view_incident_details', ['data' => $data, 'request' => $request]);
    }
	 
	 
	/**
    * Function ajax_view_incident 
    *
    * function to view incident details
    *
   
    * @param  ARRAY
    * @return STRING
    */
    public function ajax_view_incident( Request $request) {
           
            
            $account_id = $request->session()->get('account_id');
            $user_id = $request->session()->get('id');
            
            $incident_id = (isset($request->incident_id))?$request->incident_id:'0';
            if($incident_id>0){
                


                $data['totalReport'] = DB::table('report')
                ->where('incident_id', $incident_id)
                ->orderByRaw('id DESC')
                ->get()
                ->count();

            }
			$data['incident_id']=$incident_id;
            return view('admin.ajax_view_incident_details', ['data' => $data, 'request' => $request]);
    }
/**
    * Function delete_incident 
    *
    * function to delete incident
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function delete_incident( Request $request) {
           
            
             $incident_id = (isset($request->incident_id))?$request->incident_id:'0';
           
            if($incident_id>0){

             DB::table('incident')
                  ->where('id', $incident_id)
                  ->update(
                [
                    
                    'deleted_at' => date("Y-m-d h:i:s") 
                ]
              );

            DB::table('report')
                  ->where('incident_id', $incident_id)
                  ->update(
                [
                    
                    'deleted_at' => date("Y-m-d h:i:s") 
                ]
              );

           
         

           
            }
    }
    
	
	public function linkreport_toincident($id,$type,Request $request) {		
		$cancelRedirect =   '';
		$linkedtype     =   $type;
		$reportid       =   $id;		
        $admin_id       =   $request->session()->get('id');
        $user_role_name =   $request->session()->get('user_role_name');
        $user_role_id   =   $request->session()->get('user_role_id');
        $user_group     =   $request->session()->get('user_group');
        if ($user_role_id != 1){                 
            $account_id = $request->session()->get('account_id');
        } 
        $pageNo = trim($request->input('page', 1));        
        //search fields
        if (isset($_GET) && count($_GET)>0) {
            $keyword = strtolower(trim($request->input('keyword'))); 
			 $columnsort =trim($request->input('columnsort'));
			  $sortby = trim($request->input('sortby'));
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
        
        
        $account_list = array();
           
            if ($user_role_name=="superAdmin")
            {
                 
                 $account_list = AccountList::get();

            } 
         DB::enableQueryLog();

     /*    $incident = DB::table('incident')->orWhereNull('incident.deleted_at')
		->select('incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type')
		->join('incident_type','incident_type.id','=','incident.type')->get(); */

		
		if($linkedtype=='report'){
				 $incidentArray = Incident::Join('incident_type','incident_type.id','=','incident.type')
			 ->leftJoin('incident_linkto_report AS c', function($leftJoin) use ($reportid){
					$leftJoin->on('c.incident_id', '=', 'incident.id')->where('c.report_id', '=', $reportid);
			})->orWhereNull('incident.deleted_at')->WhereNull('c.incident_id')
			->select('c.incident_id','incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident.created_at','c.id as linkedid');
		}
		if($linkedtype=='case'){
            $cancelRedirect = 'viewCase';			
            $incidentArray = Incident::Join('incident_type','incident_type.id','=','incident.type')
            ->orWhereNull('incident.deleted_at')
            ->select('incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident.created_at')
            ->with(['caseOwnerName','incidentGroup']);

            if(!in_array($request->session()->get('user_role_id'), array(1,2)))
            {
            $incidentArray = $incidentArray->whereHas('incidentGroup', function ($q) use ($user_group) {$q->whereIn('group_id',$user_group);});

            }
            if(isset($account_id) && $account_id!="")
            {
            $incidentArray->where('incident.account_id',$account_id);
            }



		}
		
  
            if(isset($account_id) && $account_id!="")
                {
                    $incidentArray->where('incident.account_id',$account_id);
                }


        
        if(isset($keyword) && $keyword!="")
        {
             $incidentArray->Where(function ($query) use ($keyword) {
                    $query->orwhere('incident.title', 'rlike', $keyword);
                });
        }
		if((isset($columnsort) && $columnsort!="") && (isset($sortby) && $sortby!=""))
        {
             $incidentArray = $incidentArray->orderby('incident.'.$columnsort,$sortby);
        }
		else{
			$incidentArray = $incidentArray->orderby('incident.created_at','desc');
		}
		


        $this->data['records'] = $incidentArray->paginate($this->record_per_page);
        $caseDetails = CaseList::find($id);
         $queries = DB::getQueryLog();
   // dd_my($queries);
        return view('admin.link_reportto_incident', ['data' => $this->data,'reportid'=>$reportid, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list,'linkedtype'=>$linkedtype,'caseDetails'=>$caseDetails,'cancelRedirect'=>$cancelRedirect]);
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
    public function linkincident_tocase($id,Request $request) {
		$incidentid=$id;
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
        
        
        $account_list = array();
           
            if ($user_role_name=="superAdmin")
            {
                 
                 $account_list = AccountList::get();

            } 
         DB::enableQueryLog();

        $caseListArray = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')->leftJoin('incident_linkto_report AS c', function($leftJoin) use ($incidentid){
				$leftJoin->on('c.case_id', '=', 'case_list.id')->where('c.incident_id', '=', $incidentid);
		})->orWhereNull('case_list.deleted_at')
        ->select('case_list.*', 'account.name','c.case_id as linked_caseid')
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
        $caseListArray = $caseListArray->orderby('case_list.created_at','desc');


        $this->data['records'] = $caseListArray->paginate($this->record_per_page);

         $queries = DB::getQueryLog();
     // dd_my($queries);
        return view('admin.link_caseto_incident', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list,'incidentid'=>$incidentid]);
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
    public function linkincident_toreport($id,Request $request) {
		$incidentid=$id;
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
                 
                 
                // $account_list = AccountList::orderby('account.name','ASC')->get();
                 $account_list = Report::Join('account', 'account.id', '=', 'report.account_id')
                ->orWhereNull('report.deleted_at')
                ->select(DB::raw("account.id, account.name, count(*) as total"))
                ->groupBy('report.account_id')->get();

                
                

            } 
         DB::enableQueryLog();

        $reportListArray = Report::leftJoin('account', 'report.account_id', '=', 'account.id')->leftJoin('incident_linkto_report AS c', function($leftJoin) use ($incidentid){
				$leftJoin->on('c.report_id', '=', 'report.id')->where('c.incident_id', '=', $incidentid);
		})
        ->orWhereNull('report.deleted_at')
        ->select('report.*', 'account.name as account_name','c.report_id as linked_reportid');


  
            if(isset($account_id) && $account_id!="")
                {
                    $reportListArray->where('report.account_id',$account_id);
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
        $reportListArray = $reportListArray->orderby('report.created_at','desc');


        $this->data['records'] = $reportListArray->paginate($this->record_per_page);

         $queries = DB::getQueryLog();
     //dd_my($queries);
        return view('admin.link_incident_to_report', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list,'incidentid'=>$incidentid]);
    }
	
	public function linkincident_tocase_action(Request $request) {
        // DB::enableQueryLog();
      $account_id = $request->session()->get('account_id');

        $user_id = $request->session()->get('id');
		if(isset($request->incidentlink)) echo $request->incidentlink;
		if(isset($request->incidentunlink)) echo $request->incidentunlink;
		//echo $request->incidentunlink;
		//print_r($request->all()); die;
		 if ($request->all()) { 
		 
                    $caseidarray  = $request->caseid; 
					
					$incident_id  = $request->incidentid; 
					
					//$reportListArray=ReportIncident::select('*');
					//print_r($linktoreport); 
				if(count($caseidarray)>0){

					if(isset($request->caselink)){
						foreach($caseidarray as $row=>$case){
							$reportincident = new ReportIncident;
							$linkedcaselist = ReportIncident::where('case_id',$case)->where('incident_id',$incident_id)->get()->first();
							
							if(isset($linkedcaselist->id)){
								
								//ReportIncident::where('id',$reportlist->id)->delete();
								
								//echo $reportid.'--------------'.$incident_id;
								//continue;
							}else{
								
								$reportincident->case_id  = $case;
								$reportincident->incident_id  = $incident_id;
								$reportincident->created_at  = date('Y-m-d H:i:s');
					   
								$reportincident->save(); 
								//echo $reportid.'insert'.$incident_id;
							}
								
									
							//echo $reportlist->report_id;
									//echo $reportlist->id;
							
						
							
						}
						$msg = 'Incident has been linked successfully.';
						$request->session()->flash('add_message', $msg);
					}
					if(isset($request->caseunlink)){
						foreach($caseidarray as $row=>$case){
							$reportincident = new ReportIncident;
							$linkedcaselist = ReportIncident::where('case_id',$case)->where('incident_id',$incident_id)->get()->first();
							
							if(isset($linkedcaselist->id)){
								
								ReportIncident::where('id',$linkedcaselist->id)->delete();
								
								
							}
							
						
							
						}
						$msg = 'Incident has been Un-linked successfully.';
						$request->session()->flash('add_message', $msg);
					}
				}
				else{
                    if(isset($request->returnUrl)){
                        $returnUrl = $request->returnUrl;
                        $returnId = $caseidarray[0];
                        return redirect()->route($returnUrl,['id'=>@$returnId]);
                    }
					return redirect()->route('admin-editIncident',['id'=>@$incident_id]);
				}
					$queries = DB::getQueryLog();
					/// dd_my($queries);				
				
			 
					if(isset($request->returnUrl)){
                        $returnUrl = $request->returnUrl;
                        $returnId = $caseidarray[0];
                        return redirect()->route($returnUrl,['id'=>@$returnId]);
                    }
					return redirect()->route('admin-editIncident',['id'=>@$incident_id]);
		 }
		//echo 'sdsd';
		//print_r($request);
		//{{route('admin-linkreportToIncident',['id'=>@$data->id])}}
		return redirect()->route('admin-incidentList');
	}
    public function linkincident_toreport_action(Request $request) {
        // DB::enableQueryLog();
      $account_id = $request->session()->get('account_id');

        $user_id = $request->session()->get('id');
		//if(isset($request->reportlink)) echo $request->reportlink;
	//	if(isset($request->reportunlink)) echo $request->reportunlink;
		//echo $request->incidentunlink;
		//print_r($request->all()); die;
		 if ($request->all()) { 
		 
                    $reportidarray  = $request->reportid; 
					
					$incident_id  = $request->incidentid; 
					
					//$reportListArray=ReportIncident::select('*');
					//print_r($linktoreport); 
				if(count($reportidarray)>0){

					if(isset($request->reportlink)){
						foreach($reportidarray as $row=>$report){
							$reportincident = new ReportIncident;
							$linkedcaselist = ReportIncident::where('report_id',$report)->where('incident_id',$incident_id)->get()->first();
							
							if(isset($linkedcaselist->id)){
								
								//ReportIncident::where('id',$reportlist->id)->delete();
								
								//echo $reportid.'--------------'.$incident_id;
								//continue;
							}else{
								
								$reportincident->report_id  = $report;
								$reportincident->incident_id  = $incident_id;
								$reportincident->created_at  = date('Y-m-d H:i:s');
					   
								$reportincident->save(); 
								//echo $reportid.'insert'.$incident_id;
							}
								
									
							//echo $reportlist->report_id;
									//echo $reportlist->id;
							
						
							
						}
						$msg = 'Incident has been linked successfully.';
						$request->session()->flash('add_message', $msg);
					}
					if(isset($request->reportunlink)){
						foreach($reportidarray as $row=>$report){
							$reportincident = new ReportIncident;
							$linkedcaselist = ReportIncident::where('report_id',$report)->where('incident_id',$incident_id)->get()->first();
							
							if(isset($linkedcaselist->id)){
								
								ReportIncident::where('id',$linkedcaselist->id)->delete();
								
								
							}
							
						
							
						}
						$msg = 'Incident has been Un-linked successfully.';
						$request->session()->flash('add_message', $msg);
					}
				}
				else{
					return redirect()->route('admin-editIncident',['id'=>@$incident_id]);
				}
					$queries = DB::getQueryLog();
					/// dd_my($queries);				
				
			 
					
					return redirect()->route('admin-editIncident',['id'=>@$incident_id]);
		 }
		//echo 'sdsd';
		//print_r($request);
		//{{route('admin-linkreportToIncident',['id'=>@$data->id])}}
		return redirect()->route('admin-incidentList');
	}
    public function ajax_edit_incident(Request $request) {
		
        //dd($request);
        $group = Group::orderBy('name', 'asc')->get();
		$account_id = $request->session()->get('account_id');
		$user_id = $request->session()->get('id');
		$user_role_name = $request->session()->get('user_role_name');
		$incident_type =  DB::table('incident_type')->orWhereNull('incident_type.deleted_at')->where('incident_type.account_id',$account_id)->get();
		 $incident_id = $request->incident_id; 
        $data = array();
        $data = Incident::find($incident_id);
		//return dd($data);
		return view('admin.ajax_add_incident', ['data' => $data,'incident_type'=>$incident_type,'group'=>$group]);
	}
	 public function ajax_post_edit_incident(Request $request) {
		$account_id = $request->session()->get('account_id');
		$user_id = $request->session()->get('id');
		$user_role_name = $request->session()->get('user_role_name');
		 if ($request->all()) { //post

           //dd($request->all());
		  
		    $incident_id = $request->incident_id; 
			 $record_numbers = DB::table('incident')->where('incident.id',$incident_id)->max('record_number');
		if(!empty($record_numbers)){
			$record_number = $record_numbers;
		}else{
		$record_numbers = DB::table('incident')->max('record_number');
			if(!empty($record_numbers)){
				$record_number = $record_numbers+1;
			}else{
				$record_number = '100';
			}
		}
            $title = $request->title; 
            $description = $request->description; 
            $incident_datetime = $request->incidentdatetimepicker;
			$group_id = $request->group_id;
			/*$reported_by = $request->reported_by;
			$date_of_report = $request->date_of_report;
			$location = $request->location;
			$law_enforcement_contacted = $request->law_enforcement_contacted;
			$medical_assistance_required = $request->medical_assistance_required;
			$follow_up_actions = $request->follow_up_actions;
			$victim_name_and_contact_info = $request->victim_name_and_contact_info;			
			$persons_of_concern_name_and_contact_info = $request->persons_of_concern_name_and_contact_info;
			$witnesses_names_and_contact_info = $request->witnesses_names_and_contact_info;
		    if($date_of_report) $date_of_report=date('Y-m-d H:i:s', strtotime($date_of_report));*/
		   if($incident_datetime) $incident_datetime=date('Y-m-d H:i:s', strtotime($incident_datetime));

            $type = $request->type;
			
            $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description' => 'required',
					'incidentdatetimepicker' => 'required',
					'date_of_report' => 'required',
                    'type' => 'required'
                   
                ]);
            
            if ($validator->fails()) 
            {
					$msg = $validator->messages()->toJson();
					$request->session()->flash('add_message', $msg);
                    echo json_encode(array('message'=>$msg,'status'=>'error'));
                
            }
            else {

                
                $incident = Incident::find($incident_id);
                $incident->title = $title;
                $incident->description = $description;
                $incident->type = $type;
				/*$incident->incident_datetime = $incident_datetime;
				$incident->record_number = $record_number;
				$incident->reported_by = $reported_by;
				$incident->date_of_report = $date_of_report;
				$incident->location = $location;
				$incident->law_enforcement_contacted = $law_enforcement_contacted;
				$incident->medical_assistance_required = $medical_assistance_required;
				$incident->follow_up_actions = $follow_up_actions;
				$incident->victim_name_and_contact_info = serialize($victim_name_and_contact_info);			
				$incident->persons_of_concern_name_and_contact_info = serialize($persons_of_concern_name_and_contact_info);
				$incident->witnesses_names_and_contact_info = serialize($witnesses_names_and_contact_info);*/
                $incident->save();
                $incidentGroup = IncidentToGroup::where('incident_id', '=', $incident_id)->update(['group_id' => $group_id]);
                if(!$incidentGroup)
                {
                    $incidentGroup = IncidentToGroup::insertGetId(['incident_id' => $incident_id, 'group_id' => $group_id ]);
                }
                $msg = 'Incident has been updated successfully.';
                $request->session()->flash('add_message', $msg);
                echo json_encode(array('message'=>$msg,'status'=>'success'));
                
            }
        }
	 }
	public function incidentwithtask(Request $request,$id=''){
        $type = 'edit';
        if($request->id){
        $data = Incident::find($request->id);
        $tasks = Tasks::with(['user'])->where('tasks.status', '!=', '');
        if($request->session()->get('user_role_id') > 1 )
        {     
            $tasks->where('account_id', '=', $request->session()->get('account_id') ) ;
        }
        $taskListArray = $tasks->WhereNull('.deleted_at')->get();
      // die();
         if($request->all()){
            //dd($request->all());
                        if( !empty($request->existingtaskId) ) {
                            $existingtaskIdArray = explode(',',$request->existingtaskId );
                            if(count($existingtaskIdArray)>0){
                                foreach($existingtaskIdArray as $key){
                                    TaskIncident::where('task_id', $key)->where('incident_id',$request->id)->delete();
                                }
                            }
                        }
                        if(!empty($request->send_tasks)){
                            foreach(array_filter($request->send_tasks) as $value){                        
                                    $casetask = new TaskIncident;
                                    $casetask->task_id             =  $value;
                                    $casetask->incident_id         =  $request->id;
                                    $casetask->save();
                            }
                        }          
                        $msg = 'Tasks are linked successfully.';
                        $request->session()->flash('add_message', $msg);                
                        return redirect()->route('admin-editIncident',$request->id);
                    }

         return view('admin.add_incident_task', ['data'=>$data,'request' => $request,'taskListArray'=>$taskListArray,'type'=>$type]);
        
     }
}

public function linkincident_totask_action(Request $request){
   // echo '<pre>'; print_r($request->all()); die();
    if(!empty($request->incidentid)){
        TaskIncident::where('task_id', $request->taskid)->where('incident_id',$request->incidentid)->delete();
    }
    return redirect()->route('admin-editIncident',$request->incidentid);
}   


public function ajaxAddNewIncident(Request $request, $id = '') {

        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
       // $group = Group::orderBy('name', 'asc')->get();

        $group = Group::with(['userGroup'])->with('accountGroup') ;
     //   dd($request->all());
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
            
        }
        $group = $group->orderBy('created_at', 'desc')->get(); 
       // echo '<pre>'; print_r($group); echo '</pre>';

        $record_numbers = DB::table('incident')->where('incident.id',$id)->max('record_number');
        if(!empty($record_numbers)){
            $record_number = $record_numbers;
        }else{
        $record_numbers = DB::table('incident')->max('record_number');
            if(!empty($record_numbers)){
                $record_number = $record_numbers+1;
            }else{
                $record_number = '100';
            }
        }
        $user_role_name = $request->session()->get('user_role_name');
        
        $data = array();
        $data = Incident::find($id);
        $incident_type =  DB::table('incident_type')->orWhereNull('incident_type.deleted_at')->where('incident_type.account_id',$account_id)->get();
        $reportListArray = array();
        $caseListArray = array();
        $data['case_id'] = $request->id;
       //  return view('admin.ajax_add_incident_on_case_page', ['data' => $data,'incident_type'=>$incident_type,'group'=>$group]);
         return view('admin.ajax_add_incident_on_case_page', ['data' => $data,'reportdata'=>$reportListArray,'caselistdata'=>$caseListArray, 'request' => $request, 'incident_type' =>  $incident_type,'group'=>$group ]);
       
    }

    public function ajaxtogetlatitudeandlongitude(Request $request){
           // echo $address = "123 main street, pelham, NY";
            //echo '<pre>'; print_r($request->get('location')); echo '</pre>';
            $geolocation = array();
            $address = $request->get('location');
            $apiKey = 'AIzaSyAq9He6hEcMpg9DyzHgr8r4iGJfnOcCSKg'; // Google maps now requires an API key.
            // Get JSON results from this request
            $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$apiKey);
            $geo = json_decode($geo, true); // Convert the JSON to an array
          //  echo '<pre>'; print_r($geo); echo '</pre>';
             $geolocation['latitude']   = $geo['results'][0]['geometry']['location']['lat']; // Latitude
             $geolocation['longitude']  = $geo['results'][0]['geometry']['location']['lng']; // Longitude
             $geolocation['place_id']  = $geo['results'][0]['place_id']; // place_id

            echo json_encode($geolocation);
            exit();
    }

    public function getLocationAndLongitudeAndLatitudeGraph(Request $request){
    }

    public function admindatatablerecords(Request $request){
            $mainArrayData = array();
            $admin_id = $request->session()->get('id');        
            $account_id = $request->session()->get('account_id');       
            $user_role_name = $request->session()->get('user_role_name');
            $user_role_id = $request->session()->get('user_role_id');
            if ($user_role_name!="superAdmin")
            {
            $account_id = $request->session()->get('account_id');
            } 


            $group = Group::with(['userGroup'])->with('accountGroup')->with('incidentGroup') ;
            $user_id = $request->session()->get('id');
            if($request->session()->get('user_role_id') > 1 )
            {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
            }
            if(isset($request->groupId)) $group->where('id',$request->groupId);
            $group = $group->orderBy('created_at', 'desc')->get(); 
            //dd($group);
            if(!empty($group)){
                $arrayRecord = array();
                $mainArrayData = $incidentTypes = array();
                foreach($group as $key=>$value){
                        $incidentArray = array();
                        //echo count($value['incidentGroup']);
                        if( count($value['incidentGroup'])>0  ){ 
                            foreach ($value['incidentGroup'] as $keyincident => $valueincident) {
                               $incidentArray[] = $valueincident['incident_id']; 
                               $groupId = $valueincident['group_id'];
                              }
                              if(!empty($groupId)){
                                $incidentTypeGroup =  DB::table('incident')
                                ->select(DB::raw('count(*) as incident_type_count, incident.type,incident_type.type'), DB::raw("DATE_FORMAT(incident.created_at, '%m-%Y') new_date"),  DB::raw('YEAR(incident.created_at) year, MONTH(incident.created_at) month'))
                                ->join('incident_type', 'incident_type.id', '=', 'incident.type');
                                if(isset($request->monthgragh)) $incidentTypeGroup->whereMonth('incident.created_at', $request->monthgragh);
                                if(isset($request->yeargragh)) $incidentTypeGroup->whereYear('incident.created_at', $request->yeargragh);
                                $incidentTypeGroup->whereIn('incident.id',$incidentArray);
                                $incidentTypeGroup = $incidentTypeGroup->groupBy('incident.type')->groupBy('year','month')->get();
                                $mainArrayData[$groupId] = $incidentTypeGroup;
                            }
                            }
                }
               // die();
                if(!empty($mainArrayData)){
                    foreach ($mainArrayData as $keyouter => $valueouter) {
                        foreach ($valueouter as $keyinner => $valueinner) {
                           $arrayRecord[$keyouter][$valueinner->type][] = $valueinner->incident_type_count;      
                           $incidentTypes[] =  $valueinner->type;                        
                        }
                    }
                }
                //dd($arrayRecord);
                $incidentTypes = array_unique($incidentTypes);


            }

        return view('admin.graph.incidents',['group'=>$group,'incidentTypes'=>$incidentTypes,'arrayRecord'=>$arrayRecord]);

    }


    public function admindatatablemonthyrecords(Request $request){
            $mainArrayData = array();
            $admin_id = $request->session()->get('id');        
            $account_id = $request->session()->get('account_id');       
            $user_role_name = $request->session()->get('user_role_name');
            $user_role_id = $request->session()->get('user_role_id');
            if ($user_role_name!="superAdmin")
            {
            $account_id = $request->session()->get('account_id');
            } 


            $group = Group::with(['userGroup'])->with('accountGroup')->with('incidentGroup') ;
            $user_id = $request->session()->get('id');
            if($request->session()->get('user_role_id') > 1 )
            {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
            }
            if(isset($request->groupId)) $group->where('id',$request->groupId);
            $group = $group->orderBy('created_at', 'desc')->get(); 
            //dd($group);
            $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'Octber', 11 => 'November', 12 => 'December');
            $monthArray = array();
            if(!empty($group)){
                $arrayRecord = array();
                $mainArrayData = $incidentTypes = array();
                foreach($group as $key=>$value){
                        $incidentArray = array();
                        //echo count($value['incidentGroup']);
                        if( count($value['incidentGroup'])>0  ){ 
                            foreach ($value['incidentGroup'] as $keyincident => $valueincident) {
                               $incidentArray[] = $valueincident['incident_id']; 
                               $groupId = $valueincident['group_id'];
                              }
                              if(!empty($groupId)){
                                $incidentTypeGroup =  DB::table('incident')
                                ->select(DB::raw('count(*) as incident_type_count, incident.type,incident_type.type'), DB::raw("DATE_FORMAT(incident.created_at, '%m-%Y') new_date"),  DB::raw('YEAR(incident.created_at) year, MONTH(incident.created_at) month'))
                                ->join('incident_type', 'incident_type.id', '=', 'incident.type');
                                if(isset($request->yeargragh)) $incidentTypeGroup->whereYear('incident.created_at', $request->yeargragh);
                                $incidentTypeGroup->whereIn('incident.id',$incidentArray);
                                $incidentTypeGroup = $incidentTypeGroup->groupBy('incident.type')->groupBy('year','month')->get();
                                $mainArrayData[$groupId] = $incidentTypeGroup;
                            }
                            }
                }
               // die();
               // dd($mainArrayData);
                if(!empty($mainArrayData)){
                    foreach ($mainArrayData as $keyouter => $valueouter) {
                        foreach ($valueouter as $keyinner => $valueinner) {
                           $arrayRecord[$valueinner->month][$valueinner->type][] = $valueinner->incident_type_count;      
                           $incidentTypes[] =  $valueinner->type; 
                           if(array_key_exists($valueinner->month, $months)){
                                $monthArray[$valueinner->month] =  $months[$valueinner->month];
                          // $monthArray[]  =  $valueinner->month;                        
                           }
                        }
                    }
                }
                $incidentTypes = array_unique($incidentTypes);
                $newDataArray = array();
                if(!empty($incidentTypes)){

                }
                $mainDataArray = array();
                foreach($arrayRecord as $key=>$value){
                    foreach($value as $keyInner=>$valueInner){
                        foreach($incidentTypes as $keyincident=>$valueIncident){
                            if(!array_key_exists($valueIncident, $value)){
                                $newDataArray[$key][$valueIncident] = array(0);
                            }
                            if($valueIncident == $keyInner){
                                $newDataArray[$key][$keyInner][] = $valueInner[0];
                            }
                        }
                    }                   
                }

            }

        return view('admin.graph.incidentsmonthly',['group'=>$group,'incidentTypes'=>$incidentTypes,'mainDataArray'=>$newDataArray,'monthArray'=>$monthArray]);

    }

   

}