<?php

use App\User;
use App\Forum;
use App\ForumThreads;
use App\ForumPost;
use App\Email_template;
use App\General_option;
use App\PaypalSetting;
use App\StripeSetting;
use App\AccountList;
use Carbon\Carbon;


//use Config;

/**
* Function redstar
*
* function to get red colored star
*
* @Created Date: 16 July, 2018
* @Modified Date: 16 July, 2018
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/
function redstar() {
    echo "<span class='red-star'> * </span>";
}



/**
* Function template_by_variable
*
* function to get email template from variable name
*
* @Created Date: 16 July, 2018
* @Modified Date: 16 July, 2018
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/
function template_by_variable($variable_name) {
    $data = Email_template::where('variable_name', '=', $variable_name)->first();
    return $data;
}

/**
* Function get_image_url
*
* function to form image url 
*
* @Created Date: 16 July, 2018
* @Modified Date: 16 July, 2018
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/
function get_image_url($image, $folder) {
    
    if (file_exists(public_path().'/uploads/'.$folder.'/'.$image)) {
        return IMAGE_URL().'uploads/' . $folder . '/' . $image;
    }
    else {
        $folder = 'img';
        $image = 'noimage.jpg';     
        return IMAGE_URL().'assets/' . $folder . '/' . $image;
    }
}

function get_image_url_server($image, $folder) {
	//return $_SERVER['DOCUMENT_ROOT'];
	//return public_path();
    if (file_exists(public_path().'/uploads/'.$folder.'/'.$image)) {
        return public_path().'/uploads/' . $folder . '/' . $image;
    }
    else {
        $folder = 'img';
        $image = 'noimage.jpg';     
        return public_path().'/assets/' . $folder . '/' . $image;
    }
}


function ImageUpload($Image, $folder,$oldname='') {

    $ext = $Image->getClientOriginalExtension();
    //$imageName = time() . '.' . $ext;
    $imageName = rand(10000, 990000) . '_' .time() . '.' . $ext;
    if($oldname && ($imageName==$oldname))
    {
        //generate a new image name
        $imageName = rand(10000, 990000) . '_' .time() . '.' . $ext;
    }
    if (!is_dir(public_path('uploads/' . $folder))) {
        mkdir(public_path('uploads/' . $folder), 0777, true);
    }
    $imgUpload = $Image->move(public_path('uploads/' . $folder . '/'), $imageName);

    return $imageName;
}




/**
* Function save_facebook_login_image
*
* Function used to save facebook login image
*
* @Created Date: 23 May, 2017
* @Modified Date: 23 May, 2017
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/

function IMAGE_URL() {
    $url = get_option('image_url');
    if ($url == '') {
        //give folder asset url
        $url = asset('/');
    }
    return $url;
}


/**
* Function get_option
*
* function to get general options value
*
* @Created Date: 16 July, 2018
* @Modified Date: 16 July, 2018
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/
function get_option($option_name) {
    $data = General_option::where('option_name', '=', $option_name)->first();
    if ($data)
        return $data->option_value;
}

function  sendrefundEmail($id=null) { 
        $userID = trim($id); 
        $user = User::find($userID); 
        $userEmailID = $user->email; 
        $userName = $user->first_name; 
        //dd($user);
        
        if ($user) { 
           

                    $image = public_path().'/assets/images/logo.jpg';
                    //dd($image);
                    $template = template_by_variable('refunded');
                   //dd($template);
                    $emaildata['site_title'] = get_option('site_title'); 
                    $emaildata['admin_email'] = get_option('email'); 
                    $signature = get_option('email_signature'); 
                     
                    $emaildata['subject'] = $template->subject; 
                    $body = stripslashes($template->description); 
                 
                    $patternFind[0] = '/{NAME}/'; 
                    $patternFind[1] = '/{LOGO_IMAGE}/'; 
                    $patternFind[2] = '/{SIGNATURE}/';
                     
                    $replaceFind[0] = $userName;  
                    $replaceFind[1] = $image; 
                    $replaceFind[2] = $signature; 

                    $ebody     = nl2br(preg_replace($patternFind, $replaceFind, $body)); 
                    $emaildata['body'] = html_entity_decode(stripslashes($ebody)); 
                     
                    //$userEmailID = "sdd.sdei@gmail.com"; 
         
            try{ 
                    Mail::send(['html' => 'emails.template'], ['body' => $emaildata['body']], function($message) use ($emaildata,$userEmailID) 
                    { 
                        $message->from($emaildata['admin_email'],$emaildata['site_title']); 
                        $message->subject($emaildata['subject']); 
                        $message->to($userEmailID); 

                    }); 
                    $msg = "Email Has been sent successfully.";
                 
                   return ;
        } catch(\Exception $e){
            
          echo  $msg = "Something Went wrong, Please try Again."; 
                  return;    
                   
                    
        }           
        }else{ 

            echo  $msg = "Something Went wrong, Please try Again."; 
              return;        
                   
                       
                }             
         
    }

    function getstripekey(){
    $data = StripeSetting::first();
    if ($data)
        return $data;
    }

    function dd_my(){
        array_map(function($x) { var_dump($x); }, func_get_args());
        //array_map(function ($x) {(new Dumper)->dump($x);}, func_get_args());
    }

    function getAccessListsArray($roleName){
        $access_list = array();
        $access_list['superAdmin'] = array(
            'account'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'user'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'case'=>array(
                array('add'=>'1'),
                array('edit'=>'0'),
                array('delete'=>'0'),
                array('block'=>'0')
                            ),
			 'incident'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
              'files'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            )           

            );


        $access_list['agencySuperAdmin'] = array(
            
            'user'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'case'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'task'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'factor'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'sector'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'subject'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'target'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'files'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'forum'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'reports'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
             'resources'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
			 'incident'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
              'files'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            )

            );


        $access_list['agencyAdmin'] = array(
           
            'case'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'task'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'factor'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'sector'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'subject'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'target'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'files'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'forum'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'reports'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
             'resources'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
			 'incident'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
             ),
             'user'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
             'files'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            )
            );

        $access_list['agencyUser'] = array(
            'case'=>array(
                array('add'=>'0'),
                array('edit'=>'1'),
                array('delete'=>'0'),
                array('block'=>'0')
                        ),
            'task'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'factor'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'sector'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'subject'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'target'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'files'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'forum'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
            'reports'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
             'resources'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
			 'incident'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
             ),
             'user'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            ),
             'files'=>array(
                array('add'=>'1'),
                array('edit'=>'1'),
                array('delete'=>'1'),
                array('block'=>'1')
                            )

            );


        return $access_list[$roleName];
    }

    function getAccessList($roleName){
        $roleList = array('superAdmin','agencySuperAdmin','agencyAdmin','agencyUser');
        if (in_array($roleName, $roleList))
        {
        $access_list = getAccessListsArray($roleName);
        }
        else
        {
        $access_list = array();
        }


        return $access_list;


        

       /* echo "<pre>";
         print_r($access_list);
         echo "</pre>";   */     
    }


    function isAllowToCreateNewUser($account_membership_type,$totalExistUsers){
        $packageList = array('trial', 'basic', 'pro', 'premium' ,'deactive');

        /*Best would be different types of accounts.
        Trial - 5 users
        Basic - 1 user
        Pro - 5 users
        Premium - unlimited number
        De-Active - not applicable. No users will work.*/

       $allowStatus = 0;
       if($account_membership_type =="trial" && $totalExistUsers<5){
       $allowStatus = 1;
       }
       if($account_membership_type =="basic" && $totalExistUsers<1){
       $allowStatus = 1;
       }

       if($account_membership_type =="pro" && $totalExistUsers<5){
       $allowStatus = 1;
       }
       if($account_membership_type =="premium"){
       $allowStatus = 1;
       }
      


        return $allowStatus;
 
    }


    function getMembershipPlanTitle($account_membership_type){
        $packageList = array('trial', 'basic', 'pro', 'premium' ,'deactive');

        /*Best would be different types of accounts.
        Trial - 5 users
        Basic - 1 user
        Pro - 5 users
        Premium - unlimited number
        De-Active - not applicable. No users will work.*/

       $plan = 'De-Active';
       if($account_membership_type =="trial"){
       $plan = 'Trial - 5 users';
       }
       if($account_membership_type =="basic"){
       $plan = 'Basic - 1 user';
       }

       if($account_membership_type =="pro"){
       $plan = 'Pro - 5 users';
       }
       if($account_membership_type =="premium"){
       $plan = 'Premium - unlimited number';
       }
      


        return $plan;
 
    }

      function getStatusTitle($statusval){
         

         $statusList = array('new'=> 'New', 'in_progress'=>'In Progress', 'assigned' => 'Assigned', 'delayed' => 'Delayed' ,'closed' => 'Closed');


        $returnVal = $statusval;

       foreach ($statusList as $key => $value) {
           # code...
            if($key==$statusval){
                 $returnVal = $value;
            }
       }


        return $returnVal;


      }
