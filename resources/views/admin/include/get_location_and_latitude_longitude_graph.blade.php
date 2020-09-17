<style type="text/css">
    .modal-footer {
    padding: 5px;
    text-align: right;
    border-top: 1px solid #e5e5e5;
    margin-top: 5px;
}
.modal-header {
    padding: 5px 13px 0px 22px;
    border-bottom: 1px solid #e5e5e5;
}
</style>
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="add-sector-title" aria-hidden="true">
    <div class="modal-dialog"  style="width: 90% !important; margin: 30px auto;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Set Incident Location </h4>
            </div>
        <div id="myMap"></div><br>
            <div class="form-group" style="margin-bottom: 10px;">
                    <div class="col-sm-12">                              
                        <input id="address" type="text" class="form-control" style="width:100%;" readonly />
                    </div>
                     <!-- <div class="col-sm-3">                              
                        <input type="text" id="latitude_" class="form-control" placeholder="Latitude"/>
                    </div>
                      <div class="col-sm-3">                              
                            <input type="text" id="longitude_" class="form-control" placeholder="Longitude"/>
                      </div>  -->
            </div>
            <br>
        <div>
        </div>
        <style>
        #myMap {
        height: 350px;
        width: 100%px;
        }
        </style>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyC2H-kU8WBtolE7HScebuNUwRGQgBaHHCI"></script>
        <script type="text/javascript"> 
        var map;
        var marker;
        var myLatlng = new google.maps.LatLng(42.015822027880674,-105.40103019811954);
        var myLatlng = new google.maps.LatLng("<?php echo $latLongArray['latitude'];?>","<?php echo $latLongArray['longitude'];?>");
        var geocoder = new google.maps.Geocoder();
        var infowindow = new google.maps.InfoWindow();
        function initialize(){
        var mapOptions = {
        zoom: 4,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("myMap"), mapOptions);

        marker = new google.maps.Marker({
        map: map,
        position: myLatlng,
        draggable: true 
        }); 

        geocoder.geocode({'latLng': myLatlng }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
        $('#latitude,#longitude').show();
        $('#address').val(results[0].formatted_address);
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
        $('#address').val(results[0].formatted_address);
        $('#location').val(results[0].formatted_address);
        $('#latitude').val(marker.getPosition().lat());
        $('#longitude').val(marker.getPosition().lng());
        infowindow.setContent(results[0].formatted_address);
        infowindow.open(map, marker);
        }
        }
        });
        });

        }
        google.maps.event.addDomListener(window, 'load', initialize);
        </script>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div> 