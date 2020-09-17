@extends('layout.backened.header')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{_i('Manage Factor')}}</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Factor</li>
        </ol>
    </section>

    <section class="content">
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

                        <form id="user-mng" method="get" action="{{route('admin-factor-list')}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="Keyword" type="text">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="target_chart_visibility">
                                                <option value="">Select Status</option>
                                                <option value="y" <?php echo ($request->target_chart_visibility=="y")?'selected="selected"':''; ?> >Active</option>
                                                <option value="n" <?php echo ($request->target_chart_visibility=="n")?'selected="selected"':''; ?> >In Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>  

                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="timeline_chart_visibility">
                                                <option value="">Select Status</option>
                                                <option value="y" <?php echo ($request->timeline_chart_visibility=="y")?'selected="selected"':''; ?> >Active</option>
                                                <option value="n" <?php echo ($request->timeline_chart_visibility=="n")?'selected="selected"':''; ?> >In Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 


                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary btn-info">Search<div></div></button>
                                    <a href="{{route('admin-sector-list')}}" class="btn btn-primary btn-success">Reset</a>
                                </div>
                                 
                                   <!--  <div class="col-sm-2 pull-right">
                                        <a href="{{route('admin-add-factor')}}" class="btn btn-block btn-warning">Add Factor</a>
                                    </div> -->
                                   
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
                        <table class="table table-hover">
                            <tr>
                               <!-- <th>Sr.No.</th>-->
                                <th>Title</th>
                                <th>Target Chart Visibility</th>
                                <th>Timeline Chart Visibility </th>
                                <th>Created Date</th>
                                <th width="15%">Action</th>
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                            <tr>
                                <!--<td scope="row">{{$k}}</td>-->
                                <td>
                                    <?php 
                                        echo $row->title;
                                    ?>
                                        
                                </td>
                                
                                <td>@if($row->target_chart_visibility=='y'){{'Active'}}@else{{'In-Active'}}@endif</td>
                                <td>@if($row->timeline_chart_visibility   =='y'){{'Active'}}@else{{'In-Active'}}@endif</td>
                                <td>{{date("d-m-Y", strtotime($row->created_at))}}

                                </td>
                                <td>
                                    @if($row->target_chart_visibility=='y')
                                        <a href="{{route('admin-target-chart-visibility-status',['id'=>$row->id,'target_chart_visibility'=>'n'])}}"  class="btn btn-danger btn-xs action-btn" title ="De-activate"><span class="glyphicon glyphicon-remove" aria-hidden="true" ></span></a>
                                            
                                    @else
                                        <a href="{{route('admin-target-chart-visibility-status',['id'=>$row->id,'target_chart_visibility'=>'y'])}}" class="btn btn-success btn-xs action-btn" title ="Activate"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
                                    @endif
                                    @if($row->timeline_chart_visibility=='y')
                                        <a href="{{route('admin-timeline-chart-visibility-status',['id'=>$row->id,'timeline_chart_visibility'=>'n'])}}"  class="btn btn-danger btn-xs action-btn" title ="De-activate"><span class="glyphicon glyphicon-remove" aria-hidden="true" ></span></a>
                                            
                                    @else
                                        <a href="{{route('admin-timeline-chart-visibility-status',['id'=>$row->id,'timeline_chart_visibility'=>'y'])}}" class="btn btn-success btn-xs action-btn" title ="Activate"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
                                    @endif
                                    <!-- <a href="{{route('admin-edit-sector',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> -->
                                    <a href="{{route('admin-delete-factor',[$row->id])}}" class="btn btn-danger btn-xs action-btn" onclick="return confirm('Are you sure you want to delete ?');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>

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

@endsection
