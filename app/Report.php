<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class Report extends Model
{
    
    protected $table = 'report';

     public function reportlists()
    {
        return $this->hasMany('App\ReportMedia','report_id','id')->select('*');
    }
    public function reportGroup()
    {
        return $this->hasOne('App\ReportToGroup','report_id','id')->select('*');
    }
}
