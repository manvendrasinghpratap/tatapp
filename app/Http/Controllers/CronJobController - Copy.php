<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use DateTimeZone;
use DateTime;
class CronJobController extends Controller
{
    public function __construct() {

        //$this->CaseList_obj = new CaseList();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       /* echo Carbon::tomorrow();

        $tasks = $taskDetails = Tasks::where('due_date',Carbon::tomorrow())->where('email_sent',1)->get();


        //$due_date_timeZone = $taskDetails->due_date_timeZone;

            if( (empty($taskDetails->case_id)) && ($taskDetails->case_id == '') && (empty($taskDetails->incident_id)) && ($taskDetails->incident_id == '') )
           {
                if($taskDetails->casetasklist->count()>0){
                    $case_id = $taskDetails->casetasklist[0]->case_id;
                    $caseDetails = CaseList::find($case_id);
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
           
            echo $timezone; die();*/



        $tasks = Tasks::where('due_date',Carbon::tomorrow())->where('email_sent',1)->get();
        $timezone = 'America/New_York';
        if($tasks->count()>0){
            foreach ($tasks as $key => $value) {
                $taskId = $taskdatas = $value->id;
                $taskDetailsArray = $value;    

                $taskDetails = $value;
                if( ((empty($taskDetails->case_id)) && ($taskDetails->case_id == '')) || ((empty($taskDetails->incident_id)) && ($taskDetails->incident_id == '')) )
                {
                    if($taskDetails->casetasklist->count()>0){
                        $case_id = $taskDetails->casetasklist[0]->case_id;
                        $caseDetails = CaseList::find($case_id);
                        $timezone = $caseDetails->caseGroup->group->timezone;
                    }
                    if($taskDetails->TaskIncident->count()>0){
                        $incident_id = $taskDetails->incidenttasks[0]->incident_id;
                        $incidentDetails = Incident::find($incident_id);
                        $timezone = $incidentDetails->incidentGroup->group->timezone;
                    }
                }
                //dd($timezone);
                $morning6am = strtotime('6 am');
                $date = new DateTime("now", new DateTimeZone($timezone) );
                $duetime6am =  strtotime($date->format('H:i:s'));
                //echo $date->format('H:i:s');
                if($duetime6am >= $morning6am)
                {
                    if(!empty($value->case_id)){
                        $task_assigned = $value->task_assigned;
                        $user = User::find($task_assigned);
                        if(!empty($user)){
                            $to=$user->email;
                            $subject = 'TADapp Task Reminder for '.$value->case->title.' : '.$value->value;
                            $data['taskDetailsArray'] = $taskDetailsArray;
                            $data['user']  = $user; 
                            try {
                                Mail::send([], [], function ($message) use($to, $data, $subject){
                                        $message->to($to)->subject($subject)->setBody(view('emails.task_assign_case', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                        $message->from('manvendrasinghpratap@icloud.com', $name = 'No Reply');
                                        $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                    });
                                    $message_body = view('emails.task_assign_case', ['data' => $data]);
                                    $id = EmailLog::insertGetId(
                                [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                            } catch (Exception $ex) {
                               $message='Mail Not Send.'.$ex->getMessage();
                               $status='Failure';                      
                            }
                        }                    

                    } /// End of case mail

                    if(!empty($value->incident_id)){
                        if(!empty($taskDetailsArray->incidenttasks) && (count($taskDetailsArray->incidenttasks)>0) )
                        {
                            $task_assigned = $value->task_assigned;
                            $user = User::find($task_assigned);
                            if(!empty($user)){
                                $to=$user->email;
                                $subject = 'TADapp Task Reminder for '. $taskDetailsArray->incidenttasks[0]->incident->title.' : '.$taskDetailsArray->title;
                                $data['taskDetailsArray'] = $taskDetailsArray;
                                $data['user']  = $user; 
                                try {
                                    Mail::send([], [], function ($message) use($to, $data, $subject){
                                            $message->to($to)->subject($subject)->setBody(view('emails.task_assign_incident', ['data' => $data]), 'text/html'); // for HTML rich messages; 
                                            $message->from('tasks_noreply@tadapp.net', $name = 'No Reply');
                                            $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                        });
                                        $message_body = view('emails.task_assign_case', ['data' => $data]);
                                        $id = EmailLog::insertGetId(
                                    [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                                } catch (Exception $ex) {
                                   $message='Mail Not Send.'.$ex->getMessage();
                                   $status='Failure';                      
                                }
                            }
                        }

                    } /// End of incident id mail
                    $user = Tasks::find($value->id);
                    $user->email_sent = 3;
                    $user->save();  
               }
            }  // end of foreeach
        }  // End of if

        $tasks = Tasks::where('due_date',Carbon::today())->where('email_sent',2)->get();
        $timezone = 'America/New_York';
        if($tasks->count()>0){
            foreach ($tasks as $key => $value) {
                $taskId = $taskdatas = $value->id;
                $taskDetailsArray = $value;    

                $taskDetails = $value;
                if( ((empty($taskDetails->case_id)) && ($taskDetails->case_id == '')) || ((empty($taskDetails->incident_id)) && ($taskDetails->incident_id == '')) )
                {
                    if($taskDetails->casetasklist->count()>0){
                        $case_id = $taskDetails->casetasklist[0]->case_id;
                        $caseDetails = CaseList::find($case_id);
                        $timezone = $caseDetails->caseGroup->group->timezone;
                    }
                    if($taskDetails->TaskIncident->count()>0){
                        $incident_id = $taskDetails->incidenttasks[0]->incident_id;
                        $incidentDetails = Incident::find($incident_id);
                        $timezone = $incidentDetails->incidentGroup->group->timezone;
                    }
                }
                //dd($timezone);
                $morning6am = strtotime('1:40 am');
                $date = new DateTime("now", new DateTimeZone($timezone) );
                $duetime6am =  strtotime($date->format('H:i:s'));
                //echo $date->format('H:i:s');
                if($duetime6am >= $morning6am)
                {
                    if(!empty($value->case_id)){
                        $task_assigned = $value->task_assigned;
                        $user = User::find($task_assigned);
                        if(!empty($user)){
                            $to=$user->email;
                            $subject = 'TADapp Task Reminder for '.$value->case->title.' : '.$value->value;
                            $data['taskDetailsArray'] = $taskDetailsArray;
                            $data['user']  = $user; 
                            try {
                                Mail::send([], [], function ($message) use($to, $data, $subject){
                                        $message->to($to)->subject($subject)->setBody(view('emails.task_assign_case', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                        $message->from('manvendrasinghpratap@icloud.com', $name = 'No Reply');
                                        $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                    });
                                    $message_body = view('emails.task_assign_case', ['data' => $data]);
                                    $id = EmailLog::insertGetId(
                                [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                            } catch (Exception $ex) {
                               $message='Mail Not Send.'.$ex->getMessage();
                               $status='Failure';                      
                            }
                        }                    

                    } /// End of case mail

                    if(!empty($value->incident_id)){
                        if(!empty($taskDetailsArray->incidenttasks) && (count($taskDetailsArray->incidenttasks)>0) )
                        {
                            $task_assigned = $value->task_assigned;
                            $user = User::find($task_assigned);
                            if(!empty($user)){
                                $to=$user->email;
                                $subject = 'TADapp Task Reminder for '. $taskDetailsArray->incidenttasks[0]->incident->title.' : '.$taskDetailsArray->title;
                                $data['taskDetailsArray'] = $taskDetailsArray;
                                $data['user']  = $user; 
                                try {
                                    Mail::send([], [], function ($message) use($to, $data, $subject){
                                            $message->to($to)->subject($subject)->setBody(view('emails.task_assign_incident', ['data' => $data]), 'text/html'); // for HTML rich messages; 
                                            $message->from('tasks_noreply@tadapp.net', $name = 'No Reply');
                                            $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                        });
                                        $message_body = view('emails.task_assign_case', ['data' => $data]);
                                        $id = EmailLog::insertGetId(
                                    [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                                } catch (Exception $ex) {
                                   $message='Mail Not Send.'.$ex->getMessage();
                                   $status='Failure';                      
                                }
                            }
                        }

                    } /// End of incident id mail
                    $user = Tasks::find($value->id);
                    $user->email_sent = 3;
                    $user->save();  
               }
            }  // end of foreeach
        }  // End of if 

    } // End of function


 public function index1()
    {
        $tasks = $taskDetails = Tasks::where('due_date',Carbon::today())->where('email_sent',1)->get();


        $due_date_timeZone = $taskDetails->due_date_timeZone;

           if( (!empty($taskDetails->incident_id)) && ($taskDetails->incident_id != '') ){
                $incident_id = $taskDetails->incident_id;
                $incidentDetails = Incident::find($incident_id);
                $timezone = $incidentDetails->incidentGroup->group->timezone;
                //$date = new DateTime($request->due_date);
               // $date->setTimezone(new DateTimeZone($timezone));
                //$due_date_timeZone = $date->format('Y-m-d H:i');

            }
            if( (!empty($taskDetails->case_id)) && ($taskDetails->case_id != '') ){
                $caseDetails = $this->CaseList_obj::find($taskDetails->case_id);
                $timezone = $caseDetails->caseGroup->group->timezone;
               // $date = new DateTime($request->due_date);
               // $date->setTimezone(new DateTimeZone($timezone));
               // $due_date_timeZone = $date->format('Y-m-d H:i');

            }
            //dd($taskDetails);
            //echo $timezone; die();

        if($tasks->count()>0){
            foreach ($tasks as $key => $value) {
                $taskId = $taskdatas = $value->id;
                $taskDetailsArray = $value;              
                if(!empty($value->case_id)){
                    $task_assigned = $value->task_assigned;
                    $user = User::find($task_assigned);
                    if(!empty($user)){
                        $to=$user->email;
                        $subject = 'TADapp Task Reminder for '.$value->case->title.' : '.$value->value;
                        $data['taskDetailsArray'] = $taskDetailsArray;
                        $data['user']  = $user; 
                        try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign_case', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = 'No Reply');
                                    $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                });
                                $message_body = view('emails.task_assign_case', ['data' => $data]);
                                $id = EmailLog::insertGetId(
                            [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                        } catch (Exception $ex) {
                           $message='Mail Not Send.'.$ex->getMessage();
                           $status='Failure';                      
                        }
                    }                    

                } /// End of case mail

                if(!empty($value->incident_id)){
                    if(!empty($taskDetailsArray->incidenttasks) && (count($taskDetailsArray->incidenttasks)>0) )
                    {
                        $task_assigned = $value->task_assigned;
                        $user = User::find($task_assigned);
                        if(!empty($user)){
                            $to=$user->email;
                            $subject = 'TADapp Task Reminder for '. $taskDetailsArray->incidenttasks[0]->incident->title.' : '.$taskDetailsArray->title;
                            $data['taskDetailsArray'] = $taskDetailsArray;
                            $data['user']  = $user; 
                            try {
                                Mail::send([], [], function ($message) use($to, $data, $subject){
                                        $message->to($to)->subject($subject)->setBody(view('emails.task_assign_incident', ['data' => $data]), 'text/html'); // for HTML rich messages; 
                                        $message->from('tasks_noreply@tadapp.net', $name = 'No Reply');
                                        $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                    });
                                    $message_body = view('emails.task_assign_case', ['data' => $data]);
                                    $id = EmailLog::insertGetId(
                                [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                            } catch (Exception $ex) {
                               $message='Mail Not Send.'.$ex->getMessage();
                               $status='Failure';                      
                            }
                        }
                    }

                } /// End of incident id mail
                $user = Tasks::find($value->id);
                $user->email_sent = 2;
                $user->save();  
            }
        }

        $tasks = Tasks::where('due_date',Carbon::today())->where('email_sent',2)->get();
        if($tasks->count()>0){
            foreach ($tasks as $key => $value) {
                $taskId = $taskdatas = $value->id;
                $taskDetailsArray = $value;              
                if(!empty($value->case_id)){
                    $task_assigned = $value->task_assigned;
                    $user = User::find($task_assigned);
                    if(!empty($user)){
                        $to=$user->email;
                        $subject = 'TADapp Task Reminder for '.$value->case->title.' : '.$value->value;
                        $data['taskDetailsArray'] = $taskDetailsArray;
                        $data['user']  = $user; 
                        try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign_case', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = 'No Reply');
                                    $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                });
                                $message_body = view('emails.task_assign_case', ['data' => $data]);
                                $id = EmailLog::insertGetId(
                            [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                        } catch (Exception $ex) {
                           $message='Mail Not Send.'.$ex->getMessage();
                           $status='Failure';                      
                        }
                    }                    

                } /// End of case mail

                if(!empty($value->incident_id)){
                    if(!empty($taskDetailsArray->incidenttasks) && (count($taskDetailsArray->incidenttasks)>0) )
                    {
                        $task_assigned = $value->task_assigned;
                        $user = User::find($task_assigned);
                        if(!empty($user)){
                            $to=$user->email;
                            $subject = 'TADapp Task Reminder for '. $taskDetailsArray->incidenttasks[0]->incident->title.' : '.$taskDetailsArray->title;
                            $data['taskDetailsArray'] = $taskDetailsArray;
                            $data['user']  = $user; 
                            try {
                                Mail::send([], [], function ($message) use($to, $data, $subject){
                                        $message->to($to)->subject($subject)->setBody(view('emails.task_assign_incident', ['data' => $data]), 'text/html'); // for HTML rich messages; 
                                        $message->from('tasks_noreply@tadapp.net', $name = 'No Reply');
                                        $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                    });
                                    $message_body = view('emails.task_assign_case', ['data' => $data]);
                                    $id = EmailLog::insertGetId(
                                [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                            } catch (Exception $ex) {
                               $message='Mail Not Send.'.$ex->getMessage();
                               $status='Failure';                      
                            }
                        }
                    }

                } /// End of incident id mail
                $user = Tasks::find($value->id);
                $user->email_sent = 2;
                $user->save();  
            }
        }

    }



    public function indexbk()
    {

       // where('created_at', '<=', Carbon::now()->subDays(14)->toDateTimeString());
       // $tasks = Tasks::where('due_date',Carbon::tomorrow())->get();
        $tasks = Tasks::where('due_date',Carbon::tomorrow())->where('email_sent',1)->get();
        if($tasks->count()>0){
            foreach ($tasks as $key => $value) {
                $taskId = $taskdatas = $value->id;
                $taskDetailsArray = $value;              
                if(!empty($value->case_id)){
                    $task_assigned = $value->task_assigned;
                    $user = User::find($task_assigned);
                    if(!empty($user)){
                        $to=$user->email;
                        $subject = 'TADapp Task Reminder for '.$value->case->title.' : '.$value->value;
                        $data['taskDetailsArray'] = $taskDetailsArray;
                        $data['user']  = $user; 
                        try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign_case', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = 'No Reply');
                                    $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                });
                                $message_body = view('emails.task_assign_case', ['data' => $data]);
                                $id = EmailLog::insertGetId(
                            [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                        } catch (Exception $ex) {
                           $message='Mail Not Send.'.$ex->getMessage();
                           $status='Failure';                      
                        }
                    }                    

                } /// End of case mail

                if(!empty($value->incident_id)){
                    if(!empty($taskDetailsArray->incidenttasks) && (count($taskDetailsArray->incidenttasks)>0) )
                    {
                        $task_assigned = $value->task_assigned;
                        $user = User::find($task_assigned);
                        if(!empty($user)){
                            $to=$user->email;
                            $subject = 'TADapp Task Reminder for '. $taskDetailsArray->incidenttasks[0]->incident->title.' : '.$taskDetailsArray->title;
                            $data['taskDetailsArray'] = $taskDetailsArray;
                            $data['user']  = $user; 
                            try {
                                Mail::send([], [], function ($message) use($to, $data, $subject){
                                        $message->to($to)->subject($subject)->setBody(view('emails.task_assign_incident', ['data' => $data]), 'text/html'); // for HTML rich messages; 
                                        $message->from('tasks_noreply@tadapp.net', $name = 'No Reply');
                                        $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                    });
                                    $message_body = view('emails.task_assign_case', ['data' => $data]);
                                    $id = EmailLog::insertGetId(
                                [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                            } catch (Exception $ex) {
                               $message='Mail Not Send.'.$ex->getMessage();
                               $status='Failure';                      
                            }
                        }
                    }

                } /// End of incident id mail
                $user = Tasks::find($value->id);
                $user->email_sent = 2;
                $user->save();  
            }
        }
       // $utcTimezone = new DateTimeZone( 'UTC' );
        //echo Carbon::today(); die();
        $tasks = Tasks::where('due_date',Carbon::today())->where('email_sent',2)->get();
       // $utcTimezone = new DateTimeZone( 'UTC' );
        if($tasks->count()>0){
            foreach ($tasks as $key => $value) {
                $taskId = $taskdatas = $value->id;
                $taskDetailsArray = $value;              
                if(!empty($value->case_id)){
                    $task_assigned = $value->task_assigned;
                    $user = User::find($task_assigned);
                    if(!empty($user)){
                        $to=$user->email;
                        $subject = 'TADapp Task Reminder for '.$value->case->title.' : '.$value->value;
                        $data['taskDetailsArray'] = $taskDetailsArray;
                        $data['user']  = $user; 
                        try {
                            Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.task_assign_case', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = 'No Reply');
                                    $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                });
                                $message_body = view('emails.task_assign_case', ['data' => $data]);
                                $id = EmailLog::insertGetId(
                            [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                        } catch (Exception $ex) {
                           $message='Mail Not Send.'.$ex->getMessage();
                           $status='Failure';                      
                        }
                    }                    

                } /// End of case mail

                if(!empty($value->incident_id)){
                    if(!empty($taskDetailsArray->incidenttasks) && (count($taskDetailsArray->incidenttasks)>0) )
                    {
                        $task_assigned = $value->task_assigned;
                        $user = User::find($task_assigned);
                        if(!empty($user)){
                            $to=$user->email;
                            $subject = 'TADapp Task Reminder for '. $taskDetailsArray->incidenttasks[0]->incident->title.' : '.$taskDetailsArray->title;
                            $data['taskDetailsArray'] = $taskDetailsArray;
                            $data['user']  = $user; 
                            try {
                                Mail::send([], [], function ($message) use($to, $data, $subject){
                                        $message->to($to)->subject($subject)->setBody(view('emails.task_assign_incident', ['data' => $data]), 'text/html'); // for HTML rich messages; 
                                        $message->from('manvendrasinghpratap@icloud.com', $name = 'No Reply');
                                        $message->cc("manvendra_pratap@yahoo.com", $name = 'Manvendra Pratap Singh');
                                    });
                                    $message_body = view('emails.task_assign_case', ['data' => $data]);
                                    $id = EmailLog::insertGetId(
                                [ 'task_id'=>$taskdatas,'send_to'=> $to, 'comment'=> $subject , 'message_body' => $message_body, 'created_at' => date("y-m-d h:i:s")]);                        
                            } catch (Exception $ex) {
                               $message='Mail Not Send.'.$ex->getMessage();
                               $status='Failure';                      
                            }
                        }
                    }

                } /// End of incident id mail
                $user = Tasks::find($value->id);
                $user->email_sent = 2;
                $user->save();  

                /*$timeZone =  $value->zone;
                $laTimezone = new DateTimeZone( $timeZone );
                $time = new DateTime( $value->due_date , $utcTimezone );
                $time->setTimeZone( $laTimezone );
                echo $time->format( 'Y-m-d H:i:s' ); echo '<br>';*/
            }
        }



       // echo $tasks->count();
        //dd($tasks);
/*        $to = 'm8005029425@gmail.com';
        $subject = 'Test';
        $tasksArray = $tasks->toArray();
        $name = 'Test@test.com';
        $data = array();
        Mail::send([], [], function ($message) use($to, $data, $subject){
                                    $message->to($to)->subject($subject)->setBody(view('emails.test', ['data' => $data]), 'text/html'); // for HTML rich messages;
                                    $message->from('tasks_noreply@tadapp.net', $name = null);
                                    $message->cc("manvendra_pratap@yahoo.com", $name = null);
                                });
        //echo '<pre>'; print_r($tasksArray); echo '</pre>';*/
        /*date_default_timezone_set('Asia/Kolkata');
        echo date('Y-m-d H:i:s T', time()) . "<br>\n";
        date_default_timezone_set('UTC');
        echo date('Y-m-d H:i:s T', time()) . "<br>\n";*/
        //
    }

   
    public function test(){
            echo Carbon::tomorrow(); echo '<br>';
        echo Carbon::today(); echo '<br>';
         $tasks = $taskDetails = Tasks::where('due_date',Carbon::tomorrow())->where('email_sent',2)->get();
        echo '<pre>'; print_r($tasks); echo '</pre>';
        echo $morning6am = strtotime('2:15 am'); echo '<br>';
        $date = new DateTime("now", new DateTimeZone('America/New_York') );
        echo $duetime6am =  strtotime($date->format('H:i:s')); echo '<br>';
        echo $date->format('Y-m-d H:i:s');
        if($duetime6am >= $morning6am){
        echo 'mail Sent';

        }
    }
}
