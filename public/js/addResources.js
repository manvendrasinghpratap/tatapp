 $( document ).ready(function() {
    
     
      $('#add-form').validate({
            ignore: ".ignore",
            rules: {
                account_id: "required",
                name: {
                    required:true,
                    minlength:3,
                    maxlength: 120,
                    
                },
                email: {
                    required:true,
                    maxlength: 160,
                    email:true,
                },
                website: {
                    required:true,
                    maxlength: 250,
                },
                contact_person: {
                    required:true,
                    maxlength: 150,
                    
                },
                phone: {
                    required:true,
                    number:true,
                },
                

              
            },
            // Specify validation error messages
            messages: {
                account_id: "Please select account from the list.",
                name:
                {
                    required:"Please enter name.",
                    
                  
                },
                email:
                {
                    required:"Please enter valid email address.",
                    email:"Please enter valid email."
                  
                },
                website:
                {
                    required:"Website link should not be blank.",
                    url:"Please enter valid URL."
                  
                },
                contact_person:
                {
                    required:"Please enter name of the Contact Person.",
                    
                  
                },
                phone:
                {
                    required:"Phone field should not be blank.",
                 
                  
                },

                
               
               
            },
        });
    });