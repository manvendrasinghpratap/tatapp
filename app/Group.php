<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $table = 'groups';
    
    public function userGroup()
    {
        return $this->hasMany('App\UserGroup','group_id','id')->select('*');
    }
    public function accountGroup()
    {
        return $this->hasOne('App\AccountToGroup','group_id','id')->select('*');
    }
    public function groupCase()
    {
        return $this->hasMany(CaseToGroup::class,'group_id');
    }
    public function incidentGroup()
    {
        return $this->hasMany(IncidentToGroup::class,'group_id');
    }
}
