
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Veloh</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet"> 
 <link rel="stylesheet" href="{{asset('assets/css/master.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/media.css')}}">
<link rel="stylesheet" href="{{asset('assets/fontawesome/css/font-awesome.min.css')}}">

</head>
<body class="main-bg">
    <div class="container">
        <!-- BANNER -->
        <div class="banner-wrap">
            <div class="banner">
                <div class="banner-content">
                    <h1>Genial. Alle Veloborsen!</h1>
                    <p>der Schweiz auf einer Seite</p>
                </div>
                <ul class="psocial-links">
                    <li><a class="fb-icon" href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                    <li><a class="twt-icon" href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                    <li><a class="gm-icon" href="javascript:void(0);"><i class="fa fa-google-plus"></i></a></li>
                    <li><a class="insta-icon" href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
                    <li><a class="pin-icon" href="javascript:void(0);"><i class="fa fa-pinterest-p"></i></a></li>
                </ul>
                <div class="newsletter-wrp">
                    <input type="text" class="input-control">
                    <input type="submit" value="Go!" class="bttn">
                </div>
            </div>
                <div class="overlay"></div>
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
                <nav class="navlist">
                    <ul class="navul">
                        <li>
                            <h4>
                                <a href="javascript:void(0);">alle Velobörsen</a></h4>
                           <p>
                                <a href="{{route('home')}}">home</a>
                           </p>
                            
                        </li>
                        <li>
                            <h4>
                                <a href="{{route('used-bicycles-Zurich')}}">Zürich</a></h4>
                           <p>
                                <a href="{{route('bicycle-market-dates')}}">Velobörsen Daten</a>
                           </p>
                        </li>
                        <li>
                            <h4>
                                <a href="javascript:void(0);">Basel</a></h4>
                           <p>
                                <a href="javascript:void(0);">Börse eintragen</a>
                           </p>
                        </li>
                        <li>
                            <h4>
                                <a href="javascript:void(0);">Bern</a></h4>
                           <p>
                                <a href="{{route('sellbycycle')}}">Velo verkaufen</a>
                           </p>
                        </li>
                        <li>
                            <h4>
                                <a href="javascript:void(0);">Luzern</a></h4>
                           <p>
                                <a href="javascript:void(0);">Velo Kauftipps</a>
                           </p>
                        </li>
                        <li>
                            <h4>
                                <a href="javascript:void(0);">Olten</a></h4>
                           <p>
                                <a href="{{route('Velo-recycling')}}">Velo schenken</a>
                           </p>
                        </li>
                       
                        <li>
                            <h4>
                                <a href="javascript:void(0);">Biel</a></h4>
                           <p>
                                <a href="{{route('about-veloboersen')}}">About</a>
                           </p>
                        </li>
                        <li>
                            <h4>
                                <a href="javascript:void(0);">Winterthur</a></h4>
                           <p>
                                <a href="javascript:void(0);">%% Velo Outlet %%</a>
                           </p>
                        </li>
                        <li>
                            <h4>
                                <a href="javascript:void(0);">Online-Velobörse</a></h4>
                           <p>
                                <a href="javascript:void(0);">Bike Repatur Tipps</a>
                           </p>
                        </li>
                    </ul>
            </nav>
            </div>  
        </header>
        <!-- /HEADER -->
        <!-- CONTENT -->
        @yield('content')
        @extends('layout.frontend.footerinner')