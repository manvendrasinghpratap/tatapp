@extends('layout.frontend.outer.header') @section('content')

    <div id="top"></div>


        <div class="fullscreen landing parallax height_fix" style="background-image:url('{{asset('newtheme/images/bg3.jpeg')}}');" data-img-width="2000" data-img-height="1333" data-diff="100">

        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <!-- /.main title -->
                        <h1 class="titre wow fadeInLeft">
                            {{_i('You are almost there')}}!
                            <h2><strong>{{_i('A little step further')}}...</strong></h2>

                        </h1>

                        <!-- /.header paragraph -->
                        <div class="landing-text wow fadeInUp">
                            <p><strong>{{_i('I just sent you an email. To complete your registration you just have to confirm your email address. If you have not received the email within 2 to 3 minutes ... Remember to check your unwanted emails / SPAM. Thank you we see on the other side')}}!</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection