<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class FileCase extends Model
{
    
    protected $table = 'files';

   public function cases()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }

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
   
        $query = "SELECT * FROM files where id=$file_id";

               
                $getFactorDetails = DB::select($query);


                $returnArray = array();

                foreach ($getFactorDetails as $key => $row) {

                $returnArray = $row; 
                }

                return $returnArray;
    }



}
