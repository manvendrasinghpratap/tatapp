<?php
/* copied from account controller */
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
use App\AccountList;
use App\CaseList;
use App\Subject;
use App\Target;
use App\File;
use App\User;
use Session;
use Carbon\Carbon;
use DB;
class GalleryController extends AdminController
{
    public $data = array();
    /**
    * Function __construct
    *
    * constructor
    *
    * @Created Date: 29 May 2018
    * @Modified Date: 29 May 2018
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
        $this->CaseList_obj = new CaseList();
        $this->record_per_page=10;
    }

    /**
    * Function ajaxShowGallery
    *
    * function to Show Gallery
    *
    * @Created Date: 29 May 2018
    * @Modified Date: 29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxShowGallery(Request $request) {

            $account_id = $request->session()->get('account_id');
            $user_id = $request->session()->get('id');
            $data = array();

            $subject_id = (isset($request->subject_id))?$request->subject_id:'0';
            $target_id = (isset($request->target_id))?$request->target_id:'0';
            $case_id = (isset($request->case_id))?$request->case_id:'0';
            $data['case_id'] = $case_id;
            $data['subject_id'] = $subject_id;
            $data['target_id'] = $target_id;
            $data['caseList'] = CaseList::find($case_id);
            $data['fileListArray'] =  $this->File_obj->where('case_id', $case_id )->orderby('id','desc')->get();            
            $data['fileDetailsArray']   =  array();            
            return view('admin.ajax_view_gallery', ['data' => $data, 'request' => $request]);
        
    }



   /**
    * Function ajaxEditGalleryDetails 
    *
    * function to Edit Gallery Details
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxEditGalleryDetails( Request $request) {

            $account_id = $request->session()->get('account_id');
            $data = array();
            $File_id = (isset($request->file_id))?$request->file_id:'0';
            $case_id = (isset($request->case_id))?$request->case_id:'0';
            if($File_id>0){
            $FileDetailsArray = $this->File_obj->getFileDetails($File_id);

            
            $data['fileDetailsArray'] =  $FileDetailsArray;
            $case_id = $FileDetailsArray->case_id;
            
          
            $data['caseList'] = CaseList::find($case_id);
            
            //dd($data);
            
            }
            else{
           
           
            $data['fileDetailsArray']   =  array();
            $data['caseList'] = CaseList::find($case_id);
           

            }

            return view('admin.ajax_edit_gallery', ['data' => $data, 'request' => $request]);


    }

    /**
    * Function ajaxViewGalleryDetails 
    *
    * function to View Gallery Details
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxViewGalleryDetails( Request $request) {
            $account_id = $request->session()->get('account_id');
            $data = array();
            $File_id = (isset($request->file_id))?$request->file_id:'0';
            $case_id = (isset($request->case_id))?$request->case_id:'0';
            $target_id = (isset($request->target_id))?$request->target_id:'0';
            $subject_id = (isset($request->subject_id))?$request->subject_id:'0';
            if($File_id>0){
            $FileDetailsArray = $this->File_obj->getFileDetails($File_id);

            
            $data['fileDetailsArray'] =  $FileDetailsArray;
            $case_id = $FileDetailsArray->case_id;
            
            $data['target_id'] = $target_id;
            $data['subject_id'] = $subject_id;
            $data['caseList'] = CaseList::find($case_id);            
            }
            else{          
           
            $data['fileDetailsArray']   =  array();
            $data['caseList'] = CaseList::find($case_id);
            $data['target_id'] = $target_id;
            $data['subject_id'] = $subject_id;

            }

            return view('admin.ajax_view_gallery_details', ['data' => $data, 'request' => $request]);


    }


  /**
    * Function ajaxSaveFile 
    *
    * function to Save Gallery
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */


public function ajaxSaveGallery( Request $request) {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
          
          
        if($request->file_id > 0){

             //update case
                    $FileData = File::find($request->file_id);
                } else {
                    
                    $FileData = new File;
                    
                }


                  if($_FILES['profile_pic']['size']>0){
                    
                    if($request->file_id > 0){

                        if($request->profile_pic)
                            @unlink(public_path('uploads/files/' . $request->profile_pic));
                    }
                    $imagename = ImageUpload($request->profile_pic,'files');
                    $FileData->profile_pic = $imagename;
                }

                $FileData->account_id  = $account_id;
                $FileData->created_by     = $user_id;
                $FileData->case_id = $request->case_id;
                $FileData->title = $request->title;
                $FileData->description = $request->description;
                
                

                $FileData->save();

                $data['fileListArray'] =  $this->File_obj->where('case_id', $request->case_id )->orderby('id','desc')->get();

                 return view('admin.ajax_view_listGallery', ['data' => $data, 'request' => $request]);


   }




