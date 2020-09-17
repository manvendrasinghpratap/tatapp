<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>Veloh</title>
<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet"> 
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="http://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">
 <link rel="stylesheet" href="{{asset('assets/css/rating.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/market-form.css')}}">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
 <link rel="stylesheet" href="{{asset('assets/css/master.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/media.css')}}">
<link rel="stylesheet" href="{{asset('assets/fontawesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/slick/slick.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/slick/slick-theme.css')}}">



<!-- Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

        <!-- jQuery UI 1.11.4 -->


<style>
    #st-1.st-has-labels .st-btn{
        min-width: 80px !important;
    }
	.alert-success-msg{
		margin-top:50%;
	}
</style>
<link rel="stylesheet" href="{{asset('assets/css/jquery.mCustomScrollbar.css')}}">

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
</head>
<body class="main-bg">
   @if (session('add_message'))
    <div class="lgn-success">
        <h3>{{session('add_message')}}</h3>
    </div>
    @endif
 <div class="box-header with-border">
              <h3 class="box-title"></h3>
                
            </div>

<!--<div class="se-pre-con"></div>-->
    <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : 'your-app-id',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v2.11'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5a0d5debdaf39500128e17e1&product=inline-share-buttons' async='async'></script>

    <div class="main-wrap">
	<div class="container">
        <!-- BANNER -->

        <div class="banner-wrap @if(Request::route()->getName()=='sellbycycle') sellby-bann-wrap  @endif @if(Request::route()->getName()=='Velo-recycling') velor-bann-wrap @endif @if(Request::route()->getName()=='bicycle-market-dates') bicmkt-bann-wrap @endif @if(Request::route()->getName()=='used-bicycles-Zurich') usd-bizu-bann-wrap @endif @if(Request::route()->getName()=='publish-bike-sale') pubbik-bann-wrap @endif @if(Request::route()->getName()=='about-veloboersen') abt-vshophy-bann-wrap @endif @if(Request::route()->getName()=='regionalpage') usd-bizu-bann-wrap @endif" >

           
            <div class="banner" style="background-image:url({{ URL::asset('assets/img/') }}/{{$bannerimage}})" >
            <div class="overlay"></div>
                <div class="pull-right top-rightsec" style="margin-right: 2%;">
                        <h3>
                       
                          <ul>
                            @foreach(Config::get('laravel-gettext.supported-locales') as $locale)
                                    <li><a href="/lang/{{$locale}}">{{$locale}}</a></li>
                            @endforeach
                            <li>
                            @if (Auth::check())
                                <a class="user_btn" href="{{ route('logout') }}">{{ _i('Logout') }}</a>
                            @else
                                <a class="user_btn" href="{{ route('login') }}"> {{ _i('Login') }}</a>
                            @endif
                            </li>
                        </ul>
                           
                        </h3>
                    </div>
                <div class="banner-content">
                    
                    <?php echo $bannerhead; ?>
                    <p>{{$bannerpera}}</p>
                </div>
                <ul class="psocial-links">
                 
                    <div class="social-outer-main">
                    <div class="sharethis-inline-share-buttons"></div>
                    <div class="insta-single-icon"><a target="_blank" href="{{get_social_link('social_instagram')}}"><i class="fa fa-instagram" aria-hidden="true"></i></a></div>
                    <div class="insta-single-icon"><a class="yt-icon" href="javascript:void(0);"><i class="fa fa-youtube"></i></a></div>
                    </div>

                </ul>
				@if (session('subs_message'))
				<div class="alert alert-success-msg">
					{{session('subs_message')}}
				</div>
				@endif
				<form id="subscribe-news-form" action="" method="POST">
					<div class="newsletter-wrp">
                    <input id="subscribe_email" name="subscribe_email" type="text" class="input-control" placeholder="{{ _i('Bike rides by e-mail') }}">
                    <input type="submit" value="{{ _i('Go!') }}" class="bttn">
					</div>
					
				</form>
                
        </div>
                 </div>

        <!-- /BANNER -->
        <!-- HEADER -->
      <header class="header">
            <div class="navbx-wrp">
                <div class="navbar-hd">     
                    <a href="javascript:void(0);">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
               

               @include('layout.frontend.menu')
            </div>  
        </header>
        <!-- /HEADER -->
        <!-- CONTENT -->
			
        @yield('content')
      


 @if(Request::route()->getName()=='bicycle-market-dates' )
 @include('layout.frontend.footerinner')
 @else  @include('layout.frontend.footer')
 @endif
 
     
</body>
</html>


<script>
 $(document).ready(function(){ 
    setTimeout(function() {
    $('.lgn-success').slideUp('fast');
}, 2500);
    
 });   
</script>



