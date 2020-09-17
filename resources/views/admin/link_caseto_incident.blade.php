<?php //dd($data); ?>
@extends('layout.backened.header')
@section('content')
<div id="caseDetails">
    
</div>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{_i('Manage Case')}}</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>{{_i('Home')}}</a></li>
            <li class="active">{{_i('Manage Case')}}</li>
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
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="status">
                                                 <option value="">Select</option>
                                                 <option value="new" <?php echo  (isset($_GET['status']) && $_GET['status']=='new')?'selected':''; ?>>New</option>
                                                <option value="active" <?php echo  (isset($_GET['status']) && $_GET['status']=='active')?'selected':''; ?>>Active</option>


                                                 <option value="closed" <?php echo  (isset($_GET['status']) && $_GET['status']=='closed')?'selected':''; ?>>Closed</option>
                                                <option value="archived" <?php echo  (isset($_GET['status']) && $_GET['status']=='archived')?'selected':''; ?>>Archived</option>


                                            </select>
                                        </div>
                                    </div>
                                </div> 

                                 <?php

                            $user_role_name = Session::get('user_role_name');

                            if ($user_role_name=="superAdmin")
                            {
                            ?>
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="account_id">
                                                <option value="">Select Account</option>
                                                 <?php foreach($account_list as $key=>$val){ 
                                                //dd($val);
                    $activeClass = (isset($_GET['account_id']) && $_GET['account_id']==$val->id)?'selected':'';
                                              ?>

                                            <option value="<?php echo $val->id; ?>" <?php echo $activeClass; ?>><?php echo $val->name; ?></option>
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
                                    <a href="" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                    
                                    <!-- <a href="{{route('admin-download-pdf-caseList')}}" class="btn btn-primary btn-success">
                                   <span class="glyphicon glyphicon-download" aria-hidden="true"></span> PDF</a> -->
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

                    <!-- /.box-header -->
					<form class="form-horizontal"  action="{{route('admin-linkincidentToCaseAction')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
                    <div class="box-body table-responsive no-padding">
                        <table class="table" id="printTable">
                            <tr>
                               <!-- <th>Sr.No.</th>-->
								<th width="15%">{{_i('Select')}} <input type="hidden"  value="{{$incidentid}}" name="incidentid"></th>
                                <th width="25%">{{_i('Title')}}</th>
								
                                <th>Assign To</th>
                                <!-- <th width="15%">{{_i('Account')}}</th> -->
                                <th>{{_i('Status')}}</th>
                                <th>{{_i('Created Date')}}</th>
                                
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
							<?php $trstyle='';	$linkchecked=''; //echo '<pre>'; print_r($row);
							/*if($row->id==$row->linked_caseid){
								$trstyle='btn-success';
								$linkchecked="checked=checked";
							} */
								
							//echo $row->linkedid;
							if($row->id!=$row->linked_caseid){
							?>
							
                            <tr class="<?php //echo $trstyle;?>">
                               <!-- <td scope="row">{{$k}}</td>-->
								
								<td> 
								
								<input type="checkbox" <?php //echo $linkchecked;?> class="linkchecked" value="{{$row->id}}" name="caseid[]">
								
								
								</td>
                                <td> <a target="_blank"  href="{{route('admin-viewReport',['id'=>$row->id])}}"><?php 
                            echo $row->title;

                                        ?></a></td>
                                <td>{{$row->CaseOwnerName[0]->first_name}}</td>
                                <!-- <td>{{$row->name}}</td> -->
                                <td>{{$row->status}}</td>
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
					<div class="box-footer">
						<a href="{{route('admin-editIncident',@$incidentid )}}" class="btn btn-default">Cancel</a>
						<input type="submit" name="caselink" id="add-button" value="Link to Incident" class="btn btn-info">
						
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
						<!--<input type="submit" name="caseunlink"id="add-button" value="Click Here to Un-Link to Incident" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link selected case to Incident?')">-->
					 </div>
					 </form>
                    <!-- /.box-body -->
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
<script src="{{asset('js/caseList.js')}}"></script>
@endsection