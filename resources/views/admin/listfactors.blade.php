@extends('layout.backened.header')
@section('content')
<?php //dd($data['caseDetails']->title);?>
<!-- START Datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<!-- Start Datatable -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;} figcaption{display:nones;} </style> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script> 
<!-- End Datatable -->
<!-- Trigger the modal with a button -->
<div class="clearfix"></div>
 <div class="section" > 
      <div class="container">
         <section class="content-header">    
        <div class="classnameheading">{{ $data['caseDetails']->title }}</div>
        <div class="paddingbottom10px"><h3>@if(@$request->id){{'Manage Factor '}} @else {{'Manage Factor'}} @endif </h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
        <li class="active">@if(@$request->id){{'Add Factor'}} @else {{'Add Factor'}} @endif </li>
      </ol>
	  @if(count($data['getAllSectorByCaseId'])>0)		
		 <div class="margintopminus48">		 
      <input type="hidden" id="filename" name="filename" value="Factor {{ @$data['caseDetails']->title }}">	
      <a href="javascript::void(0)" id="csv" class="btn btn-info btn-xs action-btn edit" title ="Download CSV File"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span></a>        		 
<a href="{{route('admin-download-case-pdf-factorList',['id'=>@$data['caseDetails']->id]) }}" class="btn btn-info btn-xs action-btn edit" title ="Download PDF"><i class="fa fa-file-pdf-o backgroundred" aria-hidden="true"></i></span></a>
        </div>
		@endif
             <div> <span style="float:right;"><a href="{{ url('admin/addNewFactor',[Request::segment(3)])}}" class="btn btn-info btn-xs action-btn">Add New Factor</a></span>
        </div>
    </section>
</div>
        
        
<button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
<!-- Modal HTML -->
<div class="modal" id="add-sector" tabindex="-1" role="dialog" aria-labelledby="add-sector-title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add New Sector</h4>
      </div>
      <form role="form" name="addSectorForm" id="addSectorForm" method="post">
        <div class="modal-body">
          <div class="form-group">
            Sector Name: 
            <input id="sector_name" name="sector_name" type="text">
            <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
            <input type="hidden" name="case_id" id="modalCaseId" value="<?php echo $data['caseList']->id; ?>">
            <!-- <p class="help-block">Files up to 5Mb only.</p> -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="saveSector">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="sectorDetails"></div>
<div id="descriptionDetails"></div>
<div id="galleryDetails"></div>
<div id="factorgalleryDetails"></div>
<div class="clearfix"></div>
     
    <div class="section" id="printcontent" style="padding:0px;">
        <div class="container">
            <div class="box-header with-border">
                  <h3 class="box-title"></h3>
                  @if(Session::has('add_message'))
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     {!! session('add_message') !!} 
                    </div>
                    @endif
                </div>
            
                <?php $user_role_name = Session::get('user_role_name');?>
          
                <div class="draggable_"> 
                  <div class="panel-body">
                   <div class="row" id="factor-list">
                    <div class="col-sm-12" id="ajaxresp">
                      <div class="table-responsive">
                        <table id="sectortbl" class="table table-striped table-bordered" style="width:100%">
                          <thead>
                            <tr>
                              <th>Factor</th>
                              <th>Sector</th>
                              <th>Rank</th>
                              <th>Occurance Date</th>
                              <?php 
                              if ($user_role_name!="superAdmin")
                              {
                                ?>
                                <th class="ignore" style="width:15%;">Action</th>
                              <?php } ?>
                            </tr>
                          </thead>
                          <tbody>

                            @if(count($data['getAllSectorByCaseId'])>0)
                            @foreach($data['getAllSectorByCaseId'] as $row)   

                            <tr>

                              <td><?php echo $row->title; ?></td>
                              <td><?php echo $row->sector_name; ?></td>
                              <td><?php echo $row->rank_id; ?></td>
                              <td><?php if(!empty($row->occurance_date )){ echo date("F j, Y", strtotime($row->occurance_date));} ?></td>
                              <?php 
                              if ($user_role_name!="superAdmin")
                              {
                                ?>

                                <td class="ignore" >
                                  <a href="javascript:open_factor_modal(<?php echo $row->id; ?>, <?php echo $row->case_id; ?>);" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                  <a href="#" class="btn btn-danger btn-xs action-btn" onclick="delete_factor(<?php echo $row->id; ?>);" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                </td>
                              <?php } ?>
                            </tr>
                            @endforeach
                            @else
                            @endif


                          </tbody>

                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                </div>
        </div>
    </div>