    /**
    * Function ajaxSetAsSubjectImage 
    *
    * function to Set Image as a Traget Image
    *
    * @Created Date: 19 June 2018
    * @Modified Date:  19 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
  

        public function ajaxSetAsSubjectImage( Request $request) {
            $account_id = $request->session()->get('account_id');
            $user_id = $request->session()->get('id');          
            $case_id = $request->case_id;
            $subject_id = $request->subject_id;
            $mediaUrl = $request->mediaUrl;   
            $caseList = CaseList::find($case_id);
            $subjectList = Subject::find($subject_id);
            if(isset($request->mediaUrl))
            {           
                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                ); 
                $image_url=$request->mediaUrl;
                $data = file_get_contents($image_url, false, stream_context_create($arrContextOptions));
                $filename = 'target_'.basename($request->mediaUrl);           
                if($subjectList->profile_pic)
                        @unlink(public_path('uploads/subject/' . $subjectList->profile_pic));
                $new = public_path('uploads/subject/' . $filename);
                $upload =file_put_contents($new, $data);
                $subjectList->profile_pic = $filename;
            }
            $subjectList->save();
        }

    /**
    * Function ajaxSetAsTargetImage 
    *
    * function to Set Image as a Traget Image
    *
    * @Created Date: 19 June 2018
    * @Modified Date:  19 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
  

        public function ajaxSetAsTargetImage( Request $request) {
            $account_id = $request->session()->get('account_id');
            $user_id = $request->session()->get('id');          
            $case_id = $request->case_id;
            $target_id = $request->target_id;
            $mediaUrl = $request->mediaUrl;   
            $caseList = CaseList::find($case_id);
            $targetLsit = Target::find($target_id);
            if(isset($request->mediaUrl))
            {           
                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                ); 
                $image_url=$request->mediaUrl;
                $data = file_get_contents($image_url, false, stream_context_create($arrContextOptions));
                $filename = 'target_'.basename($request->mediaUrl);           
                if($targetLsit->profile_pic)
                        @unlink(public_path('uploads/target/' . $targetLsit->profile_pic));
                $new = public_path('uploads/target/' . $filename);
                $upload =file_put_contents($new, $data);
                $targetLsit->profile_pic = $filename;
            }
            $targetLsit->save();
        }


    /**
    * Function ajaxSetAsCaseImage 
    *
    * function to Set Image as a CaseImage
    *
    * @Created Date: 19 June 2018
    * @Modified Date:  19 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
  

public function ajaxSetAsCaseImage( Request $request) {
		$account_id = $request->session()->get('account_id');
		$user_id = $request->session()->get('id');          
		$case_id = $request->case_id;
		$mediaUrl = $request->mediaUrl;   
        $caseList = CaseList::find($case_id);
		if(isset($request->mediaUrl))
		{			
			$arrContextOptions=array(
				"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			); 
			$image_url=$request->mediaUrl;
			$data = file_get_contents($image_url, false, stream_context_create($arrContextOptions));
			$filename = 'case_'.basename($request->mediaUrl);			
			if($caseList->default_pic)
					@unlink(public_path('uploads/package/' . $caseList->default_pic));
			$new = public_path('uploads/package/' . $filename);
			$upload =file_put_contents($new, $data);
			$caseList->default_pic = $filename;
		}
		$caseList->save();
   }
   
	function file_get_contents_curl( $url ) {

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

		$data = curl_exec( $ch );
		curl_close( $ch );

		return $data;

	}
    
}