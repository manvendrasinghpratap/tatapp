   <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

   <div class="modal" tabindex="-1" role="dialog" id="myModal">
   	<div class="modal-dialog" role="document">
   		<form name="modalDesform" id="modalDesform" method="post" action="{{route('admin-ajaxSaveDescription')}}">
   			<div class="modal-content">
   				<div class="modal-header">
   					<button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
   					<h4 class="modal-title">Manage Description</h4>
   				</div>
   				<input type="hidden" name="case_id" value="{{$request->case_id}}">
   				<div class="modal-body">

   					<div class="inner-div">
   						<textarea name="description" class="form-control">{{$data['caseDetails']->description}}</textarea>


   					</div>

   					<div style="clear:both"></div>
   				</div>
   				<div class="modal-footer">


   					<button type="button" class="btn btn-primary" id="saveSubject">Save changes</button>
   					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
   				</div>
   				<div class="modal-body">

   				</div>
   			</form>  


   		</div>
   	</div>
   	<!--   New Block -->
<script type="text/javascript">
   
    $('#saveSubject').on('click', function(){

        
        $('#modalDesform').submit();

    });


</script>

<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- End Datatable -->
<script type="text/javascript">
    $( document ).ready(function() {
    
      
         

        $('#modalDesform').validate({
            ignore: ".ignore",
            rules: {
                
                description:'required',
                            

            },
            // Specify validation error messages
            messages: {
              
                
                description: "Please enter description.",
                
                
                
            },
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      

             
                   var form_data = new FormData(form); 
                   

                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSaveDescription')}}",
                    dataType: 'html',
                    data:form_data,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                    //result=html.split('#');
                    // $('#ajaxresp').html(response);
                   		$('#modalDesform').modal('hide');
                     	location.reload();

                       }
                    });

    }

        });
    });
  
</script>