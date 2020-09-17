<!-- START Datatable -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<!-- END Datatable -->
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">

<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

<!-- Start Datatable -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<!-- End Datatable -->
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
        $('#modalform').validate({
            ignore: ".ignore",
            rules: {                
                title:'required',
                description:'required',
                status:'required',
                task_assigned:'required',                
                due_date:'required',
            },
            // Specify validation error messages
            messages: {
                title: "Please enter title.",
                description: "Please give the task details.",
                status: "Please select status from the list.",
                task_assigned: "Please assign the task from the user list.",
                due_date : "Please assign due date."
            },
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
                    var sdata = $("#modalform").serialize();
                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-saveTask')}}",
                    dataType: 'html',
                    data:sdata,
                    success: function (response) {
                     $('#myModal').modal('hide');
                        location.reload();
                       }
                    });

    }

        });
    });
  
</script>


<!-- Trigger the modal with a button -->
        
    
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <form name="modalform" id="modalform" method="post" action="">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                <h4 class="modal-title">Manage Task</h4>
                </div>
               
                    <div class="inner-divs" style="padding: 5% 10% 0 10%;">
                        <input type="hidden" name="token" id="token" value="">
                        <input type="hidden" name="task_id" id="task_id" class="taskClass" value="{{$data['taskAjaxDetailsArray']->id}}">
                        Title:<input type="text" id="title" name="title" placeholder="Title" class="form-control" value="{{ $data['taskAjaxDetailsArray']->title}}" /><br/>
                        Description:<input type="text" name="description" id="description" class="form-control" placeholder="Description" value="{{ @$data[taskAjaxDetailsArray]->description }}"><br/>
                       <div>
                            Status:
                            <select name="status" class="form-control" id="status">
                                            <option value="">Select</option>
                                            <option @if(@$data[taskAjaxDetailsArray]->status=='new') {{'selected'}} @endif value="new">{{_i('New')}}</option>
                                            <option @if(@$data[taskAjaxDetailsArray]->status=='assigned') {{'selected'}} @endif value="assigned">{{_i('Assigned')}}</option>
                                            <option @if(@$data[taskAjaxDetailsArray]->status=='in_progress') {{'selected'}} @endif value="in_progress">{{_i('In Progress')}}</option>

                                           
                                            <option @if(@$data[taskAjaxDetailsArray]->status=='delayed') {{'selected'}} @endif value="delayed">{{_i('Delayed')}}</option>
                                            <option @if(@$data[taskAjaxDetailsArray]->status=='closed') {{'selected'}} @endif value="closed">{{_i('Closed')}}</option>
                                        </select>
                        </div>
                       
                    <br/>    
                    <div id="SectorDiv">
                    Assign to: 
                    <select name="task_assigned" class="form-control" id="task_assigned">
                    <option value="">Select</option>
                    @if(count($userList)>0)
                    @foreach($userList as $row) 
                    <?php  $selectedClass = (isset($data['taskAjaxDetailsArray']->task_assigned) && $data['taskAjaxDetailsArray']->task_assigned==$row->id)?'selected':'';  ?>  
                    <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->first_name.' '.$row->last_name; ?></option>
                    @endforeach
                    @else
                    @endif
                    </select>
                    <br/>
                    </div>   
                        Due Date: <input type="date" id="due_date" name="due_date" class="form-control" value="{{$data['taskAjaxDetailsArray']->due_date}}" /><br/>
                            <div id="SectorDiv" style="display: none;">
                            {{_i('Time Zone')}}
                            <select name="zone" class="form-control" id="zone">
                            @if(count($data['zones'])>0)
                            @foreach($data['zones'] as $row) 
                            <?php  $selectedClass = (isset($data['taskAjaxDetailsArray']->zone) && $data['taskAjaxDetailsArray']->zone==$row)?'selected':'';  ?> 
                            <option value="<?php echo $row; ?>" <?php echo $selectedClass; ?>><?php echo $row; ?></option>
                            @endforeach
                            @else
                            @endif
                            </select>
                            <br/>
                            </div> 
                    </div>
                    <div style="clear:both"></div>
                    <br/>

                    
                    <br>
                     <div style="clear:both"></div>
                    <div style="margin-bottom: 20px;text-align: center;"> <button type="button" class="btn btn-primary" id="saveTask">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>

                </div>
                <div class="modal-body">
                    
                </div>
        </form>  
    

                </div>
            </div>
        </div>

<!--   New Block -->
<script type="text/javascript">
  
$(document).ready(function () { 
    $('#saveTask').on('click', function(){

            $('#modalform').submit();     
    });

	$("#myModal #messagess").hide();
	$('#myModal #send_mail').on('click', function(){
		$('#myModal .mails-section').toggle();
	});
	$('#myModal #mailsends').on('click', function(){
		var mails =  $(".mails").serialize(); 
		var from =  $('#from').val(); 
		var send_tasks=$(".send_tasks").serialize();
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
	$("#myModal .add_more_records").on("click", function () {
		
        var cols = '<div class="dyncDataTableRow"><div class="pull-left"><input type="text" placeholder="Email" class="form-control mails" name="mails[]" value="" ></div>';
		cols += '<div class="pull-left"><input type="button" class="ibtnDelRow btn btn-md btn-danger"  value="-"></div>';
		cols += '</div>';
		
       // newRow.append(cols);
        $(this).closest(".dyncDataTable").append(cols);
    });
	
	 $("#myModal .dyncDataTable").on("click", ".ibtnDelRow", function (event) {
        $(this).closest(".dyncDataTableRow").remove();  
    });
       

	});

    





</script>
   
<style>
#myModal .mails-section{
	display:none;	
}
#myModal .add-tasks{
}
#myModal #send_mail{
margin-left:0px;
margin-top:10px;
}
#myModal .add_more_records{
margin-left:10px;
}
#myModal .dyncDataTableRow{
width:300px;
margin-left:10px;
margin-right:10px;
}
#myModal .dyncDataTableRow .mails{
width:150px;
}
#myModal .dyncDataTable{
width:214px;
}
#myModal .dyncDataTableRow .pull-left{
margin-top:10px;
margin-right:10px;
}
</style>