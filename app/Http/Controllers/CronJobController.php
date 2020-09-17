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
                $fff = 1;
                if($fff == 1)
                {
                    if(!empty($value->case_id)){
                        $task_assigned = $value->task_assigned;
                        $user = User::find($task_assigned);
                        if(!empty($user)){
                            $to=$user->email;
                            $to = 'm8005029425@gmail.com';
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
                                $to = 'm8005029425@gmail.com';
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
                            $to = 'm8005029425@gmail.com';
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
                                $to = 'm8005029425@gmail.com';
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

  
    public function test(){
            echo Carbon::tomorrow(); echo '<br>';
            echo Carbon::today(); echo '<br>';
            $tasks = $taskDetails = Tasks::where('due_date',Carbon::tomorrow())->where('email_sent',1)->get();

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
