<?php //dd($data); ?>
@extends('layout.backened.header')
@section('content')
<style>
    .margintopminus48{margin-top: 0px !important;}
</style>
<div id="caseDetails">  </div>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
        <section class="content-header">
        <h3>{{_i('Cases')}}</h3>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Cases</li>
            <div class="margintopminus48">	
                <input type="hidden" id="filename" name="filename" value="Cases">	
                <a href="javascript:void(0)" id="csv" class="btn btn-info btn-xs action-btn edit" title ="Download CSV File"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span></a>        		 
            </div>
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
                        <form id="user-mng" method="get" action="{{route('admin-caseList')}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Keyword')}}" type="text">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-2" style="width:13%;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="status">
                                                 <option value="">Status</option>
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
                                 <div class="col-sm-1" style="width:10%;" >
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="account_id">
                                                <option value="">Account</option>
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

                               @if(Session::get('user_role_id')<3)
                                <div class="col-sm-1" style="width:10%;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="group_filter" class="form-control" id="group">
                                            <option value="">Group</option>
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
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-primary btn-info">{{_i('Search')}}<div></div></button>
                                    <a href="{{route('admin-caseList')}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
           
                                <?php 
            $allowRolesList = array("agencySuperAdmin", "agencyAdmin");
            $user_role_name = Session::get('user_role_name');
            if (in_array($user_role_name, $allowRolesList))
            {
            ?>
            <div class="col-sm-3 pull-right">
                                        <a href="{{route('admin-addCase')}}" class="btn btn-block btn-warning">Add Case</a>
            </div>
            <?php } ?>
            <?php
			$getAccessListArray = getAccessList($user_role_name);
			if(count($getAccessListArray)>0){ 

              if (array_key_exists("sector",$getAccessListArray))
                {?>
			<div class="col-sm-3 pull-right">
                  <a href="{{route('admin-sector-list')}}" class="btn btn-block btn-primary"><i class="fa fa-user-secret"></i> &nbsp;Manage Sectors</a>
			</div>
			<?php }}?>
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
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="printTable">
                            <tr>
                                <!--<th>Sr.No.</th>-->
                                <th width="25%">{{_i('Title')}}</th>
                                <th>Assign To</th>
                                @if(Session::get('user_role_id')<=2) <th width="15%">{{_i('Group')}}</th> @endif
                                <th>Tasks</th>
                                <th>{{_i('Status')}}</th>
                                <th>{{_i('Created Date')}}</th>
                                @if(Session::get('user_role_id')<=4)<th class= "ignore" width="10%">{{_i('Action')}}</th>@endif
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                            <tr>
                               <!-- <td scope="row">{{$k}}</td>-->
                                <td>{{@$row->title}}</td>
                                <td>{{ @$row->CaseOwnerName[0]->first_name}}  </td>
                                @if(Session::get('user_role_id')<=2)<td> @if(isset($row->caseGroup->group->name)) {{ $row->caseGroup->group->name}} @endif</td>  @endif
                                <td><?php  $taskarray = array(); if(!empty($row->case) ){
                                    foreach ($row->case as $key => $value) {
                                            $taskarray[] = @$value->task->title;
                                    }
                                }?> {!! implode('<br>',$taskarray) !!}</td>
                                <td>{{$row->status}}</td>
                                <td>
                                    {{date("F j, Y", strtotime($row->created_at))}}

                                </td>
                                
                                <td class= "ignore">
                                     
                                    <a href="{{route('admin-viewCase',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="View Detail"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                    <a href="{{route('admin-download-case-pdf-log',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Download Pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>                                     
                                    <!-- <a href="{{route('admin-editCase',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Edit Package"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> -->
                                    @if(Session::get('user_role_id')<=3)
                                    <a href="#" class="btn btn-info btn-xs action-btn deleteCase" title ="Delete"  data-link1="{{route('admin-ajaxViewCase')}}" data-link2="{{$row->id}}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                    @endif    

                                </td>
                                
                            </tr>
                            <?php $k++; ?>     
                            @endforeach
                            @else
                            <tr class="bg-info">
                                <td colspan="8">Record(s) not found.</td>
                            </tr>
                            @endif
                        </table>
                    </div>
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
