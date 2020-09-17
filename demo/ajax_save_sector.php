<?php
include("db_config.php");
/*echo "<pre>";
print_r($_POST);
echo "</pre>";
exit;*/
$sector_name = (isset($_POST['sector_name']))?$_POST['sector_name']:'';


        $arrProp = array();
        $arrProp['sector_name'] = $_POST['sector_name'];
        
        
        $resp = isSectorDataAlreadyExist($arrProp,$mysqli);
        
if(!$resp){
$query = "insert into sector set
        sector_name = '" . $mysqli->real_escape_string($_POST['sector_name'])."',
        created_on='" . date("Y-m-d h:i:s")."'";

        $mysqli->query($query);
        }



                $query = "SELECT * FROM `sector` order by sector_name";

                if ($result = $mysqli->query($query)) {

                /* fetch object array */
                while ($row = $result->fetch_assoc()) {
                ?>
                 <a href="#" onclick="return set_sector(<?php echo $row["id"]; ?>,'<?php echo $row["sector_name"]; ?>');"><?php echo $row["sector_name"]; ?></a>
                
                <?php
                }
                /* free result set */
                $result->close();
                }
                /* close connection */
                //$mysqli->close();
                ?>
                <a href="#" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#add-sector">
                <span class="glyphicon glyphicon-plus"></span> Add Sector 
                </a>