<?php
//dd($data['fileDetailsArray']); 
                      
$file_id = isset($data['fileDetailsArray']->id)?$data['fileDetailsArray']->id:'';

$title = isset($data['fileDetailsArray']->title)?$data['fileDetailsArray']->title:'';
$description = isset($data['fileDetailsArray']->description)?$data['fileDetailsArray']->description:'';
$profile_pic = isset($data['fileDetailsArray']->profile_pic)?$data['fileDetailsArray']->profile_pic:'';
?>

                <div class="row"><div class="col-sm-12">
                      
                        <input type="hidden" name="token" id="token" value="">
                        <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
                        <input type="hidden" name="case_id" id="case_id" value="<?php echo $data['caseList']->id; ?>">
                        <input type="hidden" name="file_id" id="file_id" value="<?php echo $file_id; ?>"  class="subjectClass">
                        <input type="hidden" name="target_id" id="target_id" value="<?php echo $data['target_id']; ?>"  class="targetClass">
                        <input type="hidden" name="subject_id" id="subject_id" value="<?php echo $data['subject_id']; ?>"  class="targetClass">
                         <br/>
                         @if(@$profile_pic!='')
                        <div class="row" id="galleryDiv">
                                <div class="col-sm-4" id="galleryDiv1">
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
                              <a href="{{get_image_url(@$profile_pic,'files')}}">{{$profile_pic}}</a>
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
                                 <button type="button" class="btn btn-primary" id="setAsCaseImage">Set As Case Image</button>
                                @if( !empty($data['target_id'])) <button type="button" class="btn btn-primary" id="setAstargetImage">Set As Target Image</button> @endif
                                @if( !empty($data['subject_id'])) <button type="button" class="btn btn-primary" id="setAsSubjectImage">Set As Subject Image</button> @endif
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

        
        $('#galleryForm').submit();

    });

    $('#setMedia').on('click', function(){
        var mediaContent = $('#galleryDiv1').html();
        $("#appendImgBox").html(mediaContent);

        var mediaUrl = $('#mediaUrl').val();
        $("#profile_pic").val(mediaUrl);
       
        $('#myModal2').modal('hide');  

    });

    $('#setAstargetImage').on('click', function(){
        var r = confirm("Are you sure you want to change Target Image ?");
        if (r == true) {
          var mediaUrl = $('#mediaUrl').val();
          var target_id = $('#target_id').val();
          var subject_id = $('#subject_id').val();
          var case_id = $('#case_id').val();
            $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSetAsTargetImage')}}",
                    dataType: 'html',
                    data: {
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      case_id:case_id,mediaUrl:mediaUrl,target_id:target_id,subject_id:subject_id},
                    success: function (html) {                          
                          $(".case_pic").attr('src', mediaUrl);
                          $('#myModal').modal('hide');  
                          $('#myModal2').modal('hide');  
                          location.reload();
                       }
                    });
          }
    });

    $('#setAsSubjectImage').on('click', function(){
        var r = confirm("Are you sure you want to change Subject Image ?");
        if (r == true) {
          var mediaUrl = $('#mediaUrl').val();
          var subject_id = $('#subject_id').val();
          var case_id = $('#case_id').val();
            $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSetAsSubjectImage')}}",
                    dataType: 'html',
                    data: {
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      case_id:case_id,mediaUrl:mediaUrl,subject_id:subject_id},
                    success: function (html) {                          
                          $(".case_pic").attr('src', mediaUrl);
                          $('#myModal').modal('hide');  
                          $('#myModal2').modal('hide');  
                          location.reload();
                       }
                    });
          }
    }); 

    $('#setAsCaseImage').on('click', function(){
        var r = confirm("Are you sure you want to change Case Image ?");
        if (r == true) {
          var mediaUrl = $('#mediaUrl').val();
          var case_id = $('#case_id').val();
            $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSetAsCaseImage')}}",
                    dataType: 'html',
                    data: {
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      case_id:case_id,mediaUrl:mediaUrl},
                    success: function (html) {
                          
                          $(".case_pic").attr('src', mediaUrl);
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