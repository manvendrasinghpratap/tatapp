@extends('layout.frontend.header')
@section('content')
<style>
    iframe{
        height:200px !important;
        width:100% !important;
    }

.error {
    color: red;
    font-size: 10px;
}
</style>
<script>

$(document).ready(function () { // Load on page load
    var marketid = {{@$products[0]->id}}
    if(marketid)
    {
        getdata('market/detailregional',marketid);
    }
    
});

</script>
   <section>
                <div class="flex-wrap gd-txt-wrp">
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                        <a href="#mrkt">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <div class="gd-txt gd-big-hdd-txt gd-big-hdd-txt">
                                        <h1>
                                            {{_i('Velobörse Bern')}}    
                                        </h1>
                                        <h1>  {{_i('Nächstes Datum:')}}  <br />
                                        @if(count($products)>0)
                                            {{date('d.m.Y',strtotime($products[0]->date))}} 
                                        @else
                                            {{'--'}}
                                        @endif
                                        
                                        <br /><br />   {{_i('See all')}}  
                                        </h1>
                                    </div>                               
                                </div>
                            </div> 
                         </a>                  
                    </div>
                    <!-- /REPEAT GRID  -->
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Velo-Occasion-Bern.jpg')}}" alt="bike billig" />                                
                                </div>
                            </div>  
                        </a>                 
                    </div>
                    <!-- /REPEAT GRID  -->
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <div class="gd-txt gd-txt-2 gd-txt-grn gd-big-hdd-txt gd-big-hdd-txt">
                                        <h2 class="frline-txt">
                                            {{_i('Wie läuft der')}} <br />{{_i('Velomarkt in')}} :<br /><br />   {{_i('Bern')}}  <br />{{_i('genau ab?')}} 
                                        </h2>
                                    </div>
                                </div>
                            </div> 
                        </a>                  
                    </div>
                    <!-- /REPEAT GRID  -->               
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Kindervelo-guenstig.jpg')}}" alt="velo_zustand" />
                                </div>
                            </div>     
                        </a>              
                    </div>
                    <!-- /REPEAT GRID  -->
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                        <div class="display-table gd-ct-wp txt-vtop">
                <div class="display-cell dv-brdr-cls">
                    <div class="gd-txt gd-txt-h1 gd-txt-para contentCustomScroller">
                                    <h4>
                                      {{_i('Die kundenfreundliche Börse')}}   
                                    </h4>
                                    <p>{{_i('Die zweimal jährlich stattfindende Velobörse Bern zeichnet sich durch die praktisch komplette Abwesenheit von Warteschlangen aus, was insbesondere dem gekonnten Einsatz moderner Technik zu verdanken ist. Es wird mit Barcodescannern gearbeitet und man kann nicht nur mit Karte (Postcard, Maestro, Visa) bezahlen, sondern sogar den Verkaufsstatus des eigenen Velos online verfolgen. Ein grosses Lob an die Veranstaltende')}} <a target="_blank" href="https://www.provelobern.ch/" title="ProVelo Bern">{{_i('Pro Velo Bern')}}</a>, {{_i('die überaus engagiert für die Besucherinnen und Besucher denkt und den Velokauf zum Spass macht.')}}
                                    <br> {{_i('Die Börse in der Kaserne Bern gehört mit etwas über Tausend Velos zu den grossen Veranstaltungen. Fahrräder können bereits am Vorabend abgegeben werden, woduch sich der Andrang an der Annahme am Verkaufstag in Grenzen hält. Testfahrten finden auf einem abgesperrten Gelände hinter der Halle statt, ein Ausweisdokument muss dazu nicht abgegeben werden.')}}
			                        </p>
                                    <p>{{_i('Neben dem Markt in der Kaserne führt auch der')}} <a target="_blank" href="https://sportboerse.ch/de/" title="Sportbörse">{{_i('Verein Sportbörse')}}</a> {{_i('zwei jährliche Velobörsen durch, die durchaus nennenswerte Auswahl bieten. Nicht wegdenkbar sind zudem natürlich die grossen Regionalbörsen in')}} <a href="{{route('veloboerse-biel')}}">{{_i('Biel')}}</a> {{_i('und in der Velostadt')}} <a target="_blank" href="https://www.provelo-emmental.ch/" title="Velobörse Velostadt Bugdorf">{{_i('Burgdorf')}}</a>.</p>
                                    <p><u>{{_i('Ganzjährige Alternativen')}} &gt;&gt;&gt; {{_i('Bikeshops mit grosser Auswahl:')}}</u></p>
                                    <ul>
										<li>{{_i('Occasionen')}}:
                                            <a target="_blank" href="https://sportboerse.ch/de/" title="Sportbörse">{{_i('Sportbörse')}}</a>
                                            <a target="_blank" href="http://drahtesel.ch/de/Dreigaenger-Veloladen" title="Drahtesel Bern">{{_i('Drahtesel')}}</a>
                                        </li>
										<li>
                                            {{_i('Reduzierte Neuvelos')}}: <a target="_blank" href="https://sportboerse.ch/de/" title="Sportbörse">Sportbörse</a></li>
									</ul>
                                </div>
                            </div>
                        </div>                   
                    </div>
                    <!-- /REPEAT GRID  -->
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Bike-kaufen.jpg')}}" alt="gebrauchte velos"  >
                                </div>
                            </div>  
                        </a>                 
                    </div>
                    <!-- /REPEAT GRID  -->
                    
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                        <div class="display-table gd-ct-wp">
                                <div class="display-cell lnnwsbg" id="mrkt">
                    <?php
                    $rng = (isset($_GET['range']) && !empty($_GET['range'])) ? $_GET['range'] : "";
                    $m_order = (isset($_GET['order']) && !empty($_GET['order']) && $_GET['order'] == 'asc') ? 'desc' : "asc";
                    $locations = array();
                    ?>
                                     <div class="mark-list-wrp">
                                        <div class="mark-tag-wrp">
                                            <div class="mark-tag">
                                                <h1>  {{_i('Daten Velobörse Bern')}}</h1>
                                                   @foreach($range as $ranges)
                    <a href="{{url()->current()}}?range={{$ranges->range_id}}#mrkt" style="background:  {{$ranges->range_color}};color:#fff" class="wt-bg">{{$ranges->range_from}}-{{$ranges->range_to}}</a>
                    @endforeach

                    <a href="{{route('veloboerse-bern')}}" style="background:#808080;color:#fff" class="wt-bg"><i class="fa fa-refresh" title="Clear Filters" aria-hidden="true"></i></a>
                                        
                                            </div>
                                        </div>
                                        <div class="row-bx">
                                            <div class="row-block">
                                                <div class="col-full">
                                                    <div class="mark-locwrp">
                                                        <div class="display-table">
                                                            <!-- REPEAT -->
                                                            <div id="content">
                                                                <div class="single-row-makt-data-table-outer">
                    <div class="single-row-makt-data-table dv-tbl-scrll">
                        <table>
                            <thead>
                                <tr>
                                    <th style="background: none !important;"><a href="{{url()->current()}}?range={{$rng}}&type=date&order=<?php echo (isset($_GET['type']) && !empty($_GET['type']) && trim($_GET['type']) == 'date') ? $m_order : 'asc';?>#mrkt"> {{_i('Datum')}} <i class="fa fa-sort" style="color:black;"></i></a> </th>
                                    <th style="background: none !important;">{{_i('Ortschaft')}}</th>
                                    <th>{{_i('Veranstaltungsort')}}?</th>
                                    <th style="background: none !important;"><a href="{{url()->current()}}?range={{$rng}}&type=range&order=<?php echo (isset($_GET['type']) && !empty($_GET['type']) && trim($_GET['type']) == 'range') ? $m_order : 'asc';?>#mrkt" style="background: none !important;">{{_i('Grösse')}} <i class="fa fa-sort" style="color:black;"></i></a></th>
                                </tr>
                            </thead> 
                            <tbody>
                                @if(count($products) > 0)
                                @foreach($products as $key => $market)
                                <?php 
                                    if(!empty($market->latitude) && !empty($market->longitude)){
                                        $locations[] = array($market->street,$market->latitude, $market->longitude,$key);
                                    }
                                ?>
                                    <tr>
                                        <td>{{date("d-m", strtotime($market->date))}}</td>
                                        <td><a style="text-decoration:underline; cursor:pointer;" onclick="getdetailregional({{$market->id}})" style="cursor: pointer;">{{$market->town}}</a></td>
                                        <td>{{$market->place}}</td>
                                        <td><div style="background:{{$market->general_range->range_color}}" class="clrd-bx gn-bx"></td>
                                    </tr>
                                @endforeach
                                @else
                                <tr><td colspan="3"> {_i('No data found')}}</td></tr>
                                @endif
                            </tbody>
                        </table>
                        <?php $filter = array(); 
                        if(isset($_GET['q']) && !empty($_GET['q'])){
                            $filter['q'] = trim($_GET['q']);
                        }
                        if(isset($_GET['range']) && !empty($_GET['range'])){
                            $filter['range'] = trim($_GET['range']);
                        }
                        if(isset($_GET['type']) && !empty($_GET['type'])){
                            $filter['type'] = trim($_GET['type']);
                            if(isset($_GET['order']) && !empty($_GET['order'])){
                                $filter['order'] = trim($_GET['order']);
                            }
                        }           
                        ?>
                        
                        
                    </div>
                </div>

                                                         
                                                            </div>
                                                          
                                                            <!-- /REPEAT -->                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                                             
                    </div>
                    <!-- /REPEAT GRID  -->
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                         <div class="display-table gd-ct-wp">
                                <div class="display-cell" id="contentdetailregional">
                                    
                                </div>
                            </div>   
                    </div>
                    <!-- /REPEAT GRID  -->
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell lnnwsbg">
                                    <div class="gd-txt feat-list">
                                        
                                        {!!$data['sellingdata']->description!!}

                                    </div>
                                </div>
                            </div>  
                         </a>                    
                    </div>
                    <!-- /REPEAT GRID  -->
                    
                    <!-- REPEAT GRID  -->
                    <!--<div class="flex-col">
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <div class="gd-txt gd-txt-h2 gd-txt-grn gd-big-hdd-txt">
                                        <h2>
                                            {{_i('Compact')}}:
                                        </h2>
                                        <h2>
                                            {{_i('Important information about the bike exchange Bern')}}
                                        </h2>
                                    </div>
                                </div>
                            </div> 
                        </a>                  
                    </div>-->
                    <!-- /REPEAT GRID  -->               
                    <!-- REPEAT GRID  -->
                    <!--<div class="flex-col">
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Fahrrad-Oldtimer.jpg')}}" alt="bike secodhand" />
                                </div>
                            </div>     
                        </a>              
                    </div>-->
                    <!-- /REPEAT GRID  -->
                    <!-- REPEAT GRID VIDEO SECTION STARTS HERE  -->
                    @include('videoleft')
                    <!-- REPEAT GRID  -->
                     <div class="flex-col  top_btm_boder dv-vdo-frnt">
                        <div class="display-table gd-ct-wp tl-dnm-bx">
                                <div class="display-cell">
                                        <div class="gd-txt gd-txt-h2 gd-txt-para contentCustomScroller">
                                        <h2>
                                            <h2> {{_i('Teile Deinen besten Film vom Markt in')}} {{_i('Bern')}}!</h2>
                                        </h2>

                                        <form  id="video-form" method="POST" enctype="multipart/form-data" action='{{route("add-videos")}}'>
										{{ csrf_field() }}

                                        <input type="hidden" name="regional_id" value="3">
                                        <!--include common video section-->
                                        @include('videofront')
                                        
                                </div>
                        </div> 
                    </div>       
                   
                    <!-- /REPEAT GRID  -->
                    <!-- REPEAT GRID  -->
                    @include('videoright')
                     <!-- REPEAT GRID  -->
                    <div class="flex-col">
                         <div class="display-table gd-ct-wp">
                                <div class="display-cell lnnwsbg">
                                    <div class="gd-txt gd-txt-wt">
                                        <h2>
                                {{_i('Unsere Kurz-Bewertung: Börse')}} {{_i('Bern')}} {{_i('Helvetiaplatz')}} 
                                        </h2>
                                        {!!$data['featuredata']->description!!} 
                                        <a href="#rating-form" class="arwbx text animated pulse jumper">
                                           {{_i('zu den Kunden-Bewertungen')}} 
                                        </a>                                      
                                    </div>
                                </div>
                            </div>      
                    </div>
                    <!-- /REPEAT GRID  -->  
                    @include('socialicons')
                     <!-- REPEAT GRID  -->
                    <div class="flex-col gmapblk">
                         <div class="display-table gd-ct-wp">
                            <div class="display-cell">
                                <div id="map" style="height:592px;"></div>
                               <!-- <img src="{{asset('assets/img/map.jpg')}}" alt="google map" />-->
                            </div>
                        </div>    
                    </div>
                    <!-- /REPEAT GRID  -->
                </div>
                <div class="bl-strp"> 
                    <h2> {{_i('Besuchereindrücke von der Fahrradbörse Bern')}}</h2>
                </div>
                <!-- REPEAT -->
                <div class="flex-wrap gd-txt-wrp larg-sngl-outer">
                    <div class="flex-col thri-col-rw thrd-col-left">
                         <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Velo-guenstig-Bern.jpg')}}" alt="bike billig">                                
                                </div>
                            </div>  
                        </a>
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Velotest-Bern.jpg')}}" alt="bike billig">                                
                                </div>
                            </div>  
                        </a> 
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Bike-gratis.jpg')}}" alt="bike billig">                                
                                </div>
                            </div>  
                        </a> 
                    </div>
                
                    <!-- /REPEAT -->
                    <!-- REPEAT -->
                    <div class="flex-col sngl-rwcol">
                        <div class="display-table gd-ct-wp gpbx-md txt-vtop">
                            <div class="display-cell">
                                <div class="gd-txt gd-txt-para contentCustomScroller">
                                    <h4>
                                   {{_i('Velo Berne Bern: 1A-modern')}}  
                                    </h4>

                                   <p>{{_i('Auf den ersten Blick ist die Velobörse in der Mehrzweckhalle der Kaserne in Bern eine Börse wie alle anderen: Zweiräder soweit das Auge reicht, qualitativ angesiedelt zwischen Bahnhofsgöppel und qualitativ hochwertigem Rennvelo. Doch bei näherem Hinsehen fällt die rekordverdächtige Abfertigung der Kaufwilligen auf: das minutenlange Kramen im Zettelkasten gehört hier definitiv der Vergangenheit an. Stattdessen werden an den Kassen modernste technische Hilfsmittel verwendet, so dass sich kaum Schlangen bilden &ndash; was sich wiederum sehr positiv auf die Stimmung auswirkt. Der übliche Dreifachtalon wird durch einen Barcode ergänzt, der nur noch eingescannt werden muss. Das System hat')}} <a target="_blank" href="https://www.provelobern.ch/(EmptyReference!)" title="Pro Velo Bern">{{_i('Pro Velo Bern')}}</a> {{_i('zwar einiges an Arbeit gekostet, doch es lohnt sich nicht nur in Hinblick auf die rasche Abwicklung des Verkaufs oder der Auszahlung. Auch passieren so weniger Fehler (etwa dass am Schluss Fahrräder übrigbleiben, die nicht zugeordnet werden können). Mit Hilfe des Codes können Verkäufer zudem selbst')}} <a target="_blank" href="http://provelobern.ch/boerse/" title="Velo verkauft?">{{_i('online nachsehen')}}</a>, {{_i('ob ihr Bike schon verkauft ist - das Suchen in der Halle am Ende des Tages bleibt somit nur noch den Besitzern nicht verkaufter Velos aufgebürdet. Praktisch ist auch, dass an der Velobörse Bern mit Karte gezahlt werden kann. Obwohl Kartenterminals nicht billig sind, wollten die Organisatoren den Käufern die 400 Meter zum nächsten Bankomaten nicht mehr zumuten. „So versuchen wir jedes Jahr etwas zu verbessern &ndash; und sei es nur der Kaffee!')}}</p>

                                    <p><strong>{{_i('Klare Regelung für Händler')}}</strong></p>

                                    <p>{{_i('Wie bei den meisten Börsen werden auch hier schon am Abend vorher Bikes angenommen, so dass man Schlangen am Morgen vergeblich sucht und die Veloabgabe schnell über die Bühne geht. Doch beim Ausfüllen des Talons gerät manch einer ins Grübeln, und einmal mehr wird deutlich, wie schwierig es sein kann, den Preis des eigenen Velos realistisch einzuschätzen.&nbsp;Kein Wunder, denn wer nicht gerade ein alter Velobörsenhase ist, kennt sich ja auch mit dem üblichen Preisniveau nicht aus - zum Glück steht das Hilfspersonal mit Rat beiseite.')}}</p>

                                    <p>{{_i('Während an andern Orten - wie zum Beispiel')}} <a href="{{route('veloboerse-basel')}}">{{_i('Basel')}}</a> {{_i('- Händler aus weiten Teilen der Schweiz anreisen um ihren Kundenstamm zu erweitern, hat die Pro Velo Bern eine klare Richtlinie aufgestellt:&nbsp;Teilnehmen dürfen nur Händler aus dem Grossraum Bern. Dass dieser mehr oder weniger flexibel definiert ist, zeigt sich allerdings an den Anbieter-Adressen auf einigen Verkaufsquittungen - wie weit die Markleitung dies gehen lässt, war nicht zu erfahren. Klar dürfte indessen sein, dass damit die regionale Händlerschaft bis zu einem gewissen Mass geschützt werden soll, was zweifelsfrei Sinn macht. Zudem vereinfacht es für Kunden die Abwicklung von Garantiefällen, da diese auf Distanz zu einer Herausforderung werden können.')}}</p>

                                    <p>{{_i('Auffällig ist in Bern ist nicht nur, dass die Polizei überhaupt vor Ort ist, sondern auch, wie gründlich die angebotenen Velos kontrolliert werden. Sehr viele Velos werden geprüft, Rahmennummern notiert und mit der nationalen Datenbank der gestohlen gemeldeten Velos abgeglichen. So wird sichergestellt, dass die Velobörsen nicht zur Plattform für den')}} <a target="_blank" href="https://www.bernerzeitung.ch/region/bern/Veloboerse-Fuenf-von-1000-Fahrraedern-waren-gestohlen/story/21646646" title="Berner Zeitiung gestohlene Velos">{{_i('Verkauf entwendeter Fahrräder')}}</a> {{_i('werden')}}.</p>

                                    <p>{{_i('Auch in Bern erfolgt der Eintritt gestaffelt, und schon vor der offiziellen Eröffnung um 9 Uhr drängt sich Jung und Alt erwartungsvoll vor dem Absperrband.')}} <a target="_blank" href="https://www.provelobern.ch/" title="Pro&nbsp;Velo Bern">{{_i('Pro Velo')}}</a>- und <a target="_blank" href="http://www.vcs-be.ch/" title="VCS">{{_i('VCS-Mitglieder')}}</a> {{_i('sind einmal mehr im Vorteil, denn erst um 10 Uhr ist offizieller Einlass auch für Nichtmitglieder.')}}</p> 


                                    <p><strong>{{_i('Mindestens 1000 Velos')}}</strong></p>

                                    <p>{{_i('Zwischen Turnleitern und Basketballkörben stehen nun um die 1000 Velos grob sortiert zum Verkauf, durchschnittlich etwa 60% verlassen die Halle auch tatsächlich mit neuen Besitzern. Die Auswahl ist dementsprechend breit. E-Bikes gibt es jedoch praktisch kaum, auch Anhänger scheinen eher unter der Hand zu gehen. Am meisten nachgefragt werden Allerwelts-Zweiräder, halten die Veranstalter fest. Wie auch bei Simone, die am Nachmittag für 200 Franken ein grün-blaues Villiger-Occasionvelo erstanden hat: „Es war Liebe auf den ersten Blick! Ein Herr hat sich dagegen in ein Liegevelo für 580 Franken verguckt und ist auch noch nach einer Testfahrt ganz begeistert von dem doch ziemlich gewöhnungsbedürftigen Zweirad, aber leider fehlt es zuhause an Platz &ndash; ein weitverbreitetes Problem unter Veloliebhabern. Doch ansonsten leert sich die Halle bis zum Nachmittag zu einem guten Teil, und auch die Händler sind am Schluss des Tages mit dem Verkauf zufrieden - „Bern läuft immer gut.')}}</p>

                                    <p>{{_i('Angenehm sind in Bern auch die Probefahrten in der abgesperrten Zone hinter der Halle. Gemütlich radeln Kaufwillige fortlaufend im Kreis, steigen ab um etwas am Velo zu prüfen oder zwei Modelle zu vergleichen, fahren weiter. Veloliebhaber Andi meint:&nbsp;"Ich komme jedes Jahr an die Börse, selbst wenn ich mal grad kein neues Velo kaufen will - es macht einfach richtig Spass, ...".')}}</p>

                                    <p>{{_i('Auf Nachfrage nehmen die Helfer von Pro Velo gerne kleine Einstellungen vor oder geben ihre Meinung zum jeweiligen Bike. Stellen dabei etwa fest, dass die Felgen des schwarzen Bianchi-Rennvelos billig sind und lassen sich dabei auch nicht vom Händler beirren, dem es vor allem daran gelegen ist, sein Velo zu loszuwerden. Die Preisspanne für Erwachsenen-Velos liegt etwa zwischen 100 und 1000 Franken, mit einigen Ausreissern nach viel weiter oben. Wobei bei Velos im Standardbereich der Preis nicht unbedingt etwas über die Qualität aussagen muss: auch in Bern stehen Velos im Angebot - von Pro Velo-Mitgliedern gerne als Neuschrott bezeichnet -, die für 100 Franken aus China importiert und (mit weit überrissener&nbsp;Händlermarge) für 300 Franken angeboten werden, aber aus qualitativ schlechtem Material bestehen &ndash; ganz nach dem Motto „Farbe ist billig und sieht attraktiv aus. Gute Occasionen würden hier sicher bessere Dienste leisten. Die Helfer von Pro Velo raten von einem Kauf ab, aber „die Leute sind damit (leider nur vorerst) glücklich…". Gefährlich sind solche Velos allerdings oft auch, wie in unseren')}} <a href="{{route('sellbycycle')}}">{{_i('Kautipps')}}</a> {{_i('aufgezeigt wird')}}. </p>

                                    <p>{{_i('Zur Stärkung vor dem Heimweg gibt es unter anderem chilenische Empanadas. Und wer noch Bedarf nach einer neuen Klingel, einem Schloss oder einer Karte hat, deckt sich nebenan ein &ndash; sowie natürlich mit dem kostenlosem Gel für helmbedingte Frisurschäden.')}}</p>

                                    <p>{{_i('Wer sein Velo schlussendlich nicht verkaufen konnte und es trotzdem nicht mehr nach Hause nehmen möchte, hat immer noch eine Chance, es gleich vor Ort zu verschenken: Die Organisation')}} <a target="_blank" href="http://velafrica.ch/de/" title="Velafrica">{{_i('Veloafrica')}}</a> {{_i('sammelt alte Fahrräder für Afrika und nimmt es gerne entgegen.')}}</p>

                                    <p>{{_i('Kurzum: Die Velobörse in Bern ist in vielerlei Hinsicht best in class - und einen Besuch definitiv wert!')}} </p>
                                   
                                    
                                </div>
                            </div>
                        </div>                   
                    </div>
                    <!-- /REPEAT -->
                    <!-- REPEAT -->
                    <div class="flex-col thri-col-rw">
                         <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Velo-gebraucht-Bern.jpg')}}" alt="bike">                                
                                </div>
                            </div>  
                        </a>
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Veloshop-Bern.jpg')}}" alt="bike">                                
                                </div>
                            </div>  
                        </a>
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Velafrica-Bern.jpg')}}" alt="bike">                                
                                </div>
                            </div>  
                        </a>
                    </div>
                    <!-- /REPEAT -->
                    </div>
                    <div class="flex-wrap gd-txt-wrp rating-main-wrap">
                    <!-- REPEAT -->
                    <div class="flex-col">
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Veloboerse-Reithalle.jpg')}}" alt="bike billig">                                
                                </div>
                            </div>  
                        </a>                 
                    </div>
                    <!-- /REPEAT -->
                    <!-- REPEAT -->
                      <div class="flex-col ">
                            <div class="display-table gd-ct-wp txt-vtop">
                                <div class="display-cell">
                                    <div class="gd-txt gd-txt-para mrkt-rt-bx contentCustomScroller">
                                        <h4 class="mrktzurchshare">
                                            {{_i('Velobörsen Bern:Kunden-Bewertungen')}}
                                        </h4>
                                         <h4 class="mrktzurchshare">{{_i('Was gefällt Dir am Markt in Bern?')}}</h4>
                                        <p class="gd-tx-org">{{_i('Fragen & Probleme bitte mit dem')}} <a href="#Anchor-01.05.201-21731">{{_i('Veranstalter:')}}</a> {{_i('klären')}}! </p>
                                        
                                        <div class="errormsg" style="display:none;background-color:red;color:white"></div>
																					
																					<div class="successmsg" style="display:none;background-color:green;color:white"></div>
																						
																					<div class="formbx-wrp">
                                              <form class="form-horizontal" id="rating-form">
                                               {{ csrf_field() }}
                                                <input type="hidden" name="rid" value="{{$regionalpages->id }}" id="rid">
                                                 <input type="hidden" name="rating" id="result" value="3">

																								
                                            <div class="row-block">
                                                <div class="row-bx">
                                                    <div class="col-6">
                                                        <input id="name" type="text" placeholder=" {{_i('Name')}} " class="input-control" name="name" value="{{old('name')}}" />
                                                    </div>
                                                    <div class="col-6">
                                                        <input id="email" type="email" placeholder=" {{_i('Email address')}} " class="input-control" name="email" value="{{old('email')}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-block">
                                                <div class="row-bx">
                                                    <div class="col-full">
                                                        <textarea id="comment" class="input-control" name="comment">{{old('comment')}}</textarea>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="row-block">
                                                <div class="row-bx">
                                                    <div class="col-6">
                                                        <div class="rating-bx big-rating">
                                                            <input id="rating5" type="text" class="ratingEvent rating5" value="3" />
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        <input type="submit" value="Submit" class="bttn-sbmt" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ratng-bx" id="rating-repeat">
                                                <!-- REPEAT -->
                                                  @foreach($lessrating as $rating)
																										<div class="ratng-rw">
                                                    <div class="rt-ttl">
                                                        <h4>{{$rating->name}}<i>{{date("d.m.Y", strtotime($rating->created_at))}}</i></h4>
                                                        <div class="rt-img">
                                                            <div class="rating-bx small-rating">
                                                            <input readonly type="text" class="rating rating5" readonly value="{{$rating->rating}}" />
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <p>{{$rating->comment}}</p>
                                                    
                                                </div>

																							@endforeach
                                                
                                            
                                                @if(count($ratings)>4)
                                                <!-- /REPEAT -->
                                                <div class="showread">
                                                    <a id="showallrating" href="javascript:void(0);"> {{_i('See more')}} </a>
                                                </div> 
                                            @endif
                                                
                                                
                                            </div>
                                            <form>
                                        </div>
                                    </div>                              
                                </div>
                            </div>             
                    </div>
                    <!-- /REPEAT -->
                    <!-- REPEAT -->
                    <div class="flex-col">
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <img src="{{asset('assets/img/Fahrrad-verkaufen-Bern.jpg')}}" alt="bike billig">                                
                                </div>
                            </div>  
                        </a>                 
                    </div>
                    <!-- /REPEAT -->
                    
                </div> 
                 
                </div>
		
		<!-- The Modal -->
