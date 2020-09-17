<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->

    <!-- Facebook Pixel Code -->
   <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '450063975449870');
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=450063975449870&ev=PageView&noscript=1"
  /></noscript>

  <!-- google code track -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116670264-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-116670264-1');
</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Digital Kheops: monétise ton temps passé sur le web</title>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/chartist-js/dist/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="{{asset('css/blue.css')}}">
    <link rel="stylesheet" href="{{asset('css/common.css')}}">

    <script src="//code.jquery.com/jquery-3.0.0.min.js"></script>
    <link rel="stylesheet" href="{{asset('plugins/chartist-js/dist/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/c3-master/c3.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/chartist-js/dist/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
     <link rel="stylesheet" href="{{asset('css/payment.css')}}">
   
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body class="fix-header fix-sidebar card-no-border">


    <?php
    $seven_dollar_success = Session::get('pay_success_7');

    $package_buy_success = Session::get('pay_success_package');

     if(!empty($seven_dollar_success)){ ?>
        <script>
          fbq('track', 'CompleteRegistration');
        </script>
    <?php }?>

     <?php if(!empty($package_buy_success)){ ?>
        <script>
          fbq('track', 'Purchase');
        </script>
    <?php }?>


    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
               <div class="navbar-header">
                    <a class="navbar-brand" href="{{route('dashboard')}}">
                        <b>
                            <img src="{{asset('assets/images/logo-light-icon.png')}}" alt="homepage" class="light-logo" />
                        </b>
                        <span>
                        <img src="{{asset('assets/images/logo-light-text-dk.png')}}" class="light-logo" alt="homepage" />
                        </span> 
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item"> 
                            <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-menu"></i>
                            </a> 
                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark dropbtn" href="{{route('user-coming-soon')}}" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-attachment"></i> {{_i('Tools')}}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark dropbtn" href="#" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-account"></i> {{_i('My info')}}</a>
                            <div class="dropdown-content">
                                <a href="{{route('profile')}}">{{_i('Profile')}}</a>
                                <?php if(Auth::user()->is_free_member == '0'){ ?>
                                <a href="{{route('packages')}}">{{_i('Packages')}}</a>
                                <?php }?>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

            @extends('layout.frontend.user.left')
            @yield('content')
            @extends('layout.frontend.user.footer')

            

    </div>

<script type="text/javascript" src="{{asset('assets/js/outils.js')}}"></script>
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
     <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

        <script type="text/javascript">
             
            $('#updateprofile').validate({
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
                },
                mdp: {
                    minlength:6,
                },
                mdpverif:{
                    required: {
                        depends: function(element) {
                            return ($("input[name=mdp]").val() != "");
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
                    required:"{{_i('Please enter email')}}"
                },
                first_name:
                {
                    required:"{{_i('Please enter email')}}",
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
                }
                
              
            },
             submitHandler: function (form) {
                    form.submit();
            }
        });

            $('#paypal-update').validate({
            ignore: ".ignore",
            rules: {
               
                 cardNumber: {
                  required: true,
                  digits: true,
                  minlength:16,
                    
                },
                EXPDATE:{
                    required:true,
                    digits: true
                },
                CVV2 :{
                  required:true
                },
                BILLTOFIRSTNAME:{
                  required:true
                },
                BILLTOLASTNAME:{
                  required:true
                }
            },
            // Specify validation error messages
            messages: {
              
                cardNumber:
                {
                    required:"{{_i('This field is required.')}}"
                },
                EXPDATE:{
                  required:"{{_i('This field is required.')}}"
                },
                CVV2:{
                  required:"{{_i('This field is required.')}}"
                },
                BILLTOFIRSTNAME:{
                  required:"{{_i('This field is required.')}}"
                },
                BILLTOLASTNAME:{
                  required:"{{_i('This field is required.')}}"
                },
                
              
            },
             submitHandler: function (form) {
               $.ajax({
                        url: "{{route('paypal-card-update')}}", 
                        type: "POST", 
                        dataType: "json", 
                        data: $("#paypal-update").serialize(),
                        success: function (response) {
                         if (response.status  == 'true') {
                            location.reload();
                      } else {
                       $(".modal-footer").text(response.msg) 
                   } 
               }
           });
        }
    });


var el = document.getElementById("copy-button");
if(el){
    el.addEventListener("click", function() {
    copyToClipboard(document.getElementById("inLienComp"));
    });
}


function copyToClipboard(elem) {
      // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
          succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}

$(".nav-link.nav-toggler ").click(function(){
    $(".left-sidebar").toggle();
    console.log('click');
});
$(document).ready(function(){
//console.log(window.innerWidth);
if(window.innerWidth<768)

$(".left-sidebar").toggle();

var seven_dollar_payment = "<?php echo Session::get('pay_success_7');?>";

if(seven_dollar_payment){
    <?php Session::pull('pay_success_7'); ?>
}

var package_payment = "<?php echo Session::get('pay_success_package');?>";

if(seven_dollar_payment){
    <?php Session::pull('pay_success_package'); ?>
}
})
window.onresize = function(){

    if(window.innerWidth<768){
if($(".left-sidebar").is(':visible'))
$(".left-sidebar").toggle();
    }
    else{
        if(!$(".left-sidebar").is(':visible'))
$(".left-sidebar").toggle();
    }


}
      
</script>

<script>
$(document).ready(function(){

       $(function(){
            $('.card-header').click(function(){      
                $('iframe').attr('src', $('iframe').attr('src'));

            });
        });
});

</script>



</body>

</html>
 
           