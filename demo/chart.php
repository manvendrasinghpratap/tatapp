<?php
include("db_config.php");
$caseId=1;
$site_url = ($_SERVER['SERVER_NAME'] == "localhost")?'/tatapp/demo/':'/demo/';
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Polar Scatter</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- START Datatable -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<!-- END Datatable -->
<link rel="stylesheet" href="css/style.css">

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

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
<script src="js/bootstrap.min.js"></script>


<script>
    $(document).ready(function() {
    
    $('#sectortbl').DataTable();
     } );
      
    var AddDbclk = 0;
    </script>

<script  src="js/script.js"></script>



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
  var site_url = '<?php echo $site_url; ?>';
$('#myModal').on('hidden.bs.modal', function () {
 location.reload();
})

    $('#addBt').on('click', function(){
              
                    AddDbclk = 0;
                    formatModal();
                    $('#Rank').val(10);
                    //$('#SectorDiv').hide();
                    $('#deleteFactor').hide();
                
            });


    $('#saveBt').on('click', function(){

                    $.ajax({
                    type: "POST",
                    url: site_url+"ajax_save_factor.php",
                    dataType: 'html',
                    data: $("#modalform").serialize(),
                    success: function (html) {
                    //result=html.split('#');
                    $('#ajaxresp').html(html);
                    

                       }
                    });
    });

    $('#deleteFactor').on('click', function(){

           var factor_id = $('.factorClass').val();

                    $.ajax({
                    type: "POST",
                    url: site_url+"ajax_delete_factor.php",
                    dataType: 'html',
                    data: {factor_id:factor_id},
                    success: function (html) {
                    //result=html.split('#');
                    //$('#ajaxresp').html(html);
                    
                    $('#myModal').modal('hide');
                     location.reload();
                       }
                    });
    });


    





    $('#saveSector').on('click', function(){

                    $.ajax({
                    type: "POST",
                    url: site_url+"ajax_save_sector.php",
                    dataType: 'html',
                    data: $("#addSectorForm").serialize(),
                    success: function (html) {
                    //result=html.split('#');
                    $('#myDropdown').html(html);
                    $('#add-sector').modal('hide');

                       }
                    });
    });







    });


  
</script>

</head>
<body>

<div class="row">
  <div class="col-sm-4">&nbsp;</div>
  <div class="col-sm-4">
        <div class="panel panel-default">
        <div class="panel-heading">Manage Factor</div>
        <div class="panel-body"><button type="button" class="btn btn-info btn-lg" id="addBt">Add Factor</button></div>
        </div> 

  </div>
  <div class="col-sm-4">&nbsp;</div>
</div> 


 

