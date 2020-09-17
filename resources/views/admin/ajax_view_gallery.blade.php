<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- End Datatable -->
<script type="text/javascript">
    $( document ).ready(function() {
    
      $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      });
         
      $.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
      }, "Combination of alphabets,special characters & numeric values required.");
        $('#galleryForm').validate({
            ignore: ".ignore",
            rules: {                
                title:'required',
                description:'required',
                profile_pic:{
                    required: {
                        depends: function(element) {
                            return ($('input[name=file_id]').val() == "");
                        },
                    },
                    
                },
            },
            // Specify validation error messages
            messages: {
                title: "Please enter title.",
                description: "Please enter description.",
                profile_pic: "Please select a file.",
            },
            submitHandler: function(form) {
                   $('#ajaxresp').html('<div class="loader"></div>');
                   var form_data = new FormData(form); 
                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSaveGallery')}}",
                    dataType: 'html',
                    data:form_data,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                    $('#ajaxresp').html(response);
                    $('#addDiv').hide('slow');
                    $('#addFilebtn').show('slow');
                    //$('#myModal').modal('hide');
                     //location.reload();
                       }
                    });
                }
        });
    });
  
</script>
<?php $file_id = ''; $title = ''; $description = ''; $profile_pic = '';?>
<!-- Trigger the modal with a button -->
        <div class="modal" tabindex="-1" role="dialog" id="myModal2">
            <div class="modal-dialog" role="document">
                <form name="galleryForm" id="galleryForm" method="post" action="">
                  <input type="hidden" name="target_id" id="target_id"  value="<?php echo @$data['target_id'];?>">
                  <input type="hidden" name="subject_id" id="subject_id"  value="<?php echo @$data['subject_id'];?>">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                <h4 class="modal-title">Select From Gallery</h4>
                </div>         
                <div class="modal-body" id="addDiv" style="display:none;">             
                </div>               
                <div class="modal-body">
                      <div class="row">
                          <div class="col-sm-8">
                          </div>
                          <div class="col-sm-4" class="float-sm-right"> 
                                     
                                     <button type="button" class="btn btn-primary pull-right" id="addFilebtn" onclick="addGalleryDetails(0,<?php echo $data['case_id']; ?>,'{{route('admin-ajaxEditGalleryDetails')}}');">Add file</button>
                                </div>
                      </div>
                      <br>
                     <div class="row">
    <div class="col-sm-12" id="ajaxresp">
        

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
                              <a onclick="viewGalleryDetails(this, <?php echo $row->id; ?>, '{{route('admin-ajaxViewGalleryDetails')}}');"  class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="{{get_image_url(@$profile_pic,'files')}}" alt="">
          </a>
          <?php echo "<p>".substr($row->title, 0,30)."</p>"; ?>
           </div>
                              <?php
                              }
                            else
                              {
                             ?>
                              <!-- <a href="{{get_image_url(@$profile_pic,'files')}}">{{$profile_pic}}</a> -->
                              <?php
                              }
                                ?> 
                         @endif
                    
          
       
         @endforeach
                          @else
                          @endif
        
      </div>
    
    </div>
</div>
                </div>
        </form>  
    

                </div>
            </div>
        </div>

<!--   New Block -->
<script type="text/javascript">
   var addGalleryDetails = function(file_id, case_id, link1) {
          
          $('#addDiv').html('<div class="loader"></div>');
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    file_id:file_id,case_id:case_id 
                    },
                    success: function (data) {

                        $('#addDiv').show('slow');
                        $('#addDiv').html(data);
                        
                       
                       
                   

                       }
                    });
    
    };


    var editGalleryDetails = function(file_id, link1) {
          
          $('#addDiv').html('<div class="loader"></div>');
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    file_id:file_id
                    },
                    success: function (data) {

                        $('#addDiv').show('slow');
                        $('#addDiv').html(data);
                        
                       
                       
                   

                       }
                    });
    
    };

    var viewGalleryDetails = function(e1, file_id, link1) {
      //var rr = $(e1).attr("class");
      var operation_type = $('#operation_type').val();
      
     // operation_type = 'view_target';
      var target_id  = $('#target_id').val();
      if(target_id == '') { target_id = 0;}
      var subject_id  = $('#subject_id').val();
      if(subject_id == '') { subject_id = 0;}
      $(".d-block").removeClass("active");
         $(e1).addClass("active");
          $('#addDiv').html('<div class="loader"></div>');
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    file_id:file_id,target_id:target_id,subject_id:subject_id
                    },
                    success: function (data) {

                        $('#addDiv').show('slow');
                        $('#addDiv').html(data);
                        
                          if(operation_type=="view_subject" || operation_type=="view_target" ){

                          $('#setAsCaseImage').hide();
                              if(operation_type=="view_subject"){
                                $('#setMedia').html("Set As Subject Image");
                              }
                              if(operation_type=="view_target"){
                                $('#setMedia').html("Set As Target Image");
                              }
                          }
                          if(operation_type=="change_case_image"){

                          $('#setMedia').hide();
                          }
                       
                   

                       }
                    });
    
    };

    
    $('#saveFile1').on('click', function(){
      
        
        $('#modalform1').submit();

    });

    $('#displayAddBox').on('click', function(){

        
        $('#addDiv').hide('slow');
        $('#addFilebtn').show('slow');

    });

   $( document ).ready(function() {
  
    
 });

</script>
   