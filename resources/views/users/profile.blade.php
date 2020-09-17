 @extends('layout.frontend.user.header') @section('content')
<script>
    top.window.opener.location = "{{route('profile')}}";
    // if you want to close the window
    window.close();
</script>
<style>
    .input-wrapped.full .card {
        margin-bottom: 0 !important;
        border: none;
    }
    
    .input-icon i {
        top: 15px;
        position: absolute;
    }
</style>
<div class="page-wrapper profile">
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">{{_i('Profile')}}</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('dashboard')}}">{{_i('Home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{_i('Profile')}}
                    </li>
                </ol>
            </div>
            <?php if(Session::has('add_message')){ ?>
                <div class="col-md-5 col-8 align-self-center">
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a> {!! session('add_message') !!}
                    </div>
                </div>
                <?php }?>
                
                <?php if(Session::has('error_message')){ ?>
                <div class="col-md-5 col-8 align-self-center">
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a> {!! session('error_message') !!}
                    </div>
                </div>
                <?php }?>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <img class="card-img-top" src="{{asset('assets/images/background')}}/<?php echo(mt_rand(1,5)); ?>.png" alt="Card image cap">
                    <div class="card-block little-profile text-center">
                        <div class="pro-img"><img src="{{asset('assets/images/users/profil.png')}}" alt="user" />
                        </div>
                        <h3 class="m-b-0" id="prenomCarte">{{{ Auth::user()->first_name}}}</h3>
                        <hr>
                        <p>
                            {{_i('Summary of your results')}}
                        </p>
                        <div class="row text-center m-t-0">
                            <div class="col-lg-4 col-md-4 m-t-20">
                                <h3 class="m-b-0 font-light">{{$my_leads}}</h3><small>{{_i('Leads')}}</small>
                            </div>
                            <div class="col-lg-4 col-md-4 m-t-20">
                                <h3 class="m-b-0 font-light">{{$my_registrations}}</h3><small>{{_i('Registrations')}}</small>
                            </div>
                            <div class="col-lg-4 col-md-4 m-t-20">
                                <h3 class="m-b-0 font-light">{{$my_members}}</h3><small>{{_i('Members')}}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(Auth::user()->is_free_member == '0'){ ?>
                    <div class="card">
                        <div class="card-block">
                            <h3 class="card-title">{{_i('Your Plan')}}</h3>
                            <div class="row">
                                <?php if(!empty($current_plan)){ ?>
                                    <div class="col-sm-12 text-center">
                                        <img class="img-responsive radius forfait-image" src="{{get_image_url(@$current_plan->plan_image,'package')}}" alt="" />
                                        <p>
                                            <strong> <?php 
                                                if($current_language == 'fr'){
                                                    echo $current_plan->plan_name_fr;
                                                }else{
                                                    echo $current_plan->plan_name_en;
                                                }

                                        ?></strong>
                                        </p>
                                        <p>
                                            {{$current_plan->price}} $ /mois
                                        </p>
                                        <?php 
                                        if($current_language == 'fr'){
                                            echo $current_plan->description_fr;
                                        }else{
                                            echo $current_plan->description_fr;
                                        }
                                        ?>
                                            <a href="{{route('packages')}}" class="btn btn-success">{{_i('Change The Plan')}}</a>
                                            <?php if(!empty($plan_payment)){ ?>
                                                <a href="{{route('cancel-refund-plan')}}" style="margin-top: 6px;" class="btn btn-success">{{_i('Cancel and Refund')}}</a>
                                                <?php }else{?>
                                                    <a href="{{route('cancel-plan')}}" class="btn btn-success">{{_i('Cancel Plan')}}</a>
                                                    <?php }?>
                                    </div>
                                    <?php }else{?>
                                        <div class="col-sm-12 text-center">
                                            {{_i('No Plan Purchased')}}.
                                        </div>
                                        <?php }?>
                            </div>
                        </div>
                        <?php if(@$refund == 1  && empty($current_plan)){?>
                            <div class="card-block">
                                <h3 class="card-title">{{_i('Starter Plan')}}</h3>

                                <a href="javascript:void(0)" data-toggle="modal" data-target="#refundModal" class="btn btn-success">
                            {{_i('Refund')}}
                                </a>
                                <!-- Modal -->
                                <div class="modal" id="refundModal" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header"><span>Are you sure?</span>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{_i('Are you sure you to refund this amount ?. Your account wiil be deactivated once you proceed.')}}</p>
                                                <a href="{{route('refund')}}" class="btn btn-default proceed">{{_i('Proceed')}}</a>
                                                <div class="clearfix"></div>
                                            </div>
                                            <!-- <div class="modal-footer">

                                          <button type="button" class="btn btn-default" data-dismiss="modal">{{_i('Close')}}</button>
                                        </div> -->
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <?php }?>

                    </div>

                    <?php }?>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <div class="card-block">
                        <form class="form-horizontal form-material" id="updateprofile" method="post" action="{{route('update_user')}}">
                            <div class="form-group">
                                <label class="col-md-12">{{_i('First Name')}}</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="{{_i('First Name')}}" id="first_name" name="first_name" value="{{Auth::user()->first_name}}" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">{{_i('Last Name')}}</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="{{_i('Last Name')}}" id="last_name" class="form-control form-control-line" value="{{Auth::user()->last_name}}" name="last_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="courriel" class="col-md-12">{{_i('Email Address')}}</label>
                                <div class="col-md-12">
                                    <input type="email" name="emailid" placeholder="adresse@courriel.com" class="form-control form-control-line" readonly value="{{Auth::user()->email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">{{_i('Password')}}</label>
                                <div class="col-md-12">
                                    <input type="password" placeholder="********" class="form-control form-control-line" name="mdp" id="mdp">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">{{_i('Confirm Password')}}</label>
                                <div class="col-md-12">
                                    <input type="password" placeholder="********" class="form-control form-control-line" name="mdpverif" id="confmdp">
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="" id="btnProfil">
                                        <button type="submit" class="btn btn-success" id="submit">
                                            {{_i('Update')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">{{_i('Your Sponsor')}}</h3>
                        <form class="form-horizontal form-material">
                            <div class="form-group">
                                <?php if(!empty($my_sponser)){ ?>
                                    <div class="col-md-12">
                                        </i>
                                        <p>
                                            <i class="mdi mdi-account" aria-hidden="true"> </i> {{$my_sponser->first_name}} {{$my_sponser->last_name}}
                                        </p>
                                        <p>
                                            <i class="mdi mdi-email" aria-hidden="true"> </i> {{$my_sponser->email}}
                                        </p>
                                    </div>
                                    <?php }else{?>
                                        <div class="col-md-12">
                                            </i>
                                            <p>
                                                <i class="mdi mdi-account" aria-hidden="true"> </i> Self
                                            </p>
                                        </div>
                                        <?php }?>
                            </div>
                            <hr>
                            <h3 class="card-title">{{_i('Affiliate Links')}}</h3>
                            <div class="form-group">
                                <label class="col-md-12">{{_i('Your Affiliate Link')}}</label>
                                <div class="col-md-12">
                                    <input id="inLienComp" type="text" readonly value="{{$my_refere_link}}" class="form-control form-control-line">
                                    <a href="javascript:void(0)" id="copy-button" class="btn btn-info">
                                        {{_i('Copy')}}
                                    </a>
                                </div>

                            </div>
                            <!-- 
                            <div class="form-group">
                                <label class="col-md-12">Votre lien à publiciser</label>
                                <div class="col-md-12">
                                    <input type="text" id="inLienDK" placeholder="monlien.digitalkheops.com" class="form-control form-control-line">
                                </div>
                            </div> -->
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">{{_i('Get Paid')}}</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card shade0">
                                    <div class="card-block">
                                        <div class="">
                                            <h3 class="card-title">{{_i('Paypal Account')}}</h3>
                                            <div class="">
                                                <?php if(empty($current_paypal_detail)){?>
                                                    <span>{{_i('Your account is not linked yet. Click the following button to link your Paypal account.')}}</span>
                                                    <span id='lippButton' style="float:right;"></span>

                                                    <?php }else{?>
                                                        <div class="">
                                                            <div class="">
                                                                <label>
                                                                    {{_i('Paypal user id:')}}
                                                                </label>
                                                                <p class="useer-id">
                                                                    <?php echo $current_paypal_detail->paypal_user_id; ?>
                                                                </p>

                                                                <label>
                                                                    {{_i('Paypal Id:')}}
                                                                </label>
                                                                <?php echo $current_paypal_detail->paypal_id; ?>
                                                                    <div class="clearfix"></div>
                                                                    <a href="{{route('delete-paypal-account')}}" class="btn btn-default proceed">{{_i('Delete Account')}}</a>
                                                            </div>
                                                        </div>
                                                        <?php }?>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-sm-6">
                                <div class="card shade0">
                                    <div class="card-block">
                                        <h3 class="card-title"> {{_i('Stripe Account')}}</h3>
                                        <?php if(empty($current_stripe_detail)){?>
                                            <span>{{_i('Your account is not linked yet. Click the following button to link your Stripe account.')}}</span>

                                            <?php $url = 'https://connect.stripe.com/oauth/authorize?response_type=code&client_id='.$stripe_client_secret_key.'&scope=read_write';?>
                                                <a href="<?php echo $url;?>" class="btn btn-default proceed">{{_i('Connect Stripe')}}</a>
                                                <?php }else{?>
                                                    <div class="">
                                                        <div class="">
                                                            <label>
                                                                {{_i('Stripe payer id:')}}
                                                            </label>
                                                            <?php echo $current_stripe_detail->stripe_user_id; ?>

                                                                <a href="{{route('delete-stripe-account')}}" class="btn btn-default proceed">{{_i('Delete Account')}}</a>
                                                        </div>
                                                    </div>
                                                    <?php }?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">{{_i('Commision')}}</h3>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card shade0">
                                    <div class="card-block">
                                        <div class="">
                                            <div class="">
                                                <div class="row text-center m-t-0">
                                                    <div class="col-lg-6 col-md-6 m-t-20">
                                                        <h3 class="m-b-0 font-light">$<?php echo round($user_commision,2) ?></h3><small>{{_i('Total Commision in this month')}}</small>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 m-t-20">
                                                        <h3 class="m-b-0 font-light">{{$next_billing_date}}</h3><small>{{_i('Payout Date')}}</small>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->

                        </div>
                    </div>
                </div>

                <?php if(!empty($current_payment_details)){ ?>
                    <div class="card">
                        <div class="card-block">
                            <h3 class="card-title">{{_i('Update Credit Card')}}</h3>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card shade0">
                                        <div class="card-block">
                                            <div class="">
                                                <div class="">
                                                    <div class="">
                                                        <div class="">
                                                            <div class="clearfix"></div>
                                                            <?php if($current_payment_details->transaction_type == '1'){//paypal update ?>
                                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#updateCardPaypal" class="btn btn-info">{{_i('Update Card Detail')}}</a>
                                                                <div class="modal" id="updateCardPaypal" role="dialog">
                                                                    <form id="paypal-update" action="{{route('paypal-card-update')}}" method="post">
                                                                        <div class="modal-dialog">
                                                                            <!-- Modal content-->
                                                                            <div class="modal-content">
                                                                                <div class="modal-header"><span>{{_i('Update Card Detail')}}</span>
                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p>{{_i('Update Card Detail')}}</p>
                                                                                    <div class="input-wrapped full" id="validateCard">
                                                                                        <div class="input-wrapped full" id="validateCard">
                                                                                            <input type="text" size="20" name="cardNumber" maxlength="16" id="cardnumber" class="form-control" placeholder="{{_i('Card Number')}}" data-creditcard="true" value="{{ old('cardNumber') }}">
                                                                                            <i class="icon-ok"></i>
                                                                                            <!-- <i class="icon-ok"></i> -->
                                                                                            <!-- <span class="icon-ok"></span> -->
                                                                                        </div>
                                                                                        <div class="col-half">
                                                                                            <div class="input-group input-group-icon">
                                                                                                <input type="text" name="CVV2" id="CVV2" value="" placeholder="CVV" class="form-control" value="{{ old('CVV2') }}" required/>
                                                                                                <div class="input-icon"><i class="fa fa-user"></i></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-half">
                                                                                            <div class="input-group">
                                                                                                <select id="month" name="month" value="{{ old('month') }}">
                                                                                                    <option value="01">1</option>
                                                                                                    <option value="02">2</option>
                                                                                                    <option value="03">3</option>
                                                                                                    <option value="04">4</option>
                                                                                                    <option value="05">5</option>
                                                                                                    <option value="06">6</option>
                                                                                                    <option value="07">7</option>
                                                                                                    <option value="08">8</option>
                                                                                                    <option value="10">9</option>
                                                                                                    <option value="11">11</option>
                                                                                                    <option value="12">12</option>
                                                                                                </select>
                                                                                                <select id="year" name="year" value="{{ old('year') }}">
                                                                                                    <?php
                                                                                                for ($i=date("Y"); $i < 2100 ; $i++) { ?>
                                                                                                        <option value="<?php echo $i;?>">
                                                                                                            <?php echo $i;?>
                                                                                                        </option>
                                                                                                        <?php } ?>
                                                                                                </select>

                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="input-group input-group-icon">
                                                                                            <input type="text" name="BILLTOFIRSTNAME" id="BILLTOFIRSTNAME" placeholder="{{_i('First Name')}}" value="{{ old('BILLTOFIRSTNAME') }}" />
                                                                                            <div class="input-icon"><i class="fa fa-user"></i></div>
                                                                                        </div>
                                                                                        <div class="input-group input-group-icon">
                                                                                            <input type="text" name="BILLTOLASTNAME" id="BILLTOLASTNAME" placeholder="{{_i('Last Name')}}" value="{{ old('BILLTOLASTNAME') }}" />
                                                                                            <div class="input-icon"><i class="fa fa-user"></i></div>
                                                                                        </div>
                                                                                        {{ csrf_field() }}
                                                                                        <button type="submit" class="btn btn-default proceed" id="update-card-detail">{{_i('Update Card')}}</button>
                                                                                        <div class="clearfix"></div>
                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                    </form>
                                                                    </div>
                                                                    <?php }?>

                                                                        <?php if($current_payment_details->transaction_type == '2'){// stripe update ?>
                                                                            <form action="{{route('stripe-card-update')}}" method="POST">
                                                                                {{ csrf_field() }}
                                                                                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="<?php echo $stripe_publishable_key;?>" data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-name="Digital Kheops" data-panel-label="Update Card Details" data-label="{{_i('Update Card Detail')}}" data-allow-remember-me=false data-locale="auto" data-email="<?php echo Auth::user()->email; ?>">
                                                                                </script>
                                                                            </form>
                                                                            <?php }?>
                                                                </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <!-- Column -->
                                </div>
                            </div>
                        </div>
                        <?php }?>
                            <!-- Column -->
                            <div class="clearfix"></div>

                            <!-- Column -->
                            <div class="col-sm-8 col-sm-offset-4">
                            </div>
                    </div>

            </div>
            <!-- Row -->
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src='https://www.paypalobjects.com/js/external/api.js'></script>
    <script>
        // self executing function here
        (function() {

            paypal.use(['login'], function(login) {
                login.render({
                    "appid": "<?php echo $paypal_app_id;?>",
                    "authend": "sandbox",
                    "scopes": "openid profile email",
                    "containerid": "lippButton",
                    "locale": "en-us",
                    "returnurl": "<?php echo $redirect_url;?>"
                });
            });

        })();
    </script>
    @endsection