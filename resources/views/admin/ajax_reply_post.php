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
                
                messageboxcontent:'required',
               
              
            },
            // Specify validation error messages
            messages: {
              
                
                messageboxcontent: "Please enter Message.",
               
            
            },
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
     
             var editor = CKEDITOR.instances.messageboxcontent;
             var editordata = editor.getData();
             $("#message").val(editordata);

             $('#ajaxresp').html('<div class="loader"></div>');
                    var sdata = $("#modalform").serialize();

                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajax-save-topic')}}",
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
                <h4 class="modal-title">Add / Edit Topic</h4>
                </div>
               
                <div class="modal-body">



                    <div class="inner-div row">
                      
                        <input type="hidden" name="token" id="token" value="">
                        <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
                        <input type="hidden" name="case_id" value="<?php echo $data['caseList']->id; ?>">
                        <input type="hidden" name="forum_id" id="forum_id" value="<?php echo $data['forum_id']; ?>">
                        
                        <textarea rows="5" cols="20" type="text" id="messageboxcontent" name="messageboxcontent" placeholder="Description"/></textarea><br/>
                        <textarea rows="5" cols="20" type="text" id="message" name="message" placeholder="Description"/></textarea><br/>
                        
                        
                    </div>
                  
                    <div style="clear:both"></div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="deleteTopic">Delete Topic</button>
                    <button type="button" class="btn btn-primary" id="saveTopic">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    
                </div>
        </form>  
    

                </div>
            </div>
        </div>
<!-- <script src="js/drag.js"></script> -->
<script src="https://cdn.ckeditor.com/4.8.0/standard-all/ckeditor.js"></script>
<!--   New Block -->
<script type="text/javascript">

     //debugger;
    //CKEDITOR.instances['summaryboxarea'].on('change', function() {alert('value changed!!');});
        CKEDITOR.replace( 'messageboxcontent', {
            // Define the toolbar groups as it is a more accessible solution.
            toolbarGroups: [
                {"name":"basicstyles","groups":["basicstyles"]},
                {"name":"links","groups":["links"]},
                {"name":"paragraph","groups":["list","blocks"]},
                {"name":"document","groups":["mode"]},
                {"name":"insert","groups":["insert"]},
                {"name":"styles","groups":["styles"]},
                {"name":"about","groups":["about"]}
            ],
            // Remove the WebSpellChecker plugin.
            removePlugins: 'wsc',
            height: 350,
            // Configure SCAYT to load on editor startup.
            scayt_autoStartup: true,
            // Limit the number of suggestions available in the context menu.
            scayt_maxSuggestions: 3,
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
        });



   
    $('#saveTopic').on('click', function(){

            $('#modalform').submit();     
    });

    $('#deleteTopic').on('click', function(){

        var task_id = $('.taskClass').val();


        var r = confirm("Are you sure you want to delete ?");
        if (r == true) {
            $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxDeleteTopic')}}",
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
   