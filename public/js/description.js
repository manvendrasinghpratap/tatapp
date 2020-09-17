  $('#addDescription').on('click', function(){
             
                    AddDbclk = 0;
                    var case_id = $('#modalCaseId').val();
                    
                    var link1 = $(this).data("link1");
                   

                    
                    open_description_modal(case_id, link1);
                   
                    
                
            });


     var open_description_modal = function( case_id, link1) {
              $('#operation_type').val("view_target");
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    case_id:case_id 
                    },
                    success: function (data) {

                     
                        $('#descriptionDetails').html(data);
                        $('#modalBt').trigger('click');
                       
                      
                   

                       }
                    });
    
    };
