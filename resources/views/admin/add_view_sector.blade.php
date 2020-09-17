@extends('layout.backened.header')
@section('content')
<?php //dd($data); ?>
 <div class="clearfix"></div>
 <div class="section" > 
    <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3 class="paddingbottom10px">@if(@$request->id){{'Manage Factor '}} @else {{'Manage Factor Form'}} @endif </h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> {{ 'Home'}}</a></li>
        <li class="active">@if(@$request->id){{'Assign Factor'}} @else {{'Add Factor'}} @endif </li>
      </ol>
        <div style="float:right;">
        <a href="javascript:void(0)" class="btn btn-info btn-xs action-btn edit" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
            <a href="javascript:void(0)" class="btn btn-info btn-xs action-btn view" title ="View"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
         <a href="{{route('admin-delete-target',[$caseId])}}" class="btn btn-info btn-xs action-btn" onclick="return confirm('Are you sure you want to delete ?');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </div>
    </section>
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
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
  <script type="text/javascript">
    $( document ).ready(function() {    
      $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      });
         
      $.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
      }, "Combination of alphabets,special characters & numeric values required.");
        $('#addfactor').validate({
            ignore: ".ignore",
            rules: {                
                name:'required',
                phone_number: {
                    minlength: 6,
                    maxlength: 15,
                    digits: true,
                    required:true,
                },
                 cell_phone: {
                    minlength: 6,
                    maxlength: 15,
                    digits: true,
                     required:true,
                },
                address: {
                    minlength: 4,
                    maxlength: 250,
                    required:true,
                },
                state: {
                    minlength: 3,
                    maxlength: 200,
                    required:true,
                },
                city: {
                    minlength: 3,
                    maxlength: 200,
                    required:true,
                },
                zip_code: {
                    minlength: 3,
                    maxlength: 15,
                    required:true,
                },
            },
            // Specify validation error messages
            messages: {
                name: "Please enter name.",
            },
        });
    });
  
</script>
<!-- Trigger the modal with a button -->
        <button id="modalBt" type="button" class="btn btn-info btn-lg hidden" data-toggle="modal" data-target="#myModal">Open Modal</button>
