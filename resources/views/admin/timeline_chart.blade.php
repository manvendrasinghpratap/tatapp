@extends('layout.backened.header')
@section('content')
<?php $linkedtype='case'; ?> 
<!-- START Datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<!-- END Datatable -->
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!-- Start Datatable -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/amstockchart/3.13.0/exporting/rgbcolor.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/canvg.js"></script>

<style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;} figcaption{display:nones;} </style> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script> 
<div class="clearfix"></div>
 <div class="section" > 
      <div class="container">
         <section class="content-header">    
        <div class="classnameheading">{{ @$data['caseList']->title }}</div>
        <div class="paddingbottom10px"><h3>@if(@$request->id){{'Timeline Chart '}} @else {{'Timeline Chart'}} @endif </h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> {{_i('Home')}}</a></li>
        <li class="active">@if(@$request->id){{'Timeline Chart'}} @else {{'Timeline Chart'}} @endif </li>
      </ol>
    </section>
</div>
<div class="section" id="printcontent" style="padding:0px;">
    <div class="container">
        <div class="row" id="target-chart">
            <div class="col-sm-12">
                      <div class="panel-body">
                        <div class="panelDiv">
                          Chart Type:
                          <select id="chart_type">
                            <option value="">Please Select</option>
                            <option value="scatter">Polar Scatter</option>
                            <option value="area">Area</option>
                            <option value="line">Line</option>
                          </select>
                        </div>
                        <div id="timeLineContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                      </div>
                </div>
            </div>
      </div>
</div>
</div>

<?php   $username = Session::get('first_name')." ".Session::get('last_name'); ?>

<script> 
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
  return false;
}



function set_sector(id, sector_name){

  $('#sector_id').val(id);
  $('.dropbtn').html(sector_name);


}

