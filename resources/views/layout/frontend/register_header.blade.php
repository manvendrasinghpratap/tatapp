<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <title>Digital Kheops: inscription</title>
    <!-- Bootstrap Core CSS -->
      <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="{{asset('css/blue.css')}}">
    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <!-- All Jquery -->
    <!-- ============================================================== -->
   <script src="{{asset('plugins/jQuery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/outils.js')}}"></script>
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
     <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
     <style type="text/css">
         .error{
                    color:red;
                }

     </style>
    

    <script type="text/javascript" charset="utf-8">
        /*function clicSoumettre() {

            $.ajax({
                url: "{{route('user-registration')}}",
                type: "POST",
                data: {
                    username: $(".user_name").val(),
                    first_name:$(".first_name").val(),
                    last_name:$(".last_name").val(),
                    email: $('.email').val(),
                    password: $('#mdp').val(),
                    user_id: $('#user_id').val(),
                    _token: $('[name="_token"]').val()

                },
                dataType: 'json', // JSON
                success: function(response) {
                    if (response) {
                    document.forms[0].submit();
                    SimpleDeleteCookie('mdp');

                    }else{
                        alert("probleme dB");
                        if (json.statut == 2)
                            alert("Compte déjà existant, choisir un autre identifiant ou allez à votre tableau de bord");
                    }
                }
            });

        }
*/
        function valideMdP() {
            $('#alertemdp').remove();
            if ($('#confmdp').val() == $('#mdp').val()) {
                $("#alertes").append($('<p></p>').addClass("alert alert-success alert-dismissable").attr("id", "alertemdp").text("Les mots de passes concordent"));
                confMdPOK = true;

            } else {
                $("#alertes").append($('<p></p>').addClass("alert alert-danger alert-dismissable").attr("id", "alertemdp").text("Les mots de passes ne concordent pas"));
                confMdPOK = false;
            }
           //// checkSoumettre();
        }

        function valideConfCourriel() {
            $('#alerteConfCourriel').remove();
            if ($('#confcourriel').val() == $('#awf_field-95327553').val()) {
                $("#alertes").append($('<p></p>').addClass("alert alert-success alert-dismissable").attr("id", "alerteConfCourriel").text("Les courriels concordent"));
                confCourrielOK = true;
            } else {
                $("#alertes").append($('<p></p>').addClass("alert alert-danger alert-dismissable").attr("id", "alerteConfCourriel").text("Les courriels ne concordent pas"));
                confCourrielOK = false;
            }
            //checkSoumettre();
        }

        function valideCourriel() {

            $('#alerteCourriel').remove();
            if (!isEmail($("#awf_field-95327553").val())) {

                $("#alertes").append($('<p></p>').addClass("alert alert-danger alert-dismissable").attr("id", "alerteCourriel").text("Le format courriel n'est pas valide."));
                courrielOK = false;
            } else {
                courrielOK = true;
            }
            //checkSoumettre();
        }

        function validePrenom() {
            $('#alertePrenom').remove();
            if ($('#awf_field-95327552').val() == "") {

                $("#alertes").append($('<p></p>').addClass("alert alert-danger alert-dismissable").attr("id", "alertePrenom").text("Le prenom ne peut être vide."));
                prenomOK = false;
            } else {
                prenomOK = true;
            }
            //checkSoumettre();
        }

        function valideNom() {
            $('#alerteNom').remove();
            if ($('#nom').val() == "") {
                $("#alertes").append($('<p></p>').addClass("alert alert-danger alert-dismissable").attr("id", "alerteNom").text("Le nom d'utilisateur ne peut être vide."));
                nomOK = false;
            } else {
                nomOK = true;
            }
            //checkSoumettre();
        }


            $(document).on('click','#soumettre',function(){
                $('#registration-form').submit();

            }).removeClass("disabled").addClass("active");
    </script>

</head>