<div id="galleryDetails"></div>
 
      <div class="row">
        <div class="col-md-10">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              @if(Session::has('add_message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('add_message') !!} 
                </div>
                @endif
            </div>
            <!-- /.box-header -->   
            <!-- form start -->   
      <?php
             // dd($data);
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
            <form class="" id="addfactor" action=""  method="POST" enctype="multipart/form-data"> 
            {{ csrf_field() }}
                <input type="hidden" name="token" id="token" value="">
                <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
                <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
                <input type="hidden" name="case_id" value="<?php echo $data['caseList']->id; ?>">
                <input type="hidden" name="factor_id" class="factorClass" value="<?php echo $data['factor_id']; ?>">
                
              <div class="box-body">
                  <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Title {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <input type="text" id="title" name="title" value="{{ @$title }}" placeholder="Title"  class="form-control"/>                    
                        <?php if(@$errors->first('title')) { ?><span class="help-block">{{@$errors->first('title')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('rank_id')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Rank {{redstar()}}</label>
                      <div class="col-sm-7">   
                         <select id="rank_id" name="rank_id" class="form-control input-sm">
							             <option value="">Rank</option>
                                <option <?php if(@$rank_id==1) echo 'selected=selected';?> value="1">1</option>
                                <option <?php if(@$rank_id==2) echo 'selected=selected';?> value="2">2</option>
                                <option <?php if(@$rank_id==3) echo 'selected=selected';?> value="3">3</option>
                                <option <?php if(@$rank_id==4) echo 'selected=selected';?> value="4">4</option>
                                <option <?php if(@$rank_id==5) echo 'selected=selected';?> value="5">5</option>
                                <option <?php if(@$rank_id==6) echo 'selected=selected';?> value="6">6</option>
                                <option <?php if(@$rank_id==7) echo 'selected=selected';?> value="7">7</option>
                                <option <?php if(@$rank_id==8) echo 'selected=selected';?> value="8">8</option>
                                <option <?php if(@$rank_id==9) echo 'selected=selected';?> value="9">9</option>
                                <option <?php if(@$rank_id==10) echo 'selected=selected';?> value="10">10</option>
                            </select>                   
                        <?php if(@$errors->first('rank_id')) { ?><span class="help-block">{{@$errors->first('rank_id')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('sector_id')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Sector {{redstar()}}</label>
                      <div class="col-sm-7">   
                        <select id="sector_id" name="sector_id" class="form-control input-sm">
                        <?php 
                        foreach($data['sectorListByAccount'] as $key=>$row){?>              
                        <option <?php if(@$sector_id==$row->id) echo 'selected=selected';?> value="<?php echo $row->id; ?>"><?php echo $row->sector_name; ?></option>
                        <?php } ?>
                        </select>                  
                        <?php if(@$errors->first('sector_id')) { ?><span class="help-block">{{@$errors->first('sector_id')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('source')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Source {{redstar()}}</label>
                      <div class="col-sm-7">  
                          <input type="text" id="source" placeholder="Source" name="source"  class="form-control input-sm" value="<?php echo @$source?>"/>                                             
                        <?php if(@$errors->first('source')) { ?><span class="help-block">{{@$errors->first('source')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('occurance_date')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Occurence Date </label>
                      <div class="col-sm-7">  
                          <input type="text" id="occurance_date" class="datespicker1 form-control input-sm" name="occurance_date" value="<?php echo @$occurance_date?>"/> <span class="add-on"><i class="icon-calendar" id="cal"></i></span>                  
                        <?php if(@$errors->first('occurance_date')) { ?><span class="help-block">{{@$errors->first('occurance_date')}}</span> <?php } ?>
                      </div>
                    </div>
                    <?php 
                    $allowRolesList = array("agencySuperAdmin", "agencyAdmin", "agencyUser");
                    $user_role_name = Session::get('user_role_name');
                    $v='';
                    if (in_array($user_role_name, $allowRolesList)&&isset($data['factor_id'])&&!empty($data['factor_id']))
                    {
                    $v='1';
                    ?>
                    <?php }else{ $temp_id=uniqid();?>
                  <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> Link Files</label>
                      <div class="col-sm-7">   
                          <input type="hidden" name="temp_id" id="temp_id" value="<?php echo $temp_id;?>" >
                     <button type="button" class="btn btn-warning"  onclick="open_factor_file( '<?php echo @$data['caseList']->id; ?>','<?php echo @$temp_id; ?>','{{route('admin-ajaxGetFactorFileDetails')}}');">Link Files</button>
                     <?php }?>
                      </div>
                    </div>                 
                  
                     
                  <div class="form-group row @if($errors->first('target_chart_visibility')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Show on Target Chart {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <input type="checkbox" id="target_chart_visibility"  name="target_chart_visibility" <?php if(@$target_chart_visibility=='y')echo 'checked=checked';?>/>                    
                        <?php if(@$errors->first('target_chart_visibility')) { ?><span class="help-block">{{@$errors->first('target_chart_visibility')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('timeline_chart_visibility')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Show on timeline? {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <input type="checkbox" id="timeline_chart_visibility"  name="timeline_chart_visibility" <?php if(@$timeline_chart_visibility=='y')echo 'checked=checked';?> />                   
                        <?php if(@$errors->first('timeline_chart_visibility')) { ?><span class="help-block">{{@$errors->first('timeline_chart_visibility')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('chart_icon')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Chart Icon {{redstar()}}</label>
                      <div class="col-sm-7">   
                        <select id="chart_icon" name="chart_icon" class="form-control input-sm">
							 <option value="">Chart Icon</option>
                                <option <?php if(@$chart_icon=='social_media_icon')echo 'selected=selected';?> value="social_media_icon">social media icon</option>
                                <option <?php if(@$chart_icon=='pdf_icon')echo 'selected=selected';?> value="pdf_icon">pdf icon</option>
                                <option <?php if(@$chart_icon=='interview_icon')echo 'selected=selected';?> value="interview_icon">interview icon</option>
                                <option <?php if(@$chart_icon=='criminal_history_icon')echo 'selected=selected';?> value="criminal_history_icon">criminal history icon</option>
                                <option <?php if(@$chart_icon=='weapon_icon')echo 'selected=selected';?> value="weapon_icon">weapon icon</option>
								 <option <?php if(@$chart_icon=='health_icon')echo 'selected=selected';?> value="health_icon">health icon</option>
                                <option <?php if(@$chart_icon=='incident_report_icon')echo 'selected=selected';?> value="incident_report_icon">incident report icon</option>
                         </select>                 
                        <?php if(@$errors->first('chart_icon')) { ?><span class="help-block">{{@$errors->first('chart_icon')}}</span> <?php } ?>
                      </div>
                   </div>
                  <div class="form-group row @if($errors->first('description')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Description {{redstar()}}</label>
                      <div class="col-sm-7">  
                          <textarea class="form-control input-sm" type="text" id="description" style="height:100px;" name="description" placeholder="Description"><?php echo @$description?></textarea> 
                        <?php if(@$errors->first('description')) { ?><span class="help-block">{{@$errors->first('description')}}</span> <?php } ?>
                      </div>
                    </div>
                </div>
              <!-- /.box-body -->
              @if(@$type !='view')
              <div class="box-footer">
                <a href="{{route('admin-viewCase',[$caseId])}}" class="btn btn-default">Cancel</a>
                <input type="submit" id="add-button" value="Submit" class="btn btn-info checkimagesize" >
              </div>
              @endif
              <!-- /.box-footer -->
            </form>
          </div>
          
        </div>
        <!--/.col (right) -->
        </div>
       </div> 
      </div>
    <style>
        .error{
            color:red;
        }
    </style>
<script>
     $(document).ready(function(){
      $(".edit").click();
        $('.datespicker1').datepicker({ dateFormat: 'yy-mm-dd' });
        $(".imagediv, .box-footer, .view").show();
        $(".edit").hide();
        //$(".imagediv, .box-footer, .view").hide();
       // $("#addfactor :input").prop("readonly", true);
        $(".edit").on("click", function(){
            $(".imagediv, .box-footer, .view").show();
            $(".edit").hide();
            $("#addfactor :input").prop("readonly", false);
       });
        $(".view").on("click", function(){
            $(".imagediv, .box-footer, .view").hide();
            $(".edit").show();
            $("#addfactor :input").prop("readonly", true);
      });
    });
</script>
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
    $(document).ready(function() {
    $('select>option:eq(1)').prop('selected', true);  
  });
</script>
  @endsection
