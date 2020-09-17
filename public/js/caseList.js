  $('.deleteCase').on('click', function(){
              
                  
          
          var link1 = $(this).data("link1");       
          var case_id = $(this).data("link2"); 
                
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
                         //alert(data);
                      
                        $('#caseDetails').html(data);
                        $('#myModal').modal('show'); 
                       
                       
                   

                       }
                    });
    
                   
                    
                
            });

