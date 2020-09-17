<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
<?php
      $user_role_name = session('user_role_name');
      //$roleList = array('superAdmin','agencySuperAdmin','agencyAdmin','agencyUser');

      $getAccessListArray = getAccessList($user_role_name);
         /* echo "<pre>";
         print_r($getAccessListArray);
         echo "</pre>"; */

          ?>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!-- <li class="header">{{_i('MAIN NAVIGATIONS')}}</li> -->
        <li class="@if(Route::currentRouteName()=='admin-dashboard') active @endif treeview">
          <a href="{{route('admin-dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>{{_i('Dashboard')}} </span>
          </a>
        </li>
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
        <li class="@if(Route::currentRouteName()=='admin-users') active @endif treeview">
          <a href="{{route('admin-users')}}">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>{{_i('Team')}}</span>
          </a>
        </li>
        <?php 
         } 
       } 
             if(count($getAccessListArray)>0){ 

              if (array_key_exists("case",$getAccessListArray))
                {
          ?>
         <li class="@if((Route::currentRouteName()=='admin-caseList') || (Route::currentRouteName()=='admin-viewCase')) active @endif treeview">
          <a href="{{route('admin-caseList')}}">
            <i class="fa fa-briefcase"></i> <span>{{_i('Manage Cases')}}</span>
          </a>
        </li>
        <?php 
         } 
       } 
             if(count($getAccessListArray)>0){ 

              if (array_key_exists("sector",$getAccessListArray))
                {
          ?>
         <li class="@if(Route::currentRouteName()=='admin-sector-list') active @endif treeview">
          <a href="{{route('admin-sector-list')}}">
            <i class="fa fa-user-secret" aria-hidden="true"></i>
            <span>{{_i('Manage Sectors')}}</span>
          </a>
        </li>
        <?php 
         } 
       } 
       ?>
       <li class="@if(Route::currentRouteName()=='admin-task-list') active @endif treeview">
          <a href="{{route('admin-task-list')}}">
            <i class="fa fa-tasks" aria-hidden="true"></i>
            <span>{{_i('Manage Tasks')}}</span>
          </a>
        </li>

       <li class="@if(Route::currentRouteName()=='admin-resources-list') active @endif treeview">
          <a href="{{route('admin-resources-list')}}">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>{{_i('Manage Resources')}}</span>
          </a>
        </li>

        <li class="@if(Route::currentRouteName()=='admin-reportList') active @endif treeview">
          <a href="{{route('admin-reportList')}}">
            <i class="fa fa-file" aria-hidden="true"></i>
            <span>{{_i('Manage Report')}}</span>
          </a>
        </li>
        <?php  
        $roleList = array('agencySuperAdmin','agencyAdmin','agencyUser');
        if (in_array($user_role_name, $roleList))
        {
       

        ?>
        <li class="@if(Route::currentRouteName()=='admin-manage-forum') active @endif treeview">
          <a href="{{route('admin-manage-forum')}}">
            <i class="fa fa-comments" aria-hidden="true"></i>
            <span>{{_i('Forums')}}</span>
          </a>
        </li>
        <?php } ?>
       <!--  <li class="@if(Route::currentRouteName()=='admin-factor-list') active @endif treeview">
          <a href="{{route('admin-factor-list')}}">
            <i class="fa fa-video-camera" aria-hidden="true"></i>
            <span>{{_i('Manage Factor')}}</span>
          </a>
        </li> -->
    
       
    </section>
    <!-- /.sidebar -->
  </aside>
