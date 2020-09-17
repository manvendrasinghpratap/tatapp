<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class ForumThreads extends Model
{
    
    protected $table = 'forum_threads';

   

     public static function isTopicDataAlreadyExist($arrProp)
        {

        $case_id = $arrProp['case_id'];
        $name = $arrProp['name'];
  

        $forumList = DB::table('forum_threads')
                ->where('case_id', $case_id)
                ->where('name', $name)
                ->orderByRaw('id DESC')
                ->get()
                ->count();

               if($forumList>0){
                    return 1;
                }
                else{
                    return 0;
                }

          }     

    





   function getTopicDetails($forum_id)
     {
   
        $query = "SELECT * FROM forum_threads where id=$forum_id";

               
                $getForumDetails = DB::select($query);


                $returnArray = array();

                foreach ($getForumDetails as $key => $row) {

                $returnArray = $row; 
                }

                return $returnArray;
    }



}
