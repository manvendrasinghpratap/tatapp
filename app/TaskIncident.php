<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class TaskIncident extends Model
{
    protected $table = 'incident_task';
    
    
    public function incident()
    {
        return $this->belongsTo(Incident::class, 'incident_id');
    }
     public function task()
    {
        return $this->belongsTo(Tasks::class, 'task_id');
    }


}
