@extends('layout.frontend.home_header')
@section('content')
<div id="carre_noir">
        <div class="image text-center" style="text-align: center; ">
        <img src="https://image.flaticon.com/icons/svg/742/742751.svg" alt="Smile free icon" title="Smile free icon" width="224" height="224" style=" margin: 30px 0;">        </div>
        <p style="color:#fff; padding-top:0;font-size:18px;" > Link Expired.</p>


        </div>
        <footer>
        <div class="pull-right top-rightsec dv-lang-usr" style="margin-right: 2%;">
            <h3>
           
              <ul>
                @foreach(Config::get('laravel-gettext.supported-locales') as $locale)
                    <li>
                        <a href="lang/{{$locale}}">@if($locale=='en_US'){{'English'}} @elseif($locale=='de-CH') {{'Deutsch'}} @elseif($locale=='fr-CH') {{'Français'}} @else {{$locale}} @endif  </a>
                    </li>
                @endforeach
                
            </ul>
               
            </h3>
        </div>
        </footer>
   @endsection