<style>
.error{
  color:red;
}
</style>
<?php   $username = Session::get('first_name')." ".Session::get('last_name'); ?>
<script src="{{asset('js/tasklist.js')}}"></script> 
<script>
 var tokenval = $('meta[name="csrf-token"]').attr('content');
 $('#token').val(tokenval);


 $(document).ready(function() {

  $('#sectortbl').DataTable( {
    "order": [[ 0, "desc" ]]
  } );

  $('#taskList').DataTable( {
    "order": [[ 0, "desc" ]]
  } );
  $('#incidentList').DataTable( {
    "order": [[ 0, "desc" ]]
  } );
  


} );



 var AddDbclk = 0;
</script>

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
<?php
$visibleSector = $data['getAllVisibleSectorByCaseId'];
$visibleFactor = $data['getAllVisibleFactorByCaseId'];

$myJsonString = json_encode($visibleFactor);
$myJsonString = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $myJsonString);

 //print_r($myJsonString);


$visibleTimeLineDataList = $data['getAllVisibleTimeLineDataByCaseId'];


$myJsonStringForTimeLine = json_encode($visibleTimeLineDataList);
$myJsonStringForTimeLine = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $myJsonStringForTimeLine);

/*echo "<pre>";
print_r($visibleFactor);
echo "</pre>";*/
?>
<svg aria-hidden="true" focusable="false" style="width:0;height:0;position:absolute;">
  <linearGradient id="gradient-horizontal">
    <stop offset="0%" stop-color="var(--color-stop-1)" />
    <stop offset="50%" stop-color="var(--color-stop-2)" />
    <stop offset="100%" stop-color="var(--color-stop-3)" />
  </linearGradient>
  <linearGradient id="gradient-vertical" x2="0" y2="1">
    <stop offset="0%" stop-color="var(--color-stop-1)" />
    <stop offset="50%" stop-color="var(--color-stop-2)" />
    <stop offset="100%" stop-color="var(--color-stop-3)" />
  </linearGradient>
</svg>
<style>
.draggable {
  cursor: move; /* fallback if grab cursor is unsupported */
  cursor: grab;
  cursor: -moz-grab;
  cursor: -webkit-grab;
}

/* (Optional) Apply a "closed-hand" cursor during drag operation. --color-stop-1: #a770ef;  --color-stop-3: #fdb99b;  --color-stop-2: #cf8bf3;*/
.draggable:active { 
  cursor: grabbing;
  cursor: -moz-grabbing;
  cursor: -webkit-grabbing;
}
#gradient-horizontal {
 --color-stop-1: #aba3b3;
 --color-stop-2: #d9d4de;
 --color-stop-3: #5c5861;
 
}
#note_add{
  padding:10px;background-color: #f4f7fb;width:100%;float:left;
}
.note_add_button{
  width:6%;float:left;
}
.note_add_button button{
  width:100%;vertical-align:middle;height:41px;
}
.note_add_input_content{
  width:90%;float:left;margin-right:2%;
}
.note_add_input_content .error{
  margin-top:5px;padding-left:10px;
}
.note_add_input{
  width:100%;height:41px;padding:10px;vertical-align:middle;
}
.note_add_content{
  width:100%;float:left;
}
.note_add_message_previous{
  width:100%;float:left;background-color: #f4f7fb;
}
.note_add_message{
  margin:10px;width:99%;float:left;border-bottom:1px solid #eee;
}
.note_add_message_previous_content{
  margin:10px;float:left;width: 96%;
}
.note_add_img{
  float:left;
}
.note_add_img img{
  width:30px;height:30px;border-radius:15px;
}
.note_add_message_text_content{
  color:#999;
}
.note_add_message_content{
  height:120px;
  overflow: hidden;
}
.note_add_message_text{
  float:left;padding-left:10px;font-weight:normal;width:80%;
}
.note_add_case_account{
  font-weight:normal;font-size:11px
}
.note_add_note_add{
  padding-left:10px;font-weight:normal;font-size:11px
}
.note_add_previous{
  width:128px;float:left;font-size:11px
}
.note_add_out{
  float:right;font-weight:normal;font-size:11px
}
#gradient-vertical {
  --color-stop-1: #00c3ff;
  --color-stop-2: #77e190;
  --color-stop-3: #ffff1c;
}
/*g.highcharts-yaxis-grid path {
   fill: url(#gradient-horizontal);
    stroke: darkgray;
}
g.highcharts-xaxis-grid path{
	 fill: url(#gradient-vertical);
    stroke: darkgray;
    }*/
    .profile-image-buttons{
      width:50%;float:left;
      margin-top:5px;
    }
    figcaption{
      width:100%;float:left;margin:4px 0;
    }
    .profile-image-inner-button{
      width:48%;float:left;
    }
    .profile-image-inner-button-right{
      width:48%;float:right;
      margin-top:0px;
    }
    @media (max-width: 768px) {
      .note_add_message_previous{
        width:100%;
      }
      .note_add_button{
        width:14%
      }
      .note_add_input_content{
        width:80%;
        padding-left: 1px;
      }
      .profile-image-inner-button,.profile-image-inner-button-right{
        width:100%;float:left
      }
      .profile-image-inner-button-right{
        margin-top:5px;
      }
      .profile-image-buttons{
        width:100%;float:left;
        margin-top:5px;
      }
    }
  </style>

