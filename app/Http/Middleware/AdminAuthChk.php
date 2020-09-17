<?php

namespace App\Http\Middleware;


use Closure;
use Auth;
use DB;
use Illuminate\Routing\Route;
//use App\Models\User;


class AdminAuthChk
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

      $permission_array = array('admin-changepassword','check_current_password','check_username','forgotpasswordpage','resetpassword', 'admin-profile','admin-dashboard','admin-login','admin-logout','admin-access-denied-page','admin-ajaxGetFactorDetails','admin-ajaxAssignFactorDetails','admin-ajaxSaveFactor','admin-ajaxSaveAddNote','admin-ajaxSaveSector','admin-ajaxDeleteFactor','admin-manage-forum','admin-incidentListByType');

  
        
         if ($request->session()->exists('id')) {
            
        /*echo "<br>".$request->session()->get('id');
        echo "<br>".$request->session()->get('name');
        echo "<br>".$request->session()->get('email');*/

        $roleName = $request->session()->get('user_role_name');
        $roleList = array('superAdmin','agencySuperAdmin','agencyAdmin','agencyUser');
        if (in_array($roleName, $roleList))
        {
        $access_list = $this->getGlobalAccessListsArray($roleName);
        }
        else
        {
        $access_list = array();
        }

//dd_my($access_list);

foreach ($access_list as $key => $value) {
    # code...
    //echo "<br>".$key;
//dd($value); 
   

    if($key=="user"){
      if($value['view']){
            $permission_array[] ='admin-users';
            $permission_array[] ='admin-userdetail';
            
        }
      if($value['add']){
            $permission_array[] ='admin-adduser';
        }
       if($value['edit']){
            $permission_array[] ='admin-edituser';
        }
       if($value['delete']){
            $permission_array[] ='admin-deleteuser';
        }
       if($value['block']){
            $permission_array[] ='admin-userstatus';
        }
    }
    if($key=="account"){

      
      if($value['view']){
            $permission_array[] ='admin-AccountList';
        }
      if($value['add']){
            $permission_array[] ='admin-add-account';
        }
       if($value['edit']){
            $permission_array[] ='admin-edit-account';
        }
       if($value['delete']){
            $permission_array[] ='admin-account-delete';
        }
       if($value['block']){
            $permission_array[] ='admin-changeAccountStatus';
        }
      
      
    }

	 if($key=="incident"){

      
      if($value['view']){
            $permission_array[] ='admin-incidentList';
            $permission_array[] ='admin-viewIncident';
            $permission_array[] ='admin-linkreportToIncident';
            $permission_array[] ='admin-download-pdf-caseList';
            $permission_array[] ='admin-download-case-pdf-caseList';
			$permission_array[] ='admin-linkincidentToCase';
			$permission_array[] ='admin-linkincidentToReport';
			$permission_array[] ='admin-linkincidentToCaseAction';
			$permission_array[] ='admin-linkincidentToReportAction';
			$permission_array[] ='admin-incidentListByType';
			$permission_array[] ='admin-addManyIncident';
			$permission_array[] ='admin-incidentQuickEdit';
			$permission_array[] ='admin-incidentPostQuickEdit';
			$permission_array[] ='admin-incidentChartView';
			
			
            
            
        }
      if($value['add']){
            $permission_array[] ='admin-addIncident';
			$permission_array[] ='admin-ajaxAddNewIncidentType';
        }
       if($value['edit']){
            $permission_array[] ='admin-editIncident';
        }
        if($value['delete']){
            $permission_array[] ='admin-ajaxViewIncident';
            $permission_array[] ='admin-ajaxDeleteIncident';
        }
       /*
       if($value['block']){
            $permission_array[] ='admin-changeAccountStatus';
        }*/
      
      
    }
	if($key=="incidenttype"){

      
      if($value['view']){
            $permission_array[] ='admin-incidenttypeList';
            $permission_array[] ='admin-viewIncidenttype';
            
			
            
            
        }
      if($value['add']){
            $permission_array[] ='admin-addIncidentType';
			$permission_array[] ='admin-ajaxAddNewIncidentType';
        }
       if($value['edit']){
            $permission_array[] ='admin-editIncidentType';
        }
        if($value['delete']){
            $permission_array[] ='admin-ajaxViewIncidentType';
            $permission_array[] ='admin-ajaxDeleteIncidentType';
        }
    }
    if($key=="case"){

      
      if($value['view']){
            $permission_array[] ='admin-caseList';
            $permission_array[] ='admin-viewCase';
            $permission_array[] ='admin-viewTargetChart';
            $permission_array[] ='admin-download-pdf-caseList';
            
            
        }
      if($value['add']){
            $permission_array[] ='admin-addCase';
        }
       if($value['edit']){
            $permission_array[] ='admin-editCase';
        }
        if($value['delete']){
            $permission_array[] ='admin-ajaxViewCase';
            $permission_array[] ='admin-ajaxDeleteCase';
        }
       /*
       if($value['block']){
            $permission_array[] ='admin-changeAccountStatus';
        }*/
      
      
    }

    if($key=="factor"){
 
      if($value['view']){
            $permission_array[] ='admin-factor-list';
        }
      if($value['add']){
            $permission_array[] ='admin-add-factor';
        }
       if($value['edit']){
            $permission_array[] ='admin-edit-factor';
        }
       if($value['delete']){
            $permission_array[] ='admin-delete-factor';
        }
       if($value['block']){
            $permission_array[] ='admin-target-chart-visibility-status';
            $permission_array[] ='admin-timeline-chart-visibility-status';
        }
      
      
    }

     if($key=="sector"){

      if($value['view']){
            $permission_array[] ='admin-sector-list';
        }
      if($value['add']){
            $permission_array[] ='admin-add-sector';
        }
       if($value['edit']){
            $permission_array[] ='admin-edit-sector';
        }
       if($value['delete']){
            $permission_array[] ='admin-delete-sector';
        }
       if($value['block']){
            $permission_array[] ='admin-sector-status';
        }
      
      
    }


    if($key=="tasks"){


      if($value['view']){
            $permission_array[] ='admin-ajaxGetTaskDetails';
			$permission_array[] ='admin-ajaxSendTaskDetails';
            $permission_array[] ='admin-ajaxAssignTaskDetails';
            $permission_array[] ='admin-task-list';
            
        }
      if($value['add']){
            $permission_array[] ='admin-ajax-save-task';
			$permission_array[] ='admin-add-email-task';
        }
       if($value['edit']){
            $permission_array[] ='admin-edit-resources';
        }
       if($value['delete']){
            $permission_array[] ='admin-ajaxDeleteTask';
        }
       if($value['block']){
            $permission_array[] ='admin-sector-status';
        }
      
    }



    
     if($key=="resources"){

      if($value['view']){
            $permission_array[] ='admin-resources-list';
        }
      if($value['add']){
            $permission_array[] ='admin-add-resources';
        }
       if($value['edit']){
            $permission_array[] ='admin-edit-resources';
        }
       if($value['delete']){
            $permission_array[] ='admin-delete-resources';
        }
       if($value['block']){
            $permission_array[] ='admin-sector-status';
        }
      
    }



    if($key=="subject"){

      if($value['view']){
            $permission_array[] ='admin-ajaxAssignSubjectDetails';
            $permission_array[] ='admin-ajaxGetSubjectDetails';
            
        }
      if($value['add']){
            $permission_array[] ='admin-ajaxSaveSubject';
        }
       if($value['edit']){
            $permission_array[] ='admin-ajaxSaveSubject';
        }
       if($value['delete']){
           
        }
       if($value['block']){
           
        }
      
    }

 if($key=="target"){

      if($value['view']){
            $permission_array[] ='admin-ajaxGetTargetDetails';
            $permission_array[] ='admin-ajaxAssignTargetDetails';
            
        }
      if($value['add']){
            $permission_array[] ='admin-ajaxSaveTarget';
        }
       if($value['edit']){
            $permission_array[] ='admin-ajaxSaveTarget';
        }
       if($value['delete']){
           
        }
       if($value['block']){
           
        }
      
    }



  if($key=="gallery"){

      if($value['view']){
            $permission_array[] ='admin-ajaxShowGallery';
            $permission_array[] ='admin-ajaxViewGalleryDetails';
            
            
            
            
        }
      if($value['add']){
            $permission_array[] ='admin-ajaxSaveGallery';
            $permission_array[] ='admin-ajaxEditGalleryDetails';
            $permission_array[] ='admin-ajaxSetAsCaseImage';
            
            
        }
       if($value['edit']){
            $permission_array[] ='admin-ajaxSaveGallery';
            $permission_array[] ='admin-ajaxEditGalleryDetails';
            $permission_array[] ='admin-ajaxSetAsCaseImage';
            
        }
       if($value['delete']){
            
        }
       if($value['block']){
           
        }
      
    }

	
	if($key=="factorgallery"){

      if($value['view']){
            $permission_array[] ='admin-ajaxShowFactorGallery';
            $permission_array[] ='admin-ajaxViewFactorGalleryDetails';
            
            
            
            
        }
      if($value['add']){
            $permission_array[] ='admin-ajaxSaveFactorGallery';
            $permission_array[] ='admin-ajaxEditFactorGalleryDetails';
            $permission_array[] ='admin-ajaxSetAsFactorImage';
			$permission_array[] ='admin-addFileFactorDetails';
			$permission_array[] ='admin-ajaxDeleteFileFactorDetails';
            $permission_array[] ='admin-ajaxDeleteFactorImage';
            
        }
       if($value['edit']){
            $permission_array[] ='admin-ajaxSaveFactorGallery';
            $permission_array[] ='admin-ajaxEditFactorGalleryDetails';
            $permission_array[] ='admin-ajaxSetAsFactorImage';
			$permission_array[] ='admin-addFileFactorDetails';
			$permission_array[] ='admin-ajaxDeleteFileFactorDetails';
            $permission_array[] ='admin-ajaxDeleteFactorImage';
        }
       if($value['delete']){
            $permission_array[] ='admin-ajaxDeleteFactorImage';
        }
       if($value['block']){
           
        }
      
    }
	
    if($key=="files"){

      if($value['view']){
            $permission_array[] ='admin-ajaxGetFileDetails';
			$permission_array[] ='admin-ajaxGetFactorFileDetails';
            $permission_array[] ='admin-ajaxAssignFileDetails';
            
        }
      if($value['add']){
            $permission_array[] ='admin-ajaxSaveFile';
        }
       if($value['edit']){
            $permission_array[] ='admin-ajaxSaveFile';
            $permission_array[] ='admin-ajaxEditFileDetails';
        }
       if($value['delete']){
            $permission_array[] ='admin-ajaxDeleteFile';
        }
       if($value['block']){
           
        }
      
    }
    

    if($key=="report"){

      if($value['view']){
            $permission_array[] ='admin-reportList';
            $permission_array[] ='admin-viewReport';
			$permission_array[] ='admin-incident-linkto-report';
			$permission_array[] ='admin-reportListByIncident';
			$permission_array[] ='admin-linkreportToCase';
			
			
            
        }
      if($value['add']){
            //$permission_array[] ='admin-ajaxSaveFile';
        }
       if($value['edit']){
           // $permission_array[] ='admin-ajaxSaveFile';
            //$permission_array[] ='admin-ajaxEditFileDetails';
        }
       if($value['delete']){
           $permission_array[] ='admin-delete-report';
        }
       if($value['block']){
           
        }
      
    }

     if($key=="forum"){

      if($value['view']){
            $permission_array[] ='admin-forum-list';
            $permission_array[] ='admin-topic-list';
            $permission_array[] ='admin-view-topic';
            $permission_array[] ='admin-ajax-save-reply';
            
            
            
        }
      if($value['add']){
            $permission_array[] ='admin-ajaxGetForumDetails';
            $permission_array[] ='admin-ajax-save-forum';
            $permission_array[] ='admin-ajaxGetTopicDetails';
            $permission_array[] ='admin-ajax-save-topic';
            $permission_array[] ='admin-ajaxPostReply';
            
        }
       if($value['edit']){
            $permission_array[] ='admin-ajaxGetForumDetails';
            $permission_array[] ='admin-ajax-save-forum';
            $permission_array[] ='admin-ajaxGetTopicDetails';
            $permission_array[] ='admin-ajax-save-topic';
            $permission_array[] ='admin-ajaxPostReply';
        }
       if($value['delete']){
            $permission_array[] ='admin-ajaxDeleteForum';
            $permission_array[] ='admin-ajaxDeleteTopic';
            $permission_array[] ='admin-ajaxDeletePost';
            
            
        }
       if($value['block']){
           
        }
      
    }





    



}
//dd($permission_array);
 /*account,user,case,task,factor,sector,subject,target,files,forum,
reports,resources*/
/*
admin-dashboard
Match found
App\Http\Controllers\Admin\AdminController@index
AdminController
index 
*/
$routename = \Request::route()->getName();

if (in_array($routename, $permission_array))
  {
  
  }
else
  {
   
    if (auth()->guest()) {
            
            return redirect('admin/access-denied-page');
        }
  
  }

        /*echo "<br>".$currentAction = \Route::currentRouteAction();
        list($controller, $method) = explode('@', $currentAction);
       

        echo "<br>".$controller = preg_replace('/.*\\\/', '', $controller);
        echo "<br>".$method = preg_replace('/.*\\\/', '', $method);*/

        }
        else{
            // user value cannot be found in session
        //return redirect('/access.php');
        }


        
        
        return $next($request);
    }


    function getGlobalAccessListsArray($roleName){
        $access_list = array();
        $access_list['superAdmin'] = array(
            'account'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                    ),
            'user'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                ),
            'case'=>array(
                'view'   =>'1',
                'add'    =>'0',
                'edit'   =>'0',
                'delete' =>'1',
                'block'  =>'0'
              ),
            'resources'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
            'tasks'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
            'forum'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
            'report'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
			'incident'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
			  'incidenttype'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
            

            );


        $access_list['agencySuperAdmin'] = array(
            
            'user'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                    ),
            'case'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'task'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'factor'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'sector'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'subject'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'files'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'gallery'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
			 'factorgallery'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'target'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'files'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'forum'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'report'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
             'resources'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
             'tasks'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                ),
             'forum'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
			  'incident'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
            'incidenttype'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
          

            );


        $access_list['agencyAdmin'] = array(
           
            'case'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'task'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'factor'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'sector'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'subject'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'files'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'gallery'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
			'factorgallery'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'target'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'files'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'forum'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'report'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
             'resources'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
             'tasks'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
             'forum'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
			  'incident'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
            'incidenttype'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
          

            );

        $access_list['agencyUser'] = array(
            'case'=>array(
                'view'   =>'1',
                'add'    =>'0',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'0'
                            ),
            'task'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'0',
                'block'  =>'0'
                            ),
            'factor'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'0',
                'block'  =>'0'
                            ),
            'sector'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'0',
                'block'  =>'0'
                            ),
            'subject'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'0',
                'block'  =>'0'
                            ),
            'files'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'gallery'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
			'factorgallery'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'target'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'files'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'forum'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
            'report'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
             'resources'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
                            ),
             'tasks'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
             'forum'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
			'incident'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
			  'incidenttype'=>array(
                'view'   =>'1',
                'add'    =>'1',
                'edit'   =>'1',
                'delete' =>'1',
                'block'  =>'1'
              ),
            
            );


        return $access_list[$roleName];
    }

    
}
