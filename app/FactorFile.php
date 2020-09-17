<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class FactorFile extends Model
{
    
    protected $table = 'factor_files';

   

     public static function isFileDataAlreadyExist($arrProp)
        {

        $case_id = $arrProp['case_id'];
        $title = $arrProp['title'];
  

        $factorList = DB::table('files')
                ->where('case_id', $case_id)
                ->where('title', $title)
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

    





   function getFileDetails($file_id)
     {
   
        $query = "SELECT * FROM factor_files where id=$file_id";

               
                $getFactorDetails = DB::select($query);


                $returnArray = array();

                foreach ($getFactorDetails as $key => $row) {

                $returnArray = $row; 
                }

                return $returnArray;
    }



}
