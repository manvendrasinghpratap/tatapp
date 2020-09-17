<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class Tasks extends Model
{
    
    protected $table = 'tasks';

   

     public static function isTaskAlreadyExist($arrProp)
     {
        $case_id = $arrProp['case_id'];
        $title = $arrProp['title'];
        $factorList = DB::table('tasks')
                ->where('case_id', $case_id)
                ->where('title', $title)
                ->orderByRaw('id DESC')
                ->get()
                ->count();

               if($factorList>0){
                    return 1;
                }
                else{
                    return 0;
                }
          }     

   function getTasksDetails($subject_id)
     {
   
        $query = "SELECT * FROM tasks where id=$subject_id";

               
                $getFactorDetails = DB::select($query);


                $returnArray = array();

                foreach ($getFactorDetails as $key => $row) {

                $returnArray = $row; 
                }

                return $returnArray;
    }

    public function case(){
        return $this->belongsTo('App\CaseList','case_id');
    }

    public function incidenttasks(){
           return $this->hasMany(IncidentTask::class, 'task_id');
        }
     public function taskIncident(){
           return $this->hasMany(TaskIncident::class, 'task_id');
        }    
    public function user(){
        return $this->belongsTo('App\User','task_assigned');
    }
    public function incident(){
           return $this->belongsTo(Incident::class, 'incident_id');
        }

    public function casetasklist(){
           return $this->hasMany(CaseTask::class, 'task_id');
        }
      public function userGroup()
    {
        return $this->hasMany('App\UserGroup','user_id','id')->select('*');
    }   
        
}
