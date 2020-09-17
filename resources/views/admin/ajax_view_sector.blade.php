<?php 

//echo $data['caseList']->account_id;
//dd($data); 
//dd($data['sectorListByAccount']);

 //dd($data['getAllSectorByCaseId']);
                         
?>
<!-- START Datatable -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<!-- END Datatable -->
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">

<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

<!-- Start Datatable -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
     $(document).ready(function(){

       $("#modalformss :input").change(function() {
            $("#page_change_status").val("1");
       });

 
   
    });
</script>
<!-- End Datatable -->
<script type="text/javascript">
    $( document ).ready(function() {
    
      $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      });
         
      $.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
      }, "Combination of alphabets,special characters & numeric values required.");
        $('#modalformss').validate({
           // ignore: ".ignore",
            rules: {
                
                title:'required',
                description:'required',
                sector_id:'required',
                source:'required',
                occurance_date:{
                    required: {
                        depends: function(element) {
                            //$('#timeline_chart_visibility').prop( "checked", true);
                            var isChecked = $('#timeline_chart_visibility').is(':checked');
                            return isChecked;
                            //return ($("input[name=timeline_chart_visibility]").val() != "");
                        },
                    },
                    
                },

                

              
            },
            // Specify validation error messages
            messages: {
              
                
                title: "Please enter title.",
                description: "Please give the factor details.",
                sector_id: "Please select sector from the list.",
                source: "Please enter source.",
                occurance_date : "Please choose the occurance date."
                
                
            },
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      
        var page_change_status = parseInt($("#page_change_status").val());
        if(page_change_status){
                    var sdata = new FormData(form);
                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSaveFactor')}}",
                   // dataType: 'html',
                    data:sdata,
                    success: function (response) {
                    //result=html.split('#');
                    $('#ajaxresp').html(response);
                    $('#myModal').modal('hide');
                     location.reload();

                       },
					   cache: false,
					contentType: false,
					processData: false
                    });
                }
                else{
                   //$('#myModal').modal('toggle');
                    $('#myModal').modal('hide');
                     location.reload();
                }

    }

        });
    });
  
