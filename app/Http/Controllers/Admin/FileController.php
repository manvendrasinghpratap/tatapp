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
use App\File;
use App\CaseList;
use App\AccountList;
use App\Accounttask;
use App\FactorList;
use App\User;
use Session;
use Carbon\Carbon;
use DB;
use App\Group;
Use App\CaseToGroup;
Use App\UploadFiles;
use App\Incident;
use App\IncidentFile;

class FileController extends AdminController
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
        $this->File_obj = new File();
        $this->record_per_page=10;
    }
   
    /**
    * Function ajaxSaveFile 
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
public function index(Request $request){
        $admin_id = $request->session()->get('id');
        $user_role_name = $request->session()->get('user_role_name');
        
        $account_id = $request->session()->get('account_id');
        $pageNo = trim($request->input('page', 1));

        $user_id = $request->session()->get('id');     

        $extArray = array('png','jpg','jpeg','PNG','JPG','JPEG');
        DB::enableQueryLog();
        $user_group = $request->session()->get('user_group');
       
        $fileListArray = UploadFiles::where('account_id','=',$account_id)->orderby('created_at','desc')->WhereNull('deleted_at');
        
        /**
        * @Modified By: Shweta Trivedi * @Modified Date: 17-02-20
        * @Disciption : Globle and Super Admin user can access all cases but Other user can manage and view Case based on their group
        */
       
        $this->data['records'] = $fileListArray->paginate($this->record_per_page);
        //echo '<pre>'; print_r($this->data['records']); echo '</pre>';
        $queries = DB::getQueryLog();
        return view('admin.file_mng', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request,'extArray'=>$extArray]);
}

    public function add_files(Request $request, $id = ''){
        $type = 'admin';
         $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $imagenotuploadedmsg = '';
        $user_id = $request->session()->get('id');
        $extArray = array('png','jpg','jpeg','PNG','JPG','JPEG');
        $data = array();
        $data = UploadFiles::find($id);
        if ($request->all()) { //post
            if ($request->default_pic) 
            {
               // echo '<pre>'; print_r($request->file('default_pic')->getClientOriginalName()); echo '</pre>'; 
                $picSize = round($request->file('default_pic')->getSize()/1024000,3);  
                $imagename = ImageUpload($request->default_pic,'files');
                $uploadFiles = new UploadFiles; 
                $uploadFiles->account_id        = $account_id;
                $uploadFiles->title             = $request->get('title');
                $uploadFiles->description       = $request->get('description');
                $uploadFiles->originalfilename  = $request->file('default_pic')->getClientOriginalName();
                $uploadFiles->newfilename       = $imagename;
                $uploadFiles->size              = $picSize;
                $uploadFiles->save();
                $msg = 'Files has been uploaded successfully.';
                $request->session()->flash('add_message', $msg);                
                return redirect()->route('admin-filelist');
            }            
        }
        else {
            return view('admin.add_file', ['data' => $data, 'request' => $request,'type'=>$type,'extArray'=>$extArray]);
        }
    }

     public function edit_files(Request $request, $id = ''){
        $admin_id = $request->session()->get('id');
        $type = 'edit';
        $account_id = $request->session()->get('account_id');
        $imagenotuploadedmsg = '';
        $user_id = $request->session()->get('id');
        $data = array();
        $data = UploadFiles::find($id);
        $extArray = array('png','jpg','jpeg','PNG','JPG','JPEG');
        $msgfile = '';
        if ($request->all()) { //post
            if ($request->id) { //update case
                    $uploadFiles = UploadFiles::find($request->id);
                } else {                    
                    $uploadFiles = new UploadFiles;
                    
                }
                $uploadFiles->title             = $request->get('title');
                $uploadFiles->description       = $request->get('description');
                if ($request->default_pic) 
                {
                    @unlink(public_path('uploads/files/' . $uploadFiles->newfilename));
                    $picSize = round($request->file('default_pic')->getSize()/1024000,3);  
                    $imagename = ImageUpload($request->default_pic,'files');                
                    $uploadFiles->originalfilename  = $request->file('default_pic')->getClientOriginalName();
                    $uploadFiles->newfilename       = $imagename;
                    $uploadFiles->size              = $picSize;
                    $msgfile = ' and uploaded ';
                }  
                $uploadFiles->save();
                $msg = 'Files records has been Updated '. $msgfile .' successfully.';
                $request->session()->flash('add_message', $msg);                
                return redirect()->route('admin-filelist');

        }
        else {
            return view('admin.edit_file', ['data' => $data, 'request' => $request,'extArray'=>$extArray,'type'=>$type]);
        }
    }
     public function view_files(Request $request, $id = ''){
        $admin_id = $request->session()->get('id');
        $type = 'view';
        $account_id = $request->session()->get('account_id');
        $imagenotuploadedmsg = '';
        $user_id = $request->session()->get('id');
        $data = array();
        $data = UploadFiles::find($id);
        $extArray = array('png','jpg','jpeg','PNG','JPG','JPEG');
            return view('admin.add_file', ['data' => $data, 'request' => $request,'extArray'=>$extArray,'type'=>$type]);
    }

    public function delete_file(Request $request, $id = ''){
            $uploadFiles = UploadFiles::where('id', '=', $request->id)->delete();
            //$uploadFiles->where('id', '=', $request->id)->delete();
             $msg = 'Files records has been Deleted  successfully.';
                    $request->session()->flash('add_message', $msg);                
                    return redirect()->route('admin-filelist');

    }
    public function caseAndFilesMapped(Request $request, $id = ''){
        $account_id = $request->session()->get('account_id');
       $admin_id = $request->session()->get('id');

       $group_id = $this->getUsersGroupIds($request);
        $admin_id = $request->session()->get('id');
        $incidentLists = Incident::where('account_id',$account_id); 
        $incidentLists->whereHas('incidentGroup', function ($q) use ($group_id) {$q->whereIn('group_id',$group_id);});
        $caseListArray  = $incidentLists->pluck('title','id');



        //$caseListArray = CaseList::where('account_id',$account_id)->pluck('title','id');   

        $admin_id = $request->session()->get('id');
        $type = 'add';
        $account_id = $request->session()->get('account_id');
        $imagenotuploadedmsg = '';
        $user_id = $request->session()->get('id');
        $data = array();
        $data = UploadFiles::find($id);
        $extArray = array('png','jpg','jpeg','PNG','JPG','JPEG');

        if($request->all()){
            if( !empty($request->existingcaseId) ) {
                $existingcaseIdArray = explode(',',$request->existingcaseId);
                if(count($existingcaseIdArray)>0){
                    foreach($existingcaseIdArray as $key){
                        File::where('account_id', $account_id)->where('case_id', $key)->where('file_id',$request->id)->delete();
                    }
                }
            }

             $data = UploadFiles::find($request->id);
            if(!empty($request->caseid)){
                foreach(array_filter($request->caseid) as $value){

                        $files = new File;
                        $files->account_id         =  $data->account_id ;
                        $files->case_id            =  $value;
                        $files->file_id            =  $request->id;
                        $files->title              =  $data->title ;
                        $files->description        =  $data->description ;
                        $files->profile_pic        =  $data->newfilename ;
                        $files->created_by         =  $admin_id ;
                        $files->save();
                }
            }          
            $msg = 'Files and Cases are linked successfully.';
                $request->session()->flash('add_message', $msg);                
                return redirect()->route('admin-filelist');
        }
            return view('admin.add_file_case', ['data'=>$data,'request' => $request,'extArray'=>$extArray,'type'=>$type,'caseListArray'=>$caseListArray]);

}

    public function getUsersGroupIds(Request $request){
        $account_id = $request->session()->get('account_id'); 
        $user_id = $request->session()->get('id');
        $group = Group::with(['userGroup'])->with('accountGroup') ;
        $user_id = $request->session()->get('id');
        if($request->session()->get('user_role_id') > 1 )
        {
            $group->whereHas('accountGroup', function ($q) use ($account_id) {$q->where('account_id',$account_id);});
            if($request->session()->get('user_role_id') > 2 )
            {       
            $group->whereHas('userGroup', function ($q) use ($user_id) {$q->where('user_id',$user_id);});
            }
            
        }
        $group = $group->orderBy('created_at', 'desc')->get();
        if(!empty($group) && (count($group)>0)){
            foreach($group as $innerKey=>$innerValue){
                if(!empty($innerValue['userGroup']) ){
                    foreach($innerValue['userGroup'] as $inKey=>$invalue){
                        $userBelongToLoginUserGroup[] = $invalue->user_id;
                        $groupids[] =  $invalue->group_id;
                    }
                } 
                 
            }
            $groupids = $groupidds = array_unique($groupids);
            if(!empty($request->input('group_id'))){
                $groupids = array($request->input('group_id'));
            }

        }
        return $groupids;
}

    public function incidentAndFilesMapped(Request $request, $id = ''){
        $account_id = $request->session()->get('account_id'); 
        $account_list = array();
        $group_id = $this->getUsersGroupIds($request);
        //dd($group_id);
        $admin_id = $request->session()->get('id');
        $incidentLists = Incident::where('account_id',$account_id); 
        $incidentListArray  = $incidentLists->whereHas('incidentGroup', function ($q) use ($group_id) {$q->whereIn('group_id',$group_id);})->pluck('title','id');

        $admin_id = $request->session()->get('id');
        $type = 'add';
        $account_id = $request->session()->get('account_id');
        $imagenotuploadedmsg = '';
        $user_id = $request->session()->get('id');
        $data = array();
        $data = UploadFiles::find($id);
        $extArray = array('png','jpg','jpeg','PNG','JPG','JPEG');
        if($request->all()){
            if( !empty($request->existingIncidentId) ) {
                $existingincidentIdArray = explode(',',$request->existingIncidentId );
                if(count($existingincidentIdArray)>0){
                    foreach($existingincidentIdArray as $key){
                        IncidentFile::where('account_id', $account_id)->where('incident_id', $key)->where('file_id',$request->id)->delete();
                    }
                }
            }
             $data = UploadFiles::find($request->id);
            if(!empty($request->incidentid)){
                foreach(array_filter($request->incidentid) as $value){                        
                        $files = new IncidentFile;
                        $files->account_id          =  $data->account_id ;
                        $files->incident_id         =  $value;
                        $files->file_id             =  $request->id;
                        $files->title               =  $data->title ;
                        $files->description         =  $data->description ;
                        $files->profile_pic         =  $data->newfilename ;
                        $files->created_by          =  $admin_id;
                        $files->save();
                }
            }          
            	$msg = 'Files and Incident are linked successfully.';
                $request->session()->flash('add_message', $msg);                
                return redirect()->route('admin-filelist');
        }
            return view('admin.add_file_incident', ['data'=>$data,'request' => $request,'extArray'=>$extArray,'type'=>$type,'incidentListArray'=>$incidentListArray]);

}

    public function ajaxSaveFile( Request $request) {
        $return = 0;
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');  
        if($request->file_id > 0){
             //update case
                $FileData = File::find($request->file_id); 
                if( !empty($FileData['file_id']) ){
                    $uploadFiles = UploadFiles::findorfail ($FileData['file_id']);
                    if(empty($uploadFiles)){
                        $uploadFiles = new UploadFiles;
                    }
                }else{
                $uploadFiles = new UploadFiles;                    
                }

                } else {
                    $FileData = new File;
                    $uploadFiles = new UploadFiles;
                }
                if(isset($_FILES['profile_pic']['size'])&&$_FILES['profile_pic']['size']>0)
                  {                    
                    if($request->file_id > 0){
                        if($request->profile_pic)
                            @unlink(public_path('uploads/files/' . $request->profile_pic));
                    }
                    $imagename = ImageUpload($request->profile_pic,'files');
                    $FileData->profile_pic = $imagename;
                    $picSize = round($_FILES['profile_pic']['size']/1024000,3); 
                    $uploadFiles->originalfilename  = $_FILES['profile_pic']['name'];
                    $uploadFiles->newfilename       = $imagename;
                    $uploadFiles->size              = $picSize; 
                  }
                //$imagename = ImageUpload($request->default_pic,'files');
                
                $uploadFiles->account_id        = $account_id;
                $uploadFiles->title             = $request->title;
                $uploadFiles->description       = $request->description;
               
                $uploadFiles->save();
                $file_id = $uploadFiles->id;
                
                $FileData->account_id  = $account_id;
                $FileData->created_by     = $user_id;
                $FileData->case_id = $request->case_id;
                $FileData->title = $request->title;
                $FileData->description = $request->description;
                $FileData->file_id = $file_id;
               if( $FileData->save()) {
                  $return = 1 ;
               }
                echo $return;
            }


    public function getFileDetail( Request $request,$caseId) {  
        $account_id = $request->session()->get('account_id');
            $data = array();
           // $File_id = (isset($request->file_id))?$request->file_id:'0';
            $case_id = $caseId;
            $data['fileListArray'] =  $this->File_obj->where('case_id', $case_id )->orderby('id','desc')->get();
            $data['caseList'] = CaseList::find($case_id);
        
        return view('admin.add_view_file', ['data' => $data, 'request' => $request,'caseId'=>$caseId]);

    }
    
    
    /**
    * Function ajaxGetFileDetails 
    *
    * function to get File Details
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxGetFileDetails( Request $request) {
            $account_id = $request->session()->get('account_id');
            $data = array();
            $File_id = (isset($request->file_id))?$request->file_id:'0';
            $case_id = (isset($request->file_id))?$request->case_id:'0';
            $data['fileListArray'] =  $this->File_obj->where('case_id', $case_id )->orderby('id','desc')->get();


            if($File_id>0){
            $data['fileDetailsArray']   =  array();
            $data['caseList'] = CaseList::find($case_id);
            }
            else{
            $data['fileDetailsArray']   =  array();
            $data['caseList'] = CaseList::find($case_id);
            }

            return view('admin.ajax_view_file', ['data' => $data, 'request' => $request]);
    }

 /**
    * Function ajaxGetFactorFileDetails 
    *
    * function to get File Details
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxGetFactorFileDetails( Request $request) {
            $account_id = $request->session()->get('account_id');
            $data = array();
          

			$data['factor_id'] = (isset($request->factor_id))?$request->factor_id:'0';
			$case_id = (isset($request->case_id))?$request->case_id:'0';
			
			
			  $data['fileListArray'] = DB::select( DB::raw('select `files`.*, `factor_files`.`case_file_id` as `case_file_id`,`factor_files`.`factor_id` from `files` left join `factor_files` on `files`.`id` = `factor_files`.`case_file_id` where `files`.`case_id` = "'.$case_id.'" and `files`.`id` not in (select `factor_files`.`case_file_id` as `case_file_id` from `files` left join `factor_files` on `files`.`id` = `factor_files`.`case_file_id` where `files`.`case_id` = "'.$case_id.'" and `factor_files`.`factor_id` = "'.$data['factor_id'].'" group by `files`.`id` order by `files`.`id` desc)  group by `files`.`id` order by `files`.`id` desc'));
			 /* $data['fileListArray'] =  File::Join('factor_files', 'files.id', '!=', '')
        ->select('files.*', 'factor_files.case_file_id as case_file_id')
		->where('files.case_id', $case_id)
		->where('factor_files.factor_id','!=', $data['factor_id'])
		->groupBy('files.id')
        ->orderby('files.id','desc')
        ->get();*/
            $data['fileDetailsArray']   =  array();
            $data['caseList'] = CaseList::find($case_id);
            /* $data['caseList'] =$this->File_obj::Join('factor_files', 'case_list.id', '=', 'factor_files.case_file_id')
        ->select('case_list.*', 'factor_files.case_file_id as case_file_id')
        ->orderby('case_list.id','desc')
        ->get();*/

            return view('admin.ajax_factor_view_file', ['data' => $data, 'request' => $request]);
    }
	
      /**
    * Function ajaxAssignFileDetails 
    *
    * function to ajaxAssignFileDetails
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxAssignFileDetails( Request $request) {
           
            
            $File_id = (isset($request->file_id))?$request->file_id:'0';
            if($File_id>0){
            $taskDetailsArray = $this->File_obj->getFileDetails($File_id);
            echo json_encode($taskDetailsArray);
            
            }
    }


    /**
    * Function ajaxEditFileDetails 
    *
    * function to Edit File Details
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxEditFileDetails( Request $request) {
            $account_id = $request->session()->get('account_id');
            $data = array();
            $File_id = (isset($request->file_id))?$request->file_id:'0';
            $case_id = (isset($request->case_id))?$request->case_id:'0';
            if($File_id>0){
            $FileDetailsArray = $this->File_obj->getFileDetails($File_id);
            $data['fileDetailsArray'] =  $FileDetailsArray;
            $case_id = $FileDetailsArray->case_id; 
            $data['caseList'] = CaseList::find($case_id);
            }
            else{  
            $data['fileDetailsArray']   =  array();
            $data['caseList'] = CaseList::find($case_id);
            }
            return view('admin.ajax_edit_file', ['data' => $data, 'request' => $request]);
    }


    
    /**
    * Function ajaxDeleteFile 
    *
    * function to Delete File
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxDeleteFile( Request $request) {
		
            $file_id = (isset($request->file_id))?$request->file_id:'0';
            if($file_id>0){
              DB::table('files')
              ->where('id', '=', $file_id)
              ->delete();
              $data['fileListArray'] =  $this->File_obj->where('case_id', $request->case_id )->orderby('id','desc')->get();
			  
			  return redirect()->route('admin-getFileDetail',[$request->case_id]);
              //return view('admin.ajax_view_listfile', ['data' => $data, 'request' => $request]);
            }
    } 
    
public function casefileist(Request $request){
        $admin_id = $request->session()->get('id');
        $user_role_name = $request->session()->get('user_role_name');
        
        $account_id = $request->session()->get('account_id');
        $pageNo = trim($request->input('page', 1));

        $user_id = $request->session()->get('id');     

        $extArray = array('png','jpg','jpeg','PNG','JPG','JPEG');
        DB::enableQueryLog();
        $user_group = $request->session()->get('user_group');
       
        $fileListArray = File::with(['cases'])->where('account_id','=',$account_id)->orderby('created_at','desc')->WhereNull('deleted_at');
        
      
        $this->data['records'] = $fileListArray->paginate($this->record_per_page);
        $queries = DB::getQueryLog();
        return view('admin.case_file_mng', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request,'extArray'=>$extArray]);
}

public function incidentfilelist(Request $request){

        $admin_id = $request->session()->get('id');
        $user_role_name = $request->session()->get('user_role_name');
        
        $account_id = $request->session()->get('account_id');
        $pageNo = trim($request->input('page', 1));

        $user_id = $request->session()->get('id');     

        $extArray = array('png','jpg','jpeg','PNG','JPG','JPEG');
        DB::enableQueryLog();
        $user_group = $request->session()->get('user_group');
       
        $fileListArray = UploadFiles::where('account_id','=',$account_id)->orderby('created_at','desc')->WhereNull('deleted_at');
        $this->data['records'] = $fileListArray->paginate($this->record_per_page);
        $queries = DB::getQueryLog();
        return view('admin.incident_file_mng', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request,'extArray'=>$extArray]);
}

    
}