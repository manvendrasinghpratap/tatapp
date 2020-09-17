<?php
//dd($data['fileDetailsArray']); 
                      
$file_id = isset($data['fileDetailsArray']->id)?$data['fileDetailsArray']->id:'';

$title = isset($data['fileDetailsArray']->title)?$data['fileDetailsArray']->title:'';
$description = isset($data['fileDetailsArray']->description)?$data['fileDetailsArray']->description:'';
$profile_pic = isset($data['fileDetailsArray']->profile_pic)?$data['fileDetailsArray']->profile_pic:'';
?>

                <div class="row"><div class="col-sm-12">
                      
                        <input type="hidden" name="token" id="token" value="">
                        <input type="hidden" name="account_id" value="<?php echo $data['factorList']->account_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $data['factorList']->user_id; ?>">
                        <input type="hidden" name="factor_id" id="factor_id" value="<?php echo $data['factorList']->id; ?>">
                        <input type="hidden" name="file_id" id="file_id" value="<?php echo $file_id; ?>"  class="subjectClass">
                         <br/>
                         @if(@$profile_pic!='')
                        <div class="row" id="factorgalleryDiv">
                                <div class="col-sm-4" id="factorgalleryDiv1">
                                <?php

                            $path = get_image_url($profile_pic,'files');
                            $ext = pathinfo($path, PATHINFO_EXTENSION); 
                            $extensionsArray = array('jpg', 'JPG', 'png' ,'PNG' ,'jpeg' ,'JPEG');
                            if (in_array($ext, $extensionsArray))
                              {
                              ?>
                              <img src="{{get_image_url(@$profile_pic,'files')}}" class="img-thumbnail">
                              
                               <input type="hidden" name="mediaUrl" id="mediaUrl" value="{{get_image_url(@$profile_pic,'files')}}">
                              <?php
                              }
                            else
                              {
                             ?>
                              <a href="{{get_image_url(@$profile_pic,'files')}}"><img class="img-fluid img-thumbnail" src="{{asset('images/download_file.png')}}" style="cursor:pointer;width:110px;"></a>
							 <input type="hidden" name="mediaUrl" id="mediaUrl" value="{{get_image_url(@$profile_pic,'files')}}">
                              <?php
                              }

                                ?>    
                        
                        
                       
                       
                                </div>
                                <div class="col-sm-8">
                                  <div class="row hidden">
                                          <div class="col-sm-4">Image:</div>
                                          <div class="col-sm-8"> <input type="file" id="profile_pic"  name="profile_pic" data-buttonName="btn-primary">
                                          </div>
                                  </div>
                                  <div class="row">
                                          <div class="col-sm-4">Title:</div>
                                          <div class="col-sm-8">  <input type="text" id="title" name="title" value="<?php echo $title; ?>" placeholder="Title" style="border:1px solid black;" readonly/>
                                          </div>
                                  </div>
                                  <div class="row">
                                          <div class="col-sm-4">Description:</div>
                                          <div class="col-sm-8">  <input type="text" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>"  style="border:1px solid black;" readonly/>
                                          </div>
                                  </div><br>
                                  <div class="row">

                            <div class="col-sm-12">
                              <div class="pull-right">
                                <button type="button" class="btn btn-danger" id="displayAddBox">Close</button>

                                 
                                 <button type="button" class="btn btn-primary" id="setMedia">Confirm</button>
   
                                 <button type="button" class="btn btn-primary" id="deleteFactorImage">Delete</button>
								 
                                <button type="button" class="btn btn-primary" id="setAsFactorImage">Set As Factor Image</button>
                               </div>
                            </div>
                       
                        </div>

                                </div>
                        </div>
                         @endif
                        

                    </div> </div>
<script type="text/javascript">
   $( document ).ready(function() {
    $('#saveFile').on('click', function(){

        
        $('#factorgalleryForm').submit();

    });

    $('#setMedia').on('click', function(){
        var mediaContent = $('#factorgalleryDiv1').html();
        $("#appendImgBox").html(mediaContent);

        var mediaUrl = $('#mediaUrl').val();
        $("#profile_pic").val(mediaUrl);
       
        $('#myModal2').modal('hide');  

    });

    $('#setAsFactorImage').on('click', function(){
        

        var r = confirm("Are you sure you want to change Factor Image ?");
        if (r == true) {
          var mediaUrl = $('#mediaUrl').val();
          var factor_id = $('#factor_id').val();
            $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSetAsFactorImage')}}",
                    dataType: 'html',
                    data: {
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      factor_id:factor_id,mediaUrl:mediaUrl},
                    success: function (html) {
                          
                          $(".factor_pic").attr('src', mediaUrl);
                          $('#myModal').modal('hide');  
                          $('#myModal2').modal('hide');  
                       }
                    });
          }



        

    });

    
    $('#deleteFactorImage').on('click', function(){
        

        var r = confirm("Are you sure you want to delete this Factor Image ?");
        if (r == true) {
          var mediaUrl = $('#mediaUrl').val();
          var file_id = $('#file_id').val();
            $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxDeleteFactorImage')}}",
                    dataType: 'html',
                    data: {
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      file_id:file_id,mediaUrl:mediaUrl},
                    success: function (html) {
                          
                          $(".factor_pic").attr('src', mediaUrl);
                          $('#myModal').modal('hide');  
                          $('#myModal2').modal('hide');  
                       }
                    });
          }



        

    });

   

    $('#displayAddBox').on('click', function(){

        
        $('#addDiv').hide('slow');
        $('#addFilebtn').show('slow');

    });

    
 });

</script>         