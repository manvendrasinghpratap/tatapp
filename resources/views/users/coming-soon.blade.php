  @extends('layout.frontend.user.header')
@section('content')
<div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 col-8 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}">{{_i('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{_i('Coming Soon')}}
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <h1 class="card-title text-center">{{_i('Coming Soon')}} .............</h1>
                            <div class="row text-center">
                            <div class="col-sm-8 col-sm-offset-2">
                                <div class="col-md-6">
                                    
                                </div>
                            </div>
                                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 </div>
 @endsection