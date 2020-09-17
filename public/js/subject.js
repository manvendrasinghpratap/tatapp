  $('#addSubject').on('click', function(){
              
                    AddDbclk = 0;
                    var case_id = $('#modalCaseId').val();
                    
                    var link1 = $(this).data("link1");
                    var link2 = $(this).data("link2");

                    
                    open_subject_modal(0, case_id, link1, link2);
                   
                    
                
            });


     var open_subject_modal = function(subject_id, case_id, link1, link2) {
          $('#operation_type').val("view_subject");
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    subject_id:subject_id,case_id:case_id 
                    },
                    success: function (data) {

                      
                        $('#sectorDetails').html(data);
                        $('#modalBt').trigger('click');
                       
                       
                   

                       }
                    });
    
    };

 
