<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Veloh</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet"> 
 <link rel="stylesheet" href="{{asset('assets/css/master.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/media.css')}}">
<link rel="stylesheet" href="{{asset('assets/fontawesome/css/font-awesome.min.css')}}">

</head>
<body >
    <div class="container">
       <div class="login-bg">
       </div>
        <div class="login-wrp">
            <div class="login-content signup-thm">
                <div class="login-head">
                    <h4></h4>
                    <div class="login-avt">
                        <img src="{{asset('assets/img/useravat.jpg')}}">
                    </div>
                </div>
                  <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                <div class="login-int">
                    <div  class="row-block input-wrap" >
                        <div class="row-bx">
                            <div class="col-6 pd-lt-rt-15 {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="lbl-ipt">Name </label>
                               
                                 <input id="name" type="text" class="input-control" name="name" value="{{ old('name') }}" autofocus>
                                  @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-6 pd-lt-rt-15 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="lbl-ipt">Email </label>
                                <input id="email" type="text" class="input-control" name="email" value="{{ old('email') }}" autofocus>
                                  @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>    
                    <div class="row-block input-wrap">
                        <div class="row-bx">
                             <div class="col-6 pd-lt-rt-15 {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="lbl-ipt">Password </label>
                                <input id="password" type="password" class="input-control" name="password" value="{{ old('email') }}" autofocus>
                                  @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-6 pd-lt-rt-15">
                                <label class="lbl-ipt">Confirm Password </label>
                                <input id="password-confirm" type="password" name="password_confirmation" class="input-control" placeholder="">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row-block input-wrap">
                        <div class="row-bx">
                            <div class="col-6 pd-lt-rt-15">
                                <label class="lbl-ipt">City </label>
                                <select name="city" class="input-control cities" id="cityId" required="required">
<option value="">Select City</option>
</select>
                                
                               
                            </div>
                            <div class="col-6 pd-lt-rt-15">
                                <label class="lbl-ipt">State </label>
                                <select name="state" class="input-control states" id="stateId" required="required">
<option value="">Select State</option>
</select>
                                
                               
                            </div>
                        </div>
                    </div> 
                    
                    
                   <div class="row-block input-wrap">
                        <div class="row-bx">
                            <div class="col-6 pd-lt-rt-15">
                                <label class="lbl-ipt">Country </label>
                                <select name="country" class="input-control countries" id="countryId" required="required">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $countrie)
                                    <option value="{{$countrie->country_id}}">{{$countrie->name}}</option>
                                    @endforeach

                                    </select>
                                
                               
                            </div>
                            <div class="col-6 pd-lt-rt-15">
                                <label class="lbl-ipt">Street </label>
                                <input name="street" type="text" class="input-control" placeholder="">
                            </div>
                        </div>
                    </div> 
                   
                   <div class="row-block input-wrap">
                        <div class="row-bx">
                            <div class="col-6 pd-lt-rt-15 {{ $errors->has('postcode') ? ' has-error' : '' }}">
                                <label class="lbl-ipt">Password </label>
                                <input id="postcode" type="" class="input-control" name="postcode" value="{{ old('postcode') }}" autofocus>
                                  @if ($errors->has('postcod'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('postcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                             <div class="col-6 pd-lt-rt-15 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="lbl-ipt">Phone </label>
                                <input id="phone" type="" class="input-control" name="phone" value="{{ old('phone') }}" autofocus>
                                  @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div> 
                   <div  class="input-wrap {{ $errors->has('website') ? ' has-error' : '' }}">
                        <label class="lbl-ipt">Website </label>
                        <input name="website" type="text" class="input-control" placeholder="" value="{{ old('website') }}">
                         @if ($errors->has('website'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('website') }}</strong>
                                    </span>
                                @endif
                    </div>
                    <div class="input-wrap {{ $errors->has('addinfo') ? ' has-error' : '' }}">
                        <label class="lbl-ipt">Additional info </label>
                        <textarea name="addinfo" class="input-control" placeholder=""></textarea>
                         @if ($errors->has('addinfo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('addinfo') }}</strong>
                                    </span>
                                @endif
                    </div>
                    
                    
                    <input type="submit" value="Sign up" class="bttn bttn-sbmt lg-btn">
                   
                    <p class="dntacnt">Don't have account Sign up <a href="{{ route('login') }}">Login</a> </p>
                </div>
            </form>
            </div>
        </div>
       
         
                   
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script>
        $(document).ready(function(){
            $(".navbar-hd a").click(function(){
                $(".navlist").toggleClass("showmenu");
            });
        });
    </script>
    <script>
    function ajaxCall() {
    this.send = function(data, url, method, success, type) {
        type = type || 'json';
        var successRes = function(data) {
            success(data);
        }
        var errorRes = function(e) {
            console.log(e);
            alert("Error found \nError Code: " + e.status + " \nError Message: " + e.statusText);
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
        $(".cities option:gt(0)").remove();
        var url ='city/'+id;
        var method = "post";
        var data = {};
        $('.cities').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            $('.cities').find("option:eq(0)").html("Select City");
            if (data.result.length == 1) {
                $.each(data['result'], function(key, val) {
                    var option = $('<option />');
                    option.attr('value', val.town_id).text(val.town_title);
                    $('.cities').append(option);
                });
                $(".cities").prop("disabled", false);
            } else {
                alert(data.msg);
            }
        });
    };
    this.getStates = function(id) {
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
                    console.log(key);
                    console.log(val.state_name); 
                    var option = $('<option />');
                    option.attr('value', val.state_id).text(val.state_name);
                    $('.states').append(option);
                });
                $(".states").prop("disabled", false);
            } else {
                alert(data.msg);
            }
        });
    };
    this.getCountries = function() {
        var url = rootUrl + '?type=getCountries';
        var method = "get";
        var data = {};
        $('.countries').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            $('.countries').find("option:eq(0)").html("Select Country");
            console.log(data);
            if (data.tp == 1) {
                $.each(data['result'], function(key, val) {
                    var option = $('<option />');
                    option.attr('value', key).text(val);
                    $('.countries').append(option);
                });
                $(".countries").prop("disabled", false);
            } else {
                alert(data.msg);
            }
        });
    };
}
$(function() {
    var loc = new locationInfo();
    
    $(".countries").on("change", function(ev) {
        var countryId = $(this).val()
        if (countryId != '') {
            loc.getStates(countryId);
        } else {
            $(".states option:gt(0)").remove();
        }
    });
    $(".states").on("change", function(ev) {
        var stateId = $(this).val()
        if (stateId != '') {
            loc.getCities(stateId);
        } else {
            $(".cities option:gt(0)").remove();
        }
    });
});
</script>
</body>
</html>