<body class="fix-header card-no-border">
    @if (session('add_message'))
    <div class="lgn-success">
        <h3>{{session('add_message')}}</h3>
    </div>
    @endif
    
     
        <!-- /HEADER -->
        <!-- CONTENT -->
			
        @yield('content')
  <script type="text/javascript" src="{{asset('bootstrap/js/tether.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <!--Wave Effects -->
  <script type="text/javascript" src="{{asset('assets/js/waves.js')}}"></script>

    <script type="text/javascript" charset="utf-8">
       

        $('#redirect_16b006ec503c8e5b30801dde3ffc4a0c').val("{{route('start')}}")
    </script>


    <script type="text/javascript">
        //our script starts from here
    $( document ).ready(function() {

     $('#registration-form').validate({
            ignore: ".ignore",
            rules: {
                 first_name: {
                  required: true,
                    //digits: true,
                    
                },
                last_name:{
                    required:true,
                },
                email: {
                    required:true,
                    email:true,
                    remote: {
                        url: "{{route('is_user_exist')}}",
                        //url : "http://localhost/digitalkheops/public/index.php/check_for_email",
                        type: "get",
                        data: {
                            title: function() {
                                return $("#awf_field-95327553").val();
                            }
                        },
                    },
                },
                 cemail:{
                    required: {
                        depends: function(element) {
                            return ($("input[name=email]").val() != "" && $('input[name=id]').val() != "");
                        },
                    },
                    minlength:6,
                    equalTo : "#awf_field-95327553",
                },
                mdp: {
                    minlength:6,
                    required:true,
                },
                mdpverif:{
                    required: {
                        depends: function(element) {
                            return ($("input[name=mdp]").val() != "" && $('input[name=id]').val() != "");
                        },
                    },
                    minlength:6,
                    equalTo : "#mdp",
                },

            },
            // Specify validation error messages
            messages: {
              
                email:
                {
                    required:"{{_i('Please enter email')}}",
                    email:"{{_i('Please enter valid email')}}",
                    remote:"{{_i('You must have a referent to register')}}"
                },
                first_name:
                {
                    required:"{{_i('First name is required.')}}",
                },
                last_name:
                {
                    required:"{{_i('Last name is required.')}}",
                },
                mdp:{
                    required : "{{_i('This field is required.')}}",
                    minlength: "{{_i('Password must be 6 characters long.')}}",
                },
                mdpverif:{
                    required:"{{_i('Please enter confirm password.')}}",
                    minlength: "{{_i('Password must be 6 characters long.')}}",
                    equalTo : "{{_i('Confirm password should match with new password.')}}",
                },
                cemail:{
                    required:"{{_i('Please enter confirm email.')}}",
                    equalTo : "{{_i('confimation email should match with email.')}}",
                }
                
              
            },
             submitHandler: function (form) {
                    //clicSoumettre();
                    form.submit();
            }
        });

     $('#login-form').validate({
            ignore: ".ignore",
            rules: {
                email: {
                    required:true,
                    email:true
                },
                password: {
                    minlength:6,
                    required:true,
                }

            },
            // Specify validation error messages
            messages: {
              
                email:
                {
                    required:"{{_i('Please enter email.')}}",
                    email:"{{_i('Please enter valid email')}}",
                },
                password:{
                    required : "{{_i('This field is required.')}}",
                    minlength: "{{_i('Password must be 6 characters long.')}}",
                }
                
              
            },
             submitHandler: function (form) {
                     form.submit();
            }
        });
    });

 $('#forgetpassword').validate({
            ignore: ".ignore",
            rules: {
                email: {
                    required:true,
                    email:true,
                },
            },
            // Specify validation error messages
            messages: {
              
                email:
                {
                    required:"{{_i('Please enter email')}}",
                    email:"{{_i('Please enter valid email')}}",
                }
                
              
            },
             submitHandler: function (form) {
                    
                    form.submit();

                    
            }
});

 $('#reset-form').validate({
            ignore: ".ignore",
            rules: {
                password: {
                    minlength:6,
                    required:true,
                },
                password_confirmation:{
                    required: {
                        depends: function(element) {
                            return ($("input[name=password]").val() != "");
                        },
                    },
                    minlength:6,
                    equalTo : "#password",
                },

            },
            // Specify validation error messages
            messages: {
              
               
                password:{
                    required : "{{_i('This field is required.')}}",
                    minlength: "{{_i('Password must be 6 characters long.')}}",
                },
                password_confirmation:{
                    required:"{{_i('Please enter confirm password.')}}",
                    minlength: "{{_i('Password must be 6 characters long.')}}",
                    equalTo : "{{_i('Confirm password should match with new password.')}}",
                }
                
              
            },
             submitHandler: function (form) {
                    //clicSoumettre();
                    form.submit();
            }
        });
    </script>
    <!-- <footer>
        <div class="pull-right top-rightsec dv-lang-usr" style="margin-right: 2%;">
            <h3>
           
              <ul>
                @foreach(Config::get('laravel-gettext.supported-locales') as $locale)
                    <li>
                        <a href="lang/{{$locale}}">
                        <?php  
                         $current_language = \Lang::getLocale();
                        if($current_language.'_US' == $locale){
                         continue; 
                       } 
                       if($current_language.'-CH' == $locale){
                        continue;
                       }
                        else{
                         if($locale=='en_US')
                          {
                           echo 'Englishssss';
                         }
                         if($locale=='fr-CH'){
                          echo 'Français';
                         } 
                       } ?>  </a>
                    </li>
                @endforeach
              </ul>
               
            </h3>
        </div>
        </footer> -->

</body>

</html>





