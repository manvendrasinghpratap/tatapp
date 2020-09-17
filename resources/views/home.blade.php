@extends('layout.frontend.home_header') @section('content')
<div id="carre_noir">
    <p>
        <span>{{ _i('Discover for FREE')}}</span> {{ _i('How you can generate a minimum of $ 563 in less than 30 minutes a day with your SmartPhone or Laptop')}}
    </p>

    <div class="centered-text">
        <div id="btnJeVeuxSavoir" class="boutonJaune">
            {{ _i('I want to know')}}<i class="fa fa-check-square-o" aria-hidden="true"></i>

        </div>

    </div>

    <div id="boite-legere" style="display:none">
        <form method="post" class="af-form-wrapper" id="optin-form" accept-charset="UTF-8" action="https://www.aweber.com/scripts/addlead.pl" name="form-go" id="optin-form">
            <div style="display: none;">
                <input type="hidden" name="meta_web_form_id" value="1708197330" />
                <input type="hidden" name="meta_split_id" value="" />
                <input type="hidden" name="listname" value="awlist4915474" />
                <input type="hidden" name="redirect" value="" id="redirect_16b006ec503c8e5b30801dde3ffc4a0c" class="redirect_url" />
                <input type="hidden" name="meta_adtracking" value="Opt-In_DK_officiel" />
                <input type="hidden" name="meta_message" value="1" />
                <input type="hidden" name="meta_required" value="name,email" />
                <input type="hidden" name="meta_tooltip" value="" />
            </div>
            <p class="mar_tp_0" style="font-size:14px; color:#000; margin:20px 0;">
                {{_i('Enter your first name and email to access the explanatory video')}}
            </p>
            <div class="inputText">
                <input type="text" class="form-control" placeholder="{{_i('Enter your first name')}}" id="awf_field-92280269" name="name" />
            </div>
            <div class="inputText">
                <input type="text" class="form-control" placeholder="{{_i('Enter your email')}}" id="awf_field-92280270" name="email" />
            </div>
            <div style="width:100%; text-align:center;">
                <div class="boutonJaune" style="color:#fff;maring:auto;" id="onPlonge" onClick="clickOnPlonge();">
                    {{_i('We dive!')}}
                </div>
            </div>

            <div style="width:100%; text-align:center;">

                <p class="mar_tp_0" style="font-size:12px;">
                    <i class="fa fa-lock" aria-hidden="true"></i> {{_i('Your information is safe. We will never give or sell your information.')}}

                </p>
            </div>
            <div id="xFerme" style="width:16px;">
                <i class="fa fa-close"></i></div>
    </div>
    <div style="display: none;"><img src=" https://forms.aweber.com/form/displays.htm?id=jCxsjJxMbCwsDA== " alt="" /></div>
    </form>
    <script type="text/javascript" charset="utf-8">
        $("#redirect_16b006ec503c8e5b30801dde3ffc4a0c").val("{{route('vsldk')}}?reference=" + getValue("reference"));
    </script>
</div>
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
<script type="text/javascript">
    (function() {
        var IE = /*@cc_on!@*/ false;
        if (!IE) {
            return;
        }
        if (document.compatMode && document.compatMode == 'BackCompat') {
            if (document.getElementById("af-form-1461926440")) {
                document.getElementById("af-form-1461926440").className = 'af-form af-quirksMode';
            }
            if (document.getElementById("af-body-1461926440")) {
                document.getElementById("af-body-1461926440").className = "af-body inline af-quirksMode";
            }
            if (document.getElementById("af-header-1461926440")) {
                document.getElementById("af-header-1461926440").className = "af-header af-quirksMode";
            }
            if (document.getElementById("af-footer-1461926440")) {
                document.getElementById("af-footer-1461926440").className = "af-footer af-quirksMode";
            }
        }
    })();
</script>