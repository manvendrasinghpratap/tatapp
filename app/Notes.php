<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class Notes extends Model
{
    protected $table = 'add_note';

    protected function user(){
    	return $this->belongsTo('App\User','id');
    }

}
