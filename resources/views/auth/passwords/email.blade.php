 @extends('layout.frontend.register_header')
@section('content')
 <section id="wrapper">
            <div class="container">

                <div class="col-lg-6 text-center">
                    <h1>    Threat Assessment Tool</h1>
                     @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-block">
                            <h2>{{_i('Forget Password')}}</h2>
                           <form class="form-horizontal" id="forgetpassword" method="POST" action="{{ route('userforgotpasswordpage') }}">
                        {{ csrf_field() }}
                            <div class="login-int">
                                <div class="form-group">
                                    <label class="lbl-ipt col-sm-12">E-Mail Address </label>
                                   <div class="col-sm-12">
                                        <input type="text" name="email" class="form-control" placeholder="" value="{{ old('email') }}">
                                   </div> 
                                     @if ($errors->has('email'))
                                                <span class="help-block">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                </div>
                              
                                <!-- <input type="submit" value="Send Password Reset Link" class="bttn bttn-sbmt lg-btn"> -->
                                <div class="form-group">
                                    <div class="col-sm-12">
                                         <input type="submit" value="{{_i('Send Password Reset Link')}}" class="btn btn-success">
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
 @endsection