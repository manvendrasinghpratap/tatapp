 
    $( document ).ready(function() {

     $('#add-form').validate({
       
         errorPlacement: function(error, element) {
            console.log(error);
            if(element[0].id=="dt1" || element[0].id=="sot" || element[0].id=="sct"|| element[0].id=="pot"
                || element[0].id=="pct"|| element[0].id=="ibot"|| element[0].id=="ibct"|| element[0].id=="iiot"
                || element[0].id=="iict"|| element[0].id=="dbot"|| element[0].id=="dbct"|| element[0].id=="diot"
                || element[0].id=="dict" || element[0].id=="prot" || element[0].id=="prct" || element[0].id=="stateId"){

            }else{
                     element[0].placeholder=error.text();
              //  element.val(error.text());
            }
           /* if(element[0].id=='hiddenRecaptcha'){
alert('Recapcha is required');
            }*/
        },
           
            ignore: [],

            rules: {
                
              
                place: "required",
                street: "required",
                mstreet: "required",
                state:"required",              
                town: "required",
                sot:'required',
                sct:'required',
                pot:'required',
                pct:'required',
                ibot:'required',
                ibct:'required',
                iiot:'required',
                iict:'required',
                dbot:'required',
                dbct:'required',
                diot:'required',
                dict:'required',
                prot:'required',
                prct:'required',
                             
                commission:'required',
              
                

            },
         
       });
     /* $("#date2").rules("add", {
         required:true,
        
      });*/
    });
  


   
$( document ).ready(function() {

    
       
    
      $('#add-form-front').validate({
       
        errorPlacement: function(error, element) {
            console.log(error);
            if(element[0].id=="dt1" || element[0].id=="sot" || element[0].id=="sct"|| element[0].id=="pot"
                || element[0].id=="pct"|| element[0].id=="ibot"|| element[0].id=="ibct"|| element[0].id=="iiot"
                || element[0].id=="iict"|| element[0].id=="dbot"|| element[0].id=="dbct"|| element[0].id=="diot"
                || element[0].id=="dict" || element[0].id=="prot" || element[0].id=="prct" || element[0].id=="stateId"){

            }else{
                 console.log(error.text());
                 if(error.text()=="Email already in use!"){
alert("Email already exist please login to add market place");
                 }else{
                     element[0].placeholder=error.text();
                 }
               
              //  element.val(error.text());
            }
           /* if(element[0].id=='hiddenRecaptcha'){
alert('Recapcha is required');
            }*/
        },
            
             ignore: [], 
            rules: {
              /*  hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            },*/
            
             email: {
                    required:true,
                    email:true,
                    remote: {
                        url: 'check_email',
                        type: "post",
                        data: {
          email: function() {
            return $( "#email" ).val();
          },

                       
                    },
                },
            },
    
               name:"required",
                place: "required",
                street: "required",
                mstreet: "required",
                state:"required",              
                town: "required",
                sot:'required',
                sct:'required',
                pot:'required',
                pct:'required',
                ibot:'required',
                ibct:'required',
                iiot:'required',
                iict:'required',
                dbot:'required',
                dbct:'required',
                diot:'required',
                dict:'required',
                prot:'required',
                prct:'required',
                             
                commission:'required',
                phone:'required',
                postcode:'required',
            },
           messages: {
                email: {
                    required: "Please Enter Email!",
                    email: "This is not a valid email!",
                    remote: "Email already in use!"
                }
            },
       /*errorElement : 'div',
    errorLabelContainer: '.errorTxt'*/
            // Specify validation error messages
           
        });
  /* $("#dt1").rules("add", {
         required:true,
        
      });*/
       
    
    });
$(document).ready(function() {
    $('.js-example-basic-single').select2({
       placeholder: "Bitte wählen"
    });
     $('.js-example-basic-single-town').select2({
       placeholder: "Bitte wählen"
    });
});