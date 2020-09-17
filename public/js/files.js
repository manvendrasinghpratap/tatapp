  $('#addFile').on('click', function(){
              
                    AddDbclk = 0;
                    var case_id = $('#modalCaseId').val();
                    
                    var link1 = $(this).data("link1");
                    var link2 = $(this).data("link2");

                    
                    open_file_modal(0, case_id, link1, link2);
                   
                    
                
            });


     var open_file_modal = function(file_id, case_id, link1, link2) {
          
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    file_id:file_id,case_id:case_id 
                    },
                    success: function (data) {

                      
                        $('#sectorDetails').html(data);
                        $('#modalBt').trigger('click');
                       
                        $('.sectortbl111').show('slow');
                       
                   

                       }
                    });

    
    };

    var addFileDetails = function(file_id, case_id, link1) {
		$('#myModal').modal('show');
          $('#addDiv').html('<div class="loader"></div>');
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    file_id:file_id,case_id:case_id 
                    },
                    success: function (data) {
						$('#myModal').modal('show');
                        $('#addDiv').show('slow');
                        $('#addDiv').html(data);
                        $('.sectortbl111').hide('slow');
                       }
                    });
    
    };


    var editFileDetails = function(file_id, link1) {
          
          $('#addDiv').html('<div class="loader"></div>');
		  $('#myModal').modal('show');
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    file_id:file_id
                    },
                    success: function (data) {
						$('#myModal').modal('show');
                         $('#addDiv').show('slow');
                        $('#addDiv').html(data);
                        $('.sectortbl111').hide('slow');
                       
                       
                   

                       }
                    });
    
    };


    

    var delete_file = function(file_id, case_id, link1) {
           var r = confirm("Are you sure you want to delete ?");
           if (r == true) {
          $('#ajaxresp').html('<div class="loader"></div>');
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    file_id:file_id,case_id:case_id
                    },
                    success: function (data) {
						location.reload();
                        $('#ajaxresp').html(data);

                       }
                    });
      }
    
    };


    

 
