  @extends('layout.frontend.user.header')
@section('content')
<div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 col-8 align-self-center">
                    <h3 class="text-themecolor m-b-0 m-t-0">{{_i('Packages')}}</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">{{_i('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{_i('Packages')}}
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <h1 class="card-title text-center">{{_i('Packages')}}</h1>
                            <h6 class="card-subtitle text-center"> 
                                <?php 
                                    
                                    $note =  '';
                                     foreach($data['records'] as $row){
                                     
                                     if($current_language == 'fr'){
                                            $note = $row->note_fr;
                                        }else{
                                            $note = $row->note;
                                        }

                                     }
                                     echo $note;
                                     
                                      
                                ?>
                                            
                             </h6>
                            <div class="row text-center">
                            <div class="col-sm-8 col-sm-offset-2">
                                <?php $plan_price = 0; ?>
                             @foreach($data['records'] as $row)
                                <div class="col-md-6">
                                    <img class="img-responsive radius forfait-image" src="{{get_image_url(@$row->plan_image,'package')}}" alt="" />
                                    <p>
                                        <strong>
                                         <?php 
                                                if($current_language == 'fr'){
                                                    echo $row->plan_name_fr;
                                                }else{
                                                    echo $row->plan_name_en;
                                                }

                                        ?>
                                                    
                                        </strong>
                                    </p>

                                    <?php 
                                                if($current_language == 'fr'){
                                                    echo $row->description_fr;
                                                }else{
                                                    echo $row->description_fr;
                                                }

                                                $id = base64_encode($row->id);

                                        ?>

                                        <?php if($current_plan_id == 0){?>
                                            <div class="row text-center">
                                                
                                                <a href="{{route('payment',$id)}}" class="btn btn-info" >
                                                    {{_i('Subscribe')}}
                                                </a>
                                            </div>
                                        <?php }else{?>
                                        <?php if($current_plan_id != $row->id ){

                                            $plan_price = $row->price;
                                            $plan_id  = base64_encode($row->id);?>
                                            <div class="row text-center">
                                            
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#changePlan" class="btn btn-info" >
                                                {{_i('Subscribe')}}
                                            </a>
                                        </div>
                                        <br> 
                                        <?php }else{?>
                                        <div class="row text-center">
                                                {{_i('Your Plan')}}
                                           
                                        </div>
                                        <?php }}?>
                                          <!-- Modal -->



                                    </div>
                             @endforeach
                            </div>
                             <div class="modal" id="changePlan" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header"><span>{{_i('Please Confirm')}}</span>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{_i('Are you sure you to change your package')}} ?</p>
                                            <p>{{_i('Plan Price')}} : $<?php echo $plan_price; ?> </p>
                                            <a href="{{route('change_plan',@$plan_id)}}" class="btn btn-default proceed">{{_i('Proceed')}}</a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <!-- <div class="modal-footer">

                                      <button type="button" class="btn btn-default" data-dismiss="modal">{{_i('Close')}}</button>
                                    </div> -->
                                    </div>

                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 </div>
 @endsection