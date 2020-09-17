<?php //dd($data); ?>
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

	<!-- MESSAGE SUBJECT -->
	<title>{{ $data['caseDetails']->title}}</title>

</head>

<!-- BODY -->
<body>	
	<?php //echo "/var/www/vhosts/a2zapp.online/tadapp.a2zapp.online/public/uploads/package/";?>
	<?php //echo $ddd = get_image_url_server(@$data['caseDetails']->default_pic,'package');  die(); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="panel panel-default">
                <section class="content-header">
                    <h1><center>{{_i('Case:')}} {{ $data['caseDetails']->title}}</center></h1><br>
                     <h3 class="box-title" style="margin: 0px 0px 10px;">
                                        @if(@$data['caseDetails']->default_pic !='')
                                    <center><img src="{{get_image_url_server(@$data['caseDetails']->default_pic,'package')}}" style="width:100px !important;height:100px;" width="100px" height="100px" class="img-responsive case_pic" alt="" ></center>
                                     @else 
                                    <center><img src="{{asset('images/gravitor.jpg')}}" alt="gravitor" class="img-responsive case_pic"></center>
                                    @endif
                     </h3>
                </section>
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">                             
                            <div class="box box-info">
							@if(count($data['getAllSectorByCaseId'])>0)
								@php $i = 0; @endphp
								  @foreach($data['getAllSectorByCaseId'] as $row)
								  		 
                                <div class="box-header with-border">
                                  <h3><center class="heading" >Factor {{ ++$i}}</center></h3> 
                                </div>

                               <div class="box-body table-responsive no-padding">
                                    <table class="table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="left">Title</td> 
                                                <td class="right"><?php echo $row->title; ?></td>
                                            </tr>
                                            <tr> 
                                                <td class="left">Occurrence Date</td> 
                                                <td class="right"><?php echo date("F j, Y", strtotime($row->occurance_date)); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Rank</td>
                                                <td class="right"><?php echo $row->rank_id; ?></td>

                                            </tr>
                                            <tr>
                                                <td class="left">Sector</td>
                                                <td class="right"><?php echo $row->sector_name; ?></td>
                                            </tr>

                                            <tr>
                                                <td class="left">Source</td> 
                                                <td class="right"><?php echo $row->source; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Description</td>
                                                <td class="right">
                                                    <p style="word-break: break-all; word-wrap: break-word;"><?php echo $row->description; ?></p>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
								@endforeach
						      @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </section>
    </div>
    <!-- End Subject Details-->
    

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