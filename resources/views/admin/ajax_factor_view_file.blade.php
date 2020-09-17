<?php 

//echo $data['caseList']->account_id;
//dd($data); 
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
    
     
      $.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
      }, "Combination of alphabets,special characters & numeric values required.");
	  
        $('#modalforms').validate({
            ignore: ".ignore",
            rules: {
                
               /* title:'required',
                description:'required',
                profile_pic:{required:true}*/
                    
                
                

              
            },
            // Specify validation error messages
            messages: {
              
                
               
                
                
                
                
            },
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
               //$('#ajaxresp').html('<div class="loader"></div>');
                   var form_data = new FormData(form); 
                   
				 if($('#assigns').val()=='1'){
                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-addFileFactorDetails')}}",
                    dataType: 'html',
                    data:form_data,
                    //mimeType: "multipart/form-data",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                    //result=html.split('#');
                   // $('#ajaxresp').html(response);
                    //$('#addDiv').hide('slow');
                   // $('#addFilebtn').show('slow');
                    // location.reload();
                    //$('#factorDetailsModal').modal('hide');
					$('#display-message').html('<span style="color:green">File Added Successfully.</span>');
					var temp_id=$('#temp_id').val();
					if(temp_id==''){
						open_factor_modal('<?php echo $data['factor_id'];?>', '<?php echo @$data['caseList']->id; ?>');
					}
                       }
                    });
				}
				if($('#assigns').val()=='2'){
                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxDeleteFileFactorDetails')}}",
                    dataType: 'html',
                    data:form_data,
                    //mimeType: "multipart/form-data",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                    //result=html.split('#');
                   // $('#ajaxresp').html(response);
                    //$('#addDiv').hide('slow');
                   // $('#addFilebtn').show('slow');
                    $('#factorDetailsModal').modal('hide');
                    // location.reload();

                       }
                    });
				}

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
        
                <form name="modalform" id="modalforms" method="post" action="">
               <input type="hidden" name="factor_id" value="<?php echo $data['factor_id'];?>">
               
                     <div class="row">
    <div class="col-sm-12" id="ajaxresp">
	<div id="display-message"></div>
	<div class="box-body table-responsive no-padding" style="max-height:300px;overflow:auto;margin-top:20px;">
                        <table class="table table-hover" id="printTable">
                            <tbody><tr>
                                <!--<th>Sr.No.</th>-->
                                <th>Select</th>
                                <th width="25%">Title</th>
                                <th>Type</th>
                                <th>Created Date</th>
                            </tr>
                                 
                @if(count($data['fileListArray'])>0)                                                                           
            @foreach($data['fileListArray'] as $key=>$row)   
                          
            <tr>
                <!--<td>{{$key+1}}</td>--> <td><input type="checkbox" name="file_select[<?php echo $row->id; ?>]" class="file_selects" value="<?php echo $row->id; ?>"></td>
                <td>
                   
                    <input type="hidden" name="title[<?php echo $row->id; ?>]" value="<?php echo $row->title; ?>"><?php echo $row->title; ?></td>
                <td><input type="hidden" name="description[<?php echo $row->id; ?>]" value="<?php echo $row->description; ?>"><?php
					 $profile_pic = isset($row->profile_pic)?$row->profile_pic:'';
					 ?>
					 @if(@$profile_pic!='')
                              <?php
                            $path = get_image_url($profile_pic,'files');
                            $ext = pathinfo($path, PATHINFO_EXTENSION); 
							echo $ext; ?>
							@endif</td>
                <td><input type="hidden" name="profile_pic[<?php echo $row->id; ?>]" value="<?php echo $row->profile_pic; ?>"><?php echo date("F j, Y", strtotime($row->created_at));
                           $profile_pic = $row->profile_pic;
                 ?></td>
            </tr>
                          @endforeach
                          @else
                          @endif
                                                                                </tbody></table>
                    </div>
   
    </div>
                    </div> 
	<div class="row">
                          <div class="col-sm-4">
                                     <input type="hidden" id="assigns" value="0">
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									  <button type="button" class="btn btn-info" id="savesFile">Link File</button>
                          </div>
                          <div class="col-sm-8" class="float-sm-right"> 
                                     
									 
                                </div>
								
                      </div>
</div>
                </div>
        </form>  
    

<!--   New Block -->
<script type="text/javascript">
   $( document ).ready(function() {
    $('#savesFile').on('click', function(){
			
		if($('.file_selects:checked').length>0){
			$('#assigns').val('1');
			$('#modalforms').submit();
		}else{
		 alert('please choose any one checkbox');
		 return false;
		}
    });

    $('#unsavesFile').on('click', function(){
	
        if($('.file_selects:checked').length>0){
			$('#assigns').val('2');
			$('#modalforms').submit();
		}else{
		 alert('please choose any one checkbox');
		 return false;
		}

    });

    $('#displayAddBox').on('click', function(){

        
        $('#addDiv').hide('slow');
        $('#addFilebtn').show('slow');

    });

    
 });

</script>
   