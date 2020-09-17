<?php
/* copied from account controller */
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
use App\AccountList;
use App\ReportIncident;
use App\Incident;
use App\CaseList;
use App\Subject;
use App\Target;
use App\File;
use App\User;
use App\Report;
use App\Group;
use App\ReportMedia;
use Session;
use Carbon\Carbon;
use DB;
use App\ReportToGroup;
class ReportController extends AdminController
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
        $this->Report_obj = new Report();
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
        $user_role_id = $request->session()->get('user_role_id');      
        $group = Group::with(['userGroup'])->with('accountGroup') ;
        $user_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');	
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
            
        }
        $group = $group->orderBy('created_at', 'desc')->get(); 
        //echo '<pre>'; print_r($group); echo '</pre>';
        if ($user_role_name!="superAdmin")
        {
        $account_id = $request->session()->get('account_id');
        } 
        $pageNo = trim($request->input('page', 1));
        $group_filter =  trim($request->input('group_filter')); 
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
        if ($user_role_id==1)
        {   // $account_list = AccountList::orderby('account.name','ASC')->get();
                $account_list = Report::Join('account', 'account.id', '=', 'report.account_id')
            ->orWhereNull('report.deleted_at')
            ->select(DB::raw("account.id, account.name, count(*) as total"))
            ->groupBy('report.account_id')->get();
        } 
         DB::enableQueryLog();
         $user_group = $request->session()->get('user_group');
        $reportListArray = Report::leftJoin('account', 'report.account_id', '=', 'account.id')
        ->orWhereNull('report.deleted_at')
        ->select('report.*', 'account.name as account_name')
        ->with(['reportGroup']);

        if(!in_array($request->session()->get('user_role_id'), array(1,2)))
        {
           $reportListArray = $reportListArray->whereHas('reportGroup', function ($q) use ($user_group) {$q->whereIn('group_id',$user_group);});
            
        }
  
        if(isset($account_id) && $account_id!="")
            {
                $reportListArray->where('report.account_id',$account_id);
            }
            if(isset($group_filter) && $group_filter!="")
            {
                //dd($reportListArray);
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
        $reportListArray = $reportListArray->orderby('report.created_at','desc');


        $this->data['records'] = $reportListArray->paginate($this->record_per_page);

         $queries = DB::getQueryLog();
        return view('admin.report_mng', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list,'group'=>$group]);
    }

	/**
    * Function view_reportlist
    *
    * function to get user report which is linked from incident.
    *
    * @Created Date: 12/07/2018
   
    * @Created By: Nikhil
    
    * @param  ARRAY
    * @return STRING
    */
	
	public function view_reportlist($id,Request $request) {
		$incident=$id;
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

        $reportListArray = Report::leftJoin('account', 'report.account_id', '=', 'account.id')->join('incident_linkto_report','incident_linkto_report.report_id','=','report.id')
        ->orWhereNull('report.deleted_at')->Where('incident_linkto_report.incident_id',$incident)
        ->select('report.*', 'account.name as account_name');


  
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
        return view('admin.report_mng', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list]);
    }
	
    /**
    * Function view_report
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
    public function view_report($id,Request $request) {
         DB::enableQueryLog();
      $account_id = $request->session()->get('account_id');

        $user_id = $request->session()->get('id');
		//$incident_type =  DB::table('incident_type')->get();
		//$incident =  DB::table('incident')->get();
            if ($request->all()) { 
                    
                    

            
               $report_id  = $request->report_id;
               $account_id = $request->account_id;
               $case_id    = $request->case_id;

              $mediaList = ReportMedia::where('report_id',$report_id)->get();

               foreach ($mediaList as $key => $value) {
                   $FileData = new File;
                   # code...
                   $report_file_name =  $value->file_name;
                   $report_file_url = get_image_url(@$report_file_name,'report');
               
                if(isset($report_file_url))
                {
                    $image_url=$report_file_url;
                    $data = file_get_contents($image_url);
                    $filename = 'report_'.basename($report_file_url);
                   

                    $new = public_path('uploads/files/' . $filename);
                    $upload =file_put_contents($new, $data);
                    $FileData->profile_pic = $filename;
                }

                $FileData->account_id  = $account_id;
                $FileData->created_by     = $user_id;
                $FileData->case_id = $case_id;
                $FileData->title = $value->title;
                $FileData->description = '';
                $FileData->save();


               }
               $reportDetails = Report::find($report_id);
               $reportDetails->case_id  = $case_id;
               $reportDetails->isImport  = 'y';
               $reportDetails->save();
               //dd($request->all());

               $msg = 'All files has been successfully imported to the selected case.';
               $request->session()->flash('add_message', $msg);

            }

        if ($id) {
            
        $incidentArray = Incident::Join('incident_type','incident_type.id','=','incident.type')->Join('incident_linkto_report', 'incident_linkto_report.incident_id', '=', 'incident.id')
         ->select('incident_type.type','incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type','incident.created_at')->where('incident_linkto_report.report_id',$id)->get();
		//$queries = DB::getQueryLog();
            //dd($queries);

            $data = Report::leftJoin('account', 'report.account_id', '=', 'account.id')->leftJoin('case_list', 'case_list.id', '=', 'report.case_id')
                ->select('report.*', 'account.name as account_name','case_list.title as case_title')->where('report.id',$id)->with('reportlists')->first();
            $case_list = CaseList::where('account_id',$data->account_id)->orderby('case_list.title','ASC')->get();
            $queries = DB::getQueryLog();
            //dd($queries);
            return view('admin.report_detail',['data'=>$data,'request'=>$request,'case_list'=>$case_list,'incident'=>$incidentArray]);
        }
        else{
            return redirect()->route('admin-reportList');
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
    public function delete_report($id, Request $request) {
        if ($id) {
            $Report = Report::find($id);
            $Report->deleted_at = date("Y-m-d h:i:s");
            if($Report->save()){
                $msg = 'Report has been deleted successfully.';
                $request->session()->flash('message', $msg);
            }
        }
        return redirect()->route('admin-reportList');
    }
    public function incident_linkto_report(Request $request) {
        // DB::enableQueryLog();
      $account_id = $request->session()->get('account_id');

        $user_id = $request->session()->get('id');
		//if(isset($request->incidentlink)) echo $request->incidentlink;
		//if(isset($request->incidentunlink)) echo $request->incidentunlink;
		//echo $request->incidentunlink;
		//print_r($request->all()); die;
		 if ($request->all()) { 
		 
                    $linktoreport  = $request->linktoreport; 
					$reportid  = $request->reportid; 
					$linktoreportid  = $request->linktoreportid; 
					$linkedtype  = $request->linkedtype; 
					
					//$reportListArray=ReportIncident::select('*');
					//print_r($linktoreport); 
				if(count($linktoreport)>0){

					if(isset($request->incidentlink)){
						foreach($linktoreport as $row=>$incident_id){
							$reportincident = new ReportIncident;
							if($linkedtype=='report'){
								$reportlist = ReportIncident::where('report_id',$reportid)->where('incident_id',$incident_id)->get()->first();
							}
							if($linkedtype=='case'){
								$reportlist = ReportIncident::where('case_id',$reportid)->where('incident_id',$incident_id)->get()->first();
							}
							
							if(isset($reportlist->id)){
								
								//ReportIncident::where('id',$reportlist->id)->delete();
								
								//echo $reportid.'--------------'.$incident_id;
								//continue;
							}else{
								if($linkedtype=='case')$reportincident->case_id  = $reportid;
								if($linkedtype=='report')$reportincident->report_id  = $reportid;
								
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
					if(isset($request->incidentunlink)){
						foreach($linktoreport as $row=>$incident_id){
							$reportincident = new ReportIncident;
							
							if($linkedtype=='report'){
								$reportlist = ReportIncident::where('report_id',$reportid)->where('incident_id',$incident_id)->get()->first();
							}
							if($linkedtype=='case'){
								$reportlist = ReportIncident::where('case_id',$reportid)->where('incident_id',$incident_id)->get()->first();
							}
							
							
							if(isset($reportlist->id)){
								
								ReportIncident::where('id',$reportlist->id)->delete();
								
								
							}
							
						
							
						}
						$msg = 'Incident has been Un-linked successfully.';
						$request->session()->flash('add_message', $msg);
					}
				}
				else{
					if($linkedtype=='case')return redirect()->route('admin-caseList');
					if($linkedtype=='report')return redirect()->route('admin-reportList');
					
				}
					$queries = DB::getQueryLog();
					/// dd_my($queries);				
				
			 
					if($linkedtype=='case')return redirect()->route('admin-viewCase',['id'=>@$reportid]);
					if($linkedtype=='report')return redirect()->route('admin-viewReport',['id'=>@$reportid]);
					 
		 }
		//echo 'sdsd';
		//print_r($request);
		//{{route('admin-linkreportToIncident',['id'=>@$data->id])}}
		return redirect()->route('user-dashboard');
	}
    public function updatereporttogroup(Request $request){
        $reportGroup = new ReportToGroup();
        //$reportGroup->report_id     =   $request->report_id ;
        //$reportGroup->group_id      =   $request->group_id;
        //if( (!empty($request->report_id)) && ($request->group_id))
    //    echo  $affectedRows =  $reportGroup->where('report_id', '=', $request->report_id)->update(array('group_id' => $request->group_id));
    //    die();
       //$incidentGroup = ReportToGroup::where('incident_id', '=', $id)->update(['group_id' => $group_id]);
       $reportGroupaffectedRows =  $reportGroup->where('report_id', '=', $request->report_id)->update(array('group_id' => $request->group_id));
        if(!$reportGroupaffectedRows)
        {
           $reportGroupaffectedRows = ReportToGroup::insertGetId(['report_id' =>  $request->report_id, 'group_id' => $request->group_id ]);
           echo '1';
        }
        else{
            echo '0';
        }
    }


}