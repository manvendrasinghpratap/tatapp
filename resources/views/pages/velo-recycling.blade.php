@extends('layouts.default')

@section('banner_content')

<div class="banner-wrapper">
	<img class="banner-image" src="{{asset('assets/img/banner-velo-recycling.jpg')}}" alt="Velo Recycling Banner" />
	<h1 class="banner-title">
		Genial. Alle Velobörsen!
		<p>der Schweiz auf einer Seite</p>
	</h1>

	<div class="banner-meta-wrapper">
		<div class="banner-social">
			<a class="banner-social-icon icon-facebook" href="https://www.facebook.com"></a>
			<a class="banner-social-icon icon-twitter" href="https://www.twitter.com"></a>
			<a class="banner-social-icon icon-google-plus" href="https://plus.google.com"></a>
			<a class="banner-social-icon icon-linkedin" href="https://www.instagram.com"></a>
			<a class="banner-social-icon icon-pinterest" href="https://www.pinterest.com"></a>
		</div>
		<div class="banner-newsletter">
			<form action="" method="POST">
				<input type="text" name="newsletter_email" placeholder="Velobörsen per E-mail" />
				<input type="submit" name="newsletter_submit" value="Go!" />
			</form>
		</div>
	</div>
</div>

@endsection

@section('main_content')
<div class="main-content-wrapper" ng-controller="pageController" ng-init="init()">
	<div class="box-container">
		<div class="box-row odd">
			<div class="box-item">
				<h1 class="item-title item-blue">
					Velos nach
					<br/>
					Afrika verschenken:
					<br/>
					<br/>
					So einfach können
					<br/>
					Sie helfen und
					<br/>
					Freude bereiten!
				</h1>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Velos-fuer-afrika.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<h2 class="item-title item-green">
					Lesen Sie die Studie:
					<br/>
					<br/>
					Mit Velos
					<br/>
					wird Armut
					<br/>
					deutlich reduziert!
				</h2>
			</div>
		</div>

		<div class="box-row odd">
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Fahrraeder-fuer-Afrika.jpg')}}" alt="Box Image" />
			</div>
			<div class="box-item">
				<p class="item-header">
					Velafrica: Alte Schweizer Velos nach Afrika
				</p>
				<p class="item-desc">
					<strong>Die Idee ist so einfach wie genial:</strong> <a title="Velos sammeln für Afrika" href="http://velafrica.ch/de/" target="_blank">Velafrica</a> sammelt in der Schweiz ausgediente Velos ein, lässt sie hierzulande in sozialen Einrichtungen instandstellen und verschifft sie anschliessend nach Afrika. Bei uns werden die Fahrräder nicht einfach entsorgt, sondern schaffen Arbeitsplätze und Integration. In Afrika verhelfen die Drahtesel ihren neuen BesitzerInnen zu wesentlich besseren wirtschaftlichen Chancen und geben ihnen vereinfachten Zugang zu Bildung und Gesundheitsversorgung. <strong>Denn wenn Distanzen weit und keine Verkehrsmittel vorhanden sind, bewirken zwei Räder Wunder - wie die eindrückliche <a title="Studie Velafrica" href="http://velafrica.ch/media/archive1/PDF_Deutsch/Wirkungsstudie/160901_Impact_kurz_Layout_def.pdf" target="_blank">Studie von Velafrica</a> zeigt.</strong> Velafrica engagiert sich zudem auch vor Ort, hilft mit beim Aufbau von Fahrradwerkstätten und bildet Mechanikerinnen und Mechaniker aus - es entstehen Arbeitsplätze und Perspektiven.
					<br/>
					<strong>Wenn Sie Ihr altes Velo also lieber verschenken als verkaufen: Nichts einfacher als das, an über <a title="Sammelstellen Velafrica" href="http://velafrica.ch/de/Machen-Sie-mit/Sammelstellen" target="_blank">500 Sammelstellen</a> kommen schweizweit jährlich 20'000 alte Fahrräder zusammen <a title="Factsheet Velafrica" href="http://velafrica.ch/media/archive1/PDF_Deutsch/2017_d_Factsheet_Velafrica.pdf" target="_blank">(Factsheet)</a>. Machen Sie mit und und bringen Sie grosse Freude südwärts!</strong>
				</p>
			</div>
			<div class="box-item">
				<img class="item-img" src="{{asset('assets/img/Fahrrad-gratis-schenken.jpg')}}" alt="Box Image" />
			</div>
		</div>
	</div>
	
	@include('partials.jigjaw')
	@include('partials.slider')

	
</div>

@endsection

