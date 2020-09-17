@extends('layouts.default')

@section('additional_styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
<link rel="stylesheet" href="{{asset('assets/css/datetimepicker.css')}}">

@endsection

@section('banner_content')

<div class="banner-wrapper">
	<img class="banner-image" src="{{asset('assets/img/banner-veloboerse-eintragen.jpg')}}" alt="Veloboerse Eintragen Banner" />
	<h1 class="banner-title title-eintragen">
		Velo
		<br/>
		&nbsp;&nbsp;Börse
		<br/>
		&nbsp;&nbsp;anmelden.
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
					Kostenlos für
					<br/>
					Organisatoren:
					<br/>
					<br/>
					Ihre Velobörse
					<br/>
					hier eintragen
					<br/>
					Topplatz bei Google!
				</h1>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Kindervelo-gebraucht.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<h2 class="item-title item-green">
					Führen Sie eine 
					<br/> 
					Velobörse durch:
					<br/>
					<br/>
					Es geht
					<br/>
					ganz einfach!
				</h2>
			</div>
		</div>

		<div class="box-row odd">
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Fahrrad-reparieren.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<p class="item-desc">
					<a href="#">Börse eintragen</a> - So einfach fügen Sie als Veranstalter Ihre Börse dem <a title="Velobörsenkalender" href="veloboerse-datum.html" target="_self">Velobörsenkalender</a> bei. Mehrere Börsen an verschiedenen Daten? Ganz einfach in einem Mal eintragen!
					<br/>
					<br/>
					<a href="#">Börse durchführen</a> - Hier finden Sie nützliche Hinweise, worauf zu achten ist bei der Organisation einer Börse.
					<br/>
					<br/>
					<strong>Gute Velobörsen sind ein Besuch wert, selbst wenn man kein Fahrrad kaufen möchte.</strong>
					. Insbesondere an Börsen an speziellen Orten herrscht eine wunderbar entspannte und freudvolle Atmosphäre - Kinder radeln überall umher und den "Grossen" macht es nicht weniger Spass, Velo um Velo frei zu testen. Ganz besonders gilt dies in <a title="Velobörse Luzern" href="veloboerse-luzern.html" target="_self">Luzern</a> direkt am See, in Basel unter den Bäumen der Kunsteisbahn Margarethen, speziell ist auch <a title="Velobörse Olten" href="veloboerse-olten.html" target="_self">Olten</a> auf der alten Holzbrücke. Wenn Sie einen Markt für gebaruchte Velos durchführen möchten, machen Sie sich und Ihren Besuchern also bestimmt die grösste Freude, wenn Sie sich nach einem tollen Ort mit Atmosphäre umsehen - wie wär's mit dem Innenhof einer alten Burg? Besucher und Medien garantiert und gute Börsen publizieren wir hier mit Bildern!
				</p>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Fahrradkauf-Luzern.jpg')}}" alt="Box Image" />
			</div>
		</div>
		
		<div class="box-row odd">
			<div class="full-box-item exchange-box-item">
				<div class="exchange-list">
					<h1 class="search-title">Veranstalter: Gratis Eintrag im Velobörsenkalender</h1>
					<div class="register-form-container">
						<form action="" method="POST">
							<div class="form-layout">
								<span class="field-comment">Bis 6 Börsendaten sind hier gleichzeitig erfassbar</span>
								<div class="form-field">
									<label for="">Börsendaten*</label>
									<datetimepicker data-ng-model="data.dateDropDownLink" data-datetimepicker-config=""/>
								</div>
								<div class="form-field">
									<label for="register_location">Veranstaltungsort</label>
									<input type="text" name="register_location" id="register_location" />
								</div>
								<div class="form-field">
									<label for="register_street">Strasse* / (Nr.)</label>
									<input type="text" name="register_street" id="register_street" />
								</div>
								<div class="form-field">
									<label for="register_city">Ort* / Kanton*</label>
									<select id="register_city" ui-select2 ng-model="register_city" data-placeholder="z.B. Zürich / ZH">
										<option value=""></option>
										<option ng-repeat="code in regionCodes" ng-model = "register_city" ng-value="code">[[code]]</option>
									</select>
									<!-- <input type="text" name="register_city" id="register_city" placeholder="z.B. Zürich / ZH" /> -->
								</div>
								<div class="form-field">
									<label for="register_sale">Verkauf*</label>
									<input type="text" name="register_sale" id="register_sale" placeholder="z.B. 10:00-17:00" />
								</div>
								<div class="form-field">
									<label for="register_member_sales">Mitgliederverkauf</label>
									<input type="text" name="register_member_sales" id="register_member_sales" placeholder="z.B. 09:00-10:00" />
								</div>
								<div class="form-field">
									<label>Annahme Private*<br/><span>** frei lassen falls<br/>nicht zutreffend</span></label>
									<div class="form-sub-layout">
										<div class="form-sub-field">
											<label for="register_acceptance_private_previous">Vortag **</label>
											<input type="text" name="register_acceptance_private_previous" id="register_acceptance_private_previous" placeholder="z.B. 18:00-19:00" />
										</div>
										<div class="form-sub-field">
											<label for="register_acceptance_private_sales">Verkaufstag</label>
											<input type="text" name="register_acceptance_private_sales" id="register_acceptance_private_sales" placeholder="z.B. 08:00-10:00" />
										</div>
									</div>
								</div>
								<div class="form-field">
									<label for="">Annahme Händler</label>
									<div class="form-sub-layout">
										<div class="form-sub-field">
											<label for="register_accepting_dealer_previous">Vortag **</label>
											<input type="text" name="register_accepting_dealer_previous" id="register_accepting_dealer_previous" placeholder="z.B. 18:00-19:00" />
										</div>
										<div class="form-sub-field">
											<label for="register_accepting_dealer_sales">Verkaufstag</label>
											<input type="text" name="register_accepting_dealer_sales" id="register_accepting_dealer_sales" placeholder="z.B. 08:00-10:00" />
										</div>
									</div>
								</div>
								<div class="form-field">
									<label for="register_payout_private">Auszahlung Private*</label>
									<input type="text" name="register_payout_private" id="register_payout_private" placeholder="15:00-17:00" />
								</div>
								<div class="form-field">
									<label for="register_member_sales">Auszahlung Händler</label>
									<input type="text" name="register_member_sales" id="register_member_sales" placeholder="17:00-19:00" />
								</div>
								<div class="form-field">
									<label for="register_member_sales">Provision*</label>
									<input type="text" name="register_member_sales" id="register_member_sales" placeholder="z.B. 15% oder 10-15%" />
								</div>
								<div class="form-field">
									<label for="register_member_sales">Empfohlen:</label>
									<div class="form-sub-layout">
										<a class="form-sub-field" href="">Provisionsliste hochladen</a>
										<a class="form-sub-field" href="">Börseninfos hochladen</a>
									</div>
								</div>
							</div>

							<div class="form-layout">
								<div class="form-field">
									<label for="register_organizer">VeranstalterIn*</label>
									<input type="text" name="register_organizer" id="register_organizer" />
								</div>
								<div class="form-field">
									<label for="register_organizer_street">Strasse / Nr.*</label>
									<input type="text" name="register_organizer_street" id="register_organizer_street" />
								</div>
								<div class="form-field">
									<label for="register_organizer_zip">PLZ / Ort*</label>
									<input type="text" name="register_organizer_zip" id="register_organizer_zip" />
								</div>
								<div class="form-field">
									<label for="register_organizer_email">E-mailadresse*</label>
									<input type="email" name="register_organizer_email" id="register_organizer_email" required />
								</div>
								<div class="form-field">
									<label for="register_organizer_phone">Tel.-Nummer*</label>
									<input type="tel" name="register_organizer_phone" id="register_organizer_phone" required />
								</div>
								<div class="form-field">
									<label for="register_organizer_website">Website</label>
									<input type="url" name="register_organizer_website" id="register_organizer_website" />
								</div>
								<div class="form-field">
									<label for="register_organizer_further">Weitere Infos</label>
									<textarea name="register_organizer_further" id="register_organizer_further"></textarea>
								</div>
								<span class="field-comment">Wie viele Velos werden ca. angeboten (anklicken)?*</span>
								<div class="form-field">
									<div class="bike-checkbox-container">
										<input type="radio" id="bike_amount_x_large" name="bike_amount" value="x-large" />
										<label class="x-large" for="bike_amount_x_large">1000-1500</label>
									</div>
									<div class="bike-checkbox-container">
										<input type="radio" id="bike_amount_large" name="bike_amount" value="large" />
										<label class="large" for="bike_amount_large">600-1000</label>
									</div>
									<div class="bike-checkbox-container">
										<input type="radio" id="bike_amount_medium" name="bike_amount" value="medium" />
										<label class="medium" for="bike_amount_medium">300-600</label>
									</div>
									<div class="bike-checkbox-container">
										<input type="radio" id="bike_amount_small" name="bike_amount" value="small" />
										<label class="small" for="bike_amount_small">100-300</label>
									</div>
									<div class="bike-checkbox-container">
										<input type="radio" id="bike_amount_x_small" name="bike_amount" value="x-small" />
										<label class="x-small" for="bike_amount_x_small">&lt; 100</label>
									</div>
								</div>
								<div class="form-field submit-form-field">
									<span class="submit-desc">Alle Einträge werden manuell geprüft und freigeschaltet. Sie erhalten danach eine Bestätigung per E-mail.</span>
									<input type="submit" value="Senden!" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="box-row register-desc-box">
			<h2>Velomarkt durchführen: Was ist zu beachten?</h2>

			<div class="box-item long-box-item bg-transparent">
				<p class="desc-box">
					<strong>Wozu eine Velobörse durchführen?</strong>
					<br/>
					<br/>
					Velo-Recycling ist überaus sinnvoll. Mit der Organisation einer Fahrradbörse können Sie das optimal unterstützen und im gleichen Atemzug durch Provisionseinnahmen Geld für andere Projekte generieren. Nach diesem Prinzip agiert zum Beispiel die <a title="Pro Velo" href="http://www.provelo.ch" target="_blank">Pro Velo</a> mit unzähligen Börsen in der ganzen Schweiz. Die (durchaus beachtlichen) Einnahmen setzt sie gekonnt zur Förderung des Veloverkehrs ein. Unter anderem mit den Börsen hat die Pro Velo grossen Bekanntheitsgrad erlangt und dadruch erfährt auch ihr politisches Engagement zusätzlich Zulauf. Das Konzept geht auf und auch viele andere kleinere Sozial- und Umweltprojekte wenden es erfolgreich an. Die Nachfrage nach Occasions-Velos ist hoch - Velobörsen sind also auch eine gute Möglichkeit, Ihrem Projekt finanziell auf die Beine zu helfen.
					<br/>
					<br/>
					Bevor Sie eine Fahrradbörse organisieren, sollten Sie sich jedoch einige Gedanken machen und gut planen. Am besten besuchen Sie zuerst eine oder mehrere grössere Veranstaltungen und studieren deren Systeme. Schon als Besucher werden Sie sehen, was gut klappt und wo es nicht ganz reibungslos abläuft - es gibt grosse Unterschiede bei Methoden und Organisationsgrad.
			</div>
			<div class="box-item long-box-item bg-transparent">
				<p class="desc-box">
					<strong>Zu mindestens folgenden Punkten sollten Sie genaue Überlegungen anstellen:</strong>
					<br/>
					<br/>
					<strong>1. Zeitpunkt:</strong> Frühling optimal - da werden am meisten Velos gekauft. Sommer/Frühherbst ok.
					<br/>
					<br/>
					<strong>2. Veranstaltungsort:</strong> Wenn möglich regensicher, gut erreichbar - optimal: Ort mit Charakter. Lassen sich Besucher gut leiten (Annahme, Kasse)? Wo können Velos getestet werden (optimal: Auf Platz)?
					<br/>
					<br/>
					<strong>3. Sicherung des Areals:</strong> Diebstahlgefahr, welche Sicherheitsmassnahmen sind notwendig? Ausgangskontrolle in jedem Fall wichtig.
					<br/>
					<br/>
					<strong>4. Werbung:</strong> Kostengünstig sind Medienberichte (Pressemitteilung versenden), Social Media, Online-Veranstaltungskalender, unser Börsenkalender, Börsenliste der Pro Velo, Flyers, Plakate. Inserate lohnen sich allerhöchstens für Grossanlässe.
					<br/>
					<br/>
					<strong>5. Mitarbeitende:</strong> Sie brauchen ausreichend Hilfe, am besten schon bei der Organisation und vor Ort. Velos müssen angenommen werden, Kasse, Geldausgabe, Ausgangskontrolle, optimal ist auch eine technische Beratung.
					<br/>
					<br/>
					<strong>6. Verkäufer:</strong> Nur Private oder auch Händler?
			</div>

			<div class="box-item long-box-item bg-transparent">
				<p class="desc-box">
					<strong>7. Velos:</strong> Nur gebrauchte Bikes oder auch Neuräder? Oft liquidieren Händler Altbestände an Börsen - insofern attraktiv, als dass die Provisionen aufgrund der Preise höher sind als bei Occasionen.
					<br/>
					<br/>
					<strong>8. Vermittlungsprovision:</strong> Üblich zwischen 10 und 20%, 15% meist angemessen. Es gibt auch abgestufte Modelle (kleinerer Prozentsatz für teurere Velos). Zudem Gebühr für Einstellung des Velos (nur erstattbar bei erfolgreichem Verkauf)? Konditionen immer klar benennen!
					<br/>
					<br/>
					<strong>9. System:</strong> Computergestützte System nur geeignet für grosse Veranstaltungen, deshalb wird meist eine Methode mit drei Quittungen am idealsten sein: Eine Kopie für den Verkäufer bei Abgabe des Velos, zwei werden am Fahrad befestigt. Eine davon ist Verkaufsquittung für den Käufer, die andere wird beim Verkauf in einem Register abgelegt. Alle immer abstempeln, sonst Betrugsgefahr. Wenn Verkäufer mit seinem Beleg die Auszahlung abholen möchte, wird im Register geprüft, ob die Gegenquittung vorhanden ist und wenn ja ausgezahlt. Dem Verkäufer seinen Beleg bei Auszahlung abnehmen und Erhalt des Geldes unterzeichnen lassen. Auszahlungszeiten genau definieren, tagsüber Belege im Register sortieren für rasche Auffindbarkeit!
			</div>
		</div>
	</div>

	@include('partials.jigjaw')
	@include('partials.slider')

	
</div>

@endsection

@section('additional_scripts')

@endsection
