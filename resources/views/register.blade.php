@extends('layout.frontend.register_header')
@section('content')
  <section id="wrapper">
        <div class="container">

            <div class="col-md-10">
                <div class="text-center">
                	<img src="{{asset('assets/images/digital-kheops-logo.png')}}" class="logo-inscription"">
                </div>
                <div class="text-center">{{_i('Please create your member area by filling out the form below. Your email address will be your login and the chosen password will allow you to login to your member area.')}}</div><br>
                <div class="card">
                    <div class="card-block" id="alertes">
                        <h2>{{_i('Registration')}}</h2>
                        <form method="post" id="registration-form" accept-charset="UTF-8" action="{{route('user-registration')}}">
                            <div class="form-horizontal form-material">
                                <div class="row">
                                    <div class="col-md-6">
                                        

                                        <div class="form-group">
                                            <label class="col-md-12">{{_i('First Name')}}</label>
                                            <div class="col-md-12">
                                                <input placeholder="{{_i('First Name')}}" class="form-control form-control-line first_name" id="awf_field-95327552" type="text" name="first_name" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">{{_i('Last Name')}}</label>
                                            <div class="col-md-12">
                                                <input id="awf_field-95327552" type="text" name="last_name" placeholder="{{_i('Last Name')}}" class="form-control form-control-line last_name" id="nom">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">{{_i('Email Address')}}</label>
                                            <div class="col-md-12">
                                                <input type="email" placeholder="adresse@email.com" class="form-control form-control-line email" id="awf_field-95327553" type="text" name="email" "@if(@$data['email']) {{'readonly' }} @endif" value="@if(@$data['email']) {{ @$data['email'] }}@endif">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-12">{{_i('Confirmation Email Address')}}</label>
                                            <div class="col-md-12">
                                                <input type="email" placeholder="adresse@courriel.com" class="form-control form-control-line" name="cemail" id="confcourriel" "@if(@$data['email']) {{'readonly' }} @endif" value="@if(@$data['email']) {{ @$data['email'] }}@endif">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="mdp" class="col-md-12">{{_i('Password')}}</label>
                                            <div class="col-md-12">
                                                <input type="password" placeholder="********" class="form-control form-control-line" name="mdp" id="mdp">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-email" class="col-md-12">{{_i('Confirm Password')}}</label>
                                            <div class="col-md-12">
                                                <input type="password" placeholder="********" class="form-control form-control-line" name="mdpverif" id="confmdp">
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <div class="">
                                            <div class="col-md-12 text-center">
                                            <div class="btn-md btn-primary" id="soumettre" style="width: 200px;margin: 0 auto;">
                                                    {{_i('Register')}}
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div style="display: none;">
                                    <input type="hidden" name="meta_web_form_id" value="1461926440" />
                                    <input type="hidden" name="meta_split_id" value="" />
                                    <input type="hidden" name="listname" value="awlist4929030" />
                                    <input type="hidden" name="redirect" value="{{route('start')}}" id="redirect_16b006ec503c8e5b30801dde3ffc4a0c" />

                                    <input type="hidden" name="meta_adtracking" value="Inscription_Dk_officiel" />
                                    <input type="hidden" name="meta_message" value="1" />
                                    <input type="hidden" name="meta_required" value="name,email" />

                                    <input type="hidden" name="meta_tooltip" value="" />
                                    <input type="hidden" name="id" id="user_id" value="{{@$data['id']}}" />
                                     {{ csrf_field() }}
                        </form>
                        </div>
                        </div>
                    </div>
                </div>
    </section>
 @endsection