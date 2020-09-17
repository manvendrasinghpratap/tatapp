<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* static front end pages */
//Route::any('/', 'HomeController@index')->name('home');
Auth::routes();

//home routings
Route::get('/aff', 'HomeController@affi')->name('aff');
Route::any('/home', 'HomeController@index')->name('home');
Route::get('/', 'Admin\LoginController@login')->name('admin-login');
Route::any('/agaxCaptchaResponse', 'HomeController@agaxCaptchaResponse')->name('agaxCaptchaResponse');
Route::any('/report-home/{id}', 'HomeController@report_home')->name('report-home');
Route::get('/vsldk', 'HomeController@callback')->name('vsldk');
Route::get('/thankyou','HomeController@thankyou')->name('thankyou');
Route::post('/register', 'HomeController@register')->name('register');
Route::get('/register', 'HomeController@register')->name('register');
Route::get('/start', 'HomeController@start')->name('start');
Route::post('/user-registration', 'HomeController@register_user')->name('user-registration');
Route::any('/check_for_email', 'HomeController@check_for_email')->name('check_for_email');
Route::any('/check_user_status', 'HomeController@check_user_status')->name('check_user_status');
Route::any('/is_user_exist', 'HomeController@is_user_exist')->name('is_user_exist');
Route::any('/check_user_reference','HomeController@check_user_reference')->name('check_user_reference');


Route::post('/first-payment', 'HomeController@first_payment')->name('first-payment');
Route::any('/verify-link', 'HomeController@verify_link')->name('verify-link');
Route::any('/verification-failed','HomeController@verification_failed')->name('verification-failed');
Route::any('/vsl-page','HomeController@vsl_page')->name('vsl-page');
Route::any('/pdf','HomeController@genrate_invoice_pdf')->name('pdf');
Route::any('/privacy','HomeController@privacy')->name('privacy');
Route::any('/agreement','HomeController@agreement')->name('agreement');
Route::any('/coming-soon','HomeController@coming_soon')->name('coming-soon');



//Webhooks for payment capturing and auth login
//paypal call back for user authentication
Route::any('/paypal_auth','WebhookController@paypal_auth')->name('paypal_auth');
//stripe call back for user authentication
Route::any('/stripe_auth','WebhookController@stripe_auth')->name('stripe_auth');

Route::any('/stripe_callback','WebhookController@stripe_callback')->name('stripe_callback');
Route::any('/paypal_callback','WebhookController@paypal_track')->name('paypal_callback');

Route::any('/UserConsentRedirect','WebhookController@UserConsentRedirect')->name('UserConsentRedirect');





//user routings
Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {


    Route::get('/coming-soon','DashboardController@coming_soon')->name('user-coming-soon');

    Route::get('/dashboard', 'DashboardController@index')->name('user-dashboard');
    Route::get('/starter', 'DashboardController@start_plan')->name('start-plan');
    Route::get('/exclusive', 'DashboardController@exclusive_plan')->name('exclusive-plan');
    Route::get('/module/{id}', 'DashboardController@view_module')->name('view-module');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/packages','DashboardController@packages')->name('packages');
    Route::get('/profile','DashboardController@profile')->name('profile');
    Route::post('/update-user','DashboardController@update_user')->name('update_user');
    Route::get('/unlock/{id}','DashboardController@unlock_next_video')->name('user-unlock-next-video');





    //payment routes

     Route::get('/payment/{id}', 'PaymentController@index')->name('payment');
     Route::get('/change_plan/{id}', 'PaymentController@change_plan')->name('change_plan');
     Route::post('/paypal_buy', 'PaymentController@paypal_buy')->name('paypal_buy');
     Route::post('/stripe_buy', 'PaymentController@stripe_buy')->name('stripe_buy');
     Route::get('/refund', 'PaymentController@refund')->name('refund');
     Route::get('/cancel','PaymentController@cancel_plan')->name('cancel-plan');
     Route::get('/cancelRefund','PaymentController@cancel_refund_plan')->name('cancel-refund-plan');
     Route::post('/stripeUpdate','PaymentController@stripe_card_update')->name('stripe-card-update');
     Route::post('/paypalUpdate','PaymentController@paypal_card_update')->name('paypal-card-update');



     //paypal and stripe authentication user

     Route::get('/payment-accounts','PaymentController@authenticate_user')->name('authenticate_user');
     Route::get('/delete-paypal-account','PaymentController@delete_paypal_account')->name('delete-paypal-account');
     Route::get('/delete-stripe-account','PaymentController@delete_stripe_account')->name('delete-stripe-account');

    
});



