<?php

namespace App;

use DB;
use App\Quotation;
use Illuminate\Database\Eloquent\Model;


class TempCaseList extends Model
{
    
    protected $table = 'temp_case_list';

    /*public function module()
    {
        return $this->hasMany('App\PlanModules','plan_id','id')->select('*');
    }*/


    public function caseOwnerName()
    {
        return $this->hasMany('App\User','id','case_owner_id')->select('*');
    }

    public function caseCreatorName()
    {
        return $this->hasMany('App\User','id','user_id')->select('*');
    }
    
    
    public function caseGroup()
    {
        return $this->hasOne('App\CaseToGroup','case_id','id')->select('*');
    }


    public static function getAllSectorList($account_id)
    {

    	$sectorList = DB::table('account_sector')
                ->where('account_id', $account_id)
                ->where('isActive', 'y')
                ->orderByRaw('sector_name ASC')
                ->get();
       
			
	     return $sectorList->toArray();

    }


    public static function isSectorDataAlreadyExist($arrProp){

        $sector_name = strtolower($arrProp['sector_name']);
        $account_id = $arrProp['account_id'];
        $user_id = $arrProp['user_id'];
        

        $sectorList = DB::table('account_sector')
                ->where('account_id', $account_id)
                ->where('user_id', $user_id)
                ->where('sector_name', $sector_name)
                ->orderByRaw('sector_name ASC')
                ->get()
                ->count();

               if($sectorList>0){
                    return 1;
                }
                else{
                    return 0;
                }

        }


       public static function isFactorDataAlreadyExist($arrProp)
        {

        $case_id = $arrProp['case_id'];
        $sector_id = $arrProp['sector_id'];
        $title = $arrProp['title'];
        $rank_id = $arrProp['rank_id'];

        $factorList = DB::table('factor_list')
                ->where('case_id', $case_id)
                ->where('sector_id', $sector_id)
                ->where('title', $title)
                ->where('rank_id', $rank_id)
                ->orderByRaw('id DESC')
                ->get()
                ->count();

               if($factorList>0){
                    return 1;
                }
                else{
                    return 0;
                }

          }


     public static function isTaskDataAlreadyExist($arrProp)
        {

        $case_id = $arrProp['case_id'];
        $title = $arrProp['title'];
  

        $factorList = DB::table('tasks')
                ->where('case_id', $case_id)
                ->where('title', $title)
                ->orderByRaw('id DESC')
                ->get()
                ->count();

               if($factorList>0){
                    return 1;
                }
                else{
                    return 0;
                }

          }     

     public static function getAllSectorByCaseId($caseId)
     {

         $getAllSectorByCaseId = DB::select("SELECT s.id as sectorId, s.*, f.id as factor_id, f.*  FROM account_sector as s, factor_list as f  where s.id = f.sector_id and f.case_id=$caseId ORDER BY f.id DESC");

	     return $getAllSectorByCaseId;

     }


      public static function getAllAssignedTaskByUserId($task_assigned)
     {

         $getAllAssignedTaskByUserIdArr = DB::select("SELECT case_list.title as case_title, tasks.*, tasks.id as task_id, users.first_name, users.last_name FROM `tasks`,users,case_list WHERE tasks.task_assigned=users.id AND case_list.id=tasks.case_id AND tasks.task_assigned=$task_assigned ORDER BY tasks.id DESC");

         return $getAllAssignedTaskByUserIdArr;

     }


     public static function getAllTaskByCaseId($caseId)
     {

         $getAllSectorByCaseId = DB::select("SELECT tasks.*, tasks.id as task_id, users.first_name, users.last_name FROM `tasks`,users WHERE tasks.task_assigned=users.id AND tasks.case_id=$caseId ORDER BY tasks.id DESC");

         return $getAllSectorByCaseId;

     }





