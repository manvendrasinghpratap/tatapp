<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;


class UploadFiles extends Model
{
   use \Illuminate\Database\Eloquent\SoftDeletes;
   protected $table = 'upload_files';

	public function incidentfiles(){
       return $this->hasMany(IncidentFile::class, 'file_id');
    }

    public function casesfiles(){
       return $this->hasMany(file::class, 'file_id');
    }

}
