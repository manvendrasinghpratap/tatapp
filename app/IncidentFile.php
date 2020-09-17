<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class IncidentFile extends Model
{
    protected $table = 'incident_files';
    
    public function incident()
    {
        return $this->belongsTo(Incident::class, 'incident_id');
    }


}
