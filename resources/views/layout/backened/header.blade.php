<!DOCTYPE html>
<html> 
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Threat Assessment Tool: Admin Panel</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="{{asset('css_new/selectric.css')}}">
		 <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
	
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
		
		<link rel="stylesheet" href="{{asset('css_new/style.css')}}">
		<link rel="stylesheet" href="{{asset('css_new/custom.css')}}">
		<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">
		 <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
		<link rel="stylesheet" href="{{asset('/plugins/timepicker/bootstrap-datetimepicker.min.css')}}">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<script type="text/javascript" src="{{asset('bootstrap/js/tether.min.js')}}"></script>	
		<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script> 
		<script src="{{asset('/plugins/timepicker/bootstrap-datetimepicker.js')}}"></script>
    	<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
		<link rel="stylesheet" href="{{asset('css_new/sidebar.css')}}">
		<!-- END Custom CSS-->
		<style type="text/css">.whitecolor{color:#fff;} .pointer{ cursor: pointer; } .innerdropdownul{ background-color: #31B0D5; } .innerdropdownul li{ padding-left: 50px; }
	.fa-passwd-reset > .fa-lock {
		font-size: 0.85rem;
	}
	.fa-stack {
		display: inline-block;
		height: 1em;
		line-height: 0.9em;
		position: relative;
		vertical-align: middle;
		width: 1em;
	}
		</style>
		<style>
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 12px 16px;
  z-index: 1;
}

.dropdown:hover .dropdown-content {
  display: block;
}
.styled select {
   background: transparent;
   width: 150px;
   font-size: 16px;
   border: 1px solid #ccc;
   height: 34px;
   padding-left: 24px;
    color: black; 
} 

.styled{
   margin-top: 7px;
   width: 120px;
   height: 34px;
   border: 1px solid #111;
   border-radius: 3px;
   overflow: hidden;
   background-color: #ddd;
}
</style>
<style>
.dropbtn {

    color: white;
    padding: 12px 0px 10px 1px;
    font-size: 14px;
    border: none;
    width: 27px;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: fixed;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: inherit;}
