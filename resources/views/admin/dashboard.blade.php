@extends('layout.backened.header') @section('content')
<style type="text/css">.fullwidth{ width: 100% !important }</style>


<style type="text/css">
#container {
height: 400px;
width: 100%
}

.highcharts-figure, .highcharts-data-table table {
min-width: 310px;
max-width: 96%;
margin: 1em 0px 50px 20px;
}

.highcharts-figure-second, .highcharts-data-table table {
min-width: 310px;
max-width: 96%;
margin: 1em 0px 50px 20px;
}

#datatable {
font-family: Verdana, sans-serif;
border-collapse: collapse;
border: 1px solid #EBEBEB;
margin: 10px auto;
text-align: center;
width: 100%;
max-width: 500px;
}
#datatable caption {
padding: 1em 0;
font-size: 1.2em;
color: #555;
}
#datatable th {
font-weight: 600;
padding: 0.5em;
}
#datatable td, #datatable th, #datatable caption {
padding: 0.5em;
}
#datatable thead tr, #datatable tr:nth-child(even) {
background: #f8f8f8;
}
#datatable tr:hover {
background: #f1f7ff;
}
.highcharts-credits{ display: none; }    

</style>
<!-- Trigger the modal with a button -->
<button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
<div id="sectorDetails"></div>
<div class="table-section-main">
	<div class="container">
                @if(Session::has('add_message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {!! session('add_message') !!} 
                </div>
                @endif 						
        	   <div class="images-table-container">			
        				<div class="left-section">
        					<ul>
        						<?php foreach (@$data['caseList'] as $key => $row) { ?>
        							<li>
        								<div class="image-box">
        									@if(@$row->default_pic!='')
        										<img src="{{get_image_url(@$row->default_pic,'package')}}"  style="height:120px;">
        									@else
        										<img src="{{asset('images/gravitor.jpg')}}"  style="height:120px;">
        										
        									@endif
        									
        									<div class="overlay">
        										<h3><a href="{{route('admin-viewCase',['id'=>$row->id])}}" ><?php echo substr($row->title, 0,30); ?></a></h3>
        									</div>
        								</div>
        							</li>
        						<?php } ?>						
        					</ul>
        				</div>
                        <?php 
                        $user_role_name = Session::get('user_role_name');
                        if ($user_role_name!="superAdmin")
                        {
                            $widthFull='';
                            if($request->session()->get('user_role_id')==4){
                                $widthFull = 'fullwidth';
                            }
                        ?>
        				<div class="right-section <?= $widthFull ?>">
        					<div class="task-table-wrapper ">
        						<table id="task-table1" class="dashboard-table table table-striped table-bordered nowrap" style="width:100%">
        							<thead>
        								<tr>
        									<th  class="col-sm-2" >Tasks</th>
                                            <th class="col-sm-2" >Case</th>
        									<th class="col-sm-2" >Incident</th>
        									<th  class="col-sm-1">Status</th>
        									<th  class="col-sm-1">Due Date</th>								   
        								</tr>
        							</thead>
        							<tbody>
        									@if(count($data['getAllAssignedTaskByUserId'])>0)
            									@foreach($data['getAllAssignedTaskByUserId'] as $row)  												  
            									<tr>									   
            										<td><a href="javascript:task_link_modal({{$row->id}},'{{route('admin-ajaxGetTaskDetailsChangeStatus')}}');"><?php echo $row->title; ?></a></td>
            										<td><?php $caseNames = array(); if(!empty(@$row->casetasklist)){ foreach(@$row->casetasklist as $innerKey=>$innerValue){ $caseNames[] = $innerValue->case->title;} } ?> {!! implode('<br> ',$caseNames) !!} </td> 
                                                    <td><?php $caseNames = array(); if(!empty(@$row->incidenttasks)){ foreach(@$row->incidenttasks as $innerKey=>$innerValue){ $caseNames[] = $innerValue->incident->title;} } ?> {!! implode('<br> ',$caseNames) !!} </td>
            										<td><?php echo getStatusTitle($row->status); ?></td>										
            										<td ><?php echo date("F j, Y", strtotime($row->due_date)); ?></td>									
            									</tr>
                                                @endforeach
        								   @else
            								<tr class="bg-info">
            									<td colspan="5">Record(s) not found.</td>
            								</tr>
        								@endif
        							</tbody>       
        						</table>
        					</div>
        				</div>
        				<?php } ?>				
        		</div>    <!-- End images-table-container -->
	                           <!-- /.box-header -->
            <div class="reports-table">
                <div class="row">
                    <div class="col-sm-12 m_top25">
                    <?php 
                    $allowRolesList = array("agencySuperAdmin", "agencyAdmin");
                    $user_role_name = Session::get('user_role_name');
                    if (in_array($user_role_name, $allowRolesList)){?>
                    <a href="{{route('admin-addCase')}}" class="btn btn-info min-120 m_btm15 m_rgt5"><i class="fa fa-plus"></i> New Case</a>
                    
                    <a href="{{route('admin-caseList')}}" class="btn btn-default min-120 m_btm15">All Cases</a>
                    <?php } ?>
                    </div>  
                </div>
                <div class="spacer7"></div>
                <div id="alertmsg"></div>  
                <form id="user-mng" method="get" action="{{route('admin-dashboard')}}">
                    {{ csrf_field() }}
                    
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Keyword')}}" type="text">
                                </div>
                            </div>
                        </div> 
                        @if(in_array($request->session()->get('user_role_id'), array(1,2)) ) 
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="form-line">
                                <select name="group_filter" class="form-control" id="group">
                                    <option value="">Select Group</option>
                                    @if(count($group)>0)
                                    @foreach($group as $row) 
                                    <?php 
                                    $selectedClass = (isset($_GET['group_filter']) && $_GET['group_filter']==$row->id)?'selected':'';
                                    ?>  
                                    <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?> > <?php echo $row->name ?></option>
                                  @endforeach


                                  @endif
                                  </select>
                                </div>
                            </div>
                        </div>
                        @endif 
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary btn-info">{{_i('Search')}}<div></div></button>
                            <a href="{{route('admin-dashboard')}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                            <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                        </div>                            
                    </div>
                </form>
				<div class="task-table-wrapper">
					<table id="report-table" class="dashboard-table table table-striped table-bordered nowrap" style="width:100%">
						<thead>
							 <tr>
                               <!-- <th>Sr.No.</th> -->
                                <th >{{_i('Title')}}</th>
								@if(Session::get('user_role_id')<3)<th>Account</th>@endif
                                <th>Name</th>
                                <th>{{_i('Email Address')}}</th>
                                <th>{{_i('Phone No.')}}</th>
								@if(Session::get('user_role_id')<3)<th>{{_i('Group.')}}</th>@endif
                                <th>{{_i('Created Date')}}</th>
                                
                            </tr>
						</thead>
						<tbody>
							 @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                            <tr>
                               <!-- <td scope="row">{{$k}}</td>-->
								 <td><a target="_blank"  href="{{route('admin-viewReport',['id'=>$row->id])}}">{{wordwrap($row->title, 15, "\n", true)}} </a></td>
                               
								 @if(Session::get('user_role_id')<3)<td>{{wordwrap($row->account_name, 15, "\n", true)}}</td> @endif
                                <td>{{wordwrap($row->name, 15, "\n", true)}}</td>
                                <td>{{wordwrap($row->email_address, 15, "\n", true)}}</td>
                                <td>{{wordwrap($row->phone_no, 15, "\n", true)}}</td>
								@if(Session::get('user_role_id')<3)<td>  <select name="group_id" class="form-control groupid" id="{{$row->id}}" >
                                <option value="">Select</option>
                                    @if(count($group)>0)
                                    @foreach($group as $rowgroup) 
                                    <?php $selectedClass = (isset($row->reportGroup) && $row->reportGroup->group_id==$rowgroup->id)?'selected':''; ?>  
                                    <option value="<?php echo $rowgroup->id; ?>" <?php echo $selectedClass; ?>><?php echo $rowgroup->name ?></option>
                                    @endforeach
                                    @endif
                          </select> </td>	@endif							
                                <td>{{date("F j, Y", strtotime($row->created_at))}}</td>
                                
                            </tr>
								 <?php $k++; ?>     
								@endforeach
								@else
								
								@endif
						</tbody>
					</table>
				</div>
                    <?php if(!empty($k)&&$k>6){?>
                    <a href="javascript:void(0);" id="show_more" class="btn btn-block btn-primary">View More</a> 
                    <a href="javascript:void(0);" id="show_less" class="btn btn-block btn-primary" style="display:none;">Less More</a>
                    <?php }?>
			</div>  <!-- reports-table -->
	   </div>
                @if(in_array($request->session()->get('user_role_id'), array(1,2,3,4)) ) 
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-line">
                        <select name="groupgragh" class="form-control groupgragh" id="groupgragh">
                            <option value="">Select Group</option>
                            @if(count($group)>0)
                            @foreach($group as $row) 
                            <?php  $selectedClass = ( count($group)==1)?'selected':'';  ?>  
                            <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?> > <?php echo $row->name ?></option>
                          @endforeach


                          @endif
                          </select>
                        </div>
                    </div>
                </div>
                @endif 
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-line">
                            <?php $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'Octber', 11 => 'November', 12 => 'December'); ?>
                        <select name="monthgragh" class="form-control groupgragh" id="monthgragh">
                            <option value="">Select Month</option>
                            <?php foreach ($months as $num => $name) { ?>
                                <option data-monthname = "<?php echo $name;?>"  <?php if($num == date('m')){ echo 'selected= selected';} ?> value="<?php echo $num;?>"><?php echo $name;?></option>
                            <?php }?>
                          </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-line">
                        <select name="yeargragh" class="form-control groupgragh" id="yeargragh">
                            <?php for ($year = 2018; $year<=date('Y'); $year++) { ?>
                                <option <?php if($year == date('Y')){ echo 'selected= selected';} ?> value="<?php echo $year;?>"><?php echo $year;?></option>
                            <?php }?>
                          </select>
                        </div>
                    </div>
                </div>

                <figure class="highcharts-figure">
                    <div id="container"></div>
                    <div id="incidentsrecords"></div>
                </figure>
                <div class="row">
                    <div class="col-sm-3 " style="margin-left: 22px;">
                    <div class="form-group">
                        <div class="form-line">
                        <select name="groupgraghsecond" class="form-control groupgraghsecond" id="groupgraghsecond">
                            <option value="">Select Group</option>
                            @if(count($group)>0)
                            @foreach($group as $row) 
                            <?php  $selectedClass = ( count($group)==1)?'selected':'';  ?>  
                            <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?> > <?php echo $row->name ?></option>
                          @endforeach


                          @endif
                          </select>
                        </div>
                    </div>
                    </div> 
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-line">
                        <select name="yeargragh" class="form-control groupgraghsecond" id="yeargragh">
                            <?php for ($year = 2018; $year<=date('Y'); $year++) { ?>
                                <option <?php if($year == date('Y')){ echo 'selected= selected';} ?> value="<?php echo $year;?>"><?php echo $year;?></option>
                            <?php }?>
                          </select>
                        </div>
                    </div>
                </div> 
                </div>
                <figure class="highcharts-figure-second">
                    <div id="containersecond"></div>
                    <div id="incidentsrecords"></div>
                </figure>
</div>

<script src="{{asset('js/code/highcharts.js')}}"></script> 
<script src="{{asset('js/code/modules/data.js')}}"></script> 
<script src="{{asset('js/code/modules/exporting.js')}}"></script> 
<script src="{{asset('js/code/modules/accessibility.js')}}"></script> 


    <script type="text/javascript">
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $( document ).ready(function() {
        $(".groupgragh").change(function(){
                var groupId = $("select[name=groupgragh]").val();
                var monthgragh = $("select[name=monthgragh]").val();
                var yeargragh = $("select[name=yeargragh]").val();
                var monthname = $(this).find(':selected').data("monthname");
                var monthname = $("select[name=monthgragh] :selected").text();
                if(monthname == 'Select Month'){ monthname =' ';}
                $.ajax({
                type:'POST',
                url:"{{ route('admin-datatable-records') }}",
                data:{groupId:groupId,monthgragh:monthgragh,yeargragh:yeargragh},
                success:function(data){
                $('#incidentsrecords').html(data);
                var text = 'Incident During  ' + monthname + '   ' +  yeargragh;
                camparechart(text);
                }
                });
        }).change();

         $(".groupgraghsecond").change(function(){
                var groupId = $("select[name=groupgraghsecond]").val();
                var yeargragh = $("select[name=yeargragh]").val();
                var groupName = $("select[name=groupgraghsecond] :selected").text();
                if(groupName == 'Select Group'){ groupName ='All Groups';}
                $.ajax({
                type:'POST',
                url:"{{ route('admin-datatable-monthy-records') }}",
                data:{groupId:groupId,yeargragh:yeargragh},
                success:function(data){
                $('#incidentsrecords').html(data);
                var text = 'Alert for :  '+ groupName;
                camparechartsecond(text);
                }
                });
        }).change();

});



        var text = '';
        camparechart(text);
        function camparechart(text){
            Highcharts.chart('container', {
            data: {
            table: 'datatable'
            },
            chart: {
            type: 'column'
            },
            title: {
            text: text
            },
            yAxis: {
            allowDecimals: false,
            title: {
            text: 'Units'
            }
            },
            tooltip: {
            formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
            this.point.y + ' ' + this.point.name.toLowerCase();
            }
            },
            legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            itemMarginTop: 20,
            itemMarginBottom: 0
            },
            }); 
        }
        function camparechartsecond(text){
            Highcharts.chart('containersecond', {
            data: {
            table: 'datatable'
            },
            chart: {
            type: 'column'
            },
            title: {
            text: text
            },
            yAxis: {
            allowDecimals: false,
            title: {
            text: 'Units'
            }
            },
            tooltip: {
            formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
            this.point.y + ' ' + this.point.name.toLowerCase();
            }
            },
            legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            itemMarginTop: 20,
            itemMarginBottom: 0
            },
            }); 
        }
    </script>
<script src="{{asset('js/tasklist.js')}}"></script> 
@endsection