</script>

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
<!-- Trigger the modal with a button -->
        
    
        <div class="modal" tabindex="-1" role="dialog" id="myModal" style="overflow-x: hidden;overflow-y: auto;">
            <div class="modal-dialog" role="document">
                <form name="modalformsss" id="modalformss" method="post" enctype="multipart/form-data"action="">
                    <input type="hidden" name="page_change_status" id="page_change_status" value="0">
                <div class="modal-content">
                <div class="modal-header">
                <button  type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                <h4 class="modal-title">Factor Form</h4>
                </div>
               
				<div class="modal-body"> 


					<?php
					
					//if(count($data['factorDetailsArray'])>0){
					if($data['factorDetailsArray']){
						@$title=$data['factorDetailsArray']->title;
						@$description=$data['factorDetailsArray']->description;
						@$rank_id=$data['factorDetailsArray']->rank_id;
						@$sector_id=$data['factorDetailsArray']->sector_id;
						@$source=$data['factorDetailsArray']->source;
						@$occurance_date=$data['factorDetailsArray']->occurance_date;
						@$target_chart_visibility=$data['factorDetailsArray']->target_chart_visibility;
						@$timeline_chart_visibility=$data['factorDetailsArray']->timeline_chart_visibility;
						@$chart_icon=$data['factorDetailsArray']->chart_icon;
					}
					
					?>

                    <div class="inner-div" style="padding:10px">
                      
						<input type="hidden" name="token" id="token" value="">
                        <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
                        <input type="hidden" name="case_id" value="<?php echo $data['caseList']->id; ?>">
                        <input type="hidden" name="factor_id" class="factorClass" value="<?php echo $data['factor_id']; ?>">
                        <input type="text" id="title" name="title" placeholder="Title" value="<?php echo @$title?>" class="form-control input-sm"/><br/>
                        <div>
                            <select id="rank_id" name="rank_id" class="form-control input-sm">
							 <option value="">Rank</option>
                                <option <?php if(@$rank_id==1)echo 'selected=selected';?> value="1">1</option>
                                <option <?php if(@$rank_id==2)echo 'selected=selected';?> value="2">2</option>
                                <option <?php if(@$rank_id==3)echo 'selected=selected';?> value="3">3</option>
                                <option <?php if(@$rank_id==4)echo 'selected=selected';?> value="4">4</option>
                                <option <?php if(@$rank_id==5)echo 'selected=selected';?> value="5">5</option>
                                <option <?php if(@$rank_id==6)echo 'selected=selected';?> value="6">6</option>
                                <option <?php if(@$rank_id==7)echo 'selected=selected';?> value="7">7</option>
                                <option <?php if(@$rank_id==8)echo 'selected=selected';?> value="8">8</option>
                                <option <?php if(@$rank_id==9)echo 'selected=selected';?> value="9">9</option>
                                <option <?php if(@$rank_id==10)echo 'selected=selected';?> value="10">10</option>
                            </select>
                        </div>
                        <br/>
                        
 <div id="SectorDiv">
                                    
			<select id="sector_id" name="sector_id" class="form-control input-sm">
			<option value="">Sector</option>
			 <?php 
                foreach($data['sectorListByAccount'] as $key=>$row){

                ?>
                
				 
				   <option <?php if(@$sector_id==$row->id)echo 'selected=selected';?> value="<?php echo $row->id; ?>"><?php echo $row->sector_name; ?></option>
                
                <?php
                }
                
                ?>
			  
		</select>
            


            
                        </div>

                       


                        <br/>
                         <input type="text" id="source" placeholder="Source" name="source"  class="form-control input-sm" value="<?php echo @$source?>"/><br/><br/>
                         Occurence Date: <br/><input type="text" id="occurance_date" class="datespicker1 form-control input-sm" name="occurance_date" value="<?php echo @$occurance_date?>"/> <span class="add-on"><i class="icon-calendar" id="cal"></i></span><br/><br/>  
					   <?php 
            $allowRolesList = array("agencySuperAdmin", "agencyAdmin", "agencyUser");
            $user_role_name = Session::get('user_role_name');
			$v='';
            if (in_array($user_role_name, $allowRolesList)&&isset($data['factor_id'])&&!empty($data['factor_id']))
            {
			$v='1';
            ?>
                          <!--  <button type="button" class="btn btn-warning" onclick="open_factor_file(<?php echo @$data['caseList']->id; ?>,<?php echo @$data['factor_id']; ?>, '{{route('admin-ajaxGetFactorFileDetails')}}');">Link Files</button><br/><br/>
								 <input type="hidden" name="temp_id" id="temp_id" value="" >-->
                                <?php }else{ $temp_id=uniqid();?>
								 <input type="hidden" name="temp_id" id="temp_id" value="<?php echo $temp_id;?>" >
								 <button type="button" class="btn btn-warning"  onclick="open_factor_file( '<?php echo @$data['caseList']->id; ?>','<?php echo @$temp_id; ?>','{{route('admin-ajaxGetFactorFileDetails')}}');">Link Files</button><br/><br/>
								 <?php }?>
                        <input type="checkbox" id="target_chart_visibility"  name="target_chart_visibility" <?php if(@$target_chart_visibility=='y')echo 'checked=checked';?>/> Show on Target Chart? <br/><br/>
                        <input type="checkbox" id="timeline_chart_visibility"  name="timeline_chart_visibility" <?php if(@$timeline_chart_visibility=='y')echo 'checked=checked';?> /> Show on timeline? <br/><br/>
						Chart Icon: <br/>  <select id="chart_icon" name="chart_icon" class="form-control input-sm">
							 <option value="">Chart Icon</option>
                                <option <?php if(@$chart_icon=='social_media_icon')echo 'selected=selected';?> value="social_media_icon">social media icon</option>
                                <option <?php if(@$chart_icon=='pdf_icon')echo 'selected=selected';?> value="pdf_icon">pdf icon</option>
                                <option <?php if(@$chart_icon=='interview_icon')echo 'selected=selected';?> value="interview_icon">interview icon</option>
                                <option <?php if(@$chart_icon=='criminal_history_icon')echo 'selected=selected';?> value="criminal_history_icon">criminal history icon</option>
                                <option <?php if(@$chart_icon=='weapon_icon')echo 'selected=selected';?> value="weapon_icon">weapon icon</option>
								 <option <?php if(@$chart_icon=='health_icon')echo 'selected=selected';?> value="health_icon">health icon</option>
                                <option <?php if(@$chart_icon=='incident_report_icon')echo 'selected=selected';?> value="incident_report_icon">incident report icon</option>
                            </select><br/><br/>
					</div>
                    <div class="inner-div"  style="padding:10px">
					
					<?php if(empty($v)){ ?>
								<!--<input type="file" name="profile_pic"  class="form-control input-sm" value=""/><br/><br/>-->
								<?php }?>
                        @if(@$data['factorDetailsArray']->default_pic!='')
                         <?php
							$profile_pic=@$data['factorDetailsArray']->default_pic;
                            $path = get_image_url($profile_pic,'package');
                            $ext = pathinfo($profile_pic, PATHINFO_EXTENSION); 
                            $extensionsArray = array('jpg', 'JPG', 'png' ,'PNG' ,'jpeg' ,'JPEG');
                            if (in_array($ext, $extensionsArray))
                              {
                              
                              ?>
                              <img src="{{get_image_url(@$profile_pic,'package')}}" class="img-responsive factor_pic" style="width:auto;padding:10px;">
                              <?php
                              }
                            else
                              {
							  ?>
                              <a href="{{get_image_url(@$profile_pic,'package')}}"><img class="img-responsive factor_pic" src="{{asset('images/download_file.png')}}" style="cursor:pointer;width:100px;height:100px;padding:10px;"></a>
                              <?php
                              }

                                ?>   
                         @else
                        <img src="{{asset('images/noImageSelected.jpg')}}" alt="gravitor" style="width:100%" class="img-responsive factor_pic">
                        @endif
                        </a>
					  
                        

                        <br/><br/>
                        <textarea class="form-control input-sm" type="text" id="description" style="height:100px;" name="description" placeholder="Description"><?php echo @$description?></textarea><br/>
                    </div>
					
                    <div style="clear:both"></div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="deleteFactor">Delete Factor</button>
                    <button type="button" class="btn btn-primary" id="saveBt">Save changes</button>
                    <button type="button" class="btn btn-secondary closebutton" data-dismiss="modal">Close</button>
                </div> <?php if (in_array($user_role_name, $allowRolesList)&&isset($data['factor_id'])&&!empty($data['factor_id']))
            {
			$v='1';
            ?>  <div class="row">
    <div class="col-sm-12">
                     <button type="button" class="btn btn-warning" onclick="open_factor_file(<?php echo @$data['caseList']->id; ?>,<?php echo @$data['factor_id']; ?>, '{{route('admin-ajaxGetFactorFileDetails')}}');" style="margin-left: 15px;">Link Files</button><br/>
								 <input type="hidden" name="temp_id" id="temp_id" value="" >
                               </div>
                </div> <?php }?></form> 
                <div class="modal-body">
            @if(isset($data['fileListArray']))
                     <div class="row">
    <div class="col-sm-12" id="ajaxresp">
	<h3 style="">Factor Linked Files</h3>
	<div class="box-body table-responsive no-padding" style="max-height:300px;overflow:auto;margin-top:20px;">
                        <table class="table table-hover" id="printTable">
                            <tbody><tr>
                                <!--<th>Sr.No.</th>-->
                                <th width="25%">Title</th>
                                <th>Type</th>
                                <th>Created Date</th>
								<th width="15%">Default Image</th>
                                <th width="15%">Action</th>
                            </tr>
               @if(count($data['fileListArray'])>0)                                                                                              
            @foreach($data['fileListArray'] as $key=>$row)   
                          
            <tr>
                <!--<td>{{$key+1}}</td>-->
                <td><?php echo $row->title; ?></td>
                <td> <?php
					 $profile_pics = isset($row->profile_pic)?$row->profile_pic:'';
					 ?>
					 @if(@$profile_pics!='')
                              <?php
                            $path = get_image_url($profile_pics,'files');
                            $ext = pathinfo($path, PATHINFO_EXTENSION); 
							echo $ext; ?>
							@endif</td>
                <td><?php echo date("F j, Y", strtotime($row->created_at));
				$profile_pic="";
				if(isset($profile_pic)&&!empty($profile_pic)){
				$profile_pic=str_replace('factor_','',$profile_pic);
				}?></td>
                <td><?php if(isset($profile_pic)&&!empty($profile_pic)&&isset($profile_pics)&&!empty($profile_pics)&&$profile_pic==$profile_pics){?>
				<span style="color:green;font-weight:bold;">Default Image</span>
				<?php }else{?><button type="button" class="btn btn-info"  onclick="add_default_factor_file('<?php echo @$path; ?>',<?php echo @$data['factor_id']; ?>, '{{route('admin-ajaxSetAsFactorImage')}}');">Add Default</button>
				<?php }?>
				</td>
				<td>
				<form id="frm_{{$row->id}}" class="form-horizontal" action="javascript:void(0);" onsubmit="return unlink_factor_file(this);" method="POST" enctype="multipart/form-data"> <input type="hidden" name="factor_id" value="<?php echo $data['factor_id'];?>">
				<input type="hidden" name="file_select[<?php echo $row->id; ?>]" class="file_selects" value="<?php echo $row->id; ?>">
                                <button type="submit" class="btn btn-danger" id="displayAddBox">Unlink</button>
	</form>    </td>
            </tr>
                          @endforeach
						  @else
						  <tr><td colspan="5"><h6 style="text-align:center;">Record Not Found</h6></td></tr>
						      @endif
                                                                                </tbody></table>
                    </div>
   
    </div>
                    </div> 
                          @else
                          @endif
                </div>
        
    

                </div>
            </div>
        </div>
