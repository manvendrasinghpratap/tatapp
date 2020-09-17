<?php
/* copied from resources controller */
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
use App\resourcesList;
use App\AccountList;
use App\Resources;
use App\User;
use Session;
use Carbon\Carbon;
use DB;
class ResourcesController extends AdminController
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
        $this->Resources_obj = new Resources();
        $this->record_per_page=10;
    }


    /**
    * Function resourcesList
    *
    * function to get listing of resources List
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function resourcesList(Request $request) {


        $admin_id = $request->session()->get('id');

        $pageNo = trim($request->input('page', 1));

        $user_role_name = $request->session()->get('user_role_name');

        if ($user_role_name!="superAdmin")
            {
                 
                $account_id = $request->session()->get('account_id');
            } 
       

        
        $account_list = array();
       
           
            if ($user_role_name=="superAdmin")
            {
                
                 $account_list = AccountList::orderby('account.name','ASC')->get();

            } 


          //search fields
        if (isset($_GET) && count($_GET)>0) {
            //dd($_GET);
            $keyword = strtolower(trim($request->input('keyword'))); 
            $status = trim($request->input('status')); 
            
            if ($user_role_name=="superAdmin")
            {
                 
                 $account_id = trim($request->input('account_id'));

            }
            else{
                $account_id = $request->session()->get('account_id');
            } 
            
            
         }



        DB::enableQueryLog();
        
        $resources_list = Resources::where('status', '!=', '');
        //dd(DB::getQueryLog());
        $count = Resources::where('status', '!=','');
        //dd_my($resources_list);
        
        if(isset($status) && $status!="")
        {
            $resources_list->where('status',$status);
        }
        if(isset($account_id) && $account_id!="")
                {
                    $resources_list->where('account_id',$account_id);
                }

        if(isset($keyword) && $keyword!="")
        {


            $resources_list->Where(function ($query) use ($keyword) {
                    $query->orwhere('name', 'rlike', $keyword)
                    ->orwhere('email', 'rlike', $keyword)
                  ->orwhere('phone', 'rlike', $keyword);
                });

            
        }
        $resources_list = $resources_list->orderby('id','desc');

       
        $this->data['records'] = $resources_list->paginate($this->record_per_page);
         //dump(DB::getQueryLog());
    
         //dd($this->data['records']->toArray());
        return view('resources.resources_mng', ['data' => $this->data, 'pageNo' => @$pageNo, 'record_per_page' => $this->record_per_page,'request'=>$request,'count' => $count, 'account_list'=>$account_list]);
    }


    

    /**
    * Function add_resources
    *
    * function to add resources
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function add_resources(Request $request,$id = null){

        $admin_id = $request->session()->get('id');
        $account_id = $request->session()->get('account_id');
        $user_id = $request->session()->get('id');
       // dd($id);


        $data = array();
        $data = Resources::find($id);


        $user_role_name = $request->session()->get('user_role_name');
        $account_list = array();
       
           
            if ($user_role_name=="superAdmin")
            {
                
                 $account_list = AccountList::orderby('account.name','ASC')->get();

            } 
     //dd($account_list);
     if ($request->all()) { //post
       //dd($request->all());
            $account_id = $request->account_id; 
            $name = $request->name; 
            $email = $request->email; 
            $website    = $request->website;
            $contact_person = $request->contact_person; 
            $organisation = $request->organisation; 
            $phone = $request->phone; 
            $notes = $request->notes; 
            $status = $request->status; 
           
           

             $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required',
                    'website' => 'required',
                    'contact_person' => 'required',
                    'organisation' => 'required',
                    'phone' => 'required'
                    
                ]);
            
            if ($validator->fails()) 
            {
                
                    return redirect()->route('admin-add-resources')
                            ->withErrors($validator)
                            ->withInput();
                
            }
            else {
                if(!empty($request->id)){
                    $Resources = Resources::find($request->id);
                    $Resources->updated_at  = date("Y-m-d");
                    $msg = 'Resource has been updated successfully.';
                }else{
                    $Resources = new Resources;
                    $Resources->created_at  = date("Y-m-d");
                    $Resources->created_by  = $user_id;
                    $msg = 'Resource has been added successfully.';
                }
                

                
                $Resources->account_id     = $account_id;
                $Resources->name           = $name;
                $Resources->email          = $email;
                $Resources->website        = $website;
                $Resources->contact_person = $contact_person;
                $Resources->organisation = $organisation;
                $Resources->phone          = $phone;
                $Resources->notes          = $notes;
                $Resources->status         = $status;
              
                

                //dd($account_list);
                $Resources->save();

                
                $request->session()->flash('add_message', $msg);
                return redirect()->route('admin-resources-list');
                
            }
        }
     
    return view('resources.add_resources',['data'=>$data, 'account_list'=>$account_list]);
  }

   

    



     /**
    * Function resources_delete
    *
    * function to delete resources from the list
    *
    * @Created Date: 29 May, 2018
    * @Modified Date: 29 May, 2018
    * @Created By: Subhendu Das
    * @Modified By: Subhendu Das
    * @param  ARRAY
    * @return STRING
    */
    public function resources_delete($resource_id, Request $request) {
        if ($resource_id) {
            $resp = Resources::where('id', '=', $resource_id)->delete();
            if($resp){
                $msg = 'Resource has been deleted successfully.';
                $request->session()->flash('message', $msg);
            }
        }
       //return redirect()->route('admin-factor-list');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }


    
}