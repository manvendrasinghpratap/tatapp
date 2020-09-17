@extends('layout.frontend.register_header')
@section('content')
 <section id="wrapper">
            <div class="container">

                <div class="col-lg-6 text-center">
                    <h1>    <a href="{{route('home')}}"><img src="{{asset('assets/images/digital-kheops-logo.png')}}" class="logo-inscription""></a></h1>
                     @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-block">
                            <h2>{{_i('Log in')}}</h2>
                            <form id="login-form" class="form-horizontal" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-md-12">{{_i('Email Address')}}</label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="{{_i('Email Address')}}" class="form-control form-control-line" name="email" id="courriel" value="<?php echo @$email; ?>">
                                         @if ($errors->has('email'))
                                            <span class="help-block">
                                                {{ $errors->first('email') }}
                                            </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">{{_i('Password')}}</label>
                                    <div class="col-md-12">
                                        <input type="password" placeholder="********" class="form-control form-control-line" name="password" id="mdp" value="<?php echo @$password; ?>">
                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            {{ $errors->first('password') }}
                                        </span>
                                        @endif


                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success" id="submit">
                                            {{_i('Log in')}}
                                        </button>
                                    </div>
                                </div>
                                 <div class="right-float frgt-pswd"> 
                                    <a  href="{{ url('user-forgot-password') }}">{{_i('Forgot Password')}}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
 @endsection