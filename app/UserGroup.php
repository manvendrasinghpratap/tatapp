<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'user_to_group';
    
    public function users()
    {    
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function group()
    {
        return $this->belongsTo(Group::class,'group_id');
    }
     public function groupCases()
    {                                                                     
        return $this->hasMany(CaseToGroup::class,'group_id');
    }
}
