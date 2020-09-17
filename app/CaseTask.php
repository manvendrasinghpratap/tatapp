<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class CaseTask extends Model
{
    protected $table = 'case_tasks';
    
    
    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }
     public function task()
    {
        return $this->belongsTo(Tasks::class, 'task_id');
    }
    


}
