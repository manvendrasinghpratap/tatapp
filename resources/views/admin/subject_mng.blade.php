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
        <h3 class="paddingbottom10px">{{_i('Manage Subjects')}}</h3>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Subject</li>
            <div class="margintopminus48">	
                <input type="hidden" id="filename" name="filename" value="Subjects">	
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
                        

                        @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! session('message') !!} 
                        </div>
                        @endif
                        <form id="user-mng" method="get" action="{{route('admin-subjectList')}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Keyword')}}" type="text">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary btn-info">{{_i('Search')}}</button>
                                    <a href="{{route('admin-subjectList')}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                    <div class="col-sm-2 pull-right">
                                    <a href="{{route('admin-addSubjectInCase')}}" class="btn btn-block btn-warning">Add Subject</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="printTable">
                            <tr>
                                <!--<th>Sr.No.</th>-->
                                <th width="15%">{{_i('Name')}}</th>
                                <th>{{_i('Case Name')}}</th>
                                <th>Phone No</th>                                
                                <th>Cell Phone</th>                                
                                <th>Address</th>                                
                                <th>State</th>                                
                                <th>City</th>                                
                                <th>Zipcode</th>
                                <th>{{_i('Created Date')}}</th>                                
                            </tr>
                            @if(count($data['subjects'])>0)
                            @foreach($data['subjects'] as $row)
                            <tr>
                                <td>{{@$row->name}}</td>                                
                                <td>{{@$row->case->title}}</td>                                
                                <td>{{@$row->phone_number}}</td>                                
                                <td>{{@$row->cell_phone}}</td>                                
                                <td>{{@$row->address}}</td>                                
                                <td>{{@$row->state}}</td>                                
                                <td>{{@$row->city}}</td>                                
                                <td>{{@$row->zip_code}}</td>                                
                                <td>{{date("F j, Y", strtotime($row->created_at))}}</td>                                
                            </tr>
                            @endforeach
                            @else
                            <tr class="bg-info">
                                <td colspan="9">Record(s) not found.</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
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
