@extends('layout.backened.header')
@section('content')
<?php //dd($data); ?>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>

                        <form id="user-mng" method="get" action="{{route('admin-resources-list')}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="Keyword" type="text">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="status">
                                                <option value="">Select</option>
                                            <option @if(@$data->status=='n') {{'selected'}} @endif value="n">{{_i('No')}}</option>
                                            <option @if(@$data->status=='y') {{'selected'}} @endif value="y">{{_i('Yes')}}</option>
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
                                    <button type="submit" class="btn btn-primary btn-info">Search<div></div></button>
                                    <a href="{{route('admin-resources-list')}}" class="btn btn-primary btn-success">Reset</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                                </div>
                                    <div class="col-sm-2 pull-right">
                                        <a href="{{route('admin-add-resources')}}" class="btn btn-block btn-warning">Add Resources</a>
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
                        <table class="table table-hover"  id="printTable">
                            <tr>
                                <!--<th>Sr.No.</th>-->
                                <th width="10%">Name</th>
                                <th width="10%">Email</th> 
                                <th>Website</th>
                                <th>Contact Person</th>
								<th>Organisation</th> 								
                                <th width="10%">Phone</th>     
                                <th>Created Date</th>
                                <th width="15%">Action</th>
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                            <tr>
                                <!--<td scope="row">{{$k}}</td>-->
                                <td>{{wordwrap($row->name, 15, "\n", true)}}</td>
                                <td>{{wordwrap($row->email, 15, "\n", true)}}</td> 
                                <td>{{wordwrap($row->website, 15, "\n", true)}}</td>
                                <td>{{wordwrap($row->contact_person, 15, "\n", true)}}</td> 
                                <td>{{wordwrap($row->organisation, 15, "\n", true)}}</td> 
                                <td>{{wordwrap($row->phone, 15, "\n", true)}}</td>
                                <td>{{date("F j, Y", strtotime($row->created_at))}}

                                </td>
                                <td>
                                   <a href="{{route('admin-edit-resources',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>

                                   
                                    <a href="{{route('admin-delete-resources',['id'=>$row->id])}}" class="btn btn-danger btn-xs action-btn" onclick="return confirm('Are you sure you want to delete ?');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>

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

@endsection
