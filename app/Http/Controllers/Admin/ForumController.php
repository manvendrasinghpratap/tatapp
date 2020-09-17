<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use Auth;
use App\Site;
use App\Http\Middleware\ResizeImageComp;
use Validator;
use Mail;
use Illuminate\Support\Facades\Hash;
Use Config;
use App\Forum;
use App\ForumThreads;
use App\ForumPost;
use App\CaseList;
use App\AccountList;
use App\Accounttask;
use App\FactorList;
use App\User;
use Session;
use Carbon\Carbon;
use DB;
class ForumController extends AdminController
{
    public $data = array();
    /**
    * Function __construct
    *
    * constructor
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function __construct() {
        //dd($this->record_per_page);
        parent::__construct();
        $this->middleware('check_admin_status');
        $this->middleware('revalidate');
        $this->Forum_obj = new Forum();
        $this->ForumThreads_obj = new ForumThreads();
        $this->ForumPost_obj = new ForumPost();
        
        
        $this->record_per_page=20;
    }
   
    

     /**
    * Function forumList 
    *
    * function to get forum List
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function forumList(Request $request, $id = '') {
       
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        
        $pageNo = trim($request->input('page', 1));
        //search fields
        $keyword = strtolower(trim($request->input('keyword'))); 
        
        DB::enableQueryLog();

        $user_role_name = $request->session()->get('user_role_name');
        if($id>0){
        $forum = Forum::Join('users', 'forum.created_by', '=', 'users.id')
        ->select('forum.*','forum.id as forumId', 'users.first_name', 'users.last_name')
        ->where('forum.case_id', $id);  
        }
        else{
            $forum = Forum::Join('users', 'forum.created_by', '=', 'users.id')
        ->select('forum.*','forum.id as forumId', 'users.first_name', 'users.last_name');  
        }
          
        
    
           
        if($keyword)
        {
             $forum->Where(function ($query) use ($keyword) {
                    $query->orwhere('forum.title', 'rlike', $keyword);
                });
        }
        $forum = $forum->orderby('forum.created_at','desc');
      
        
       
        $this->data['case_id'] = $id;
        $this->data['records'] = $forum->paginate($this->record_per_page);
       $queries = DB::getQueryLog();
        //dd($queries);
        return view('admin.forumList', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request]);


        
    }

     /**
    * Function forumList 
    *
    * function to get forum List
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function manageForum(Request $request, $id = '') {
       
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        
        $pageNo = trim($request->input('page', 1));
        //search fields
        $keyword = strtolower(trim($request->input('keyword'))); 
        
        DB::enableQueryLog();

        $user_role_name = $request->session()->get('user_role_name');
       
        
        
        $forum = Forum::Join('users', 'forum.created_by', '=', 'users.id')
        ->select('forum.*','forum.id as forumId', 'users.first_name', 'users.last_name');  
        //$this->backProcessForum($account_id, $admin_id);
          
         if(isset($account_id) && $account_id!="")
                {
                    $forum->where('forum.account_id',$account_id);
                }

    
           
        if($keyword)
        {
             $forum->Where(function ($query) use ($keyword) {
                    $query->orwhere('forum.title', 'rlike', $keyword);
                });
        }
        $forum = $forum->orderby('forum.created_at','desc');
      
        
       
        $this->data['case_id'] = $id;
        $this->data['records'] = $forum->paginate($this->record_per_page);
       $queries = DB::getQueryLog();
        //dd($queries);
        return view('admin.manageForum', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request]);


        
    }


    function backProcessForum($account_id, $user_id){

        $AllcaseList = CaseList::get();
        
        foreach ($AllcaseList as $key => $value) {
               $case_id = $value->id;
            
            # code...
        
        $totalForum = Forum::Join('users', 'forum.created_by', '=', 'users.id')
        ->select('forum.*','forum.id as forumId', 'users.first_name', 'users.last_name')
        ->where('forum.case_id', $case_id)->count();

       if($totalForum==0){
        $caseList = CaseList::find($case_id);
        
         
          
        #### If forum is not created against any job then a forum topic will be created #####
                        $this->Forum_obj = new Forum();
                        $this->Forum_obj->account_id  = $caseList->account_id;
                        $this->Forum_obj->created_by  = $caseList->user_id;
                        $this->Forum_obj->case_id     = $caseList->id;
                        $this->Forum_obj->title       = $caseList->title;
                        $this->Forum_obj->description = $caseList->description;
                        $this->Forum_obj->save();
                        }
        }

    }

    



    /**
    * Function topicList 
    *
    * function to get topic List
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function topicList(Request $request, $id = '') {
       
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        
        $pageNo = trim($request->input('page', 1));
        //search fields
        $keyword = strtolower(trim($request->input('keyword'))); 
        
        DB::enableQueryLog();

        $user_role_name = $request->session()->get('user_role_name');
        $forumDetails   = Forum::where('id', $id)->get();
     

        
        //get user data
        $forum = ForumThreads::Join('users', 'forum_threads.created_by', '=', 'users.id')
        ->select('forum_threads.*', 'users.first_name', 'users.last_name')
        ->where('forum_threads.forum_id', $id);
    
    
           
        if($keyword)
        {
             $forum->Where(function ($query) use ($keyword) {
                    $query->orwhere('forum_threads.subject', 'rlike', $keyword);
                });
        }
        $forum = $forum->orderby('forum_threads.created_at','desc');
      
        $queries = DB::getQueryLog();
       
        $this->data['forum_id']      = $id;
        $this->data['case_id']       = $forumDetails[0]->case_id;
        $this->data['forumDetails']  = $forumDetails[0];

       
        $this->data['records'] = $forum->paginate($this->record_per_page);
       
        return view('admin.topicList', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request]);

        
    }




  /**
    * Function ajaxSaveForum 
    *
    * function to Save Forum
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */


public function ajaxSaveForum( Request $request) {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
          
          
        if($request->forum_id > 0){

             //update case
                    $this->Forum_obj = $this->Forum_obj->find($request->forum_id);
                } 


                $this->Forum_obj->account_id  = $account_id;
                $this->Forum_obj->created_by  = $user_id;
                $this->Forum_obj->case_id     = $request->case_id;
                $this->Forum_obj->title        = $request->title;
                $this->Forum_obj->description = $request->description;
                

                $this->Forum_obj->save();

         //get user data
        $forum = Forum::Join('users', 'forum.created_by', '=', 'users.id')
        ->select('forum.*', 'users.first_name', 'users.last_name')
        ->where('forum.account_id', $account_id);
    
           
        
        $forum = $forum->orderby('forum.created_at','desc');
      
        $queries = DB::getQueryLog();
       
        $this->data['case_id'] = $request->case_id;
        $this->data['records'] = $forum->paginate($this->record_per_page);





        return view('admin.ajaxForumList', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request]);


   }


    



    /**
    * Function ajaxGetForumDetails 
    *
    * function to get Forum Details
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxGetForumDetails( Request $request) {
            $account_id = $request->session()->get('account_id');
            
            $forum_id = (isset($request->forum_id))?$request->forum_id:'0';
            if($forum_id>0){
            $forumDetailsArray = $this->Forum_obj->find($forum_id);

            $data = array();
            $data['forumDetailsArray'] =  $forumDetailsArray;

            $caseId = $forumDetailsArray->case_id;
          
            
            $data['caseList'] = CaseList::find($caseId);
            
            //dd($data);
            
            }
            else{
            $caseId = $request->case_id;
            $data = array();
            $data['subjectDetailsArray']   =  array();
            $data['caseList'] = CaseList::find($caseId);
           

            }

            return view('admin.ajax_create_forum', ['data' => $data, 'request' => $request]);
    }



   /**
    * Function ajaxDeleteForum 
    *
    * function to Delete Forum
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxDeleteForum( Request $request) {
           
            
            $forum_id = (isset($request->forum_id))?$request->forum_id:'0';
            
            if($forum_id>0){

              DB::table('forum')
              ->where('id', '=', $forum_id)
              ->delete();
           
            }
    }   

   ################# START TOPIC #######################
    /**
    * Function ajaxSaveTopic 
    *
    * function to Save Topic
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */


