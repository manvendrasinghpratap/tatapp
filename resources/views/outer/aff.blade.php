@extends('layout.frontend.outer.header') @section('content')

    <div id="top"></div>

    <!-- /.parallax full screen background image -->
    <div class="fullscreen landing parallax height_fix" style="background-image:url('{{asset('newtheme/images/bg3.jpeg')}}');" data-img-width="2000" data-img-height="1333" data-diff="100">

        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 text-center text-md-left">
                        <!-- /.main title -->
                        <h1 class="titre wow fadeInLeft mar_230">
                            {{_i('Ras-le-bol du 9 à 5')}} ?
                        </h1>

                        <!-- /.header paragraph -->
                        <div class="landing-text wow fadeInUp">
                            <p><strong>{{_i('Discover for FREE how two new trades will help you earn a living with three simple tools that everyone uses every day')}}.</strong></p>
                        </div>

                    </div>

                    <!-- /.signup form -->
                    <div class="col-md-5">

                        <div class="signup-header wow fadeInUp">
                            <h3 class="form-title text-center">{{_i('Start Here')}}</h3>
                             <form method="post" class="af-form-wrapper form-header" id="optin-form" accept-charset="UTF-8" action="https://www.aweber.com/scripts/addlead.pl" name="form-go" id="optin-form">
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
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" placeholder="{{_i('Enter your first name')}}" id="awf_field-92280269" name="name" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" placeholder="{{_i('Enter your email')}}" id="awf_field-92280270" name="email" />
                                </div>
                                <div class="form-group last">
                                    <input type="submit" class="btn btn-warning btn-block btn-lg" value="{{_i('Start')}}">
                                </div>
                                <p class="privacy text-center">{{_i('We will not share your email')}}. {{_i('Read our')}} <a href="{{route('privacy')}}" target="_blank">{{_i('privacy policy')}}</a>.</p>
                                <div style="display: none;"><img src=" https://forms.aweber.com/form/displays.htm?id=jCxsjJxMbCwsDA== " alt="" /></div>
                            </form>
                            <script type="text/javascript" charset="utf-8">
                        $("#redirect_16b006ec503c8e5b30801dde3ffc4a0c").val("{{route('vsldk')}}?reference=" + getValue("reference"));
                    </script>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
