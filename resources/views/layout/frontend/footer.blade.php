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
 <div class="cycle-banner cyclblkovt bkbtnwrp">
            <a class="backtotop" href="javascript:void(0);"><i class="fa fa-angle-up"></i>Back to top</a>
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
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.11';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>            
   
<!-- <script type="text/javascript" src="{{--asset('assets/js/jquery.min.js')--}}"></script> -->
<!-- Video Player Script -->
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
      $(".regular img").on("click", function() {

        var typee = $(this).attr('type');
        if(typee==1)
        {
            $("#videoarea").show();
            $("#embedarea").hide();
            $('#embedarea iframe').attr('src', $('iframe').attr('src'));
            $("#videoarea").attr({
                "src": $(this).attr("movieurl"),
                "poster": "",
                "autoplay": "autoplay"
            })

        }
        else if(typee==2)
        {
            $("#videoarea").hide();
            $("#embedarea").show();
            $("#embedarea").html($(this).attr("movieurl"));

        }

      })
      var global_type = $(".regular img").eq(0).attr("type");
      if(global_type==1)
      {
          $("#videoarea").show();
            $("#embedarea").hide();
             $('#embedarea iframe').attr('src', $('iframe').attr('src'));
           $("#videoarea").attr({
            "src": $(".regular img").eq(0).attr("movieurl"),
            "poster": $(".regular img").eq(0).attr("moviesposter")
        })
      }
      else if(global_type==2)
      {
        $("#videoarea").hide();
        $("#embedarea").show();
        $("#embedarea").html($(".regular img").eq(0).attr("movieurl"));
        
      }
     
      
    });
</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="{{asset('assets/js/datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/common.js')}}"></script>

<script type="text/javascript">
 $( function() {
    $( ".datepicker" ).datepicker({
  dateFormat: "dd.mm.yy"
});
    $('.btimepicker').timepicker({
       'timeFormat': 'H:i',
        'minTime': '6:00am',
        'maxTime': '10:00pm'
    });

  });
                    
	// Wait for window load
	$(document).ready(function () {
		// Animate loader off screen
		//$(".se-pre-con").show();
		//$(".se-pre-con").hide();
	});
  </script>
    <script>
        $(document).ready(function(){
            $(".navbar-hd a").click(function(){
                $(".navlist").toggleClass("showmenu");
            });
        });
        var v_lat = 46.81; var v_lng = 8.22; 
            
        <?php
        if(isset($regionalpages) && !empty($regionalpages)){ ?>
            var place = '<?php echo $regionalpages->page_slug;?>'; 
            var v_lat = <?php echo round((float) $regionalpages->latittide , 2);?>;
            var v_lng = <?php echo round((float) $regionalpages->longitude , 2);?>;
            var locations = <?php echo json_encode($locations);?>;
            if(locations == ""){
                locations = [[place, v_lat, v_lng, 1]];
            }    
<?php } ?>
    </script>

    
     
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/rating.js')}}"></script> 
 <script type="text/javascript" src="{{asset('assets/js/regionalmarketlist.js')}}"></script>

 <script src="{{asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
  
<script>
$(document).ready(function () {
    $('#subscribe-news-form').validate({
            rules: {
                subscribe_email: {required: true,email:true},
            },
            messages: {
                subscribe_email:{
                    required:"Please enter email.",
                    email: "Please enter valid email.",
                },
            },
            submitHandler: function (form) {
				subscribe_email = $('#subscribe_email').val();
				$.ajax({
					type: 'POST',
					url: '{{route("subscribe-newsletter")}}',
					data: {_token: '<?php echo csrf_token() ?>', subscribe_email: subscribe_email},
					success: function (res) {
						if (res.status == '200')
						{
							alert(res.msg);
							$('#subscribe_email').val('');
						}
						else if(res.status == '400') {
							alert(res.msg);
						}
						else {
							alert('Some error occurred. Please try again later.');
						}
					}
				});
            }
        });
    });
	</script>

 <script type="text/javascript">
    

   function ajaxCall() {

    this.send = function(data, url, method, success, type) {
        type = type || 'json';
        var successRes = function(data) {
            success(data);
        }
        var errorRes = function(e) {
            console.log(e);
           // alert("Error found \nError Code: " + e.status + " \nError Message: " + e.statusText);
        }
        $.ajax({
            url: url,
            type: method,
            data: data,
            success: successRes,
            error: errorRes,
            dataType: type,
            timeout: 60000
        });
    }
}