.dropbtn:hover, .dropbtn:focus {
    background-color: transparent !important;
}
.dropdown-content a {padding: 7px 11px !important;}
.user-name{color: #5bc0de;}
</style>
		</head>
    <body class="hold-transition skin-blue sidebar-mini">
		<?php
		$user_role_name = session('user_role_name');
		$getAccessListArray = getAccessList($user_role_name);
		$account_membership_type = Session::get('account_membership_type');
		$account_membership_display_name =  getMembershipPlanTitle($account_membership_type); 
		$spaceUsed =  getSpaceUsed(35); 
		?>
		<?php 
		$user_role_name = session('user_role_name');
		$getAccessListArray = getAccessList($user_role_name);
		$account_membership_type = Session::get('account_membership_type');

		$account_membership_display_name =  getMembershipPlanTitle($account_membership_type); 
		$spaceUsed =  getSpaceUsed(35); 
		?>
	<div class="page-wrapper chiller-theme toggled">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="javascript:void(0);">
                <i class="fas fa-bars"></i>
            </a>
	       <nav id="sidebar" class="sidebar-wrapper">
		<div class="sidebar-content">
			    <div class="sidebar-brand">
					<a href="{{url('/')}}" style="font-size: 11px;">Threat Assessment Dashboard</a>
					<div id="close-sidebar">
					  <i class="fas fa-times"></i>
					</div>
			    </div>
				<?php $profile_pic = 'images/default_user.jpg'; if(!empty(session('profile_pic')) ){
				 $profile_pic = 'uploads/user/'.session('profile_pic');
				}?>
					
				<div class="sidebar-header">
					<div class="user-pic">
						<img class="img-responsive img-rounded" src = "{{asset($profile_pic)}}"   alt="User picture">
					</div>
					<div class="user-info">	
						<div class="dropdown">
							<a class="dropbtn" href="#"><span title = "{{ ucfirst(session('name')) }}" class="user-name">{{ substr(ucfirst(session('name')),0 ,21) }}</span></a>
							<div class="dropdown-content">
								<a href="{{route('admin-profile')}}">Profile</a>
								<a href="{{route('admin-users')}}">Team</a>
								<a href="{{route('admin-groups')}}">Groups</a>
								<a href="{{ url('admin/resourcesList')}}">Resources</a>
								<a href="{{route('admin-changepassword')}}">Change Password</a>
								<a href="{{route('admin-logout')}}">Logout</a>
							</div>
						</div>
						<span class="user-status">
							<i class="fa fa-circle"></i>	
							<span>Online</span>
						</span>	
					</div>
				</div>
			  <!-- sidebar-header  -->
			  <div class="sidebar-menu">
					<ul>
					@if( !empty(Request::segment(3)) && (Route::currentRouteName()=='admin-viewCase') || (Route::currentRouteName()=='admin-add-subject') || (Route::currentRouteName()=='admin-getDescription') || (Route::currentRouteName()=='admin-getTargetDetail') || (Route::currentRouteName()=='admin-getFileDetail') || (Route::currentRouteName()=='admin-targetchart') || (Route::currentRouteName()=='admin-timelinechart') || (Route::currentRouteName()=='admin-getFactorsList') || (Route::currentRouteName()=='admin-addNewFactor') || (Route::currentRouteName()=='admin-getCaseTasksList') || (Route::currentRouteName()=='admin-getCaseNotesList') || (Route::currentRouteName()=='admin-getCaseIncidentsList') || (Route::currentRouteName()=='admin-managesubject') || (Route::currentRouteName()=='admin-managetarget') || (Route::currentRouteName()=='admin-add-target')  )
						<li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-tachometer-alt"></i> Dashboard </a></li>
						<li class="header-menu"><span>Case View </span></li>
						<li><a href="{{ route('admin-managesubject',[Request::segment(3)])}}"><i class="fa fa-tachometer-alt"></i> Subject </a></li>
						<li><a href="{{ route('admin-getDescription',[Request::segment(3)])}}"><i class="fa fa-bullseye" aria-hidden="true"></i> Description </a></li>
						<li><a href="{{ route('admin-managetarget',[Request::segment(3)])}}"><i class="fa fa-futbol-o" aria-hidden="true"></i> Target </a></li>
						<li class="active">
							<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-bar-chart" aria-hidden="true"></i> Charts</a>
								<ul class="collapse list-unstyled innerdropdownul" id="homeSubmenu">
									<li>
										<a href="{{ route('admin-targetchart',[Request::segment(3)])}}"><i class="fa fa-pie-chart" aria-hidden="true"></i> Target charts</a>
									</li>
									<li>
										<a href="{{ route('admin-timelinechart',[Request::segment(3)])}}"><i class="fa fa-line-chart" aria-hidden="true"></i> TimeLine charts</a>
									</li>
									<li>
										<a href="{{ route('admin-corkboard',[Request::segment(3)])}}"><i class="fa fa-line-chart" aria-hidden="true"></i> Corkboards</a>
									<li>
								</ul>
						</li>
						<li><a href="{{ url('admin/getFactorsList',[Request::segment(3),'factors'])}}"><i class="fa fa-sun-o" aria-hidden="true"></i> Factors </a></li>
						<li><a href="{{ url('admin/getFactorsList',[Request::segment(3),'tasks'])}}"><i class="fa fa-sign-language" aria-hidden="true"></i> Tasks </a></li>
						<li><a href="{{ url('admin/getFactorsList',[Request::segment(3),'notes'])}}"><i class="fa fa-sticky-note" aria-hidden="true"></i> Notes </a></li>	
						<li><a href="{{ url('admin/getFactorsList',[Request::segment(3),'incidents'])}}"><i class="fa fa-crosshairs"></i> Linked Incidents </a></li>
						<li><a href="{{ route('admin-getFileDetail',[Request::segment(3)])}}"><i class="fa fa-files-o"></i> Files </a></li>	
                        <li><a href="{{route('admin-download-case-pdf-caseList',['id'=>Request::segment(3)]) }}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Generate PDF </a></li>
					@else
						<li class="header-menu"><span>General</span></li>
						<li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-tachometer-alt"></i> Dashboard </a></li>
						<li><a href="{{ url('admin/incidentList')}}"><i class="fa fa-random" aria-hidden="true"></i> Incidents </a></li>
						
                        
						<?php 
						if(count($getAccessListArray)>0){ 
							if (array_key_exists("account",$getAccessListArray))
								{ ?>
									<li class="@if(Route::currentRouteName()=='admin-AccountList') active @endif treeview">
										<a href="{{route('admin-AccountList')}}">
										<i class="fa fa-university" aria-hidden="true"></i>
										<span>{{_i('Account')}}</span>
										</a>
									</li>
						<?php } } ?>	
						<?php if(count($getAccessListArray)>0){ 
							if (array_key_exists("user",$getAccessListArray))	{ ?>
									<li class="@if(Route::currentRouteName()=='admin-users') active @endif treeview ">
										<a href="{{route('admin-users')}}">						
										<i class="fa fa-user" aria-hidden="true"></i>
										<span>{{_i('Team')}}</span>
										</a>
									</li>
						<?php  } } ?>	
						<?php if(count($getAccessListArray)>0){
							if (array_key_exists("user",$getAccessListArray)){ ?>
									<li class="@if(Route::currentRouteName()=='admin-groups') active @endif treeview ">
										<a href="{{route('admin-groups')}}">
										<i class="fa fa-group" aria-hidden="true"></i>
										<span>{{_i('Groups')}}</span>
										</a>
									</li>
						<?php  } } ?>
						<?php 
						 if(count($getAccessListArray)>0){ 
							if (array_key_exists("case",$getAccessListArray)){?>
										<li class="@if((Route::currentRouteName()=='admin-caseList') || (Route::currentRouteName()=='admin-viewCase')) active @endif treeview ">
										<a href="{{route('admin-caseList')}}">
										<i class="fa fa-life-ring" aria-hidden="true"></i> 
										<span>{{_i(' Cases')}}</span>
										</a>
									</li>
						<?php  } } ?>
						<?php 
						 if(count($getAccessListArray)>0){ 
							if (array_key_exists("files",$getAccessListArray)){?>
									<li class="@if((Route::currentRouteName()=='admin-filelist') || (Route::currentRouteName()=='admin-filelist')) active @endif treeview ">
										<a href="{{route('admin-filelist')}}">
										<i class="fa fa-file" aria-hidden="true"></i>
											<span>{{_i(' Files')}}</span>
										</a>
									</li>
						<?php } } ?>
						<li><a href="{{ url('admin/subjectList')}}"><i class="fa fa-university" aria-hidden="true"></i> Subjects </a></li>
						<li><a href="{{ url('admin/targetList')}}"><i class="fa fa-university" aria-hidden="true"></i> Targets </a></li>
						<li><a href="{{ url('admin/taskList')}}"><i class="fa fa-snowflake-o" aria-hidden="true"></i> Tasks </a></li>
						<li><a href="{{ url('admin/reportList')}}"><i class="far fa-gem"></i> Reports </a></li>
						<li class="@if(Route::currentRouteName()=='admin-resources-list') active @endif treeview ">
							<a href="{{route('admin-resources-list')}}">
							<i class="fa fa-user-secret" aria-hidden="true"></i>{{_i(' Resources')}}</a>
						</li>
						<li><a href="{{ url('admin/comingsoon')}}"><i class="fa fa-chart-line"></i> Analytics </a></li>  		
					@endif	
						        
					</ul>
				<div class="pages">
					<ul class="breadcrumb">
						<li><a class="active" href=" https://tadapp.net/threat-assessment-for-schools-instructions/" target="_blank">How to use</a></li>
					</ul>
				</div>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer" style="display: none;">
      <a href="#">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">3</span>
      </a>
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="#">
        <i class="fa fa-cog"></i>
        <span class="badge-sonar"></span>
      </a>
      <a href="#">
        <i class="fa fa-power-off"></i>
      </a>
    </div>
  </nav>
  <!-- sidebar-wrapper  -->
            <main class="page-content">
            <div class="wrapper">           
                <header class="main-header">
				<!--  New Html    -->
				<div class="header-container">
					<div class="mob_header">
						<a href="{{url('/')}}">TAD App</a>
						<div class="mob_trigger">
							<span class="one"></span>
							<span class="two"></span>
							<span class="third"></span>
						</div> 
						<cite class="user-img">
						<?php $profile_pic = 'images/default_user.jpg'; if(!empty(session('profile_pic')) ){
							 $profile_pic = 'uploads/user/'.session('profile_pic');
						}?>
						<img src="{{asset($profile_pic)}}" /></cite>
					</div>
					<div class="container">
						<div class="welcome-user">
							<a href="{{url('/')}}">Threat Assessment Dashboard </a>
							<div class="user" style="display: none;">
								<p><span>Welcome!</span> &nbsp;{{ ucfirst(session('name')) }}</p> 
								<span class="user-img"><img src="{{asset($profile_pic)}}" width="35" /></span>
								<div class="user-popup">
									<ul>
                                        <li class="pointer"><span> <a title="Profile" class="usernavopopup" href="{{route('admin-profile')}}">Profile</a></span></li>
                                        <li class="pointer"><span> <a title="Team" class="usernavopopup" href="{{route('admin-users')}}">Team</a></span></li>
                                        <li class="pointer"><span> <a title="Groups" class="usernavopopup" href="{{route('admin-groups')}}">Groups</a></span></li>
                                        <li class="pointer"><span> <a  title="Resources" class="usernavopopup" href="{{ url('admin/resourcesList')}}">Resources</a></span></li>
										<li class="pointer"><span> <a  title="Change Password" class="usernavopopup" href="{{ route('admin-changepassword')}}">Change Password</a></span></li>
                                        <li class="pointer"><span> <a  data-toggle="tooltip" title="Logout" class="usernavopopup" href="{{route('admin-logout')}}">Logout</a></span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="navigation-container resp-nav" style="display: none;">
					<div class="container resp">
						<div class="nav-container">
							<div class="nav-bar">
								<ul>
								<!-- <li class="header">{{_i('MAIN NAVIGATIONS')}}</li> -->
									<li class="@if(Route::currentRouteName()=='admin-dashboard') active @endif treeview ">
									  <a href="{{route('admin-dashboard')}}">
										{{_i('Dashboard')}} 
									  </a>
									</li>
									
									 <li class="@if(Route::currentRouteName()=='admin-incidentList') active @endif treeview ">
									  <a href="{{route('admin-incidentList')}}">
										{{_i('Incidents')}} 
									  </a>
									</li>
									<!-- <li class="@if(Route::currentRouteName()=='admin-incidenttypeList') active @endif treeview">
									  <a href="{{route('admin-incidenttypeList')}}">
										<i class="fa fa-dashboard"></i> <span>{{_i('Incident Type')}} </span>
									  </a>
									</li>-->
									<?php 
									if(count($getAccessListArray)>0){ 
										if (array_key_exists("account",$getAccessListArray))
									{
									?>
									<li class="@if(Route::currentRouteName()=='admin-AccountList') active @endif treeview">
									  <a href="{{route('admin-AccountList')}}">
										<i class="fa fa-university" aria-hidden="true"></i>
										<span>{{_i('Account')}}</span>
									  </a>
									</li>
									<?php 
									 } 
								   }
                                                                   
										 if(count($getAccessListArray)>0){ 

										  if (array_key_exists("user",$getAccessListArray))
											{
									  ?>
									<li class="@if(Route::currentRouteName()=='admin-users') active @endif treeview ">
									  <a href="{{route('admin-users')}}">
										
										<span>{{_i('Team')}}</span>
									  </a>
									</li>
									<?php 
									 } 
								   } 
                                                                   
                                                                   if(count($getAccessListArray)>0){ 
                                                                        if (array_key_exists("user",$getAccessListArray))
									{
									  ?>
									<li class="@if(Route::currentRouteName()=='admin-groups') active @endif treeview ">
									  <a href="{{route('admin-groups')}}">
										<span>{{_i('Groups')}}</span>
									  </a>
									</li>
									<?php 
									 } 
								   }
                                                                   
                                                                   
										 if(count($getAccessListArray)>0){ 

										  if (array_key_exists("case",$getAccessListArray))
											{
									  ?>
									 <li class="@if((Route::currentRouteName()=='admin-caseList') || (Route::currentRouteName()=='admin-viewCase')) active @endif treeview ">
									  <a href="{{route('admin-caseList')}}">
										{{_i(' Cases')}}
									  </a>
									</li>
									<?php 
									 } 
								   } 
								    if(count($getAccessListArray)>0){ 

										  if (array_key_exists("files",$getAccessListArray))
											{
									  ?>
									 <li class="@if((Route::currentRouteName()=='admin-filelist') || (Route::currentRouteName()=='admin-filelist')) active @endif treeview ">
									  <a href="{{route('admin-filelist')}}">
										{{_i(' Files')}}
									  </a>
									</li>
									<?php 
									 } 
								   } 
										 if(count($getAccessListArray)>0){ 

										  if (array_key_exists("sector",$getAccessListArray))
											{
									  ?>
								   <!--  <li class="@if(Route::currentRouteName()=='admin-sector-list') active @endif treeview">
									  <a href="{{route('admin-sector-list')}}">
										<i class="fa fa-user-secret" aria-hidden="true"></i>
										<span>{{_i('Manage Sectors')}}</span>
									  </a>
									</li>-->
									<?php 
									 } 
								   } 
								   ?>
								   <li class="@if(Route::currentRouteName()=='admin-task-list') active @endif treeview ">
									  <a href="{{route('admin-task-list')}}">
										
										{{_i(' Tasks')}}
									  </a>
									</li>

								   <li class="@if(Route::currentRouteName()=='admin-resources-list') active @endif treeview ">
									  <a href="{{route('admin-resources-list')}}">										
										{{_i(' Resources')}}
									  </a>
									</li>

									<li class="@if(Route::currentRouteName()=='admin-reportList') active @endif treeview ">
									  <a href="{{route('admin-reportList')}}">
										
										{{_i(' Reports')}}
									  </a>
									</li>
									<!--<li class="@if(Route::currentRouteName()=='admin-manage-forum') active @endif treeview ">
									  <a href="{{route('admin-manage-forum')}}">
										
										<span>{{_i('Forums')}}</span>
									  </a>
									</li>-->
									
									
									
								</ul>
							</div>
							<div class="pages">
								<ul class="breadcrumb">
								<li><a class="active" href=" https://tadapp.net/threat-assessment-for-schools-instructions/" target="_blank">How to use</a></li>
									<!--<li><a class="active" href="#">Home</a></li>
									<li class="disabled"><a href="#">Dashboard</a></li>-->
								</ul>
							</div>
						</div>
					</div>
				</div>
            </header>    



           

            @yield('content')

            @extends('layout.backened.footer_new')
            <script type="text/javascript">
  jQuery(function ($) {

    $(".sidebar-dropdown > a").click(function() {
  $(".sidebar-submenu").slideUp(200);
  if (
    $(this)
      .parent()
      .hasClass("active")
  ) {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
      .parent()
      .removeClass("active");
  } else {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
      .next(".sidebar-submenu")
      .slideDown(200);
    $(this)
      .parent()
      .addClass("active");
  }
});

$("#close-sidebar").click(function() {
  $(".page-wrapper").removeClass("toggled");
});
$("#show-sidebar").click(function() {
  $(".page-wrapper").addClass("toggled");
});


   $(".actions").change(function() {
   	if (this.selectedIndex !== 0) {
       window.location.href = this.value;
  }
});
   
});
</script>
