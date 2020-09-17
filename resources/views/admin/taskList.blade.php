
@extends('layout.backened.header')
@section('content')

<!-- Trigger the modal with a button -->
    <button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <div id="sectorDetails"></div>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
        <section class="content-header">
            <h3 class="paddingbottom10px">{{_i('Tasks')}}</h3>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Tasks</li>
        </ol>
        <div class="margintopminus48">	
            <input type="hidden" id="filename" name="filename" value="TasksList">	
            <a href="javascript:void(0)" id="csv" class="btn btn-info btn-xs action-btn edit" title ="Download CSV File"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span></a>        		 
        </div>
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
                        
                        
                        <div class="box-footer clearfix" id="messagess">
                            <div class="alert alert-success alert-dismissible">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                             <span class="msg_txt">Mail send successfully.</span>
                            </div>
			</div>
                        
                        
                    </div>
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
 <form id="user-mng" method="get" action="{{route('admin-task-list')}}">
     <input class="form-control" name="field_name" id="field_name" value="{{old('field_name',$request->field_name)}}" type="hidden">
     <input class="form-control" name="order_by" id="order_by" value="{{old('order_by',$request->order_by)}}" type="hidden">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="Keyword" type="text">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="status" class="form-control" id="status">
                                            <option value="">Select</option>
                                            <option <?php echo (isset($_GET['status']) && $_GET['status']=="new")?'selected':''; ?> value="new">{{_i('New')}}</option>
                                            <option <?php echo (isset($_GET['status']) && $_GET['status']=="assigned")?'selected':''; ?>value="assigned">{{_i('Assigned')}}</option>
                                            <option <?php echo (isset($_GET['status']) && $_GET['status']=="in_progress")?'selected':''; ?>value="in_progress">{{_i('In Progress')}}</option>

                                           
                                            <option <?php echo (isset($_GET['status']) && $_GET['status']=="delayed")?'selected':''; ?>value="delayed">{{_i('Delayed')}}</option>
                                            <option <?php echo (isset($_GET['status']) && $_GET['status']=="closed")?'selected':''; ?> value="closed">{{_i('Closed')}}</option>
                                        </select>


                                        </div>
                                    </div>
                                </div>  
                                <?php

                            $user_role_name = Session::get('user_role_name');
							$user_email = Session::get('email');

                            if(Session::get('user_role_id')<4)
                            {
                            ?>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="task_assigned">
                                                <option value="">Select User</option>
                                                 <?php foreach($valid_user_list as $key=>$val){ 
                                                //dd($val);
                    $activeClass = (isset($_GET['task_assigned']) && $_GET['task_assigned']==$val->task_assigned)?'selected':'';
                                              ?>

                                            <option value="<?php echo $val->task_assigned; ?>" <?php echo $activeClass; ?>><?php echo $val->first_name; ?>&nbsp;<?php echo $val->last_name; ?>(<?php echo $val->total; ?>)</option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                                <?php }
                            
                            if ($user_role_id=="1"){?>
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="account_id">
                                                <option value="">Select Account</option>
                                                 <?php foreach($account_list as $key=>$val){ 
                                                //dd($val);
                    $activeClass = (isset($_GET['account_id']) && $_GET['account_id']==$val->account_id)?'selected':'';
                                              ?>

                                            <option value="<?php echo $val->account_id; ?>" <?php echo $activeClass; ?>><?php echo $val->name; ?>(<?php echo $val->total; ?>)</option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                                <?php } ?> 
                                @if(Session::get('user_role_id')<3)
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="group_id">
                                                <option value="">Select Group</option>
                                                 <?php foreach($group as $key=>$val){ 
                                            $activeClass = (isset($_GET['group_id']) && $_GET['group_id']==$val->id)?'selected':''; ?>
                                            <option value="<?php echo $val->id; ?>" <?php echo $activeClass; ?>><?php echo $val->name; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                                @endif     
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-primary btn-info">Search<div></div></button>
                                    <a href="{{route('admin-task-list')}}" class="btn btn-primary btn-success">Reset</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
									<!--<a href="{{route('admin-add-email-task')}}" class="btn btn-primary btn-info"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Email Send</a>-->
                                </div>
                                   <!--  <div class="col-sm-2 pull-right">
                                        <a href="{{route('admin-add-resources')}}" class="btn btn-block btn-warning">Add Resources</a>
                                    </div> -->
                            </div>
                        </form>

                        @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! session('message') !!} 
                        </div>
                        @endif
                    </div>
                    @php $ii = 1; @endphp
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="printTable">
                            <tr>
                               @if($ii==0)<th>Select</th> @endif
                                <th>Task</th>
                                <th>Assign User</th>
                                <th>Due Date</th>
                                @if(Session::get('user_role_id')<=2)<th>Group</th>@endif       
                                <th>Cases </th>     
                                <th>Incidents</th>     
                                <th>Status</th>     
                                <th class="ignore" style="width: 8%;">Action</th>
                            </tr>

                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)                               
                             <tr>
                                @if($ii==0)<td scope="row"><input type="checkbox" name="send_tasks[]" class="send_tasks" value="{{$row->id}}"></td> @endif
                                <td>{{$row->title}} </td>
                                <td>{{ @$row['user']['first_name'] }} &nbsp; {{ @$row['user']['last_name'] }}</td> 
                                <td>{{date("F j, Y", strtotime($row->due_date))}}</td> 
                                @if(Session::get('user_role_id')<=2)<td>
                                <?php $groupNames = array(); if(!empty(@$row->casetasklist)){ foreach(@$row->casetasklist as $innerKey=>$innerValue){ $groupNames[] = $innerValue->case->caseGroup->group->name; } } ?> {!! implode('<br> ',$groupNames) !!} </td> @endif
                                


                                <td><?php $caseNames = array(); if(!empty(@$row->casetasklist)){ foreach(@$row->casetasklist as $innerKey=>$innerValue){ $caseNames[] = $innerValue->case->title;} } ?> {!! implode('<br> ',$caseNames) !!} </td> 
                                <td><?php $caseNames = array(); if(!empty(@$row->incidenttasks)){ foreach(@$row->incidenttasks as $innerKey=>$innerValue){ $caseNames[] = $innerValue->incident->title;} } ?> {!! implode('<br> ',$caseNames) !!} </td>
                                <td><?php echo getStatusTitle($row->status); ?></td>
                               
                                <td class="ignore">
                                    @if((Session::get('user_role_id')<4) || ($row->task_assigned==Session::get('id')) )
                                    <a href="{{route('admin-edittaskdetails',[$row->id,'mode'=>'edit'])}}" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    @endif
									 @if(Session::get('user_role_id')< 4 )
                                    <a href="javascript:void(0)" class="btn btn-danger btn-xs action-btn" onclick="delete_task(<?php echo $row->id; ?>,'{{route('admin-ajaxDeleteTask')}}');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                   <!-- <a href="javascript:open_emaillog_modal(<?php echo $row->id; ?>, '<?php echo $row->taskTitle; ?>', '{{route('admin-ajaxGetTaskEmailLog')}}');" class="btn btn-info btn-xs action-btn">
                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true" title ="View Email Log"></span></a>-->
                                    @endif 
                                </td>
                            </tr>
                            <?php $k++; ?>     
                            @endforeach
                            @else
                            <tr class="bg-info">
                                <td colspan="9">Record(s) not found.</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {!! $data['records']->links() !!}
                        </ul>
                    </div>
		<!-- 		<div class="box-footer clearfix" id="messagess">
					<div class="alert alert-success alert-dismissible" style="width:300px;margin-left:10px;margin-bottom:0px;">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						  <span>Mail send suceesfully.</span>
                        </div>
						</div>
					
                   <div class="box-footer clearfix mails-section">	
                        <div class="dyncDataTable ">					
					<div class="dyncDataTableRow">
									<div class="pull-left"><input type="text" placeholder="Email" class="form-control mails" name="mails[]" value="" ></div>
									<div class="pull-left"><input type="button"  value="+" class="btn btn-primary btn-info add_more_records"></div>
					</div>
					</div>
					</div>
					<div class="box-footer clearfix mails-section" style="margin-top:10px;">	
								<div class="pull-left"><a href="javascript:void(0)" class="btn btn-block btn-primary" id="mailsends" Title="Send Email">Send</i></a>	
					</div>
					</div>-->
                    
					</div>
                </div>
                <!-- /.box -->
            </div>
        </div>
	 </div>
</div>
<script src="{{asset('js/tasklist.js')}}"></script>
<script type="text/javascript">
    function sort_list(sortby){
       
       $('#field_name').val(sortby);
       var order_by = $('#order_by').val();
       
       if(order_by=="asc"){
        $('#order_by').val('desc');
       }
       else if(order_by=="desc"){
        $('#order_by').val('asc');
       }
       else{
        $('#order_by').val('asc');
       }
       $("#user-mng").submit();
       
    }
	
$(document).ready(function () {
	
	$("#messagess").hide();
	$('#send_mail').on('click', function(){
		$('.mails-section').toggle();
	});
	$('#mailsends').on('click', function(){
		//var mails =  $(".mails").serialize(); 
		var from =  $('#from').val(); 
		var send_tasks=$(".send_tasks:checked").serialize();
//		if(mails==''){
//			alert("please enter email");
//			return false;
//		}
		if(send_tasks==''){
                         window.scrollTo(500, 0);
                         $(".msg_txt").html("Please select at least one task");
                         $("#messagess").children().removeClass('alert-success').addClass('alert-danger')
                         $("#messagess").show();
			return false;
		}
		
		 $.ajax({
			//context: this,
			type: "POST",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{route('admin-ajaxSendTaskDetails')}}",
			dataType: 'json',
			data: {// change data to this object
			token : $('meta[name="csrf-token"]').attr('content'), 
			//mails:mails,
			send_tasks:send_tasks			
			},
			
			success: function (data) { 
				//console.log(data);
				window.scrollTo(500, 0);
                                $(".msg_txt").html(data.message);
                                $("#messagess").show();
				if(data.status=='Success'){
                                    $("#messagess").children().removeClass('alert-danger').addClass('alert-success');
				}else{
                                      $("#messagess").children().removeClass('alert-success').addClass('alert-danger');
                                }
			
			
			}
        });
		
	});
	$(".add_more_records").on("click", function () {
		
        var cols = '<div class="dyncDataTableRow"><div class="pull-left"><input type="text" placeholder="Email" class="form-control mails" name="mails[]" value="" ></div>';
		cols += '<div class="pull-left"><input type="button" class="ibtnDelRow btn btn-md btn-danger"  value="-"></div>';
		cols += '</div>';
		
       // newRow.append(cols);
        $(this).closest(".dyncDataTable").append(cols);
    });
	
	 $(".dyncDataTable").on("click", ".ibtnDelRow", function (event) {
        $(this).closest(".dyncDataTableRow").remove();  
    });
	});
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
