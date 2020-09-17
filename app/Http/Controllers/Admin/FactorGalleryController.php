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
use App\FactorList;
use App\Subject;
use App\Target;
use App\FactorFile;
use App\User;
use Session;
use Carbon\Carbon;
use DB;
class FactorGalleryController extends AdminController
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
        $this->File_obj = new FactorFile();
        $this->factorList_obj = new FactorList();
        $this->record_per_page=10;
    }

    /**
    * Function ajaxShowFactorGallery
    *
    * function to Show FactorGallery
    *
    * @Created Date: 29 May 2018
    * @Modified Date: 29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxShowFactorGallery(Request $request) {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
            $data = array();
            
            $factor_id = (isset($request->factor_id))?$request->factor_id:'0';
			 $case_id = (isset($request->case_id))?$request->case_id:'0';
            $data['factor_id'] = $factor_id;
			 $data['case_id'] = $case_id;
            $data['factorList'] = FactorList::find($factor_id);
            //->where('created_by', $user_id )
            $data['fileListArray'] =  $this->File_obj->where('factor_id', $factor_id )->orderby('id','desc')->get();
            
            $data['fileDetailsArray']   =  array();
            

          

        return view('admin.ajax_view_factor_gallery', ['data' => $data, 'request' => $request]);
        
    }



   /**
    * Function ajaxEditFactorGalleryDetails 
    *
    * function to Edit FactorGallery Details
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxEditFactorGalleryDetails( Request $request) {

            $account_id = $request->session()->get('account_id');
            $data = array();
            $File_id = (isset($request->file_id))?$request->file_id:'0';
            $factor_id = (isset($request->factor_id))?$request->factor_id:'0';
          
            


            if($File_id>0){
            $FileDetailsArray = $this->File_obj->getFileDetails($File_id);

            
            $data['fileDetailsArray'] =  $FileDetailsArray;
            $factor_id = $FileDetailsArray->factor_id;
            
          
            $data['factorList'] = FactorList::find($factor_id);
            
            //dd($data);
            
            }
            else{
           
           
            $data['fileDetailsArray']   =  array();
            $data['factorList'] = FactorList::find($factor_id);
           

            }
			$data['factor_id']=$factor_id;
            return view('admin.ajax_edit_factor_gallery', ['data' => $data, 'request' => $request]);


    }

    /**
    * Function ajaxViewFactorGalleryDetails 
    *
    * function to View FactorGallery Details
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function ajaxViewFactorGalleryDetails( Request $request) {

            $account_id = $request->session()->get('account_id');
            $data = array();
            $File_id = (isset($request->file_id))?$request->file_id:'0';
            $factor_id = (isset($request->factor_id))?$request->factor_id:'0';
          
            


            if($File_id>0){
            $FileDetailsArray = $this->File_obj->getFileDetails($File_id);

            
            $data['fileDetailsArray'] =  $FileDetailsArray;
            $factor_id = $FileDetailsArray->factor_id;
            
          
            $data['factorList'] = FactorList::find($factor_id);
            
            //dd($data);
            
            }
            else{
           
           
            $data['fileDetailsArray']   =  array();
            $data['factorList'] = FactorList::find($factor_id);
           

            }

            return view('admin.ajax_view_factor_gallery_details', ['data' => $data, 'request' => $request]);


    }


  /**
    * Function ajaxSaveFile 
    *
    * function to Save FactorGallery
    *
    * @Created Date: 13 June 2018
    * @Modified Date:  13 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */


