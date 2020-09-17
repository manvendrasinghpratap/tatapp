<?php
include("db_config.php");
/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/
$target_chart_visibility = ($_POST['target_chart_visibility']=="on")?'y':'n';
$timeline_chart_visibility = ($_POST['timeline_chart_visibility']=="on")?'y':'n';

        $arrProp = array();
        $arrProp['case_id'] = $_POST['case_id'];
        $arrProp['sector_id'] = $_POST['sector_id'];
        $arrProp['title'] = $_POST['title']; // factor name
        $arrProp['rank_id'] = $_POST['rank_id'];
        
        $resp = isFactorDataAlreadyExist($arrProp,$mysqli);
        
if(!$resp){
$query = "insert into factor_list set
        sector_id= " . $mysqli->real_escape_string($_POST['sector_id']).", 
        case_id=" . $mysqli->real_escape_string($_POST['case_id']).", 
        title='" .$mysqli->real_escape_string($_POST['title']) ."', 
        description='" .$mysqli->real_escape_string($_POST['description']) ."', 
        rank_id='" . $mysqli->real_escape_string($_POST['rank_id'])."', 
        source='" . $mysqli->real_escape_string($_POST['source'])."', 
        occurance_date='" . $mysqli->real_escape_string($_POST['occurance_date'])."',
        target_chart_visibility='" . $target_chart_visibility."',
        timeline_chart_visibility='" . $timeline_chart_visibility."',
        addedOn='" . date("Y-m-d h:i:s")."', 
        addedBy=1";

        $mysqli->query($query);
        }


//printf ("New Record has id %d.\n", $mysqli->insert_id);
?>
<table id="sectortbl" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Sector</th>
                <th>Factor</th>
                <th>Rank</th>
                <th>isVisibility</th>
                <th>occurance date</th>
            </tr>
        </thead>
        <tbody>
             <?php 
             $sectorList = getAllSectorByCaseId($_POST['case_id'],$mysqli);
               foreach($sectorList as $key=>$row){
                ?>
                 <tr>
                <td><?php echo $row["sector_name"]; ?></td>
                <td><?php echo $row["title"]; ?></td>
                <td><?php echo $row["rank_id"]; ?></td>
                <td><?php echo $row["target_chart_visibility"]; ?></td>
                <td><?php echo $row["occurance_date"]; ?></td>
                
            </tr>
                
                <?php
                }
                
                ?>
           
        </tbody>
       
    </table>
  