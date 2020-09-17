<table id="datatable" style="display: none;">
        <thead>
            <tr>
                <th></th>
                <?php if(!empty($incidentTypes)){ $i = 0;
                    foreach ($incidentTypes as $key => $value) { $i++;?>
                        <th>{{ $value }}</th>
                   <?php  }} ?>
            </tr>
        </thead>
        <tbody>

            <?php 
            foreach ($group as $key => $value) {?>
            <tr>
                <td>{{ $value->name }}</td>
                <?php if(!empty($incidentTypes)){
                    foreach ($incidentTypes as $keyinner => $valueinner) { ?>
                            <?php if(array_key_exists($value->id,$arrayRecord)){
                                         if(array_key_exists($valueinner,$arrayRecord[$value->id]) ){?>
                                                <td> <?php echo $arrayRecord[$value->id][$valueinner][0]; ?></td>
                                                 <?php } else { ?>
                                                 <td> 0 </td>
                                   <?php   } }
                                     ?>
                       
                   <?php  }} ?>
            </tr>
            
           <?php  } ?>
            
           
        </tbody>
    </table>