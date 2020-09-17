<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\ResizeImageComp;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use DB;
use PDF;
use Auth;
use Mail;
Use Config;
use Session;
use App\File;
use App\Log;
use App\User;
use App\Site;
use App\Forum;
use App\Tasks;
use App\Notes;
use App\Group;
use Validator;
use App\Target;
use App\CaseList;
use App\Subject;
use App\Incident;
use App\TempTasks;
use App\TempFactorList;
use App\TempCaseList;
use App\TempSubject;
use App\TempTarget;
use Carbon\Carbon;
use App\CaseTask;
Use App\CaseToGroup;
use App\AccountList;
use App\ReportIncident;
use App\Http\Controllers\Controller;

class PdfController extends AdminController
{
    public function __construct() {
        parent::__construct();
        $this->middleware('check_admin_status');
        $this->middleware('revalidate');
        $this->CaseList_obj = new CaseList();
        $this->record_per_page=10;
    }
    public function downloadcaselog(Request $request,$id='')
    {
		$account_id = $request->session()->get('account_id');
		$user_id = $request->session()->get('id');
		$data = array();
		$caseId = $id;
		$data['caseDetails'] = CaseList::find($id);
		$caseLog = Log::where('case_id',$caseId)->get();
		$category = array();
		$pdfFileName = str_replace(" ", "-", $data['caseDetails']['title']) . '.pdf';
       // dd($caseLog);
        $data['userList'] = DB::table('users')
            ->where('account_id', $account_id)
            ->get();
        if ($id) {
            $data['caseList'] = CaseList::find($id);
        }
        $request = $request;
        if (count($data['userList']) > 0) {
            foreach ($data['userList'] as $row) {
                if ($data['caseDetails']->case_owner_id == $row->id)
                    $data['case_owner_name'] = ucfirst($row->first_name) . ' ' . ucfirst($row->last_name);
            }
        }
        $casecounter = $subjectcounter = $targetcounter = $taskcounter = $factorcounter = 0;
        foreach($caseLog as $key=>$val){
        	$model_name = $val->model_name;
        	$type_id 	= $val->type_id;
        	//die();
        	switch ($model_name) {
        		case 'Case':
        			$data['getAllSectorByCaseId'] = CaseList::getAllSectorByCaseId($type_id);
        			$data['caseDetails'] = TempCaseList::find($type_id);
                    if(!empty($data['caseDetails'])){     
                        if( ($data['caseDetails']->updated_at == NULL)){
                            $insertOrUpdate ='Case Registerd On : '.$data['caseDetails']->created_at->format('d-m-Y H:i:s'); 

                        }else{
                            $insertOrUpdate ='Case Updated On : '. $data['caseDetails']->updated_at->format('d-m-Y H:i:s');  
                        }
                    	$data['insertOrUpdate'] = $insertOrUpdate; 
                    	$tableData[] = view('pdf.case', compact("data", "request"));
                    }
        			break;
        		case 'Note':
        			$data['notesinserted'] = 'Notes Added On: '; 
        			$data['notesDetails'] = Notes::find($type_id);
        			$tableData[] = view('pdf.notes', compact("data", "request"));
        			break;
    			case 'Subject':        			
                        $data['subjectDetails'] = TempSubject::find($type_id);
                        if(!empty($data['subjectDetails'])){         			
                            if( ($data['subjectDetails']->updated_at == NULL)){
                            $subjectinsertOrUpdate ='Subject Registerd On : '.$data['subjectDetails']->created_at->format('d-m-Y H:i:s');                      
                            }else{
                            $subjectinsertOrUpdate ='Subject Updated On : '.$data['subjectDetails']->updated_at->format('d-m-Y H:i:s');  
                            }
                            $data['subjectinsertOrUpdate'] = $subjectinsertOrUpdate; 
                            $tableData[] = view('pdf.subject', compact("data", "request"));
                       }
    			break;
        		case 'Target':
	    			$data['targetDetails'] = TempTarget::find($type_id);  
                    if(!empty($data['targetDetails'])){   
                        if( ($data['targetDetails']->updated_at == NULL)){
                        $targetinsertOrUpdate ='Target Registerd On : ' .$data['targetDetails']->created_at->format('d-m-Y H:i:s');                     
                        }else{
                        $targetinsertOrUpdate ='Target Updated On : ' .$data['targetDetails']->updated_at->format('d-m-Y H:i:s'); 
                        }
                        $data['targetinsertOrUpdate'] = $targetinsertOrUpdate;
                        $tableData[] = view('pdf.target', compact("data", "request"));
                    }
    			break;	
    			case 'Task':
	    			 $data['taskDetails'] = TempTasks::find($type_id);    
                     if(!empty($data['taskDetails'])){ 
                            if( ($data['taskDetails']->updated_at == NULL)){
                            $taskinsertOrUpdate ='Task Added and Linked with Case On : '.$data['taskDetails']->created_at->format('d-m-Y H:i:s');                   
                            }else{
                            $taskinsertOrUpdate ='Task Updated On : '.$data['taskDetails']->updated_at->format('d-m-Y H:i:s');  
                            }
                            $data['taskinsertOrUpdate'] = $taskinsertOrUpdate; 
                            $tableData[] = view('pdf.task', compact("data", "request"));
                        }
    			break;
    			case 'Factor':
	    			$data['factorDetails'] = TempFactorList::find($type_id); 
                    if(!empty($data['factorDetails'])){ 
                        if( ($data['factorDetails']->updated_at == NULL)){
                        $factorinsertOrUpdate ='Factor Added and Linked with Case On : '.$data['factorDetails']->created_at->format('d-m-Y H:i:s');                     
                        }else{
                        $factorinsertOrUpdate ='Factor Updated On : '.$data['factorDetails']->updated_at->format('d-m-Y H:i:s');  
                        }

                        $data['factorinsertOrUpdate'] = $factorinsertOrUpdate;  
                        $tableData[] = view('pdf.factor', compact("data", "request"));
                    }
    			break;
                case 'incident_link_to_report':
                    $activity    = $val->activity; 
                    $incident_id    = $val->incident_id; 
                    $linked_date = $val->created_at;  
                    $data['incidentDetails'] = Incident::find($incident_id); 
                    //dd($data['incidentDetails']);
                    if(!empty($data['incidentDetails'])){ 
                        if($activity == 'insert'){ 
                        $incidentInsertOrDelete='Incident Is Linked with Case On : '; 
                        }else{
                        $incidentInsertOrDelete ='Incident Is Unlinked with Case On : '; 
                        }
                        $data['linked_date'] = $linked_date;
                        $data['incidentInsertOrDelete'] = $incidentInsertOrDelete;  
                        $tableData[] = view('pdf.incident', compact("data", "request"));
                    }
                break;
        		default:
        			# code...
        			break;
        	}
        }
        //echo view('pdf.case_log_pdf', compact("data", "request","tableData")); die();
        $pdf = PDF::loadView('pdf.case_log_pdf', compact("data", "request","tableData"));
        return $pdf->download($pdfFileName);
    }

    //
}
