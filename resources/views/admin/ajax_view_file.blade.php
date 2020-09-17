<?php $linkedtype='case'; ?> 
<!-- START Datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<!-- END Datatable -->
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!-- Start Datatable -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/amstockchart/3.13.0/exporting/rgbcolor.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/canvg.js"></script>

<style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;} figcaption{display:none_;} </style> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script> 
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">

<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->


<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- End Datatable -->
<script type="text/javascript">
    $( document ).ready(function() {        $.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
      }, "Combination of alphabets,special characters & numeric values required.");	  
        $('#modalform').validate({
            ignore: ".ignore",
            rules: {                
                title:'required',
                description:'required',
                profile_pic:{required:true}
            },
            // Specify validation error messages
            messages: {       
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
                    url: "{{route('admin-ajaxSaveFile')}}",
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
					$('.sectortbl111').show('slow');
                    //$('#myModal').modal('hide');
                     //location.reload();

                       }
                    });

    }

        });
    });
  
</script>
<div id="sectorDetails"></div>
<div id="descriptionDetails"></div>
<div id="galleryDetails"></div>
<div id="factorgalleryDetails"></div>
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
        
    
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <form name="modalform" id="modalform" method="post" action="">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                <h4 class="modal-title">Manage Files</h4>
                </div>

            

               
                <div class="modal-body" id="addDiv" style="display:none;">

                <div class="row">
                    <div class="col-sm-12">                      
                        <input type="hidden" name="token" id="token" value="">
                        <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
                        <input type="hidden" name="case_id" value="<?php echo $data['caseList']->id; ?>">
                        <input type="hidden" name="file_id" id="file_id" value="<?php echo $file_id; ?>"  class="subjectClass" value="">
                         <br/>
                         @if(@$profile_pic!='')
                        <div class="row">
                                <div class="col-sm-8">
                                    
                        
                        <img src="{{get_image_url(@$profile_pic,'files')}}" style="width:100px;height:100px">
                       
                       
                                </div>
                        </div>
                         @endif
                        

                        <br/>

                        <div class="row">
                                <div class="col-sm-4">File:</div>
                                <div class="col-sm-4"> <input type="file" id="profile_pic"  name="profile_pic" data-buttonName="btn-primary">
                                </div>
                        </div>
                        <br/>
                        <div class="row">
                                <div class="col-sm-4">Title:</div>
                                <div class="col-sm-4">  <input type="text" id="title" name="title" value="<?php echo $title; ?>" placeholder="Title" style="border:1px solid black;"/>
                                </div>
                        </div>
                        <br/>
                        <div class="row">
                                <div class="col-sm-4">Description:</div>
                                <div class="col-sm-4">  <input type="text" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>"  style="border:1px solid black;"/>
                                </div>
                        </div>
                        <br/> <br/>
                        <div class="row">

                            <div class="col-sm-4">
                                <button type="button" class="btn btn-danger" id="displayAddBox2">Cancel</button>
                            </div>
                            <div class="col-sm-4"> 
                                 
                                 <button type="button" class="btn btn-primary" id="saveFile">Upload</button>
                            </div>
                       
                        </div>


                    </div> </div>
                    <div style="clear:both"></div>
                </div>
                
                <div class="modal-body sectortbl111">
                      <div class="row">
                          <div class="col-sm-8">
                          </div>
                          <div class="col-sm-4" class="float-sm-right"> 
                                     
                                     <button type="button" class="btn btn-primary pull-right" id="addFilebtn" onclick="addFileDetails(0,<?php echo $data['caseList']->id; ?>,'{{route('admin-ajaxEditFileDetails')}}');">Add file</button>
                                </div>
                      </div>
                      <br>
                     <div class="row">
    <div class="col-sm-12" id="ajaxresp">
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
                <td>
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
                              <img src="{{get_image_url(@$profile_pic,'files')}}" style="width:100px;height:100px">
                              <?php
                              }
                            else
                              {
                             ?>
                              <a href="{{get_image_url(@$profile_pic,'files')}}">Download file</a>
                              <?php
                              }
                                ?> 
                         @endif
                    <?php echo "<br><br><br>".$row->title; ?></td>
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
    </div>
</div>
                </div>
        </form>  
    

                </div>
            </div>
        </div>

<!--   New Block -->
<script type="text/javascript">
   $( document ).ready(function() {
    $('#saveFile').on('click', function(){

        
        $('#modalform').submit();

    });

   

    $('#displayAddBox2').on('click', function(){

        
        $('#addDiv').hide('slow');
        $('#addFilebtn').show('slow');
		$('.sectortbl111').show('slow');
    });

    
 });

</script>

<script src="{{asset('js/script.js')}}"></script>
<script src="{{asset('js/subject.js')}}"></script>
<script src="{{asset('js/target.js')}}"></script>
<script src="{{asset('js/files.js')}}"></script>
<script src="{{asset('js/description.js')}}"></script>
<script> 
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
  return false;
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {

  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}


function set_sector(id, sector_name){

  $('#sector_id').val(id);
  $('.dropbtn').html(sector_name);


}

/* New code By Subhendu 15-05-2018 */
$(document).ready(function(){

  $('#myModal').on('hidden.bs.modal', function () {
   location.reload();
 })



  $('.addTask').on('click', function(){

    AddDbclk = 0;
    var case_id = $('#modalCaseId').val();

    open_task_modal(0, case_id);

    $('#deleteTask').hide();

  }); 

  $('#addTask').on('click', function(){

    AddDbclk = 0;
    var case_id = $('#modalCaseId').val();

    open_task_modal(0, case_id);

    $('#deleteTask').hide();

  });
  $('#view_previous_add_note').click(function(){

   $('.note_add_message_content').css('overflow','auto');
   $('#view_previous_add_note').hide();
   $('#view_previous_add_note_show').show();
 });
  $('#view_previous_add_note_show').click(function(){

   $('.note_add_message_content').css('overflow','hidden');
   $('#view_previous_add_note').show();
   $('#view_previous_add_note_show').hide();
 });


  $('#addBt').on('click', function(){

    AddDbclk = 0;
    var case_id = $('#modalCaseId').val();
                    //formatModal();
                    open_factor_modal(0, case_id);
                    $('#rank_id').val(10);
                    //$('#SectorDiv').hide();
                    $('#deleteFactor').hide();

                  });
});
</script>
   