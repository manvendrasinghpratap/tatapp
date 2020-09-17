@extends('layout.backened.app')

@section('content')
<style>
.error {
    color: #FF2F0F;
    font-size: 12px;
    left: 0;
}
.has-feedback label ~ .form-control-feedback {
    top: 0px;
}
</style>
<?php
    $strOldEmail = old('email');
    $strEmail = '';
    $strRemember = '';
    $strPassword ='';
    if (!empty($strOldEmail)) {
        $strEmail = old('email');
    }
	//print_r($AdminLoginDetails); die;
    //a($arrLoginDetails); exit;
	if(is_array($AdminLoginDetails))
    if (!empty(@$AdminLoginDetails['email'] && !empty(@$AdminLoginDetails['password']))) {
        $strEmail = $AdminLoginDetails['email'];
        $strPassword = $AdminLoginDetails['password'];
        $strRemember = ' checked';
    }
?> 
<script type="text/javascript">
  $(document).ready(function () {

   $('#login-form').validate({ 
    rules: {
     email:
     {
         required: true,
         email:true,
     },
     password:"required",
   },
   messages: {
      title:
      {
          required:"Please enter Email",
          email:"Please enter valid Email",
      } ,
      password: "Please enter Password",
   },
   submitHandler: function(form) {
     form.submit();
   }
 });
});
</script>
    <body class="hold-transition login-page">
        <div class="se-pre-con"></div>
    <div class="login-box">
    <div class="login-logo">
      <a href="{{ route('admin-login') }}"><b>Admin Panel</a>
    </div>
   
    <div class="login-box-body">
        @if (@$msg)
        <div class="alert alert-success">
            {{ $msg }}
        </div>
        @endif
      <p class="login-box-msg">Sign In</p>
          <form class="form-horizontal" id="login-form" role="form" method="POST" action="{{ route('admin-login') }}">
              {{ csrf_field() }}
              
              <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" placeholder="Email" type="email" class="form-control" name="email" value="{{ $strEmail }}"  autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
              </div>

              <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" placeholder="Password" type="password" class="form-control" name="password" value="{{ $strPassword }}" >
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
              </div>
              <div class="row">
                <div class="col-xs-8">
                  <div class="checkbox icheck">
                    <label>
                      <input id="login-remember" type="checkbox" name="remember_me" value="1" {{$strRemember }}> Remember Me
                    </label>
                  </div>
                </div>
                <div class="col-xs-4 pull-right">
                  <button type="submit" class="btn btn-info btn-block btn-flat">Sign In</button>
                </div>
               
              </div>
              
            <br>
              <br>
               <a href="{{ url('user-forgot-password') }}">I forgot my password</a><br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
