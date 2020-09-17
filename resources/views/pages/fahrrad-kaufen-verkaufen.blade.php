@extends('layouts.default')

@section('banner_content')

<div class="banner-wrapper">
	<img class="banner-image" src="{{asset('assets/img/banner-fahrrad-kaufen-verkaufen.jpg')}}" alt="Fahrrad Kaufen Verkaufen Banner" />
	<h1 class="banner-title title-fahrrad">
		Hingestellt.
		<br/>
		&nbsp;&nbsp;&nbsp;&nbsp;Verkauft!
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
					Kann & soll ich
					<br/>
					mein Fahrrad
					<br/>
					verkaufen an
					<br/>
					einer Velobörse?
				</h1>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Bike-guenstig.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<h2 class="item-title item-green">
					Secondhand-
					<br/>
					Bikes:
					<br/>
					<br/>
					Worauf ist zu
					<br/>
					achten beim Kauf?
				</h2>
			</div>
		</div>

		<div class="box-row odd">
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Fahrrad-untersuchen.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<p class="item-header">
					Was für Fahrräder werden an <br/>Velomärkten verkauft?
				</p>
				<p class="item-desc">
					Velobörsen wurden mit dem Gedanken geboren, dass gebrauchte Fahrräder auf einfache Weise neue Besitzer finden sollen. Dieser Philosophie sind sie treu geblieben, wenngleich mittlerweile an diversen Veranstaltungen auch eine Auswahl an neuen Fahrrädern vorzufinden ist. Wirklich genial ist und bleibt der rasche Verkauf von privaten Secondhand-Bikes, die in jedem Preisbereich angeboten werden - von gratis bis Tausende Franken. Nur ist klar: Velos aus zweiter Hand können Mängel aufweisen und deshalb sollten Sie jedes Fahrrad genau prüfen (<a href="#Anchor-57553">Tipps</a>) oder beim meist sehr hilfreichen Börsenteam untersuchen lassen. VelobesitzerInnen: Selbst wenn Sie ein uraltes Velo im Keller haben, es gibt Chancen zum Verkauf. Wenn es nicht ganz defekt ist und Sie den Verkaufspreis dem Zustand anpassen, finden sich oft freudige KäuferInnen, die es allenfalls kostengünstig selber reparieren können. Mehr dazu hier!
				</p>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/gutes-fahrrad.jpg')}}" alt="Box Image" />
			</div>
		</div>

		<div class="box-row padding-box odd bg-blue">
			<h2 class="box-title">Lohnt sich der Verkauf eines alten Velos?</h2>
			<div class="box-item long-box-item bg-transparent">
				<div class="desc-box bg-blue">
					<p>
						Unbedingt probieren!
						<br/>
						<br/>
						<span class="desc-undersline">Erstens:</span> Die Nachfrage nach Secondhand-Velos ist riesig und durch das Angebot am Markt nicht gedeckt. Das sind optimale Voraussetzungen. Da PrivatverkäuferInnen ihre Velos an Börsen zudem meist etwas günstiger anbieten als Händler, stehen Ihre Verkaufschancen sehr gut. Die Erfolgsquote für Private liegt je nach Börse bei bis zu 75-90%, Händler dagegen setzen vielleicht 60-65% ihrer Fahrräder ab. Nicht abschrecken lassen von Veloshops, welche die Reparatur von Mängeln als zu teuer bezeichnen - im Shop ja (gerechtfertigt), aber viele Käufer reparieren ihre Bikes eigenhändig
					</p>
				</div>
			</div>
			<div class="box-item long-box-item bg-transparent">
				<div class="desc-box bg-blue">
					<p>
						<strong>Zweitens:</strong> Mit dem Verkauf Ihres alten Velos tun Sie der Umwelt Gutes! Einerseits wird das Velo weiterhin gebraucht statt entsorgt - und das vielleicht noch Jahrzehntelang. Andererseits erhalten Käufer viel mehr für ihr Geld beim Kauf eines robusten gebrauchten Bikes als wenn sie für denselben Betrag ein günstiges Neuvelo kaufen müssten. Denn gerade im sehr gefragten günstigeren Bereich gibt es (ausser vergünstigt in einem Outlet) keine guten Neuräder. Ihr Secondhand-Velo rettet also vielleicht den Käufer davor, stattdessen Billigschrott zu kaufen, der zudem bald umweltbelastend wieder entsorgt werden muss. Re-cycling vom Feinsten!
					</p>
				</div>
			</div>
			<div class="box-item long-box-item bg-transparent">
				<div class="desc-box bg-blue">
					<p>
						Und das Velo meiner Grossmutter im Keller...?
						<br/>
						<br/>
						Landauf, landab stehen in Kellern, Garagen und Schöpfen Unmengen an alten Velos, die seit Jahrzehnten nicht mehr genutzt wurden. Verstaubt, vergessen werden sie schlussendlich irgendwann entsorgt. Alarm! Die meisten dieser Fahrräder sind in gutem bis sehr gutem Zustand und würden Ihnen nach kurzer Auffrischung rasch 150.- bis über 500.- (Oldtimer) Franken einbringen. Die robusten älteren Drei-, Fünf-, Sieben-, Zehngänger, etc. sind alle sehr gefragt an Velobörsen. Das Velo Ihrer Grossmutter gehört dazu und vielleicht bereiten Sie ihr grosse Freude, wenn es wieder losfahren kann!
					</p>
				</div>
			</div>
		</div>

		<div class="box-row padding-box odd bg-green">
			<h2 class="box-title title-blue">Mängel erkennen an gebrauchten Velos</h2>
			<div class="box-item long-box-item bg-transparent">
				<div class="desc-box">
					<p>
						Viele Fahrräder an Velobörsen sind in gutem bis sehr gutem Zustand. Das grösste Problem beim Kauf eines Occasionsvelos besteht aber darin, dass es Mängel aufweisen kann, die nicht gleich erkennbar sind. Möglicherweise sind sie auch dem Verkäufer nicht bewusst (sollte bei Händlern natürlich nicht vorkommen). Im Ernstfall können gewisse Defekte bei Gebrauch gefährlich werden, im ärgerlichen Fall einfach nur teuer. Deshalb: <strong>Testen Sie jedes Velo ausführlich und untersuchen Sie es möglichst gut, um spätere Enttäuschungen zu vermeiden.</strong> Lassen Sie sich nach Möglichkeit begleiten von velokundigen Bekannten - diese beraten oft liebend gerne und reparieren Ihnen vielleicht auch vorhandene Defekte. Oder fragen Sie das Assistenzteam, das an den meisten Velobörsen präsent ist (aber keine 100%-Garantien geben kann, zu wenig Zeit vorhanden). Einen Leitfaden kann auch die Checkliste unten geben. Grössere Reparaturen an alten Velos sind in Bikeshops oft zu teuer (kostenbedingt, geht nicht anders), kleinere hingegen in aller Regel kein Problem. Fragen Sie das Assistenzteam!
						<br/>
						<br/>
						<span class="desc-underline"><strong>Checkliste als PDF zum Ausdrucken</strong></span>
						<br/>
						<br/>
						<span class="desc-underline"><strong>Räder:</strong></span>
						<br/>
						<br/>
					</p>
					<ul class="desc-inner">
						<li>Drehen die Räder regelmässig an den Bremsklötzen vorbei oder haben sie Achter?</li>
						<li>Speichen: Alle vorhanden? Rost (abwischbar?)?</li>
						<li>Vorderrad anheben, Fahrrad an der Gabel festhalten und am Rad rütteln: Wackelt es in der Radnabe (Radmitte)? Wenn ja, muss dies behoben werden - dasselbe beim Hinterrad.</li>
						<li>Ist die Felgenwand vom vielen Bremsen dünn/unregelmässig geworden? Felge ersetzen!</li>
						<li>Reifen: Risse oder Brüche sichtbar, abgefahren? Wenn ja: Pneu ersetzen</li>
						<li>Verlieren die Reifen Luft?</li>
					</ul>
				</div>
			</div>
			<div class="box-item long-box-item bg-transparent">
				<div class="desc-box">
					<p>
						<span class="desc-underline"><strong>Schaltung:</strong></span>
						<br/>
						<br/>
					</p>
					<ul class="desc-inner">
						<li>Beim Fahren alle Gänge durchschalten, lassen sich die Schalthebel gut bewegen?</li>
						<li>Läuft die Schaltung sauber? Kann im Normalfall einfach behoben werden</li>
						<li>Schaltkabel: Rostig, ausgefranst? Ersetzen.</li>
						<li>Ritzel ("Zahnräder"): Stark abgenutzte oder</li>
						<li>abgebrochene Zähne? Müssten ersetzt werden</li>
					</ul>
					<p>
						<br/>
						<br/>
						<span class="desc-underline"><strong>Bremsen:</strong></span>
						<br/>
						<br/>
					</p>
					<ul class="desc-inner">
						<li>Beim Fahren und im Stehen Vollbremse vollziehen, lassen sich die Bremshebel einfach bewegen?</li>
						<li>Ziehen beide Bremsen richtig (essentiell!)? Bremse anziehen oder neue Bremsbeläge nötig?</li>
						<li>Bremskabel: Rostig, ausgefranst? Wenn ja: Ersetzen, können unvorhergesehen reissen!</li>
						<li>Bremsklötze: Dürfen die Reifen nicht berühren</li>
					</ul>
					<p>
						<br/>
						<br/>
						<span class="desc-underline"><strong>Pedale und Kurbeln:</strong></span>
						<br/>
						<br/>
					</p>
					<ul class="desc-inner">
						<li>Lassen sie sich ohne Behinderung bewegen?</li>
						<li>Wackeln?</li>
						<li>Pedale verbogen?</li>
						<li>Ritzel ("Zahnräder"): Stark abgenutzte oder</li>
						<li>abgebrochene Zähne? Müssten ersetzt werden</li>
					</ul>
					<p>
						<br/>
						<br/>
						<span class="desc-underline"><strong>Pedale und Kurbeln:</strong></span>
						<br/>
						<br/>
					</p>
					<ul class="desc-inner">
						<li>Genau untersuchen: Sind Risse oder Dellen sichtbar? Falls am Rahmen vorhanden: Fahrrad unbrauchbar, andere Teile können meist ersetzt werden</li>
						<li>Gabel: Verbogen (von Unfall)?</li>
						<li>Gabel frei drehbar ohne zu wackeln? Anziehen nötig!</li>
						<li>Funktioniert die Gabelfederung?</li>
					</ul>
				</div>
			</div>
			<div class="box-item long-box-item bg-transparent">
				<div class="desc-box">
					<p>
						<span class="desc-underline"><strong>Beleuchtung:</strong></span>
						<br/>
						<br/>
					</p>
					<ul class="desc-inner">
						<li>Funktioniert das Licht hinten und vorne?</li>
						<li>Sind Reflektoren hinten und vorne vorhanden (gesetzlich erforderlich)?</li>
					</ul>
					<p>
						<br/>
						<br/>
						<span class="desc-underline"><strong>Sonstiges:</strong></span>
						<br/>
						<br/>
					</p>
					<ul class="desc-inner">
						<li>Sattel: Darf nicht zu weit aus dem Sattelrohr gezogen werden (siehe Markierung) und muss fest verankert werden können</li>
						<li>Anbauteile: Es sollte nichts wackeln</li>
						<li>Federungen: Auf Körpergewicht des Fahrers einstellbar? Voll funktionstüchtig?</li>
						<li>Testfahren, testfahren, testfahren! Velogrösse (Rahmenhöhe und Distanz zum Lenker) passend?</li>
						<li>Lenker und Sattel bequem? Gutes und sicheres Fahrgefühl?</li>
					</ul>
					<p>
						<br/>
						<br/>
						Diese Checkliste dient nur zur groben Orientierung und stellt keinen Anspruch auf Vollständigkeit. Es kann keinerlei Haftung übernommen werden bei Verwendung der Liste. Lassen Sie das Fahrrad in jedem Fall vor Gebrauch von einem Fachmann überprüfen.
					</p>
				</div>
			</div>
		</div>

	</div>
	
	@include('partials.jigjaw')
	@include('partials.slider')

	
</div>

@endsection

