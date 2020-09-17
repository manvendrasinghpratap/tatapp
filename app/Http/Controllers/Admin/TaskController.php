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
use App\CaseList;
use App\Tasks;
use App\EmailLog;
use App\AccountList;
use App\Accounttask;
use App\FactorList;
use App\User;
use App\Group;
use App\Incident;
use App\IncidentTask;
use App\CaseTask;
use Session;
use App\TaskIncident;
use Carbon\Carbon;
use DB;
use App\Zone;
use DateTime;
use DateTimeZone;
class TaskController extends AdminController
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
        $this->CaseList_obj = new CaseList();
        $this->record_per_page=10;
    }
   
    
    
        /**
    * Function ajaxSaveTask 
    *
    * function to Save Task
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    
    
    /**
    * Function ajaxSaveTask 
    *
    * function to Save Task
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxSaveTask( Request $request) {

        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
          
           
        if($request->task_id > 0){
                 
            $taskDetails = $this->CaseList_obj->getTaskDetails($request->task_id);
            $task_assigned_to = $taskDetails->task_assigned ;
           
                DB::table('tasks')
                  ->where('id', $request->task_id)
                  ->update(
                [
                    'account_id' => $account_id, 
                    'created_by' => $user_id,
                    'case_id' => $request->case_id,
                    'incident_id' => $request->incident_id,
                    'title' => $request->title, 
                    'description' => $request->description,
                    'task_assigned' => $request->task_assigned, 
                    'due_date' => $request->due_date, 
                    'status' => $request->status
                   
                ]
              );
                
            if($request->task_assigned != $task_assigned_to && $request->status != "closed" ) {
                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($request->task_id);
		if(!empty($taskDetailsArray)){
                    $user = User::find($taskDetailsArray->task_assigned);
			if(!empty($user)){
                            $to=$user->email;
                            //$to='manvendra_pratap@yahoo.com';
                            $subject = 'TADapp Task Reminder for '.$taskDetailsArray->case_title.' : '.$taskDetailsArray->title;
                                                        
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject , 'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.'.$ex->getMessage();
                               $status='Failure';
                               $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'message_body' => $message, 'created_at' => date("y-m-d h:i:s")]);
                               $request->session()->flash('add_message', $message);
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                        }
                    }
                }
                
                else{
                       
                $message='Task saved successfully';
                $status='Success';
                $request->session()->flash('add_message', $message);
                echo json_encode(array('message'=>$message,'status'=>$status));
                }
        }
        else{

            $arrProp = array();
            $arrProp['case_id'] = $request->case_id;
            $arrProp['title'] = $request->title; // factor name
        
            $resp = $this->CaseList_obj->isTaskDataAlreadyExist($arrProp);

            if(!$resp){

                if($request->task_id > 0){
                DB::table('tasks')
                  ->where('id', $request->task_id)
                  ->update(
                [
                    'account_id' => $account_id, 
                    'created_by' => $user_id,
                    'case_id' => $request->case_id,
                    'incident_id' => $request->incident_id,
                    'title' => $request->title, 
                    'description' => $request->description,
                    'task_assigned' => $request->task_assigned, 
                    'due_date' => $request->due_date, 
                    'status' => $request->status
                ]
              );
            }
            else{

                $id = DB::table('tasks')->insertGetId(
                [
                    'account_id' => $account_id, 
                    'created_by' => $user_id,
                    'case_id' => $request->case_id,
                    'incident_id' => $request->incident_id,
                    'title' => $request->title, 
                    'description' => $request->description,
                    'task_assigned' => $request->task_assigned, 
                    'due_date' => $request->due_date, 
                    'status' => $request->status
                ]
              );  
            }
            

            if(!empty($request->case_id) && (!empty($id)) ){
                        $casetask = new CaseTask;
                        $casetask->task_id              =  $id;
                        $casetask->case_id              =  $request->case_id;
                        $casetask->save();
                        }

            if($request->status != "closed" ) {
                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($id);
		if(!empty($taskDetailsArray)){
                    $user = User::find($taskDetailsArray->task_assigned);
			if(!empty($user)){
                            $to=$user->email;
                            //$to='manvendra_pratap@yahoo.com';
                            $subject = 'TADapp Task Reminder for '.$taskDetailsArray->case_title.' : '.$taskDetailsArray->title;
                                                        
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject ,  'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.';
                               $status='Failure';
                               $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $message , 'message_body' => '' , 'created_at' => date("y-m-d h:i:s")]);
                               
                               $request->session()->flash('add_message', $message);
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                                  
                        }
                    }
                }else{
                       
                $message='Task saved successfully';
                $status='Success';
                $request->session()->flash('add_message', $message);
                echo json_encode(array('message'=>$message,'status'=>$status));
                }
             
        }
     }
    }


    
 /**
    * Function ajaxSaveTask 
    *
    * function to Save Task
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */


     public function saveTask( Request $request) {

        // $caseId = $request->case_id ? $request->case_id : $request->existingcaseid;
        //  dd($request->all());  
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');         
        if($request->task_id > 0){   
            $taskDetails = $this->CaseList_obj->getTaskDetails($request->task_id);
            if(empty($taskDetails)){
                $taskDetails = Tasks::find($request->task_id);
            }


           if(!empty($taskDetails)){$task_assigned_to = $taskDetails->task_assigned;}else{$task_assigned_to = $request->task_assigned;  }
           $due_date_timeZone = $taskDetails->due_date_timeZone;

           if( (!empty($taskDetails->incident_id)) && ($taskDetails->incident_id != '') ){
                $incident_id = $taskDetails->incident_id;
                $incidentDetails = Incident::find($incident_id);
                $timezone = $incidentDetails->incidentGroup->group->timezone;
                $date = new DateTime($request->due_date);
                $date->setTimezone(new DateTimeZone($timezone));
                $due_date_timeZone = $date->format('Y-m-d H:i');

            }
            if( (!empty($taskDetails->case_id)) && ($taskDetails->case_id != '') ){
                $caseDetails = $this->CaseList_obj::find($taskDetails->case_id);
                $timezone = $caseDetails->caseGroup->group->timezone;
                $date = new DateTime($request->due_date);
                $date->setTimezone(new DateTimeZone($timezone));
                $due_date_timeZone = $date->format('Y-m-d H:i');

            }

           if( (empty($taskDetails->case_id)) && ($taskDetails->case_id == '') && (empty($taskDetails->incident_id)) && ($taskDetails->incident_id == '') )
           {
                if($taskDetails->casetasklist->count()>0){
                    $case_id = $taskDetails->casetasklist[0]->case_id;
                    $caseDetails = $this->CaseList_obj::find($case_id);
                    $timezone = $caseDetails->caseGroup->group->timezone;
                    $date = new DateTime($request->due_date);
                    $date->setTimezone(new DateTimeZone($timezone));
                    $due_date_timeZone = $date->format('Y-m-d H:i');
                }
                if($taskDetails->TaskIncident->count()>0){
                    $incident_id = $taskDetails->incidenttasks[0]->incident_id;
                    $incidentDetails = Incident::find($incident_id);
                    $timezone = $incidentDetails->incidentGroup->group->timezone;
                    $date = new DateTime($request->due_date);
                    $date->setTimezone(new DateTimeZone($timezone));
                    $due_date_timeZone = $date->format('Y-m-d H:i');
                }
           }

            
            

             $request->existingcaseid;
                if(!empty($request->caseids)){
                $caseIds = explode(',',$request->caseids);
                 if( !empty($request->existingcaseid) ) {
                            $existingcaseidArray = explode(',',$request->existingcaseid );
                            if(count($existingcaseidArray)>0){
                                foreach($existingcaseidArray as $key){
                                    CaseTask::where('task_id', $request->task_id)->where('case_id',$key)->delete();
                                }
                            }
                        }
                            foreach(array_filter($caseIds) as $value){                        
                                    $casetask = new CaseTask;
                                    $casetask->task_id              =  $request->task_id;
                                    $casetask->case_id              =  $value;
                                    $casetask->save();
                            }
                }
                 if(!empty($request->incidentids)){
                  $incidentids = explode(',',$request->incidentids);
                  if( !empty($request->existingincidentid) ) {
                            $existingincidentidArray = explode(',',$request->existingincidentid );
                            if(count($existingincidentidArray)>0){
                                foreach($existingincidentidArray as $key){
                                    TaskIncident::where('task_id', $request->task_id)->where('incident_id',$key)->delete();
                                }
                            }
                        }
                            foreach(array_filter($incidentids) as $value){                        
                                    $incidentFiles = new TaskIncident;
                                    $incidentFiles->incident_id         =  $value;
                                    $incidentFiles->task_id             =  $request->id;
                                    $incidentFiles->save();
                            }
                }

                DB::table('tasks')
                  ->where('id', $request->task_id)
                  ->update(
                        [
                            'account_id' => $account_id, 
                            'created_by' => $user_id,
                           // 'case_id' => $request->case_id ? $request->case : $request->existingcaseid,
                            'title' => $request->title, 
                            'description' => $request->description,
                            'task_assigned' => $request->task_assigned, 
                            'due_date' => $request->due_date, 
                            'due_date_timeZone' => $due_date_timeZone,                              
                            'zone' => $request->zone, 
                            'status' => $request->status                   
                        ]
              ); 

           //dd($request->all());   

           if($request->task_assigned != $task_assigned_to && $request->status != "closed" ) {
                $taskDetailsArray = Tasks::find($request->task_id);
                    if(!empty($taskDetailsArray->incidenttasks) && (count($taskDetailsArray->incidenttasks)>0) ){
                    $user = User::find($taskDetailsArray->task_assigned);
                    if(!empty($user)){
                            $to=$user->email;
                            //$to='manvendra_pratap@yahoo.com';
                            $subject = 'TADapp Task Reminder for '. $taskDetailsArray->incidenttasks[0]->incident->title.' : '.$taskDetailsArray->title;
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign_incident', ['data' => $data]), 'text/html'); // for HTML rich messages;   
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
                                ['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject ,  'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                echo 'try';
                                return redirect()->route('admin-task-list');
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.';
                               $status='Failure';
                               $id = EmailLog::insertGetId(
                                ['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $message , 'message_body' => '' , 'created_at' => date("y-m-d h:i:s")]);
                               $request->session()->flash('add_message', $message);
                               return redirect()->route('admin-task-list',$request->incidentid);
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                                  
                        }
                    }
                }



               // echo $task_assigned_to;
               // dd($request->all());
            if($request->task_assigned != $task_assigned_to && $request->status != "closed" ) {
                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($request->task_id);
               // dd($taskDetailsArray);
                if(!empty($taskDetailsArray)){
                    $user = User::find($taskDetailsArray->task_assigned);
               // dd($user);
                            if(!empty($user)){
                            $to=$user->email;
                            $subject = 'TADapp Task Reminder for '.$taskDetailsArray->case_title.' : '.$taskDetailsArray->title;                                                        
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject , 'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                return redirect()->route('admin-task-list');
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.'.$ex->getMessage();
                               $status='Failure';
                               $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'message_body' => $message, 'created_at' => date("y-m-d h:i:s")]);
                               $request->session()->flash('add_message', $message);
                               return redirect()->route('admin-task-list');
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                        }
                    }
                }
                
                else{
                       
                $message='Task saved successfully';
                $status='Success';
                $request->session()->flash('add_message', $message);
                 return redirect()->route('admin-task-list');
                echo json_encode(array('message'=>$message,'status'=>$status));
                }
        }                                       /*End of if */
        else{


            $arrProp = array();
            $arrProp['case_id'] = $request->case_id;
            $arrProp['title'] = $request->title; // factor name
            
             $resp = $this->CaseList_obj->isTaskDataAlreadyExist($arrProp);
            if(!$resp){
                if($request->task_id > 0){
                        DB::table('tasks')
                          ->where('id', $request->task_id)
                          ->update(
                                [
                                    'account_id' => $account_id, 
                                    'created_by' => $user_id,
                                    'case_id' => $request->case_id,
                                   // 'incident_id' => $request->incident_id,
                                    'title' => $request->title, 
                                    'description' => $request->description,
                                    'task_assigned' => $request->task_assigned, 
                                    'due_date' => $request->due_date, 
                                    'due_date_timeZone' => $request->due_date, 
                                    'zone' => $request->zone, 
                                    'status' => $request->status
                                ]
                      );
            }
            else{
                $id = DB::table('tasks')->insertGetId(
                [
                    'account_id' => $account_id, 
                    'created_by' => $user_id,
                    'case_id' => $request->case_id,
                    'incident_id' => $request->incident_id,
                    'title' => $request->title, 
                    'description' => $request->description,
                    'task_assigned' => $request->task_assigned, 
                    'due_date' => $request->due_date, 
                    'due_date_timeZone' => $request->due_date, 
                    'zone' => $request->zone, 
                    'status' => $request->status
                ]
              );  
            }
            if($request->status != "closed" ) {
                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($id);
                    if(!empty($taskDetailsArray)){
                    $user = User::find($taskDetailsArray->task_assigned);
                    if(!empty($user)){
                            $to=$user->email;
                            //$to='manvendra_pratap@yahoo.com';
                            $subject = 'TADapp Task Reminder for '.$taskDetailsArray->case_title.' : '.$taskDetailsArray->title;
                                                        
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject ,  'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                echo 'try';
                                return redirect()->route('admin-task-list');
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.';
                               $status='Failure';
                               $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $message , 'message_body' => '' , 'created_at' => date("y-m-d h:i:s")]);
                               
                               $request->session()->flash('add_message', $message);
                               echo 'cartch';
                               return redirect()->route('admin-task-list');
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                                  
                        }
                    }else{
                    $message='Task saved successfully';
                    $status='Success';
                    $request->session()->flash('add_message', $message);
                    return redirect()->route('admin-task-list');
                    }
                }else{                       
                    $message='Task saved successfully';
                    $status='Success';
                    $request->session()->flash('add_message', $message);
                    return redirect()->route('admin-task-list');
               // echo json_encode(array('message'=>$message,'status'=>$status));
                }  /* $request->status if condiotion closed */


             
        }
     }
    }




    public function updateincidentTask( Request $request) {

        // $caseId = $request->case_id ? $request->case_id : $request->existingcaseid;
        //  dd($request->all());  
    	$account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');         
        if($request->task_id > 0){   
    		$taskDetails = $this->CaseList_obj->getTaskDetails($request->task_id);
            if(empty($taskDetails)){
                $taskDetails = Tasks::find($request->task_id);
            }
           if(!empty($taskDetails)){$task_assigned_to = $taskDetails->task_assigned;}else{$task_assigned_to = $request->task_assigned;  }
           $due_date_timeZone = $taskDetails->due_date_timeZone;
           if( (!empty($taskDetails->incident_id)) && ($taskDetails->incident_id != '') ){
                $incident_id = $taskDetails->incident_id;
                $incidentDetails = Incident::find($incident_id);
                $timezone = $incidentDetails->incidentGroup->group->timezone;
                $date = new DateTime($request->due_date);
                $date->setTimezone(new DateTimeZone($timezone));
                $due_date_timeZone = $date->format('Y-m-d H:i');

            }
            if( (!empty($taskDetails->case_id)) && ($taskDetails->case_id != '') ){
                $caseDetails = $this->CaseList_obj::find($taskDetails->case_id);
                $timezone = $caseDetails->caseGroup->group->timezone;
                $date = new DateTime($request->due_date);
                $date->setTimezone(new DateTimeZone($timezone));
                $due_date_timeZone = $date->format('Y-m-d H:i');

            }

           if( (empty($taskDetails->case_id)) && ($taskDetails->case_id == '') && (empty($taskDetails->incident_id)) && ($taskDetails->incident_id == '') )
           {
                if($taskDetails->casetasklist->count()>0){
                    $case_id = $taskDetails->casetasklist[0]->case_id;
                    $caseDetails = $this->CaseList_obj::find($case_id);
                    $timezone = $caseDetails->caseGroup->group->timezone;
                    $date = new DateTime($request->due_date);
                    $date->setTimezone(new DateTimeZone($timezone));
                    $due_date_timeZone = $date->format('Y-m-d H:i');
                }
                if($taskDetails->TaskIncident->count()>0){
                    $incident_id = $taskDetails->incidenttasks[0]->incident_id;
                    $incidentDetails = Incident::find($incident_id);
                    $timezone = $incidentDetails->incidentGroup->group->timezone;
                    $date = new DateTime($request->due_date);
                    $date->setTimezone(new DateTimeZone($timezone));
                    $due_date_timeZone = $date->format('Y-m-d H:i');
                }
           }
           //echo $due_date_timeZone;

          // dd($taskDetails);


           //dd($taskDetails);
            //$task_assigned_to = $taskDetails->task_assigned;  
             $request->existingcaseid;
                if(!empty($request->caseids)){
            	$caseIds = explode(',',$request->caseids);
            	 if( !empty($request->existingcaseid) ) {
                            $existingcaseidArray = explode(',',$request->existingcaseid );
                            if(count($existingcaseidArray)>0){
                                foreach($existingcaseidArray as $key){
                                    CaseTask::where('task_id', $request->task_id)->where('case_id',$key)->delete();
                                }
                            }
                        }
                            foreach(array_filter($caseIds) as $value){                        
                                    $casetask = new CaseTask;
                                    $casetask->task_id             	=  $request->task_id;
                                    $casetask->case_id              =  $value;
                                    $casetask->save();
                            }
                }
                 if(!empty($request->incidentids)){
            	$incidentids = explode(',',$request->incidentids);
            	  if( !empty($request->existingincidentid) ) {
                            $existingincidentidArray = explode(',',$request->existingincidentid );
                            if(count($existingincidentidArray)>0){
                                foreach($existingincidentidArray as $key){
                                    TaskIncident::where('task_id', $request->task_id)->where('incident_id',$key)->delete();
                                }
                            }
                        }
                            foreach(array_filter($incidentids) as $value){                        
                                    $incidentFiles = new TaskIncident;
                                    $incidentFiles->incident_id         =  $value;
                                    $incidentFiles->task_id             =  $request->id;
                                    $incidentFiles->save();
                            }
                }

                DB::table('tasks')
                  ->where('id', $request->task_id)
                  ->update(
                		[
							'account_id' => $account_id, 
							'created_by' => $user_id,
							//'case_id' => $request->case_id ? $request->case : $request->existingcaseid,
							'title' => $request->title, 
							'description' => $request->description,
							'task_assigned' => $request->task_assigned, 
							'due_date' => $request->due_date, 
                            'due_date_timeZone' => $due_date_timeZone,
                            'zone' => $request->zone, 
							'status' => $request->status                   
                        ]
              ); 

           //dd($request->all());   

           if($request->task_assigned != $task_assigned_to && $request->status != "closed" ) {
                $taskDetailsArray = Tasks::find($request->task_id);
                    if(!empty($taskDetailsArray->incidenttasks) && (count($taskDetailsArray->incidenttasks)>0) ){
                    $user = User::find($taskDetailsArray->task_assigned);
                    if(!empty($user)){
                            $to=$user->email;
                            //$to='manvendra_pratap@yahoo.com';
                            $subject = 'TADapp Task Reminder for '. $taskDetailsArray->incidenttasks[0]->incident->title.' : '.$taskDetailsArray->title;
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign_incident', ['data' => $data]), 'text/html'); // for HTML rich messages;   
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
                                ['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject ,  'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                echo 'try';
                                return redirect()->route('admin-task-list');
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.';
                               $status='Failure';
                               $id = EmailLog::insertGetId(
                                ['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $message , 'message_body' => '' , 'created_at' => date("y-m-d h:i:s")]);
                               $request->session()->flash('add_message', $message);
                               return redirect()->route('admin-task-list',$request->incidentid);
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                                  
                        }
                    }
                }



               // echo $task_assigned_to;
               // dd($request->all());
            if($request->task_assigned != $task_assigned_to && $request->status != "closed" ) {
                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($request->task_id);
               // dd($taskDetailsArray);
				if(!empty($taskDetailsArray)){
                    $user = User::find($taskDetailsArray->task_assigned);
               // dd($user);
							if(!empty($user)){
                            $to=$user->email;
                            $subject = 'TADapp Task Reminder for '.$taskDetailsArray->case_title.' : '.$taskDetailsArray->title;                                                        
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject , 'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                return redirect()->route('admin-task-list');
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.'.$ex->getMessage();
                               $status='Failure';
                               $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'message_body' => $message, 'created_at' => date("y-m-d h:i:s")]);
                               $request->session()->flash('add_message', $message);
                               return redirect()->route('admin-task-list');
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                        }
                    }
                }
                
                else{
                       
                $message='Task saved successfully';
                $status='Success';
                $request->session()->flash('add_message', $message);
                 return redirect()->route('admin-task-list');
                echo json_encode(array('message'=>$message,'status'=>$status));
                }
        }                                       /*End of if */
        else{


            $arrProp = array();
            $arrProp['case_id'] = $request->case_id;
            $arrProp['title'] = $request->title; // factor name
            
             $resp = $this->CaseList_obj->isTaskDataAlreadyExist($arrProp);
            if(!$resp){
                if($request->task_id > 0){
		                DB::table('tasks')
		                  ->where('id', $request->task_id)
		                  ->update(
				                [
				                    'account_id' => $account_id, 
				                    'created_by' => $user_id,
				                   // 'case_id' => $request->case_id,
				                   // 'incident_id' => $request->incident_id,
				                    'title' => $request->title, 
				                    'description' => $request->description,
				                    'task_assigned' => $request->task_assigned, 
				                    'due_date' => $request->due_date, 
                                    'due_date_timeZone' => $request->due_date, 
                                    'zone' => $request->zone, 
				                    'status' => $request->status
				                ]
		              );
            }
            else{
                $id = DB::table('tasks')->insertGetId(
                [
                    'account_id' => $account_id, 
                    'created_by' => $user_id,
                   // 'case_id' => $request->case_id,
                   // 'incident_id' => $request->incident_id,
                    'title' => $request->title, 
                    'description' => $request->description,
                    'task_assigned' => $request->task_assigned, 
                    'due_date' => $request->due_date, 
                    'due_date_timeZone' => $request->due_date, 
                    'zone' => $request->zone, 
                    'status' => $request->status
                ]
              );  
            }
            if($request->status != "closed" ) {
                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($id);
					if(!empty($taskDetailsArray)){
                    $user = User::find($taskDetailsArray->task_assigned);
					if(!empty($user)){
                            $to=$user->email;
                            //$to='manvendra_pratap@yahoo.com';
                            $subject = 'TADapp Task Reminder for '.$taskDetailsArray->case_title.' : '.$taskDetailsArray->title;
                                                        
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject ,  'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                echo 'try';
                                return redirect()->route('admin-task-list');
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.';
                               $status='Failure';
                               $id = EmailLog::insertGetId(
['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $message , 'message_body' => '' , 'created_at' => date("y-m-d h:i:s")]);
                               
                               $request->session()->flash('add_message', $message);
                               echo 'cartch';
                               return redirect()->route('admin-task-list');
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                                  
                        }
                    }else{
                    $message='Task saved successfully';
	                $status='Success';
	                $request->session()->flash('add_message', $message);
	                return redirect()->route('admin-task-list');
                    }
                }else{                       
	                $message='Task saved successfully';
	                $status='Success';
	                $request->session()->flash('add_message', $message);
	                return redirect()->route('admin-task-list');
               // echo json_encode(array('message'=>$message,'status'=>$status));
                }  /* $request->status if condiotion closed */


             
        }
     }
    }



    /**
    * Function ajaxGetTaskDetails 
    *
    * function to get change module status
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */                                                              /* Its working */
    public function ajaxGetTaskDetails( Request $request) {
            $user_id = $request->session()->get('id');
            $request->session()->get('user_role_id');
            $account_id = $request->session()->get('account_id');
            $displaynone     =  'none';
            $groupIds = DB::table('user_to_group')->where('user_id',$user_id)->pluck('group_id','group_id');
            $listOfuserBelongToGroups = User::with(['userGroup'])->whereIn('status', [1, 2])->where('account_id', $account_id);
            $listOfuserBelongToGroups->whereHas('userGroup', function ($q) use ($groupIds) {$q->whereIn('group_id',$groupIds);});
            $userList = $listOfuserBelongToGroups->get();               



            $task_id = (isset($request->task_id))?$request->task_id:'0';
            if($task_id>0){
                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($task_id);
                $data = array();
                $data['taskDetailsArray'] =  $taskDetailsArray;
                $caseId = $taskDetailsArray->case_id;          
                $data['caseList'] = CaseList::find($caseId);               
                $data['caseId'] = $request->case_id;         
            }elseif($request->case_id>0){

                $caseId = $request->case_id;                
                $data = array();
                $data['taskDetailsArray']   =  array();
                $data['caseList'] = CaseList::find($caseId);
                $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
                $data['getAllSectorByCaseId'] = array();
                $data['caseId'] = $request->case_id;  
            }else{
                $data = array();
                $data['taskDetailsArray']   =  array();
                $caseListQuery = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
    			->orWhereNull('case_list.deleted_at')
    			->select('case_list.*', 'account.name')
    			->with('caseOwnerName')
                ->where('case_list.account_id',$account_id);
                if($request->session()->get('user_role_id') > 2){
                    $caseListQuery->where('case_list.case_owner_id', $user_id);
                }
                $caseListArray = $caseListQuery->get();  

    			$data['caseLists'] =   $caseListArray;
    			$data['caseList'] = array('account_id'=>$account_id);
                $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
                $data['incidentListArray']  =  $incidentListArray = Incident::where('account_id',$account_id)->pluck('title','id');
                $data['caseId'] = $request->case_id; 
                $data['getAllSectorByCaseId'] = array();
			} 
            return view('admin.ajax_view_task', ['data' => $data, 'request' => $request, 'userList' => $userList,'displaynone'=>$displaynone]);
    }

    public function ajaxGetTaskDetailsChangeStatus( Request $request) {
            $zones = Zone::orderBy('name')->pluck('name','name');
            $user_id = $request->session()->get('id');
            $request->session()->get('user_role_id');
            $account_id = $request->session()->get('account_id');
            $displaynone     =  'none';
            $groupIds = DB::table('user_to_group')->where('user_id',$user_id)->pluck('group_id','group_id');
            $listOfuserBelongToGroups = User::with(['userGroup'])->whereIn('status', [1, 2])->where('account_id', $account_id);
            $listOfuserBelongToGroups->whereHas('userGroup', function ($q) use ($groupIds) {$q->whereIn('group_id',$groupIds);});
            $userList = $listOfuserBelongToGroups->get();               



            $task_id = (isset($request->task_id))?$request->task_id:'0';
            if($task_id>0){
                $taskDetailsArray = Tasks::find($task_id);
                $data = array();
                $data['zones']      =  $zones;
                $data['taskAjaxDetailsArray'] =  $taskDetailsArray;
                $data['caseList'] = array('account_id'=>$account_id);            
            }elseif($request->case_id>0){

                $caseId = $request->case_id;                
                $data = array();
                $data['zones']      =  $zones;
                $data['taskDetailsArray']   =  array();
                $data['caseList'] = CaseList::find($caseId);
                $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
                $data['getAllSectorByCaseId'] = array();
                $data['caseId'] = $request->case_id;  
            }else{
                $data = array();
                $data['zones']      =  $zones;
                $data['taskDetailsArray']   =  array();
                $caseListQuery = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
                ->orWhereNull('case_list.deleted_at')
                ->select('case_list.*', 'account.name')
                ->with('caseOwnerName')
                ->where('case_list.account_id',$account_id);
                if($request->session()->get('user_role_id') > 2){
                    $caseListQuery->where('case_list.case_owner_id', $user_id);
                }
                $caseListArray = $caseListQuery->get();  

                $data['caseLists'] =   $caseListArray;
                $data['caseList'] = array('account_id'=>$account_id);
                $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
                $data['incidentListArray']  =  $incidentListArray = Incident::where('account_id',$account_id)->pluck('title','id');
                $data['caseId'] = $request->case_id; 
                $data['getAllSectorByCaseId'] = array();
            } 
            return view('admin.ajax_view_task', ['data' => $data, 'request' => $request, 'userList' => $userList,'displaynone'=>$displaynone]);
    }


/**
    * Function ajaxGetCaseDetails 
    *
    * function to get change module status
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxGetCaseDetails( Request $request) {
    	//die();
            $user_id = $request->session()->get('id');
            $request->session()->get('user_role_id');
            $account_id = $request->session()->get('account_id');
            $displaynone     =  'none';
           /* $userListd =  DB::table('users')
                ->whereIn('status', [1, 2])
                ->where('account_id', $account_id)
                ->get();  */
            $groupIds = DB::table('user_to_group')->where('user_id',$user_id)->pluck('group_id','group_id');
            $listOfuserBelongToGroups = User::with(['userGroup'])->whereIn('status', [1, 2])->where('account_id', $account_id);
            $listOfuserBelongToGroups->whereHas('userGroup', function ($q) use ($groupIds) {$q->whereIn('group_id',$groupIds);});
            $userList = $listOfuserBelongToGroups->get();               



           $task_id = (isset($request->task_id))?$request->task_id:'0';
            if($task_id>0){
                $taskDetailsArray = Tasks::find($task_id);
                $data = array();
                $data['taskAjaxDetailsArray'] =  $taskDetailsArray;
                $caseListQuery = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
    			->orWhereNull('case_list.deleted_at')
    			->select('case_list.*', 'account.name')
    			->with('caseOwnerName')
                ->where('case_list.account_id',$account_id);
                if($request->session()->get('user_role_id') > 2){
                    $caseListQuery->where('case_list.case_owner_id', $user_id);
                }
                $caseListArray = $caseListQuery->get(); 
               $data['caseLists'] =   $caseListArray;
    			$data['caseList'] = array('account_id'=>$account_id);          
                //dd($data);            
            }elseif($request->case_id>0){

                $caseId = $request->case_id;                
                $data = array();
                $data['taskDetailsArray']   =  array();
                $data['caseList'] = CaseList::find($caseId);
                $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
                $data['getAllSectorByCaseId'] = array();

            }else{
                $data = array();
                $data['taskDetailsArray']   =  array();
                $caseListQuery = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
    			->orWhereNull('case_list.deleted_at')
    			->select('case_list.*', 'account.name')
    			->with('caseOwnerName')
                ->where('case_list.account_id',$account_id);
                if($request->session()->get('user_role_id') > 2){
                    $caseListQuery->where('case_list.case_owner_id', $user_id);
                }
                $caseListArray = $caseListQuery->get();  

    			$data['caseLists'] =   $caseListArray;
    			$data['caseList'] = array('account_id'=>$account_id);              
			} //die();
            return view('admin.ajax_case_linked_task', ['ajaxdata' => $data]);
    }

    /**
    * Function addedittaskdetails 
    *
    * function to get change module status
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function addedittaskdetails( Request $request,$id = '') {
            $user_id = $request->session()->get('id');
            $request->session()->get('user_role_id');
            $account_id = $request->session()->get('account_id');
            $displaynone     =  'none';
           /* $userListd =  DB::table('users')
                ->whereIn('status', [1, 2])
                ->where('account_id', $account_id)
                ->get();  */
            $groupIds = DB::table('user_to_group')->where('user_id',$user_id)->pluck('group_id','group_id');
            $listOfuserBelongToGroups = User::with(['userGroup'])->whereIn('status', [1, 2])->where('account_id', $account_id);            
            if(Session::get('user_role_id')==4){
            $listOfuserBelongToGroups->where('id',Session::get('id'));
            }
            $listOfuserBelongToGroups->whereHas('userGroup', function ($q) use ($groupIds) {$q->whereIn('group_id',$groupIds);});
            $userList = $listOfuserBelongToGroups->get();               



            $task_id = (isset($request->task_id))?$request->task_id:'0';
            if($task_id>0){
                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($task_id);
                $data = array();
                $data['taskDetailsArray'] =  $taskDetailsArray;
                $caseId = $taskDetailsArray->case_id;          
                $data['caseList'] = CaseList::find($caseId);               
                //dd($data);            
            }elseif($request->case_id>0){

                $caseId = $request->case_id;                
                $data = array();
                $data['taskDetailsArray']   =  array();
                $data['caseList'] = CaseList::find($caseId);
                $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
                $data['getAllSectorByCaseId'] = array();

            }else{
                $data = array();
                $data['taskDetailsArray']   =  array();
                $caseListQuery = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
    			->orWhereNull('case_list.deleted_at')
    			->select('case_list.*', 'account.name')
    			->with('caseOwnerName')
                ->where('case_list.account_id',$account_id);
                if($request->session()->get('user_role_id') > 2){
                    $caseListQuery->where('case_list.case_owner_id', $user_id);
                }
                $caseListArray = $caseListQuery->get();  

    			$data['caseLists'] =   $caseListArray;
    			$data['caseList'] = array('account_id'=>$account_id);
                $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
                $data['incidentListArray']  =  $incidentListArray = Incident::where('account_id',$account_id)->pluck('title','id');

                $data['getAllSectorByCaseId'] = array();
			} 
            return view('admin.add_new_task', ['data' => $data, 'request' => $request, 'userList' => $userList,'displaynone'=>$displaynone]);
    }

    public function  edittaskdetails(Request $request,$id){
        // dd($request->all());
        $zones = Zone::orderBy('name')->pluck('name','name');
    		$user_id = $request->session()->get('id');
            $request->session()->get('user_role_id');
            $account_id = $request->session()->get('account_id');
            $displaynone     =  'none';
            $groupIds = DB::table('user_to_group')->where('user_id',$user_id)->pluck('group_id','group_id');
            $listOfuserBelongToGroups = User::with(['userGroup'])->whereIn('status', [1, 2])->where('account_id', $account_id);
            if(Session::get('user_role_id')==4){
            $listOfuserBelongToGroups->where('id',Session::get('id'));
            }
            $listOfuserBelongToGroups->whereHas('userGroup', function ($q) use ($groupIds) {$q->whereIn('group_id',$groupIds);});
            $userList = $listOfuserBelongToGroups->get();  
            $task_id = (isset($request->id))?$request->id:'0';
            if($task_id>0){
                $taskDetailsArray = Tasks::find($task_id);
                $data = array();
                $data['taskDetailsArray'] =  $taskDetailsArray;
                $caseId = $taskDetailsArray->case_id;          
                $data['caseList'] = CaseList::find($caseId);     
                $data['zones']  = $zones;         
               // dd($data);            
            }elseif($request->case_id>0){
                $caseId = $request->case_id;                
                $data = array();
                $data['taskDetailsArray']   =  array();
                $data['caseList'] = CaseList::find($caseId);
                $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
                $data['getAllSectorByCaseId'] = array();
                $data['zones']  = $zones;  

            }else{

                $data = array();
                $data['taskDetailsArray']   =  array();
                $data['zones']  = $zones;  
                $caseListQuery = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
    			->orWhereNull('case_list.deleted_at')
    			->select('case_list.*', 'account.name')
    			->with('caseOwnerName')
                ->where('case_list.account_id',$account_id);
                if($request->session()->get('user_role_id') > 2){
                    $caseListQuery->where('case_list.case_owner_id', $user_id);
                }
                $caseListArray = $caseListQuery->get();  

    			$data['caseLists'] =   $caseListArray;
    			$data['caseList'] = array('account_id'=>$account_id);
                $data['sectorListByAccount'] = CaseList::getAllSectorList($account_id);
                $data['incidentListArray']  =  $incidentListArray = Incident::where('account_id',$account_id)->pluck('title','id');
                $data['getAllSectorByCaseId'] = array();
			} 
            return view('admin.add_new_task', ['data' => $data, 'request' => $request, 'userList' => $userList,'displaynone'=>$displaynone]);       
    }
 
      /**
    * Function ajaxAssignTaskDetails 
    *
    * function to get Task Details
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxAssignTaskDetails( Request $request) {
           
            
            $task_id = (isset($request->task_id))?$request->task_id:'0';
            if($task_id>0){
            $taskDetailsArray = $this->CaseList_obj->getTaskDetails($task_id);
            echo json_encode($taskDetailsArray);
            
            }
    }
 public function ajaxSendTaskDetails( Request $request) {
           
            //$mails = (isset($request->mails))?$request->mails:'';
            $from = (isset($request->from))?$request->from:'';
            $send_tasks = (isset($request->send_tasks))?$request->send_tasks:'';
            $data="";
            $to = array();
            $subject = 'Task Detail';
            $headers = "From: " . strip_tags("$from") . "\r\n";
            $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            if(!empty($send_tasks)){
                parse_str($send_tasks, $send_tasks_data);
                //parse_str($mails, $mails_data);
                $data="<p>Task List</p>";
                $count=1;
                if(count($send_tasks_data)>0){
                    $data = array();
                    foreach($send_tasks_data['send_tasks'] as $taskdatas){
                        //foreach($taskdata as $taskdatas){
                            if(!empty($taskdatas)){
                                
                                //shw start 11-02-20
                                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($taskdatas);
                                if(!empty($taskDetailsArray)){
                                    $user = User::find($taskDetailsArray->task_assigned);
                                        if(!empty($user)){
                                            $to=$user->email;
                                            //$to='manvendra_pratap@yahoo.com';
                                            $subject = 'TADapp Task Reminder for '.$taskDetailsArray->case_title.' : '.$taskDetailsArray->title;
                                            $data['taskDetailsArray'] = $taskDetailsArray;
                                            $data['user']  = $user; //dd($data);
                                            try {
                                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                                });
                                                $count++;
                                                $message_body = view('emails.task_assign', ['data' => $data]);
                                                $id = EmailLog::insertGetId(
           [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);
                                                
                                           } catch (Exception $ex) {
                                               // Debug via $ex->getMessage();
                                               $message='Mail Not Send.'.$ex->getMessage();
                                               $status='Failure';
                                               //$request->session()->flash('add_message', $message);
                                              
                                           }
                                        }
                                    }
                                         
                                        
                                }
                                //}
                        }
                }
                
                if($count>1){
                     $message='Email reminder send to assigned user.';
                     $status='Success';
                     //$request->session()->flash('add_message', $message);
                     echo json_encode(array('message'=>$message,'status'=>$status));
                }
                
          //shw end
        }else{
			
            $message='Mail Not Send.';
            $status='Failure';
            echo json_encode(array('message'=>$message,'status'=>$status));
        }
        
            
    }

/**
    * Function ajaxGetTaskEmailLog 
    *
    * function to get change module status
    *
    * @Created Date: 12 Feb 2020
    * @Modified Date:  12 Feb 2020
    * @Created By: Shweta Trivedi
    * @Modified By: Shweta Trivedi
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxGetTaskEmailLog( Request $request) {
            $task_id = (isset($request->task_id))?$request->task_id:'0';
            $task_id = (isset($request->task_id))?$request->task_id:'0';
            $emailLog =  EmailLog::where('task_id', $task_id)->orderByRaw('id DESC')->get();
            $data['taskTitle'] = (isset($request->task_title))?$request->task_title:'';
            $data['emailLog'] = $emailLog ;
            return view('admin.ajax_view_emaillog', ['data' => $data]);
    }
    
    /**
    * Function taskList
    *
    * function to get List of all task
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function taskList(Request $request) {
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id'); 
        $user_id = $request->session()->get('id');
        $userBelongToLoginUserGroup = $groupids = array();
        $pageNo = trim($request->input('page', 1));
        DB::enableQueryLog();
        //search fields

        $keyword = strtolower(trim($request->input('keyword')));
        $field_name = strtolower(trim($request->input('field_name'))); 
        $order_by = strtolower(trim($request->input('order_by')));  
        
        $task_assigned = trim($request->input('task_assigned')); 
        $status = trim($request->input('status'));
        //$user_id = trim($request->input('user_id'));
    
        $user_role_name = $request->session()->get('user_role_name');
        $user_role_id = $request->session()->get('user_role_id');
        $account_list = array();
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
       // echo '<pre>'; print_r($group); echo '</pre>'; 
       // echo $request->session()->get('id'); 
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
            /*$taskIdsAssignedInCases = CaseTask::join('case_to_group','case_to_group.case_id','=', 'case_tasks.case_id')->whereIn('group_id',$groupids)->pluck('task_id','task_id')->toArray();
            $taskIdsAssignedInIncidents = IncidentTask::join('incident_to_group','incident_to_group.incident_id','=', 'incident_task.incident_id')->whereIn('group_id',$groupids)->pluck('task_id','task_id')->toArray();
            if( (count($taskIdsAssignedInCases)>0) && (count($taskIdsAssignedInIncidents)>0) ){
                $taskIds = array_merge($taskIdsAssignedInIncidents,$taskIdsAssignedInCases);                
            }elseif(count($taskIdsAssignedInCases)>0){
                $taskIds = $taskIdsAssignedInCases;  
            }elseif(count($taskIdsAssignedInIncidents)>0){
                 $taskIds = $taskIdsAssignedInIncidents;  
            }*/
          

        }
     
        $valid_user_list = array();
           
            if ($user_role_id=="1")
            {
                 $account_id = trim($request->input('account_id'));
                 //$account_list = AccountList::orderby('account.name','ASC')->get();
                 $account_list = Tasks::Join('account', 'account.id', '=', 'tasks.account_id')
                ->select(DB::raw("tasks.account_id, tasks.created_by, tasks.task_assigned, count(*) as total, account.name"))
                ->groupBy('tasks.account_id')->get();


            }
            else{
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
                
                $valid_user_list = Tasks::Join('users', 'users.id', '=', 'tasks.task_assigned')
                ->select(DB::raw("tasks.account_id, tasks.created_by, tasks.task_assigned, count(*) as total, users.id as user_id, users.first_name, users.last_name"))
                ->orwhereIn('tasks.id', $taskIds)
                ->groupBy('tasks.task_assigned');
                $valid_user_list = $valid_user_list->where('tasks.account_id', $account_id)->get();
                ///echo '<pre>'; print_r($valid_user_list); echo '</pre>';
                } 
                $tasks = Tasks::with(['user'])->where('tasks.status', '!=', "''");

                if($request->session()->get('user_role_id') > 1 )
                {     
                    $tasks->where('account_id','=',$request->session()->get('account_id'));
                }

                if($request->session()->get('user_role_id') > 2 )
                {   

                // $tasks->where('task_assigned', '=', $request->session()->get('id') ) ;

                // $tasks->orwhereIn('task_assigned', $userBelongToLoginUserGroup) ;
                }
      
            //echo '<pre>'; print_r($taskIds); echo '</pre>';
            if($task_assigned)
                {
                    $tasks->where('tasks.task_assigned', '=', $task_assigned);
                }elseif($request->session()->get('user_role_id') == 3  ){
                   //$tasks->where('task_assigned', '=', $request->session()->get('id') ) ;
                        $tasks->Where(function ($query) use ($taskIds,$user_id) {
                            $query->where('task_assigned', '=', $user_id ) ;
                        $query->orwhereIn('id', $taskIds);
                        });
                }elseif($request->session()->get('user_role_id') == 4  ){
                    
                    $tasks->Where(function ($query) use ($taskIds,$user_id) {
                        $query->where('task_assigned', '=', $user_id ) ;
                        $query->orwhereIn('id', $taskIds);
                        });



                    //$tasks->orwhereIn('id', $taskIds) ;
                }
                elseif($request->input('group_id') !=''){
                    $tasks->whereIn('id', $taskIds) ;
                }
                if ($user_role_name!="superAdmin")
                {
                    $tasks->where('tasks.account_id',$account_id);
                    
                } 
                if($status)
                {
                    $tasks->where('tasks.status',$status);
                }


        /*if ($user_role_name=="agencyUser")
            {
        if($user_id)
        {
            $tasks->where('tasks.created_by',$user_id);
        }
            }*/
        $status = trim($request->input('status')); 
        if($status)
        {
            $tasks->where('tasks.status',$status);
        }else{
            //$tasks->whereNotIn('tasks.status', ['closed']);
        }

        $account_id = trim($request->input('account_id')); 
        if($account_id)
        {
            $tasks->where('tasks.account_id',$account_id);
        }
        $group_id = trim($request->input('group_id')); 
        if($group_id)
        {
           // $tasks->where('groups.id',$group_id);
        }

        
        if($field_name!="")
        {
            $tasks = $tasks->orderby($field_name, $order_by);
        }
        else{
            $tasks = $tasks->orderby('tasks.created_at','desc');
        }
       
        $this->data['records'] = $tasks->paginate($this->record_per_page);       
       // echo '<pre>'; print_r($this->data['records'][0]['user']['id']); echo '</pre>'; die();
        $queries = DB::getQueryLog();
       /* echo "<pre>";
        print_r($queries);
        echo "</pre>"; */
        //dd_my($queries);
        //dd(DB::getQueryLog());
        return view('admin.taskList', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list, 'valid_user_list'=> $valid_user_list,'user_role_id'=>$user_role_id,'group'=>$group]);
    }


    



  /**
    * Function add_task
    *
    * function to add tasks 
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function add_task(Request $request,$id = null){

        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
      //dd($id);
    $task_detail = array();
    if(!empty($id)){
        $task_detail = Accounttask::find($id);
    }
//dd($task_detail);
     if ($request->all()) { //post
       //dd($request->all());
           
            $task_name = $request->task_name; 
            $description = $request->description; 
            $isActive    = $request->isActive;
           

             $validator = Validator::make($request->all(), [
                    'task_name' => 'required',
                    'isActive' => 'required'
                    
                ]);
            
            if ($validator->fails()) 
            {
                
                    return redirect()->route('admin-add-task')
                            ->withErrors($validator)
                            ->withInput();
                
            }
            else {
                if(!empty($request->id)){
                    $account_task = Accounttask::find($request->id);
                    $msg = 'task has been updated successfully.';
                }else{
                    $account_task = new Accounttask;
                    $msg = 'task has been added successfully.';
                }
                
                $account_task->account_id  = $account_id;
                $account_task->user_id     = $user_id;
                $account_task->task_name = $task_name;
                $account_task->description = $description;
                $account_task->isActive    = $isActive;
                

                //dd($account_list);
                $account_task->save();

                
                $request->session()->flash('add_message', $msg);
                return redirect()->route('admin-task-list');
                
            }
        }
       
    return view('admin.add_task',['data'=>$task_detail]);
  }
 public function addEmail(Request $request,$id = null){

        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
             $message='Mail Not Send.';
			 $status='Failure';
     if ($request->all()) { //post
       //dd($request->all());
			
            $event_type = $request->event_type; 
            $event_time = $request->event_time; 
            $status = $request->status;
			$quantity = $request->quantity;
           
				if(!empty($event_type)){
				$task_detail =  DB::table('task_mail')
                ->where('user_id', $user_id)
                ->get();
				if(isset($task_detail[0]->id)){
				if(!empty($event_time)&&count($event_time)>0){
					$event_time=serialize($event_time);
				}else{
					$event_time="";
				}
				  DB::table('task_mail')
                  ->where('user_id', $user_id)
                  ->update(
					[
						'event_type' => $event_type, 
						'event_time' => $event_time,
						'status' => $status,
						'quantity' => $quantity,
						'user_id' => $user_id
						
					]
				  );
				}
				else{
				if(!empty($event_time)&&count($event_time)>0){
					$event_time=serialize($event_time);
				}else{
					$event_time="";
				}
					$id = DB::table('task_mail')->insertGetId(
					[
						'event_type' => $event_type, 
							'event_time' => $event_time,
							'status' => $status,
							'quantity' => $quantity,
						'user_id' => $user_id
					]
				  );  
				}
             $message='Mail has been Successfully saved';
			 $status='Success';
			 
			 $request->session()->flash('add_message', $message);
			}
			
			}
			 $task_detail =  DB::table('task_mail')
                ->where('user_id', $user_id)
                ->get();
            return view('admin.add_email',['data'=>$task_detail]);
  }

     /**
    * Function ajaxDeleteTask 
    *
    * function to Delete Task info
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxDeleteTask( Request $request) {
           
            
            $task_id = (isset($request->task_id))?$request->task_id:'0';
            
            if($task_id>0){
              DB::table('tasks')
              ->where('id', '=', $task_id)
              ->delete();
            DB::table('case_tasks')->where('task_id', $task_id)->delete();
            DB::table('incident_task')->where('task_id', $task_id)->delete();
            }
    } 
    
/*    public function incidentAndTaskMapped(Request $request, $id = ''){
            $task_id = (isset($request->id))?$request->id:'0'; 
            if($task_id>0){
                    $account_id = $request->session()->get('account_id');
                    $admin_id = $request->session()->get('id');
                    $incidentListArray = Incident::where('account_id',$account_id)->pluck('title','id');         
                    $admin_id = $request->session()->get('id');
                    $type = 'add';
                    $imagenotuploadedmsg = '';
                    $user_id = $request->session()->get('id');
                    $data = array();
                     $data = Tasks::find($id);
                    if($request->all()){
                        if( !empty($request->existingIncidentId) ) {
                            $existingincidentIdArray = explode(',',$request->existingIncidentId );
                            if(count($existingincidentIdArray)>0){
                                foreach($existingincidentIdArray as $key){
                                    IncidentTask::where('account_id', $account_id)->where('incident_id', $key)->where('task_id',$request->id)->delete();
                                }
                            }
                        }
                        if(!empty($request->incidentid)){
                            foreach(array_filter($request->incidentid) as $value){                        
                                    $incidentFiles = new IncidentTask;
                                    $incidentFiles->account_id          =  $account_id;
                                    $incidentFiles->incident_id         =  $value;
                                    $incidentFiles->task_id             =  $request->id;
                                    $incidentFiles->save();
                            }
                        }          
                        $msg = 'Task and Incident are linked successfully.';
                        $request->session()->flash('add_message', $msg);                
                        return redirect()->route('admin-task-list');
                    }

            }       
            return view('admin.add_task_incident', ['data'=>$data,'request' => $request,'type'=>$type,'incidentListArray'=>$incidentListArray]);

    }*/
        public function incidentAndTaskMapped(Request $request, $id = ''){
            $task_id = (isset($request->id))?$request->id:'0'; 
            if($task_id>0){
                echo $request->session()->get('user_role_id');
                    $account_id = $request->session()->get('account_id');
                    $admin_id = $request->session()->get('id');
                    if($request->session()->get('user_role_id') > 1 ){
                    $incidentListArray = Incident::where('account_id',$account_id)->pluck('title','id');         

                    }else{
                    $incidentListArray = Incident::pluck('title','id');         

                    }
                    $type = 'add';
                    $imagenotuploadedmsg = '';
                    $user_id = $request->session()->get('id');
                    $data = array();
                    $data = Tasks::find($id);
                    if($request->all()){
                        if(!empty($request->incidentid)){
                            $data->incident_id = $request->incidentid;
                            $data->save();
                        }          
                        $msg = 'Task and Incident are linked successfully.';
                        $request->session()->flash('add_message', $msg);                
                        return redirect()->route('admin-task-list');
                    }

            }       
            return view('admin.add_task_incident', ['data'=>$data,'request' => $request,'type'=>$type,'incidentListArray'=>$incidentListArray]);

    }

     public function taskAndCase(Request $request, $id = ''){
            $task_id = (isset($request->id))?$request->id:'0'; 
            if($task_id>0){

                $caseListQuery = CaseList::Join('account', 'case_list.account_id', '=', 'account.id')
                ->orWhereNull('case_list.deleted_at')
                ->select('case_list.*', 'account.name')
                ->with('caseOwnerName')
                ->where('case_list.account_id',$request->session()->get('account_id'));
                if($request->session()->get('user_role_id') > 2){
                    $caseListQuery->where('case_list.case_owner_id', $user_id = $request->session()->get('id') );
                }
                $caseListArray = $caseListQuery->get(); 

               // echo '<pre>'; print_r($caseListArray); echo '</pre>'; die();
                    $account_id = $request->session()->get('account_id');
                    $admin_id = $request->session()->get('id');      
                    $type = 'add';
                    $imagenotuploadedmsg = '';
                    $user_id = $request->session()->get('id');
                    $data = array();
                    $data = Tasks::find($id);
                    if($request->all()){
                      //  echo $request->caseid; die();
                        if(!empty($request->caseid)){
                            $data->case_id = $request->caseid;
                            $data->save();
                        }          
                        $msg = 'Task and Case are linked successfully.';
                        $request->session()->flash('add_message', $msg);                
                        return redirect()->route('admin-task-list');
                    }

            }       
            return view('admin.add_task_case', ['data'=>$data,'request' => $request,'type'=>$type,'caseListArray'=>$caseListArray]);

    }


