<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;


class AccountList extends Model
{
   use \Illuminate\Database\Eloquent\SoftDeletes;
   protected $table = 'account';

    public function users()
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
    }
    public function membershiptype()
    {
        return $this->hasOne('App\MembershipType','id','membership_type_id')->select('*');
    }
    public function accountToStorageSpaceUsed()
    {
        return $this->hasOne('App\AccountToStorageSpaceUsed','account_id','id')->select('*');
    }
}