function locationInfo() {
    var rootUrl = "country";
    var call = new ajaxCall();
    this.getCities = function(id) {
        var oldFormDatacity = {
  city: "{{ old('city') }}",
  //...
}
 console.log(oldFormDatacity);
        $(".cities option:gt(0)").remove();
        var url ='../city/'+id;
        var method = "post";
        var data = {};
        $('.cities').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            $('.cities').find("option:eq(0)").html("Select City");
            //console.log(data.result);
            if (data.result.length > 1) {
                $.each(data.result, function(key, val) {
                    var option = $('<option />');
                    option.attr('value', val.id).text(val.city_name);
                    $('.cities').append(option);
                    if(oldFormDatacity.city!=""){
$(".cities").val(oldFormDatacity.city).find("option[value=" + oldFormDatacity.city +"]").attr('selected', true);

}
  
                });
                $(".cities").prop("disabled", false);
            } else {
               // alert(data.msg);
            }
        });
    };
    this.getStates = function(id) {
        // alert({{ old('streetno') }});
        var oldFormData = {
  state: "{{ old('state') }}",
  //...
}
         console.log(oldFormData);
        $(".states option:gt(0)").remove();
        $(".cities option:gt(0)").remove();
        var url ='state/'+id;
        var method = "post";
        var data = {};
        $('.states').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            console.log(data.result);
            $('.states').find("option:eq(0)").html("Select State");
            if (data.result.length > 0) {
         
                $.each(data.result, function(key, val) {
                    
                    var option = $('<option />');

                    option.attr('value', val.id).text(val.name);
                    $('.states').append(option);
if(oldFormData.state!=""){
$(".states").val(oldFormData.state).find("option[value=" + oldFormData.state +"]").attr('selected', true);

}
                    
                });
                if(oldFormData.state!=""){
                var loc = new locationInfo();
loc.getCities(oldFormData.state);
}
                $(".states").prop("disabled", false);
            } else {
                //alert(data.msg);
            }
        });
    };
    this.getCountries = function() {
   
        var url = 'country';
        var method = "get";
        var data = {};
        $('.countries').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            $('.countries').find("option:eq(0)").html("Select Country");
            console.log(data);
            if (data.result.length > 0) {
                $.each(data['result'], function(key, val) {
                   console.log("ammar");
                  console.log(val.id);
                    var option = $('<option />');
                    option.attr('value', val.id).text(val.name);
                    $('.countries').append(option);
                });
                $(".countries").prop("disabled", false);
            } else {
                //alert(data.msg);
            }
        });
    };
}
$(function() {


    /** BOF Atul Sharma Jan 02, 2018 Code to show scroller */

        $(window).on("load",function(){
            
            /* all available option parameters with their default values */
            $(".contentCustomScroller").mCustomScrollbar({
                setWidth:false,
                setHeight:false,
                setTop:0,
                setLeft:0,
                axis:"y",
                scrollbarPosition:"inside",
                scrollInertia:950,
                autoDraggerLength:true,
                autoHideScrollbar:false,
                autoExpandScrollbar:false,
                alwaysShowScrollbar:0,
                snapAmount:null,
                snapOffset:0,
                mouseWheel:{
                    enable:true,
                    scrollAmount:"auto",
                    axis:"y",
                    preventDefault:false,
                    deltaFactor:"auto",
                    normalizeDelta:false,
                    invert:false,
                    disableOver:["select","option","keygen","datalist","textarea"]
                },
                scrollButtons:{
                    enable:false,
                    scrollType:"stepless",
                    scrollAmount:"auto"
                },
                keyboard:{
                    enable:true,
                    scrollType:"stepless",
                    scrollAmount:"auto"
                },
                contentTouchScroll:25,
                advanced:{
                    autoExpandHorizontalScroll:false,
                    autoScrollOnFocus:"input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",
                    updateOnContentResize:true,
                    updateOnImageLoad:true,
                    updateOnSelectorChange:false,
                    releaseDraggableSelectors:false
                },
                theme:"light",
                callbacks:{
                    onInit:false,
                    onScrollStart:false,
                    onScroll:false,
                    onTotalScroll:false,
                    onTotalScrollBack:false,
                    whileScrolling:false,
                    onTotalScrollOffset:0,
                    onTotalScrollBackOffset:0,
                    alwaysTriggerOffsets:true,
                    onOverflowY:false,
                    onOverflowX:false,
                    onOverflowYNone:false,
                    onOverflowXNone:false
                },
                live:false,
                liveSelector:null
            });
        });

    /** EOF Atul Sharma Jan 02, 2018 */
    var loc = new locationInfo();
    var cid='212';
     loc.getStates(cid);
    $(".countries").on("change", function(ev) {
     
        var countryId = $(this).val()
        if (countryId != '') {
            loc.getStates(countryId);
        } else {
            $(".states option:gt(0)").remove();
        }
    });
    $(".states").on("change", function(ev) {
        console.log($(this).val());
        var stateId = $(this).val();
      
        if (stateId != '') {
            loc.getCities(stateId);
        } else {
            $(".cities option:gt(0)").remove();
        }
    });

        // BOF Atul Dec 17 -- New code 

        $("#market_state").on("change", function(ev) { 
            var stateId = $(this).val();
            
            var cityContent = new Array();
            $.ajax({
                type: "POST",
                url : '/city/'+stateId,
                success: function (data) {
                    if (data.result.length > 1) {
                        $.each(data.result, function(key, val) {
                            cityContent.push(val.city_name);
                        });
                        $( "#market_city" ).autocomplete({
                            //source: cityContent

                            // source: function (request, response) {
                            //     var matches = $.map(cityContent, function (cityItem) {
                            //         if (cityItem.toUpperCase().indexOf(request.term.toUpperCase()) === 0) {
                            //             return cityItem;
                            //         }
                            //     });
                            //     response(matches);
                            // }

                            source: function(req, responseFn) {
                                var re = $.ui.autocomplete.escapeRegex(req.term);
                                var matcher = new RegExp( "^" + re, "i" );
                                var a = $.grep( cityContent, function(item,index){
                                    return matcher.test(item);
                                });
                                responseFn( a );
                            }
                            
                            
                        });
                    }
                }
            });
        });
        

        
        // EOF -- New code

        
});

     $(function ()
        {
            $('.rating').rating();

            $('.ratingEvent').rating({ rateEnd: function (v) { 

                $('#result').val(v);

             } });
        });
</script>
<script>
    $("#f").fadeOut(1800);
</script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyCJE_DiC6GkeiZGHPQumGDtQkAHjgc6v98" type="text/javascript"></script>
<script type="text/javascript">
    // to assign php array to javascript variable
    console.log(locations);

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(v_lat, v_lng),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>
  
 <script>
    $(document).ready(function(){
        $('body,html').animate({
            scrollTop: 0
        }, 800);
    $('.backtotop').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
}); 
</script>
</body>
</html>