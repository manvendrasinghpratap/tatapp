<footer class="main-footer">
    <strong>Copyright &copy; {{date('Y')}} </strong> All rights reserved.
    <!--  <div class="pull-right top-rightsec dv-lang-usr" style="margin-right: 2%;">
            <h3>
           
               <ul>
                @foreach(Config::get('laravel-gettext.supported-locales') as $locale)
                    <li>
                        <a href="{{route('lang')}}/{{$locale}}">
                        <?php  
                         $current_language = \Lang::getLocale();
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
        </div> -->
</footer> 

  

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
  <script type="text/javascript" src="{{asset('bootstrap/js/tether.min.js')}}"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('dist/js/moment.js')}}"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<!--<script src="{{asset('plugins/morris/morris.min.js')}}"></script>-->
<!-- Sparkline -->
<!--<script src="{{asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>-->
<!-- jvectormap -->
<!--<script src="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>-->
<!-- jQuery Knob Chart -->
<!--<script src="{{asset('plugins/knob/jquery.knob.js')}}"></script>-->
<!-- daterangepicker -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>-->
<!-- datepicker -->
<!--<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- bootstrap time picker -->
<!--<script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>-->
<!-- Bootstrap WYSIHTML5 -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

<script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('plugins/fastclick/fastclick.js')}}"></script>
<script src="{{asset('dist/js/app.min.js')}}"></script>
<!--<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>-->

<script type="text/javascript" src="{{asset('timepicker/jquery.timepicker.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('timepicker/jquery.timepicker.css')}}" />
	<script type="text/javascript" src="{{asset('timepicker/bootstrap-datepicker.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('timepicker/bootstrap-datepicker.css')}}" />
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script type="text/javascript" src="{{asset('assets/js/datepicker.js')}}"></script>
 <script>
  $(document).ready(function () {
   
    $('.basicExample').timepicker({ 'timeFormat': 'H:i:s' });
       
    });
  </script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{asset('assets/js/select2.min.js')}}"></script> -->
   <script src="{{asset('assets/js/common.js')}}"></script>
  
  </script>
</body>
</html>
    
