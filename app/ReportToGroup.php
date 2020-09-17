<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportToGroup extends Model
{
    protected $table = 'report_to_group';
    public function group()
    {
        return $this->belongsTo('App\Group', 'group_id');
    }
}
