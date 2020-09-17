@extends('layout.backened.header')
@section('content')
<script>
    $(document).ready(function () {
   
        $('#userProfile').validate({
            rules: {
                current_password: {
                  required:true,
                  remote: {
                    url: '{{route("check_current_password")}}',
                    type: "get",
                    data: {
                        title: function() {
                            return $("#current_password").val();
                        }
                    },
                  },
                },
                new_password: {
                    required:true,
                    minlength:6,
                },
                confirm_password: {
                    required:true,
                    minlength : 6,
                    equalTo : "#new_password",
                },
              },
            // Specify validation error messages
            messages: {
              current_password:
              {
                  required:"Please enter Current Password.",
                  remote:"Current password is wrong.",
              },
              new_password:
              {
                  required:"Please enter New Password.",
                  minlength:"Please enter at least 6 characters.",
              },
              confirm_password:
              {
                  required:"Please enter Confirm Password.",
                  minlength:"Please enter at least 6 characters.",
                  equalTo : "Confirm password should match with New Password.",
              },
            },
        });
    });
</script>

 <div class="clearfix"></div>
 <div class="section" style="min-height:490px;" >
	<div class="container">
    <section class="content-header">
	<div class="paddingbottom10px"><h3>Change Password</h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
        <li class="active">Change Password</li>
      </ol>
    </section>
    
  
      <div class="row">
        <div class="col-md-9">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              
              @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('message') !!} 
                </div>
                @endif
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="" id="userProfile" action="{{route('admin-changepassword')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">

                <div class="form-group row @if($errors->first('current_password')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label">Current Password {{redstar()}}</label>
                  <div class="col-sm-7">
                   <input type="password" id="password" name="current_password" value="{{old('current_password')}}" class="form-control">
                  </div>
                </div>
                
                <div class="form-group row @if($errors->first('new_password')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label">New Password {{redstar()}}</label>
                  <div class="col-sm-7">
                   <input type="password" id="new_password" name="new_password" value="{{old('last_name')}}" class="form-control">
                  </div>
                </div>
                <div class="form-group row @if($errors->first('confirm_password')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label">Confirm Password {{redstar()}}</label>
                  <div class="col-sm-7">
                   <input type="password" id="confirm_password" name="confirm_password"  value="{{old('confirm_password')}}" class="form-control detail_valid">
                  </div>
                </div>
                  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-dashboard')}}" class="btn btn-default">Cancel</a>
                <input type="submit" value="Submit" class="btn btn-info">
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          
        </div>
        <!--/.col (right) -->
       </div>   
	  </div>
       
      </div>
      <style>
        .error{
          color: red;
        }
      </style>
  @endsection