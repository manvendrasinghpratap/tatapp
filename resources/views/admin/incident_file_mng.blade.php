<?php //dd($data); ?>
@extends('layout.backened.header')
@section('content')
<div id="caseDetails">
    
</div>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
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
                                <div class="col-sm-2" style="width:10%; display: none;">
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
   
                                <div class="col-sm-10">
                                    <button style="display: none;" type="submit" class="btn btn-primary btn-info">{{_i('Search')}}<div></div></button>
                                    <a href="{{route('admin-caseList')}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                                    <?php 
                                    $allowRolesList = array("agencySuperAdmin", "agencyAdmin");
                                    $user_role_name = Session::get('user_role_name');
                                    if (in_array($user_role_name, $allowRolesList)) { ?>
                                    <div class="col-sm-3 pull-right">
                                    <a href="{{route('admin-addfiles')}}" class="btn btn-block btn-warning">Add Files</a>
                                    </div>
                                    <?php } ?>
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
                                <th >{{_i('Title')}}</th>
                                <th width="20%" style=" word-break: break-all; ">{{_i('Description')}}</th>
                                <th >{{_i('Incident Name')}}</th>
                                <th >{{_i('Case Name')}}</th>
                                <th>{{_i('Created Date')}}</th>
                                @if(Session::get('user_role_id')<3)<th width="15%">{{_i('Action')}}</th>@endif
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                            <tr>
                               <!-- <td scope="row">{{$k}}</td>-->
                               <td>{{@$row->title}}</td>
                               <td> <div style="word-wrap: break-word; width: 90%;" > {{@$row->description}}</div></td>
                               <td>
                                <?php 
                                $incidentArray  = array();
                                if(!empty( $row->incidentfiles) ){
                                    $incidentName = $row->incidentfiles;
                                    foreach ($incidentName as $key => $value) {
                                        $incidentArray[] = $value->incident->title;
                                    }
                                    echo implode(',<br>',$incidentArray);
                                }
                               ?>
                               </td>
                               <td>
                                <?php 
                                $casesfilesArray  = array();
                                if(!empty( $row->casesfiles) ){
                                    $casesName = $row->casesfiles;
                                    foreach ($casesName as $key => $value) {
                                        //echo 'ddddddddddd';
                                        $casesfilesArray[] = $value->cases->title;
                                    }
                                    echo implode(',<br>',$casesfilesArray);
                                }
                               ?>
                               </td>
                                <td>{{date("F j, Y", strtotime($row->created_at))}}</td>
                                @if(Session::get('user_role_id')<=4)
                                <td>                                                                          
                                    In progress
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
<script src="{{asset('js/filesList.js')}}"></script>
@endsection
