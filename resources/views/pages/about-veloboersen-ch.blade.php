@extends('layouts.default')

@section('banner_content')

<div class="banner-wrapper">
	<img class="banner-image" src="{{asset('assets/img/banner-about-veloboersen-ch.html.jpg')}}" alt="About Veloboersen Ch Banner" />
	<h1 class="banner-title title-eintragen">
		Hey.
		<br/>
		&nbsp;&nbsp;This is.
		<br/>
		&nbsp;&nbsp;&nbsp;&nbsp;Velosophy!
	</h1>

	@include('partials.banner-meta');
</div>

@endsection

@section('main_content')
<div class="main-content-wrapper" ng-controller="pageController" ng-init="init()">
	<div class="box-container">
		<div class="box-row odd">
			<div class="box-item">
				<h1 class="item-title item-blue">
					We love cycles
					<br/>
					we live cycling
					<br/>
					<br/>
					Velosophy
					<br/>
					is the future.
				</h1>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Velostaedte-Zukunft.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<h2 class="item-title item-green">
					Copenhagenize:
					<br/> 
					Velos überall.
					<br/>
					<br/>
					Re-Cyclize:
					<br/>
					Velos bezahlbar.
				</h2>
			</div>
		</div>

		<div class="box-row odd">
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Copenhagenize.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<p class="item-header">
					Der Gedanke hinter veloboersen.ch
				</p>
				<p class="item-desc">
					<strong>Velosophy! Veloweisheit. Veloüberzeugung. Velos überall!</strong> Wir stehen am Anfang einer tollen Zeit, das Velo, das genialste aller Fortbewegungsmittel, holt sich seinen Platz zurück. <a title="Kopenhagen Bikes" href="https://www.google.co.uk/search?q=copenhagen+bicycles&amp;rlz=1C1VLSA_enCH705CH705&amp;espv=2&amp;biw=1536&amp;bih=759&amp;source=lnms&amp;tbm=isch&amp;sa=X&amp;ved=0ahUKEwjHhoe7wffRAhVHDcAKHS1WBugQ_AUIBigB" target="_blank">Kopenhagen</a> zeigt vor, es ist möglich. Seit Kurzem gibt es dort mehr Bikes als Autos und das ist erst der Start. Das Konzept wird kopiert, weltweit. Unsere Städte in 20 Jahren, so viel mehr Lebensqualität & Freiheit, solch tolles neues Bewusstsein - <a title="Copenhagenize" href="http://copenhagenize.eu/index/about.html" target="_blank">let's Copenhagenize</a>!
					<br/>
					Unser Beitrag mag bescheiden sein, aber vielleicht ist er ja auch nur der Anfang. Mit dieser Website möchten wir das Fahrrad-Recycling fördern: <strong>Re-Cyclize soll bewusster Trend und Teil von Copenhagenize werden - join us and re-cycle!</strong> Es werden noch immer VIEL ZU VIELE gute alte Velos entsorgt! Gleichzeitig möchten wir mit diesem 
					<br/>
					Engagement, unserer <a title="Velobörse Basel Margarethen" href="http://www.veloboersen.ch/veloboerse-basel.html" target="_self">Velobörse in Basel</a> und unseren <a title="Velo-Outlet" href="http://www.velomaerkte.ch" target="_blank">Bike-Outlets</a> in Basel & Zürich das Velofahren fördern. <strong>GUTE Fahrräder sollen bezahlbar und allen zugänglich sein: Denn nur gute Velos machen Spass und werden geliebter täglicher Begleiter und echte Überzeugung!</strong>
				</p>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Cargobikes.jpg')}}" alt="Box Image" />
			</div>
		</div>

		<div class="box-row info-box-row bg-blue">
			<div class="info-snippet">
				<p>Impressum</p>
			</div>
			<div class="info-snippet">
				<p>
					Diese Website wurde erstellt und wird
					<br/>
					betreut von <a title="Velomaerkte.ch" href="http://www.velomaerkte.ch" target="_blank">velomaerkte.ch</a>
					<br/>
					info[at]velomaerkte.ch
				</p>
			</div>
			<div class="info-snippet">
				<p>
					velomaerkte.ch
					<br/>
					Bafüsserplatz
					<br/>
					CH-4051 Basel
				</p>
			</div>
			<div class="info-snippet">
				<p>
					velomaerkte.ch
					<br/>
					Bleicherweg 52
					<br/>
					CH-8002 Zürich
				</p>
			</div>
			<div class="info-snippet">
				<p>
					velomaerkte.ch ist ein Projekt von Wide World Designs LLC, 
					<br/>
					Freie Strasse 88, CH-4051 Basel. HR-Nr: CHE-112,985.060.
					<br/>
					<span class="desc-underline">
						<strong>&copy; </strong>
						wwd 2017
					</span>
					-
					<span class="desc-underline">
						Disclaimer
					</span>
				</p>
			</div>
		</div>
	</div>

	@include('partials.jigjaw')
	@include('partials.slider')

	
</div>

@endsection

@section('additional_scripts')
	<script>
    function initMap() {
      var locLatLng = {lat: 47.378469, lng: 8.540329};
      var map = new google.maps.Map(document.getElementById('stockMap'), {
        zoom: 20,
        center: locLatLng
      });
      var geocoder = new google.maps.Geocoder();
      var address = 'Zürich HB, 8001 Zürich, Switzerland';

      geocodeAddress(address, geocoder, map);
    }

    function geocodeAddress(address, geocoder, resultsMap) {
      geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
          resultsMap.setCenter(results[0].geometry.location);
          var marker = new google.maps.Marker({
            map: resultsMap,
            position: results[0].geometry.location
          });
        } else {
          alert('Geocode was not successful for the following reason: ' + status);
        }
      });
    }
  </script>
@endsection

