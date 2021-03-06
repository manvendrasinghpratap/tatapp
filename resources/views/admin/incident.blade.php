@extends('layout.backened.header')
@section('content')
<style>.margintopminus48{margin-top: 0px !important;}</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/timeline.js"></script>

 <!-- Modal HTML -->
    <div class="modal" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="add-sector-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add New Incident Type </h4>
                </div>
                <form class="form-horizontal" role="form" name="addIncidentTypeForm" id="addIncidentTypeForm" method="post">
                <div class="modal-body ">
				<div class="box-body">
					<div class="form-group">
						  <label for="inputError" class="col-sm-4 control-label"> Incident Type</label>
						  <div class="col-sm-6">
							  <input type="text" name="incident_type_name" id="incident_type_name" class="form-control" placeholder="Type of Incident" value="">
							
						  </div>
					</div>
					<div class="form-group">
						  <label for="inputError" class="col-sm-4 control-label"> Incident Description</label>
						  <div class="col-sm-6">
							  
							  <textarea class="form-control" id="incident_type_desc" name="incident_type_desc" placeholder="Incident Description"></textarea>
						  </div>
					</div>


				   </div>
                </div>
                <div class="modal-footer">
				
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveIncidentType">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<div id="caseDetails"></div>
<div class="clearfix"></div>
<div class="spacer30"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h3 class="paddingbottom10px">Incidents</h3>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Incidents</li>
            <div class="margintopminus48">	
                <input type="hidden" id="filename" name="filename" value="Incidents">	
                <a href="javascript:void(0)" id="csv" class="btn btn-info btn-xs action-btn edit" title ="Download CSV File"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span></a>        		 
            </div>
        </ol>
    </section>

  
        <div class="row">
            <div class="col-md-12">
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

                        <form id="user-mng" method="get" action="{{route('admin-incidentList')}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Keyword')}}" type="text">
                                        </div>
                                    </div>
                                </div> 
                                 <?php

                            $user_role_name = Session::get('user_role_name');

                            if ($user_role_name=="superAdmin")
                            {
                            ?>
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="account_id">
                                                <option value="">Select Account</option>
                                                 <?php foreach($account_list as $key=>$val){ 
                                                //dd($val);
                    $activeClass = (isset($_GET['account_id']) && $_GET['account_id']==$val->id)?'selected':'';
                                              ?>

                                            <option value="<?php echo $val->id; ?>" <?php echo $activeClass; ?>><?php echo $val->name; ?></option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                                <?php } ?>    
                                @if($user_role_id < 3)                    
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="group_filter" class="form-control" id="group">
                                            <option value="">Select Group</option>
                                            @if(count($group)>0)
                                            @foreach($group as $row) 
                                            <?php 
                                            $selectedClass = (isset($_GET['group_filter']) && $_GET['group_filter']==$row->id)?'selected':'';
                                            ?>  
                                            <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?> > <?php echo $row->name ?></option>
                                          @endforeach
                                          @endif
                                          </select>
                                        </div>
                                    </div>
                                </div> 
                                @endif                        
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-primary btn-info">{{_i('Search')}}<div></div></button>
                                    <a href="{{route('admin-incidentList')}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                                    <!-- <a href="{{route('admin-download-pdf-caseList')}}" class="btn btn-primary btn-success">
                                   <span class="glyphicon glyphicon-download" aria-hidden="true"></span> PDF</a> -->

								   <div class="col-sm-4 pull-right">
								   <a href="{{route('admin-incidenttypeList')}}" class=" btn btn-block btn-primary"><i class="fa fa-dashboard"></i> &nbsp;&nbsp;Incident Type</a></div>
                                </div>
								
								
								
								
                                <?php
                                $jsonincident_string=array();								
                                $allowRolesList = array("agencySuperAdmin", "agencyAdmin");
                                $user_role_name = Session::get('user_role_name');
                                if (in_array($user_role_name, $allowRolesList))
                                {
                                ?>
            
			
			<!-- Trigger the modal with a button -->
       <!-- <button id="modalBt" type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal1">Add New Incident Type</button>-->
			
			
			
			
            <?php } ?>
			
			<div class="col-sm-2 pull-right">
                  
            </div>
			
            
                                    
                            </div>
                        </form>

                        @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! session('message') !!} 
                        </div>
                        @endif
                    </div>

                    <!-- /.box-header -->
                    <?php /*echo '<pre>'; print_r($data['records']); echo '</pre>';*/
                    $subArray = array(); 
                    $latORlong = '41.443621704245224'.','.'-100.83085415947265';

                    foreach($data['records'] as $key=>$value){
                        if(!empty($value->latitude)){
                            $subArray[] = "['".$value->location."',". $value->latitude.",". $value->longitude.",'".$value->title."','".$value->type."','".$value->id."','".date("F j, Y H:i", strtotime($value->incident_datetime))."']";
                           //$latORlong = $value->latitude.','.$value->longitude;
                        }
                    }   
                  // echo '<pre>'; print_r($subArray); echo '</pre>';  die();
                    $vendorLocation  = implode(',',$subArray);
                    ?>
                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2H-kU8WBtolE7HScebuNUwRGQgBaHHCI&libraries&sensor=false&callback=initMap"></script>
                    <script>
                        function getIconImage(i){
                           var iconArray = ['red','blue','yellow','orange','black','grey','green','pink','purple'];
                        var image = {
                                   url: 'http://maps.google.com/mapfiles/ms/micons/'+iconArray[i]+'.png',
                                // This marker is 20 pixels wide by 32 pixels high.
                                size: new google.maps.Size(32, 32),
                                // The origin for this image is (0, 0).
                                origin: new google.maps.Point(0, 0),
                                // The anchor for this image is the base of the flagpole at (0, 32).
                                anchor: new google.maps.Point(0, 32)
                            };
                          return image;
                        }
                        function initMap() {
                          var bounds = new google.maps.LatLngBounds();
                          var title = '';
                          var name ='';
                          var url ='';
                          var slug ='';

                          var location = [
                            <?php echo $vendorLocation;?>,
                            
                          ];
                          
                          var map = new google.maps.Map(document.getElementById('location_map'), {
                            zoom: 4,
                            center: new google.maps.LatLng(<?php echo $latORlong ?>),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                          });
                          for( i = 0; i < location.length; i++ ) {

                            var position = new google.maps.LatLng(location[i][1], location[i][2]);
                            console.log(location[i][1], location[i][2]);

                            bounds.extend(position);
                            title= location[i][0];
                            name = location[i][3];
                            slug= location[i][4];
                            type= location[i][4];
                            incidentDateTime = location[i][6];
                            url = "{{ route('admin-editIncident',['slug'=>'modal']) }}";
                            url = url.replace("modal",location[i][5]);

                            var marker = new google.maps.Marker({
                              position: position,
                              map: map,
                            //   draggable:true,
                              icon: getIconImage(i),
                              title: location[i][0]
                            });


                            infoWindow(marker, map, title,name,url,incidentDateTime,type);
                            bounds.extend(marker.getPosition());


                          }
                        }
                        function infoWindow(marker, map, title, name,url,incidentDateTime,type) {
                            google.maps.event.addListener(marker, 'click', function () {
                                var html = "<div><h5><p> Title : " + name + "</p></h5><h5><p> Incident Type : " + type + "</p></h5><h5><p> Incident Date Time : " + incidentDateTime + "</p></h5><h5><h5> Location : " + title + "</h5></div><br><p><a target='_blank' href='" + url + "' >View Full Incident Details</a></p></div>"
                                iw = new google.maps.InfoWindow({
                                    content: html,
                                    maxWidth: 350
                                });
                                iw.open(map, marker);
                            });
                        }

                        $(".weight").change(function(){

                          var dataId    = $(this).attr("data-id");
                          var dataType  = $(this).children("option:selected").attr("data-type");
                          var value     = $(this).children("option:selected").val();
                          var product_class = 'featured-price_'+dataId ; 
                          $("."+product_class).html("$"+value);
                          $(".addToCartbutton_"+dataId).attr('data-type', dataType).attr('data-new-price', value);
                          //alert(dataType);
                        });
                    </script>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="printTable">
                            <tr class="d-flex">
                               <!-- <th class="col-md-0">Sr.No.</th>-->
                                <th class="col-md-1">{{_i('Title')}}</th>
                                <th class="col-md-2">Description</th>
                                @if(Session::get('user_role_id')<=2)<th width="12%">{{_i('Group')}}</th> @endif 
                                <!-- <th width="15%">{{_i('Account')}}</th> -->
                                <th class="col-md-1">{{_i('Date/Time')}}</th>
                                <th class="col-md-2">{{_i('Task')}}</th>
								 <th class="col-md-2">{{_i('Created TimeStamp')}}</th>
								 <th class="col-md-1">{{_i('Type')}}</th>                                
                                 @if(Session::get('user_role_id')<30)<th class="col-md-1 ignore">{{_i('Action')}}</th>@endif
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; 
						
								
						?>
                            @foreach($data['records'] as $row)
                            <tr>
                               <!-- <td scope="row">{{$k}}</td>-->
                                <td> 
                                <a href="{{route('admin-viewIncident',['id'=>$row->id])}}"  title ="View Incident">{{ $row->title }}</a>
                                <?php 
								$jsonincident_data=array();
								$rurl= route('admin-editIncident',['id'=>@$row->id]);
										$jsonincident_data['date']=date("F j, Y H:i", strtotime($row->incident_datetime));
										$jsonincident_data['label']='<a href="'.$rurl.'">'.$row->title.'</a>';
										$jsonincident_data['description']=$row->description;
										$jsonincident_string[]=$jsonincident_data;
                                        ?></td>
                                <td>{{$row->description	}}</td>
                                @if(Session::get('user_role_id')<=2)<td> @if(isset($row->incidentGroup->group->name)) {{ $row->incidentGroup->group->name}} @endif </td> @endif
                                <td>
                                    {{date("F j, Y H:i", strtotime($row->incident_datetime))}}

                                </td>
								
                                <td><?php  $taskarray = array(); if(!empty($row->incident) ){
                                    foreach ($row->incident as $key => $value) {
                                            $taskarray[] = $value->task->title;
                                    }
                                }?> {!! implode('<br>',$taskarray) !!}</td>
								  <td> 
                                    {{date("F j, Y H:i", strtotime($row->created_at))}}

                                </td>
                                  <td>{{$row->type	}}</td>

                                  @if(Session::get('user_role_id' )< 10 )
                                <td class="ignore">                                    
                                   
								  <!-- <a href="javascript:void(0)" class="btn btn-info btn-xs action-btn quickedit" title ="Quick Edit" data-link2="{{$row->id}}"><span class="glyphicon glyphicon-edit" aria-hidden="true" ></span></a>-->
									
                                    <a href="{{route('admin-editIncident',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Edit Incident"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                     <!--<a href="{{route('admin-incidentwithtask',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Link with Tasks"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span></a>-->
                                    <a href="#" class="btn btn-info btn-xs action-btn deleteIncident" title ="Delete"  data-link1="{{route('admin-ajaxViewIncident')}}" data-link2="{{$row->id}}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                               <!--       
									<a href="{{route('admin-reportListByIncident',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="This will show the list of linked reports"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
									</a> -->
									 
                                </td>
                                @endif
                            </tr>
							
                            <?php $k++; ?>     
                            @endforeach
                            @else
                            <tr class="bg-info">
                                <td colspan="8">Record(s) not found.</td>
                            </tr>
                            @endif
							<tr>
								<td colspan="8"><form id="incident-form" method="post" >
                            {{ csrf_field() }}
								<table id="dyncTable" class="table table-hover"></table>								
								  	<div class=" pull-right" ><input type="submit" class="btn btn-md btn-danger " id="saveall" value="Save All"></div>
								</form></td>
							</tr>
                        </table>
                    </div>
                    <!-- /.box-body {{route('admin-addIncident')}}-->
                    <div class="box-footer clearfix_">					
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {!! $data['records']->links() !!}
                        </ul>
                    </div>
                <div class="pull-left" style="width: 110px;margin-bottom: 20px; ">                                
						<a style="width:100px" href="{{route('admin-addIncident')}}" class="btn btn-block btn-primary" Title="Add Incident">Add Incident</i></a>
                </div> 
                <div class="pull-left" style="width:40px;">        
						<a style="width:170px" href="javascript:void(0);" class="btn btn-block btn-primary fullincidentgraph" Title="Add Incident">View All Incident Map</i></a>
                        </div>
								
					</div>
                </div>
                <!-- /.box -->
                
            </div>
			<div class="header-with-slider" style="margin-bottom:50px; display:none;">
					<div id="location_map" style="width: 100%; height: 500px;"></div>
			</div>
			<div class="col-sm-4" style="display:none_">
                            <!-- <select id="incident_type" name="type" multiple class="form-control incident_year_type" >-->
                            <select name="type" class="form-control incident_year_type" multiple id="incident_type">
							<?php $incidentArray=array(); $incidentt=array()?>
                            @if(count($incident_type)>0)
                            @foreach($incident_type as $row) 
                            <?php 
									$incidentt['id']=$row->id;
									$incidentt['inctype']=$row->type;
									$incidentArray[]=$incidentt;
							?>
                            <option value="<?php echo $row->id; ?>" ><?php echo $row->type ?></option>
                          @endforeach
                          @else

                          @endif

                          </select>
                       
						<br/>
						
                    </div> 
					 <div class="col-sm-4">
						<div class="slider-box"> 
						  <label for="priceRange">Date Range:</label>
						  <input type="text" id="dateRange" style="width:70%;border: 0; color: #f6931f; font-weight: bold;"  readonly>
						  <div id="date-range" class="slider"></div>
						 </div>
					</div>
					<div class="col-sm-4"> 
                          <select name="type" class="form-control incident_year_type" multiple id="incident_year">
                            @for($i=2017;$i<=date('Y'); $i++)
                            <option value="{{ $i }}"  >{{ $i }}</option>
                            @endfor
                            </select>
                       
						<br/>
						
                    </div> 
			<div class="col-sm-12">
				<div  id="container" ></div>
			</div>
			
			<div class="col-sm-12">
				<div  id="container2" ></div>
			</div>
			
			<div class="col-sm-12">
				<div  id="incident_type_chart" ></div>
			</div>
					
        </div>
		</div>
