<?php 

//echo $data['caseList']->account_id;
//dd($data); 
//dd($data['sectorListByAccount']);

 //dd($data['getAllSectorByCaseId']);
                         
?>
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
               
              
            },
            // Specify validation error messages
            messages: {
              
                
                title: "Please enter title.",
               
                
                
            },
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      

             $('#ajaxresp').html('<div class="loader"></div>');
                    var sdata = $("#modalform").serialize();

                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajax-save-forum')}}",
                    dataType: 'html',
                    data:sdata,
                    success: function (response) {
                    
                    $('#myModal').modal('hide');
                    $('#ajaxresp').html(response);

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
                <h4 class="modal-title">Add / Edit Forum</h4>
                </div>
               
                <div class="modal-body">



                    <div class="mdl-ipt-ovt">
                      
                        <input type="hidden" name="token" id="token" value="">
                        <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
                        <input type="hidden" name="case_id" value="<?php echo $data['caseList']->id; ?>">
                        <input type="hidden" name="forum_id" id="forum_id" value="">
                        <div class="form-group">
                            <input class="form-control" type="text" id="title" name="title" placeholder="Title" />
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="5" cols="20" type="text" id="description" name="description" placeholder="Description"/></textarea>
                        </div>
                    </div>
                  
                    <div style="clear:both"></div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger hidden" id="deleteForum">Delete Forum</button>
                    <button type="button" class="btn btn-primary btn-info" id="saveForum">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                
        </form>  
    

                </div>
            </div>
        </div>

<!--   New Block -->
<script type="text/javascript">
   
    $('#saveForum').on('click', function(){

            $('#modalform').submit();     
    });

    $('#deleteForum').on('click', function(){

        var task_id = $('.taskClass').val();


        var r = confirm("Are you sure you want to delete ?");
        if (r == true) {
            $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxDeleteForum')}}",
                    dataType: 'html',
                    data: {
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      task_id:task_id},
                    success: function (html) {
                    $('#myModal').modal('hide');
                     location.reload();
                       }
                    });
          } 
                    
    });


    





</script>
   