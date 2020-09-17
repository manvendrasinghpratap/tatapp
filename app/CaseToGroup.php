<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class CaseToGroup extends Model
{
    protected $table = 'case_to_group';
    public function group()
    {
        //return $this->belongsTo('App\Group');
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function case()
    {        
        return $this->belongsTo(CaseList::class, 'case_id');
    }
    
    
}