/**
* Function get_total_topic_by_forumId
*
* function to get general options value
*
* @Created Date: 16 July, 2018
* @Modified Date: 16 July, 2018
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/
function get_total_topic_by_forumId($forumId) {
    $total_topic = ForumThreads::where('forum_id', '=', $forumId)->count();
    
        return $total_topic;
}   
  
/**
* Function get_total_topic_by_forumId
*
* function to get general options value
*
* @Created Date: 16 July, 2018
* @Modified Date: 16 July, 2018
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/
function get_total_post_by_topicId($forumId) {
     $forumThreadsArray = ForumThreads::where('forum_id', '=', $forumId)->get();

     $topic_arr = array();
     foreach ($forumThreadsArray as $key => $value) {
         $topic_arr[] = $value->id;
     }

     
     $forumPostArray = ForumPost::Join('users', 'forum_post.created_by', '=', 'users.id')->whereIn('forum_post.thread_id', $topic_arr)->orderby('forum_post.id','desc')
         ->select('forum_post.*','forum_post.created_at as post_created_at', 'users.first_name', 'users.last_name')
         ->first();


     $totalPost = ForumPost::whereIn('thread_id', $topic_arr)->count();


     $returnArray = array();
     $returnArray['total_post'] = $totalPost;
     $returnArray['last_post_array'] = $forumPostArray;


     return $returnArray;

      
        
}  


/**
* Function get_total_reply_by_topicId
*
* function to get general options value
*
* @Created Date: 16 July, 2018
* @Modified Date: 16 July, 2018
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/
function get_total_reply_by_topicId($thread_id) {
    $total_reply = ForumPost::where('thread_id', '=', $thread_id)->count();
    
        return $total_reply;
}   
  
/**
* Function get_last_post_by_topicId
*
* function to get general options value
*
* @Created Date: 16 July, 2018
* @Modified Date: 16 July, 2018
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/
function get_last_post_by_topicId($thread_id) {
     $last_post_array = ForumPost::Join('users', 'forum_post.created_by', '=', 'users.id')->where('forum_post.thread_id', '=', $thread_id)->orderby('forum_post.id','desc')
         ->select('forum_post.*','forum_post.created_at as post_created_at', 'users.first_name', 'users.last_name')
         ->first();

     
     return $last_post_array;

      
        
}  


/**
* Function get_selected_class_for_sorting
*
* function to get_selected_class_for_sorting
*
* @Created Date: 16 July, 2018
* @Modified Date: 16 July, 2018
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/
function get_selected_class_for_sorting($field_name) {
  echo (isset($_GET['field_name']) && $_GET['field_name']==$field_name)?'text-primary':'text-success';
    
}  

/**
* Function get_sort_icon_of_selected_field
*
* function to get_sort_icon_of_selected_field
*
* @Created Date: 16 July, 2018
* @Modified Date: 16 July, 2018
* @Created By: Subhendu Das
* @Modified By: Subhendu Das
* @param  ARRAY
* @return STRING
*/
function get_sort_icon_of_selected_field($field_name, $orderBy) {
  
   if(isset($_GET['field_name']) && $_GET['field_name']==$field_name & $orderBy=="asc"){
     echo '<i class="fa fa-sort-alpha-asc"></i>';
   }
    
   else if(isset($_GET['field_name']) && $_GET['field_name']==$field_name & $orderBy=="desc"){
     echo '<i class="fa fa-sort-alpha-desc"></i>';

   }
   else{
    echo '<i class="fa fa-arrows-v"></i>';
   }
 
    
}

 function getSpaceUsed(){
    $defaultSpace = 0;
     $account_id = Session::get('account_id');
  $accountsList = AccountList::find($account_id);
        //echo '<pre>'; print_r($accountsList->accountToStorageSpaceUsed); echo '</pre>'; 
        $defaultSpace = 0 ;
        if($accountsList->accountToStorageSpaceUsed){
            $defaultSpace = $accountsList->accountToStorageSpaceUsed->space_assigned - $accountsList->accountToStorageSpaceUsed->space_used;
        }
        return $defaultSpace .' MB';
}