<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class TempSubject extends Model
{
    
    protected $table = 'temp_subject';

   

     public static function isSubjectDataAlreadyExist($arrProp)
        {

        $case_id = $arrProp['case_id'];
        $name = $arrProp['name'];
  

        $factorList = DB::table('subject')
                ->where('case_id', $case_id)
                ->where('name', $name)
                ->orderByRaw('id DESC')
                ->get()
                ->count();

               if($factorList>0){
                    return 1;
                }
                else{
                    return 0;
                }

          }     

    





   function getSubjectDetails($subject_id)
     {
   
        $query = "SELECT * FROM subject where id=$subject_id";

               
                $getFactorDetails = DB::select($query);


                $returnArray = array();

                foreach ($getFactorDetails as $key => $row) {

                $returnArray = $row; 
                }

                return $returnArray;
    }

    function case(){
        return $this->belongsTo('App\CaseList','case_id','id');
    }

}
