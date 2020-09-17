<!-- START Datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<!-- END Datatable -->
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">

<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

<!-- Start Datatable -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<!-- End Datatable -->



<!-- Trigger the modal with a button -->
        
    
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <form name="modalform" id="modalform" method="post" action="">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                <h4 class="modal-title">Task "{{ $data['taskTitle']}}" Email Log</h4>
                </div>
               
                <div class="modal-body">

       
              
            @if(count($data['emailLog'])>0)
                <table id="sectortbl" class="table table-striped table-bordered" style="width:100%">
                 <thead>
                    <tr>
                    <!--<th>SL No</th>-->
                    <th>Send to</th>
                    <th>Subject</th>
                    <th>Date Time </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data['emailLog'] as $key=>$row)   

                <tr>
                    <!--<td>{{$key+1}}</td>-->
                    <td> {{ $row->send_to }} </td>
                    <td> {{ $row->comment }}</td>
                    <td> {{ date("F j, Y h:i A", strtotime($row->created_at)) }} </td>
                </tr>
                @endforeach
                </tbody>
                 </table>
            @else
                <p>No data found</p>
            @endif
             
           
        
       
   
   

                    <div style="clear:both"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
	$("#myModal #messagess").hide();
	$('#myModal #send_mail').on('click', function(){
            $('#myModal .mails-section').toggle();
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

.modal-dialog {
    width: 700px;
}
</style>



   