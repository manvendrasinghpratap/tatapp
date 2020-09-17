<?php //dd($data); ?>
@extends('layout.backened.header')
@section('content')
<style type="text/css">
    .checked{ background-color: #FEFf96;}
</style>
 
 <div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h3>{{_i('Click checkbox to link incident to ')}} {{$linkedtype}}</h3>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-tachometer-alt"></i>{{_i('Home')}}</a></li>
            <li class="active">{{ucfirst(trans($linkedtype))}}{{_i(' linking from Incident')}}</li>
        </ol>
    </section>

  
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                          <!-- <h3 class="box-title">Highlighted incidents are the already linked {{$linkedtype.'s'}}.</h3>-->
              @if(Session::has('add_message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('add_message') !!} 
                </div>
                @endif

                      

                        @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! session('message') !!} 
                        </div>
                        @endif
                    </div>
					
					
					<form id="user-mng" method="get" action="{{route('admin-linkreportToIncident',['id'=>$reportid,'type'=>$linkedtype])}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Search By Title')}}" type="text">
                                        </div>
                                    </div>
                                </div> 
								<div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="columnsort">
                                                 <option value="">Column Sort</option>
                                                 <option value="title" <?php echo  (isset($_GET['columnsort']) && $_GET['columnsort']=='title')?'selected':''; ?>>Title</option>
                                                <option value="incident_datetime" <?php echo  (isset($_GET['columnsort']) && $_GET['columnsort']=='incident_datetime')?'selected':''; ?>>Date/Time</option>
												
												 <option value="created_at" <?php echo  (isset($_GET['columnsort']) && $_GET['columnsort']=='created_at')?'selected':''; ?>>Created TimeStamp</option>


                                                
                                               


                                            </select>
                                        </div>
                                    </div>
                                </div>
                               <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="sortby">
                                                 
                                                 <option value="asc" <?php echo  (isset($_GET['sortby']) && $_GET['sortby']=='asc')?'selected':''; ?>>Sort By Asc</option>
                                                <option value="desc" <?php echo  (isset($_GET['sortby']) && $_GET['sortby']=='desc')?'selected':''; ?>>Sort By Dsc</option>


                                                
                                               


                                            </select>
                                        </div>
                                    </div>
                                </div>

                                


                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary btn-info">{{_i('Search / Sort')}}<div></div></button>
                                    <a href="{{route('admin-linkreportToIncident',['id'=>$reportid,'type'=>$linkedtype])}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                     <!--<button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                                    <a href="{{route('admin-download-pdf-caseList')}}" class="btn btn-primary btn-success">
                                   <span class="glyphicon glyphicon-download" aria-hidden="true"></span> PDF</a> -->
                                </div>
								
								
						    <?php 
            $allowRolesList = array("agencySuperAdmin", "agencyAdmin");
            $user_role_name = Session::get('user_role_name');
            if (in_array($user_role_name, $allowRolesList))
            {
            ?>
            
			
			
            <?php } ?>
			<div class="col-sm-2 pull-right">
                                        <a href="{{route('admin-addIncident')}}" class="btn btn-block btn-warning">Add Incident</a>
            </div>
			
            
                                    
                            </div>
                        </form>
					
					<form class="form-horizontal"  action="{{route('admin-incident-linkto-report')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
                    <?php  $existingincidentIds = array();
                    if(!empty( $caseDetails->reportCaseId  )){
                    foreach ($caseDetails->reportCaseId as $key => $value) {
                    $existingincidentIds[] = $value->incident_id;
                    }
                    } ?>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table " id="printTable">
                            <tr   >  
                                <!--<th>Sr.No.</th>-->
								<th width="15%">{{_i('Select')}}</th>
                                <th width="25%">{{_i('Title')}}</th>
                                <th>{{_i('Date/Time')}}</th>
								 <th>{{_i('Incident Type')}}
								  <input type="hidden" value="{{$reportid}}" name="reportid">
								   <input type="hidden" value="{{$linkedtype}}" name="linkedtype">
								 </th>
								
                                
                              
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1;
					?>
                            @foreach($data['records'] as $row) 
							<?php $trstyle='';	$linkchecked=''; //echo '<pre>'; print_r($row);
							if($row->id==$row->incident_id){
								$trstyle='btn-success';
								$linkchecked="checked=checked";
							} 
								
							//echo $row->linkedid;
							
							?>
                            <tr <?php if(in_array($row->id,$existingincidentIds)) { echo "class='checked'"; }  ?>>
                                <!--<td scope="row">{{$k}}</td>-->
								<td>
								
                      <input type="checkbox" <?php if(in_array($row->id,$existingincidentIds)) {echo "checked=checked"; echo " class='checked'"; echo ' disabled '; }  ?> class="linkchecked" value="{{$row->id}}" name="linktoreport[]">
					   <input type="hidden"  value="{{$row->linkedid}}" name="linktoreportid[]">
                     
                   		
								</td>
                                <td> <a target="_blank" title="view incident" href="{{route('admin-editIncident',['id'=>$row->id])}}"><?php   echo $row->title ?></a></td>
                               
                             
                               
                                <td>  {{date("F j, Y H:i", strtotime($row->incident_datetime))}}</td>
								 <td>{{$row->type}}</td>
								
                               
                            </tr>
                            <?php $k++; ?>     
                            @endforeach
                            @else
                            <tr class="bg-info">
                                <td colspan="8">Record(s) not found.</td>
                            </tr>
                            @endif
                        </table>
                    </div>
					<div class="box-footer">
                        @if($cancelRedirect=='viewCase')
						<a href="{{route('admin-viewCase',@$reportid)}}" class="btn btn-default">Cancel</a>
                        @else
                        <a href="{{route('admin-reportList')}}" class="btn btn-default">Cancel</a>
                        @endif
						<input type="submit" name="incidentlink" id="add-button" value="Link Incidents" class="btn btn-info">
						<!--<input type="submit" name="incidentunlink"id="add-button" value="Click Here to Un-Link to {{$linkedtype}}" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link selected incident to {{$linkedtype}}?')">-->
					 </div>
					 </form>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {!! $data['records']->links() !!}
                        </ul>
                    </div>
					 <!-- /.box-body -->
              
              <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
        </div>
	</div>
</div>
<style>
.table-responsive{overflow-x: initial;}
</style>
<script >

/* $(function () {
							$('.datetimepicker1').datetimepicker({
 defaultDate:  null,
	 
	 //else return new Date();
	 


useCurrent:false,
 

});
		
});	 */	
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
	$('#add-button').on('click', function(){
		if($('#printTable input:checkbox:checked').length<=0){
			alert("Please choose any checkbox for Link Incidents");
			return false;
		}
	});
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
@endsection
