@extends('layout.backened.header')
@section('content')

<!-- START Datatable --> 
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<!-- END Datatable -->
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">

<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/maps/modules/map.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!-- <script src="js/jquery.js"></script> -->
<!-- Start Datatable -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<!-- End Datatable -->
<!-- <script src="js/bootstrap.min.js"></script> -->


  <div class="clearfix"></div>
 <div class="section" >
	<div class="container">

    <!-- Content Header (Page header) -->
    
    <section class="content-header">
      <h1><?php echo $data['caseList']->title; ?></h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Target Chart</li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
   
   
        <div class="row">
            <div class="col-md-12 col-sm-3">
               <a href="javascript:history.back();"> 
                <button type="button" class="btn btn-info">Back</button></a>
              <div id="container"></div>
               
            </div>
            
        </div>
       
       
      </div>
  </div>




<!-- Trigger the modal with a button -->
        <button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display:none;">Open Modal</button>


 <!-- Modal HTML -->
    <div class="modal" id="add-sector" tabindex="-1" role="dialog" aria-labelledby="add-sector-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add New Sector</h4>
                </div>
                <form role="form" name="addSectorForm" id="addSectorForm" method="post">
                <div class="modal-body">
                    <div class="form-group">
              Sector Name: 
              <input id="sector_name" name="sector_name" type="text">
            <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
            <input type="hidden" name="case_id" id="modalCaseId" value="<?php echo $data['caseList']->id; ?>">
              <!-- <p class="help-block">Files up to 5Mb only.</p> -->
            </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveSector">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>


<div id="sectorDetails">
    
</div> 
<style>
    .error{
        color:red;
    }
</style>


<script>
   var tokenval = $('meta[name="csrf-token"]').attr('content');
   $('#token').val(tokenval);

    $(document).ready(function() {
    
    $('#sectortbl').DataTable();
     } );
      
    var AddDbclk = 0;
    </script>

<script src="{{asset('js/script.js')}}"></script>
<script>
  
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}


function set_sector(id, sector_name){
   
    $('#Sector').val(id);
    $('.dropbtn').html(sector_name);
    

}

/* New code By Subhendu 15-05-2018 */
  $(document).ready(function(){
  var site_url = 'http://localhost/tatapp/public/admin/';
$('#myModal').on('hidden.bs.modal', function () {
 location.reload();
})

    $('#addBt').on('click', function(){
              
                    AddDbclk = 0;
                    var case_id = $('#modalCaseId').val();
                    //formatModal();
                    open_factor_modal(0, case_id);
                    $('#Rank').val(10);
                    //$('#SectorDiv').hide();
                    $('#deleteFactor').hide();
                
            });

    });
</script>
<?php
$visibleSector = $data['getAllVisibleSectorByCaseId'];
$visibleFactor = $data['getAllVisibleFactorByCaseId'];

$myJsonString = json_encode($visibleFactor);
$myJsonString = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $myJsonString);
 

$visibleTimeLineDataList = $data['getAllVisibleTimeLineDataByCaseId'];


$myJsonStringForTimeLine = json_encode($visibleTimeLineDataList);
$myJsonStringForTimeLine = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $myJsonStringForTimeLine);

/*echo "<pre>";
print_r($visibleFactor);
echo "</pre>";*/
?>

<script type="text/javascript">