public function ajaxSaveTopic( Request $request) {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
          
          
        if($request->topic_id > 0){

             //update case
                    $this->ForumThreads_obj = $this->ForumThreads_obj->find($request->topic_id);
                } 


               

                $this->ForumThreads_obj->forum_id  = $request->forum_id;
                $this->ForumThreads_obj->created_by  = $user_id;
                $this->ForumThreads_obj->subject     = $request->subject;
             
            

               
                if($this->ForumThreads_obj->save()) {

                    $thread_id = $this->ForumThreads_obj->id;
                    $this->ForumPost_obj->thread_id  = $thread_id;
                    $this->ForumPost_obj->parent  = 0;
                    $this->ForumPost_obj->children  = 0;
                    $this->ForumPost_obj->replySubject  = $request->subject;
                    $this->ForumPost_obj->message  = $request->message;
                    $this->ForumPost_obj->created_by  = $user_id;
                    $this->ForumPost_obj->save();


                }


        $forumDetails   = Forum::where('id', $request->forum_id)->get();
                //get user data
        
        //get user data
        $topicList = ForumThreads::Join('users', 'forum_threads.created_by', '=', 'users.id')
        ->select('forum_threads.*', 'users.first_name', 'users.last_name')
        ->where('forum_threads.forum_id', $request->forum_id);
    
    
           
       
        $topicList = $topicList->orderby('forum_threads.created_at','desc');
        $this->data['case_id'] = $request->case_id;
        $this->data['forumDetails'] = $forumDetails[0];


        $this->data['records'] = $topicList->paginate($this->record_per_page);
        return view('admin.ajaxTopicList', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request]);


   }


    



    /**
    * Function ajaxGetTopicDetails 
    *
    * function to get Topic Details
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxGetTopicDetails( Request $request) {
            $account_id = $request->session()->get('account_id');
            
            $topic_id = (isset($request->topic_id))?$request->topic_id:'0';
            if($topic_id>0){
            $forumDetailsArray = $this->ForumThreads_obj->find($topic_id);

            $data = array();
            $data['forumDetailsArray'] =  $forumDetailsArray;

            $caseId = $forumDetailsArray->case_id;
          
            
            $data['caseList'] = CaseList::find($caseId);
            
            //dd($data);
            
            }
            else{
            $caseId = $request->case_id;
            $forum_id = $request->forum_id;
            $data = array();
            $data['subjectDetailsArray']   =  array();
            $data['caseList'] = CaseList::find($caseId);
            $data['forum_id'] = $forum_id;
           

            }

            return view('admin.ajax_create_topic', ['data' => $data, 'request' => $request]);
    }

    /**
    * Function saveReply 
    *
    * function to get change module status
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function saveReply( Request $request) {
            //dd($request->all());
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
            
            ######################  ###########################
        
    if ($request->all()) { //post
         //dd($request->all());
           

                 if(isset($request->message) && $request->message!=""){
                  
                    $this->ForumPost_obj->thread_id  = $request->topic_id;
                    $this->ForumPost_obj->parent  = 0;
                    $this->ForumPost_obj->children  = 0;
                    $this->ForumPost_obj->replySubject  = $request->subject;
                    $this->ForumPost_obj->message  = $request->message;
                    $this->ForumPost_obj->created_by  = $user_id;
                    $this->ForumPost_obj->save();
                  }
               }   
        ######################  ############################
         
    }






    /**
    * Function viewTopic 
    *
    * function to view Topic
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function viewTopic( Request $request, $forum_threads_id = '') {
        //dd($request->all());
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
        
        $pageNo = trim($request->input('page', 1));
        //search fields
        $keyword = strtolower(trim($request->input('keyword'))); 


        
        
        DB::enableQueryLog();

        $user_role_name = $request->session()->get('user_role_name');

        $forumDetails   = Forum::Join('forum_threads', 'forum_threads.forum_id', '=', 'forum.id')
        ->select('forum_threads.*','forum.*')
        ->where('forum_threads.id', $forum_threads_id)->get();
           
          //dd($forumDetails);
        //get user data
        
        $forumPostArray = ForumPost::Join('users', 'forum_post.created_by', '=', 'users.id')
        ->Join('forum_threads', 'forum_threads.id', '=', 'forum_post.thread_id')
        ->select('forum_threads.*','forum_post.*', 'users.first_name', 'users.last_name')
        ->where('forum_post.thread_id', $forum_threads_id);
    
           
        if($keyword)
        {
             $forumPostArray->Where(function ($query) use ($keyword) {
                    $query->orwhere('forum_post.message', 'rlike', $keyword);
                    $query->orwhere('forum_post.replySubject', 'rlike', $keyword);
                });
        }
        $forumPostArray = $forumPostArray->orderby('forum_post.id','ASC');
      
        $queries = DB::getQueryLog();
       
        $this->data['topic_id']      = $forum_threads_id;
        $this->data['forum_id']      = $forumDetails[0]->forum_id;
        $this->data['case_id']       = $forumDetails[0]->case_id;
        $this->data['forumDetails']  = $forumDetails[0];

       
        $this->data['records'] = $forumPostArray->paginate($this->record_per_page);
       
        return view('admin.view_topic', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request]);

        
    }

   /**
    * Function ajaxDeleteTopic 
    *
    * function to Delete Topic
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxDeleteTopic( Request $request) {
           
            
            $forum_id = (isset($request->forum_id))?$request->topic_id:'0';
            
            if($forum_id>0){

              DB::table('forum_threads')
              ->where('id', '=', $forum_id)
              ->delete();
           
            }
    } 


    /**
    * Function ajaxDeletePost 
    *
    * function to Delete Post
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxDeletePost( Request $request) {
           
            
            $post_id = (isset($request->post_id))?$request->post_id:'0';
            
            if($post_id>0){

              DB::table('forum_post')
              ->where('id', '=', $post_id)
              ->delete();
           
            }
    }   
    
}