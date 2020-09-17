<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class ReportIncident extends Model
{
    
    protected $table = 'incident_linkto_report';

    function incident(){
    	return $this->belongsTo('App\Incident','incident_id');
    }
   



}