<div id="divshowallrating" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <!-- REPEAT -->
				@foreach($ratings as $rating)
					<div class="ratng-rw">
					<div class="rt-ttl">
							<h4>{{$rating->name}}<i>{{date("d.m.Y", strtotime($rating->created_at))}}</i></h4>
							<div class="rt-img">
									<div class="rating-bx small-rating">
									<input readonly type="text" class="rating rating5" readonly value="{{$rating->rating}}" />
							</div>
							</div>
					</div>
					<p>{{$rating->comment}}</p>
					
			</div>

      @endforeach
  </div>

</div>
	
		
		
	<script>
		
	$(document).ready(function() {
		//custom modal for show more rating
		var modal = document.getElementById('divshowallrating');
		var btn = document.getElementById("showallrating");
		if(btn && modal)
		{
			var span = document.getElementsByClassName("close")[0];
			btn.onclick = function() {
					modal.style.display = "block";
			}
			span.onclick = function() {
					modal.style.display = "none";
			}
			window.onclick = function(event) {
				if (event.target == modal) {
						modal.style.display = "none";
				}
			}
		}
		//ratijng form submit
    if (typeof $('#rating-form').attr('id') != 'undefined') {

     $("#rating-form").validate({
         rules: {
            name:"required",
            email: {
                required:true,
                email:true,
            },
            comment:"required",
        },
        // Specify validation error messages
        messages: {
            name: "Please enter name",
            email:{
                    required:"Please enter email",
                    emai: "Please enter valid email",
                },
            comment: "Please enter comment"
        },

    submitHandler: function(form) {
        $("#rating-form").serialize();
            $.ajax({
                type: "POST",
                url: "{{route('addregionalrating')}}",
                data : $("#rating-form").serialize(),
                success: function (data) {
								
                    if(data.status==200)
                    {
                        $('.successmsg').show().html(data.message).fadeOut(2500);
                        $("#rating-form")[0].reset();
                    
                    }
                    else if(data.status==400)
                    {
                        $('.errormsg').show().html(data.message).fadeOut(2500);
                    }
                    
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
      
        }
     });

    }

});
	</script>
              @endsection