</div>

<style>
    #container {
        min-width: 320px;
        max-width: 100%;
    
    }
    .highcharts-credits{display:none}
    tspan.highcharts-anchor{
            text-decoration: underline;
    }
    .btn-app{
            padding: 5px 5px !important; 
            
            height: inherit; 
    }

    .error {
    color: #ff0000;
    font-size: 12px;
    margin-top: 5px;
    margin-bottom: 0;
    }
    
    .inputTxtError {
    border: 1px solid #ff0000;
    color: #0e0e0e;
    }
</style>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script >
$(".fullincidentgraph").click(function(){
  $(".header-with-slider").toggle();
});
function json2table(json, classes) {
  var cols = Object.keys(json[0]);
 // console.log(cols);
   //console.log( json);
 
  var headerRow = '';
  var bodyRows = '';
  
  classes = classes || '';

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  cols.map(function(col,index) {
	  if(index>0)headerRow += '<th>' + capitalizeFirstLetter(col) + '</th>';
    
  });

  json.map(function(row) {
    bodyRows += '<tr>';
	
    cols.map(function(colName,index) {
		
		if(index>0){
			var url = '{{ route("admin-editIncident", ":id") }}';
			url = url.replace(':id', row.id);
			if(index==1)  bodyRows += '<td><a href="'+url+'">'+row[colName]+'</a></td>';
			else bodyRows += '<td>' + row[colName] + '</td>';
		}
		
      
    })

    bodyRows += '</tr>';
  });

  return '<table class="' +
         classes +
         '"><thead><tr>' +
         headerRow +
         '</tr></thead><tbody>' +
         bodyRows +
         '</tbody></table>';
}

