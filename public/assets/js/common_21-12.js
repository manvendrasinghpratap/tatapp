$(document).ready(function() {
    imgHight();
});
$(window).resize(function() {
    imgHight();
});

function imgHight(){
    var ratingimgheight = $(".rating-main-wrap .display-cell").height();
    $(".larg-sngl-outer .display-cell img").css('min-height', ratingimgheight+'px');
}



    
    $( document ).ready(function() {
        if (typeof $('#add-form').attr('id') != 'undefined') {
            $('#add-form').validate({
        
            errorPlacement: function(error, element) {
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
                
                
                    iiot:'required',
                    iict:'required',
                
                    
                    prot:'required',
                    prct:'required',
                                
                    commission:'required',
                    phone:'required',
                    postcode:'required',
                                
                    
                
                    

                },
            
        });
    }
        /* $("#date2").rules("add", {
            required:true,
        
        });*/
    });
  


   
    $( document ).ready(function() {


        // EOF - Video Section
        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        });
        

        

        $('#add-form-front').validate({
       
        errorPlacement: function(error, element) {
            
            

            if(element[0].id=="dt1" || element[0].id=="sot" || element[0].id=="sct"|| element[0].id=="pot"
                || element[0].id=="pct"|| element[0].id=="ibot"|| element[0].id=="ibct"|| element[0].id=="iiot"
                || element[0].id=="iict"|| element[0].id=="dbot"|| element[0].id=="dbct"|| element[0].id=="diot"
                || element[0].id=="dict" || element[0].id=="prot" || element[0].id=="prct" || element[0].id=="stateId"){

            }
            else if( element[0].id=="market_rules")
            {
                $('#error-market_rules').html(error.text()).fadeOut(2500);
            }
            else if( element[0].id=="commision_fee_doc")
            {
                $('#error-commision_fee_doc').html(error.text()).fadeOut(2500);         

            }   
            else {
            
                 if(error.text()=="Email already in use!"){
                    alert("Email already exist please login to add market place");
                 }else{
                     element[0].placeholder=error.text();
                 }
            }
        },
            
            ignore: [], 
            rules: {
                "marketdt[]":{
                      required: true,
                },
                email: {
                    required:true,
                    email:true,
                },
                name:"required",
                place: "required",
                street: "required",
                mstreet: "required",
                state:"required",              
                town: "required",
                sot:'required',
                sct:'required',
                iiot:'required',
                iict:'required',
                prot:'required',
                prct:'required',
                commission:'required',
                phone:'required',
                postcode:'required',
                commision_fee_doc:{
                    extension: "xls|csv|doc|txt|pdf|odt|jpg|jpeg|png|svg|gif",
                    filesize: 5242880, //5242880, //5MB
                },
                market_rules:{
                    extension: "xls|csv|doc|txt|pdf|odt|jpg|jpeg|png|svg|gif",
                    filesize: 5242880, //5242880, //5MB
                },
            },
            messages: {
                email: {
                    required: "Please Enter Email!",
                    email: "This is not a valid email!",
                    remote: "Email already in use!"
                },
                commision_fee_doc: {
                    extension: "Please select file of xls|csv|doc|txt|pdf|odt|jpg|jpeg|png|svg|gif extension",
                    filesize: "Please select file of size upto 5 MB",
                  },
                  market_rules:{
                    extension: "Please select file of xls|csv|doc|txt|pdf|odt|jpg|jpeg|png|svg|gif extension",
                    filesize: "Please select file of size upto 5 MB",
                  },
            }
       });
       // Below code is throwing error due to which menu in mobile case does not work.
        // $("#dt1").rules("add", {
        //     required:true
        // });
       
    
    });
$(document).ready(function() {
    $('.js-example-basic-single').select2({
       placeholder: "Bitte wählen"
    });
     $('.js-example-basic-single-town').select2({
       placeholder: "Bitte wählen"
    });
});

function printData()
{
   var divToPrint=document.getElementById("printTable");
   newWin= window.open("");
   newWin.document.write('<!DOCTYPE html><html> <head> <meta charset="utf-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <title>Threat Assessment Tool: Admin Panel</title> <meta name="csrf-token" content="Fruqn3PwqCR1q94Rxxqk8V3oiARUH6NkMAc6mMMn"> <!-- Tell the browser to be responsive to screen width --> <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> <!-- Bootstrap 3.3.6 --> <!-- <link rel="stylesheet" href="http://localhost/tatapp/public/bootstrap/css/bootstrap.min.css"> --> <link rel="stylesheet" href="http://localhost/tatapp/public/bootstrap/css/bootstrap.css"> <!-- Font Awesome --> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> <!-- Ionicons --> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"> <!-- Theme style --> <link rel="stylesheet" href="http://localhost/tatapp/public/dist/css/AdminLTE.css"> <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. --> <link rel="stylesheet" href="http://localhost/tatapp/public/css/custom.css"> <link rel="stylesheet" href="http://localhost/tatapp/public/dist/css/skins/_all-skins.css"> <!-- Admin CSS--> <!-- bootstrap wysihtml5 - text editor --> <link rel="stylesheet" href="http://localhost/tatapp/public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> <!-- iCheck --> <!--<link rel="stylesheet" href="http://localhost/tatapp/public/plugins/iCheck/flat/blue.css">--> <!-- Morris chart --> <!--<link rel="stylesheet" href="http://localhost/tatapp/public/plugins/morris/morris.css">--> <!-- jvectormap --> <!--<link rel="stylesheet" href="http://localhost/tatapp/public/plugins/jvectormap/jquery-jvectormap-1.2.2.css">--> <!-- Date Picker --> <link rel="stylesheet" href="http://localhost/tatapp/public/plugins/datepicker/datepicker3.css"> <!-- Bootstrap time Picker --> <link rel="stylesheet" href="http://localhost/tatapp/public/plugins/timepicker/bootstrap-timepicker.min.css"> <!-- Daterange picker --> <link rel="stylesheet" href="http://localhost/tatapp/public/plugins/daterangepicker/daterangepicker.css"> <link rel="stylesheet" href="http://localhost/tatapp/public/assets/css/market-form.css"> </head> <body class="hold-transition skin-blue sidebar-mini">');
   newWin.document.write(divToPrint.outerHTML);
   newWin.document.write('</body></html>');
   newWin.print();
   newWin.close();
}

$('#printButton').on('click',function(){
printData();
})