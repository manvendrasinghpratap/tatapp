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
<style type="text/css">
    .checked{ background-color: #FEFf96;}
</style>

<!-- Trigger the modal with a button -->
        <?php  $existingincidentIds = array();
            if(!empty( $data->incidenttasks  )){
              foreach ($data->incidenttasks as $key => $value) {
             $existingincidentIds[] = $value->incident_id;
              }
            } ?>
        <div class="modal modal show" tabindex="1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document" style="width: 85%; background-color: white;" >
                <div class="box-body table-responsive no-padding" style="padding:30px;">
                    <table class="table table-hover" id="printTable">
                            <tr>
                                <th>Select</th>
                                <th>{{_i('Title')}}</th>
                                <th>Description</th>
                                @if(Session::get('user_role_id')<=2) <th width="15%">{{_i('Group')}}</th> @endif
                                <th class="col-md-2">{{_i('Date/Time')}}</th>
                                <th>{{_i('Type')}}</th>
                            </tr>
                            @if( !empty(@$incidentListArray))
                            @foreach($incidentListArray as $key=>$value)

                            <tr <?php if(in_array($value->id,$existingincidentIds)) { echo "class='checked'"; }  ?>>
                                <td><input type="checkbox" <?php if(in_array($value->id,$existingincidentIds)) {echo 'checked=checked '; echo "class='checked'"; }  ?>  name="incidentId" id="incidentId" value="{{ $value->id}}" /></td>
                                <td>{{$value->title}}</td>
                                <td>{{$value->description}}</td>
                                @if(Session::get('user_role_id')<=2)<td> @if(isset($value->incidentGroup->group->name)) {{ $value->incidentGroup->group->name}} @endif </td> @endif
                                <td>{{date("F j, Y H:i", strtotime($value->incident_datetime))}}</td>
                                <td>{{$value->incidentType->type}}</td>
                            </tr>
                            @endforeach
                            <tr id="error">
                                <td colspan="6">  <div class="col-sm-6"><span class="error"></span></div></td>
                            </tr>
                            <tr>                               
                                <td colspan="6">                                   
                                    <div class="col-sm-2"> <button  class="btn btn-block btn-primary add-incidentid " Title="Add Task">Link</button>
                    </div></td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="6" t>No Data Found</td>
                            </tr>
                            @endif                            
                        </table>
                </div>
    

                </div>
            </div>
        </div>

<!--   New Block -->
<script type="text/javascript">
  
$(document).ready(function () { 
    
     $('.error').hide();
     $('#error').hide();
    $('.add-incidentid').on('click', function(){
        var chk = $('input[type="checkbox"]:checked').length;

        if(chk==0){
              $('.error').show();
              $('#error').show();
            $('.error').html('Select Atleast One checkbox');
        }else{
            var arr = [];
        $('input[type="checkbox"]:checked').each(function () {
            arr.push($(this).val());
        })
        $('#incidentids').val(arr);
        $('#modalBt').trigger('click').hide();
        $('#modalBt').hide();
              $('.error').hide();
        }

               
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