$( window ).on( "load", function() {
        $('#incident_year').trigger('change');
    });

$(document).ready(function (e) {	
	
 $('#incident_type').multiselect({
  nonSelectedText: 'Select Incident type',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'250px'
 });

 $('#incident_year').multiselect({
  nonSelectedText: 'Select Year',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'250px'
 });

	$('#saveall').css('display','none');
	$('form#incident-form').bind('submit', function () {
		let formdata=$(this).serialize();
		resetErrors();
		let validate=true;
		$.each($('form#incident-form input, form#incident-form select, form#incident-form textarea'), function(i, v) {
          if (v.type !== 'submit') {
			  if(v.value==''){
				  
				  var msg = '<label class="error" for="'+i+'">This filed is required.</label>';
				  //	$(this).css("border", "10px solid red");
					$(this).addClass('inputTxtError').after(msg);
					validate=false;
			  }
             // data[v.name] = v.value;
		
			
			 //console.log(v.name);
			 //console.log(v.value);
          }
      }); //end each
	  
	  if(validate){
		   $.ajax({
				type: "POST",
				
				url: "{{route('admin-addManyIncident')}}",
				dataType: 'json',
				data: formdata,
				
				success: function (data) {  console.log(data.status);
					if(data.status=='success') location.reload();
					//createChart(data);   
				
				
				}
		 });
	  }
	  
	  return false;
	});
	function resetErrors() {
		$('form#incident-form input, form#incident-form select, form#incident-form textarea').removeClass('inputTxtError');
		$('form#incident-form label.error').remove();
	}
	
	$('a.quickedit').bind('click', function(){
		var incident_id = $(this).data("link2"); 
		//$('<tr colspan="5"><td>dsfsdfsfsfsdf</td></tr>').insertAfter($(this).closest('tr'));
		 var incident_data_id=$(".quickedit_form #incident_id").val();
		if(incident_id!=incident_data_id){
		 $.ajax({
			 context: this,
			type: "POST",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			 url: "{{route('admin-incidentQuickEdit')}}",
			dataType: 'html',
			data: {// change data to this object
			token : $('meta[name="csrf-token"]').attr('content'), 
			incident_id:incident_id 
			
			},
			
			success: function (data) { 
				//console.log(data);
				$('<tr ><td colspan="7">'+data+'</td></tr>').insertAfter($(this).closest('tr'));
			
			
			}
        });
    
		}			
					
					
					 
                
		
		
		
	});
	// console.log(incidentarray);
    var counter = 0;
	
    $("#addrow").on("click", function () {
		// console.log(incidentarray.length);
		
		
		
       // var newRow = $("");
        var cols = "";
        counter++;
		if(counter>1){
		cols += '<tbody><tr><td colspan="8">&nbsp;</td></tr><tr>';
		}else{
		cols += '<tbody>';
		}
		//cols += '<td ><input type="text" class="form-control" name="record_number['+counter+']" autocomplete="off" placeholder="Record Number"/></td>';
        cols += '<tr><td><input type="text" name="title['+counter+']" id="title" class="form-control" placeholder="Title"/></td>';
        cols += '<td><textarea name="description['+counter+']" placeholder="description" id="description" class="md-textarea form-control" rows="3"></textarea></td>';
        cols += '<td ><input type="text"  class="form-control datetimepicker1" name="incidentdatetimepicker['+counter+']" autocomplete="off" placeholder="Date/Time"/></td>';
		
		cols += '<td colspan="2"><select name="type['+counter+']" class="form-control" id="incident_type"> <option value="">Select</option>';
		for (var i = 0; i < incidentarray.length; i++) {
			cols += ' <option value="'+incidentarray[i]["id"]+'">'+incidentarray[i]["inctype"]+'</option>';
		}
		cols += '</select></td>';
		cols += '<td>&nbsp;</td>';
		cols += '<td>&nbsp;</td>';
		cols += '<td>&nbsp;</td></tr><tr>';
		cols += '<td ><input type="text"  class="form-control" name="reported_by['+counter+']" autocomplete="off" placeholder="Reported By"/></td>';
		cols += '<td ><input type="text"  class="form-control datetimepicker1" name="date_of_report['+counter+']" autocomplete="off" placeholder="Date of Report"/></td>';
		cols += '<td><textarea name="location['+counter+']" placeholder="Location" id="location" class="md-textarea form-control" rows="3"></textarea></td>';
		cols += '<td ><input type="checkbox"  name="law_enforcement_contacted['+counter+']" value="1" autocomplete="off"/> Law Enforcement Contacted?</td>';
		cols += '<td ><input type="checkbox"  name="medical_assistance_required['+counter+']" value="1" autocomplete="off"/> Medical Assistance Required?</td>';
		cols += '<td><textarea name="follow_up_actions['+counter+']" placeholder="Follow up Actions" id="follow_up_actions" class="md-textarea form-control" rows="3"></textarea></td>';
		cols += '<td>&nbsp;</td>';
		cols += '<td>&nbsp;</td></tr>';
		cols += '<tr ><td colspan="8"><table class="table table-hover dyncDataTable">';
		cols += '<tr><td style="width:14%"><textarea name="victim_name_and_contact_info['+counter+'][]" placeholder="Victim Name And Contact Info" id="victim_name_and_contact_info" class="md-textarea form-control" rows="3"></textarea></td>';
		cols += '<td style="width:14%"><textarea name="persons_of_concern_name_and_contact_info['+counter+'][]" placeholder="Persons Of Concern Name And Contact Info" id="persons_of_concern_name_and_contact_info" class="md-textarea form-control" rows="3"></textarea></td>';
		cols += '<td  style="width:18%"><textarea name="witnesses_names_and_contact_info['+counter+'][]" placeholder="Witnesses Names And Contact Info" id="witnesses_names_and_contact_info" class="md-textarea form-control" rows="3"></textarea></td>';
		cols += '<td  style="width:15%"><input type="button" class="btn btn-primary btn-info add_more_records"  value="+"></td>';		
		cols += '<td style="width:10%">&nbsp;</td>';
		cols += '<td style="width:10%">&nbsp;</td>';
		cols += '<td style="width:10%">&nbsp;</td>';
		cols += '<td style="width:10%">&nbsp;</td></tr>';		
		cols += '</table></td></tr>';
        cols += '<tr><td><input type="button" class="ibtnDel btn btn-md btn-danger " value="Delete"></td>';
		cols += '<td colspan="7"><input type="submit" class=" btn btn-md btn-danger singlesave"  value="Save"></td></tr></tbody>';
       // newRow.append(cols);
        $("table#dyncTable").append(cols);
		if(counter>1){$('#saveall').css('display','block'); $('.singlesave').css('display','none');}
		$('.datetimepicker1').datetimepicker({
			useCurrent:false
		});

 $(".add_more_records").on("click", function () {
		
        var cols = "";
		cols += '<tr><td><textarea name="victim_name_and_contact_info['+counter+'][]" placeholder="Victim Name And Contact Info" id="victim_name_and_contact_info" class="md-textarea form-control" rows="3"></textarea></td>';
		cols += '<td><textarea name="persons_of_concern_name_and_contact_info['+counter+'][]" placeholder="Persons Of Concern Name And Contact Info" id="persons_of_concern_name_and_contact_info" class="md-textarea form-control" rows="3"></textarea></td>';
		cols += '<td><textarea name="witnesses_names_and_contact_info['+counter+'][]" placeholder="Witnesses Names And Contact Info" id="witnesses_names_and_contact_info" class="md-textarea form-control" rows="3"></textarea></td>';	
        cols += '<td><input type="button" class="ibtnDelRow btn btn-md btn-danger "  value="-"></td>';	
		cols += '<td style="width:10%">&nbsp;</td>';
		cols += '<td style="width:10%">&nbsp;</td>';
		cols += '<td style="width:10%">&nbsp;</td>';
		cols += '<td style="width:10%">&nbsp;</td></tr>';	
		
       // newRow.append(cols);
        $(this).closest("table.dyncDataTable").append(cols);
    });

    $("table#dyncTable").on("click", ".ibtnDel", function (event) {
        $(this).closest("tbody").remove();       
        counter -= 1
		if(counter==1){$('#saveall').css('display','none'); $('.singlesave').css('display','block');}
		
    });
	 $("table.dyncDataTable").on("click", ".ibtnDelRow", function (event) {
        $(this).closest("tr").remove();  
		var tabledata = $("table.dyncDataTable").html();
    });
	return false;
  });

}); 
var incidentarray=<?php echo json_encode($incidentArray);?>;
$(function() {
	
	$(function() {
    $( "#date-range" ).slider({
      range: true,
      min: new Date('<?php echo $data['incident_min_time']; ?>').getTime() / 1000,
      max: new Date('<?php echo $data['incident_max_time']; ?>').getTime() / 1000,
      step: 86400,
      values: [ new Date('<?php echo $data['incident_min_time']; ?>').getTime() / 1000, new Date('<?php echo $data['incident_max_time']; ?>').getTime() / 1000 ],
      slide: function( event, ui ) {
        $( "#dateRange" ).val( (new Date(ui.values[ 0 ] *1000).toDateString() ) + " - " + (new Date(ui.values[ 1 ] *1000)).toDateString() );
      },
	  change: function( event, ui ) {
		  
		   //console.log((new Date(ui.values[ 0 ] *1000).toDateString() ) + " - " + (new Date(ui.values[ 1 ] *1000)).toDateString());
           $('#incident_year').trigger('change');
		   $('#incident_type').trigger('change');
	  }
    });
    $( "#dateRange" ).val( (new Date($( "#date-range" ).slider( "values", 0 )*1000).toDateString()) +
      " - " + (new Date($( "#date-range" ).slider( "values", 1 )*1000)).toDateString());
  });

	
	
	
	
/*   $("#price-range").slider({
	  range: true, 
	  min: <?php echo $data['incident_min_time'] ?>, 
	  max: <?php echo $data['incident_max_time'] ?>, 
	  values: [<?php echo $data['incident_min_time'] ?>, <?php echo $data['incident_max_time'] ?>], 
	  slide: function(event, ui) {
		  $("#priceRange").val("$" + ui.values[0] + " - $" + ui.values[1]);
	  }
  });
  $("#priceRange").val("$" + $("#price-range").slider("values", 0) + " - $" + $("#price-range").slider("values", 1));
   */
 
  
  
});
var chart;

