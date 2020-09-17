@extends('layout.backened.header')
@section('content')
<div id="caseDetails">  </div>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
        <section class="content-header">
            <div class="classnameheading">{{ @$data['CaseList']->title }}</div>
        <h3 class="paddingbottom10px">{{_i('Manage Subjects')}}</h3>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Subject</li>
			
        </ol>	
      @if(count($data['subjectDetails'])>0)		
		 <div class="margintopminus48">	
             <input type="hidden" id="filename" name="filename" value="subject {{ @$data['CaseList']->title }}">	
            <a href="javascript::void(0)" id="csv" class="btn btn-info btn-xs action-btn edit" title ="Download CSV File"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span></a>
        	<a href="{{route('admin-download-case-pdf-subjectList',['id'=>@$data['CaseList']->id]) }}" class="btn btn-info btn-xs action-btn edit" title ="Download PDF"><i class="fa fa-file-pdf-o backgroundred" aria-hidden="true"></i></span></a>
        </div>
		@endif
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
                        <form id="user-mng" method="get" action="{{route('admin-managesubject',[@$data['CaseList']->id])}}">
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
                                    <a href="{{route('admin-managesubject',[@$data['CaseList']->id])}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                     <div class="col-sm-2 pull-right">
                                    <a href="{{route('admin-add-subject',[@$data['CaseList']->id,0])}}" class="btn btn-block btn-warning">Add Subject</a>
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
                                <th>Phone No</th>                                
                                <th>Cell Phone</th>                                
                                <th>Address</th>                                
                                <th>State</th>                                
                                <th>City</th>                                
                                <th>Zipcode</th>
                                <th>{{_i('Created Date')}}</th>                                
                                <th class="ignore">{{_i('Action')}}</th>                                
                            </tr>
                            @if(count($data['subjectDetails'])>0)
                            @foreach($data['subjectDetails'] as $row)
                            <tr>
                                <td>{{@$row->name}}</td>                                       
                                <td>{{@$row->phone_number}}</td>                                
                                <td>{{@$row->cell_phone}}</td>                                
                                <td>{{@$row->address}}</td>                                
                                <td>{{@$row->state}}</td>                                
                                <td>{{@$row->city}}</td>                                
                                <td>{{@$row->zip_code}}</td>                                
                                <td>{{date("F j, Y", strtotime($row->created_at))}}</td> 
                                <td class="ignore"><a href="{{route('admin-add-subject',[@$row->case->id,@$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Edit Subject Info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
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
