@extends('layout.frontend.outer.header') @section('content')
 <!-- /.preloader -->
    <div id="preloader"></div>
    <div id="top"></div>

    <!-- /.parallax full screen background image -->
    <div class="fullscreen landing parallax" style="background-image:url('{{asset('newtheme/images/bg5.jpg')}}');" data-img-width="2000" data-img-height="1333" data-diff="100">

        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mr-auto ml-auto text-center">

                        <!-- /.main title -->
                        <h1 class="wow fadeInLeft" style="margin-bottom: 5px; ">
                                {{_i('7 steps for')}} <strong style="color:#1F95DF;">{{_i('make a living online')}}</strong>, {{_i('starting from scratch')}}!
                            </h1>
                        <!-- /.header paragraph -->
                        <div class="landing-text-video wow fadeInLeft">
                            <p><strong>{{_i('Discover two new trades that emerged from the digital age')}}...</strong></p>
                        </div>
                        <div class="video-header">
                            <div class="video-embed wow fadeIn" data-wow-duration="1s">

                                <!-- The YouTube video -->
                                <div class="video-wrap">
                                    <div class="video">
                                        <iframe width="1903" height="764" src="https://www.youtube.com/embed/aO2rxG_pwkI?modestbranding=1&amp;rel=0&autoplay=0&showinfo=0&controls=0" frameborder="0" allow="autoplay; encrypted-media" gesture="media " allowfullscreen></iframe>
                                    </div>
                                </div>

                                <!-- video embed from VIMEO -->
                                <!-- <iframe src="//player.vimeo.com/video/103435603?title=0&amp;byline=0&amp;portrait=0&amp;color=8aba56" width="500" height="281" frameborder="0" allowfullscreen></iframe> -->

                            </div>
                        </div>
                        <div class="btn wow fadeInLeft" style="margin:0px auto;" text-center>
                            <form class="form-horizontal" method="post" action="{{route('register')}}">
                                    {{ csrf_field() }}
                                      <div class="form-group">

                                         <div class="text-center"> 
                                            <button type="submit" class="btn-secondary">{{_i('CREATE MY ACCOUNT')}}</button>


                                         </div>
                                      </div>
                                      <input type="hidden" name="email" value="{{@$data['email']}}" />
                                      <input type="hidden" name="id" value="{{@$data['id']}}" />
                                   </form>
                        </div>
                        <!-- /.header paragraph -->
                        <div class="landing-text-video wow fadeInLeft" style="padding-top: 15px; padding-bottom:25px;">
                            <p>100% {{_i('Secure')}} </p>
                            <a href=""><img src="{{asset('newtheme/images/cards.jpg')}}" alt="Cards"></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.feature 2 section -->
    <div id="feature-2">
        <div class="container">
            <div class="row">
                <!-- /.feature content -->
                <div class="col-lg-12 wow fadeInLeft text-center">
                    <h2><strong>{{_i('Series of 7 videos to learn how')}} <strong style="color:#1F95DF;">{{_i('make a living by simply selling information')}}</strong>, {{_i('in a completely automated way')}}!</strong></h2>
                    <h3>{{_i('All thanks to three tools that everyone uses every day')}}....</h3>
                    <p>
                        
                        {{_i('We went through different economies. And the society we know is experiencing the biggest economic change it has ever experienced. Several parameters and variables have changed with the arrival of the digital age. In other, how to make a living. Becoming an info-taker or becoming an Affiliate allows you to start your own business very quickly without having')}} :
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- /.testimonial section -->
    <div id="feature" style="padding-bottom:25px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="wow fadeInLeft">{{_i('Here is what they think')}}...</h2>
                    <div class="title-line wow fadeInRight"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 mr-auto ml-auto">
                    <div id="owl-testi" class="owl-carousel owl-theme wow fadeInUp">

                        <!-- /.testimonial 1 -->
                        <div class="testi-item">
                            <div class="client-pic text-center">

                                <!-- /.client photo -->
                                <img src="{{asset('newtheme/images/manu-lemire.jpg')}}" alt="Manu Lemire">
                            </div>
                            <div class="box">

                                <!-- /.testimonial content -->
                                <p class="message text-center">{{_i('Danny, you are someone who inspires success in his DNA, and when you take the time to get to know yourself better, you realize how endless you are a man of infinite resources who has the incredible ability to ALWAYS find a way to succeed and that is exceptional! Hat my friend')}}</p>
                            </div>
                            <div class="client-info text-center">

                                <!-- /.client name -->
                                Manu Lemire, <span class="company">"{{_i('Speaker and Author')}}"</span>
                            </div>
                        </div>

                        <!-- /.testimonial 2 -->
                        <div class="testi-item">
                            <div class="client-pic text-center">

                                <!-- /.client photo -->
                                <img src="{{asset('newtheme/images/dominique-fraser.jpg')}}" alt="Dominique Fraser">
                            </div>
                            <div class="box">

                                <!-- /.testimonial content -->
                                <p class="message text-center">{{_i('Danny Cyr is nothing short of')}} "{{_i('NEXT BIG STAR')}}" {{_i('It is definitely THE PERSON to follow if you want to make money online. to revolutionize the way of generating passive income on the web.By his great sensitivity, his listening and his daring Danny is a visionary like there is little')}} !"</p>
                            </div>
                            <div class="client-info text-center">

                                <!-- /.client name -->
                                Dominique Fraser, <span class="company">{{_i('Speaker and Mentor in Business Development')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.intro section -->
    <div id="intro">
        <div class="container">
            <div class="row">

                <!-- /.intro image -->
                <div class="col-sm-12 col-lg-3 intro-pic wow slideInRight text-center">
                    <img src="{{asset('newtheme/images/guaranteed.png')}}" alt="image" class="img-fluid">
                </div>

                <!-- /.intro content -->
                <div class="col-sm-12 col-lg-9 wow slideInRight">
                    <h2>{{_i('Deposit')}} 100% {{_i('Guaranteed')}}!</h2>
                    <p><strong>{{_i('Deposit returned 100% when requested')}}.</strong></p>
                    <p>{{_i('This is a series of 7 FREE videos to learn how two new trades can change your life in the next 90 days. This video series will explain the basics of knowing how to succeed in these two areas. This video series also discusses what it takes as tools and knowledge to really be successful in the next 90 days. And as this video series contains VERY VERY high value-added content, revealing some secrets then you have to give a deposit in order to get the FREE video series for 14 days. Anytime within this period you can ask for your deposit again')}}.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- /.download section -->
    <div id="download">
        <div class="action fullscreen parallax" style="background-image:url('{{asset('newtheme/images/bg5.jpg')}}');" data-img-width="2000" data-img-height="1333" data-diff="100">
            <div class="overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 text-center">

                            <!-- /.download title -->
                            <h2 class="wow fadeInRight">{{_i('What are you waiting for exactly')}} ? </h2>
                            <p>{{_i('Request your FREE video series immediately and start immediately adapting to our new economy')}}.</p>

                            <!-- /.download button -->
                            <div class="btn wow fadeInLeft" style="margin:0px auto;">

                                <form class="form-horizontal" method="post" action="{{route('register')}}">
                                    {{ csrf_field() }}
                                      <div class="form-group">

                                         <div class=" text-center"> 
                                            <button type="submit" class="btn-secondary">{{_i('CREATE MY ACCOUNT')}}</button>


                                         </div>
                                      </div>
                                      <input type="hidden" name="email" value="{{@$data['email']}}" />
                                      <input type="hidden" name="id" value="{{@$data['id']}}" />
                                   </form>
                            </div>

                            <p><strong>100% {{_i('Secure')}}</strong></p>
                            <p class="mar_bt-40">{{_i('P.S. At any time you can ask for your deposit again. I am here for one purpose, to make you understand that the old economic model (Work hard 40h / week ... For 40 years ... For + / - 40k per year) and it is over and I am Commit to showing you everything from A to Z')}}. </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection