<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;


class MembershipType extends Model
{
   use \Illuminate\Database\Eloquent\SoftDeletes;

   protected $table = 'membership_type';

    /*public function users()
    {
        return $this->hasMany('App\User','account_id','id')->select('*');
    }
    public function accountGroup()
    {
        return $this->hasOne('App\AccountToGroup','account_id','id')->select('*');
    }
    public function accountGroups()
    {
        return $this->hasMany('App\AccountToGroup','account_id','id')->select('*');
    }
    public function accountStorageSize()
    {
        return $this->hasOne('App\AccountToStorageSpace','account_id','id')->select('*');
    }*/
}
