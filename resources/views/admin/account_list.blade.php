@extends('layout.backened.header')
@section('content')
<button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <div id="sectorDetails"></div>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h3>{{_i('List of Account')}}'s </h3>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Account</li>
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
                        @if(Session::has('add_error_message'))
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                         {!! session('add_error_message') !!} 
                        </div>
                        @endif
                    </div>
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>

                        <form id="user-mng" method="get" action="{{route('admin-AccountList')}}">
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
                                            <select class="form-control" name="status">
                                                <option value="">Select Status</option>
                                                <option value="y" <?php echo  (isset($_GET['status']) && $_GET['status']=='y')?'selected':''; ?>>Active</option>
                                                <option value="n" <?php echo  (isset($_GET['status']) && $_GET['status']=='n')?'selected':''; ?>>In Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="membership_type">
                                                <option value="">Select Plan</option>
                                                <option value="trial" <?php echo  (isset($_GET['membership_type']) && $_GET['membership_type']=='trial')?'selected':''; ?>>Trial</option>
                                                <option value="basic" <?php echo  (isset($_GET['membership_type']) && $_GET['membership_type']=='basic')?'selected':''; ?>>Basic</option>
                                                <option value="pro" <?php echo  (isset($_GET['membership_type']) && $_GET['membership_type']=='pro')?'selected':''; ?>>Pro</option>
                                                <option value="premium" <?php echo  (isset($_GET['membership_type']) && $_GET['membership_type']=='premium')?'selected':''; ?>>Premium</option>
                                                <option value="deactive" <?php echo  (isset($_GET['membership_type']) && $_GET['membership_type']=='deactive')?'selected':''; ?>>Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>          
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary btn-info">Search<div></div></button>
                                    <a href="{{route('admin-AccountList')}}" class="btn btn-primary btn-success">Reset</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                                </div>
                                
                                    <div class="col-sm-2 pull-right">
                                        <a href="{{route('admin-add-account')}}" class="btn btn-block btn-warning">Add Account</a>
                                  
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Group</th>
                                <th>Office Number</th>
                                <th>Membership</th>
                                <th>Storage</th>
                                <th>Total User</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th width="15%">Action</th>
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                               <?php 
                                /*echo "<pre>";
                                print_r($row->users);
                                echo "</pre>";*/
                                ?>
                            <tr>
                                <!--<td scope="row">{{$k}}</td>-->
                                <td>{{$row->name}}</td>                                
                                <td><?php echo $row->email_address;?></td>
                                <td><?= ( $row->accountGroup )? $row->accountGroup->group->name : ''; ?> </td>
                                <td><?php echo $row->office_number; ?></td>
                                <td><?php echo getMembershipPlanTitle($row->membership_type); ?></td>
                                <td>  @if(@$row->accountStorageSize->space_size ) @if ($row->accountStorageSize->space_size >=1000)  {{ $row->accountStorageSize->space_size / 1000 }} GB @elseif($row->accountStorageSize->space_size < 1000) {{ $row->accountStorageSize->space_size}} MB  @endif @endif </td>
                                <td><?php echo count($row->users); ?></td> 
                                <td>@if($row->status=='y'){{'Active'}}@else{{'In-Active'}}@endif</td>
                                <td>{{date("F j, Y", strtotime($row->created_at))}}

                                </td>
                                <td>
                                    @if($row->id!=1)
                                    @if($row->status=='y')
                                        <a href="{{route('admin-changeAccountStatus',[$row->id,base64_encode('n')])}}"  class="btn btn-danger btn-xs action-btn" title ="De-activate"><span class="glyphicon glyphicon-remove" aria-hidden="true" ></span></a>
                                    @else
                                        <a href="{{route('admin-changeAccountStatus',['id'=>$row->id,'status'=>base64_encode('y')])}}" class="btn btn-success btn-xs action-btn" title ="Activate"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
                                    @endif
                                    <a href="{{route('admin-edit-account',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    <a href="javascript:void(0);" class="btn btn-info btn-xs action-btn showEmbedCode" title="Share LINK"><i class="glyphicon glyphicon-share" title="Share LINK"></i></a>
                                    <a href="javascript:open_account_modal({{ $row->id }},'{{route('admin-ajax-edit-account',$row->id)}}');" class="btn btn-primary btn-xs action-btn"  title ="Assign Extra Space" ><span class="glyphicon glyphicon-king" aria-hidden="true"></span></a>
                                    <a href="{{route('admin-account-delete',[$row->id])}}" class="btn btn-danger btn-xs action-btn" onclick="return confirm('Are you sure you want to delete this account and all the users in that account ?');" title ="Delete Account "><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>

                                
                    </div>
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
<script src="{{asset('js/accounjtlist.js')}}"></script>
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
@endsection
