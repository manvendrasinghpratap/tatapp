<?php 
$mysqli = new mysqli("localhost", "root", "smartdata", "db_tatapp");
//$mysqli = new mysqli("localhost", "tatapp", "tatapp", "db_tatapp");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

function getAllSectorList($mysqli){
	 $query = "SELECT * FROM `sector` order by sector_name";

                if ($result = $mysqli->query($query)) {
                 $returnArray = array();
                /* fetch object array */
                while ($row = $result->fetch_assoc()) {
                 $returnArray[] = $row; 
                }
                return $returnArray;
                /* free result set */
                $result->close();
                }

}


function isSectorDataAlreadyExist($arrProp,$mysqli){


     $query = "SELECT * FROM `sector` where 
     LOWER(sector_name) = '".strtolower($arrProp['sector_name'])."'";

                if ($result = $mysqli->query($query)) {
                 $returnArray = array();
                /* fetch object array */
                while ($row = $result->fetch_assoc()) {
                 $returnArray[] = $row; 
                }
                if(count($returnArray)>0){
                    return 1;
                }
                else{
                    return 0;
                }
                
                /* free result set */
                $result->close();
                }

}


function isFactorDataAlreadyExist($arrProp,$mysqli){


     $query = "SELECT * FROM `factor_list` 
     where 
     case_id = '".$arrProp['case_id']."' and 
     sector_id = '".$arrProp['sector_id']."' and
     title = '".$arrProp['title']."' and 
     rank_id = '".$arrProp['rank_id']."' ";

                if ($result = $mysqli->query($query)) {
                 $returnArray = array();
                /* fetch object array */
                while ($row = $result->fetch_assoc()) {
                 $returnArray[] = $row; 
                }
                if(count($returnArray)>0){
                    return 1;
                }
                else{
                    return 0;
                }
                
                /* free result set */
                $result->close();
                }

}


function getAllSectorByCaseId($caseId,$mysqli){
	 $query = "SELECT s.id as sectorId, s.*, f.id as factor_id, f.*  FROM sector as s, factor_list as f  where s.id = f.sector_id and f.case_id=$caseId  and f.target_chart_visibility='y' ORDER BY f.id DESC";

                if ($result = $mysqli->query($query)) {
                 $returnArray = array();
                /* fetch object array */
                while ($row = $result->fetch_assoc()) {
                 $returnArray[] = $row; 
                }
                return $returnArray;
                /* free result set */
                $result->close();
                }

}


function getAllVisibleSectorByCaseId($caseId,$mysqli){
	 $query = "SELECT  s.sector_name, COUNT(f.sector_id) totalsector
FROM    factor_list f
        JOIN sector s
            ON  s.id = f.sector_id AND
                f.case_id = $caseId  and f.target_chart_visibility='y'
GROUP  BY s.sector_name";

                if ($result = $mysqli->query($query)) {
                 $returnArray = array();
                /* fetch object array */
                while ($row = $result->fetch_assoc()) {
                 $returnArray[] = $row['sector_name']; 
                }

                return $returnArray;
                /* free result set */
                $result->close();
                }

}

function getAllVisibleFactorByCaseId($caseId,$mysqli){
   /*  $query = "SELECT title, sector_id, rank_id FROM `factor_list` where case_id = $caseId";*/
    $query = "SELECT s.id as sectorId, s.*, f.id as factor_id, f.*  FROM sector as s, factor_list as f  where s.id = f.sector_id and f.case_id=$caseId and f.target_chart_visibility='y'";

                if ($result = $mysqli->query($query)) {
                 $returnArray = array();
                /* fetch object array */
                $uniqueSectorArray = getAllVisibleSectorByCaseId($caseId,$mysqli);
                $counter = 0; 
                $sectorIdPlace = 0;
                while ($row = $result->fetch_assoc()) {
                    foreach ($uniqueSectorArray as $key => $value) {
                        if($value==$row['sector_name']){
                           $sectorIdPlace = $key;
                        }
                    }
                 $returnArray[$counter]['name'] = $row['title']; 
                 $returnArray[$counter]['x'] = floatval($sectorIdPlace); 
                 $returnArray[$counter]['y'] = floatval($row['rank_id']); 
                 $returnArray[$counter]['factor_id'] = $row['factor_id']; 
                 $counter++;
                }

                return $returnArray;
                /* free result set */
                $result->close();
                }

}


function getAllVisibleTimeLineDataByCaseId($caseId,$mysqli){
   /*  $query = "SELECT title, sector_id, rank_id FROM `factor_list` where case_id = $caseId";*/
    $query = "SELECT s.id as sectorId, s.*, f.id as factor_id, f.*  FROM sector as s, factor_list as f  where s.id = f.sector_id and f.case_id=$caseId and f.timeline_chart_visibility='y' order by f.occurance_date ASC";

                if ($result = $mysqli->query($query)) {
                 $returnArray = array();
                /* fetch object array */
                
                $counter = 0; 
                $sectorIdPlace = 0;
                while ($row = $result->fetch_assoc()) {
                   
                 $returnArray[$counter][] = $row['occurance_date']; 
                 $returnArray[$counter][] = floatval($row['rank_id']); 
                 $counter++;
                }

                return $returnArray;
                /* free result set */
                $result->close();
                }

}


function getFactorDetails($factor_id, $mysqli){
   
    $query = "SELECT s.id as sectorId, s.*, f.id as factor_id, f.*  FROM sector as s, factor_list as f  where s.id = f.sector_id and f.id=$factor_id and f.timeline_chart_visibility='y' order by f.occurance_date ASC";

                if ($result = $mysqli->query($query)) {
                 $returnArray = array();
                /* fetch object array */
                
                 $returnArray = $result->fetch_assoc();

                return $returnArray;
                /* free result set */
                $result->close();
                }

}


/*$abc = getAllVisibleSectorByCaseId(1,$mysqli);
echo "<pre>";
print_r($abc);
echo "</pre>";*/
?>