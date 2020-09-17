@extends('layouts.default')

@section('banner_content')

<div class="banner-wrapper">
	<img class="banner-image" src="{{asset('assets/img/banner-veloboerse-olten.jpg')}}" alt="Veloboerse Olten Banner" />
	<h1 class="banner-title title-olten">
		Velobörse. Olten!
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
					Velobörse Zürich
					<br/>
					<br/>
					Nächstes Datum:
					<br/>
					22.05.2017
					<br/>
					<br/>
					alle sehen
				</h1>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Bike-billig.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<h2 class="item-title item-green">
					Wie läuft der
					<br/> 
					Velomarkt in
					<br/>
					<br/>
					Velomarkt in
					<br/>
					genau ab?
				</h2>
			</div>
		</div>

		<div class="box-row odd">
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Velo_Zustand.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<p class="item-desc">
					In Sachen Velobörsen ist Zürich einsame Spitze: Ganze sechs Mal pro Saison finden auf dem Helvetiaplatz Verkäufe von Secondhand-Bikes statt, hinzu kommen zwei weitere Märkte in Wollishofen und Oerlikon. Die Velobörse auf dem Helvetiaplatz gehört mit rund 1300 Fahrrädern zu den grössten der Schweiz - wenngleich nicht nur Gebrauchtvelos vertreten sind. Hinter den Veranstaltungen steht die sehr engagierte <a title="ProVelo Zürich" href="http://www.provelozuerich.ch" target="_blank">Pro Velo Zürich</a>, zu deren vollen Gunsten sinnvollerweise die Verkaufsprovisionen gehen.
					<br/>
					<br/>
					Testfahrten sind in einer Nebenstrasse gegen Abgabe eines Ausweisdokumentes möglich. Ein früher Besuch lohn sich aufgrund des grossen Andrangs - rund 60% der Velos finden in der Regel neue Besitzer. Verglichen mit anderen Börsen sind die Schlangen vor der Kasse hier zu den Stosszeiten lang (bezahlt werden kann nur in bar). Auffällig aktiv sind an der Velobörse auf dem Helvetiaplatz auch die zahlreich vertretenen Händler, die ihre Fahrräder bisweilen ein wenig aufdringlich anpreisen - die Atmosphäre ist dadurch etwas weniger entspannt als anderswo. Trotzdem: Ein Besuch lohnt sich!
				</p>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Gebrauchte_Velos.jpg')}}" alt="Box Image" />
			</div>
		</div>
		
		<div class="box-row odd">
			<div class="box-item exchange-box-item">
				<div class="exchange-list">
					<h1 class="search-title">Daten Velobörse Zürich</h1>
					<div class="search-options">
						<div class="hint-section">
							<span class="hint-item hint-title">Velos</span>
							<span class="hint-item hint-x-large">1000-1500</span>
							<span class="hint-item hint-large">600-1000</span>
							<span class="hint-item hint-medium">300-600</span>
							<span class="hint-item hint-small">100-300</span>
							<span class="hint-item hint-x-small">&lt; 100</span>
						</div>
					</div>
					<div class="search-result">
						<table class="result-table">
							<thead>
								<tr>
									<td>Datum</td>
									<td>Ortschaft</td>
									<td>Veranstaltungsort</td>
									<td>Grösse</td>
								</tr>
							</thead>
							<tbody>
								<tr class="result-item active">
									<td class="col-date">01.05.</td>
									<td class="col-town">Zürich</td>
									<td class="col-location">Helvetiaplatz</td>
									<td class="col-size">
										<span class="hint-item hint-x-large"></span>
									</td>
								</tr>
								<tr class="result-item">
									<td class="col-date">01.05.</td>
									<td class="col-town">Zürich</td>
									<td class="col-location">Helvetiaplatz</td>
									<td class="col-size">
										<span class="hint-item hint-large"></span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="box-item result-box-item">
				<div class="search-result-detail">
					<div class="detail-section section-time">
						<div class="section-title">
							<span class="detail-date">01.05.2017</span>
							<span class="detail-date">ZürichHelvetiaplatz</span>
							<span class="hint-item hint-x-large"></span>
						</div>
						<div class="section-info">
							<div class="info-row">
								<span class="info-col info-label">Verkauf</span>
								<span class="info-col info-value">10:00-17:00</span>
							</div>
							<div class="info-row">
								<span class="info-col info-label">Veloannahme</span>
								<span class="info-col info-value">10:00-17:00</span>
							</div>
							<div class="info-row">
								<span class="info-col info-label">Auszahlung</span>
								<span class="info-col info-value">16:00-18:00</span>
							</div>
							<div class="info-row">
								<span class="info-col info-label">Provision</span>
								<span class="info-col info-value">15%</span>
							</div>
						</div>
					</div>
					<div class="detail-section section-further">
						<div class="section-info">
							<div class="info-row">
								<span class="info-col-full">Vorverkauf Mitglieder Pro Velo: 09:00-10:00</span>
							</div>
							<div class="info-row">
								<span class="info-col-full">Veloannahme Händler: 21.05.2017, 18:00-20:00</span>
							</div>
							<div class="info-row">
								<span class="info-col-full">Auszahlung Händler: 18:00-19:00</span>
							</div>
						</div>
					</div>
					<div class="detail-section section-connection">
						<div class="section-info">
							<div class="info-row">
								<span class="info-col info-label">VeranstalterIn</span>
								<span class="info-col info-value">ProVelo Zürich</span>
							</div>
							<div class="info-row">
								<span class="info-col info-label">E-mail</span>
								<span class="info-col info-value">info@provelozuerich.ch</span>
							</div>
							<div class="info-row">
								<span class="info-col info-label">Tel.-Nummer</span>
								<span class="info-col info-value">044 555 55 55</span>
							</div>
							<div class="info-row">
								<span class="info-col info-label">Website</span>
								<span class="info-col info-value"><a href="http://www.provelozuerich.ch">www.provelozuerich.ch</a></span>
							</div>
							<div class="info-row">
								<span class="info-col info-label">Weitere Infos</span>
								<span class="info-col info-value">xyz</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="box-item info-box-item">
				<h2 class="info-title">Fahrrad verkaufen</h2>
				<ul class="info-content-list">
					<li>Velo zu Annahmezeiten (s. links) registrieren:</li>
					<li>Hierzu erhalten Sie vor Ort ein Formular</li>
					<li>Velo und ID vorweisen</li>
					<li>Einstellgebühr bezahlen (Fr. 5.-/wenn VP über</li>
					<li>Fr. 400.-: Fr. 10.-). Wird bei Verkaufserfolg erstattet.</li>
					<li>Velo auf Platz stellen, Formularkopie mitnehmen</li>
					<li>Auszahlung/Veloabholung: Zeiten s. links</li>
					<li>Hierzu Ihre Formularkopie wieder mitbringen!</li>
					<li>Download Börsenregeln</li>
					<li>Download Preisliste (Provisionen)</li>
					<li>Händler (ab 10 Velos): 2 Wochen vorher anmelden</li>
				</ul>
				<h2 class="info-title">Fahrrad kaufen</h2>
				<ul class="info-content-list">
					<li>Verkaufszeiten s. links - Tipp: Früh da sein!</li>
					<li>Velos mit ID ausserhalb des Platzes testen</li>
					<li>Ggf. Fahrrad von Assistenz kontrollieren lassen</li>
					<li>Velo bezahlen, mitnehmen - nur Barzahlung!</li>
				</ul>
			</div>
		</div>

		<div class="box-row odd">
			<div class="box-item">
				<h1 class="item-title item-green">
					Kompakt:
					<br/>
					<br/>
					Wichtige Infos zur
					<br/>
					Velobörse Zürich
				</h1>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Bike-billig.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<h2 class="item-title item-blue">
					Routenplaner
					<br/>
					<br/>
					Per Velo, zu Fuss
					<br/>
					mit dem ÖV
					<br/>
					<span>und wenn denn wirklich nötig...<br/>mit dem Auto (keine Parkplatzgewähr)!</span>
				</h2>
			</div>
		</div>

		<div class="box-row">
			<div class="box-item stock-box-item">
				<h2 class="stock-title">Ausgewählte Börse: Zürich Helvetiaplatz</h2>
				<div class="stock-list">
					<div class="stock-list-item">
						<span class="stock-key">Auswahl</span>
						<span class="stock-value">Top</span>
					</div>
					<div class="stock-list-item">
						<span class="stock-key">Auswahl</span>
						<span class="stock-value">Top</span>
					</div>
					<div class="stock-list-item">
						<span class="stock-key">Support durch Helfer</span>
						<span class="stock-value">Top</span>
					</div>
					<div class="stock-list-item">
						<span class="stock-key">Kartenzahlung</span>
						<span class="stock-value">Nein</span>
					</div>
					<div class="stock-list-item">
						<span class="stock-key">Schnelligkeit Abwicklung</span>
						<span class="stock-value">lange Schlagen</span>
					</div>
					<div class="stock-list-item">
						<span class="stock-key">Schutz vor Regen</span>
						<span class="stock-value">Nein</span>
					</div>
					<div class="stock-list-item">
						<span class="stock-key">Polizeikontrolle Velos</span>
						<span class="stock-value">teilweise</span>
					</div>
					<div class="stock-list-item">
						<span class="stock-key">Diebstahlschutz Ausgang</span>
						<span class="stock-value">Gut</span>
					</div>
					<div class="stock-list-item">
						<span class="stock-key">Diebstahlschutz Absperrung</span>
						<span class="stock-value">mässig</span>
					</div>
					<div class="stock-list-item">
						<span class="stock-key">Velo-Verkaufsstatus online</span>
						<span class="stock-value">Nein</span>
					</div>
					<div class="stock-list-item">
						<span class="stock-key">Abgabe am Vortag möglich</span>
						<span class="stock-value">Nein</span>
					</div>
				</div>
			</div>
			<div class="box-item">
				<h2 class="item-title item-blue">Love it? Like it!</h2>
				<div class="box-socials">
					<a class="box-social-icon icon-facebook" href="https://www.facebook.com"></a>
					<a class="box-social-icon icon-twitter" href="https://www.twitter.com"></a>
					<a class="box-social-icon icon-google-plus" href="https://plus.google.com"></a>
					<a class="box-social-icon icon-linkedin" href="https://www.instagram.com"></a>
					<a class="box-social-icon icon-pinterest" href="https://www.pinterest.com"></a>
				</div>
			</div>
			<div class="box-item">
				<div id="stockMap">
				</div>
			</div>
		</div>
	</div>
	
	<div class="region-detail-container">
		<h2 class="region-detail-title">Besuchereindrücke von der Fahrradbörse Zürich</h2>
		<div class="box-row long-box-row">
			<div class="box-item long-box-item">
				<img class="item-img" src="{{asset('assets/img/Velo-gebraucht-Zuerich.jpg')}}" alt="Box Image" />
				<img class="item-img" src="{{asset('assets/img/Velorad-Occasion.jpg')}}" alt="Box Image" />
				<img class="item-img" src="{{asset('assets/img/Velo-probieren.jpg')}}" alt="Box Image" />
				<img class="item-img" src="{{asset('assets/img/Velohaendler-Zuerich.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item long-box-item">
				<h2 class="region-desc-title">Velobörsen: Zürich ist Spitze</h2>
				<p class="region-desc-content">Von ihrem Stuhl aus überblickt Edna den gesamten Helvetiaplatz: Direkt vor ihr ein paar Kinderfahrräder, dahinter lange Reihen von Rennvelos und City Bikes in allen Farben, Formen und Zuständen bis hin zum ProVelo-Servicestand am anderen Ende des Platzes, und mittendrin sitzen die Händler unter Sonnenschirmen mit ihren Werkzeugkisten. Ein besonderes Augenmerk hat die cremefarbige Mischlingshündin natürlich auf die vor ihr platzierten Bikes, die ihr Herrchen, ein Händler, heute an den Mann oder die Frau bringen will.
				<br/><br/>
				Die Auswahl auf dem Zürcher Helvetiaplatz an der Langstrasse ist gross: es werden ca. 1300 Fahrräder zum Verkauf angeboten, etwa die Hälfte davon sind Occasion-Velos. Um die 60% aller Bikes findet gewöhnlich ein neues Zuhause. Kindervelos ebenso wie E-Bikes sind an diesem Maisamstag eher wenige vertreten. In Zürich als grösster Schweizer Stadt organisiert ProVelo auch die meisten Velobörsen. Allein sechs Mal pro Jahr zwischen März und September veranstaltet ProVelo Zürich auf dem Helvetiaplatz gegenüber dem Kanzlei-Flohmarkt eine Velobörse, jeweils einmal zudem am Wolli-Märt in Wollishofen im Hof des Schulhauses sowie in Oerlikon auf dem Max Bill-Platz. Die Kommission für Verkäufer liegt ungefähr zwischen 10 und 20%: bei Fr. 150 Verkaufspreis werden beispielsweise Fr. 120 ausgezahlt, bei Fr. 300 Verkaufspreis Fr. 250. Dazu kommt eine Einstellgebühr für Nichtmitglieder von Fr. 5 (bzw. Fr. 10 wenn das Velo über Fr. 400 kosten soll), die bei einem Verkauf zurückerstattet wird. Verglichen mit anderen Börsen wird auf dem Helvetiaplatz wenig Zubehör verkauft, auch Essensstände sucht man vergebens. Testen kann man das Velo in der Nebenstrasse.
				<br/><br/>
				Doch nicht nur die Grösse der Börse ist verglichen mit anderen derartigen Märkten beeindruckend, die Schlangen sind es auch: schon um halb 9 stehen die Menschen vor der Kasse, aber diese öffnet erst um 9 Uhr, so dass manche bereits ungeduldig werden. Bezahlt werden kann übrigens nur in bar. Auch am Schluss bei der Auszahlung bilden sich wieder Schlangen (eine separate Händlerkasse für Verkäufer von mehr als 10 Bikes gibt es nicht).
				<br/><br/>
				Auch in Zürich kann man zwischen unterschiedlichen Qualitätsstufen wählen, und nicht alle kommen mit so klaren Vorstellungen so wie der Herr, der ein Velo haben möchte, dessen Reifen nicht in die Tramschienen geraten. Etwas resigniert kommentiert ein Helfer, dass viele Leute weniger an technischen Details als vielmehr daran interessiert seien, ein lila Velo passend zum lila Kleid zu finden. So versuchten manche Händler auch immer wieder, qualitativ minderwertige Velos zu überhöhten Preisen zu verkaufen: „Ich habe durchgesetzt, dass einige der qualitativ schlechten Velos nicht zugelassen werden. Sie werden eingekauft für 50 Dollar, aber verkauft für Fr. 400.“ Dennoch kritisiert ein Händler, es gäbe in Zürich immer noch mehr minderwertige Velos als an anderen Orten. Auch müsse man als Händler früh auf dem Platz sein - so habe er sein erstes Velo bereits um halb 7 verkauft.
				<br/><br/>
				Oft versuchen die Händler dazu, ihre Velos in möglichst gutes Licht zu stellen, aber manchmal mit eher zweifelhaften Beteuerungen. Eine Käuferin fragt beispielsweise, ob denn das Velo in der Schweiz hergestellt worden sei? Natürlich, antwortet der Händler. Aber da stehe „Made in Taiwan“… woraufhin der Händler entgegnet, nein, das Fahrrad sei aus der Schweiz. Über die Preise der Fahrräder gehen die Meinungen auseinander: während sich ein Händler beschwert, dass die Leute hier zu sehr auf den Preis schauten und die Händler zu billig verkauften, finden einige Kunden wiederum die Händlerpreise überrissen. Da heute der erste Markt bei schönem Wetter ist, seien die Preise höher als bei schlechtem Wetter; allerdings gewähren die Händler, die nicht speziell gekennzeichnet sind, auf Nachfrage manchmal ein Preisnachlass.
				<br/><br/>
				Auch hier gilt: Exoten wie Tandems gehen bis zum Ende des Nachmittags nicht weg. Ein Velo im Toblerone-Design für 290 Franken findet so zwar viel Beachtung, bleibt aber am Schluss ebenfalls übrig. Abgesperrt ist die Velobörse nicht mit Zäunen, sondern lediglich mit grünen Kunststoffbanden, die zwar schnell aufgebaut, aber icht gerade sicher sind. Ein gewisses Diebstahlrisiko besteht vor allem nach dem offiziellen Verkaufsschluss, wenn sie zum einfacheren Wegräumen der Velos rasch eingerollt werden. Edna jedenfalls hat bis zum Börsenende gut aufgepasst, dass keines ihrer Velos verschwindet - und bestimmt hat sie sich positiv auf die Umsätze ihres Herrchens ausgewirkt…
			</div>
			<div class="box-item long-box-item">
				<img class="item-img" src="{{asset('assets/img/Renvelo-Zuerich.jpg')}}" alt="Box Image" />
				<img class="item-img" src="{{asset('assets/img/Fahrrad-testen-Zuerich.jpg')}}" alt="Box Image" />
				<img class="item-img" src="{{asset('assets/img/Testbike.jpg')}}" alt="Box Image" />
				<img class="item-img" src="{{asset('assets/img/Fahrrad-bezahlen.jpg')}}" alt="Box Image" />
			</div>
		</div>
	</div>
	@include('partials.jigjaw')
	@include('partials.slider')

	
</div>

@endsection

@section('additional_scripts')
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiDs7N3BtEEx2eXnm26oc5_ZRjomyhe0k&callback=initMap"></script>
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

