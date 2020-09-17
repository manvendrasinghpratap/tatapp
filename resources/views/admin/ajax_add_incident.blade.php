<form class="quickedit_form">
 {{ csrf_field() }}
<table class="table table-hover" >
<tr>
<th>Edit and save</th>
<td ><input type="text" class="form-control" readonly name="record_number" autocomplete="off" value="{{old('name',$data->record_number)}}" placeholder="Record Number"/></td>
<td>
<input type="hidden" name="incident_id" value="{{$data->id}}">

<input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{old('name',$data->title)}}">
</td>
<td>
<textarea name="description" id="description" class="form-control" placeholder="Description">{{old('name',@$data->description)}}</textarea>

</td>
                             
                               
                                <td>
								
								<div class="input-group date datetimepicker1" >
						
                <input type="text"  id="incidentdatetimepicker" name="incidentdatetimepicker" class="form-control datetimepicker1" style="width:70%;border:1px solid #ccc;color: #555;" value="">
                <span class="input-group-addon " style="text-align: left;border:none"><i class="fa fa-calendar "></i></span>
              </div>
			  
			  <?php
					$incdatetime='';
					if(@$data->incident_datetime){
						$incdatetime=date('m/d/Y H:i',strtotime(@$data->incident_datetime));
					}
					
					$date_of_report='';
					if(@$data->date_of_report){
						$date_of_report=date('m/d/Y H:i',strtotime(@$data->date_of_report));
					}
					?>
					<script type="text/javascript">
					var dd2 = "<?php if($incdatetime){
						echo date('m/d/Y H:i',strtotime(@$data->incident_datetime));
					}
					else{
						
						echo  date('m/d/Y H:i');
					}
					
					?>";
					
					var dd3 = "<?php if($date_of_report){
						echo date('m/d/Y H:i',strtotime(@$data->date_of_report));
					}
					else{
						
						echo  date('m/d/Y H:i');
					}
					
					?>";
						$(function () {
							$('.datetimepicker1').datetimepicker({
 defaultDate:  new Date(dd2),
	 
	 //else return new Date();
	 


useCurrent:false,
 

});$('.datetimepicker2').datetimepicker({
							 defaultDate:  new Date(dd3),
								 //else return new Date();
							useCurrent:false,
							});
							
 $(".add_more_records").on("click", function () {
		
      var cols = "";
		cols += '<tr><td><textarea name="victim_name_and_contact_info[]" placeholder="Victim Name And Contact Info" id="victim_name_and_contact_info" class="md-textarea form-control" rows="3"></textarea></td>';
		cols += '<td><textarea name="persons_of_concern_name_and_contact_info[]" placeholder="Persons Of Concern Name And Contact Info" id="persons_of_concern_name_and_contact_info" class="md-textarea form-control" rows="3"></textarea></td>';
		cols += '<td><textarea name="witnesses_names_and_contact_info[]" placeholder="Witnesses Names And Contact Info" id="witnesses_names_and_contact_info" class="md-textarea form-control" rows="3"></textarea></td>';	
        cols += '<td><input type="button" class="ibtnDelRow btn btn-md btn-danger "  value="-"></td>';	
		cols += '<td>&nbsp;</td>';
		cols += '<td>&nbsp;</td>';
		cols += '<td>&nbsp;</td>';
		cols += '<td>&nbsp;</td></tr>';	
		
       // newRow.append(cols);
        $(this).closest(".dyncDataTable").append(cols);
    });
	
	 $(".dyncDataTable").on("click", ".ibtnDelRow", function (event) {
        $(this).closest("tr").remove();  
    });
						});
					</script>
			  
                                   
                                </td>
								
								<td>
							<select name="type" class="form-control" id="type">
                            <option value="">Select</option>

                            @if(count($incident_type)>0)
                            @foreach($incident_type as $row) 
                            <?php 
