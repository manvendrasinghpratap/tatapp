
<!-- START Datatable -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

<!-- END Datatable -->
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">

<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->


<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>


<!-- Trigger the modal with a button -->
        
    
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <form name="modalform" id="modalform" method="post" action="">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                <h4 class="modal-title">Are you sure you want to delete the incident?</h4>
                </div>
                
                <div class="modal-body">
                 <?php //var_dump($data); ?>
                <ul class="list-group">
                  <?php
                  if($data['totalReport']>0){
                  ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total No of Report
                    <span class="badge badge-primary badge-pill"><?php echo $data['totalReport']; ?></span>
                  </li>
                  <?php  } ?>
                
                 
                
                 
                 
                </ul>


              
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="deleteCase" data-link1="{{route('admin-ajaxDeleteIncident')}}" data-link2="<?php echo $data['incident_id']; ?>">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
          
        </form>  
    

                </div>
            </div>
        </div>

<!--   New Block -->
<script type="text/javascript">
    


 $('#deleteCase').on('click', function(){
              
                  
          
          var link1 = $(this).data("link1");       
          var incident_id = $(this).data("link2"); 
                   
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      incident_id:incident_id},
                    success: function (html) {
                    $('#myModal').modal('hide');
                     location.reload();
                       }
                    });
    
                   
                    
                
            });
</script>