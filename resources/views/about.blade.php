@extends('layout.frontend.header')
@section('content')
 <section>
                <div class="flex-wrap gd-txt-wrp">
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                        <a href="javascript:void(0);">
                            <div class="display-table gd-ct-wp">
                                <div class="display-cell">
                                    <div class="gd-txt gd-big-hdd-txt">
                                        <h2>{{_i('We love cycles')}} <br>{{_i('we live cycling')}}</h2>
                                        <h2>{{_i('Velosophy is the future.')}}</h2>
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
                                    <img src="{{asset('assets/img/velostaedte-zukunft.jpg')}}" alt="bike exchange" />                                
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
                                    <div class="gd-txt gd-txt-grn gd-big-hdd-txt">
                                        <h2>
                                          {{_i('Copenhagenize:')}} <br /> {{_i('Velos überall.')}} 
                                        </h2>
                                        <h2>
                                           {{_i('Re-Cyclize:')}}  <br /> {{_i('Velos forever.')}} 
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
                                    <img src="{{asset('assets/img/Copenhagenize.jpg')}}" alt="test bike" />
                                </div>
                            </div>     
                        </a>              
                    </div>
                    <!-- /REPEAT GRID  -->
                    <!-- REPEAT GRID  -->
                    <div class="flex-col">
                        <div class="display-table gd-ct-wp txt-vtop">
                            <div class="display-cell">
                                <div class="gd-txt gd-txt-h1 gd-txt-para mCustomScrollbar cstmscrlgp">
                                <div class="txthldgdp">
                                    <h4>
                                      {{_i('Der Gedanke hinter veloboersen.ch')}}  
                                    </h4>
                                    <p>
                                    @if(isset($localelang) && $localelang=='de-CH')

                                        {!!$pcontant[0]->description_ch!!}

                                    @elseif(isset($localelang) && $localelang=='fr-CH')

                                        {!!$pcontant[0]->description_fr!!}

                                    @else

                                        {!!$pcontant[0]->description!!}

                                    @endif
                                    </p>
                                  </div>
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
                                    <img src="{{asset('assets/img/Cargobikes.jpg')}}" alt="cycle exchange"  >
                                </div>
                            </div>  
                        </a>                 
                    </div>
                    <!-- /REPEAT GRID  -->                    
                </div>
                
                <div class="row-block abt-blk">
                    <div class="row-bx">
                        <div class="col-1 display-cell"> 
                            <p>{{_i('Impressum')}}</p>
                        </div>
                        <div class="col-3 display-cell"> 
                            <p>{{_i('Diese Website wurde erstellt und wird')}}</br>{{_i('betreut von')}}  <a target="_blank" href="http://www.velomaerkte.ch" title="Velomaerkte.ch">velomaerkte.ch</a></p><p>info [at] velomaerkte.ch </p>
                        </div>
                        <div class="col-2 display-cell"> 
                            <p>velomaerkte.ch Bafüsserplatz CH-4051 Basel</p>
                        </div>
                        <div class="col-2 display-cell"> 
                            <p>velomaerkte.ch Bleicherweg 52 CH-8002 Zurich</p>
                        </div>
                        <div class="col-5 display-cell">
                            <p>{{_i('velomaerkte.ch ist ein Projekt von Wide World Designs LLC , Freie Strasse 88, CH-4051 Basel. HR-Nr: CHE-112.985.060.')}} 
<a href="http://www.ww-d.ch/"></br>© wwd 2017</a> - <a href="{!! url('/pages/disclaimer') !!}">{{_i('Disclaimer')}}</a></p>
                        </div>
                    </div>
                </div>
                
        </section>
 @endsection