////  admin routings

 

Route::group([  'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/test2', function()
{
    return 'Hello World';
});
  Route::middleware(['password_expired'])->group(function () {	
    Route::get('/comingsoon', 'ComingsoonController@comingsoon')->name('admin-comingsoon');
    Route::get('/dashboard', 'AdminController@index')->name('admin-dashboard');
    Route::get('/access-denied-page', 'AdminController@access_denied_page')->name('admin-access-denied-page');

    //user routes
    Route::any('/users', 'UserController@index')->name('admin-users');
    Route::any('/add_user', 'UserController@add_user')->name('admin-adduser');
    Route::any('/user_edit/{id}', 'UserController@add_user')->name('admin-edituser');
    Route::get('/user_delete/{id}', 'UserController@user_delete')->name('admin-deleteuser');
    Route::get('/user_detail/{id}', 'UserController@user_detail')->name('admin-userdetail');
    Route::any('/user_status/{id}/{status}', 'UserController@change_status')->name('admin-userstatus');
    
    Route::get('/groups', 'GroupController@index')->name('admin-groups');
    Route::any('/add-group','GroupController@add')->name('admin-add-group');
    Route::any('/edit-group/{id}', 'GroupController@add')->name('admin-edit-group');
    Route::get('/delete-group/{id}', 'GroupController@destroy')->name('admin-group-delete');
    Route::any('/list-all-users-account','GroupController@listallusersbelongstospecificaccount')->name('admin-list-all-users-account');
    Route::any('/list-all-group','UserController@listallgroupbelongstospecificaccount')->name('admin-list-all-group');
    Route::any('/admin-datatable-records','IncidentController@admindatatablerecords')->name('admin-datatable-records');
    Route::any('/admin-datatable-monthy-records','IncidentController@admindatatablemonthyrecords')->name('admin-datatable-monthy-records');
    
    
    //starteerr plan routes

    Route::any('/AccountList','AccountController@accountList')->name('admin-AccountList');
    Route::any('/add-account','AccountController@add_account')->name('admin-add-account');
    Route::any('/edit-account/{id}', 'AccountController@add_account')->name('admin-edit-account');
    Route::any('/ajax-edit-account/{id}', 'AccountController@ajax_add_account')->name('admin-ajax-edit-account');
    Route::any('/changeAccountStatus/{account_id}/{status}', 'AccountController@change_account_status')->name('admin-changeAccountStatus');

    Route::get('/account_delete/{account_id}', 'AccountController@account_delete')->name('admin-account-delete');

    //exclusive plan routes
    Route::any('/sectorList','AccountController@sectorList')->name('admin-sector-list');
    Route::any('/add-sector','AccountController@add_sector')->name('admin-add-sector');
    Route::any('/edit-sector/{id}', 'AccountController@add_sector')->name('admin-edit-sector');

    Route::any('/sector_status/{id}/{status}', 'AccountController@sector_status')->name('admin-sector-status');
    Route::get('/sector_delete/{id}', 'AccountController@sector_delete')->name('admin-delete-sector');

    
    //exclusive plan routes
    Route::any('/factorList','AccountController@factorList')->name('admin-factor-list');
    Route::any('/add-factor','AccountController@add_factor')->name('admin-add-factor');
    Route::any('/edit-factor/{id}', 'AccountController@add_factor')->name('admin-edit-factor');

    Route::any('/target-chart-visibility-status/{id}/{status}', 'AccountController@target_chart_visibility_status')->name('admin-target-chart-visibility-status');
    Route::any('/timeline-chart-visibility-status/{id}/{status}', 'AccountController@timeline_chart_visibility_status')->name('admin-timeline-chart-visibility-status');
    Route::get('/factor_delete/{id}', 'AccountController@factor_delete')->name('admin-delete-factor');

    //report routes
    Route::any('/reportList','ReportController@index')->name('admin-reportList');
    Route::any('/reportList/{id}','ReportController@view_reportlist')->name('admin-reportListByIncident');
    Route::any('/view_report/{id}','ReportController@view_report')->name('admin-viewReport');
    Route::get('/delete-report/{id}', 'ReportController@delete_report')->name('admin-delete-report');
    Route::any('/incident-linktoreport', 'ReportController@incident_linkto_report')->name('admin-incident-linkto-report');
    Route::any('/updatereporttogroup','ReportController@updatereporttogroup')->name('admin-updatereporttogroup');

	
	
    
	
	//incident Incident
       // Route::get('/test','IncidentController@test')->name('admin-test');
        //Route::get('/test2','UserController@test_user')->name('test-user');

        Route::post('/updatecoordinate','CaseController@updatecoordinate')->name('admin-updatecoordinate');
        
        
    Route::get('/incidentList','IncidentController@index')->name('admin-incidentList');
	Route::any('addIncident','IncidentController@edit_incident')->name('admin-addIncident');
	Route::any('/addmanyIncident','IncidentController@ajax_add_incident')->name('admin-addManyIncident');
	Route::any('/editIncident/{id}/','IncidentController@edit_incident')->name('admin-editIncident');
	Route::any('/viewIncident/{id}','IncidentController@view_incident')->name('admin-viewIncident');
	Route::any('/addIncidenttype','IncidentController@add_incidenttype')->name('admin-ajaxAddNewIncidentType');
	Route::any('/ajaxtogetlatitudeandlongitude','IncidentController@ajaxtogetlatitudeandlongitude')->name('admin-ajaxtogetlatitudeandlongitude');
	 Route::any('/ajax-view-incident','IncidentController@ajax_view_incident')->name('admin-ajaxViewIncident');
    Route::any('/delete-incident','IncidentController@delete_incident')->name('admin-ajaxDeleteIncident'); 
	Route::any('/linkreport-toincident/{id}/{type1}','IncidentController@linkreport_toincident')->name('admin-linkreportToIncident'); 
	Route::any('/incident-list-bytype','IncidentController@ajax_view_incident_by_type')->name('admin-incidentListByType'); 
	
	Route::any('/incident-quickedit','IncidentController@ajax_edit_incident')->name('admin-incidentQuickEdit');
	Route::any('/incident-postquickedit','IncidentController@ajax_post_edit_incident')->name('admin-incidentPostQuickEdit');
	
	Route::any('/incident-incident_chart','IncidentController@ajax_view_incident_chart')->name('admin-incidentChartView');
	
	/*  16 April 2020 Begin */
    Route::any('/ajaxAddNewIncident/{id}','IncidentController@ajaxAddNewIncident')->name('admin-ajaxAddNewIncident');
    Route::any('/getLocationAndLongitudeAndLatitudeGraph','IncidentController@getLocationAndLongitudeAndLatitudeGraph')->name('admin-getLocationAndLongitudeAndLatitudeGraph');
 	
	
	
	
    
	Route::any('/case-linktoincident/{id}', 'IncidentController@linkincident_tocase')->name('admin-linkincidentToCase');
	Route::any('/case-linktoincident', 'IncidentController@linkincident_tocase_action')->name('admin-linkincidentToCaseAction');
	Route::any('/task-linktoincident', 'IncidentController@linkincident_totask_action')->name('admin-linkincidentToTaskAction');
	Route::any('/report-linktoincident/{id}', 'IncidentController@linkincident_toreport')->name('admin-linkincidentToReport');
	Route::any('/report-linktoincident', 'IncidentController@linkincident_toreport_action')->name('admin-linkincidentToReportAction');
	
	
	//Incident Type
    Route::get('/incidenttypeList','IncidentTypeController@index')->name('admin-incidenttypeList');
	Route::any('/addnewIncidenttype','IncidentTypeController@edit_incidenttype')->name('admin-addIncidentType');
	Route::any('/editIncidenttype/{id}','IncidentTypeController@edit_incidenttype')->name('admin-editIncidentType');
	Route::any('/delete-incidenttypelist','IncidentTypeController@delete_incidenttype')->name('admin-ajaxDeleteIncidentType'); 
	
	
	
	
	
	
	
	
    /*  Route::get('/downloadPDF','CaseController@downloadPDF')->name('admin-download-pdf-caseList');
    Route::any('/editCase/{id}','CaseController@edit_case')->name('admin-editCase');
    Route::any('/addCase','CaseController@edit_case')->name('admin-addCase');
    Route::any('/viewCase/{id}','CaseController@view_case')->name('admin-viewCase');
    Route::any('/ajax-view-case','CaseController@ajax_view_case')->name('admin-ajaxViewCase');
    Route::any('/delete-case','CaseController@delete_case')->name('admin-ajaxDeleteCase'); */
	
    Route::get('/corkboard/{id}','CaseController@Corkboard')->name('admin-corkboard');
	Route::get('/downloadCasePDF/{id}','CaseController@downloadCasePDF')->name('admin-download-case-pdf-caseList');
	Route::get('/downloadSubjectPDF/{id}','CaseController@downloadSubjectPDF')->name('admin-download-case-pdf-subjectList');
	Route::get('/downloadTargetPDF/{id}','CaseController@downloadTargetPDF')->name('admin-download-case-pdf-targetList');
	Route::get('/downloadFactorPDF/{id}','CaseController@downloadFactorPDF')->name('admin-download-case-pdf-factorList');
	Route::get('/downloadTaskPDF/{id}','CaseController@downloadTaskPDF')->name('admin-download-case-pdf-taskList');
	Route::get('/downloadIncidentPDF/{id}','CaseController@downloadIncidentPDF')->name('admin-download-case-pdf-incidentList');
	Route::get('/downloadCaseLog/{id}','PdfController@downloadcaselog')->name('admin-download-case-pdf-log');

    //case routes
    Route::get('/caseList','CaseController@index')->name('admin-caseList');
    Route::get('/subjectList','SubjectController@subjectCaseList')->name('admin-subjectList');
    Route::get('/targetList','TargetController@targetCaseList')->name('admin-targetList');
    Route::get('/filelist','FileController@index')->name('admin-filelist');
    
    Route::get('/casefileist','FileController@casefileist')->name('admin-casefileist');
    Route::get('/incidentfilelist','FileController@incidentfilelist')->name('admin-incidentfilelist');



    Route::get('/downloadPDF','CaseController@downloadPDF')->name('admin-download-pdf-caseList');
    Route::any('/editCase/{id}','CaseController@edit_case')->name('admin-editCase');
    Route::any('/addCase','CaseController@edit_case')->name('admin-addCase');
    Route::any('/addfiles','FileController@add_files')->name('admin-addfiles');
    Route::any('/editFile/{id}','FileController@edit_files')->name('admin-editFile');
    Route::any('/viewCase/{id}','CaseController@view_case')->name('admin-viewCase');
    Route::any('/viewFile/{id}','FileController@view_files')->name('admin-viewFile');
    Route::any('/ajax-view-case','CaseController@ajax_view_case')->name('admin-ajaxViewCase');
    Route::any('/delete-case','CaseController@delete_case')->name('admin-ajaxDeleteCase');
    Route::any('/deleteFile/{id}','FileController@delete_file')->name('admin-deleteFile');
    Route::any('/caseAndFilesMapped/{id}','FileController@caseAndFilesMapped')->name('admin-caseAndFilesMapped');
    Route::any('/incidentAndFilesMapped/{id}','FileController@incidentAndFilesMapped')->name('admin-incidentAndFilesMapped');

    Route::any('/viewTargetChart/{id}','CaseController@view_target_chart')->name('admin-viewTargetChart');
    Route::any('/targetchart/{id}','CaseController@targetchart')->name('admin-targetchart');
    Route::any('/timelinechart/{id}','CaseController@timelinechart')->name('admin-timelinechart');
    

    Route::any('/ajaxGetFactorDetails','CaseController@ajaxGetFactorDetails')->name('admin-ajaxGetFactorDetails');
    Route::any('/ajaxGetFactorDetailscorkboard','CaseController@ajaxGetFactorDetailscorkboard')->name('admin-ajaxGetFactorDetailscorkboard');
    Route::any('/ajaxAssignFactorDetails','CaseController@ajaxAssignFactorDetails')->name('admin-ajaxAssignFactorDetails');
    Route::any('/addNewFactor/{id}','CaseController@addNewFactor')->name('admin-addNewFactor');
    Route::any('/getFactorsList/{id}/{type}','CaseController@getFactorsList')->name('admin-getFactorsList');
/*      
    Route::any('/getCaseTasksList/{id}','CaseController@getCaseTasksList')->name('admin-getCaseTasksList');
    Route::any('/getCaseNotesList/{id}','CaseController@getCaseNotesList')->name('admin-getCaseNotesList');
    Route::any('/getCaseIncidentsList/{id}','CaseController@getCaseIncidentsList')->name('admin-getCaseIncidentsList');*/

    Route::any('/ajaxSaveFactor','CaseController@ajaxSaveFactor')->name('admin-ajaxSaveFactor');
	Route::any('/ajaxSaveAddNote','CaseController@ajaxSaveAddNote')->name('admin-ajaxSaveAddNote');

    Route::any('/ajaSaveSector','CaseController@ajaSaveSector')->name('admin-ajaxSaveSector');
    Route::any('/ajaxDeleteFactor','CaseController@ajaxDeleteFactor')->name('admin-ajaxDeleteFactor');

    Route::any('/task-linktocase', 'CaseController@linkcase_totask_action')->name('admin-linkcaseToTaskAction');
    
    Route::any('/ajaxGetTaskDetails','TaskController@ajaxGetTaskDetails')->name('admin-ajaxGetTaskDetails');
    Route::any('/ajaxGetTaskEmailLog','TaskController@ajaxGetTaskEmailLog')->name('admin-ajaxGetTaskEmailLog');

    Route::any('/ajaxGetTaskDetailsChangeStatus','TaskController@ajaxGetTaskDetailsChangeStatus')->name('admin-ajaxGetTaskDetailsChangeStatus');


    /*New Task Changes 9 April Begin*/
    Route::any('/addedittaskdetails','TaskController@addedittaskdetails')->name('admin-addedittaskdetails');
	Route::any('/edittaskdetails/{id}','TaskController@edittaskdetails')->name('admin-edittaskdetails');
    Route::any('/saveTask','TaskController@saveTask')->name('admin-saveTask');
    Route::any('/updateincidentTask','TaskController@updateincidentTask')->name('admin-updateincidentTask');

    Route::any('/ajaxGetCaseDetails','TaskController@ajaxGetCaseDetails')->name('admin-ajaxGetCaseDetails');
    Route::any('/ajaxGetIncidentDetails','TaskController@ajaxGetIncidentDetails')->name('admin-ajaxGetIncidentDetails');
    Route::any('/ajaxGetIncidentDetailsWithCase','CaseController@ajaxGetIncidentDetailsWithCase')->name('admin-ajaxGetIncidentDetailsWithCase');
    Route::any('/ajaxLinkIncidentAndCaseId','CaseController@ajaxLinkIncidentAndCaseId')->name('admin-ajaxLinkIncidentAndCaseId');

    /*New Task Changes 9 April End*/
/* nEW iNCIDENT and task page Begin */
	Route::any('/addnewTaskIncident/{id}','TaskController@addnewTaskIncident')->name('admin-addnewTaskIncident');
    Route::any('/saveTaskIncident','TaskController@saveTaskIncident')->name('admin-saveTaskIncident');
/* nEW iNCIDENT and task page End */

/* nEW iNCIDENT and task page Begin */
	Route::any('/addnewTaskCase/{id}','TaskController@addnewTaskCase')->name('admin-addnewTaskCase'); 
    Route::any('/saveTaskCase','TaskController@saveTaskCase')->name('admin-saveTaskCase');
/* nEW iNCIDENT and task page End */
    
	Route::any('/ajaxSendTaskDetails','TaskController@ajaxSendTaskDetails')->name('admin-ajaxSendTaskDetails');
    Route::any('/ajaxAssignTaskDetails','TaskController@ajaxAssignTaskDetails')->name('admin-ajaxAssignTaskDetails');
    
    Route::any('/ajaxSaveTask','TaskController@ajaxSaveTask')->name('admin-ajax-save-task');
    Route::any('/ajaxDeleteTask','TaskController@ajaxDeleteTask')->name('admin-ajaxDeleteTask');
    Route::any('/taskList','TaskController@taskList')->name('admin-task-list');
	Route::any('/addEmail','TaskController@addEmail')->name('admin-add-email-task');

    Route::any('/caseAndTasksMapped/{id}','TaskController@caseAndTasksMapped')->name('admin-caseAndTasksMapped');
    Route::any('/incidentAndTaskMapped/{id}','TaskController@incidentAndTaskMapped')->name('admin-incidentAndTaskMapped');
    Route::any('/taskAndCase/{id}','TaskController@taskAndCase')->name('admin-taskAndCase');

    Route::any('/caselinkwithtask/{id}','CaseController@caselinkwithtask')->name('admin-caselinkwithtask');
    Route::any('/incidentwithtask/{id}','IncidentController@incidentwithtask')->name('admin-incidentwithtask');

    Route::any('/ajaxGetDescriptionDetails','CaseController@ajaxGetDescriptionDetails')->name('admin-ajaxGetDescriptionDetails');
    Route::any('/ajaxSaveDescription','CaseController@ajaxSaveDescription')->name('admin-ajaxSaveDescription');
    Route::any('/getDescription/{id}','CaseController@getDescription')->name('admin-getDescription'); 
    Route::any('deleteDescription/{caseId}','CaseController@deleteDescription')->name('admin-delete-description');
    
    Route::any('/ajaxGetSubjectDetails','SubjectController@ajaxGetSubjectDetails')->name('admin-ajaxGetSubjectDetails');
    Route::any('/ajaxAssignSubjectDetails','SubjectController@ajaxAssignSubjectDetails')->name('admin-ajaxAssignSubjectDetails');
    Route::any('/ajaxSaveSubject','SubjectController@ajaxSaveSubject')->name('admin-ajaxSaveSubject');
      
    Route::any('addSubject/{caseId}/{subjectId}','SubjectController@add')->name('admin-add-subject');       
    Route::any('deleteSubject/{caseId}/{subjectId}','SubjectController@deleteSubject')->name('admin-delete-subject');  
    Route::any('managesubject/{caseId}','SubjectController@managesubject')->name('admin-managesubject');       
 
    Route::any('addSubjectInCase','SubjectController@addSubjectInCase')->name('admin-addSubjectInCase');       
    Route::any('addTargetInCase','TargetController@addTargetInCase')->name('admin-addTargetInCase');       



    Route::any('/ajaxGetTargetDetails','TargetController@ajaxGetTargetDetails')->name('admin-ajaxGetTargetDetails');
    Route::any('/ajaxAssignTargetDetails','TargetController@ajaxAssignTargetDetails')->name('admin-ajaxAssignTargetDetails');
    Route::any('/ajaxSaveTarget','TargetController@ajaxSaveTarget')->name('admin-ajaxSaveTarget');
    Route::any('/getTargetDetail/{caseId}','TargetController@getTargetDetail')->name('admin-getTargetDetail');
    Route::any('deleteTarget/{caseId}','TargetController@deleteTarget')->name('admin-delete-target');  

    Route::any('managetarget/{caseId}','TargetController@managetarget')->name('admin-managetarget');       
    Route::any('addTarget/{caseId}/{subjectId}','TargetController@add')->name('admin-add-target'); 

    Route::any('/ajaxGetFileDetails','FileController@ajaxGetFileDetails')->name('admin-ajaxGetFileDetails');
    Route::any('/getFileDetail/{caseId}','FileController@getFileDetail')->name('admin-getFileDetail');
	Route::any('/ajaxGetFactorFileDetails','FileController@ajaxGetFactorFileDetails')->name('admin-ajaxGetFactorFileDetails');
    Route::any('/ajaxAssignFileDetails','FileController@ajaxAssignFileDetails')->name('admin-ajaxAssignFileDetails');
    Route::any('/ajaxSaveFile','FileController@ajaxSaveFile')->name('admin-ajaxSaveFile');
    Route::any('/ajaxEditFileDetails','FileController@ajaxEditFileDetails')->name('admin-ajaxEditFileDetails');
    Route::any('/ajaxDeleteFile','FileController@ajaxDeleteFile')->name('admin-ajaxDeleteFile');
    

    

    
    
    
    
    //exclusive plan routes
    Route::any('/resourcesList','ResourcesController@resourcesList')->name('admin-resources-list');
    Route::any('/add-resources','ResourcesController@add_resources')->name('admin-add-resources');
    Route::any('/edit-resources/{id}', 'ResourcesController@add_resources')->name('admin-edit-resources');
    Route::get('/resources_delete/{id}', 'ResourcesController@resources_delete')->name('admin-delete-resources');
   /* 
    

    Route::any('/sector_status/{id}/{status}', 'AccountController@sector_status')->name('admin-sector-status');
    */

    //exclusive plan routes
    Route::any('/forum-list/{id}','ForumController@forumList')->name('admin-forum-list');
    Route::any('/manage-forum','ForumController@manageForum')->name('admin-manage-forum');
    
    Route::any('/topic-list/{id}','ForumController@topicList')->name('admin-topic-list');
    Route::any('/ajaxGetForumDetails','ForumController@ajaxGetForumDetails')->name('admin-ajaxGetForumDetails');
    Route::any('/ajaxSaveForum','ForumController@ajaxSaveForum')->name('admin-ajax-save-forum');
    Route::any('/ajaxDeleteForum','ForumController@ajaxDeleteForum')->name('admin-ajaxDeleteForum');


    Route::any('/ajaxGetTopicDetails','ForumController@ajaxGetTopicDetails')->name('admin-ajaxGetTopicDetails');
    Route::any('/ajaxSaveTopic','ForumController@ajaxSaveTopic')->name('admin-ajax-save-topic');
    Route::any('/ajaxDeleteTopic','ForumController@ajaxDeleteForum')->name('admin-ajaxDeleteTopic');
    Route::any('/viewTopic/{id}','ForumController@viewTopic')->name('admin-view-topic');
    Route::any('/saveReply','ForumController@saveReply')->name('admin-ajax-save-reply');

    Route::any('/ajaxDeletePost','ForumController@ajaxDeletePost')->name('admin-ajaxDeletePost');

    Route::any('/ajaxShowGallery','GalleryController@ajaxShowGallery')->name('admin-ajaxShowGallery');
    Route::any('/ajaxSaveGallery','GalleryController@ajaxSaveGallery')->name('admin-ajaxSaveGallery');
    Route::any('/ajaxEditGalleryDetails','GalleryController@ajaxEditGalleryDetails')->name('admin-ajaxEditGalleryDetails');
    Route::any('/ajaxViewGalleryDetails','GalleryController@ajaxViewGalleryDetails')->name('admin-ajaxViewGalleryDetails');
    Route::any('/ajaxSetAsCaseImage','GalleryController@ajaxSetAsCaseImage')->name('admin-ajaxSetAsCaseImage');
    Route::any('/ajaxSetAsTargetImage','GalleryController@ajaxSetAsTargetImage')->name('admin-ajaxSetAsTargetImage');
    Route::any('/ajaxSetAsSubjectImage','GalleryController@ajaxSetAsSubjectImage')->name('admin-ajaxSetAsSubjectImage');
    
	Route::any('/ajaxShowFactorGallery','FactorGalleryController@ajaxShowFactorGallery')->name('admin-ajaxShowFactorGallery');
    Route::any('/ajaxSaveFactorGallery','FactorGalleryController@ajaxSaveFactorGallery')->name('admin-ajaxSaveFactorGallery');
    Route::any('/ajaxEditFactorGalleryDetails','FactorGalleryController@ajaxEditFactorGalleryDetails')->name('admin-ajaxEditFactorGalleryDetails');
    Route::any('/ajaxViewFactorGalleryDetails','FactorGalleryController@ajaxViewFactorGalleryDetails')->name('admin-ajaxViewFactorGalleryDetails');
    Route::any('/ajaxSetAsFactorImage','FactorGalleryController@ajaxSetAsFactorImage')->name('admin-ajaxSetAsFactorImage');
	Route::any('/addFileFactorDetails','FactorGalleryController@addFileFactorDetails')->name('admin-addFileFactorDetails');
	Route::any('/ajaxDeleteFileFactorDetails','FactorGalleryController@ajaxDeleteFileFactorDetails')->name('admin-ajaxDeleteFileFactorDetails');
    Route::any('/ajaxDeleteFactorImage','FactorGalleryController@ajaxDeleteFactorImage')->name('admin-ajaxDeleteFactorImage');

	
});
    
    Route::any('/change-password', 'AdminController@change_password')->name('admin-changepassword');
	Route::get('/', 'LoginController@login')->name('admin-login');
    Route::get('/login', 'LoginController@login')->name('admin-login');
    Route::post('/login', 'LoginController@authenticate')->name('admin-login');
    Route::get('/logout', 'LoginController@logout')->name('admin-logout');
    Route::any('/profile', 'AdminController@edit_profile')->name('admin-profile');

    
    
    //Email Templates
    Route::any('/email-templates', 'EmailController@index')->name('admin-emailtemplates');
    //About section each page routes in admin section 
    
    Route::any('/edit-email-templates/{id}', 'EmailController@edit_email_template')->name('admin-edit-emailtemplates');
    //users
   
    //Route::any('/add_user', 'UserController@add_user')->name('admin-adduser');
    
    Route::any('/user-subscription-logs/{id}', 'SubscriptionLogController@user_logs')->name('admin-usersubscriptionlogs');
    
    Route::any('/register', 'AdminController@register')->name('admin-events');
    //ajax routes
    Route::any('/check_username', 'AdminController@check_username')->name('check_username');
    Route::any('/send_message', 'AdminController@send_message')->name('send_message');
    Route::any('/check_current_password', 'AdminController@check_current_password')->name('check_current_password');
	
 



});

/*------------frontend login registation---------------*/
Route::any('/forgot-password', 'ForgotController@forgot_password')->name('forgotpasswordpage');
Route::any('/reset-password', 'ForgotController@reset_password')->name('resetpassword');
Route::any('/sendverificationEmail/{id}','UserController@sendverificationEmail')->name('admin-sendverificationEmail');
Route::get('/logout', 'Auth\LoginController@logout');
 /*--------------------------------*/
 /*------------------add market from front end--------*/
Route::any('/check_email', 'MasterController@check_email')->name('check_email');
Route::any('/testcookie', 'Auth\LoginController@testCookie');

Route::get('/lang/{locale?}', [
    'as'=>'lang',
    'uses'=>'HomeController@changeLang'
]);

Route::any('/user-forgot-password', 'ForgotController@user_forgot_pass')->name('userforgotpasswordpage');
Route::any('/user-reset-password', 'ForgotController@user_reset_pass')->name('usersetpasswordpage');

Route::get('cronjob','CronJobController@index');
Route::get('cronjob/test','CronJobController@test');


 