function open_incident_modal(inctype,incmon,incyear){

        //  alert(inctype+incmon+incyear);
		  
		  $.ajax({
						type: "POST",
						headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						 url: "{{route('admin-incidentChartView')}}",
						dataType: 'json',
						data: {// change data to this object
							token : $('meta[name="csrf-token"]').attr('content'), 
							inctype:inctype ,
							incmon,incmon,
							incyear:incyear
						},
						
						success: function (data) { 
						//$('#incident_type_chart').html(json2table(data, 'table'));
							
						//createChart(data);   
						//console.log(data);
						
						}
                    });
    
    }

  $('.incident_year_type').on('change', function(){
                var incident_type = $('#incident_type').val();
				var incident_year = $('#incident_year').val();
				var dateRange=$( "#dateRange" ).val();
                if(incident_type!="" || dateRange!="" || incident_year!=''){
					 $.ajax({
						type: "POST",
						headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						 url: "{{route('admin-incidentListByType')}}",
						dataType: 'json',
						data: {// change data to this object
						token : $('meta[name="csrf-token"]').attr('content'), 
						incident_type:incident_type ,
						incident_year,incident_year,
						daterange:dateRange
						},
						
						success: function (data) { 
						
						createChart(data);   
						//console.log(data.line);
						
						}
                    });
    
					
					
					
					 
                }
                
            }) 

