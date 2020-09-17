@extends('layout.frontend.user.header')
@section('content')
       <div class="page-wrapper">
            <div class="container-fluid">
            	<div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">{{_i('Start Here')}}: {{_i('7 Free Steps')}}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active">{{_i('Start Here')}}</li>
                        </ol>
                    </div>
                  
                    
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-7">
                        <div id="accordion" role="tablist">
                            <div class="card cardblkovt">
                        	@foreach($data['records'] as $row)
                            @if(@$row->is_viewed || @$row->id == 1)
                            <?php $next_video_id = $row->id; ?>
                            
                                <div class="card-header view hm-white" role="tab" id="heading<?php echo ucwords($number_formatter->format($row->id));?>">
                                    <div class="mb-0">

                                        <a style="width:100%" data-toggle="collapse" href="#collapse<?php echo ucwords($number_formatter->format($row->id));?>" role="button" aria-expanded="false" aria-controls="collapse<?php echo ucwords($number_formatter->format($row->id));?>">

                                            <div class="carteGauche">
                                                <i class="mdi mdi-camcorder" aria-hidden="true"></i>
                                                <h3 class="card-title">
                                                <?php 
                                                if($current_language == 'fr'){
                                                	echo $row->title_fr;
                                                }else{
                                                	echo $row->title_en;
                                                }

                                                ?></h3>
                                                <p class="card-subtitle-ovt">
                                                     <?php 
                                                if($current_language == 'fr'){
                                                	echo $row->short_description_fr;
                                                }else{
                                                	echo $row->short_description_fr;
                                                }?>
                                                </p>
                                            </div>
                                            <i class="fa fa-angle-right" style="float:right" aria-hidden="true"></i>
                                        </a>

                                    </div>
                                </div>

                                <div id="collapse<?php echo ucwords($number_formatter->format($row->id));?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php echo ucwords($number_formatter->format($row->id));?>" data-parent="#accordion">
                                    <div class="card-block">
                                        <div class="col-12">
                                            <div class="embed-responsive embed-responsive-16by9">

                                                <?php 
                                                if($current_language == 'fr'){
                                                    echo $row->embeded_video_url_fr;
                                                }else{
                                                    echo $row->embeded_video_url_en;
                                                }

                                                ?>
                                            </div>
                                        </div>
                                        <div>
                                            <hr class="m-t-0 m-b-0">
                                            <div>
                                                <div class="card-block">
                                                    <ul class="list-inline m-b-0">
                                                        <li>
                                                       <?php 
		                                                if($current_language == 'fr'){
		                                                	echo $row->long_description_fr;
		                                                }else{
		                                                	echo $row->long_description_en;
		                                                }?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                             
                                </div>

                                <div>
                                    <hr class="m-t-0 m-b-0">
                                </div>
                                
                               
                           
                            @endif
                            @endforeach
                             </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-4 col-md-5">
                         @if(@!$last_video)
                        <div class="card">
                            <div class="card-block">
                                <h3 class="card-title">{{_i('Next Video')}}</h3>
                                <h6 class="card-subtitle">
                                    <?php 

                                    if($current_language == 'fr'){
                                        echo $next_video->title_fr;
                                    }else{
                                        echo $next_video->title_en;
                                    }
                                    ?>
                                        
                                    </h6>

                            </div>
                            <div>
                                <hr class="m-t-0 m-b-0">
                            </div>
                            <div class="card-block text-center ">
                                <ul class="list-inline m-b-0">
                                    <li>
                                        <h6 class="text-muted text-info"><a href="{{route('user-unlock-next-video',['id'=>$next_video->id])}}"><i class="mdi mdi-play font-14 m-r-8 "></i>{{_i('Unlock Next Video')}}</a></h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
       </div>

   
   @endsection

