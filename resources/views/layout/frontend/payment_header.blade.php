<!DOCTYPE html>
<html lang="en">

<head>
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


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <title>Digital Kheops</title>
    <!-- Bootstrap Core CSS --> 
    <script src="{{asset('plugins/jQuery/jquery.min.js')}}"></script> 
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <script type="text/javascript" src="{{asset('bootstrap/js/tether.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
     <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
     <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

      <script type="text/javascript" src="{{asset('assets/js/creditcard.js')}}"></script>
      
      <script type="text/javascript" src="{{asset('assets/js/jquery.creditCardValidator.js')}}"></script>
      <style class="cp-pen-styles">@import url("https://fonts.googleapis.com/css?family=Roboto");
@import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html, body {
  height: 100vh;
}

body {
  font: 12px/1 'Roboto', sans-serif;
  color: #555;
  background: #eee;
}
.lgn-success {
    display: none;
}

</style>

 <link rel="stylesheet" href="{{asset('css/payment.css')}}">

</head>

<body>

    <?php $current_route = \Request::route()->getName();
    if($current_route == 'start'){?>
       <!-- Facebook event track code for first payment -->
       <script>
        fbq('track', 'AddPaymentInfo');
      </script>
       
    <?php }?>

    <?php if($current_route == 'payment'){?>
         <!-- Facebook event track code for first payment -->
       <script>
        fbq('track', 'AddToCart');
      </script>
    <?php }?>

    
    @if (session('add_message'))
    <div class="lgn-success">
        <h3>{{session('add_message')}}</h3>
    </div>
    @endif
    
     
        <!-- /HEADER -->
        <!-- CONTENT -->
			
        @yield('content')

</body>
<script >
  $(document).ready(function() {

  $("#payments").submit(function() {
    $(this).submit(function() {
        return false;
    });
    return true;
    });


  $(".choosePayment").click(function(){
  	var payment_method = $(this).val();
  	//$("#paymentType").val(payment_method);
   if(payment_method == 'paypal'){
  		$("#paypal-form").show();
  		$("#stripe-form").css('display','none');

  	}else{
  		// $("#stripe-form").show();
  		//$("#paypal-form").css('display','none');
      $(".stripe-button-el").trigger('click');
  	}
  });

  $(document).on("DOMNodeRemoved",".stripe_checkout_app", close);

    function close(){
     $(".choosePayment").eq(0).trigger('click');
    }
});


  $( document ).ready(function() {

     $('#payments').validate({
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
                    form.submit();
            }
        });
    });
</script>
</html>






