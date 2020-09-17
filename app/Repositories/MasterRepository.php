<?php

namespace App\Repositories;


use Illuminate\Http\Request;
use DB;
use Validator;
use App\Market;
use App\MarketDate;
use App\Range;
use Session;
use Route;
use App\User;
use App\Rating;
class MasterRepository extends BaseRepository {

    public function __construct() {
       
    }

    /**
    * Function add_market
    *
    * function to add market places
    *
    * @Created Date: 01 Nov, 2017
    * @Modified Date: 01 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
    public function add_market($data,$user_id) {
        $market_rules_name="";
        $commision_fee_doc_name="";

        //GET LAT LONG
        $statename = get_statename($data['market_state']);
        $address = $data['mstreet'].", " .$data['city'].", ".$statename . ", Switzerland";
        $addressdata = geocode($address);
        
        
        //a($data);
        if ($data) { //POST 
            
            foreach ($data['marketdt'] as $key =>  $values) {
                if(!empty($values)){

                    //$user = new User;
                    $market = new Market;
                    $market->date =date("Y-m-d", strtotime($values));
                    $market->organizer_id = $user_id;

                    $market->sales_open_time = $data['sot'];
                    $market->sales_close_time = $data['sct'];
                    $market->presales_close_time = $data['pct'];
                    $market->presales_open_time = $data['pot'];
                    $market->individual_before_close_time = $data['ibct'];
                    $market->individual_before_open_time = $data['ibot'];
                    $market->individual_itself_close_time = $data['iict'];
                    $market->individual_itself_open_time = $data['iiot'];
                    $market->dealer_before_close_time = $data['dbct'];
                    $market->dealer_before_open_time = $data['dbot'];
                    $market->dealer_itself_close_time = $data['dict'];
                    $market->dealer_itself_open_time = $data['diot'];
                    $market->private_receive_open_time = $data['prot'];
                    $market->private_receive_close_time = $data['prct'];
                    $market->dealer_receive_close_time = $data['drct'];
                    $market->dealer_receive_open_time = $data['drot'];
                    $market->street_no = $data['streetno'];
                    $market->mstate_id = $data['market_state'];
                    $market->town = $data['city'];
                    $market->street = $data['mstreet'];
                    $market->place = $data['place'];
                    $market->commission = $data['commission'];
                    $market->market_info = $data['add_info'];
                    $market->range = $data['range'];
                    
                    // add lat lng in market_places table
                    if(@$addressdata['lat'])
                        $market->latitude = $addressdata['lat'];
                    if(@$addressdata['lng'])
                        $market->longitude = $addressdata['lng'];
                
                    if($key==0){

                        if (@$data['commision_fee_doc']) {
                            $commision_fee_doc_name = ImageUpload($data['commision_fee_doc'],'market');
                            if($commision_fee_doc_name)
                                $market->commision_fee_doc = $commision_fee_doc_name;
                        }
                        if (@$data['market_rules']) {
                            $market_rules_name = ImageUpload($data['market_rules'],'market',@$commision_fee_doc_name);
                            if($market_rules_name)
                                $market->market_rules = $market_rules_name;
                        }
                            
                    } else {
                        $market->commision_fee_doc = $commision_fee_doc_name;
                        $market->market_rules = $market_rules_name;
                    }

                    $market->status = "5";
                    $market->save();
                }
            }
            $msg = 'Market has been added successfully.';
            Session::put('add_message', $msg);
            return $msg;
        } 
    }
    /**
    * Method: geocode
    * Used to get latitude and longitude of any location based on address
    * @param array $address array of address 
    * @return array detail of latitude and longitude
    * @createdBy: Gaurav Pratap
    * @createdDate: 12 Jan 2018
    */
    public function geocode(array $address){
        $address = urlencode(implode(', ', $address));

        $url = sprintf('https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s', $address, 'AIzaSyBieArFwEDPU7afAVaq4ElNJIVdDVUMg2Y');

        $data = @file_get_contents($url);
        $data = json_decode($data, true);

        // If the json data is invalid, return empty array
        if ($data['status'] != 'OK') return array();

        return [
                'lat' => $data["results"][0]["geometry"]["location"]["lat"],
                'lng' => $data["results"][0]["geometry"]["location"]["lng"],
        ];
    } 
    /**n add
    * Function marketlist
    *
    * common function to get marketlist data
    *
    * @Created Date: 24 Nov, 2017
    * @Modified Date: 24 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
    public function marketlist($condition=null){

        $result = Market::with('market_date')->with('general_range')->with('general_status')->with('market_state')->with('market_town')->orderBy('date', 'asc');

        if($condition){

            if(array_key_exists('organizer_id', $condition)){
    
                $result=$result->where($condition)->paginate(4); 
            }else{
                $result=$result->where($condition)->get(); 
            }
        } 
        else {
            $result=$result->get();
        }
        return $result;
    }
    /**n add
    * Function marketlist
    *
    * common function to get marketlist data
    *
    * @Created Date: 24 Nov, 2017
    * @Modified Date: 24 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
    public function marketlistDashboard($condition=null,$town=null){

        $result = Market::with('market_date')->with('general_range')->with('general_status')->with('market_state')->with('market_town')->orderBy('date', 'asc');

        //a($result);
        if($condition){

            if(array_key_exists('organizer_id', $condition)){
                if($town != null){
                    $result=$result->where($condition)->where('town', 'like', '%' . $town . '%')->where('status','!=',4)->paginate(4);
                }else {
                    $result=$result->where($condition)->where('status','!=',4)->paginate(4);    
                }
                 
            }else{
                if($town != null){
                    $result=$result->where($condition)->where('town', 'like', '%' . $town . '%')->where('status','!=',4)->paginate(4);
                }else {
                    $result=$result->where($condition)->where('status','!=',4)->get();     
                }
            }
        
        } 
        else {
            $result=$result->get();
        }
        return $result;
    }
    /**n add
    * Function marketdata
    *
    * common function to get marketlist data
    *
    * @Created Date: 24 Nov, 2017
    * @Modified Date: 24 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
    public function marketdata($condition=null){
      
        $result = Market::where('status','!=', '4')->with('general_status')->with('general_range')->with('market_date')->with('market_user');
        $result= $result->where('id',$condition['date']);
        $result=$result->get();

        return $result;
    }
    /**n add
    * Function marketdataregional
    *
    * common function to get marketlist data
    *
    * @Created Date: 24 Nov, 2017
    * @Modified Date: 24 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
    public function marketdataregional($condition=null){
        
        $result = Market::where('status','!=', '4')->with('general_status')->with('general_range')->with('market_date')->with('market_user');

        if($condition['date']=='asc'){

            $result= $result->where('mstate_id', $condition['id'])->orderBy('date', 'desc');
        }
        if($condition['date']!='asc'){

            $result= $result->where('id',$condition['date']);
        }
        $result=$result->get();
        
        return $result;
    
    }
    /**
    * Function rangelist
    *
    * common function to get rangelist data
    *
    * @Created Date: 24 Nov, 2017
    * @Modified Date: 24 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
       public function rangelist(){
            $result=Range::where('status','=', '1')->orderBy('range_to', 'desc')->get();
            return $result;
        
    }
    /**
    * Function get_market_data
    *
    * function to get market data
    *
    * @Created Date: 01 Nov, 2017
    * @Modified Date: 01 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
    public function get_market_data($id) {
        $users = Market::where('id',$id)->where('status','!=','4')->with('market_date')->with('market_user')->first();
        
        return $users;
    }
    /**
    * Function edit_market
    *
    * function to edit market data
    *
    * @Created Date: 01 Nov, 2017
    * @Modified Date: 01 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
    public function edit_market($data,$user_id) {

        
     
        $market_rules_name="";
        $commision_fee_doc_name="";
        //GET LAT LONG
        $statename = get_statename($data['state']);
        $address = $data['mstreet'].", " .$data['city'].", ".$statename . ", Switzerland";
        $addressdata = geocode($address);

        if ($data) { //post
            $marketdata = Market::find($data['id']);
            $market = Market::find($data['id']);
            $market->date =date("Y-m-d", strtotime($data['marketdt'][0]));
            //  $market->organizer_id = $user_id;

            $market->sales_open_time = $data['sot'];
            $market->sales_close_time = $data['sct'];
            $market->presales_close_time = $data['pct'];
            $market->presales_open_time = $data['pot'];
            $market->individual_before_close_time = $data['ibct'];
            $market->individual_before_open_time = $data['ibot'];
            $market->individual_itself_close_time = $data['iict'];
            $market->individual_itself_open_time = $data['iiot'];
            $market->dealer_before_close_time = $data['dbct'];
            $market->dealer_before_open_time = $data['dbot'];
            $market->dealer_itself_close_time = $data['dict'];
            $market->dealer_itself_open_time = $data['diot'];
            $market->private_receive_open_time = $data['prot'];
            $market->private_receive_close_time = $data['prct'];
            $market->dealer_receive_close_time = $data['drct'];
            $market->dealer_receive_open_time = $data['drot'];
            $market->street_no = $data['streetno'];
            $market->mstate_id = $data['state'];
            $market->town = $data['city'];
            $market->street = $data['mstreet'];
            $market->place = $data['place'];
            $market->commission = $data['commission'];
            $market->market_info = $data['add_info'];
            
            $market->range = $data['range'];
            // add lat lng in market_places table
            if(@$addressdata['lat'])
                $market->latitude = $addressdata['lat'];
            if(@$addressdata['lng'])
                $market->longitude = $addressdata['lng'];

            if (@$data['commision_fee_doc']) {

                echo $data['commision_fee_doc']; exit;
                
                if($marketdata->commision_fee_doc)
                        @unlink(public_path('uploads/market/' . $marketdata->commision_fee_doc));
                $commision_fee_doc_name = ImageUpload($data['commision_fee_doc'],'market');
                if($commision_fee_doc_name)
                    $market->commision_fee_doc = $commision_fee_doc_name;
            }
            if (@$data['market_rules']) {
                if($marketdata->market_rules)
                        @unlink(public_path('uploads/market/' . $marketdata->market_rules));
                
                $market_rules_name = ImageUpload($data['market_rules'],'market',@$commision_fee_doc_name);
            if($market_rules_name)
                $market->market_rules = $market_rules_name;
            }
            
        }
        $market->save();
            
        $msg = 'Market has been updated successfully.';
        // $request->session()->flash('add_message', $msg);
        Session::put('update_message', $msg);
        
        return $msg;
    } 
    /**
    * Function get_user_data
    *
    * common function to get user data
    *
    * @Created Date: 24 Nov, 2017
    * @Modified Date: 24 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
    public function get_user_data($id) {
        $users = User::where('id',$id)->where('status','!=','4')->first();
        return $users;
    }
    public function user_edit($data){
        
        $user = User::find($data['id']);
       
        $user->name=$data['name'];
        $user->street=$data['street'];
        $user->postcode=$data['postcode'];
        $user->email=$data['email'];
        $user->phone=$data['phone'];
        $user->website=$data['website'];
       $user->save();
       return;
    }
    /**
    * Function change_status
    *
    * function to get change range status
    *
    * @Created Date: 07 Nov, 2017
    * @Modified Date: 07 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */
    public function change_status($id, $status,$table) {
        if ($id) {
            $status = base64_decode($status);
            if($table=='Market'){
 $user = Market::find($id);
            }
           

            $user->status = $status;
            $user->save();
            if ($status == '1') {
                $msg = $table.' has been activated successfully.';
            } 
            if($status == '4') {
                
                $msg = $table.' has been Deleted successfully.';
            }
            if ($status == '2') {
                $msg = $table.' has been inactive successfully.';
            }

            
        }
        return $msg;
    }
   public function validation($data){
   return $validator = Validator::make($data, $this->rules($data),$this->messages());

   }
   /**
 * Get the validation rules that apply to the request.
 *
 * @return array
 */

public function rules($data) {
     $rules = [];

if(array_key_exists('name', $data) && $data['name']==""){
  $rules['name'] = 'required';
}

if(array_key_exists('place', $data) && $data['place']==""){
    
    $rules['place'] = 'required';
}
if(array_key_exists('street', $data) && $data['street']==""){
    
    $rules['street'] = 'required';
}
if(array_key_exists('mstreet', $data) && $data['mstreet']==""){
    
    $rules['mstreet'] = 'required';
}
if(array_key_exists('state', $data) && $data['state']==""){
    
    $rules['state'] = 'required';
}
if(array_key_exists('city', $data) && $data['city']==""){
    
    $rules['city'] = 'required';
}
if(array_key_exists('sot', $data) && $data['sot']==""){
    
    $rules['sot'] = 'required';
}
if(array_key_exists('sct', $data) && $data['sct']==""){
    
    $rules['sct'] = 'required';
}
/*if(array_key_exists('pot', $data) && $data['pot']==""){
    
    $rules['pot'] = 'required';
}
if(array_key_exists('pct', $data) && $data['pct']==""){
    
    $rules['pct'] = 'required';
}*/
if(array_key_exists('ibot', $data) && $data['ibot']==""){
    
    $rules['ibot'] = 'required';
}
if(array_key_exists('ibct', $data) && $data['ibct']==""){
    
    $rules['ibct'] = 'required';
}
if(array_key_exists('dbot', $data) && $data['dbot']==""){
    
    $rules['dbot'] = 'required';
}
if(array_key_exists('dbct', $data) && $data['dbct']==""){
    
    $rules['dbct'] = 'required';
}
if(array_key_exists('diot', $data) && $data['diot']==""){
    
    $rules['diot'] = 'required';
}
if(array_key_exists('dict', $data) && $data['dict']==""){
    
    $rules['dict'] = 'required';
}
if(array_key_exists('prot', $data) && $data['prot']==""){
    
    $rules['prot'] = 'required';
}
if(array_key_exists('prct', $data) && $data['prct']==""){
    
    $rules['prct'] = 'required';
}
if(array_key_exists('email', $data) && $data['email']==""){
    
    $rules['email'] = 'required';
}
if(array_key_exists('postcode', $data) && $data['postcode']==""){
    
    $rules['postcode'] = 'required';
}
if(array_key_exists('phone', $data) && $data['phone']==""){
    
    $rules['phone'] = 'required';
}
if(array_key_exists('commission', $data) && $data['commission']==""){
    
    $rules['commission'] = 'required';
}


   /* return [
                            'name' => 'required',
                            'place' => 'required',
                            'street' => 'required',
                            'mstreet' => 'required',
                            'state' => 'required',
                            'city' => 'required',
                            'sot' => 'required',
                            'sct' => 'required',
                            'pot' => 'required',
                            'pct' => 'required',
                             'ibot' => 'required',
                             'ibct' => 'required',
                             
                             'dbot' => 'required',
                             'dbct' => 'required',
                             'diot' => 'required',
                             'dict' => 'required',
                             'prot' => 'required',
                             'prct' => 'required',
                             'email' => 'required',
                             'postcode' => 'required',
                            'phone' => 'required',
                             'commission' => 'required',
    ];*/

    return $rules;
     }
     public function messages() {
    return [
                            'name.required' => 'A title is required',
                            'place.required' => 'A place field is required',
                            'street.required' => 'A street field is required',
                            'mstreet.required' => 'Street no is required',
                            'state.required' => 'Kanton is required',
                            'city.required' => 'Ort is required',
                            'sot.required' => 'Verkauf is required',
                            'sct.required' => 'Verkauf is required',      
                             'diot.required' => 'Verkaufstag field is required',
                             'dict.required' => 'Verkaufstag field is required',
                             'prot.required' => 'Auszahlung Private field is required',
                             'prct.required' => 'Auszahlung Private field is required',
                             'email.required' => 'Email field is required',
                             'postcode.required' => 'PLZ field is required',
                            'phone.required' => 'Tel.-Nummer field is required',
                             'commission.required' => 'Provision field is required',
    ];
     }


        /**
    * Function marketlist
    *
    * common function to get regional market list data
    *
    * @Created Date: 30 Nov, 2017
    * @Modified Date: 30 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */

    public function regionalmarketlist($condition){
      
      

        $result=Market::with('market_date')->with('general_range')->with('general_status')->with('market_state')->with('market_town')->orderBy('date', 'asc')->where('mstate_id',$condition['state_id'])->get();


        return $result;
    
    }
       /**
    * Function marketlist
    *
    * common function to get regional market list data
    *
    * @Created Date: 30 Nov, 2017
    * @Modified Date: 30 Nov, 2017
    * @Created By: Ammar Zaidi
    * @Modified By: Ammar Zaidi
    * @param  ARRAY
    * @return STRING
    */

    public function marketdataregionallist($condition){
      
      

    $result=Market::with('market_date')->with('general_range')->with('general_status')->with('market_state')->with('market_town')->orderBy('date', 'asc')->where($condition)->get();

        return $result;
    
    }
    public function ratinglist($id){
         $result = Rating::where('regional_id',$id)->where('status',1)->orderBy('created_at', 'desc')->get();

        return $result;
    }
     
}
