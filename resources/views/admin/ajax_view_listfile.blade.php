
    <table id="sectortbl" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <!--<th>SL No</th>-->
                <th>Title</th>
                <th>Description</th>
                <th>Created Date</th>
                <th style="width:20%;">Action</th>
            </tr>
        </thead>
        <tbody>
              
            @if(count($data['fileListArray'])>0)
            @foreach($data['fileListArray'] as $key=>$row)   
                          
            <tr>
                <!--<td>{{$key+1}}</td>-->
                <td> <?php
 $profile_pic = isset($row->profile_pic)?$row->profile_pic:'';
 ?>
 @if(@$profile_pic!='')
                              <?php
                            $path = get_image_url($profile_pic,'files');
                            $ext = pathinfo($path, PATHINFO_EXTENSION); 
                            $extensionsArray = array('jpg', 'JPG', 'png' ,'PNG' ,'jpeg' ,'JPEG');
                            if (in_array($ext, $extensionsArray))
                              {
                              
                              ?>
                              <img src="{{get_image_url(@$profile_pic,'files')}}" style="width:100px;height:100px">
                              <?php
                              }
                            else
                              {
                             ?>
                              <a href="{{get_image_url(@$profile_pic,'files')}}">{{$profile_pic}}</a>
                              <?php
                              }
                                ?> 
                         @endif
                    <?php echo "<br>".$row->title; ?></td>
                <td><?php echo $row->description; ?></td>
                <td><?php echo date("F j, Y", strtotime($row->created_at));
                           $profile_pic = $row->profile_pic;
                 ?></td>
                <td>

                                  
                                     
                                    <a href="{{get_image_url(@$profile_pic,'files')}}" class="btn btn-primary btn-xs action-btn" download>

                                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                                    </a>

                                     <a href="javascript:editFileDetails(<?php echo $row->id; ?>, '{{route('admin-ajaxEditFileDetails')}}');" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    <a href="#" class="btn btn-danger btn-xs action-btn" onclick="delete_file(<?php echo $row->id; ?>, <?php echo $row->case_id; ?>,'{{route('admin-ajaxDeleteFile')}}');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                    
                        

                                </td>
                
            </tr>
                          @endforeach
                          @else
                          @endif
             
           
        </tbody>
       
    </table>
   