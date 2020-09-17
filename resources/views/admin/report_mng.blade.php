@extends('layout.backened.header')
@section('content')

<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
        <section class="content-header">
            <h3 class="paddingbottom10px">Reports</h3>        
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
                <li class="active">Reports</li>
            </ol>
            <div class="margintopminus48">	
                <input type="hidden" id="filename" name="filename" value="Reports">	
                <a href="javascript:void(0)" id="csv" class="btn btn-info btn-xs action-btn edit" title ="Download CSV File"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span></a>        		 
                  </div>
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

                        <form id="user-mng" method="get" action="{{route('admin-reportList')}}">
                            {{ csrf_field() }}
                            
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Keyword')}}" type="text">
                                        </div>
                                    </div>
                                </div> 
                                @if(in_array($request->session()->get('user_role_id'), array(1)) )  
                                 <div class="col-sm-2">
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
                                @endif 
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
                                    <a href="{{route('admin-reportList')}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
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
                    <div id="alertmsg"></div>                                
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="printTable">
                            <tr>
                                <!--<th>Sr.No.</th>-->
                                <th width="20%">{{_i('Title')}}</th>
                                 @if(in_array($request->session()->get('user_role_id'), array(1,2)) )  
                                <th>Account</th>
                                @endif
                                <th>Name</th>
                                <th>{{_i('Email Address')}}</th>
                                <th>{{_i('Phone No.')}}</th>
                                @if(Session::get('user_role_id')<3)<th>{{_i('Group.')}}</th>@endif
                                <th>{{_i('Created Date')}}</th>
                                @if(in_array($request->session()->get('user_role_id'), array(1,2)) ) 
                                <th class="ignore" width="10%">{{_i('Action')}}</th>
                                @endif
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                            <tr>
                                <!--<td scope="row">{{$k}}</td>-->
                                <td>{{wordwrap($row->title, 15, "\n", true)}} </td>
                                @if(in_array($request->session()->get('user_role_id'), array(1,2)) ) 
                                <td>{{wordwrap($row->account_name, 15, "\n", true)}}</td> 
                                @endif
                                <td>{{wordwrap($row->name, 15, "\n", true)}}</td>
                                <td>{{wordwrap($row->email_address, 15, "\n", true)}}</td>
                                <td>{{wordwrap($row->phone_no, 15, "\n", true)}}</td>                                
                                @if(Session::get('user_role_id')<3)
                                <td class="ignore"> 
                               
                                <select name="group_id" class="form-control groupid" id="{{$row->id}}" >
                                <option value="">Select</option>
                                    @if(count($group)>0)
                                    @foreach($group as $rowgroup) 
                                    <?php $selectedClass = (isset($row->reportGroup) && $row->reportGroup->group_id==$rowgroup->id)?'selected':''; ?>  
                                    <option value="<?php echo $rowgroup->id; ?>" <?php echo $selectedClass; ?>><?php echo $rowgroup->name ?></option>
                                    @endforeach
                                    @endif
                          </select> 
                          </td>
                          @endif                              
                                <td>{{date("F j, Y", strtotime($row->created_at))}}</td>
                                @if(in_array($request->session()->get('user_role_id'), array(1,2)) ) 
                                <td>                                     
                                    <a href="{{route('admin-viewReport',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="View Report"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                    <a href="{{route('admin-delete-report',['id'=>$row->id])}}" class="btn btn-danger btn-xs action-btn" onclick="return confirm('Are you sure you want to delete ?');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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

<script>

$(document).ready(function() {
    $(".groupid").change(function(event) {
        if(confirm('Do You want to change Group')){
        var report_id = event.target.id;
        var group_id = event.target.value;
        $.ajax({
                type: "POST",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('admin-updatereporttogroup')}}",
                data:{report_id: report_id, group_id: group_id},
                success: function (data) {  
                    if(data==1){
                        var html  = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Group Assigned successfully.</div>'
                        $('#alertmsg').html(html);
                    }
                    if(data==0){
                        var html  = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Report Updated successfully.</div>'
                        $('#alertmsg').html(html);
                    }
                }
                });
        }else{
            location.reload(true);
            
        }
        
    });
});
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
