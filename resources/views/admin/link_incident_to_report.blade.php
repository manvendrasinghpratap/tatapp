<?php //dd($data); ?>
@extends('layout.backened.header')
@section('content')

<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{_i('Manage Report')}}</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>{{_i('Home')}}</a></li>
            <li class="active">{{_i('Manage Report')}}</li>
        </ol>
    </section>

   
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                           <h3 class="box-title"></h3>
              @if(Session::has('add_message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('add_message') !!} 
                </div>
                @endif

                        <form id="user-mng" method="get" action="">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Keyword')}}" type="text">
                                        </div>
                                    </div>
                                </div> 
                                

                                 <?php

                            $user_role_name = Session::get('user_role_name');

                            if ($user_role_name=="superAdmin")
                            {
                            ?>
                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="account_id">
                                                <option value="">Select Account</option>
                                                 <?php foreach($account_list as $key=>$val){ 
                                                //dd($val);
                    $activeClass = (isset($_GET['account_id']) && $_GET['account_id']==$val->id)?'selected':'';
                                              ?>

                                            <option value="<?php echo $val->id; ?>" <?php echo $activeClass; ?>><?php echo $val->name; ?>(<?php echo $val->total; ?>)</option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                                <?php } ?>    


                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-primary btn-info">{{_i('Search')}}<div></div></button>
                                    <a href="{{route('admin-linkincidentToReport',['id'=>@$incidentid])}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                   
                                </div>
                        
                                    
                            </div>
                        </form>

                        @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! session('message') !!} 
                        </div>
                        @endif
                    </div>
					<form class="form-horizontal"  action="{{route('admin-linkincidentToReportAction')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table" id="printTable">
                            <tr>
                                <!--<th>Sr.No.</td></th>-->
								<th width="15%">{{_i('Select')}}<input type="hidden"  value="{{$incidentid}}" name="incidentid"></th>
                                <th width="25%">{{_i('Title')}}</th>
                               <?php
                                if ($user_role_name=="superAdmin")
                                {
                                ?>
                                <th>Account</th>
                                <?php } ?>
                                <th>Name</th>
                                <th>{{_i('Email Address')}}</th>
                                <th>{{_i('Phone No.')}}</th>
                                <th>{{_i('Created Date')}}</th>
                               
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
							<?php $trstyle='';	$linkchecked=''; //echo '<pre>'; print_r($row);
							/*if($row->id==$row->linked_reportid){
								$trstyle='btn-success';
								$linkchecked="checked=checked";
							} */
								
							//echo $row->linkedid;
							if($row->id!=$row->linked_reportid){
							?>
                            <tr class="<?php //echo $trstyle;?>">
                              <!--  <td scope="row">{{$k}}</td>-->
								 <td scope="row">
								 
								 <input type="checkbox" <?php //echo $linkchecked;?> class="linkchecked" value="{{$row->id}}" name="reportid[]">
								  
					   
								  
					   
                                <td> <a target="_blank"  href="{{route('admin-viewReport',['id'=>$row->id])}}">{{wordwrap($row->title, 15, "\n", true)}} </a></td>
                                <?php
                                if ($user_role_name=="superAdmin")
                                {
                                ?>
                                <td>{{wordwrap($row->account_name, 15, "\n", true)}}</td> 
                                <?php } ?>
                                <td>{{wordwrap($row->name, 15, "\n", true)}}</td>
                                <td>{{wordwrap($row->email_address, 15, "\n", true)}}</td>
                                <td>{{wordwrap($row->phone_no, 15, "\n", true)}}</td>

                                
                                <td>
                                    {{date("F j, Y", strtotime($row->created_at))}}

                                </td>
                               
                            </tr>
                            <?php }
							$k++; ?>     
                            @endforeach
                            @else
                            <tr class="bg-info">
                                <td colspan="8">Record(s) not found.</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <!-- /.box-body -->
					<div class="box-footer">
						<a href="{{ url()->previous() }}" class="btn btn-default">Cancel</a>
						<input type="submit" name="reportlink" id="add-button" value="Link to Incident" class="btn btn-info">
						
						<script>
						$(document).ready(function() {
							$('#add-button').on('click', function(){
								if($('#printTable input:checkbox:checked').length<=0){
									alert("Please choose any checkbox for Link to Incident");
									return false;
								}
							});
							});
						</script>
						<!--<input type="submit" name="reportunlink"id="add-button" value="Click Here to Un-Link to Incident" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link selected Report to Incident?')">-->
					 </div>
					 </form>
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {!! $data['records']->links() !!}
                        </ul>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
	 </div>
</div>

@endsection