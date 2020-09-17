
@extends('layout.backened.header')
@section('content')
<?php
//dd($data);
//dd($valid_user_list);
//dd($account_list);
?>
<!-- Trigger the modal with a button -->
    <button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <div id="sectorDetails">

    </div>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
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

                            if ($user_role_name!="superAdmin")
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



                            <?php

                            }
                            
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
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-primary btn-info">Search<div></div></button>
                                    <a href="{{route('admin-task-list')}}" class="btn btn-primary btn-success">Reset</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
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

                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="printTable">
                            <tr>
                               <!--<th>Sr.No.</th>-->
							   <th>Select</th>
                                <th><a href="javascript:sort_list('tasks.title');" class="<?php get_selected_class_for_sorting('tasks.title'); ?>">Tasks <?php get_sort_icon_of_selected_field('tasks.title', $request->order_by); ?></a></th>
                                <th width="20%"><a href="javascript:sort_list('users.first_name');" class="<?php get_selected_class_for_sorting('users.first_name'); ?>">Assign To <?php get_sort_icon_of_selected_field('users.first_name', $request->order_by); ?></a></th> 
                                <th><a href="javascript:sort_list('tasks.due_date');" class="<?php get_selected_class_for_sorting('tasks.due_date'); ?>">Due Date <?php get_sort_icon_of_selected_field('tasks.due_date', $request->order_by); ?></a></th>
                                <th><a href="javascript:sort_list('case_list.title');" class="<?php get_selected_class_for_sorting('case_list.title'); ?>">Case <?php get_sort_icon_of_selected_field('case_list.title', $request->order_by); ?></a></th>       
                                <th><a href="javascript:sort_list('tasks.status');" class="<?php get_selected_class_for_sorting('tasks.status'); ?>">Status <?php get_sort_icon_of_selected_field('tasks.status', $request->order_by); ?></a></th>     
                                <th><a href="javascript:sort_list('tasks.created_by');" class="<?php get_selected_class_for_sorting('tasks.created_by'); ?>">Created Date <?php get_sort_icon_of_selected_field('tasks.created_by', $request->order_by); ?></a></th>
                                <th width="15%">Action</th>
                            </tr>
							
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                               <?php 
                                /*echo "<pre>";
                                print_r($row->users);
                                echo "</pre>";*/
                                ?>
                             <tr>
                               <!-- <td scope="row">{{$k}}</td>-->
							   <td scope="row"><input type="checkbox" name="send_tasks[]" class="send_tasks" value="{{$row->id}}"></td>
                                <td>{{$row->taskTitle}}</td>
                                <td>{{$row->first_name}}&nbsp{{$row->last_name}}</td> 
                                <td>{{date("F j, Y", strtotime($row->due_date))}}</td> 
                                <td>{{$row->caseTitle}}</td> 
                                <td><?php echo getStatusTitle($row->status); ?></td>
                                <td>{{date("F j, Y", strtotime($row->created_at))}}

                                </td>
                                <td>

                                    <a href="javascript:open_task_modal(<?php echo $row->id; ?>, <?php echo $row->case_id; ?>, '{{route('admin-ajaxGetTaskDetails')}}','{{route('admin-ajaxAssignTaskDetails')}}');" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>

                                    <a href="#" class="btn btn-danger btn-xs action-btn" onclick="delete_task(<?php echo $row->id; ?>,'{{route('admin-ajaxDeleteTask')}}');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>



                                  
                                </td>
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
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
					<div class="pull-left">				
								<input type="hidden" value="<?php echo $user_email;?>" id="from">
                                        <a href="javascript:open_task_modal(0, 0, '{{route('admin-ajaxGetTaskDetails')}}','{{route('admin-ajaxAssignTaskDetails')}}');" class="btn btn-block btn-primary add-tasks" Title="Add Task">Add Task</i></a>
								
					</div>
					<div class="pull-left"><a href="javascript:void(0)" class="btn btn-block btn-primary" id="send_mail" Title="Send Email">Send Email</i></a></div>
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {!! $data['records']->links() !!}
                        </ul>
                    </div>
					<div class="box-footer clearfix" id="messagess">
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
					</div>
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
		var mails =  $(".mails").serialize(); 
		var from =  $('#from').val(); 
		var send_tasks=$(".send_tasks:checked").serialize();
		if(mails==''){
			alert("please enter email");
			return false;
		}
		if(send_tasks==''){
			alert("please select at least one task");
			return false;
		}
		//$('<tr colspan="5"><td>dsfsdfsfsfsdf</td></tr>').insertAfter($(this).closest('tr'));
		 $.ajax({
			 context: this,
			type: "POST",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			 url: "{{route('admin-ajaxSendTaskDetails')}}",
			dataType: 'html',
			data: {// change data to this object
			token : $('meta[name="csrf-token"]').attr('content'), 
			mails:mails,
			send_tasks:send_tasks			
			},
			
			success: function (data) { 
				//console.log(data);
				/*alert(data.message);
				if(data.status=='Success'){
				alert("p");*/
				$("#messagess").show();
				/*}*/
			
			
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
<style>
.mails-section{
	display:none;	
}
.add-tasks{
}
#send_mail{
margin-left:10px;
}
.add_more_records{
margin-left:10px;
}
.dyncDataTableRow{
width:300px;
margin-left:10px;
margin-right:10px;
}
.dyncDataTable{
width:300px;
}
.dyncDataTableRow .pull-left{
margin-top:10px;
margin-right:10px;
}
</style>
@endsection
