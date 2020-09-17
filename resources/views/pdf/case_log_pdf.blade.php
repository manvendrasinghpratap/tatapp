@extends('pdf.master')
@section('content')

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0;">
 	<meta name="format-detection" content="telephone=no"/>

<style>
    body {background-color: #fff;}
    .content-wrapper {background-color: #fff; margin: 0;}
    .content, .panel {border: none; margin: 0;}
    .content-header {border-bottom: 1px solid #e4e4e4; padding: 10px 0;}
    .content-header h1 {font-size: 16px; font-weight: 600; margin: 0;}
    .panel-heading h3.box-title {font-size: 14px; font-weight: 500; margin: 10px 0;}
    table {border: none; margin-bottom: 0; width: 100%;}
    table td.left { font-size: 12px; font-weight: 500; padding: 8px; width: 35%;}
    table td.right { font-size: 12px; padding: 8px; width: 65%;}
    table td.heading {background-color: #f2f2f2; font-size: 14px; font-weight: 500; padding: 8px;}

 </style>
	<title>CASE: Parkland Shooting (title)</title>
</head>

<!-- BODY -->
<body>
    <!-- Start Case Details-->
    <div class="content-wrapper">
        <section class="content">
            <div class="panel panel-default">
                <h3><center>{{_i('Case:')}} {{ $data['caseDetails']->title}}</center></h3><br>
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-header with-border">                                   
                                    <h3 class="box-title" style="margin:0 0 10px;">
                                                @if(@$data['caseList']->default_pic!='')
                                                 <center>  <img src="{{get_image_url_server(@$data['caseList']->default_pic,'package')}}" style="width:100px !important;height:100px;" width="400px" height="100px" class="img-responsive case_pic" alt=""  ></center>
                                                 @else
                                            <center> <img src="{{asset('images/gravitor.jpg')}}" alt="gravitor" class="img-responsive case_pic"></center>
                                            @endif                                         
                                    </h3>
                                </div>
                                <?php if(!empty($tableData)) { ?>	
	                                <?php  foreach($tableData as $k=>$v ) { ?>	
		                                <div class="box-body table-responsive no-padding">
		                                	<?php echo $v;?>
		                                </div>
	                            	<?php } ?>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div> 
        </section>
    </div>
    <!-- End Case Details-->

 </body>
</html>
<style>
.page-break {
    page-break-after: always;
}
.case_pic{
width:100px !important;
height: 100px !important;
}
</style>



@endsection