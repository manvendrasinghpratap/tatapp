<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\WebhookController;
use App\User;
use App\Tasks;
use App\EmailLog;
use Mail;


class TaskReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taskreminderemail:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'taskreminderemail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tasks = Tasks::Join('users', 'users.id', '=', 'tasks.task_assigned')
        ->Join('case_list', 'case_list.id', '=', 'tasks.case_id')
        ->select('tasks.*', 'users.email', 'users.first_name', 'users.last_name', 'case_list.title as case_title', 'tasks.title as title')
        ->where('tasks.status', '!=', '')->where('tasks.status', '!=', 'closed')->where(function($q) {
          $q->where('tasks.due_date', '=',\DB::raw('DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 DAY),"%Y-%m-%d")'))
            ->orWhere('tasks.due_date', '=',\DB::raw('DATE_FORMAT(now(),"%Y-%m-%d")'));
      })->get();
            $data= array();
            
            foreach($tasks as $row){
                
                $user = User::find($row->task_assigned);
                $to=$user->email;
                
                $subject = ' TADapp Task Reminder for '.$row->case_title.' : '.$row->title;
                $data['taskDetailsArray']  = $row;
                $data['user']  = $user;
                $messade_body = view('emails.task_assign', ['data' => $data]);

                try {
                Mail::send([], [], function ($message) use($to, $data, $subject){
                        $message->to($to)->subject($subject)->setBody(view('emails.task_assign', ['data' => $data]), 'text/html'); // for HTML rich messages;
                        $message->from('tasks_noreply@tadapp.net', $name = null);
                        $message->cc("shwu1@yopmail.com", $name = null);
                    });

                 $id = EmailLog::insertGetId(
['task_id'=>$row->id, 'send_to'=> $to, 'comment'=> $subject , 'message_body' => $messade_body, 'created_at' => date("y-m-d h:i:s")]);

               } catch (Exception $ex) {
                   // Debug via $ex->getMessage();
                   $message='Mail Not Send.'.$ex->getMessage();
                   $status='Failure';
                   $id = EmailLog::insertGetId(
['task_id'=>$row->id, 'send_to'=> $to, 'comment'=> $message , 'message_body' => "Failure <br>".$message, 'created_at' => date("y-m-d h:i:s")]);
               }
            } 
    }


   
}
