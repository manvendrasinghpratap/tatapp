
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Veloh</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet"> 
 <link rel="stylesheet" href="{{asset('assets/css/master.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/media.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/fontawesome/css/font-awesome.min.css')}}">

</head>
<body class="main-bg">
	<div class="container">
        <!-- BANNER -->
        <div class="banner-wrap">
            <div class="banner">
                <div class="banner-content">
                    <h1>Genial. Veloborsen!</h1>
                    <p>der Schweiz auf einer Seite</p>
                </div>
                <div class="newsletter-wrp">
                    <input type="text" class="input-control">
                    <input type="submit" value="Go!" class="bttn">
                </div>
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
                <nav class="navlist">
                    <ul class="navul">
                        <li>
                            <a href="javascript:void(0);">
                                <h4>alle Velobörsen</h4>
                                <p>home</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <h4>Zürich</h4>
                                <p>Velobörsen Daten</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <h4>Basel</h4>
                                <p>Börse eintragen</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <h4>Bern</h4>
                                <p>Velo verkaufen</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <h4>Luzern</h4>
                                <p>Velo Kauftipps</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <h4>Olten</h4>
                                <p>Velo schenken</p>
                            </a>
                        </li>
                       
                        <li>
                            <a href="javascript:void(0);">
                                <h4>Biel</h4>
                                <p>About</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <h4>Winterthur</h4>
                                <p>%% Velo Outlet %%</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <h4>Online-Velobörse</h4>
                                <p>Bike Repatur Tipps</p>
                            </a>
                        </li>
                    </ul>
            </nav>
            </div>	
        </header>
        <!-- /HEADER -->
        <!-- CONTENT -->
                    @yield('content')
                     <div class="cycle-banner">
            <a href="javascript:void(0);">
                <div class="ad-rdct-bx">
                    <img src="{{asset('assets/img/cycle.jpg')}}" alt="bicycle" />
                    <div class="cicl-wrp">
                        <div class="crcl-tri"></div>
                        <h3>hundreds redical prices check them out!</h3>
                    </div>
                </div>
            </a>
        </div> 

                 </div>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script>
    	$(document).ready(function(){
			$(".navbar-hd a").click(function(){
				$(".navlist").toggleClass("showmenu");
			});
			$('.successmsg').delay(1000).fadeOut('slow');
			$('.errormsg').delay(1000).fadeOut('slow');
		});
    </script>
</body>
</html>