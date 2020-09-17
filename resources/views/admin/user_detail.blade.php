@extends('layout.backened.header')
@section('content')
  <div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>User Details</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin-users')}}">Users</a></li>
        <li class="active">User Details</li>
      </ol>
    </section>
    
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            
              <div class="box-body box-log-dtl">

              <div class="form-group">
                  <div class="row">
                    
                  </div>
                </div>

               <!--  <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">User Name</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">{{@$data->user_name}}</label>
                    </div>
                  </div>
                </div> -->

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">{{@$data->first_name}}</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">{{@$data->last_name}}</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10 pull-left">
                    <label class="control-label sbsc-lbl-eml">{{@$data->email}}</label>
                  </div>
                </div>
                 </div>

                
                <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10 pull-left">
                    <label class="control-label sbsc-lbl-eml">@if($data->status=='1'){{'Active'}}@else{{'In-Active'}}@endif</label>
                  </div>
                </div>
                 </div>

                 <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">List of cases</label>
                  <div class="col-sm-10 pull-left">
                    <ul>
                      <?php 

                      foreach($data->caselistsOwner as $key=>$val){ 
                        echo '<li>'.$val->title.'<li>';
                        ?>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
                 </div>

                 <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">Created Date</label>
                  <div class="col-sm-10 pull-left">
                    <label class="control-label sbsc-lbl-eml">{{date("d-m-Y", strtotime($data->created_at))}}</label>
                  </div>
                </div>
                 </div>
                
                 
                

                 </div>
                
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-users')}}" class="btn btn-default">Go Back</a>
              </div>
              <!-- /.box-footer -->
          </div>
              <!-- /.box-footer -->
          </div>
          
        </div>
        <!--/.col (right) -->
        </div>
       
      </div>
    
  

  @endsection