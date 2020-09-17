 $( document ).ready(function() {

        
      $('#account-form').validate({
            ignore: ".ignore",
            rules: {
            	name: {
            		required:true,
                    alphanumspace:true,
                },
                address: "required",
                city:'required',
                state: "required",
                zip_code:'required',
                website: "required",
                contact_person:'required',
                office_number: "required",
                cell_phone: {
            		required:true,
                    alphanumspace:true,
                },
                email_address: {
            		required:true,
                    email:true,
                },
                storage_space:'required',
                membership_type:'required',
                status: "required",
                
            },
            // Specify validation error messages
            messages: {
              
                
                name:
                {
                    required:"Please enter name.",
                    alphanumspace:"Please enter valid letters."
                  
                },
                address: "Address field should not be blank.",
                city:'City field should not be blank.',
                state: "State field should not be blank.",
                zip_code:'Zip code field should not be blank.',
                website: "Website field should not be blank.",
                contact_person:'Name of the contact person field should not be blank.',
                office_number: "Office No field should not be blank.",
                cell_phone:
                {
                    required:"Cell Phone field should not be blank.",
                    alphanumspace:"Please enter valid input."
                  
                },
                email_address:
                {
                    required:"Please enter valid email address.",
                    email:"Please enter valid email."
                  
                },
                storage_space:'Please select the Storage Space.',
                membership_type:'Please select the membership type.',
                status: "Please select status from the list."
                
            },
        });
    });