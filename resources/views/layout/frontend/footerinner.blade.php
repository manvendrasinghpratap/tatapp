 <div class="pwrap">
    <img src="{{asset('assets/img/prdctbn.jpg')}}" alt="bicycle" /> 
    <div class="pstrip">
        {{ _i('Re-Cycling:) - gib Deinem Göppel neuen Wind ins Rad! ') }} ! 
    </div>
    <div class="pstriprt">
        {{ _i('ride it')}} - {{_i('love it')}} - {{ ('like it') }}!
    </div>
    <ul class="psocial-links">
     
        <div class="social-outer-main">
         <div class="sharethis-inline-share-buttons"></div>
         <div class="insta-single-icon"><a href="{{get_social_link('social_instagram')}}"><i class="fa fa-instagram" aria-hidden="true"></i></a></div>
         <div class="insta-single-icon"><a class="yt-icon" href="{{get_social_link('social_youtube')}}" target="_blank"><i class="fa fa-youtube"></i></a></div>
     </div>

    </ul>
</div>
</section>
 
 <div class="cycle-banner cyclblkovt">
                <div class="ad-rdct-bx">
                    <section class="footer-scroll slider">
                        @foreach($cycle as $cycles)
                        <div>
                           <a href="http://www.velomaerkte.ch#supersale17" target="_blank">
                                <img src="{{asset('assets/Large_supersale17/'.$cycles->image_path)}}">
                                <div class="cycle-price">
                                    <span class="cycle-pri-actual">{{$cycles->new_price}}</span>.- /
                                    <span class="cycle-cut-price">{{$cycles->old_price}}.-</span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </section>
                    
                    <!--img src="{{asset('assets/img/cycle.jpg')}}" alt="bicycle" /-->
                    <a href="http://www.velomaerkte.ch#supersale17" target="_blank">
                    <div class="cicl-wrp">
                        <div class="crcl-tri"></div>
                        <h3>{{ _i('hundreds radical prices check them out!') }}</h3>
                    </div>
                    </a>
                </div>
        </div> 
        <footer class="footer"> 
            <ul>
                <li> <a href="{!! url('/pages/terms-and-conditions') !!}">{{_i('Terms & Conditions')}}</a></li>
               <li> <a href="{!! url('/pages/privacy-policy') !!}">{{_i('Privacy')}} </a></li>
                <li> <a href="{!! url('/pages/selling-tips') !!}">{{_i('Selling tips')}}</a></li>
                <!--<li><strong>Copyright &copy; {{date('Y')}} </strong> All rights reserved.</li>-->
            </ul>
            
        </footer> 
        
        </div>

        <div class="ftr-cycle-sec">
            <div class="ftr-cycle-bx train">
                <div class="ftr-cycle-flag">{{_i("Wanna know the #1 bicycle buyer's secret?")}}</div>
                <div class="ftr-cycle-img"><img class="" src="{{asset('assets/img/bicycle-bottom.png')}}" alt=""/></div>
            </div>
            <div class="ftr-cycle-sure">
                <div class="sure-ftr-in">
                    <h3><strong>{{_i('Sure')}}.</strong>{{_i('show me')}}!</h3>
                </div>
            </div>
        </div>

     <div id="fb-root"></div>
   
<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $(".navbar-hd a").click(function(){
                $(".navlist").toggleClass("showmenu");
            });
        });
    </script>
 <script type="text/javascript" src="{{asset('assets/js/marketlist.js')}}"></script>  
 <script type="text/javascript" src="{{asset('assets/slick/slick.js')}}"></script>
<script type="text/javascript">
    $(document).on('ready', function() {
      $(".regular").slick({
        dots: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: false
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
      });
      $(".footer-scroll").slick({
        dots: false,
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay:true,
        autoplaySpeed:3500,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: false
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]

      });
      
    });
</script> 

        