<!-- Trigger the modal with a button -->
        <button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>


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




    
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <form name="modalform" id="modalform" method="post" action="">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                <h4 class="modal-title">Manage Factor</h4>
                </div>
               
                <div class="modal-body">
                    <div class="inner-div">
                        <input type="hidden" name="case_id" value="1">
                        <input type="hidden" name="factor_id" class="factorClass" value="">
                        <input type="text" id="Title" name="title" placeholder="Title" style="border:1px solid black;"/><br/><br/>
                        <textarea rows="5" cols="20" type="text" id="Description" name="description" placeholder="Description"/></textarea><br/>
                    </div>
                    <div class="inner-div">
                        <div>
                            Rank:
                            <select id="Rank" name="rank_id">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <br/>
                        
 <div id="SectorDiv">
                            Sector: 
            <input id="Sector" name="sector_id" value="4" type="hidden">

            <div class="dropdown custom_dropdown">
        <span name="sector_id1" onclick="myFunction()" class="dropbtn">Status</span>
          
             <div id="myDropdown" class="dropdown-content">
                <?php 
                $query = "SELECT * FROM `sector` order by sector_name";

                if ($result = $mysqli->query($query)) {

                /* fetch object array */
                while ($row = $result->fetch_assoc()) {
                ?>
                 <a href="#" onclick="return set_sector(<?php echo $row["id"]; ?>,'<?php echo $row["sector_name"]; ?>');"><?php echo $row["sector_name"]; ?></a>
                
                <?php
                }
                /* free result set */
                $result->close();
                }
                /* close connection */
                //$mysqli->close();
                ?>


               <a href="#" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#add-sector">
          <span class="glyphicon glyphicon-plus"></span> Add Sector 
        </a>
            </div>
            </div>


            
                        </div>

                       


                        <br/>
                        Source: <input type="text" id="Source" name="source"/><br/><br/>
                        Occurence Date: <input type="date" id="OccurenceDate" name="occurance_date"/><br/><br/>
                        Show on Target Chart? <input type="checkbox" id="Show_on_Target_Chart" name="target_chart_visibility"/><br/><br/>
                        Show on timeline? <input type="checkbox" id="Show_on_timeline" name="timeline_chart_visibility"/><br/><br/>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="deleteFactor">Delete Factor</button>
                    <button type="button" class="btn btn-primary" id="saveBt">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    <div class="row">
    <div class="col-sm-12" id="ajaxresp">
    <table id="sectortbl" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Sector</th>
                <th>Factor</th>
                <th>Rank</th>
                <th>isVisibility</th>
                <th>occurance date</th>
            </tr>
        </thead>
        <tbody>
             <?php 
               $sectorList = getAllSectorByCaseId($caseId,$mysqli);
               foreach($sectorList as $key=>$row){
                ?>
                 <tr>
                <td><?php echo $row["sector_name"]; ?></td>
                <td><?php echo $row["title"]; ?></td>
                <td><?php echo $row["rank_id"]; ?></td>
                <td><?php echo $row["target_chart_visibility"]; ?></td>
                <td><?php echo $row["occurance_date"]; ?></td>
                
            </tr>
                
                <?php
                }
                
                ?>
           
        </tbody>
       
    </table>
    </div>
</div>
                </div>
        </form>  
    

                </div>
            </div>
        </div>





<div id="container"></div>
<div class="row">
  <div class="col-sm-2">&nbsp;</div>
  <div class="col-sm-8">
        <div class="panel panel-default">
        <div class="panel-heading">Time Line Chart</div>
        <div class="panel-body">
        <div id="timeLineContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
        </div> 

  </div>
  <div class="col-sm-2">&nbsp;</div>
</div> 


<?php
$visibleSector = getAllVisibleSectorByCaseId(1,$mysqli);
$visibleFactor = getAllVisibleFactorByCaseId(1,$mysqli);
/*echo "<pre>";
print_r($visibleFactor);
echo "</pre>";*/
$myJsonString = json_encode($visibleFactor);
$myJsonString = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $myJsonString);
 

$visibleTimeLineDataList = getAllVisibleTimeLineDataByCaseId(1,$mysqli); 

?>

<script type="text/javascript">
Highcharts.chart('container', {
  mapNavigation: {
    enabled: false
  },
  chart: {
    polar: true,
    height: 500,  
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
                    symbol: 'url(https://www.highcharts.com/samples/graphics/sun.png)',
                    radius: 1,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<b></b><br>',
                    pointFormat: '<b><a href="https://www.highcharts.com/samples/graphics/sun.png" target="_blank">{point.name}</a></b> <br>Rank Id: {point.y}'

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
<?php //echo json_encode($visibleTimeLineDataList); ?>
<script type="text/javascript">
  Highcharts.chart('timeLineContainer', {
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Time Line: Rank over time'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                        'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Rank'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
                
            series: [{
                type: 'area',
                name: 'Rank',
                data: <?php echo json_encode($visibleTimeLineDataList); ?>
            }]
        });

</script>
<script type="text/javascript">
     // the actual callback for a double-click event
    var ondbclick = function(e, point) {
          $.ajax({
                    type: "POST",
                    url: "<?php echo $site_url; ?>ajaxGetFactorDetails.php",
                    dataType: 'html',
                    data: {factor_id:point.factor_id},
                    success: function (data) {
                        
                    // Parse the data as json
                    var obj = JSON.parse(data)
                   
                    $('#modalBt').trigger('click');
                    $('#Title').val(obj.title);
                    $('#Description').val(obj.description);
                    $('#Source').val(obj.source);
                    $('#OccurenceDate').val(obj.occurance_date);
                    $('#Rank').val(obj.rank_id);
                    $('#Sector').val(obj.sector_id);
                    $('.factorClass').val(obj.factor_id);
                    

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
    };

</script>
</body>
</html>