function createChart(data) {
var options2 = {

 chart: {
        type: 'line'
    },
    title: {
        text: 'Timeline of Incident'
    },
    subtitle: {
        /*text: 'Source: WorldClimate.com'*/
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Incident Count'
        }
    },
    tooltip: {
        
        shared: true
    },
    plotOptions: {
        series: {
            cursor: 'pointer',
            point: {
                events: {
                    click: function () {
						
						//alert('Continue Working on linking incident table Category: ' +this.series.name+ this.category + ', value: ' + this.y);
						//console.log(this.series);
						let inctypeid=this.series.userOptions.inctype_id;
						let incident_year = $('#incident_year').val();
						open_incident_modal(inctypeid,this.category,incident_year);
						//window.location='<?php route('admin-incidentList'); ?>'+'?year=2018&month=1&incident=test';
                        
                    }
                }
            }
        }
		
    },
    series: data.line,
	 /* tooltip: {
                    useHTML: true,
                    borderRadius: 0,
                    borderWidth: 1,
                    borderColor: '#5CD0CD',
                    shadow: false,
                    shape: 'square', // default is callout
                    style: {
                    padding: 8
                    },
                    headerFormat: '',
                    pointFormatter: function() {
        //console.log(this);
       
         var output = '<div class="area-tooltip">';
        output += '   <div class="area-tooltip-header">';
		output +=  '<h5>'+this.category+'</h5>';
        output +=  'Click to view Incident Record.<br>';
       // output +=  'Total Number of IncidentData  ' +this.series.name + this.y+'<br>';
        output +=  '<a href="javascript:open_incident_modal('+this.series.name+','+ this.category+');">'+ this.series.name+': '+ this.y+'</a>';
        output += '</div>';
        output += '</div>';
        
        

        return output;
      }
                    

                }
		  */
		/* dataLabels: {
            enabled: false,
           
            color: '#FFFFFF',
            align: 'right',
            
            y: 0, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        } */
	  
	   
	  
};
	
	
var options = {

   chart: {
        type: 'timeline',
        inverted: false
    },
    title: {
        text: 'Timeline of Incident'
    },
	legend: {
        enabled: false
    },
	
	series: [{
        data:data.timeline,
		 
		/* dataLabels: {
            enabled: false,
           
            color: '#FFFFFF',
            align: 'right',
            
            y: 0, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        } */
	  }],
	   
	  
};


