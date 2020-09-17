<!DOCTYPE html>
<html> 
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Threat Assessment Tool: Admin Panel</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <!-- <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}"> -->
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.css')}}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
                     <link rel="stylesheet" href="{{asset('css/custom.css')}}">
        <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.css')}}">
        <!-- Admin CSS-->
      
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

        <!-- iCheck -->
        <!--<link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">-->
        <!-- Morris chart -->
        <!--<link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">-->
        <!-- jvectormap -->
        <!--<link rel="stylesheet" href="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">-->
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
         <link rel="stylesheet" href="{{asset('assets/css/market-form.css')}}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
       
        <!-- bootstrap wysihtml5 - text editor -->
        <!--<link rel="stylesheet" href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">-->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->


        <!-- jQuery 2.2.3 -->
        <script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
 <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
 <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
 
 <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
 
        
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
            <!--<script src="{{asset('assets/js/select2.min.js')}}"></script>-->
        
        <script>
            // Wait for window load
            $(window).load(function() {
                // Animate loader off screen

                $(".se-pre-con").fadeOut("slow");

            });
        </script>
       
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="se-pre-con"></div>
        <div class="wrapper">


           
            <header class="main-header">
                <!-- Logo -->

               <!--  <a href="http://localhost/tatapp/public/admin/dashboard" class="logo">
                    <span class="logo-mini"> {{ ucfirst(session('email')) }}</span>
                    <span class="logo-lg"></span>
                </a> -->

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <span class="logo-mini dv-logo-mini"> 
                        {{ ucfirst(session('name')) }}
                        <?php 
                        $account_membership_type = Session::get('account_membership_type');
                        $account_membership_display_name =  getMembershipPlanTitle($account_membership_type); ?>
                       <!--  {{ ucfirst(session('account_name')) }} (<?php //echo $account_membership_display_name; ?>) -->

                        
                    </span>
                    <span class="dv-addrss-hd"><!-- {{ session('account_email') }} -->
                        
                       Role: {{ session('user_role_display_name') }} 
                    </span>
                    
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="{{route('admin-dashboard')}}" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{asset('images/user-image.jpg')}}" class="user-image" alt="admin image"/>
                                      <!--  <span class="hidden-xs">Welcome ! {{ ucfirst(@session('name')) }}</span> -->
                                </a>
                                <ul class="dropdown-menu dropdown" id="dropdown">
                                    <!-- User image -->
                                    <li class="user-header">                                       
                                        <p>
                                            <span style="font-size: 12px;">Account Name: {{ ucfirst(session('account_name')) }}</span><br>
                                            <span style="font-size: 12px;">Plan: <?php echo $account_membership_display_name; ?></span><br>
                                            <!-- <span> {{ ucfirst(session('name')) }}</span><br>
                                            <span style="font-size: 12px;">Role: {{ session('user_role_display_name') }}</span><br> -->
                                              <span style="font-size: 12px;">{{ session('email') }}</span>
                                        </p>
                                    </li>

                                    <!-- Menu Footer-->
                                    <li class="user-footer">

                                        <div class="pull-left">
                                        
                                          <a href="{{route('admin-changepassword')}}" class="btn btn-default btn-flat">Change Password</a>
                                           <a href="{{route('admin-logout')}}" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                        
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </nav>
            </header>    



            @extends('layout.backened.left')

            @yield('content')

            @extends('layout.backened.footer')
