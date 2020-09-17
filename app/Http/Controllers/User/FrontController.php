<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Range;
use App\Market;
use App\Static_pages;
use App\State;
use App\MarketDate;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MasterRepository;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Session;

class FrontController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct(MasterRepository $master)
  {
      $this->master=$master;
      $this->middleware('auth');
  }
  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $id = Auth::user()->id;

    return view('users.dashboard');
  }
  /**
  * Function add_market
  *
  * function to add market for user
  *
  * @Created Date: 07 Nov, 2017
  * @Modified Date: 31 Jan, 2018
  * @Created By: Ammar Zaidi
  * @Modified By: Diksha S
  * @param  ARRAY
  * @return STRING
  */
  public function add_market(Request $request)
  {
    $result=$this->master->rangelist();
    $states = State::all();
    
    if($request->input()){

      $userid = Auth::user()->id;

      $senddata = $request->input();

      $senddata['commision_fee_doc'] = $request->file('commision_fee_doc');
      $senddata['market_rules'] = $request->file('market_rules');

      $validator = $this->master->validation($senddata);
      
      if ($validator->fails()) {
        return redirect()->route('user-addmarket')
                ->withErrors($validator)
                ->withInput();
          
      }
      $return = $this->master->add_market($senddata,$userid);
      if($return){
        return redirect()->route('user-markets');
      }
    }
    else{
      return view('users.add_market',['ranges'=>$result,'states'=>$states]);
    }
  }
  /**
  * Function changepassword
  *
  * function to CHANGE PASSWORD for user
  *
  * @Created Date: 07 Nov, 2017
  * @Modified Date: 31 Jan, 2018
  * @Created By: Ammar Zaidi
  * @Modified By: Diksha S
  * @param  ARRAY
  * @return STRING
  */
  public function changepassword(Request $request)
  {
    if($request->input()){

      $validator = Validator::make($request->input(), [
        'current-password' => 'required',
        'password' => 'required|same:password',
        'password_confirmation' => 'required|same:password',     
      ]);

      if ($validator->fails()) {

        return redirect()->route('user-changepassword')
                                        ->withErrors($validator)
                                        ->withInput();
      }
      else
      {  
        $current_password = Auth::User()->password; 
        $request->input('current-password');
        if(Hash::check($request->input('current-password'), $current_password))
        {           
          $user_id = Auth::User()->id;                       
          $obj_user = User::find($user_id);
          
          $obj_user->password = Hash::make($request->input('password'));
      
          $obj_user->save(); 
          Session::put('change_password', "Password Change Sucussfully");
          return redirect('/logout');
          
        }
        else
        {           
          Session::put('current-password', "Please enter correct current password");
          return redirect()->route('user-changepassword');
            
        }
      }
    }
  return view('users.changepassword');
  } 
  public function market_list(Request $request )
  {
    $id=Auth::user()->id;
    $inputTown = '';
    if(!empty($request->input('town'))){
      $inputTown = $request->input('town');  
    }

    $result = Market::with('market_date')->with('general_range')->with('general_status')->with('market_state')->with('market_town');

    $result = $result->where('organizer_id',$id)->where('status','!=',4);
    if($inputTown!='')
    {
      $result = $result->where('town', 'like', '%' . $inputTown . '%');
    }
    
    $result = $result->orderBy('created_at', 'desc')->paginate(10);

    return view('users.market_list',['results'=>$result,'request'=>$request]);
  }
  
  public function user_detail(Request $request,$id=null)
  {
    $userid = Auth::user()->id;
    $result=$this->master->get_user_data($userid);
    
      if ($request->all()) { //post

        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'street' => 'required',
          'website' => 'required',
          'postcode' => 'required',
          'email' => 'required|email|unique:users,email,null,null,id,!'.$userid
            
        ]);
        if ($validator->fails()) 
        {
          return redirect()->route('user-detail')
                            ->withErrors($validator)
                            ->withInput(); 
        }
        else{
       
          $data=$request->all();
          $result=$this->master->user_edit($data);
          Session::put('edit_user', "Detail updated sucessfully");
          return redirect()->route('user-detail');

       
        }        

      }
      return view('users.user_detail',['result'=>$result]);
    }
    public function market_edit(Request $request,$id = '')
    {
      
      $data = array();
      $result=$this->master->rangelist();
      if ($id) {
        $states = State::all();
        $data = $this->master->get_market_data($id);
      }
      if($request->input()){
            $userid=Auth::user()->id;

            $senddata=$request->input();

            $senddata['commision_fee_doc'] = $request->file('commision_fee_doc');
            $senddata['market_rules'] = $request->file('market_rules');

            $validator=$this->master->validation($senddata);
            if ($validator->fails()) {
              
              return redirect('user/editmarket/'.$id)
                                    ->withErrors($validator)
                                    ->withInput();
            }else{


            
              $return = $this->master->edit_market($senddata,$userid);  
            }


            if($return){

                  
                        return redirect()->route('user-markets');
                   
}
}
       $result=$this->master->rangelist();
       return view('users.edit_market',['ranges'=>$result,'data' => $data,'states'=>$states]);
       // return view('users/dashboard');
    }

    public function change_status($id, $status, Request $request){
     $results= $this->master->change_status($id, $status,$table='Market');
     if($results!=""){
      $request->session()->flash('message', $results);
      return redirect()->route('user-markets');
     }
      

    }

}
