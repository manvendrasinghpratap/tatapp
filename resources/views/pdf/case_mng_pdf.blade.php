<?php //dd($data); ?>
@extends('pdf.master')
@section('content')

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
	<title>CASE: Parkland Shooting (title)
</title>

</head>

<!-- BODY -->
<body>
    <!-- Start Case Details-->
    <div class="content-wrapper">
        <section class="content">
            <div class="panel panel-default">
                <section class="content-header">
                    <h1>{{_i('Case Detail')}}</h1>
                </section>
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                             
                            <div class="box box-info">
                                <div class="box-header with-border">
                                  
                                   <h3 class="box-title" style="font-size: 14px; margin: 0 0 10px; padding: 8px 8px 8px 0;"> 
                                       <span>Case:</span> <span style="font-weight: 400;">{{@$data['caseDetails']->title}}</span>
                                   </h3> 
                                   
                                    <h3 class="box-title" style="margin:0 0 10px;">

                                                @if(@$data['caseList']->default_pic!='')
                                                   <img src="{{get_image_url_server(@$data['caseList']->default_pic,'package')}}" style="width:100px !important;height:100px;" width="100px" height="100px" class="img-responsive case_pic" alt=""  >
                                             @else
                                            <img src="{{asset('images/gravitor.jpg')}}" alt="gravitor" class="img-responsive case_pic">
                                            @endif

                                         
                                            </h3>
                                </div>

                                <div class="box-body table-responsive no-padding">
                                    <table class="table-bordered">
                                        <tr>
                                            <td class="left" >Status:</td>
                                            <td class="right">{{@$data['caseDetails']->status}}</td>
                                        </tr >
                                                <tr>
                                                    <td class="left">Summary Rank:</td>
                                                    <td class="right"> 
                                                        <?php  
                                                        $rank_sum = 0; 
                                                        if(isset($data['getAllSectorByCaseId'])&&!empty($data['getAllSectorByCaseId'])){
                                                            $total_rank_data = count($data['getAllSectorByCaseId']);
                                                            $avg_rank = 0;
                                                            if($total_rank_data>0){
                                                                foreach($data['getAllSectorByCaseId'] as $row) {
                                                                    $rank_sum = $rank_sum+ $row->rank_id;
                                                                }  
                                                            }
                                                            if($total_rank_data>0){
                                                                $avg_rank = $rank_sum / $total_rank_data;
                                                            }
                                                            echo number_format($avg_rank,2);
                                                        }
                                                            ?>/10
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="left">Urgency:</td>                                                              <td class="right">  {{@$data['caseDetails']->urgency}}</td>
                                                </tr>
                                               <tr>
                                                    <td class="left">User owner:</td>
                                                    <td class="right">  
                                                   {{@$data['case_owner_name']}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="left">Description:</td>
                                                    <td class="right">
                                                        <p style="word-break: break-all; word-wrap: break-word;">{{@$data['caseDetails']->description}}</p>
                                                    </td>
                                                </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </section>
    </div>
    <!-- End Case Details-->

    <div class="page-break"></div>

    <!-- Start Subject Details-->
    <div class="content-wrapper">
        <section class="content">
            <div class="panel panel-default">
                <section class="content-header">
                    <h1>{{_i('Subject')}}</h1>
                </section>
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                             
                            <div class="box box-info">
                                <div class="box-header with-border">
                                   @if(!empty($data['subjectDetails'][0]->name)) 
                                   <h3 class="box-title" style="font-size: 14px; margin: 0 0 10px; padding: 8px 8px 8px 0;"> 
                                       <span>Name:</span> <span style="font-weight: 400;">{{$data['subjectDetails'][0]->name}}</span>
                                   </h3> 
                                   @endif
                                   <h3 class="box-title" style="margin: 0 0 10px;">
                                        @if(@$data['caseList']->default_pic!='')
                                    <img src="{{get_image_url_server(@$data['caseList']->default_pic,'package')}}" style="width:100px !important;height:100px;" width="100px" height="100px" class="img-responsive case_pic" alt="" >
                                     @else 
                                    <img src="{{asset('images/gravitor.jpg')}}" alt="gravitor" class="img-responsive case_pic">
                                    @endif
                                    </h3>
                                </div>

                                <div class="box-body table-responsive no-padding">
                                    <table class="table-bordered">
                                        @if(!empty($data['subjectDetails'][0]->phone_number))
                                        <tr>
                                            <td class="left">Phone number:</td>
                                            <td class="right"> {{@$data['subjectDetails'][0]->phone_number}}</td>
                                        </tr> @endif     
                                        @if(!empty($data['subjectDetails'][0]->cell_phone))
                                        <tr>
                                            <td class="left">Cell phone:</td>
                                            <td class="right">{{@$data['subjectDetails'][0]->cell_phone}} </td>
                                        </tr> @endif
                                        @if(!empty($data['subjectDetails'][0]->address))
                                        <tr>
                                            <td class="left">Address:</td>
                                            <td class="right"> {{@$data['subjectDetails'][0]->address}}</td>
                                        </tr>@endif
                                        @if(!empty($data['subjectDetails'][0]->city))
                                        <tr>
                                            <td class="left">City:</td>
                                            <td class="right"> {{@$data['subjectDetails'][0]->city}}</td>
                                        </tr>@endif
                                        @if(!empty($data['subjectDetails'][0]->state))
                                        <tr>
                                            <td class="left">State:</td>
                                            <td class="right"> {{@$data['subjectDetails'][0]->state}}</td>
                                        </tr>@endif
                                        @if(!empty($data['subjectDetails'][0]->zip_code))
                                        <tr>
                                            <td class="left">Zip code:</td>
                                            <td class="right"> {{@$data['subjectDetails'][0]->zip_code}}</td>
                                        </tr>@endif
                                        @if(!empty($data['subjectDetails'][0]->email))
                                        <tr>
                                            <td class="left">Email addresses:</td>
                                            <td class="right"> {{@$data['subjectDetails'][0]->email}}</td>
                                        </tr>@endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </section>
    </div>
    <!-- End Subject Details-->
    @if(!empty($data['targetDetails'][0]))
    <div class="page-break"></div>

    <!-- Start Target Details-->
    <div class="content-wrapper">
        <section class="content">
            <div class="panel panel-default">
                <section class="content-header">
                    <h1>{{_i('Target')}}</h1>
                </section>
                <section class="content">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                 
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        @if(!empty($data['targetDetails'][0]->name)) 
                                        <h3 class="box-title" style="font-size: 14px; margin: 0 0 10px; padding: 8px 8px 8px 0;"> 
                                            <span>Name:</span> 
                                            <span style="font-weight: 400;">{{$data['targetDetails'][0]->name}}</span>
                                        </h3> 
                                        @endif

                                        <h3 class="box-title" style="margin: 0;">
                                         @if($data['targetDetails'][0]->profile_pic!='') 
                                         <img src="{{get_image_url_server(@$data['targetDetails'][0]->profile_pic,'package')}}" style="width:100px !important;height:100px;" width="100px" height="100px" class="img-responsive case_pic" alt="" >
                                          @else 
                                         <img src="{{asset('images/gravitor.jpg')}}" alt="gravitor" class="img-responsive case_pic">
                                         @endif</h3>
                                    </div>

                                    <div class="box-body table-responsive no-padding">
                                        <table class="table-bordered" id="printTable">
                                        @if(!empty($data['targetDetails'][0]->phone_number))
                                        <tr>
                                            <td class="left">Phone number:</td>
                                            <td class="right"> {{@$data['targetDetails'][0]->phone_number}}</td>
                                        </tr> 
                                        @endif     
                                        @if(!empty($data['targetDetails'][0]->profile_pic))
                                        <tr>
                                            <td class="left">Cell phone:</td>
                                            <td class="right">{{@$data['targetDetails'][0]->cell_phone}} </td>
                                        </tr> 
                                        @endif
                                        @if(!empty($data['targetDetails'][0]->address))
                                        <tr>
                                            <td class="left">Address:</td>
                                            <td class="right"> {{@$data['targetDetails'][0]->address}}</td>
                                        </tr>
                                        @endif
                                        @if(!empty($data['targetDetails'][0]->city))
                                        <tr>
                                            <td class="left">City:</td>
                                            <td class="right"> {{@$data['targetDetails'][0]->city}}</td>
                                        </tr>
                                        @endif
                                        @if(!empty($data['targetDetails'][0]->state))
                                        <tr>
                                            <td class="left">State:</td>
                                            <td class="right"> {{@$data['targetDetails'][0]->state}}</td>
                                        </tr>
                                        @endif
                                        @if(!empty($data['targetDetails'][0]->zip_code))
                                        <tr>
                                            <td class="left">Zip code:</td>
                                            <td class="right"> {{@$data['targetDetails'][0]->zip_code}}</td>
                                        </tr>
                                        @endif
                                        @if(!empty($data['targetDetails'][0]->email))
                                        <tr>
                                            <td class="left">Email addresses:</td>
                                            <td class="right"> {{@$data['targetDetails'][0]->email}}</td>
                                        </tr>
                                        @endif
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div> 
        </section>
    </div>
    @endif
    <!-- End Target Details-->

    

    <!-- Start Target Chart Details-->
<!--   <div class="page-break"></div> 
<div class="content-wrapper">
        <section class="content">
            <div class="panel panel-default">
                <section class="content-header">
                    <h1>{{_i(' Target Chart')}}</h1>
                </section>
                <div class="panel-heading"> </div>
                <div class="panel-body">
                    <div id="container"> <img src="http://34.211.31.84:7092/uploads/package/781071_1553272233.jpg" alt="gravitor" class="img-responsive case_pic" style="margin-top: 10px;">
                    </div>
               </div>
           </div>
       </section>
    </div>-->
    <!-- End Target Chart Details-->
    
    <div class="page-break"></div>
    
    <!-- Start Factor Details-->
    <div class="content-wrapper">
        <section class="content">
            <div class="panel panel-default">
                <section class="content-header" style="margin-bottom: 10px;">
                    <h1>{{_i('Factor')}}</h1>
                </section>  
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                             
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title"></h3>
                                </div>

                            @if(count($data['getAllSectorByCaseId'])>0)
                            <?php $i = 1;?>
                            @foreach($data['getAllSectorByCaseId'] as $row)   @if($i <=5)
                                <div class="box-body table-responsive no-padding">
                                    <table class="table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="heading" colspan="2">Factor {{$i}}</td>
                                            </tr>
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
                                            <?php $i++; ?>
                                            @endif
                                            @endforeach
                                            @else
                                            @endif


                            </div>
                        </div>
                    </div>
                </section>

            </div>    
        </section>    
    </div>
    <!-- End Factor Details-->
    
    <div class="page-break"></div>
    
    <!-- Start Tasks Details-->
    <div class="content-wrapper">
        <section class="content">
            <div class="panel panel-default">
                
                <section class="content-header" style="margin-bottom: 10px;">
                    <h1>{{_i('Tasks')}}</h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                             
                            <div class="box box-info">
                                <div class="box-header with-border">
                                   <h3 class="box-title"></h3>
                                </div>

                            @if(count($data['getAllTaskByCaseId'])>0) 
                            <?php $i = 1; ?>
                            @foreach($data['getAllTaskByCaseId'] as $row)   @if($i<=5)
                                <div class="box-body table-responsive no-padding">
                                    <table class="table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="heading" colspan="2">Task {{$i}}</td> 
                                            </tr>

                                            <tr>
                                                <td class="left">Title</td> 
                                                <td class="right"><?php echo $row->title; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Description</td>
                                                <td class="right"><p style="word-wrap: break-word; word-break: break-all;"><?php echo $row->description; ?></p></td>
                                            </tr>
                                            <tr>
                                                <td class="left">User Assigned</td>
                                                <td class="right"><?php echo $row->first_name." ".$row->last_name; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Status</td> 
                                                <td class="right"><?php echo getStatusTitle($row->status); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Due date</td>
                                                <td class="right"><?php echo date("F j, Y", strtotime($row->due_date)); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Date completed</td> 
                                                <td class="right"><?php //echo date("F j, Y", strtotime($row->due_date)); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php $i++; ?>
                                @endif
                                @endforeach
                                @else
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
    <!-- End Tasks Details-->
    
    <div class="page-break"></div>
    
    <!-- Start File Details-->
    <div class="content-wrapper">
        <section class="content">
            <div class="panel panel-default">
            
                <section class="content-header" style="margin-bottom: 10px;">
                    <h1>{{_i('File')}}</h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                             
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title"></h3>
                                </div>

                                
                            @if(count($data['fileDetails'])>0)
                            <?php $i = 1; ?>
                            @foreach($data['fileDetails'] as $row)   
                                <div class="box-body table-responsive no-padding">
                                    <table class="table-bordered">
                                        <tbody>                    
                                            <tr style="border-bottom: 1px">
                                                <td class="heading" colspan="2">File {{$i}}</td> 
                                            </tr>

                                            <tr style="border-bottom: 1px">
                                                <td class="left">Title</td> 
                                                <td class="right">
<!--                                                     <h3 class="box-title" style="margin-bottom:10px;">
                                                        @if($row->profile_pic!='') 
                                                        <img src="{{get_image_url_server($row->profile_pic,'package')}}" style="width:100px !important;height:100px;" width="100px" height="100px" class="img-responsive case_pic" alt="default_pic" >
                                                         @else 
                                                        <img src="{{asset('images/gravitor.jpg')}}" alt="gravitor" class="img-responsive case_pic">
                                                        @endif</h3>-->
                                                   {{ $row->title }}
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px">
                                                <td class="left">Description</td>
                                                <td class="right"><p style="word-wrap: break-word; word-break: break-all;"><?php echo $row->description; ?></p>
                                                </td>
                                            </tr>
                                            </tbody>
                                    </table>
                                </div>
                                            <?php $i++; ?>
                                            @endforeach
                                            @else
                                            @endif
                                        

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
    <!-- End File Details-->
    
    <div class="page-break"></div>
    
    <!-- Start Related Incidents Details-->
    <div class="content-wrapper">
        <section class="content">
            <div class="panel panel-default">
                <!-- Content Header (Page header) -->
                <section class="content-header" style="margin-bottom: 10px;">
                    <h1>{{_i('Related Incidents')}}</h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Horizontal Form -->
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title"></h3>
                                </div>

                                <!-- /.box-header -->

                            @if(count($data['incidentDetails'])>0)
                            <?php $i = 1;?>
                            @foreach($data['incidentDetails'] as $key=>$row) 
                            @if($i <= 5)
                                <div class="box-body table-responsive no-padding">
                                    <table class="table-bordered" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td class="heading" colspan="2">Incident {{$i}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Title</td> 
                                                <td class="right"><?php echo $row->title; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Description</td>
                                                <td class="right">
                                                    <p style="word-wrap: break-word; word-break: break-all;"><?php echo $row->description; ?></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left">Type</td>
                                                <td class="right"><?php echo $row->type; ?></td>

                                                </tr>
                                            <tr>
                                                <td class="left">Date/Time</td> 
                                                <td class="right">{{date("F j, Y H:i", strtotime($row->incident_datetime))}}</td>
                                                </tr>

                                            <tr>
                                                <td class="left">Created TimeStamp</td> 
                                                <td class="right">{{date("F j, Y H:i", strtotime($row->created_at))}}</td>
                                           </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php $i++; ?>
                            @endif
                            @endforeach
                            @else
                            @endif
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
    <!-- End Related Incidents Details-->

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