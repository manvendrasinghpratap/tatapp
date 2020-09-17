
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
                <h4 class="modal-title">Are you sure you want to delete the case?</h4>
                </div>
                
                <div class="modal-body">
                 <?php //var_dump($data); ?>
                <ul class="list-group">
                  <?php
                  if($data['totalSubject']>0){
                  ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total No of Subject
                    <span class="badge badge-primary badge-pill"><?php echo $data['totalSubject']; ?></span>
                  </li>
                  <?php  } ?>
                  <?php
                  if($data['totalTarget']>0){
                  ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total No of Target
                    <span class="badge badge-primary badge-pill"><?php echo $data['totalTarget']; ?></span>
                  </li>  
                  <?php  } ?>
                  <?php
                  if($data['TotalTaskByCaseId']>0){
                  ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total No of Task
                    <span class="badge badge-primary badge-pill"><?php echo $data['TotalTaskByCaseId']; ?></span>
                  </li>
                  <?php  } ?>
                  <?php
                  if($data['TotalForum']>0){
                  ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total No of Forum
                    <span class="badge badge-primary badge-pill"><?php echo $data['TotalForum']; ?></span>
                  </li>
                  <?php  } ?>
                  <?php
                  if($data['totalFile']>0){
                  ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total no Files
                    <span class="badge badge-primary badge-pill"><?php echo $data['totalFile']; ?></span>
                  </li>
                  <?php  } ?>
                  <?php
                  if($data['totalSectorByCaseId']>0){
                  ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total No of Sector
                    <span class="badge badge-primary badge-pill"><?php echo $data['totalSectorByCaseId']; ?></span>
                  </li>
                  <?php  } ?>
                  <?php
                  if($data['totalVisibleFactorByCaseId']>0){
                  ?>
                   <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Factor
                    <span class="badge badge-primary badge-pill"><?php echo $data['totalVisibleFactorByCaseId']; ?></span>
                  </li>
                  <?php  } ?>
                </ul>


              
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="deleteCase" data-link1="{{route('admin-ajaxDeleteCase')}}" data-link2="<?php echo $data['case_id']; ?>">Confirm</button>
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
          var case_id = $(this).data("link2"); 
                   
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      case_id:case_id},
                    success: function (html) {
                    $('#myModal').modal('hide');
                     location.reload();
                       }
                    });
    
                   
                    
                
            });
</script>