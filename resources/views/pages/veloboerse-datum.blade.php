@extends('layouts.default')

@section('banner_content')

<div class="conatiner-fluid banner-wrapper">
	<img class="banner-image" src="{{asset('assets/img/banner-veloboerse-datum.jpg')}}" alt="Veloboerse Datum Banner" />
	<h1 class="banner-title title-all">
		Der. Velo.
		<br/>
		Börsenkalender
	</h1>

	@include('partials.banner-meta');
</div>

@endsection

@section('main_content')
<div class="main-content-wrapper" ng-controller="pageController" ng-init="init()">
	<div class="exchange-list">
		<h1 class="search-title">Der Velobörsenkalender: Börsen in der Schweiz finden</h1>
		<div class="search-options">
			<div class="form-section">
				<input type="text" placeholder="Ort oder Kanton" />
				<a class="btn btn-search">Finden!</a>
			</div>
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
		<div class="search-result-detail">
			<div class="detail-section section-time">
				<div class="section-title">
					<span class="detail-date">01.05.2017</span>
					<span class="detail-date">ZürichHelvetiaplatz</span>
					<span class="hint-item hint-x-small"></span>
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
			<div class="detail-section section-connection">
				<div class="section-title">
					<span class="detail-date">Infolink zu dieser Velobörse</span>
				</div>
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
				</div>
			</div>
			<div class="detail-section section-further">
				<div class="section-title">
					<span class="detail-date">Weitere Infos</span>
				</div>
				<div class="section-info">
					<div class="info-row">
						<span class="info-col-full">xyz</span>
					</div>
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
		</div>
	</div>
</div>

@include('partials.slider');
@include('partials.jigjaw');


@endsection