<!--   New Block -->
<script>
$('.datespicker1').datepicker({ dateFormat: 'yy-mm-dd' });
     var open_factor_gallery_modal_to_update_case_image = function(case_id,factor_id, link1) {
         // $('#operation_type').val("change_case_image");
		  $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    case_id:case_id, factor_id:factor_id 
                    },
                    success: function (data) {

                      
                        $('#factorgalleryDetails').html(data);
                        //$('#modalBt').trigger('click');
                        $('#myModal3').modal('show');  
                       
                       
                   

                       }
                    });

    
    };

  var add_default_factor_file = function(mediaUrl,factor_id, link1) {
         // $('#operation_type').val("change_case_image");  

        var r = confirm("Are you sure you want to change Factor Image to default ?");
        if (r == true) {
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
                          
                          open_factor_modal('<?php echo $data['factor_id'];?>', '<?php echo @$data['caseList']->id; ?>');
                       }
                    });
          }



        

    };
	  var open_factor_file = function(case_id,factor_id, link1) {
         
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
  var unlink_factor_file = function(frm) {

        var r = confirm("Are you sure you want to unlink this Factor Image ?");
        if (r == true) {
                    var form_data = new FormData(frm);
                   
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
                   // $('#factorDetailsModal').modal('hide');
				   open_factor_modal('<?php echo $data['factor_id'];?>', '<?php echo @$data['caseList']->id; ?>');
					//$('#myModal').modal('hide');  
                     //     $('#myModal2').modal('hide');  
                    // location.reload();
					
                       }
                    });
		  }



        

    };


