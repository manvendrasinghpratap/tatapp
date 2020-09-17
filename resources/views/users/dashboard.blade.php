 @extends('layout.frontend.user.header')
@section('content')
       <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Bonjour <span id="prenomBonjour"></span></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-block">
                                <h2 class="card-title">
                                    <?php 
                                
                                //$current_language = \Lang::getLocale();
                                   
                                if($curr_lang == 'fr'){
                                    echo $content->video_title_fr;
                                }else{
                                    echo $content->video_title_en;
                                }
                                ?>
                                </h2>
                                <div class="embed-responsive embed-responsive-16by9">

                                <?php 
                                if($curr_lang == 'fr'){
                                    echo $content->video_url_fr;
                                }else{
                                    echo $content->video_url_en;
                                }
                                ?>
                                </div>
                                <ul class="list-inline m-b-0">
                                <?php 
                                if($curr_lang == 'fr'){
                                    echo $content->description_fr;
                                }else{
                                    echo $content->description_en;
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <img class="card-img-top" src="{{asset('assets/images/background')}}/<?php echo(mt_rand(1,5)); ?>.png"  alt="Card image cap">
                            <div class="card-block little-profile text-center">
                                <div class="pro-img"><img src="{{asset('assets/images/users/profil.png')}}"  alt="user" /></div>
                                <h3 class="m-b-0" id="prenom"></h3>
                                <hr>
                                <p>
                                {{_i('Summary of your results')}}</p>
                                <div class="row text-center m-t-0">
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h3 class="m-b-0 font-light">{{$my_leads}}</h3><small>{{_i('Leads')}}</small></div>
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h3 class="m-b-0 font-light">{{$my_registrations}}</h3><small>{{_i('Registrations')}}</small></div>
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h3 class="m-b-0 font-light">{{$my_members}}</h3><small>{{_i('Members')}}</small></div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
            </div>
        </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
   @endsection