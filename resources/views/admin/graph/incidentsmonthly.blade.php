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
            foreach ($monthArray as $keys => $value) {?>
            <tr>
                <td>{{ $value }} </td>
                <?php if(!empty($mainDataArray[$keys])){ $i = 0;
                    foreach ($mainDataArray[$keys] as $key => $value) { $i++;?>
                        <?php foreach($value as $keyinner=>$valueinner){?>
                            <?php if(in_array($key,$incidentTypes)){?>
                                    <td>{{@$valueinner[0] }}</td>
                           <?php }?>
                        <?php }?>
                        
                   <?php  }} ?>
            </tr>
            
           <?php  } ?>
            
           
        </tbody>
    </table>