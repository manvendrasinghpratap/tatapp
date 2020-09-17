@extends('layout.frontend.register_header')
@section('content')
 <section id="wrapper">
            <div class="container">

                <div class="col-lg-6 text-center">
                    <h1>    <img src="{{asset('assets/images/digital-kheops-logo.png')}}" class="logo-inscription""></h1>
                     @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-block">
                            <h2>{{_i('Reset Password')}}</h2>
                           <form class="form-horizontal" id="reset-form" method="POST" action="{{ route('usersetpasswordpage',['code'=>$key]) }}">
                        {{ csrf_field() }}
                <div class="login-int">
                     <div class="form-group">
                        <label class="lbl-ipt col-sm-12">{{_('Password')}} </label>
                        
                                <div class="col-sm-12">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                                 

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                    </div>
                  <div class="form-group">
                        <label class="lbl-ipt col-sm-12">{{_('Confirm Password')}}  </label>
                        
                                 
                                 <div class="col-sm-12">
                                   <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                    </div>
                    

                     <div class="form-group">
                                    <div class="col-sm-12">
                                         <input type="submit" value="{{_i('Reset Password')}}" class="btn btn-success">
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