<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
class MasterController extends Controller
{
    public $data = array();
  
    /**
    * Function index
    *
    * function to get listing of countriea
    *
    * @Created Date: 06 nov, 2017
    * @Modified Date: 29 June, 2017
    * @Created By: Diksha Srivastava
    * @Modified By: Diksha Srivastava
    * @param  ARRAY
    * @return STRING
    */
    public function country() {

        $countries = get_countries();
        return response()->json(['result' => $countries]);

    }
    public function state($id) {
    
        $countries = get_state($id);
        return response()->json(['result' => $countries]);
    }
     
    public function city($id) {
    
        $countries = get_city($id);

        return response()->json(['result' => $countries]);
    }
    /**
    * Function check_email
    *
    * ajax function To check unique username
    *
    * @Created Date: 27 Nov, 2017
    * @Modified Date: 27 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
    public function check_email(Request $request) {

        $email = strtolower(trim($request->email));
        $id = strtolower(trim($request->id));
        
        $user = User::where('email', '=', $email);
        if($id)
            $user->where('id', '!=', $id);
            
        $user = $user->where('status', '!=', '3')->first();
        if (!empty($user)) {
            return 'false';
        }
        return 'true';
    } 
}