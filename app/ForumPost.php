<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class ForumPost extends Model
{
    
    protected $table = 'forum_post';

   

     public static function isPostDataAlreadyExist($arrProp)
        {

        $thread_id = $arrProp['thread_id'];
        $messgage = $arrProp['messgage'];
  

        $forumList = DB::table('forum_post')
                ->where('thread_id', $thread_id)
                ->where('messgage', $messgage)
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

    





   function getPostDetails($thread_id)
     {
   
        $query = "SELECT * FROM forum_post where id=$thread_id";

               
                $getForumDetails = DB::select($query);


                $returnArray = array();

                foreach ($getForumDetails as $key => $row) {

                $returnArray = $row; 
                }

                return $returnArray;
    }



}
