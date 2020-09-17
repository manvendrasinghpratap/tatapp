  $('#createForum').on('click', function(){
             
                    AddDbclk = 0;
                    var case_id = $('#modalCaseId').val();
                    
                    var link1 = $(this).data("link1");
                   

                    
                    open_forum_modal(0, case_id, link1);
                   
                    
                
            });


     var open_forum_modal = function(forum_id, case_id, link1) {
              
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    forum_id:forum_id,case_id:case_id 
                    },
                    success: function (data) {

                     
                        $('#forumListResp').html(data);
                        $('#modalBt').trigger('click');
                       
                      
                   

                       }
                    });
    
    };


    $('#createTopic').on('click', function(){
             
                    AddDbclk = 0;
                    var case_id = $('#case_id').val();
                    var forum_id = $('#forum_id').val();
                    
                    var link1 = $(this).data("link1");
                   

                    
                    open_topic_modal(0, case_id, forum_id, link1);
                   
                    
                
            });


     var open_topic_modal = function(topic_id, case_id, forum_id, link1) {
              
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    topic_id:topic_id,forum_id:forum_id,case_id:case_id 
                    },
                    success: function (data) {
                                
                     
                        $('#topicListResp').html(data);
                        $('#modalBt').trigger('click');
                       
                      
                   

                       }
                    });
    
    };


    