/**
    * Function ajaxGetCaseDetails 
    *
    * function to get change module status
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxGetIncidentDetails( Request $request) {
            $task_id = $id = (isset($request->task_id))?$request->task_id:'0'; 
            if($task_id>0){
                    $account_id = $request->session()->get('account_id');
                    $admin_id = $request->session()->get('id');
                    $incidentListArray = Incident::with(['incidentType'])->where('account_id',$account_id)->get();   
                    //die();
                    $admin_id = $request->session()->get('id');
                    $type = 'add';
                    $imagenotuploadedmsg = '';
                    $user_id = $request->session()->get('id');
                    $data = array();
                    $data = Tasks::find($id);
                    
            }       
            return view('admin.ajax_incident_linked_task', ['data'=>$data,'incidentListArray'=>$incidentListArray]);

    }

        public function addnewTaskIncident( Request $request,$id = '') {
            $zones = Zone::orderBy('name')->pluck('name','name');
            $user_id = $request->session()->get('id');
            $request->session()->get('user_role_id');
            $account_id = $request->session()->get('account_id');
            $displaynone     =  'none';
            $groupIds = DB::table('user_to_group')->where('user_id',$user_id)->pluck('group_id','group_id');
            $listOfuserBelongToGroups = User::with(['userGroup'])->whereIn('status', [1, 2])->where('account_id', $account_id);
            $listOfuserBelongToGroups->whereHas('userGroup', function ($q) use ($groupIds) {$q->whereIn('group_id',$groupIds);});
            $userList = $listOfuserBelongToGroups->get(); 
            $data = array();             
            $data['caseList'] = array('account_id'=>$account_id);
            $data['incidentid'] =  $id;
            $data['account_id'] =  $account_id;
            $data['zones']      =  $zones;

            return view('admin.add_new_task_incident', ['data' => $data, 'request' => $request, 'userList' => $userList]);
    }

    /**
    * Function saveTaskincident 
    *
    * function to Save Task
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function saveTaskincident( Request $request) {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');         
        if($request->task_id > 0){     
            
           $taskDetails = $this->CaseList_obj->getTaskDetails($request->task_id);
          // dd($taskDetails);
        }                                       /*End of if */
        else{

            $incident_id = $request->incidentid;
            $incidentDetails = Incident::find($incident_id);
            $timezone = $incidentDetails->incidentGroup->group->timezone;
            $date = new DateTime($request->due_date);
            $date->setTimezone(new DateTimeZone($timezone));
            $due_date_timeZone = $date->format('Y-m-d H:i');

            $arrProp = array();
            $arrProp['case_id'] = $request->case_id;
            $arrProp['title'] = $request->title; // factor name

            $id = DB::table('tasks')->insertGetId(
                    [
                        'account_id' => $account_id, 
                        'created_by' => $user_id,
                        'title' => $request->title, 
                        'incident_id' => $request->incidentid, 
                        'description' => $request->description,
                        'task_assigned' => $request->task_assigned, 
                        'due_date' => $request->due_date, 
                        'due_date_timeZone' => $due_date_timeZone, 
                        'zone'      => $request->zone, 
                        'status' => $request->status
                    ]
                  ); 
                $incidentFiles = new TaskIncident;
                $incidentFiles->incident_id         =  $request->incidentid;
                $incidentFiles->task_id             =  $id;
                $incidentFiles->save();
                $taskDetails = Tasks::find($id);
              //  dd($taskDetails->incidenttasks[0]->incident->title);


            if($request->status != "closed" ) {
                $taskDetailsArray = Tasks::find($id);
                    if(!empty($taskDetailsArray->incidenttasks) && (count($taskDetailsArray->incidenttasks)>0) ){
                    $user = User::find($taskDetailsArray->task_assigned);
                    if(!empty($user)){
                            $to=$user->email;
                            //$to='manvendra_pratap@yahoo.com';
                            $subject = 'TADapp Task Reminder for '. $taskDetailsArray->incidenttasks[0]->incident->title.' : '.$taskDetailsArray->title;
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign_incident', ['data' => $data]), 'text/html'); // for HTML rich messages;   
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
                                ['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject ,  'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                echo 'try';
                                return redirect()->route('admin-task-list');
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.';
                               $status='Failure';
                               $id = EmailLog::insertGetId(
                                ['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $message , 'message_body' => '' , 'created_at' => date("y-m-d h:i:s")]);
                               $request->session()->flash('add_message', $message);
                               return redirect()->route('admin-editIncident',$request->incidentid);
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                                  
                        }
                    }else{
                    $message='Task saved successfully';
                    $status='Success';
                    $request->session()->flash('add_message', $message);
                    return redirect()->route('admin-editIncident',$request->incidentid);
                    }
                }

            if($request->status != "closed" ) {
                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($id);
                    if(!empty($taskDetailsArray)){
                    $user = User::find($taskDetailsArray->task_assigned);
                    if(!empty($user)){
                            $to=$user->email;
                            //$to='manvendra_pratap@yahoo.com';
                            $subject = 'TADapp Task Reminder for '.$taskDetailsArray->case_title.' : '.$taskDetailsArray->title;
                                                        
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign', ['data' => $data]), 'text/html'); // for HTML rich messages;   
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
                                ['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject ,  'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                echo 'try';
                                return redirect()->route('admin-task-list');
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.';
                               $status='Failure';
                               $id = EmailLog::insertGetId(
                                ['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $message , 'message_body' => '' , 'created_at' => date("y-m-d h:i:s")]);
                               $request->session()->flash('add_message', $message);
                               return redirect()->route('admin-editIncident',$request->incidentid);
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                                  
                        }
                    }else{
                    $message='Task saved successfully';
                    $status='Success';
                    $request->session()->flash('add_message', $message);
                    return redirect()->route('admin-editIncident',$request->incidentid);
                    }
                }else{                       
                    $message='Task saved successfully';
                    $status='Success';
                    $request->session()->flash('add_message', $message);
                    return redirect()->route('admin-editIncident',$request->incidentid);
               // echo json_encode(array('message'=>$message,'status'=>$status));
                }  /* $request->status if condiotion closed */


             
        
     }
    }


        public function addnewTaskCase( Request $request,$id = '') {
            $zones = Zone::orderBy('name')->pluck('name','name');
            $user_id = $request->session()->get('id');
            $request->session()->get('user_role_id');
            $account_id = $request->session()->get('account_id');
            $displaynone     =  'none';
            $groupIds = DB::table('user_to_group')->where('user_id',$user_id)->pluck('group_id','group_id');
            $listOfuserBelongToGroups = User::with(['userGroup'])->whereIn('status', [1, 2])->where('account_id', $account_id);
            if(Session::get('user_role_id')==4){
                    $listOfuserBelongToGroups->where('id',Session::get('id'));
            }
            $listOfuserBelongToGroups->whereHas('userGroup', function ($q) use ($groupIds) {$q->whereIn('group_id',$groupIds);});
            $userList = $listOfuserBelongToGroups->get();               
                
            $data = array(); 

            
            $data['caseList'] = array('account_id'=>$account_id);
            $data['caseId'] =  $id;
            $data['account_id'] =  $account_id;            
            $data['zones'] =  $zones;            
            return view('admin.add_new_task_case', ['data' => $data, 'request' => $request, 'userList' => $userList]);
    }

    /**
    * Function saveTaskCase 
    *
    * function to Save Task
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function saveTaskCase( Request $request) {


        //dd($request->all());
        $due_date_timeZone = $request->due_date;
        if((!empty($request->caseId)) && ($request->caseId !='')){
            $caseDetails = $this->CaseList_obj::find($request->caseId);
            $timezone = $caseDetails->caseGroup->group->timezone;
            $date = new DateTime($request->due_date);
            $date->setTimezone(new DateTimeZone($timezone));
            $due_date_timeZone = $date->format('Y-m-d H:i');

        }
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');         

            $id = DB::table('tasks')->insertGetId(
                    [
                        'account_id' => $account_id, 
                        'created_by' => $user_id,
                        'title' => $request->title, 
                        'case_id'=>$request->caseId,
                        'description' => $request->description,
                        'task_assigned' => $request->task_assigned, 
                        'due_date' => $request->due_date, 
                        'due_date_timeZone' => $due_date_timeZone, 
                        'zone' => $request->zone, 
                        'status' => $request->status
                    ]
                  ); 
                    $casetask = new CaseTask;
                    $casetask->task_id              =  $id;
                    $casetask->case_id              =  $request->caseId;
                    $casetask->save();

            if($request->status != "closed" ) {
                $taskDetailsArray = $this->CaseList_obj->getTaskDetails($id);
                    if(!empty($taskDetailsArray)){
                    $user = User::find($taskDetailsArray->task_assigned);
                    if(!empty($user)){
                            $to=$user->email;
                            //$to='manvendra_pratap@yahoo.com';
                            $subject = 'TADapp Task Reminder for '.$taskDetailsArray->case_title.' : '.$taskDetailsArray->title;
                                                        
                            $data['taskDetailsArray']  = $taskDetailsArray;
                            $data['user']  = $user;
                            try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
                                
                                $messade_body = view('emails.task_assign', ['data' => $data]) ;
                                $id = EmailLog::insertGetId(
                                ['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $subject ,  'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);
                                $message='Task saved and email send to assigned user - '.$to;
                                $status='Success';
                                $request->session()->flash('add_message', $message);
                                echo 'try';
                                return redirect()->route('admin-task-list');
                                echo json_encode(array('message'=>$message,'status'=>$status));
                           } catch (Exception $ex) {
                               // Debug via $ex->getMessage();
                               $message='Mail Not Send.';
                               $status='Failure';
                               $id = EmailLog::insertGetId(
                                ['task_id'=>$taskDetailsArray->id, 'send_to'=> $to, 'comment'=> $message , 'message_body' => '' , 'created_at' => date("y-m-d h:i:s")]);
                               $request->session()->flash('add_message', $message);
                               return redirect()->route('admin-editCase',$request->caseId);
                               echo json_encode(array('message'=>$message,'status'=>$status));
                           }
                                  
                        }
                    }else{
                    $message='Task saved successfully';
                    $status='Success';
                    $request->session()->flash('add_message', $message);
                    return redirect()->route('admin-viewCase',$request->caseId);
                    }
                }else{                       
                    $message='Task saved successfully';
                    $status='Success';
                    $request->session()->flash('add_message', $message);
                    return redirect()->route('admin-viewCase',$request->caseId);
               // echo json_encode(array('message'=>$message,'status'=>$status));
                }  /* $request->status if condiotion closed */


             
        
     }
    

}