@extends('layout.backened.header')
@section('content')
<?php $linkedtype='case'; ?> 
<!-- START Datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<!-- Start Datatable -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;} figcaption{display:nones;} </style> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script> 
<!-- End Datatable -->
<!-- Trigger the modal with a button -->
<div class="clearfix"></div>
 <div class="section" > 
      <div class="container">
         <section class="content-header">    
        <div class="classnameheading">{{ $data['caseDetails']->title }}</div>
        <div class="paddingbottom10px"><h3>@if(@$request->id){{'Manage Tasks '}} @else {{'Manage Tasks'}} @endif </h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
        <li class="active">@if(@$request->id){{'Add Task'}} @else {{'Add Task'}} @endif </li>
      </ol>
	  @if(count($data['getAllTaskByCaseId'])>0)		
		 <div class="margintopminus48">		 
      <input type="hidden" id="filename" name="filename" value="Task {{ @$data['caseDetails']->title }}">	
      <a href="javascript::void(0)" id="csv" class="btn btn-info btn-xs action-btn edit" title ="Download CSV File"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span></a> 		 
			<a href="{{route('admin-download-case-pdf-taskList',['id'=>@$data['caseDetails']->id]) }}" class="btn btn-info btn-xs action-btn edit" title ="Download PDF"><i class="fa fa-file-pdf-o backgroundred" aria-hidden="true"></i></span></a>
        </div>
		@endif
    </section>
</div>
<button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
<!-- Modal HTML -->

