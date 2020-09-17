@extends('layout.backened.header')
@section('content')
<?php //dd($data); ?>
 <div class="clearfix"></div>
 <div class="section" > 
    <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>@if(@$request->id){{'Manage Task'}} @else {{'Add'}} @endif </h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> {{_i('Home')}}</a></li>
        <li class="active">@if(@$request->id){{'Manage Task'}} @else {{'Add'}} @endif </li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
  <script type="text/javascript">
    $( document ).ready(function() {         
      $('#add-button').click(function (event) {
        for (var i in CKEDITOR.instances) {
              CKEDITOR.instances[i].updateElement();
          }

          $("#add-files-form").submit();
      });
         
        $('#add-files-form').validate({
            ignore: ".ignore",
            rules: {
               incidentid: {
                  required: true,                    
                },               		
            },
            // Specify validation error messages
            messages: {
             
            },
        });
    });

  
</script>
<!-- Trigger the modal with a button -->
        <button id="modalBt" type="button" class="btn btn-info btn-lg hidden" data-toggle="modal" data-target="#myModal">Open Modal</button>
<div id="galleryDetails"></div>
 
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
            <!-- /.box-header -->
            <!-- form start -->         
            <form class="" id="add-files-form" action="@if(@$request->id) {{route('admin-incidentwithtask',['id'=>@$request->id])}} @else  {{route('admin-incidentwithtask')}} @endif" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <?php  
                  $existingTaskId = array();
                  if(!empty($data->incident)){
                    foreach ($data->incident as $key => $value) {
                      $existingTaskId[] = $value->task_id;
                    }
                  }
                  ?>  
                  <input type="hidden" name="existingtaskId"  value="<?php echo implode(',', $existingTaskId);?>"> 
              <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="printTable">
                        <tr>
                          <th>Select</th>
                          <th>Tasks</th>
                          <th width="15%">Assign To</th>
                          <th>Due Date</th>
                          <th>Case </th>     
                          @if(Session::get('user_role_id')<=2)<th>Group</th>@endif       
                          <th>Incident</th>     
                          <th>Status</th>     
                          <th>Created Date</th>
                        </tr>
                        @if(!empty($taskListArray))
                        @foreach($taskListArray as $key=>$row)
                        <tr>
                          <td scope="row"><input type="checkbox" <?php if( !empty($existingTaskId) && in_array($row->id,$existingTaskId) ) { echo 'checked = true';} ?> name="send_tasks[]" class="send_tasks" value="{{$row->id}}"></td>
                          <td>{{ $row['title']}}</td>
                          <td>{{ @$row['user']['first_name'] }} &nbsp; {{ @$row['user']['last_name'] }}</td> 
                          <td>{{date("F j, Y", strtotime($row->due_date))}}</td> 
                                <td>{{ @$row->case->title}} </td> 
                                @if(Session::get('user_role_id')<=2)<td><?php if(!empty($row->case->caseGroup)){ echo $row->case->caseGroup->group->name;}?></td> @endif
                                <td>{{ @$row->incident->title}} </td> 
                                <td><?php echo getStatusTitle($row->status); ?></td>
                                <td>{{date("F j, Y", strtotime($row->created_at))}}</td>
                        </tr>
                        @endforeach
                        @endif
                  </table>
                  <input type="hidden" name="id" value="{{old('id',@$request->id)}}">           
                </div>                 
              <!-- /.box-body -->
              @if($type !='view')
              <div class="box-footer">
                <a href="{{route('admin-editIncident',@$request->id)}}" class="btn btn-default">Cancel</a>
                <input type="submit" id="add-button" value="Link To Incident" class="btn btn-info checkimagesize" >
              </div>
              @endif
              </form>
              <!-- /.box-footer -->
          </div>
          
        </div>
        <!--/.col (right) -->
        </div>
       </div> 
      </div>
<style>
    .error{
        color:red;
    }
</style>

  @endsection