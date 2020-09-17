<?php
include("db_config.php");

$factor_id = (isset($_POST['factor_id']))?$_POST['factor_id']:'0';
if($factor_id>0){

  $query = "DELETE FROM `factor_list` WHERE `factor_list`.`id` = '".$factor_id."'";

  $result = $mysqli->query($query);
}