</script>
<script type="text/javascript">
   
   $('#myModal .close,#myModal .closebutton').on('click', function(){
	   $('.modal-backdrop').remove();
	});
    $('#saveBt').on('click', function(){

        $('#modalformss').submit();

    });

    $('#deleteFactor').on('click', function(){

        var factor_id = $('.factorClass').val();


        var r = confirm("Are you sure you want to delete ?");
        if (r == true) {
            $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxDeleteFactor')}}",
                    dataType: 'html',
                    data: {
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      factor_id:factor_id},
                    success: function (html) {
                    $('#myModal').modal('hide');
                     location.reload();
                       }
                    });
          } 
                    
    });


    





    $('#saveSector').on('click', function(){


          var sdata = $("#addSectorForm").serialize();

                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSaveSector')}}",
                    dataType: 'html',
                    data:sdata,
                    success: function (response) {

                    $('#myDropdown').html(response);
                    $('#add-sector').modal('hide');
                    

                       }
                    });

           

    });

    
     var open_factor_file_modal = function(file_id, case_id, link1, link2) {
          
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

                      
                        $('#sectorDetails').html(data);
                        $('#modalBt').trigger('click');
                       
                       
                   

                       }
                    });

    
    };

    function editSectorDetails(factor_id){

          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxAssignFactorDetails')}}",
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    factor_id:factor_id
                    },
                    success: function (data) {

                        
                        
                    // Parse the data as json
                    var obj = JSON.parse(data)
                   
                    
                    $('#title').val(obj.title);
                    $('#description').val(obj.description);
                    $('#source').val(obj.source);
                    $('#occurance_date').val(obj.occurance_date);
                    $('#rank_id').val(obj.rank_id);
                    $('#sector_id').val(obj.sector_id);
                    $('.factorClass').val(obj.factor_id);
                    $('.dropbtn').html(obj.sector_name);
                    

                    if(obj.target_chart_visibility=="y"){
                        $('#target_chart_visibility').prop( "checked", true);
                    }
                    else{
                        $('#target_chart_visibility').prop( "checked", false);
                    }

                    if(obj.timeline_chart_visibility=="y"){
                        $('#timeline_chart_visibility').prop( "checked", true);
                    }
                    else{
                        $('#timeline_chart_visibility').prop( "checked", false);
                    }

                       }
                    });
    
    }
</script>
   