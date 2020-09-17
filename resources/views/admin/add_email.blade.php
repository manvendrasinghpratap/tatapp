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
           <form class="" id="add-form" action="{{route('admin-add-email-task')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
         		
		<div class="col-md-12">        
					<div class="box-footer clearfix" id="messagess">
					 @if(Session::has('add_message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('add_message') !!} 
                </div>
                @endif
						</div>   
<div class="box-footer clearfix" style="width:800px;margin-bottom:20px">
									<?php if(isset($data[0])){$data=$data[0];}?>
									<div class="pull-left" style="margin-left:10px;margin-right:10px;margin-top:5px;"><b> Status:</b><input type="radio" name="status" id="status" style="width:100px;" value="1" <?php if(!empty($data->status)) { echo 'checked'; } ?>
									<?php if(isset($data->status)&&$data->status!='0') { echo 'checked'; }?> > Yes <input type="radio" name="status" style="width:100px;" <?php if(isset($data->status)&&$data->status=='0') { echo 'checked'; }?> value="0" > No</div>
					</div>						
                    <div class="box-footer clearfix" >	
									<div class="pull-left" style="margin-left:10px;margin-right:10px;margin-top:5px;"><b> Send Mail:<?php ?></b></div>					
									<div class="pull-left" style="margin-left:10px;margin-top:5px;"> From </div><div class="pull-left" style=""><input type="number" placeholder="Quantity" id="quantity" class="form-control mails" name="quantity" style="width:100px;" value="<?php if(!empty($data->quantity)) { echo $data->quantity;} ?>" ></div>
									<div class="pull-left" style=""><select name="event_type" id="event_type" class="form-control mails">
									<option <?php if(!empty($data->event_type)&&$data->event_type=='day') { echo 'selected';} ?> value="day">day</option>								
									<option <?php if(!empty($data->event_type)&&$data->event_type=='week') { echo 'selected';}?> value="week">week</option>								
									<option <?php if(!empty($data->event_type)&&$data->event_type=='month')  { echo 'selected';}?>  value="month">month</option>								
									<option <?php if(!empty($data->event_type)&&$data->event_type=='year')  { echo 'selected';}?>  value="year">year</option>
									</select></div><div class="pull-left" style="margin-left:20px;margin-top:5px;"> before.</div>
					</div>
					<div class="box-footer clearfix" style="width:800px;margin-top:25px;">	
					<?php
					$event_time="";
					 if(!empty(@$data->event_time)) { 
						 $event_time=@unserialize($data->event_time);
						 if(!empty($event_time)&& count($event_time)>0) { 
							$event_time=$event_time;
						 }
					 }	
					 if($event_time&&count($event_time)>0){
					 $count=0;
					 foreach($event_time as $event_times){
					 if($count==0){?>
						 <div class="pull-left" style="margin-left:10px;margin-right:10px;"><input type="text" placeholder="Event Time Per Day" class="form-control mails datespicker1" name="event_time[]" value="<?php echo $event_times;?>" ></div>
						<div class="pull-left" style="margin-left:10px;margin-right:10px;"><input type="button"  value="+" class="btn btn-primary btn-info add_more_records"></div>
					<?php }
					$count++;?>
					<?php }?>
					<?php }else{?> 					
									<div class="pull-left" style="margin-left:10px;margin-right:10px;"><input type="text" placeholder="Event Time Per Day" class="form-control mails datespicker1" name="event_time[]" value="" ></div>
									<div class="pull-left" style="margin-left:10px;margin-right:10px;"><input type="button"  value="+" class="btn btn-primary btn-info add_more_records"></div>
					<?php }?>
					</div>
					<div class="box-footer clearfix">	
                        <div class="dyncDataTable">
						<?php
						$count=0;
						if($event_time&&count($event_time)>0){
					 foreach($event_time as $event_times){
					 if($count>0){?>
					<div class="dyncDataTableRow">
						 <div class="pull-left" style="margin-left:10px;margin-right:10px;"><input type="text" placeholder="Event Time Per Day" class="form-control mails datespicker1" name="event_time[]" value="<?php echo $event_times;?>" ></div>
						<div class="pull-left" style=""><input type="button" class="ibtnDelRow btn btn-md btn-danger mails"  value="-"></div>
					</div>	
					<?php }
					$count++;?>
					<?php }?>	
					<?php }?>				
					</div>
						</div>
					<div class="box-footer clearfix" style="margin-top:20px;margin-left:20px;">	
                    <button type="submit" class="btn btn-primary" id="mailsends">Save</button>
                </div>
				</div>
                </form>
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
	//$('.datespicker1').datepicker({ dateFormat: 'yy-mm-dd' });
	$('.datespicker1').datetimepicker({format: 'LT'});	
	$('#mailsends').on('click', function(){
		var event_type =  $('#event_type').val(); 
		var quantity =  $('#quantity').val(); 
		if(quantity==''){
			alert("please enter quantity");
			return false;
		}
		if(event_type==''){
			alert("please enter event type");
			return false;
		}
	});
	$(".add_more_records").on("click", function () {
        var cols = '<div class="dyncDataTableRow"><div class="pull-left" style="margin-left:10px;margin-right:10px;"><input type="text" placeholder="Event Time Per Day" class="form-control mails datespicker1" name="event_time[]" value="" ></div>';
		cols += '<div class="pull-left"><input type="button" class="ibtnDelRow btn btn-md btn-danger mails"  value="-"></div>';
		cols += '</div>';
		
       // newRow.append(cols);
        $(".dyncDataTable").append(cols);
		$('.datespicker1').datetimepicker({format: 'LT'});
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
.mails{
margin-left:10px;
margin-right:10px;
}
#send_mail{
margin-left:10px;
}
.add_more_records{
margin-left:10px;
}
.dyncDataTableRow{
width:400px;
margin-right:10px;
margin-top:10px;
}
.dyncDataTable{
width:400px;
}
.dyncDataTableRow .pull-left{
margin-top:10px;
margin-right:10px;
}
</style>
@endsection
