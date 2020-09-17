 @extends('layout.frontend.user.header') @section('content')
<script>
    top.window.opener.location ="{{route('authenticate_user')}}";
    // if you want to close the window
     window.close();
</script>

<div class="page-wrapper profile">
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">{{_i('Get Paid')}}</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">{{_i('Home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{_i('Get Paid')}}
                    </li>
                </ol>
            </div>
             <?php if(Session::has('add_message')){ ?>
                 <div class="col-md-5 col-8 align-self-center">
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        {!! session('add_message') !!}
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
            <!-- Column -->
            <div class="col-lg-6 col-xlg-6 col-md-7">
                <div class="card">
                    <div class="card-block">
                    <div class="">
                        <h3 class="card-title">{{_i('Paypal Account')}}</h3>
                        <div class="">
                         <?php if(empty($current_paypal_detail)){?>
                         <span>{{_i('Paypal account is not linked yet. Please Link')}}</span>
                          <span id='lippButton'></span>
                            <script src='https://www.paypalobjects.com/js/external/api.js'></script>
                            <script>
                            paypal.use( ['login'], function (login) {
                              login.render ({
                                "appid":"<?php echo $paypal_app_id;?>",
                                "authend":"sandbox",
                                "scopes":"openid profile email",
                                "containerid":"lippButton",
                                "locale":"en-us",
                                "returnurl":"<?php echo $redirect_url;?>"
                              });
                            });
                            </script>
                           <?php }else{?>
                           <div class="">
			                    <div class="">
			                       <label>
			                       {{_i('Paypal user id:')}}
			                       </label>
			                     <p class="useer-id">  <?php echo $current_paypal_detail->paypal_user_id; ?></p>

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

            <div class="col-lg-6 col-xlg-6 col-md-7">
                <div class="card">
                   <div class="card-block">
                        <h3 class="card-title">{{_i('Stripe Account')}}</h3>
                         <?php if(empty($current_stripe_detail)){?>
                         <span>{{_i('Stripe account is not linked yet. Please Link')}}</span>

                         <?php $url = 'https://connect.stripe.com/oauth/authorize?response_type=code&client_id='.$stripe_client_secret_key.'&scope=read_write';?>
                           <a href="<?php echo $url;?>" class="btn btn-default proceed">{{_i('Connect Stripe')}}</a>
                           <?php }else{?>
                           <div class="">
			                    <div class="">
			                       <label>
			                       {{_i('Stripe user id:')}}
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
@endsection