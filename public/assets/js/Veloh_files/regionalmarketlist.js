
    function ajaxLoad(filename, content) {
       alert();
        content = typeof content !== 'undefined' ? content : 'content';
       console.log(content);
       if(content=='content'){
filename=filename;
       }else{
        filename=filename+'/'+content;
       }
        $.ajax({
            type: "GET",
            url: filename,
            contentType: false,
            success: function (data) {
               console.log(data);
                $("#content").html(data);
                
            },
            error: function (xhr, status, error) {
             //   alert(xhr.responseText);
            }
        });
    }
     function ajaxSortbyname(filename, content) {
        content = typeof content !== 'undefined' ? content : 'content';
       console.log(content);
       if(content=='content'){
filename=filename;
       }else{
        filename=filename+'/'+content;
       }
        $.ajax({
            type: "GET",
            url: filename,
            contentType: false,
            success: function (data) {
                $("#content").html(data);
                
            },
            error: function (xhr, status, error) {
               // alert(xhr.responseText);
            }
        });
    }
    $(document).ready(function () {
    
      
      //  ajaxLoad('../market/regionallist',26);
        getdata('market/detail');
    });
    function sort(id){
        
        ajaxLoad('market/list',id);
    }
    function sortbyname(){
        $("#marketplace").val();
        
        ajaxSortbyname('market/listbyname',$("#marketplace").val());
    }
    function getdetailregional(id){
        
        getdata('../market/detailregional',id);
    }
 function getdata(filename, content){
     content = typeof content !== 'undefined' ? content : 'content';
       if(content=='content'){
filename=filename;

content="asc";
       }else{
        filename=filename;
       }
       $.ajax({
            type: "POST",
            url: filename,
              data : {
    date : content // will be accessible in $_POST['data1']
  },
            success: function (data) {
                $("#contentdetailregional").html(data);

                
            },
            error: function (xhr, status, error) {
               // alert(xhr.responseText);
            }
        });
    }
   

 
 function initMap() {
        var uluru = {lat: 47.3666700, lng: 8.5500000};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }


