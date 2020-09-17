<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\StartPlan;
use App\UserPlan;
use App\Plans;
use App\PlanModules;
use App\ModuleVideos;
use App\Payment;
use App\DashboardContent;
use App\ExclusivePlan;
use App\PaypalDetail;
use App\StripeDetail;
use App\TrackVideo;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MasterRepository;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Session;
use Carbon\Carbon;
use App\Http\Controllers\CommonController;
use DB;


class DashboardController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct(MasterRepository $master)
  {
      $this->master=$master;
      //$this->middleware('auth');
     
     // $user = Auth::user();

      
      
  }
 /**
  * Function index
  *
  * function to get you to dashboard page.
  *
  * @Created Date: 16 March 2018
  * @Modified Date: 16 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function index()
  {
    $content  = DashboardContent::where('status','=','1')->first();
    $current_language = \Lang::getLocale();
    dd($current_language);
    $all_plans = get_free_plan();
    $my_plan = get_my_plan();
    if(empty($my_plan)){
       $my_plan_id = 0;
    }else{
       $my_plan_id = $my_plan->plan_id;
    }
    $user = Auth::user();
     // total optin
    $my_leads = User::where('refer_by','=',$user->id)->where('status', '!=', '3')->count();

    //with registration completd
    $my_registrations = User::where('refer_by','=',$user->id)->where('r_status','=','2')->where('status', '!=', '3')->count();

    //my referall older than 14 days
    //$my_members = User::where('refer_by','=',$user->id)->where('r_status','=','2')->where('created_at', '>=', Carbon::now()->subDays(14)->toDateTimeString())->where('status', '!=', '3')->count();
    $my_affiliates = User::where('status','!=', '3')
                            ->where('user_type','1')
                            ->where('refer_by','=',$user->id)
                            ->pluck('id')
                            ->toArray();

    $my_members = UserPlan::whereIn('user_id',$my_affiliates)
                                   ->groupBy('user_id')
                                   ->get();

    



    $my_sponser = User::find($user->refer_by);

    
    // $plan = $user_plan->plan;
    return view('users.dashboard',[
                                  'my_plan' => $all_plans,
                                  'content' => $content,
                                  'my_leads' => $my_leads,
                                  'my_registrations' => $my_registrations,
                                  'my_members' => count($my_members),
                                  'curr_lang' => $current_language
                                   ]
                );
  }
  
  
  
  
/**
  * Function coming_soon
  *
  * function to coming_soon.
  *
  * @Created Date: 20 March 2018
  * @Modified Date: 20 March 2018
  * @Created By: Gaurav Malik
  * @Modified By: Gaurav Malik
  * @param  ARRAY
  * @return STRING
  */
  public function coming_soon(Request $request){
      echo 'hi'; exit;
     $all_plans_free = array();
     return view('users.coming-soon',['my_plan' =>$all_plans_free]);
  }

  

}