<script type="text/javascript">
     // the actual callback for a double-click event
     var ondbclick = function(e, point) {

		//alert(point.factor_id+'-----------'+point.case_id);
    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxGetFactorDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      factor_id:point.factor_id,case_id:point.case_id 
                    },
                    beforeSend: function() {
						// setting a timeout
						
					},
          success: function (data) {


            $('#sectorDetails').html(data);
            $('#modalBt').trigger('click');

                    //editSectorDetails(point.factor_id);

                  }
                });

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

  };



  function open_task_modal(task_id, case_id){

    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxGetTaskDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      task_id:task_id,case_id:case_id 
                    },
                    success: function (data) {


                      $('#sectorDetails').html(data);
                      $('#modalBt').trigger('click');

                      editTaskDetails(task_id);


                    }
                  });

  }



  function add_note(case_id, add_note){

    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxGetTaskDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      add_note:add_note,case_id:case_id 
                    },
                    success: function (data) {


                      $('#sectorDetails').html(data);
                      $('#modalBt').trigger('click');


                    }
                  });

  }



  function editTaskDetails(task_id){


    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxAssignTaskDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      task_id:task_id
                    },
                    success: function (data) {

                    // Parse the data as json
                    var obj = JSON.parse(data)

                    
                    $('#title').val(obj.title);
                    $('#description').val(obj.description);
                    $('#status').val(obj.status);
                    $('#task_assigned').val(obj.task_assigned);
                    $('#due_date').val(obj.due_date);
                    $('#task_id').val(task_id);
                    

                  }
                });

  }


  function open_factor_modal(factor_id, case_id){

    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxGetFactorDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      factor_id:factor_id,case_id:case_id 
                    },
                    success: function (data) {

                      $('#sectorDetails').html(data);
                      $('.modal-backdrop').remove();
                      $('#modalBt').trigger('click');
                       // editSectorDetails(factor_id);

                     }
                   });

  }


  function delete_factor(factor_id){

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
  }


  function delete_task(task_id){

    var r = confirm("Are you sure you want to delete ?");
    if (r == true) {
      $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin-ajaxDeleteTask')}}",
        dataType: 'html',
        data: {
          token : $('meta[name="csrf-token"]').attr('content'), 
          task_id:task_id},
          success: function (html) {
            $('#myModal').modal('hide');
            location.reload();
          }
        });
    }
  }




</script>
<script>



 var open_gallery_modal_to_update_case_image = function(case_id, link1) {
  $('#operation_type').val("change_case_image");
  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: link1,
    dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      case_id:case_id 
                    },
                    success: function (data) {


                      $('#galleryDetails').html(data);
                        //$('#modalBt').trigger('click');
                        $('#myModal2').modal('show');  




                      }
                    });


};



</script>
<script src="{{asset('js/table2csv.js')}}"></script>
<script>
$( "#csv" ).click(function() {
    var fileName = $('#filename').val();
    $("table").table2csv({
        excludeColumns:'.ignore',
        "filename": fileName+'.csv',
    });
});
</script>
@endsection