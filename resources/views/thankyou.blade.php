@extends('layout.frontend.home_header')
@section('content')
<div id="carre_noir">
        <div class="image text-center" style="text-align: center; ">
        <img src="https://image.flaticon.com/icons/svg/742/742751.svg" alt="Smile free icon" title="Smile free icon" width="224" height="224" style=" margin: 30px 0;">        </div>
        <p style="color:#fff; padding-top:0;font-size:18px;" >{{_i('Hello')}} <?php echo ucwords(@$data['name']).' ,';?> {{_i('an email verification link has been sent to your email id. Please confirm email before proceed.')}}</p>


        </div>
        <footer>
        <div class="pull-right top-rightsec dv-lang-usr" style="margin-right: 2%;">
            <h3>
           
             <ul>
                @foreach(Config::get('laravel-gettext.supported-locales') as $locale)
                    <li>
                        <a href="lang/{{$locale}}">
                        <?php   $current_language = \Lang::getLocale();
                        if($current_language.'_US' == $locale){
                         continue; 
                       } 
                       if($current_language.'-CH' == $locale){
                        continue;
                       }
                        else{
                         if($locale=='en_US')
                          {
                           echo 'English';
                         }
                         if($locale=='fr-CH'){
                          echo 'Français';
                         } 
                       } ?>  </a>
                    </li>
                @endforeach
              </ul>
               
            </h3>
        </div>
        </footer>
   @endsection