$selectedClass = (isset($data->type) && $data->type==$row->id)?'selected':'';
                            ?>  
                            <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->type ?></option>
                          @endforeach
                          @else

                          @endif

                          </select>
								
								</td>
								<td>
							<select name="group_id" class="form-control" id="group_id">
                            <option value="">Select</option>
                            @if(count($group)>0)
                            @foreach($group as $row) 
							<?php $selectedClass = (isset($data->incidentGroup) && $data->incidentGroup->group_id==$row->id)?'selected':''; ?>
                            <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->name ?></option>
                          @endforeach
						  @endif

                          </select>
								
								</td>
								</tr>
								<tr>
								
                                <td ><input type="text" class="form-control" name="reported_by" autocomplete="off" value="{{old('name',$data->reported_by)}}" placeholder="Reported By"/></td> 
								<td ><input type="text" class="form-control datetimepicker2" name="date_of_report" autocomplete="off" value="" placeholder="Date of Report"/></td> 
								<td ><textarea name="location" id="location" class="form-control" placeholder="Location">{{old('name',@$data->location)}}</textarea></td> 
								<td ><input type="checkbox" name="law_enforcement_contacted" autocomplete="off" <?php if(!empty($data->law_enforcement_contacted)){echo "checked";}?> value="1" placeholder="Law Enforcement Contacted"/></td>
								<td ><input type="checkbox" name="medical_assistance_required" autocomplete="off" <?php if(!empty($data->medical_assistance_required)){echo "checked";}?> value="1" placeholder="Medical Assistance Required"/></td> 		<td ><textarea name="follow_up_actions" id="follow_up_actions" class="form-control" placeholder="Follow up Actions">{{old('name',@$data->follow_up_actions)}}</textarea></td></tr>
								<tr ><td colspan="8"><table class="table table-hover dyncDataTable">
								 <?php 
									 $victim_name_and_contact_info="";
									 $persons_of_concern_name_and_contact_info="";
									 $witnesses_names_and_contact_info="";
									 if(!empty(@$data->victim_name_and_contact_info)) { 
									 $victim_name_and_contact_info=@unserialize($data->victim_name_and_contact_info);
									 }
									 if(!empty(@$data->persons_of_concern_name_and_contact_info)) { 
									 $persons_of_concern_name_and_contact_info=@unserialize($data->persons_of_concern_name_and_contact_info);
									 }
									 if(!empty(@$data->witnesses_names_and_contact_info)) { 
									 $witnesses_names_and_contact_info=@unserialize($data->witnesses_names_and_contact_info);
									 }
									 $count=0;
									 if(!empty($victim_name_and_contact_info)&& count($victim_name_and_contact_info)>0) { 
									 foreach($victim_name_and_contact_info as $value){
									 $victim_name_and_contact_info_value="";
									 $persons_of_concern_name_and_contact_info_value="";
									 $witnesses_names_and_contact_info_value="";
									 if(!empty($victim_name_and_contact_info[$count])){
									 $victim_name_and_contact_info_value=$victim_name_and_contact_info[$count];
									 }
									 if(!empty($persons_of_concern_name_and_contact_info[$count])){
									 $persons_of_concern_name_and_contact_info_value=$persons_of_concern_name_and_contact_info[$count];
									 }
									 if(!empty($witnesses_names_and_contact_info[$count])){
									 $witnesses_names_and_contact_info_value=$witnesses_names_and_contact_info[$count];
									 }
									 ?>
									 <tr>
								<td >
								<textarea name="victim_name_and_contact_info[]" id="victim_name_and_contact_info" class="form-control" placeholder="Victim Name And Contact Info">{{old('name',@$victim_name_and_contact_info_value)}}</textarea></td>
								<td >
								<textarea name="persons_of_concern_name_and_contact_info[]" id="persons_of_concern_name_and_contact_info_value" class="form-control" placeholder="Persons Of Concern Name And Contact Info">{{old('name',@$persons_of_concern_name_and_contact_info_value)}}</textarea></td>
								<td ><textarea name="witnesses_names_and_contact_info[]" id="witnesses_names_and_contact_info" class="form-control" placeholder="Witnesses Names And Contact Info">{{old('name',@$witnesses_names_and_contact_info_value)}}</textarea></td>
								<td >								
								 <?php if($count==0){?>
								<input type="button"  value="+" class="btn btn-primary btn-info add_more_records">
								<?php }else{?>
								<input type="button" class="ibtnDelRow btn btn-md btn-danger"  value="-">
								<?php }?>
								</td>
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								</tr>
								<?php 
								$count++;
								}
								}else{?>
									<tr>
								<td >
								<textarea name="victim_name_and_contact_info[]" id="victim_name_and_contact_info" class="form-control" placeholder="Victim Name And Contact Info"></textarea></td>
								<td >
								<textarea name="persons_of_concern_name_and_contact_info[]" id="persons_of_concern_name_and_contact_info" class="form-control" placeholder="Persons Of Concern Name And Contact Info"></textarea></td>
								<td ><textarea name="witnesses_names_and_contact_info[]" id="witnesses_names_and_contact_info" class="form-control" placeholder="Witnesses Names And Contact Info"></textarea></td>
								<td>
								<input type="button"  value="+" class="btn btn-primary btn-info add_more_records">
								</td>
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								</tr>
								<?php }?>
								</table></td></tr>
								<tr>
								<td>
                                   <input type="submit" class="btn btn-md btn-info save" value="Save">
								</td>
                            </tr>
</table>
</form>

<script >
$(document).ready(function (e) {
	

	
$('form.quickedit_form').bind('submit', function () {
	let formdata=$(this).serialize();
	$.ajax({
		type: "POST",
		
		url: "{{route('admin-incidentPostQuickEdit')}}",
		dataType: 'json',
		data: formdata,
		
		success: function (data) {  console.log(data.message.title);
			if(data.status=='success') location.reload();
			//createChart(data);   
		
		
		}
	});
	return false;
});
});

</script >
  