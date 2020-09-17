<!DOCTYPE html>
<html lang="fr">
   <head>
       <title>Digital Kheops: inscription</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css?family=Oregano" rel="stylesheet" type="text/css" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="{{asset('assets/js/outils.js')}}"></script>

       <link rel="stylesheet" href="{{asset('css/common.css')}}">

     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" http-equiv="X-UA-Compatible" />
<style>
         body {
         }
         p{
         padding-bottom:12px;
         }
         #myHeader{
         background-color: #d15c5c;
         height: 220px;
         padding-top:30px;
         padding-bottom:30px;
         color: white;
         text-align:center;
         font-size:36px;
         font-family:Oregano;
         }
         #myPresentation {
         width: 100%;
         margin: auto;
         text-align: justify;
         background: url('https://learnybox.com/images/images/wallpapers/dscf7616.jpg');
         color:white;
         }
         #first {
         background-color: inherit;
         width:450px;
         float: left;
         padding-left:120px;
         }
         #second {
         background-color: inherit;
         width:840px;
         float: right;
         padding-right:100px;
         }
         .listItem{
         font-family:Arial;color:#ffffff;padding-bottom:10px;
         padding-left:15px;
         }
         .listItem span{
         padding-left:5px;
         font-size:14px;
         color:white;
         }
         .xlarge {
         padding-top:18px;
         padding-bottom:18px;
         font-size: 24px;
         border: 1px solid white;
         }
         .title{
         font-weight:700;
         color:#707070;
         }
         .reviews{
         padding-left:120px;
         padding-right:120px;
         padding-top:36px;
         padding-bottom:36px;
         }
         .review{
         padding-top:12px;
         font-size:18px;
         color:#A9A9A9;
         text-align: justify;
         }
         .reviewer{
         font-weight: bold;
         font-size:18px;
         color:#3f4b59;
         }
         .containerGrisFonce{
         width:100%;
         background-color:#3f4b59;
         padding-top:48px;
         padding-bottom:36px;
         padding-left:120px;
         color:white;
         padding-right:120px;
         }
         .containerGris{
         width:100%;
         background-color:#e1e0d1;
         padding-top:48px;
         padding-bottom:48px;
         padding-left:120px;
         padding-right:120px;
         }
         .container{
         padding-top:36px;
         padding-bottom:36px;
         }
         footer{position: relative !important; }
      </style>
   </head>
   <body>
    
    @if (session('add_message'))
    <div class="lgn-success">
        <h3>{{session('add_message')}}</h3>
    </div>
    @endif
    
     
        <!-- /HEADER -->
        <!-- CONTENT -->
			
        @yield('content')
        @include('layout.frontend.vsldk_footer')
 </body>
 <script  type="text/javascript" charset="utf-8">
            function getValue(varname) {
                var url = window.location.href;
                var qparts = url.split("?");
                if (qparts.length <= 1) {
                    return "";
                }
                var query = qparts[1];
                var vars = query.split("&");
                var value = "";
                for ( i = 0; i < vars.length; i++) {
                    var parts = vars[i].split("=");
                    if (parts[0] == varname) {
                        value = parts[1];
                        break;
                    }
                }
                value = decodeURIComponent(value);
                //value = unescape(value);
                value.replace(/\+/g, " ");

                return value;
            }





    </script>
    <script type="text/javascript">
  $(document).ready(function() {
    $("#payments").submit(function() {
        $(this).submit(function() {
            return false;
        });
        return true;
        });



          
        });
</script>
</html>





