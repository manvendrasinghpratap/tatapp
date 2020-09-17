<?php  
     $zip = new ZipArchive;  
     $res = $zip->open('tatapp.zip');  
     if ($res === TRUE) {  
         $zip->extractTo('tatapp/');  
         $zip->close();  
         echo 'ok==>';  
     } else {  
         echo 'failed';  
     }  
?>  