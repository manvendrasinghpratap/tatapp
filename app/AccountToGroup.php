<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountToGroup extends Model
{
    protected $table = 'account_to_group';

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function account()
    {
        return $this->belongsTo(AccountList::class, 'account_id');
    }
}
