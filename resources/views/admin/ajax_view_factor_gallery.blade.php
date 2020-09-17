<?php 

//echo $data['caseList']->account_id;
//dd_my($data); 
//dd($data['sectorListByAccount']);

 //dd($data['getAllSectorByCaseId']);
                         
?>
<!-- START Datatable -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

<!-- END Datatable -->
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">

<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->


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
        $('#factorgalleryForm').validate({
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
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      

                   $('#ajaxresp').html('<div class="loader"></div>');
                   var form_data = new FormData(form); 
                   

                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSaveFactorGallery')}}",
                    dataType: 'html',
                    data:form_data,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                    //result=html.split('#');
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
  <?php //dd($data['fileDetailsArray']); 
                      
/*$file_id = isset($data['fileDetailsArray']->id)?$data['fileDetailsArray']->id:'';

$title = isset($data['fileDetailsArray']->title)?$data['fileDetailsArray']->title:'';
$description = isset($data['fileDetailsArray']->description)?$data['fileDetailsArray']->description:'';
$profile_pic = isset($data['fileDetailsArray']->profile_pic)?$data['fileDetailsArray']->profile_pic:'';*/
$file_id = '';
$title = '';
$description = '';
$profile_pic = '';

                      ?>

<!-- Trigger the modal with a button -->
  
    <div class="modal" tabindex="-1" role="dialog"  id="factorDetailsModal" style="z-index:9999;">
            <div class="modal-dialog" role="document">
			<div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                <h4 class="modal-title">Add Case Files for Factors</h4>
                </div>
                <div class="modal-body">
				 <div id="factorDetails">
				</div>
				</div>
				</div>
			</div>
</div>      
    
        <div class="modal" tabindex="-1" role="dialog" id="myModal3">
            <div class="modal-dialog" role="document">
                <form name="factorgalleryForm" id="factorgalleryForm" method="post" action="">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                <h4 class="modal-title">Select From Factor Gallery</h4>
                </div>

          
                <div class="modal-body" id="addDiv" style="display:none;">

                
                </div>
                
                <div class="modal-body">
                      <div class="row">
                          <div class="col-sm-8">
						   <a href="javascript: void(0);" class="btn btn-default" style="width:100%" onclick="open_factor_file_modal( '<?php echo @$data['case_id']; ?>','<?php echo $data['factor_id']; ?>','{{route('admin-ajaxGetFactorFileDetails')}}');">Case Files</a>
                          </div>
                          <div class="col-sm-4" class="float-sm-right"> 
                                     
                                     <button type="button" class="btn btn-primary pull-right" id="addFilebtn" onclick="addFactorGalleryDetails(0,'<?php echo $data['factor_id']; ?>','{{route('admin-ajaxEditFactorGalleryDetails')}}');">Add file</button>
									 
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
                              <a onclick="viewFactorGalleryDetails(this, <?php echo $row->id; ?>, '{{route('admin-ajaxViewFactorGalleryDetails')}}');" class="d-block mb-4 h-100" style="cursor:pointer">
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
    
    </div>
</div>
                </div>
        </form>  
    

                </div>
            </div>
        </div>

<!--   New Block -->
<script type="text/javascript">
   var addFactorGalleryDetails = function(file_id, factor_id, link1) {
          
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
                    file_id:file_id,factor_id:factor_id 
                    },
                    success: function (data) {

                        $('#addDiv').show('slow');
                        $('#addDiv').html(data);
                        
                       
                       
                   

                       }
                    });
    
    };


    
     var open_factor_file_modal = function(case_id,factor_id, link1) {
         
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    case_id:case_id,factor_id:factor_id
                    },
                    success: function (data) {

                      
                        $('#factorDetails').html(data);
                        $('#factorDetailsModal').modal('show');
                       
                       
                   

                       }
                    });

    
    };

    var editFactorGalleryDetails = function(file_id, link1) {
          
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

    var viewFactorGalleryDetails = function(e1, file_id, link1) {
      //var rr = $(e1).attr("class");
      var operation_type = $('#operation_type').val();
      
      

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
                    file_id:file_id
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

    
     var addFileFactorDetails = function(case_id, link1) {
          
		  var frm= $('#modalform5').serialize();
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    data:frm, 
                    },
                    success: function (data) {

                      /*
                        $('#factorDetails').html(data);
                        $('#factorDetailsModal').modal('show');
                       */
                       
                   

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
   