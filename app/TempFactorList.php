<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class TempFactorList extends Model
{
    
    protected $table = 'temp_factor_list';

    protected function sector(){
    	return $this->belongsTo('App\AccountSector','sector_id');
    }


}
