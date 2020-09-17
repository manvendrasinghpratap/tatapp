<?php
/* copied from account controller */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use PDF;
use Auth;
use App\Site;
use App\Http\Middleware\ResizeImageComp;
use Validator;
use Mail;
use Illuminate\Support\Facades\Hash;
Use Config;
use App\AccountList;
use App\IncidentType;

use App\Subject;
use App\Target;
use App\File;
use App\Forum;
use App\User;
use Session;
use Carbon\Carbon;
use DB;
class IncidentTypeController extends AdminController
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
		$this->record_per_page=10;
		
		
		
		
    }
    /**
    * Function index
    *
    * function to get listing of plans
    *
    * @Created Date: 29 May 2018
    * @Modified Date: 29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function index(Request $request) {
		
		
		
         $admin_id = $request->session()->get('id');
		
		
		
		
		
        $user_role_name = $request->session()->get('user_role_name');
        
        if ($user_role_name!="superAdmin")
            {
                 
                $account_id = $request->session()->get('account_id');
            } 
        $pageNo = trim($request->input('page', 1));
        
        //search fields
        if (isset($_GET) && count($_GET)>0) {
            //dd($_GET);
            $keyword = strtolower(trim($request->input('keyword'))); 
            $status = trim($request->input('status')); 
            $user_type_id = trim($request->user_type_id);
            if ($user_role_name=="superAdmin")
            {
                 
                 $account_id = trim($request->input('account_id'));

            }
            else{
                $account_id = $request->session()->get('account_id');
            } 
            
            
         }
        
        
        $account_list = array();
           
            if ($user_role_name=="superAdmin")
            {
                 
                 $account_list = AccountList::get();

            } 
         DB::enableQueryLog();

     /*    $incident = DB::table('incident')->orWhereNull('incident.deleted_at')
		->select('incident.id','incident.title','incident.description','incident.incident_datetime','incident_type.type')
		->join('incident_type','incident_type.id','=','incident.type')->get(); */

		
		
		 $incidentArray = IncidentType::select('*')
        ->orWhereNull('incident_type.deleted_at');
        
  
            if(isset($account_id) && $account_id!="")
                {
                    $incidentArray->where('incident_type.account_id',$account_id);
                }


        
        if(isset($keyword) && $keyword!="")
        {
             $incidentArray->Where(function ($query) use ($keyword) {
                    $query->orwhere('incident_type.type', 'rlike', $keyword);
                });
        }

		$incidentArray = $incidentArray->orderby('incident_type.created_at','desc');


        $this->data['records'] = $incidentArray->paginate($this->record_per_page);
       

         $queries = DB::getQueryLog();
    //dd_my($queries);
        return view('admin.incidenttype', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request, 'account_list'=>$account_list]);
    }

	/**
    * Function edit_incident_type
    *
    * function to edit incident type
    *
    * @Created Date: 30 december 2018
    * @Modified Date: 
    * @param  ARRAY
    * @return STRING
    */
     public function edit_incidenttype(Request $request, $id = '') {
        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');

        $data = array();
        $data = IncidentType::find($id);
       

        //dd($data);
        if ($request->all()) { //post

           //dd($request->all()); 
          
            $description = $request->description; 
			$type = $request->type;
			
            
            
            
                if ($id) {
            
                //Validate the input
                $validator = Validator::make($request->all(), [
                   
                    'description' => 'required',
                    'type' => 'required'
                   
                   
                    
                    
                ]);
                }
                else {
                //Validate the input
                $validator = Validator::make($request->all(), [
                   
                    'description' => 'required',
                    'type' => 'required'
                   
                ]);
            }
            if ($validator->fails()) 
            {
				
                    return redirect()->route('admin-incidenttypeList')
                            ->withErrors($validator)
                            ->withInput();
                
            }
            else {

                if ($id) { //update case
                    $incidenttype = IncidentType::find($id);
                } else {
                    
                    $incidenttype = new IncidentType;
                    
                }


                 

                $incidenttype->account_id  = $account_id;
                $incidenttype->user_id     = $user_id;
                
                $incidenttype->description = $description;
                $incidenttype->type = $type;
				
				
                //  dd($caseList);
                
				
                if ($id) {
					$incidenttype->updated_at =date('Y-m-d H:i:s');
					$incidenttype->save();
                    $msg = 'Incident has been updated successfully.';
                    $request->session()->flash('add_message', $msg);
                  //return view('admin.add_case', ['request' => $request, 'data' => $caseList, 'userList' =>  $userList ]);
          
                  return redirect()->route('admin-incidenttypeList');
                }
                else {
					
					 $incidenttype->created_at = date('Y-m-d H:i:s');
					
					 $incidenttype->save();
					
                    
                    
                    $msg = 'Incident has been added successfully.';
                    $request->session()->flash('add_message', $msg);
                    return redirect()->route('admin-incidenttypeList');
                }
            }
        }
        else {
            return view('admin.add_incidenttype', ['data' => $data, 'request' => $request]);
        }
    }
    /**
    * Function delete_incident 
    *
    * function to delete incident
    *
    * @Created Date: 29 May 2018
    * @Modified Date:  29 May 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function delete_incidenttype( Request $request) {
           
            
             $incidenttype_id = (isset($request->incidenttype_id))?$request->incidenttype_id:'0';
           
            if($incidenttype_id>0){

				 DB::table('incident_type')
					  ->where('id', $incidenttype_id)
					  ->update(
					[
						
						'deleted_at' => date("Y-m-d h:i:s") 
					]
				  );
				  $msg = 'Incident type has been deleted successfully.';
                    $request->session()->flash('add_message', $msg);
			}
			else{
					$msg = 'Please try again to delete Incident type';
                    $request->session()->flash('add_message', $msg);
				
			}
    }

   

   

    
    
}