  <div class="sortableList">
    <div class="panel panel-default">
        <div class="panel-heading">Tasks</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-12" id="ajaxresp">
            <div class="table-responsive">
            <table id="task-table1s" class="dashboard-table table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th  class="col-sm-2" >Tasks</th>
                        <th class="col-sm-2" >Case</th>
                        <th class="col-sm-2" >Incident</th>
                        <th  class="col-sm-1">Status</th>
                        <th  class="col-sm-2">Due Date</th>								   
                    </tr>
                </thead>
            <tbody>
            @if( !empty($data['caseDetails']->task) && (count($data['caseDetails']->task)>0))  
            @foreach($data['caseDetails']->task as $k=>$row)
              @if(!empty($row->task->id))
                  <tr>
                    <td><a href="javascript:open_change_status_task_modal({{$row->task->id}}, {{$data['caseDetails']->id}}, '{{route('admin-ajaxGetTaskDetailsChangeStatus')}}','{{route('admin-ajaxAssignTaskDetails')}}');" class="add-tasks" Title="Update Task Status">{{wordwrap($row->task->title, 20, "\n", true)}}</a>
                    </td>
                    <td>{{ @$row->task['user']['first_name'] }} &nbsp; {{ @$row->task['user']['last_name'] }}</td> 
                    <td>{{date("F j, Y", strtotime($row->task->due_date))}}</td> 
                    <td><?php echo getStatusTitle($row->task->status); ?></td>
                    <td>{{date("F j, Y", strtotime($row->task->created_at))}}</td>                        
                </tr>   
            @endif                         
            @endforeach
            @else
            <tr class="bg-info">
            <td colspan="8">Record(s) not found.</td>
            </tr>
            @endif
            </tbody>
            </table>
         </div>
       </div>
     </div>
   </div>
 </div>
</div>
      
      
