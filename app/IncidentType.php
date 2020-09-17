<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class IncidentType extends Model 
{
   
    protected $table = 'incident_type';
	

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
   

    /*public function module()
    {
        return $this->hasMany('App\PlanModules','plan_id','id')->select('*');
    }*/




}
