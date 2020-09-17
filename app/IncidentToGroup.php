<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidentToGroup extends Model
{
    protected $table = 'incident_to_group';
    //
    public function group()
    {
        return $this->belongsTo('App\Group', 'group_id');
    }
}
