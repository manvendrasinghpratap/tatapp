<!DOCTYPE html>
<html>

    <head>
        <title>Digital Kheops</title>
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

            <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
             <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
             <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        <!--script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.min.js"></script-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" http-equiv="X-UA-Compatible" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{asset('userdash/fontawesome/css/font-awesome.css')}}" rel="stylesheet">
        <script  type="text/javascript" charset="utf-8">
            function getValue(varname) {
                var url = window.location.href;
                var qparts = url.split("?");
                if (qparts.length <= 1) {
                    return "";
                }
                var query = qparts[1];
                var vars = query.split("&");
                var value = "";
                for ( i = 0; i < vars.length; i++) {
                    var parts = vars[i].split("=");
                    if (parts[0] == varname) {
                        value = parts[1];
                        break;
                    }
                }
                value = decodeURIComponent(value);
                //value = unescape(value);
                value.replace(/\+/g, " ");

                return value;
            }



        </script>
        <style>
            body {
                background-image: url("{{asset('assets/images/fond_hiking.jpg')}}");
                background-size: 100%;
                background-repeat: no-repeat;
                min-height: 600px;position:relative;
                
            }
            @media only screen and (max-width: 1200px) {
                body {background-image: url("{{asset('assets/images/fond_hiking.jpg')}}");    width: 100%;height: auto;  margin: 0;
    background-repeat: no-repeat;   padding: 0;background-position: center;   background-size: initial;}
                html{height:100vh; overflow-x:hidden;}
            }
        </style>

    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    </head>
    <body>
    @if (session('add_message'))
    <div class="lgn-success"> 
        <h3>{{session('add_message')}}</h3>
    </div>
    @endif
    
     
        <!-- /HEADER -->
        <!-- CONTENT -->
			
        @yield('content')
 </body>

    <script  type="text/javascript" charset="utf-8">
        // alert(getValue("reference"));
        $('#lienRef').attr('href', "logcourriel.html?reference=" + getValue("reference"));
        $('#btnJeVeuxSavoir').on("click", function() {
            $('#boite-legere').show();
        });
        $('#xFerme').on("click", function() {
            $('#boite-legere').hide();
        });
        
        function clickOnPlonge(){
            $('#optin-form').submit();
        }
    

    $( document ).ready(function() {

     $('#optin-form').validate({
            ignore: ".ignore",
            rules: {
                email: {
                    required:true,
                    email:true,
                    remote: {
                        url: '{{route("check_user_status")}}',
                        //url : "http://localhost/digitalkheops/public/index.php/check_user_status",
                        type: "get",
                        data: {

                            title: function() {
                                return $("#awf_field-92280270").val();
                            }
                        },
                    },
                },
                 name: {
                  required: true,
                    //digits: true,
                    
                }
            },
            // Specify validation error messages
            messages: {
              
                email:
                {
                    required:"{{_i('Please enter email')}}",
                    email:"{{_i('Please enter valid email')}}",
                    remote:"{{_i('You are already register with us')}} <a href='{{route('login')}}'>{{_i('Please login')}}</a>"
                },
                name: "{{_i('Please enter first name.')}}",
                
              
            },
             submitHandler: function (form) {

                    var redirect_url = $('.redirect_url').val();
                    var name = $("#awf_field-92280269").val();
                    var email = $("#awf_field-92280270").val();
                    var redirect_url = redirect_url+'&name='+name+'&email='+email;
                    $('.redirect_url').val(redirect_url);
                    
                    form.submit();

                    
            }
        });

    


    });
    </script>

</html>