     public static function getAllSectorByRankId($caseId, $sector_id, $rank_id)
     {

         $getAllSectorByCaseId = DB::select("SELECT s.id as sectorId, s.*, f.id as factor_id, f.*  FROM account_sector as s, factor_list as f  where s.id = f.sector_id and f.case_id=$caseId and f.sector_id=$sector_id and f.rank_id=$rank_id ORDER BY f.id DESC");

         return $getAllSectorByCaseId;

     }
    
     public static function getTotalClusterData($caseId, $sector_id, $rank_id)
     {

         $getAllSectorByCaseId = DB::select("SELECT count(*) as total, s.id as sectorId, s.*, f.id as factor_id, f.*  FROM account_sector as s, factor_list as f  where s.id = f.sector_id and f.case_id=$caseId and f.sector_id=$sector_id and f.rank_id=$rank_id and f.target_chart_visibility='y' ORDER BY f.id DESC");

         return $getAllSectorByCaseId;

     }






	public static function getAllVisibleSectorByCaseId($caseId)
	 {
		 $query = "SELECT  s.sector_name, COUNT(f.sector_id) totalsector
	FROM    factor_list f
	        JOIN account_sector s
	            ON  s.id = f.sector_id AND
	                f.case_id = $caseId  and f.target_chart_visibility='y'
	GROUP  BY s.sector_name";

	$getAllVisibleSectorByCaseId = DB::select($query);

    $returnArray = array();
	foreach ($getAllVisibleSectorByCaseId as $key => $value) {
              
              $returnArray[] = $value->sector_name; 
          }

      return $returnArray;
	

	}




	public function getAllVisibleFactorByCaseId($caseId)
	 {

    $query = "SELECT s.id as sectorId, s.*, f.id as factor_id, f.*  FROM account_sector as s, factor_list as f  where s.id = f.sector_id and f.case_id=$caseId and f.target_chart_visibility='y' ORDER BY s.sector_name ASC, f.rank_id DESC";


    $getAllVisibleFactorByCaseId = DB::select($query);

     
    $returnArray = array();
    
    $uniqueSectorArray = $this->getAllVisibleSectorByCaseId($caseId);

    $overlappingCounter = 0;
    $old_sector =0;
	foreach ($getAllVisibleFactorByCaseId as $key => $row) {

        $current_sector = $row->rank_id;

        if($current_sector!=$old_sector){
            $overlappingCounter = 0;
        }
        $old_sector = $row->rank_id;

        $totalClusterDataObj = $this->getTotalClusterData($caseId, $row->sector_id, $row->rank_id);
        $totalClusterData = $totalClusterDataObj[0]->total;


        


              foreach ($uniqueSectorArray as $key1 => $value1) {
                        if($value1==$row->sector_name){
                           $sectorIdPlace = $key1;
                        }
                    }
                 $returnArray[$key]['name'] = ucfirst($row->title); 
                 
                 if($totalClusterData>1){

                    $returnArray[$key]['x'] = floatval($sectorIdPlace)+($overlappingCounter*.17);   
                    
                 }
                 else{
                    $returnArray[$key]['x'] = floatval($sectorIdPlace);
                 }

                 $overlappingCounter++;
                 $returnArray[$key]['y'] = floatval($row->rank_id); 
                 $returnArray[$key]['factor_id'] = $row->factor_id; 
                 $returnArray[$key]['sector_id'] = $row->sector_id;
                 $returnArray[$key]['sector_name'] = ucfirst($row->sector_name);
                 $returnArray[$key]['totalClusterData'] = $totalClusterData;
				 if(isset($row->chart_icon)&&!empty($row->chart_icon)){
						$surl = asset('images/'.$row->chart_icon.'.png');
					}else{
						$surl=asset('images/blue_star_20.png');
					}
                 if($totalClusterData>1){

                    ///https://github.com/highcharts/highcharts/tree/master/samples/graphics
					
                    if($row->rank_id>8){
                        
                        $returnArray[$key]['marker'] = array(
                        'symbol'=> 'url('.$surl.')',
                        'height'=> 15,
                        'width'=> 15
                        );
                    }
                    else{
            
                        /*$returnArray[$key]['marker'] = array(
                        'symbol'=> 'url(https://www.highcharts.com/samples/graphics/search.png)',
                        'height'=> 35,
                        'width'=> 35
                        );*/
                       
                        $returnArray[$key]['marker'] = array(
                        'symbol'=> 'url('.$surl.')',
                        'height'=> 15,
                        'width'=> 15
                        );

                    }
                
               } else{
			   
				 if($row->rank_id>8){
                        
                        $returnArray[$key]['marker'] = array(
                        'symbol'=> 'url('.$surl.')',
                        'height'=> 20,
                        'width'=> 20
                        );
                    }
                    else{
            
                        /*$returnArray[$key]['marker'] = array(
                        'symbol'=> 'url(https://www.highcharts.com/samples/graphics/search.png)',
                        'height'=> 35,
                        'width'=> 35
                        );*/
                       
                        $returnArray[$key]['marker'] = array(
                        'symbol'=> 'url('.$surl.')',
                        'height'=> 20,
                        'width'=> 20
                        );

                    }
			   }
                 


             
          }
         //dd($returnArray);
      return $returnArray;
     

       }

  

