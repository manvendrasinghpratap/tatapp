 <div class="row text-center text-lg-left">
           @if(count($data['fileListArray'])>0)
            @foreach($data['fileListArray'] as $key=>$row)   
        
           <?php
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
                              <div class="col-lg-3 col-md-4 col-xs-6">
                            <a onclick="viewFactorGalleryDetails(this, <?php echo $row->id; ?>, '{{route('admin-ajaxViewFactorGalleryDetails')}}');"  class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="{{get_image_url(@$profile_pic,'files')}}" alt="">
          </a>
           <?php echo "<p>".substr($row->title, 0,30)."</p>"; ?>
            </div>
                              <?php
                              }
                            else
                              {
                             ?>
							  <div class="col-lg-3 col-md-4 col-xs-6">
                              <a href="{{get_image_url(@$profile_pic,'files')}}"><img class="img-fluid img-thumbnail" src="{{asset('images/download_file.png')}}" style="cursor:pointer;width:110px;"></a>
							  <p><a onclick="viewFactorGalleryDetails(this, <?php echo $row->id; ?>, '{{route('admin-ajaxViewFactorGalleryDetails')}}');"  style="cursor:pointer;" class="d-block mb-4 h-100"><?php echo substr($row->title, 0,30); ?></a></p>
							   </div>
                              <?php
                              }
                                ?> 
                         @endif
                   
          
       
         @endforeach
                          @else
                          @endif
        
      </div>