public function ajaxSaveFactorGallery( Request $request) {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
          
          
        if($request->file_id > 0){

             //update factor
                    $FileData = FactorFile::find($request->file_id);
                } else {
                    
                    $FileData = new FactorFile;
                    
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
                $FileData->factor_id = $request->factor_id;
                $FileData->title = $request->title;
                $FileData->description = $request->description;
                
                

                $FileData->save();
				
                $data['fileListArray'] =  $this->File_obj->where('factor_id', $request->factor_id )->orderby('id','desc')->get();

                 return view('admin.ajax_view_listFactorGallery', ['data' => $data, 'request' => $request]);


   }




    /**
    * Function ajaxSetAsFactorImage 
    *
    * function to Set Image as a FactorImage
    *
    * @Created Date: 19 June 2018
    * @Modified Date:  19 June 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
  

public function ajaxSetAsFactorImage( Request $request) {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
          
          $factor_id = $request->factor_id;
          $mediaUrl = $request->mediaUrl;

          

             //update factor
                    $factorList = FactorList::find($factor_id);
               

                  
                if(isset($request->mediaUrl))
                {
				
                    $image_url=$request->mediaUrl;
                    //$data = file_get_contents($image_url);


					$arrContextOptions=array(
					"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
					),
					);  

					//$image_url=$request->mediaUrl;
					$data = file_get_contents($image_url, false, stream_context_create($arrContextOptions));



                    $filename = 'factor_'.basename($request->mediaUrl);
                    
                    if($factorList->default_pic)
                            @unlink(public_path('uploads/package/' . $factorList->default_pic));
                    


                $new = public_path('uploads/package/' . $filename);
				/**/

                    $upload =file_put_contents($new, $data);
                    $factorList->default_pic = $filename;
                $factorList->save();
                }

                
                
              
                // dd($factorList);

               


   }
   
   

public function addFileFactorDetails( Request $request) {

        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
          $factor_id = $request->factor_id;
          $mediaUrl = $request->mediaUrl;

          /* if($request->file_id > 0){

             //update factor
                    $FileData = FactorFile::find($request->file_id);
                } else {
                    
                    
                    
                }*/
				
			$title = $request->title;
            $description = $request->description;
			 $profile_pic = $request->profile_pic;
			if(isset($request->file_select)&&count($request->file_select)>0){
			
				foreach($request->file_select as $k=>$file_select){
				 $fileListArray =  FactorFile::where('case_file_id','=', $file_select)->where('factor_id', '=', $factor_id)->count();
				if(!$fileListArray){
				echo $file_select;
				
				  	$iid = DB::table('factor_files')->insertGetId(
					[
						'account_id' => $account_id, 
						'created_by' => $user_id,
						'profile_pic' => $profile_pic[$k], 
						'description' => $description[$k],
						'title' => $title[$k],
						'factor_id' => $factor_id,	
						'case_file_id' => $file_select						
					]
					);
					
				}
               }
			   die;
              }  


   }
  
public function ajaxDeleteFileFactorDetails( Request $request) {

        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
          $factor_id = $request->factor_id;
          $mediaUrl = $request->mediaUrl;

			$title = $request->title;
            $description = $request->description;
			if(isset($request->file_select)&&count($request->file_select)>0){
				foreach($request->file_select as $k=>$file_select){
				 $fileListArray =  FactorList::where('case_file_id','=', $file_select)->where('factor_id', '=', $factor_id);
				 if($fileListArray){
					$resp = FactorFile::where('case_file_id','=', $file_select)->where('factor_id', '=', $factor_id)->delete();
				}
               }
              }  

               
   }
public function ajaxDeleteFactorImage( Request $request) {
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
          
          $file_id = $request->file_id;
          $mediaUrl = $request->mediaUrl;

		
                  
                if(isset($request->mediaUrl)&&!empty($file_id))
                {
                   $image_url=$request->mediaUrl; 
					$FileData = FactorFile::find($file_id);
                    if($FileData->profile_pic&&$FileData->case_file_id==''){
                        @unlink(public_path('uploads/files/' . $FileData->profile_pic));
						$resp = FactorFile::where('id', '=', $file_id)->delete();
					 }elseif($FileData->case_file_id!=''){
						$resp = FactorFile::where('id', '=', $file_id)->delete();
					 }
           
                }



   }
    
}