<div id="sectorDetails"></div>
<div id="descriptionDetails"></div>
<div id="galleryDetails"></div>
<div id="factorgalleryDetails"></div>
<div class="clearfix"></div>
<div class="section" id="printcontent" style="padding:0px;">
    <div class="container">
        <div class="box-header with-border">
              <h3 class="box-title"></h3>
              @if(Session::has('add_message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('add_message') !!} 
                </div>
                @endif
            </div>

<?php 
$user_role_name = Session::get('user_role_name');
?>

      <div class="panel-body">
        <div class="row">
          <div class="col-sm-12" id="ajaxresp">
            <div class="table-responsive">
              <table id="taskList" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>{{_i('Title')}}</th>
                    <th>Assign To</th>
                    <th>{{_i('Due Date')}}</th>
                    <th>Status</th> 
                    <th>{{_i('Created Date')}}</th>                                
                    <th class="ignore">{{_i('Action')}}</th> 
                  </tr>
                </thead>
                <tbody>
                  @if( !empty($data['caseDetails']->task) && (count($data['caseDetails']->task)>0))                          
                  @foreach($data['caseDetails']->task as $k=>$row)
                  @if(!empty($row->task->id))
                  <tr>
                    <td >{{$k+1}}</td>
                    <td><a href="javascript:open_change_status_task_modal({{$row->task->id}}, {{$data['caseDetails']->id}}, '{{route('admin-ajaxGetTaskDetailsChangeStatus')}}','{{route('admin-ajaxAssignTaskDetails')}}');" class="add-tasks" Title="Update Task Status">{{wordwrap($row->task->title, 20, "\n", true)}}</a>
                    </td>
                    <td>{{ @$row->task['user']['first_name'] }} &nbsp; {{ @$row->task['user']['last_name'] }}</td> 
                    <td>{{date("F j, Y", strtotime($row->task->due_date))}}</td> 
                    <td><?php echo getStatusTitle($row->task->status); ?></td>
                    <td>{{date("F j, Y", strtotime($row->task->created_at))}}</td>
                    <td class="ignore"><form class="form-horizontal" id="frm_{{$row->id}}" action="{{route('admin-linkcaseToTaskAction')}}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <input type="hidden" value="{{$data['caseDetails']->id}}" name="casetaskid">
                      <input type="hidden" value="{{$row->task->id}}" name="taskid">
                      <input type="submit" name="taskunlink"id="add-button" value="Un-Link" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link selected Task to Case ?')">
                    </form>

                  </td>
                </tr>   
                @endif                         
                @endforeach
                @else
                <tr class="bg-info">
                  <td colspan="8">Record(s) not found.</td>
                </tr>
                @endif
              </tbody>
            </table>

            <div class=" pull-left">
             <a href="{{route('admin-addnewTaskCase',['id'=>@$data['caseList']->id])}}" class="btn btn-primary addTask" title="Add Task"><i class="fa fa-plus"></i> Add New Task</a>
           </div>

         </div>
       </div>
     </div>
   </div>
 </div> 
</div> 


<!----------------------- -->


<!---------------------------- -->
</div>
<style>
.error{
  color:red;
}
</style>
<?php   $username = Session::get('first_name')." ".Session::get('last_name'); ?>
<script src="{{asset('js/tasklist.js')}}"></script> 
<script>
 var tokenval = $('meta[name="csrf-token"]').attr('content');
 $('#token').val(tokenval);


 $(document).ready(function() {

  $('#sectortbl').DataTable( {
    "order": [[ 0, "desc" ]]
  } );

  $('#taskList').DataTable( {
    "order": [[ 0, "desc" ]]
  } );
  $('#incidentList').DataTable( {
    "order": [[ 0, "desc" ]]
  } );
  


} );



 var AddDbclk = 0;
</script>

<script src="{{asset('js/script.js')}}"></script>
<script src="{{asset('js/subject.js')}}"></script>
<script src="{{asset('js/target.js')}}"></script>
<script src="{{asset('js/files.js')}}"></script>
<script src="{{asset('js/description.js')}}"></script>
<script> 
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
  return false;
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
		/*replaceSVGwithCanvas(function onComplete() {
  html2canvas(document.getElementById('printcontent'), {
    onrendered: function(canvasObj) {
      startPrintProcess(canvasObj, 'printedPDF',function (){
        alert('PDF saved');
      });
      //save this object to the pdf
    }
  });
});*/
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
			//var contanturl="<img src="+iimage('container')+">";
			//var timelinecontanturl="<img src="+iimage('timeLineContainer')+">";
			//$('#container').html(contanturl);
			//$('#timeLineContainer').html(timelinecontanturl);
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

                /*var source2 = document.getElementById("container");
                pdf.fromHTML(source2, 15, 650, {
                    'width' : 560,
                    'elementHandlers' : elementHandler
                  });*/

                  setTimeout(function() {
                    pdf.fromHTML(element, {pagesplit: true, background:"#ffffff",canvas: newCanvas,'elementHandlers' : elementHandler}, function () {
				// var out = pdf.output('dataurlnewwindow'); // crashed if bigger file
				//pdf.save('Case-Detail-<?php echo $data['caseList']->title; ?>.pdf');
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
				  //pdf.addImage(dataUrl, 'JPEG', 20, 300, 560, 350);

					/*	var source2 = document.getElementById("container");
						pdf.fromHTML(source2, 15, 650, {
							'width' : 560,
							'elementHandlers' : elementHandler
						});*/

						


         }
				/* var doc = new jsPDF('portrait', 'pt', 'a4', true);
    var elementHandler = {
      '#ignorePDF': function(element, renderer) {
        return true;
      }
    };

    var source = document.getElementById("printcontent");
    doc.fromHTML(source, 15, 15, {
      'width': 560,
      'elementHandlers': elementHandler
    });

    var svg = document.querySelector('svg');
    var canvas = document.createElement('canvas');
    var canvasIE = document.createElement('canvas');
    var context = canvas.getContext('2d');
   
   
   
   
    var data = (new XMLSerializer()).serializeToString(svg);
    canvg(canvas, data);
    var svgBlob = new Blob([data], {
      type: 'image/svg+xml;charset=utf-8'
    });

    var url = DOMURL.createObjectURL(svgBlob);

    var img = new Image();
    img.onload = function() {
      context.canvas.width = $('#timeLineContainer').find('svg').width();;
      context.canvas.height = $('#timeLineContainer').find('svg').height();;
      context.drawImage(img, 0, 0);
      // freeing up the memory as image is drawn to canvas
      DOMURL.revokeObjectURL(url);
      
      var dataUrl;
						if (isIEBrowser()) { // Check of IE browser 
							var svg = $('#timeLineContainer').highcharts().container.innerHTML;
							canvg(canvasIE, svg);
							dataUrl = canvasIE.toDataURL('image/JPEG');
						}
						else{
							dataUrl = canvas.toDataURL('image/jpeg');
						}
      doc.addImage(dataUrl, 'JPEG', 20, 300, 560, 350);

      var bottomContent = document.getElementById("printcontent");
      doc.fromHTML(bottomContent, 15, 650, {
        'width': 560,
        'elementHandlers': elementHandler
      });

      setTimeout(function() {
        doc.save('TestChart.pdf');
      }, 2000);
    };
    img.src = url;*/
  });
loadCSS = function(href) {
  var cssLink = $("<link rel='stylesheet' type='text/css' href='"+href+"'>");
  $("head").append(cssLink); 
};

});


</script>

<script type="text/javascript">
     // the actual callback for a double-click event
     var ondbclick = function(e, point) {

		//alert(point.factor_id+'-----------'+point.case_id);
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
                    beforeSend: function() {
						// setting a timeout
						
					},
          success: function (data) {


            $('#sectorDetails').html(data);
            $('#modalBt').trigger('click');

                    //editSectorDetails(point.factor_id);

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

                    
                    $('#title').val(obj.title);
                    $('#description').val(obj.description);
                    $('#source').val(obj.source);
                    $('#occurance_date').val(obj.occurance_date);
                    $('#rank_id').val(obj.rank_id);
                    $('#sector_id').val(obj.sector_id);
                    $('.factorClass').val(obj.factor_id);
                    $('.dropbtn').html(obj.sector_name);
                    

                    if(obj.target_chart_visibility=="y"){
                      $('#target_chart_visibility').prop( "checked", true);
                    }
                    else{
                      $('#target_chart_visibility').prop( "checked", false);
                    }

                    if(obj.timeline_chart_visibility=="y"){
                      $('#timeline_chart_visibility').prop( "checked", true);
                    }
                    else{
                      $('#timeline_chart_visibility').prop( "checked", false);
                    }

                  }
                });

    }

  };



  function open_task_modal(task_id, case_id){

    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxGetTaskDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      task_id:task_id,case_id:case_id 
                    },
                    success: function (data) {


                      $('#sectorDetails').html(data);
                      $('#modalBt').trigger('click');

                      editTaskDetails(task_id);


                    }
                  });

  }



  function add_note(case_id, add_note){

    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxGetTaskDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      add_note:add_note,case_id:case_id 
                    },
                    success: function (data) {


                      $('#sectorDetails').html(data);
                      $('#modalBt').trigger('click');


                    }
                  });

  }

  /*$('#add_note_frm').validate({
    ignore: ".ignore",
    rules: {

      add_note:'required'
    },
            // Specify validation error messages
            messages: {


              add_note: "Please enter Note."
            },
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      var sdata = new FormData(form);
      $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin-ajaxSaveAddNote')}}",
                   // dataType: 'html',
                   data:sdata,
                   success: function (response) {
                    //result=html.split('#');
                    $('#ajaxresp').html(response);
                    $('#myModal').modal('hide');
                    location.reload();

                  },
                  cache: false,
                  contentType: false,
                  processData: false
                });

    }

  });*/

  function editTaskDetails(task_id){


    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxAssignTaskDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      task_id:task_id
                    },
                    success: function (data) {

                    // Parse the data as json
                    var obj = JSON.parse(data)

                    
                    $('#title').val(obj.title);
                    $('#description').val(obj.description);
                    $('#status').val(obj.status);
                    $('#task_assigned').val(obj.task_assigned);
                    $('#due_date').val(obj.due_date);
                    $('#task_id').val(task_id);
                    

                  }
                });

  }


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
                      $('.modal-backdrop').remove();
                      $('#modalBt').trigger('click');
                       // editSectorDetails(factor_id);

                     }
                   });

  }


  function delete_factor(factor_id){

    var r = confirm("Are you sure you want to delete ?");
    if (r == true) {
      $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin-ajaxDeleteFactor')}}",
        dataType: 'html',
        data: {
          token : $('meta[name="csrf-token"]').attr('content'), 
          factor_id:factor_id},
          success: function (html) {
            $('#myModal').modal('hide');
            location.reload();
          }
        });
    }
  }


  function delete_task(task_id){

    var r = confirm("Are you sure you want to delete ?");
    if (r == true) {
      $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin-ajaxDeleteTask')}}",
        dataType: 'html',
        data: {
          token : $('meta[name="csrf-token"]').attr('content'), 
          task_id:task_id},
          success: function (html) {
            $('#myModal').modal('hide');
            location.reload();
          }
        });
    }
  }




</script>
<script>



 var open_gallery_modal_to_update_case_image = function(case_id, link1) {
  $('#operation_type').val("change_case_image");
  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: link1,
    dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      case_id:case_id 
                    },
                    success: function (data) {


                      $('#galleryDetails').html(data);
                        //$('#modalBt').trigger('click');
                        $('#myModal2').modal('show');  




                      }
                    });


};



</script>
<script src="{{asset('js/table2csv.js')}}"></script>
<script>
$( "#csv" ).click(function() {
    var fileName = $('#filename').val();
    $("table").table2csv({
        excludeColumns:'.ignore',
        "filename": fileName+'.csv',
    });
});
</script>
@endsection