Highcharts.chart('container', {
  mapNavigation: {
    enabled: false
  },
  chart: {
    polar: true,
    height: 900,  
  },
  title: {
    text: ''
  },
  credits: {
    enabled: false
  },
  legend: {
    enabled: false
  },
  pane: {
    startAngle: 45
  },
  xAxis: {
    minRange: 1,
    min: 0,
    max: <?php echo count($visibleSector); ?>,
    lineColor: '#000000',
    gridLineColor: '#000000',
    gridLineWidth: 2.5,
    labels: {
      style: {
        color: '#000000',
        fontWeight: 'bold'
      }
    },
    categories: <?php echo json_encode($visibleSector); ?>
  },
  yAxis: {
    minRange: 1,
    min: 1,
    max: 11,
    tickInterval: 1,
    gridLineColor: '#000000',
    reversed: true,
    labels: {
      x: 0,
      y: -10,
      style: {
        color: '#000000',
        fontWeight: 'bold'
      }
    }
  },
  plotOptions: {
    scatter: {
                marker: {
                     symbol: "url({{asset('images/blue_star_20.png')}})",
                    radius: 1,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    }
                },
                tooltip: {
                    useHTML: true,
                    borderRadius: 0,
                    borderWidth: 1,
                    borderColor: '#5CD0CD',
                    shadow: false,
                    shape: 'square', // default is callout
                    style: {
                    padding: 8
                    },
                    headerFormat: '',
                    pointFormatter: function() {
        //console.log(this);
        if(this.y>8){
         var output = '<div class="area-tooltip">';
        output += '   <div class="area-tooltip-header">';
        output +=  'Multiple Factor lies on the same location.<br>';
        output +=  'Total Cluster Data: ' +this.totalClusterData + '<br>';
        output +=  '<a href="javascript:open_factor_modal('+this.factor_id+','+ this.case_id+');">Click on the star icon</a> for view details.<br>';
        output += '</div>';
        output += '</div>';
        }
        else{
          var output = '<div class="area-tooltip">';
        output += '   <div class="area-tooltip-header">';
        output +=  this.name+'</a></b> <br>Sector Name: ' +this.sector_name+'<br>Rank Id: ' + this.y + '<br>';
        output += '</div>';
        output += '</div>';
        }
        

        return output;
      }
                    

                },
                states: {
                    hover: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                point: {
                    events: {
                        click: function(e) {
                           ondbclick(e, this);
                        }
                    }
                }
            }

  },
  series: [{
    type: 'scatter',
    data: <?php echo $myJsonString; ?>
  }]
});

</script>


<script type="text/javascript">
     // the actual callback for a double-click event
    var ondbclick = function(e, point) {
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxGetFactorDetails')}}",
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    factor_id:point.factor_id,case_id:point.case_id 
                    },
                    success: function (data) {
                        
                    
                    $('#sectorDetails').html(data);
                    $('#modalBt').trigger('click');
                    
                    editSectorDetails(point.factor_id);

                       }
                    });

          function editSectorDetails(factor_id){
        

          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxAssignFactorDetails')}}",
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    factor_id:factor_id
                    },
                    success: function (data) {
 
                    // Parse the data as json
                    var obj = JSON.parse(data)
                   
                    
                    $('#Title').val(obj.title);
                    $('#Description').val(obj.description);
                    $('#Source').val(obj.source);
                    $('#OccurenceDate').val(obj.occurance_date);
                    $('#Rank').val(obj.rank_id);
                    $('#Sector').val(obj.sector_id);
                    $('.factorClass').val(obj.factor_id);
                    $('.dropbtn').html(obj.sector_name);
                    

                    if(obj.target_chart_visibility=="y"){
                        $('#Show_on_Target_Chart').prop( "checked", true);
                    }
                    else{
                        $('#Show_on_Target_Chart').prop( "checked", false);
                    }

                    if(obj.timeline_chart_visibility=="y"){
                        $('#Show_on_timeline').prop( "checked", true);
                    }
                    else{
                        $('#Show_on_timeline').prop( "checked", false);
                    }

                       }
                    });
    
    }


    };



    function open_factor_modal(factor_id, case_id){

          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxGetFactorDetails')}}",
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    factor_id:factor_id,case_id:case_id 
                    },
                    success: function (data) {

                        
                        $('#sectorDetails').html(data);
                        $('#modalBt').trigger('click');
                    

                       }
                    });
    
    }


   

</script>

  @endsection