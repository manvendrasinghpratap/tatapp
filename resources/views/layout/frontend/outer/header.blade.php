<!DOCTYPE html>
<html>

<head>


    <!-- /.website title -->
    <title>TatApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

 
  <link rel="stylesheet" type="text/css" href="{{asset('newtheme/css/style.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Asap:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
</head>

<body>

    @yield('content')
    @extends('layout.frontend.outer.footer')

       <!-- /.javascript files -->
       
        <script src="{{asset('newtheme/js/jquery.js')}}"></script>
        
     
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
         
        <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
       
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
     

        <script type="text/javascript">
    $( document ).ready(function() {
    
      $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      });
         
      $.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
      }, "Combination of alphabets,special characters & numeric values required.");
      $('#report-form').validate({
            ignore: ".ignore",
            rules: {
                
                title:
                {
                    required:true,
                    maxlength:250
                    
                },
                details:'required',
                group_id:'required',
                name:
                {
                    
                    maxlength:250
                    
                },
                phone_no:
                {
                    
                    maxlength:12
                    
                },
                email_address: {
                   
                    email:true
                    
                },
                
            },
            // Specify validation error messages
            messages: {
                title: "Please Enter Title.",
                details: "Please enter  Details.",
                group_id: "Please select Group.",
                email_address:
                {     
                    email:"Please enter valid email."                    
                },
                
            },
            submitHandler: function (form,e) {
                    var form_data = new FormData(form); 
                                    // $.ajax({
                                    // type: "POST",
                                    // headers: {
                                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    // },
                                    // url: "{{route('home')}}",
                                    // dataType: 'html',
                                    // data:form_data,
                                    // mimeType: "multipart/form-data",
                                    // contentType: false,
                                    // processData: false,
                                    // success: function (data) {                                
                                    //     $('#report-form').html(data);
                                    // }
                                    // });
                                    $.ajax({
                                            type: "POST",
                                            headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            url: "{{route('agaxCaptchaResponse')}}",
                                            dataType: 'html',
                                            data:form_data,
                                            mimeType: "multipart/form-data",
                                            contentType: false,
                                            processData: false,
                                            success: function (data) {
                                                if(data=="matched")
                                                {
                                                    $.ajax({
                                                        type: "POST",
                                                        headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        },
                                                        url: "{{route('home')}}",
                                                        dataType: 'html',
                                                        data:form_data,
                                                        mimeType: "multipart/form-data",
                                                        contentType: false,
                                                        processData: false,
                                                        success: function (data) {                                
                                                            $('#report-form').html(data);
                                                        }
                                                        });
                                                }
                                                else{
                                                $("#captchaError").html('<label for="title" class="error">Captcha code is not matched. Please Try Again.</label>');
                                                }
                                                }
                                            });
                    }
        });
    });




    /* DEVELOPED BY VIKAS 18-02-2018 
   TO display all uploaded image temporary in the UI 
 */

function handleFileSelect(evt) {

   
  var files = evt.target.files; // FileList object

  // Loop through the FileList and render image files as thumbnails.
  for (var i = 0, f; f = files[i]; i++) {

    // Only process image files.
    if (!f.type.match('image.*')) {
		alert('You have allowed only an image file to upload');
      continue;
    }
	var fsizeinkb=(f.size / 1024).toFixed(2);
	if(fsizeinkb>5120){
		alert('You have allowed only 5MB image file to upload'+f.size);
      continue;
	}
	
    var reader = new FileReader();

    // Closure to capture the file information.
    reader.onload = (function(theFile) {
      return function(e) {
        
                          
  var tempImg = '<li class="newAddedImg plwc-item clearfix"><img src="'+e.target.result+'" title="" alt="" class="img-responsive img-thumbnail image_link newAddedImgClass" /><!--<input type="text" class="form-control imgCaption" name="imgCaption[]" maxlength="50">--><input type="hidden" name="portalFlag[]" value="y" class="portalFlag"><input type="hidden" name="rm_prop_details_id[]" value=""><input type="hidden" class="form-control" name="imgs3url[]" value="'+escape(theFile.name)+'"><span><a href="javascript:void(0);" class="delclass"  title="click here to delete" alt="'+escape(theFile.name)+'"><i class="fas fa-trash-alt"></i></a></span></li>';
  $('.imgBox').append(tempImg);
 
          
       
      };
    })(f);

    // Read in the image file as a data URL.
    reader.readAsDataURL(f);
  }
}
 
//$('#files').change(handleFileSelect);

$('.uploadcls').on('change',handleFileSelect);


  /* DEVELOPED BY VIKAS 18-02-2018 
   TO delete temp IMAGES- 
 */
$(document).on("click", '.delclass', function(event) { 
    $(this).parentsUntil( ".newAddedImg" ).closest( ".newAddedImg" ).remove();
});



</script>

    </body>

    </html>
           