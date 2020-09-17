<?php //dd($data); ?>
@extends('layout.backened.header')
@section('content')

 <!-- Modal HTML -->
    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="add-sector-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title">Are you sure you want to delete the incident type?</h4>
                </div>
                <form class="form-horizontal" role="form" name="addIncidentTypeForm" id="addIncidentTypeForm" method="post">
                <div class="modal-body ">
					<div class="box-body">
						<input type="hidden" id="deleteincident_type_id" value="">

				   </div>
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-primary" id="ajaxdeleteincidenttype" data-link1="{{route('admin-ajaxDeleteIncidentType')}}" data-link2="">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                   
                </div>
                </form>
            </div>
        </div>
    </div>

<div id="caseDetails">
    
</div>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h3>{{_i('Manage Incident Type')}}</h3>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>{{_i('Home')}}</a></li>
            <li class="active">{{_i('Manage Incident Type')}}</li>
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

                        <form id="user-mng" method="get" action="{{route('admin-incidenttypeList')}}" name="addIncidentTypeForm">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Keyword')}}" type="text">
                                        </div>
                                    </div>
                                </div> 
                               <!-- <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="status">
                                                 <option value="">Select</option>
                                                 <option value="new" <?php echo  (isset($_GET['status']) && $_GET['status']=='new')?'selected':''; ?>>New</option>
                                                <option value="active" <?php echo  (isset($_GET['status']) && $_GET['status']=='active')?'selected':''; ?>>Active</option>


                                                 <option value="closed" <?php echo  (isset($_GET['status']) && $_GET['status']=='closed')?'selected':''; ?>>Closed</option>
                                                <option value="archived" <?php echo  (isset($_GET['status']) && $_GET['status']=='archived')?'selected':''; ?>>Archived</option>


                                            </select>
                                        </div>
                                    </div>
                                </div> -->

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
                                    <button type="submit" class="btn btn-primary btn-info">{{_i('Search')}}<div></div></button>
                                    <a href="{{route('admin-incidenttypeList')}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                    <button class="btn btn-primary hidden-print" id="printButton"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                                    <!-- <a href="{{route('admin-download-pdf-caseList')}}" class="btn btn-primary btn-success">
                                   <span class="glyphicon glyphicon-download" aria-hidden="true"></span> PDF</a> -->
                                </div>
								
								
								
								
                                <?php 
            $allowRolesList = array("agencySuperAdmin", "agencyAdmin");
            $user_role_name = Session::get('user_role_name');
            if (in_array($user_role_name, $allowRolesList))
            {
            ?>
          
			
            <?php } ?>
             <div class="col-sm-2 pull-right">
                                        <a href="{{route('admin-addIncidentType')}}" class="btn btn-block btn-warning">Add Incident Type</a>
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
                                <th>Description</th>
                              
                                
                                <th width="15%">{{_i('Action')}}</th>
                            </tr>
                            @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
                            <tr>
                               <!-- <td scope="row">{{$k}}</td> -->
                                <td> <?php 
                            echo $row->type;

                                        ?></td>
                                <td>{{$row->description	}}</td>
                             
                           <td>
                                   
                                    
                                       <a href="{{route('admin-editIncidentType',['id'=>$row->id])}}" class="btn btn-info btn-xs action-btn" title ="Edit Incident Type"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>

                                    <a href="#" class="btn btn-info btn-xs action-btn deleteIncidenttype" title ="Delete"  data-link1="{{route('admin-ajaxDeleteIncidentType')}}" data-link2="{{$row->id}}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                     

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
<script >
  $('.deleteIncidenttype').on('click', function(){
              
                  
          
          var link1 = $(this).data("link1");       
          var incidenttype_id = $(this).data("link2"); 
		  $("#deleteincident_type_id").val(incidenttype_id); 
		  
          $('#myModal').modal('show');     
          /* $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    incidenttype_id:incidenttype_id 
                    },
                    success: function (data) {
                         //alert(data);
                      
                        $('#caseDetails').html(data);
                        $('#myModal').modal('show'); 
                       
                       
                   

                       }
                    }); */
    
                   
                    
                
            });
			

 $('#ajaxdeleteincidenttype').on('click', function(){
              
                  
          
          var link1 = $(this).data("link1");          
          var incidenttype_id = $("#deleteincident_type_id").val(); 
                   
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      incidenttype_id:incidenttype_id},
                    success: function (html) {
                    $('#myModal').modal('hide');
                     location.reload();
                       }
                    });
    
                   
                    
                
            });

</script>
@endsection