  function getAllVisibleTimeLineDataByCaseId($caseId){
  
    $query = "SELECT s.id as sectorId, s.*, f.id as factor_id, f.*  FROM account_sector as s, factor_list as f  where s.id = f.sector_id and f.case_id=$caseId and f.timeline_chart_visibility='y' order by f.occurance_date ASC";


    $getAllVisibleTimeLineDataByCaseId = DB::select($query);

     
    $returnArray = array();

	foreach ($getAllVisibleTimeLineDataByCaseId as $key => $row) {
              
                 //$returnArray[$key]['x'] = $row->occurance_date; 
    $dateArray = explode("-", $row->occurance_date);
    //mktime(0, 0, 0, $month, 1, $year);
                 $returnArray[$key]['x'] = mktime(0, 0, 0, $dateArray[1], $dateArray[2], $dateArray[0])*1000;
                 $returnArray[$key]['y'] = floatval($row->rank_id); 
                 $returnArray[$key]['z'] = $row->title;
                 $returnArray[$key]['factor_id'] = $row->factor_id; 
                 $returnArray[$key]['sector_name'] = ucfirst($row->sector_name);
                 $returnArray[$key]['case_id'] = $row->case_id; 
                 $returnArray[$key]['occurance_date'] = date("F j, Y",strtotime($row->occurance_date)); 
               
                
             
          }

      return $returnArray;


    }




   function getFactorDetails($factor_id){
   
    $query = "SELECT s.id as sectorId, s.*, f.id as factor_id, f.*  FROM account_sector as s, factor_list as f  where s.id = f.sector_id and f.id=$factor_id order by f.occurance_date ASC";

                /*if ($result = $mysqli->query($query)) {
                 $returnArray = array();
                
                
                 $returnArray = $result->fetch_assoc();

                return $returnArray;
                
                $result->close();
                }*/
				$getFactorDetails = DB::select($query);


				$returnArray = array();

				foreach ($getFactorDetails as $key => $row) {

				$returnArray = $row; 
				}

				return $returnArray;





}


   function getTaskDetails($task_id)
     {
        $query = "SELECT tasks.* , case_list.title as case_title  FROM tasks, case_list WHERE tasks.id=$task_id AND case_list.id=tasks.case_id";
        $getFactorDetails = DB::select($query);
        $returnArray = array();
        foreach ($getFactorDetails as $key => $row) {
        $returnArray = $row; 
        }

        return $returnArray;
    }

    function case(){
         return $this->hasMany('App\CaseTask','case_id');
    }
    function reportIncident(){
         return $this->hasMany('App\ReportIncident','case_id');
    }
    function task(){
         return $this->hasMany('App\CaseTask','case_id')->select('*')->orderBy('created_at','desc');
    }
     function reportCaseId(){
         return $this->hasMany('App\ReportIncident','case_id');
    }
    

}

