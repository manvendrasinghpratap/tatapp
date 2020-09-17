@extends('layout.backened.header')
@section('content')
<?php //dd($data['taskDetailsArray']); ?>

    <button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <div id="sectorDetails"></div>

<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @php $modetype = 'Update '; @endphp   @if($request->mode=='view') @php $modetype  = 'View'; @endphp  @endif
      <div class="paddingbottom10px"><h3>@if(@$data['taskDetailsArray']->id){{ $modetype }} @else {{'Add'}} @endif Task</h3></div>  
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> Home </a></li>
        <li class="active">@if(@$data['taskDetailsArray']->id){{$modetype}} @else {{'Add'}} @endif Task</li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;} .margin15{margin-right: 5%;margin-left: 5%;}</style>   
  <script type="text/javascript">
    $( document ).ready(function() {
        $('#add-task-form').validate({
            ignore: ".ignore",
            rules: {                
                title:'required',
                description:'required',
                status:'required',
                task_assigned:'required',                
                due_date:'required',
            },
            // Specify validation error messages
            messages: {
                title: "Please enter title.",
                description: "Please give the task details.",
                status: "Please select status from the list.",
                task_assigned: "Please assign the task from the user list.",
                due_date : "Please assign due date."
            },
        });
    });

  
</script>
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

            <form class="" id="add-task-form" action=" {{route('admin-saveTaskCase')}} " method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
             <input type="hidden" name="accountId" value="{{$data['account_id']}}">
             <input type="hidden" name="caseId" value="{{$data['caseId']}}">
              <div class="box-body">
              <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Title {{redstar()}}</label>
                  <div class="col-sm-7">
                      <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{old('name',@$data[taskDetailsArray]->title)}}">
                    <?php if(@$errors->first('title')) { ?><span class="help-block ">{{@$errors->first('title')}}</span> <?php } ?>
                  </div>
                </div>

                 <div class="form-group row @if($errors->first('description')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Description {{redstar()}}</label>
                  <div class="col-sm-7">
                      <input type="text" name="description" id="description" class="form-control" placeholder="Description" value="{{old('name',@$data[taskDetailsArray]->description)}}">
                    <?php if(@$errors->first('description')) { ?><span class="help-block">{{@$errors->first('description')}}</span> <?php } ?>
                  </div>
                </div>
                  <div class="form-group row @if($errors->first('default_pic')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError error" class="col-sm-3 control-label">{{_i('Status')}}</label>
                    <div class="col-sm-7">
                        <select name="status" class="form-control" id="status">
                          <option value="">Select</option>
                          <option @if(@$data[taskDetailsArray]->status=='new') {{'selected'}} @endif value="new">{{_i('New')}}</option>
                          <option @if(@$data[taskDetailsArray]->status=='assigned') {{'selected'}} @endif value="assigned">{{_i('Assigned')}}</option>
                          <option @if(@$data[taskDetailsArray]->status=='in_progress') {{'selected'}} @endif value="in_progress">{{_i('In Progress')}}</option>


                          <option @if(@$data[taskDetailsArray]->status=='delayed') {{'selected'}} @endif value="delayed">{{_i('Delayed')}}</option>
                          <option @if(@$data[taskDetailsArray]->status=='closed') {{'selected'}} @endif value="closed">{{_i('Closed')}}</option>
                        </select>
                  </div>
                </div>
                <div class="form-group row @if($errors->first('task_assigned')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-3 control-label">{{_i('Assign User')}}</label>
                    <div class="col-sm-7">
                        <select name="task_assigned" class="form-control" id="task_assigned">
                        <option value="">Select</option>
                        @if(count($userList)>0)
                        @foreach($userList as $row) 
                        <?php  $selectedClass = (isset($data['taskDetailsArray']->task_assigned) && $data['taskDetailsArray']->task_assigned==$row->id)?'selected':'';  ?>  
                        <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->first_name.' '.$row->last_name; ?></option>
                        @endforeach
                        @else
                        @endif
                        </select>
                  </div>
                </div>

                <div class="form-group row @if($errors->first('due_date')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-3 control-label">{{_i('Due Date')}}</label>
                    <div class="col-sm-7"><input type="date" id="due_date" name="due_date" value="{{ @$data[taskDetailsArray]->due_date}}" /> </div>
                </div>
                <div class="form-group row @if($errors->first('task_assigned')) {{' has-error has-feedback'}} @endif " style="display: none;">
                    <label for="inputError" class="col-sm-3 control-label">{{_i('Time Zone')}}</label>
                    <div class="col-sm-7"> 
                        <select name="zone" class="form-control" id="zone">
                        @if(count($data['zones'])>0)
                        @foreach($data['zones'] as $row) 
                        <?php  $selectedClass = ($row=='America/New_York')?'selected':'';  ?>  
                        <option value="<?php echo $row; ?>" <?php echo $selectedClass; ?>><?php echo $row; ?></option>
                        @endforeach
                        @else
                        @endif
                        </select>
                  </div>
                </div>
                </div>
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-editCase',$data['caseId'])}}" class="btn btn-default">Cancel</a>
                <input type="submit" id="add-button" value="Submit" class="btn btn-info" >
              </div>
              <!-- /.box-footer -->
            </form>
           
          </div>
          </div>
        </div>
        <!--/.col (right) -->
        </div>
      </div>
	   </div>	  
	<script src="{{asset('js/tasklist.js')}}"></script>
  @endsection
  
  
  