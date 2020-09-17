@extends('layout.backened.header')
@section('content')
<div class="clearfix"></div>
 <div class="section minheight" >
  <div class="container"> 
             <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="paddingbottom10px"><h3>@if(@$data->_id){{'Update'}} @else {{'Add'}} @endif Group</h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
        <li><a href="">{{_i('Group')}}</a></li>
        <li class="active">@if(@$data->_id){{'Update'}} @else {{'Add'}} @endif {{_i('Group')}}</li>
      </ol>
    </section>

    <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style> 

    <div class="row">
        <div class="col-md-10">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              @if(Session::has('add_message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('add_message') !!} 
                </div>
                @endif
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="" id="group-form" action="{{route('admin-add-group')}}" method="POST" enctype="multipart/form-data">
             {{ csrf_field() }}
         
              <div class="box-body">
              <input type="hidden" name="id" value="{{old('id',@$data->id)}}">
              <div class="form-group row @if($errors->first('name')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">  Name{{redstar()}}</label>
                  <div class="col-sm-10">
                      <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{old('name',@$data->name)}}">
                      <input type="hidden" name="module_id" value="{{@$module_id}}">
                    <?php if(@$errors->first('name')) { ?><span class="help-block">{{@$errors->first('name')}}</span> <?php } ?>
                  </div>
                </div>
                 @if(empty($account_to_group_id)) 
                 <div class="form-group row @if($errors->first('account')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Select Account {{redstar()}}</label>
                  <div class="col-sm-10">
                    <select name="account" class="form-control account" id="account" {{$disable}}>
                        <option value="">Select{{$account_to_group_id}}</option>
                        @foreach($account_list as $row)
                         @if($account_to_group_id == $row->id)  @endif
                           <option @if(  $row->id == $account_to_group_id) {{'selected'}} @endif value="{{ $row->id}}">{{$row->name}} </option>
                        @endforeach
                    </select>

                    <?php if(@$errors->first('account')) { ?><span class="help-block">{{@$errors->first('account')}}</span> <?php } ?>
                  </div>
                </div>
                @else
                <div class="form-group row @if($errors->first('users')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Select Account {{redstar()}}</label>
                  <div class="col-sm-10">
                  <input name="account" class="form-control account" id="account" value="{{$account_to_group_id}}" type="hidden" />{{$account_to_group_name}}
                  </div>
                </div>
                @endif
               
                <div class="form-group row @if($errors->first('users')) {{' has-error has-feedback'}} @endif " style="display:{{$actionType}};">
                  <label for="inputError" class="col-sm-2 control-label"> Select Users {{redstar()}}</label>
                  <div class="col-sm-10">
                    <select name="users[]" class="form-control" id="users" multiple=""  @if($request->session()->get('user_role_id')>3) disabled="" @endif>
                        <option value="">Select User</option>
                        @foreach($users as $row)
                           <option @if(in_array($row->id, $userIds) ) {{'selected'}} @endif value="{{$row->id}}">{{_i($row->first_name)}} {{_i($row->last_name)}}</option>
                        @endforeach
                    </select>

                    <?php if(@$errors->first('users')) { ?><span class="help-block">{{@$errors->first('users')}}</span> <?php } ?>
                  </div>
                </div>
                <div class="form-group row @if($errors->first('task_assigned')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-2 control-label">{{_i('Time Zone')}}</label>
                    <?php $editzone = 'America/New_York'; if(!empty($data) && ($data->userGroup->count()>0) ){ $editzone = $data->userGroup[0]->zone; }  ?>
                    <div class="col-sm-10">
                        <select name="zone" class="form-control" id="zone">
                        @if(count($zones)>0)
                        @foreach($zones as $row) 
                        <?php  $selectedClass = ($row == $editzone)?'selected':'';  ?>   
                        <option value="<?php echo $row; ?>" <?php echo $selectedClass; ?>><?php echo $row; ?></option>
                        @endforeach
                        @endif
                        </select>
                  </div>
                </div>
                <div class="form-group row @if($errors->first('location')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-2 control-label">Location {{redstar()}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="location" id="location"  readonly class="form-control" placeholder="Location with zipcode" value="{{old('name',@$data->location)}}">
                  </div>
                  <div class="col-sm-2">
                      <a href="javascript:void(0);" class="btn btn-primary btn-info-graph locationfromgraph" Title="Location from Graph">Open Map</a>  
                      </div>
                </div>
                <div class="form-group row @if($errors->first('location')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-2 control-label">Geo Co-ordinate {{redstar()}}</label>
                    @php $lati =  '40.37910751971025'; $longi = '-102.261480075'; $smalllocation = 'United States'; @endphp   

                     <?php $latLongArray = array('latitude'=>$lati,'longitude'=>$longi);?>
                     <?php  if( empty(@$data) ) { @$data->latitude = $lati; }  ?>
                     <?php  if( !empty(@$data->latitude) ) { $lati = $data->latitude; }  ?>
                     <?php  if( !empty(@$data->longitude) ) { $longi = $data->longitude; }  ?>
                      <div class="col-sm-5">
                     <input type="text" name="latitude" id="latitude" readonly = "true" value="{{old('name',@$lati)}}" readonly class="form-control small" placeholder="Latitude"><span><i>Latitude</i></span> 
                     </div>                 
                     <div class="col-sm-5">
                     <input type="text" name="longitude" id="longitude" readonly = "true" value="{{old('name',@$longi)}}" readonly class="form-control" placeholder="Longitude"><span><i>Longitude</i></span>                   
                     <input type="hidden" name="place_id" id="place_id" value="-102.261480075" >   
                     </div> 
                </div>
              </div>
              <div id="map_canvas"></div>  
                <div style="height:530px;display:none; padding-bottom: 20px;" class="mapdiv"> 
        <center><p class="error"><i><strong>Note:</strong> You will now be able to drag the marker to the correct position. This is done by placing your cursor over the red marker, left click and hold the mouse button down. This captures the marker and allows you to move it to the right position on the map. Once you are happy with its new position release the left button.  </i></p></center>
                    <div class="pac-card" id="pac-card">
                        <div>
                            <div id="titlemap"> Autocomplete search <span><input type="submit" id="add-button-map" value="Submit" class="btn btn-info submitmap-but"><button type="button" class="close btn btn-info" data-dismiss="modal" title="Click to Close Map" aria-hidden="true">&times;</button></span></div>
                            <div id="type-selector" class="pac-controls" style="display:none;">
                                <input type="radio" name="type1 " class="form-control" id="changetype-all" checked="checked">
                            </div>
                        </div>
                      <div id="pac-container"><input id="pac-input" type="text" class="form-control" placeholder="Enter a location" value="{{old('name',@$data->location)}}"> </div>
                    </div>
                    <div id="map"></div>
                    <div id="infowindow-content">
                      <img src="" width="16" height="16" id="place-icon">
                      <span id="place-name"  class="title"></span><br>
                      <span id="place-address"></span>                      
                    </div>
            </div>



              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-groups')}}" class="btn btn-default">Cancel</a>
                <input  id="add-video" type="submit" value="Submit" class="btn btn-info">
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          
        </div>
        <!--/.col (right) -->
        </div>
  </div>
</div>

  <script>
  $(".locationfromgraph").click(function(){
    $(".mapdiv").toggle();
  });
  $(".close").click(function(){
    $(".mapdiv").hide();
  });

    var map;
    var marker;
    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();
    function initMap() {

        var latlng2 = new google.maps.LatLng("<?php echo $lati;?>","<?php echo $longi; ?>");
        var myOptions2 =  {
            zoom: 12,
            center: latlng2,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map2 = new google.maps.Map(document.getElementById("map_canvas"), myOptions2);

        var myMarker2 = new google.maps.Marker(
        {
            position: latlng2,
            map: map2,
            title:"<?php echo $smalllocation;?>"
        });

        var longitude = $("#longitude").val();
        var latitude  = $("#latitude").val();
        var myLatlng = new google.maps.LatLng(latitude,longitude);
          var mapOptions = {
                      zoom: 6,
                      center: myLatlng,
                      mapTypeId: google.maps.MapTypeId.ROADMAP,
                      draggable: true
          };
          map = new google.maps.Map(document.getElementById("map"), mapOptions);
          var card = document.getElementById('pac-card');
          var input = document.getElementById('pac-input');
          var types = document.getElementById('type-selector');
          var strictBounds = document.getElementById('strict-bounds-selector');
          map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
          var autocomplete = new google.maps.places.Autocomplete(input);

            // Bind the map's bounds (viewport) property to the autocomplete object,
            // so that the autocomplete requests use the current map bounds for the
            // bounds option in the request.
          autocomplete.bindTo('bounds', map);

      // Set the data fields to return when the user selects a place.
          autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

          var infowindow = new google.maps.InfoWindow();
          var infowindowContent = document.getElementById('infowindow-content');
          infowindow.setContent(infowindowContent);
          var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            position: myLatlng,
            draggable: true 
          });
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': myLatlng }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              $('#latitude,#longitude').show();
              $('#location').val(results[0].formatted_address);
              $('#latitude').val(marker.getPosition().lat());
              $('#longitude').val(marker.getPosition().lng());
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
              }
            }
        });
        google.maps.event.addListener(marker, 'dragend', function() {
            geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#location').val(results[0].formatted_address);
                    $('#latitude').val(marker.getPosition().lat());
                    $('#longitude').val(marker.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                }
                }
            });
      });

      autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
          // User entered the name of a Place that was not suggested and
          // pressed the Enter key, or the Place Details request failed.
          window.alert("No details available for input: '" + place.name + "'");
          return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
          map.fitBounds(place.geometry.viewport);
        } else {
          map.setCenter(place.geometry.location);
          map.setZoom(17);  // Why 17? Because it looks good.
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        var address = '';
        if (place.address_components) {
          address = [
            (place.address_components[0] && place.address_components[0].short_name || ''),
            (place.address_components[1] && place.address_components[1].short_name || ''),
            (place.address_components[2] && place.address_components[2].short_name || '')
          ].join(' ');
        }

        infowindowContent.children['place-icon'].src = place.icon;
        infowindowContent.children['place-name'].textContent = place.name;
        infowindowContent.children['place-address'].textContent = address;
        infowindow.open(map, marker);
      });

      // Sets a listener on a radio button to change the filter type on Places
      // Autocomplete.
      function setupClickListener(id, types) {
        var radioButton = document.getElementById(id);
        radioButton.addEventListener('click', function() {
          autocomplete.setTypes(types);
        });
      }

    
    }

    $('#pac-input').keypress(function(event) {
    if (event.keyCode == 13) {
       event.preventDefault();
       return false;
    }
  });
  </script>
                  
<script type="text/javascript">google.maps.event.addDomListener(window, 'load', initialize);</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2H-kU8WBtolE7HScebuNUwRGQgBaHHCI&libraries=places&callback=initMap" async defer></script>

                  
   <script src="{{asset('js/customFormValidationRules.js')}}"></script>
<script>
 $( document ).ready(function() {
      $('#group-form').validate({
            ignore: ".ignore",
            rules: {
              name: {
                required:true,
                    alphanumspace:true,
                },
                location: {
                required:true,
                    alphanumspace:true,
                },
                'account':'required',
            },
            // Specify validation error messages
            messages: {
                name:
                {
                    required:"Please enter name.",
                    alphanumspace:"Please enter valid letters."
                },
               'account':'Please select account Name.',
            },
        });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".account").click(function(e){
          e.preventDefault();
          var account = $("select[name=account]").val();
          var groupId = $("input[name=id]").val();
          $.ajax({
          type:'POST',
          url:"{{ route('admin-list-all-users-account') }}",
          data:{account:account,groupId:groupId},
          success:function(data){
            $('#users').html(data);
          }
          });

    });
</script>               
  @endsection
  
  
  