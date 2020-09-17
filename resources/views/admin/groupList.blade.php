@extends('layout.backened.header')
@section('content')
<?php
//dd($data);
?>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h3 class="paddingbottom10px">{{_i('Groups')}}</h3>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Groups</li>
        </ol>
        <div class="margintopminus48">	
            <input type="hidden" id="filename" name="filename" value="Groups">	
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
                    </div>
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>

                        <form id="user-mng" method="get" action="{{route('admin-groups')}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="Group Name" type="text">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-primary btn-info">Search<div></div></button>
                                    <a href="{{route('admin-groups')}}" class="btn btn-primary btn-success">Reset</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                                </div>
                                @if($user_role_id<=2)
                                    <div class="col-sm-2 pull-right">
                                        <a href="{{route('admin-add-group')}}" class="btn btn-block btn-warning">Add Group</a>                                  
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
                                <th>User's</th>
                                @if($user_role_id==1) <th>Account</th> @endif
                                <th>Time Zone</th>
                                <th>Created Date</th>
                                <th class="ignore" width="15%">Action</th>
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)

                            <tr>
                                <td> {{ $row->name }}</td>
                                <td>
                                    @foreach(@$row->userGroup as $user)
                                    <p> {{ @$user->users->first_name." ".@$user->users->last_name }}</p>
                                    @endforeach
                                </td>
                                @if($user_role_id==1) <td>@if(@$row->accountGroup){{ @$row->accountGroup->account->name }} @endif</td> @endif
                                <td>{{ $row->timezone }} </td>
                                <td>{{date("F j, Y", strtotime($row->created_at))}} </td>
                                
                                <td class="ignore">
                                    <a href="{{route('admin-edit-group',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    @if(Session::get('user_role_id')<3)
                                    <a href="{{route('admin-group-delete',[$row->id])}}" class="btn btn-danger btn-xs action-btn" onclick="return confirm('Are you sure you want to delete this group ?');" title ="Delete Group "><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                @endif
                                </td>
                            </tr>
                                <tr style="display: none;" class="embedClass"><td colspan="8">
                <div class="col-sm-8">
                                    <textarea rows="2" cols="80" style="font-size: 12px;"><iframe type="text/html" width="100%" height="100%" src="{{route('report-home',['id'=>base64_encode($row->id)])}}" frameborder="0" allowfullscreen></iframe></textarea>
                                    <button type="submit" class="btn btn-primary btn-info selectClass">Select All<div></div></button>
                                    <button  class="btn btn-primary hidden-copy copyClass"> Select & Copy</button>
                                    <a href="{{route('report-home',['id'=>base64_encode($row->id)])}}" target="_blank"><button  class="btn btn-warning hidden-copy copyClass"> View Link</button></a>
                                    <button  class="btn btn-primary hidden-copy closeClass"> Close </button>
               </div>
</td></tr>
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
<script type="text/javascript">
    $(".selectClass").click(function(){
        //$(this).closest("div").css({"color": "red", "border": "2px solid red"});
        $(this).closest("div").find( "textarea" ).select().css({"color": "red", "border": "2px solid red"});
   
});

    $(".copyClass").click(function(){
    $(this).closest("div").find( "textarea" ).select().css({"color": "red", "border": "2px solid red"});
    document.execCommand('copy');
});
$(".closeClass").click(function(){
   $(".embedClass").hide("slow");
});


$(document).ready(function(){
    $(".showEmbedCode").click(function(){
        //var p1 = $(this).closest('tr').next('tr').html();
       // $(this).closest('tr').next('tr').toggleClass("show");
       
        $(".embedClass").hide("slow");
        $(this).closest('tr').next('tr').show("slow");
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
