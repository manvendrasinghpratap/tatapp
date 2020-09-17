@extends('layout.backened.header')
@section('content')
<style>
.width15per{ width: 15%;}
.margintopminus48{margin-top: 0px !important;}
</style>
<?php //dd($data); ?>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h3 class="paddingbottom10px">Team</h3>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Team</li>
            <div class="margintopminus48">	
                <input type="hidden" id="filename" name="filename" value="Team">	
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

                        <form id="user-mng" method="get" action="{{route('admin-users')}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-2 width15per">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="Keyword" type="text">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-2 width15per">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="status">
                                                <option value="">Select Status</option>
                                                <option value="1" <?php echo  (isset($_GET['status']) && $_GET['status']==1)?'selected':''; ?>>Active</option>
                                                <option value="2" <?php echo  (isset($_GET['status']) && $_GET['status']==2)?'selected':''; ?>>In Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                            <?php

                            $user_role_name = Session::get('user_role_name');

                            if ($user_role_name=="superAdmin")
                            {
                            ?>
                                 <div class="col-sm-2 width15per">
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


                                <div class="col-sm-2 width15per ">
                                    <div class="form-group">
                                        <div class="form-line">
                                             <select name="role_id" class="form-control" id="role_id">
                                            <option value="">Select Role</option>
                                            <?php foreach($roleList as $key=>$val){ 
            $activeClassRoleId = (isset($_GET['role_id']) && $_GET['role_id']==$val->id)?'selected':'';
                                              ?>

                                            <option <?php echo $activeClassRoleId; ?> value="<?php echo $val->id; ?>"><?php echo $val->display_name; ?></option>
                                            <?php
                                                }
                                            ?>
                                            
                                        </select>
                                        </div>
                                    </div>
                                </div>  


                                <?php } ?>       
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-primary btn-info">Search<div></div></button>
                                    <a href="{{route('admin-users')}}" class="btn btn-primary btn-success">Reset</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                                </div>
                                @if($user_role_id<3)
                                    <div class="col-sm-2 pull-right width15per">
                                        <a href="{{route('admin-adduser')}}" class="btn btn-block btn-warning">Add User</a>
                                    </div>
                                @endif
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
                                <th>Name</th>
                                <th width="20%">Email</th> 
                                @if(in_array($request->session()->get('user_role_id'), array(1,2)) )  
                                <th>Account</th>
                               @endif
                                <th>Role</th>   
                                @if(in_array($request->session()->get('user_role_id'), array(1,2)) )  
                                <th>Group</th>
                               @endif
                                <th>Total Case</th>     
                                <th>Status</th>
                                <th>Created Date</th>
                                @if($user_role_id<=20)
                                <th class="ignore" width="15%">Action</th>
                                @endif
                            </tr> 
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                            <tr>
                               <!-- <td scope="row">{{$k}}</td>-->
                                <td>{{$row->first_name.' '.$row->last_name}}</td>
                                <td>{{$row->email}}</td> 
                                @if(in_array($request->session()->get('user_role_id'), array(1,2)) )  
                                <td>{{$row->accountName}}</td> 
                                @endif
                                <td>{{$row->rolesDisplayName}}</td> 
                                @if(in_array($request->session()->get('user_role_id'), array(1,2)) )  
                                <td> @php $usergrouparray = array(); @endphp
                                @if($row->userGroup->count() >0 ) 
                                   @foreach($row->userGroup as $userassigntogrougs)
                                        @php $usergrouparray[] = $userassigntogrougs->group->name; @endphp
                                    @endforeach
                                    @endif
                                   {{ implode(', ',$usergrouparray) }}
                                </td> 
                                @endif
                                <td><?php echo count($row->caselistsOwner); ?></td> 
                                <td>@if($row->status=='1'){{'Active'}}@else{{'In-Active'}}@endif</td>
                                <td>{{date("F j, Y", strtotime($row->created_at))}}</td>
                                @if($user_role_id<=20)
                                <td class="ignore">
                                 @if($row->id!=session('id'))  
                                    
                                    <a href="{{route('admin-userdetail',['id'=>$row->user_id])}}" class="btn btn-info btn-xs action-btn" title ="View Detail"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                    @if(Session::get('user_role_id')<4 )
                                    <a href="{{route('admin-edituser',['id'=>$row->user_id])}}" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    @endif

                                 <?php if(count($row->caselists)<=0 && (Session::get('user_role_id')<3) ){ ?>

                                    <a href="{{route('admin-deleteuser',['id'=>$row->user_id])}}" class="btn btn-danger btn-xs action-btn" onclick="return confirm('Are you sure you want to delete ?');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                <?php } ?>
                                   @endif
                                </td>
                                @endif
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