/* New code By Subhendu 15-05-2018 */
$(document).ready(function(){

  $('#myModal').on('hidden.bs.modal', function () {
   location.reload();
 })



  $('.addTask').on('click', function(){

    AddDbclk = 0;
    var case_id = $('#modalCaseId').val();

    open_task_modal(0, case_id);

    $('#deleteTask').hide();

  }); 

  $('#addTask').on('click', function(){

    AddDbclk = 0;
    var case_id = $('#modalCaseId').val();

    open_task_modal(0, case_id);

    $('#deleteTask').hide();

  });
  $('#view_previous_add_note').click(function(){

   $('.note_add_message_content').css('overflow','auto');
   $('#view_previous_add_note').hide();
   $('#view_previous_add_note_show').show();
 });
  $('#view_previous_add_note_show').click(function(){

   $('.note_add_message_content').css('overflow','hidden');
   $('#view_previous_add_note').show();
   $('#view_previous_add_note_show').hide();
 });


  $('#addBt').on('click', function(){

    AddDbclk = 0;
    var case_id = $('#modalCaseId').val();
                    //formatModal();
                    open_factor_modal(0, case_id);
                    $('#rank_id').val(10);
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

 //print_r($myJsonString);


$visibleTimeLineDataList = $data['getAllVisibleTimeLineDataByCaseId'];


$myJsonStringForTimeLine = json_encode($visibleTimeLineDataList);
$myJsonStringForTimeLine = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $myJsonStringForTimeLine);

/*echo "<pre>";
print_r($visibleFactor);
echo "</pre>";*/
?>
<svg aria-hidden="true" focusable="false" style="width:0;height:0;position:absolute;">
  <linearGradient id="gradient-horizontal">
    <stop offset="0%" stop-color="var(--color-stop-1)" />
    <stop offset="50%" stop-color="var(--color-stop-2)" />
    <stop offset="100%" stop-color="var(--color-stop-3)" />
  </linearGradient>
  <linearGradient id="gradient-vertical" x2="0" y2="1">
    <stop offset="0%" stop-color="var(--color-stop-1)" />
    <stop offset="50%" stop-color="var(--color-stop-2)" />
    <stop offset="100%" stop-color="var(--color-stop-3)" />
  </linearGradient>
</svg>
<style>
.draggable {
  cursor: move; /* fallback if grab cursor is unsupported */
  cursor: grab;
  cursor: -moz-grab;
  cursor: -webkit-grab;
}

/* (Optional) Apply a "closed-hand" cursor during drag operation. --color-stop-1: #a770ef;  --color-stop-3: #fdb99b;  --color-stop-2: #cf8bf3;*/
.draggable:active { 
  cursor: grabbing;
  cursor: -moz-grabbing;
  cursor: -webkit-grabbing;
}
#gradient-horizontal {
 --color-stop-1: #aba3b3;
 --color-stop-2: #d9d4de;
 --color-stop-3: #5c5861;
 
}
#note_add{
  padding:10px;background-color: #f4f7fb;width:100%;float:left;
}
.note_add_button{
  width:6%;float:left;
}
.note_add_button button{
  width:100%;vertical-align:middle;height:41px;
}
.note_add_input_content{
  width:90%;float:left;margin-right:2%;
}
.note_add_input_content .error{
  margin-top:5px;padding-left:10px;
}
.note_add_input{
  width:100%;height:41px;padding:10px;vertical-align:middle;
}
.note_add_content{
  width:100%;float:left;
}
.note_add_message_previous{
  width:100%;float:left;background-color: #f4f7fb;
}
.note_add_message{
  margin:10px;width:99%;float:left;border-bottom:1px solid #eee;
}
.note_add_message_previous_content{
  margin:10px;float:left;width: 96%;
}
.note_add_img{
  float:left;
}
.note_add_img img{
  width:30px;height:30px;border-radius:15px;
}
.note_add_message_text_content{
  color:#999;
}
.note_add_message_content{
  height:120px;
  overflow: hidden;
}
.note_add_message_text{
  float:left;padding-left:10px;font-weight:normal;width:80%;
}
.note_add_case_account{
  font-weight:normal;font-size:11px
}
.note_add_note_add{
  padding-left:10px;font-weight:normal;font-size:11px
}
.note_add_previous{
  width:128px;float:left;font-size:11px
}
.note_add_out{
  float:right;font-weight:normal;font-size:11px
}
#gradient-vertical {
  --color-stop-1: #00c3ff;
  --color-stop-2: #77e190;
  --color-stop-3: #ffff1c;
}
/*g.highcharts-yaxis-grid path {
   fill: url(#gradient-horizontal);
    stroke: darkgray;
}
g.highcharts-xaxis-grid path{
	 fill: url(#gradient-vertical);
    stroke: darkgray;
    }*/
    .profile-image-buttons{
      width:50%;float:left;
      margin-top:5px;
    }
    figcaption{
      width:100%;float:left;margin:4px 0;
    }
    .profile-image-inner-button{
      width:48%;float:left;
    }
    .profile-image-inner-button-right{
      width:48%;float:right;
      margin-top:0px;
    }
    @media (max-width: 768px) {
      .note_add_message_previous{
        width:100%;
      }
      .note_add_button{
        width:14%
      }
      .note_add_input_content{
        width:80%;
        padding-left: 1px;
      }
      .profile-image-inner-button,.profile-image-inner-button-right{
        width:100%;float:left
      }
      .profile-image-inner-button-right{
        margin-top:5px;
      }
      .profile-image-buttons{
        width:100%;float:left;
        margin-top:5px;
      }
    }
  </style>
  <script type="text/javascript">

    function topschart(){
      Highcharts.chart('container', {
        mapNavigation: {
          enabled: false
        },
        chart: {
          polar: true,
          height: '75%',  

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
         startAngle: 45,

         background: [{
          backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
            [0, '#aba3b3'],
            [1, '#d9d4de']
            ]
          },
          borderWidth: 1,
          outerRadius: '100%'
        }, {
          backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
            [0, '#aba3b3'],
            [1, '#d9d4de']


            ]
          },
          borderWidth: 10,
          outerRadius: '90%'
        }, {
          backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
            stops: [
            [0, '#00ffff'],
            [1, '#ff99cc'],



            ]
          },
            // default background
          }, {
            backgroundColor: '#d9d4de',
            borderWidth: 2,
            outerRadius: '10%',
            innerRadius: '10%'
          }]
        },


        xAxis: {
          minRange: 1,
          min: 0,
          max: <?php echo count($visibleSector); ?>,
          lineColor: '#000080',
          gridLineColor: '#3c8dbc',
          gridLineWidth: 1.5,
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
          gridLineColor: '#d9d4de',
          reversed: true,
          labels: {
            x: 0,
            y: -10,
            style: {
              color: '#2f4f4f',
              fontWeight: 'bold'
            }
          },
          plotBands: [{

            from: 1,
            to: 10,

            color: {
              linearGradient: {
                x1: 0,
                x2: 0,
                y1: 0,
                y2: 1
              },
              stops: [
              [0, 'rgba(204,0,0,0.2)'],
              [0.5, 'rgba(0,204,0,0.2)'],
              [1, 'rgba(0,0,204,0.2)'],
              ]
            },



          }


          ]
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
         output +=  '<a href="javascript:open_factor_modal('+this.factor_id+','+ this.case_id+');">Click on the  icon</a> for view details.<br>';
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
}
</script>
<?php //echo json_encode($visibleTimeLineDataList); ?>
<script type="text/javascript">
  $(function() {

    var settings = {
      gridLineColor: '#eee',
      lineColor: '#5CD0CD',
      lineWidth: 1,
      gradientEndColor: '#D1F3F2'
    };
    var data = <?php echo $myJsonStringForTimeLine; ?>;


    var series_type = 'area';
    $('#chart_type').on('change', function(){
      var series_type = $(this).val(), i;
      if(series_type!=""){
        drawTimeLineChart(series_type);    
      }

    }) 
    drawTimeLineChart(series_type);
    topschart();
    function drawTimeLineChart(series_type){
      Highcharts.chart('timeLineContainer', {
        chart: {
          zoomType: 'x'
        },
        title: {
          text: 'Time Line: Rank over time'
        },
        subtitle: {
          text: ''
        },
        xAxis: {
          type: 'datetime',
          labels: {
            useHTML: true,
            formatter: function() {

              return '<span class="area-xaxis-label">' + Highcharts.dateFormat('%m/%d/%Y', this.value) + '</span>';
            }
          }
        },
        yAxis: {
          title: {
            text: 'Rank'
          },
          tickInterval: 1,
          gridLineColor: settings.gridLineColor,
          labels: {
            useHTML: true,
            formatter: function() {
              return '<span class="area-yaxis-label">' + this.value + '</span>';
            }
          }
        },
        legend: {
          enabled: false
        },
        plotOptions: {
          series: {
            point: {
              events: {
                click: function(e) {
                  open_factor_modal(this.factor_id, this.case_id);

                }
              }
            }
          },
          area: {
            fillColor: {
              linearGradient: {
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 1
              },
              stops: [
              [0, settings.gradientEndColor],
              [1, Highcharts.Color(settings.gradientEndColor).setOpacity(0).get('rgba')]
              ]
            },
            lineWidth: settings.lineWidth,
            lineColor: settings.lineColor,
            states: {
              hover: {
                lineWidth: settings.lineWidth
              }
            },
            threshold: null

          }
        },
        series: [{
          type: series_type,
          name: 'Engine LOAD',
          maxSize: 5,
          data: data,
          states: {
            hover: {
              halo: {
                size: 0
              }
            }
          }
        }],
        tooltip: {
          useHTML: true,
          borderRadius: 0,
          borderWidth: 1,
          borderColor: settings.lineColor,
          shadow: false,
    shape: 'square', // default is callout
    style: {
      padding: 8
    },
    headerFormat: '',
    pointFormatter: function() {
      //console.log(this);
      var output = '<div class="area-tooltip">';
      output += '   <div class="area-tooltip-header">';
      output += '   <span class="area-tooltip-unit">Title: ' + this.z + '</span><br>';
      output += '   <span class="area-tooltip-unit">Sector Name: ' + this.sector_name + '</span><br>';
      output += '   <span class="area-tooltip-text">Occurance Date:</span>';
      output += '   <span class="area-tooltip-date">' + this.occurance_date + '</span>';
      output += '   </div>';
      output += '   <div class="area-tooltip-footer">';
      output += '   <span class="area-tooltip-value">Rank :' + this.y + '</span>';


      output += '   </div>';
      output += '</div>';

      return output;
    }
  },
  navigation: {
    buttonOptions: {
      enabled: false
    }
  },
  credits: false



});
    }

    var replaceSVGwithCanvas = function(callback) {
  //find all svg elements in $container
  var $container = $('#container');
  //$container is the jQuery object of the div that you need to convert to image. This div may contain highcharts along with other child divs, etc
  var svgElements = $container.find('svg');
  svgElements.each(function() {
    var canvas, xml;
    canvas = document.createElement("canvas");
    canvas.className = "screenShotTempCanvas";
    //convert SVG into a XML string
    xml = (new XMLSerializer()).serializeToString(this);
    // Removing the name space as IE throws an error
    xml = xml.replace(/xmlns=\"http:\/\/www\.w3\.org\/2000\/svg\"/, '');
    //draw the SVG onto a canvas
    canvg(canvas, xml);
    $(canvas).insertAfter(this);
    $(this).hide();
  });
  callback(); //to be called after the process in finished
};
function startPrintProcess(canvasObj, fileName, callback) {
  var pdf = new jsPDF('l', 'pt', 'a4'),
  pdfConf = {
    pagesplit: false,
    background: '#fff'
  };
  document.body.appendChild(canvasObj); //appendChild is required for html to add page in pdf
  pdf.addHTML(canvasObj, 0, 0, pdfConf, function() {
    document.body.removeChild(canvasObj);
    pdf.addPage();
    pdf.save(fileName + '.pdf');
    callback();
  });
}

$("#genPDF").click(function(){ 
			/*var options = {
				background:"#ffffff",
				pagesplit: true,
				width: '1200',
				height: '1500'
				};
			var pdf = new jsPDF('p', 'pt', 'a4');
			var wih = $("#printcontent").width();
			 $("#printcontent").css('width','1200px');
			// loadCSS("{{ asset('/css_new/style2.css')}}");
			 pdf.setProperties({
				title: '<?php echo $data['caseList']->title; ?>',
				subject: '<?php echo $data['caseList']->title; ?>',
				author: '<?php echo $username; ?>',
				keywords: 'Case detail',
				creator: 'Threat Assessment'
			});
			pdf.addHTML($("#printcontent"),options, function() {
				pdf.output('save','Case-Detail-<?php echo $data['caseList']->title; ?>.pdf');
				//pdf.save('save','Case-Detail-<?php echo $data['caseList']->title; ?>.pdf');
			});*/
			// loadCSS("{{ asset('/css_new/style.css')}}");
			
			var element = document.getElementById('printcontent');

			var pdf = new jsPDF('p', 'pt', 'a4');
			pdf.internal.scaleFactor = 3.75;

			var w = element.clientWidth;
			var h = element.clientHeight;
			var newCanvas = document.createElement('canvas');
			newCanvas.width = w * 2; 
			newCanvas.height = h * 2;
			newCanvas.style.width = w + 'px';
			newCanvas.style.height = h + 'px';
			var context = newCanvas.getContext('2d');
			context.scale(2, 2);
      var elementHandler = {
        '#ignorePDF' : function(element, renderer) {
          return true;
        }
      };
			
      pdf.setProperties({
        title: '<?php echo $data['caseList']->title; ?>',
        subject: '<?php echo $data['caseList']->title; ?>',
        author: '<?php echo $username; ?>',
        keywords: 'Case detail',
        creator: '<?php echo $username; ?>'
      });
		//	pdf.fromHTML(element, {pagesplit: true, background:"#ffffff",canvas: newCanvas,'elementHandlers' : elementHandler});
		/*pdf.addHTML(element, {pagesplit: true, background:"#ffffff",canvas: newCanvas,'elementHandlers' : elementHandler}, function () {
				// var out = pdf.output('dataurlnewwindow'); // crashed if bigger file
				pdf.save('Case-Detail-<?php echo $data['caseList']->title; ?>.pdf');
			});*/
			var series_type = 'area';
			//drawTimeLineChart(series_type);
			//topschart();  /* 
			var msie = document.documentMode;

      if (!isNaN(msie) && msie < 12) {
  // code for IE < 12

  var tempSVG = $('#timeLineContainer').highcharts().container.innerHTML;
  var canvas11 = document.createElement('canvas');

  canvg(canvas11, tempSVG);
  var dataUrl = canvas11.toDataURL('image/JPEG');

  pdf.addImage(dataUrl, 'JPEG', 20, 300, 560, 350);
                  setTimeout(function() {
                    pdf.fromHTML(element, {pagesplit: true, background:"#ffffff",canvas: newCanvas,'elementHandlers' : elementHandler}, function () {
			});
                  }, 2000);

                } else {

                  var svg = document.querySelector('#container svg');
                  var width = $('#container').find('svg').width();
                  var height = $('#container').find('svg').height();
                  var canvas = document.createElement('canvas');
                  var ctx = canvas.getContext('2d');
                  var DOMURL = window.URL || window.webkitURL || window;
                  var data = (new XMLSerializer()).serializeToString(svg);

                  var img = new Image();
                  var svgBlob = new Blob([data], {type: 'image/svg+xml;charset=utf-8'});
                  var url = DOMURL.createObjectURL(svgBlob);

                  var svg2 = document.querySelector('#timeLineContainer svg');
                  var width2 = $('#timeLineContainer').find('svg').width();
                  var height2 = $('#timeLineContainer').find('svg').height();
                  var canvas2 = document.createElement('canvas');
                  var ctx2 = canvas2.getContext('2d');
                  var DOMURL2 = window.URL || window.webkitURL || window;
                  var data2 = (new XMLSerializer()).serializeToString(svg2);

                  var img2 = new Image();
                  var svgBlob2 = new Blob([data2], {type: 'image/svg+xml;charset=utf-8'});
                  var url2 = DOMURL2.createObjectURL(svgBlob2);

                  img.onload = function () {
                    ctx.canvas.width = width;
                    ctx.canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);
                    DOMURL.revokeObjectURL(url);

                    var dataUrl = canvas.toDataURL('image/jpeg');
                    var contanturl="<img src="+dataUrl+">";
                    $('#container').html(contanturl);
                  };
                  img.src = url;
                  img2.onload = function () {
                    ctx2.canvas.width = width2;
                    ctx2.canvas.height = height2;
                    ctx2.drawImage(img2, 0, 0, width2, height2);
                    DOMURL2.revokeObjectURL(url2);

                    var dataUrl2 = canvas2.toDataURL('image/jpeg');
                    var timelinecontanturl="<img src="+dataUrl2+">";
                    $('#timeLineContainer').html(timelinecontanturl);
                    setTimeout(function() {
                     $("#printcontent").css('width','1200px');
                     $("#target-chart").css('margin-top','100px');
                     pdf.addHTML(element, {pagesplit: true, background:"#ffffff",canvas: newCanvas,'elementHandlers' : elementHandler}, function () {
				// var out = pdf.output('dataurlnewwindow'); // crashed if bigger file
				pdf.save('Case-Detail-<?php echo $data['caseList']->title; ?>.pdf');
				
				var series_type = 'area';
       drawTimeLineChart(series_type);
       topschart(); 
       $("#target-chart").css('margin-top','0px');
       $("#printcontent").css('width','auto');
     });
                   }, 2000);

                  };
                  img2.src = url2;				


         }
				
  });
loadCSS = function(href) {
  var cssLink = $("<link rel='stylesheet' type='text/css' href='"+href+"'>");
  $("head").append(cssLink); 
};

});


</script>

@endsection