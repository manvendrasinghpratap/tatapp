<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\StartPlan;
use App\UserPlan;
use App\Plans;
use App\Payment;
use Session;
use AWeberAPI;

class CommonController extends HomeController {


	public function __construct() {
        //parent::__construct();
        //$this->middleware('check_site_status');
        $this->aweber_consumerKey    = 'AkHmLE2v8QKuvNqoa922TTR'; # put your credentials here
        $this->aweber_consumerSecret = 'hRF36jiliSOV8h96bxPSZrH72SqlpJ6YkX4xuJj'; # put your credentials here
        //$this->aweber_accessKey      = 'AgQI5dBI6d7aR29jhx1PPNzq'; # put your credentials here
        //$this->aweber_accessSecret   = '9nKzG8howGwl38iHYS5Sa3DHBYomlWQm9qf428xk'; # put your credentials here
		$this->aweber_accessKey = 'AgmURDO9G72t1RHqrv2b39YI'; 
		$this->aweber_accessSecret = 'ywZIntb4FUyu5xfw1roisLGuTVjm87X4EPpU7doL'; 
        $this->aweber_account_id     = 'XW4k'; # put the Account ID here
        //$this->aweber_list_id        = 'awlist4929030'; # put the List ID here  
    }
    /**
    * Function add_to_aweber_list
    *
    * function to send to aweber data 
    *
    * @Created Date: 23 March 2018
    * @Modified Date: 23 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  INT
    * @return ARRAY
    */
   public function add_to_aweber_list($post_data = array(),$list_id = null ){

   		$aweber = new AWeberAPI($this->aweber_consumerKey, $this->aweber_consumerSecret);
       // dd($aweber);

		try {

		    $account = $aweber->getAccount($this->aweber_accessKey , $this->aweber_accessSecret);
		    $lists = $account->lists->find(array('name' => $list_id));
		    $list = $lists[0];

		    # lets create some custom fields on your list!
		    $custom_fields = $list->custom_fields;
		    // try {
		    //     # setup your custom fields
		    //     $custom_fields->create(array('name' => 'Car'));
		    //     $custom_fields->create(array('name' => 'Color'));
		    // }
		    // catch(AWeberAPIException $exc) {
		    //     # errors would be raised if we already had these fields, or
		    //     # we couldnt add anymore, so skip it and keep going
		    //     # uncomment the line below to see any errors related to custom fields:
		    //     # handle_errors($exc);
		    // }
		    //$ip = $_SERVER["REMOTE_HOST"] ?: gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		    # create a subscriber
		    $params = array(
		        'email' => $post_data['email'],
		        'ip_address' => '127.0.0.1',
		        'ad_tracking' => 'client_lib_example',
		        'last_followup_message_number_sent' => 0,
		        'misc_notes' => 'my cool app',
		        'name' => $post_data['name'],
		        'tags' => array('digitalkheops')

		    );

		    $subscribers = $list->subscribers;

		    $paramss = array(
		        'email' => $post_data['email']

		    );
		    $found_subscribers = $subscribers->find($paramss);
		    //dd($found_subscribers);

		    if($found_subscribers->data['total_size']==0){
		    	$new_subscriber = $subscribers->create($params);
		    }
		    

		    # success!
		    //print "A new subscriber was added to the $list->name list!";
		    return true;

		} catch(AWeberAPIException $exc) {
		    return false;
		}

}



  /**
    * Function delete_from_aweber_list
    *
    * function to delete emails fron aweber list
    *
    * @Created Date: 23 March 2018
    * @Modified Date: 23 March 2018
    * @Created By: Gaurav Malik
    * @Modified By: Gaurav Malik
    * @param  INT
    * @return ARRAY
    */
   public function delete_from_aweber_list($post_data = array(),$list_id = null ){

   		$aweber = new AWeberAPI($this->aweber_consumerKey, $this->aweber_consumerSecret);
       // dd($aweber);

		try {

		    $account = $aweber->getAccount($this->aweber_accessKey , $this->aweber_accessSecret);
		    $lists = $account->lists->find(array('name' => $list_id));
		    $list = $lists[0];

		    # lets create some custom fields on your list!
		    $custom_fields = $list->custom_fields;
		    $params = array(
		        'email' => $post_data['email']

		    );

		    $subscribers = $list->subscribers;
		    $found_subscribers = $subscribers->find($params);
		    foreach ($found_subscribers as $subscriber) {
		        $subscriber->delete();
		    }

		    # success!
		    //print "A new subscriber was added to the $list->name list!";
		    return true;

		} catch(AWeberAPIException $exc) {
		    return false;
		}

}


	



}