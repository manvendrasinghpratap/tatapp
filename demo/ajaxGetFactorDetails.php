<?php
include("db_config.php");

$factor_id = (isset($_POST['factor_id']))?$_POST['factor_id']:'0';
if($factor_id>0){
 $factorDetailsArray = getFactorDetails($factor_id, $mysqli);
 echo json_encode($factorDetailsArray);
}