//options.chart.renderTo = 'container';

//var chart1 = new Highcharts.Chart(options);
//console.log(chart1);

options2.chart.renderTo = 'container2';

var chart2 = new Highcharts.Chart(options2);
//console.log(chart1);

}

/* Highcharts.chart('container', {
    chart: {
        type: 'timeline',
        inverted: false
    },
    title: {
        text: 'Timeline of Incident'
    },
	
    legend: {
        enabled: false
    },
    series: [{
        data: <?php echo json_encode($jsonincident_string,JSON_UNESCAPED_SLASHES);?>
		
		
		
		
    }]

});  */

  $('.deleteIncident').on('click', function(){
               
                  
          
          var link1 = $(this).data("link1");       
          var incident_id = $(this).data("link2"); 
                
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    incident_id:incident_id 
                    },
                    success: function (data) {
                         //alert(data);
                      
                        $('#caseDetails').html(data);
                        $('#myModal').modal('show'); 
                       
                       
                   

                       }
                    });
    
                   
                    
                
            });
$(document).ready(function() {
	
	 $("form[name='addIncidentTypeForm']").validate({
            ignore: ".ignore",
            rules: {
                 
				 incident_type_name: "required",
				 incident_type_desc: "required"
               
            },
            // Specify validation error messages
            messages: {
              
               
            },
			submitHandler: function(form) {
			  var incident_type_name=$('#incident_type_name').val();
				var incident_type_desc=$('#incident_type_desc').val();
				
				   $.ajax({
					type: "POST",
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: "{{route('admin-ajaxAddNewIncidentType')}}",
					dataType: 'html',
					data: {// change data to this object
					token : $('meta[name="csrf-token"]').attr('content'),
					incidentType:incident_type_name,incidentTypeDesc:incident_type_desc
					},
					success: function (data) {
						location.reload();
					 }
				});
			  
			  
			  
			  
			}
        });
	
	

});

</script>
<script src="{{asset('js/table2csv.js')}}"></script>
<script>
$( "#csv" ).click(function() {
    var fileName = $('#filename').val();
    $("#printTable").table2csv({
        excludeColumns:'.ignore',
        "filename": fileName+'.csv',
    });
});
</script> 
@endsection
