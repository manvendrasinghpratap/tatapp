<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountToStorageSpaceUsed extends Model
{
    protected $table = 'account_to_storage_space_used';

   /* public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function account()
    {
        return $this->belongsTo(AccountList::class, 'account_id');
    }*/
}
