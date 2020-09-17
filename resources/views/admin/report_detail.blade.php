@extends('layout.backened.header')
@section('content')


<?php $linkedtype='report';?>
 <div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>Report Details</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin-reportList')}}">Report</a></li>
        <li class="active">Report Details</li>
      </ol>
    </section>
   
        @if(Session::has('add_message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('add_message') !!} 
                </div>
                @endif
       <form  id="import-media-report" action="{{route('admin-viewReport',['id'=>@$data->id])}}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="report_id" value="{{old('id',@$data->id)}}">
        <input type="hidden" name="account_id" value="{{old('id',@$data->account_id)}}">
            {{ csrf_field() }}
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            
              <div class="box-body box-log-dtl">

              <div class="form-group">
                  <div class="row">
                    
                  </div>
                </div>

               <!--  <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">User Name</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">{{@$data->user_name}}</label>
                    </div>
                  </div>
                </div> -->
                
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Account Name</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">{{@$data->account_name}}</label>
                    </div>
                  </div>
                </div>
                 <?php if($data->isImport=="y"){ ?>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Assigned Case Title</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">{{@$data->case_title}}</label>
                    </div>
                  </div>
                </div>
                 <?php } ?>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">{{@$data->title}}</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Details</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">{{@$data->details}}</label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Group</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">@if(isset($data->reportGroup->group->name)) {{ $data->reportGroup->group->name}} @endif</label>
                    </div>
                  </div>
                </div> 
                 <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">{{@$data->name}}</label>
                    </div>
                  </div>
                </div>

                 <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Phone No</label>
                    <div class="col-sm-10 pull-left">
                      <label class="control-label sbsc-lbl-eml">{{@$data->phone_no}}</label>
                    </div>
                  </div>
                </div>



                <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10 pull-left">
                    <label class="control-label sbsc-lbl-eml">{{@$data->email_address}}</label>
                  </div>
                </div>
                 </div>

                
      

                 <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">List of Files</label>
                  <div class="col-sm-10 pull-left">
                    <ul>
                      <?php foreach($data->reportlists as $key=>$row){ ?>

                      <?php
 $file_name = isset($row->file_name)?$row->file_name:'';
 ?>
 @if(@$file_name!='')
                              <?php
                            $path = get_image_url($file_name,'report');
                            $ext = pathinfo($path, PATHINFO_EXTENSION); 
                            $extensionsArray = array('jpg', 'JPG', 'png' ,'PNG' ,'jpeg' ,'JPEG');
                            if (in_array($ext, $extensionsArray))
                              {
                              
                              ?>
                              <div class="col-lg-3 col-md-4 col-xs-6">
                            
            <img class="img-fluid img-thumbnail" src="{{get_image_url(@$file_name,'report')}}" alt="" style="width:100%;height:100px;">
        
           <?php echo "<p>".substr($row->title, 0,30)."</p>"; ?>
            </div>
                              <?php
                              }
                            else
                              {
                             ?>
                              <a href="{{get_image_url(@$file_name,'report')}}">{{$file_name}}</a>
                              <?php
                              }
                                ?> 
                         @endif
          

                      <?php
//dd($data); 
/*echo "<pre>";
print_r($val);
echo "</pre>";*/
?>
                     
                      <?php } ?>
                    </ul>
                  </div>
                </div>
                 </div>

                <?php if($data->isImport=="n"){ ?>

               <!-- <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">Select case from the List and click on Import button</label>
                  <div class="col-sm-6 pull-left">
                    <select class="form-control" name="case_id" id="case_id">
                                                <option value="">Select Case</option>
                                                 <?php foreach($case_list as $key=>$val){ 
                                                //dd($val);
                    $activeClass = (isset($_GET['case_id']) && $_GET['case_id']==$val->id)?'selected':'';
                                              ?>

                                            <option value="<?php echo $val->id; ?>" <?php echo $activeClass; ?>><?php echo $val->title; ?></option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                  </div>
                  <div class="col-sm-4 pull-left">
                   
                    <input type="submit" id="add-button" value="Import" class="btn btn-warning">
                  </div>
                </div>
                </div>-->
                 <?php } ?>
				<div class="form-group ">
                     <div class="row">
					<label for="inputError" class="col-sm-2 control-label"></label>
                    <div class="col-sm-6 pull-left">
                         
						
			
		
		
		
			
                    </div>
				 </div>
                  </div>
                 <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">Created Date</label>
                  <div class="col-sm-10 pull-left">
                    <label class="control-label sbsc-lbl-eml">{{date("d-m-Y", strtotime($data->created_at))}}</label>
                  </div>
                </div>
                 </div>
                
                 
                

                 </div>
                
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-reportList')}}" class="btn btn-default">Go Back</a>
              </div>
              <!-- /.box-footer -->
          </div>
              <!-- /.box-footer -->
          </div>
           </form>
          
        </div>
		<div class="spacer7"></div>
		<div class="panel panel-default">
    <div class="panel-heading">Linked Incident</div>
    <div class="panel-body">
        
        
<div class="row">
    <div class="col-sm-12" id="ajaxresp">
	
				
        <div class="table-responsive">
		
    <table id="taskList" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
               <!--<th>Sr.No.</th>-->
				
				<th width="25%">{{_i('Title')}}</th>
			  
				
				<th>{{_i('Date/Time')}}</th>
				<th>{{_i('Created TimeStamp')}}</th>
				<th width="25%">{{_i('Incident Type')}}</th>
				<th width="15%">{{_i('Unlink')}}
				</th>
            </tr>
        </thead>
        <tbody>
			<?php 
			
			//print_r($incident);
			?>
            @if(count($incident)>0)
            @foreach($incident as $key=>$row)   
               <?php $trstyle='';	$linkchecked=''; //echo '<pre>'; print_r($row);
							if($row->id==$row->incident_id){
								$trstyle='btn-success';
								$linkchecked="checked=checked";
							} 
								
							//echo $row->linkedid;
							
							?>           
            <tr>
				<!--<td scope="row">{{$key+1}}</td>-->
                <td><a target="_blank" title="view incident" href="{{route('admin-editIncident',['id'=>$row->id])}}"><?php echo $row->title; ?></a></td>
                
                <td>  {{date("F j, Y H:i", strtotime($row->incident_datetime))}}</td>
				<td> {{date("F j, Y H:i", strtotime($row->created_at))}}  </td>
				<td> {{$row->type}}  </td>
               <td><div>
				<form id="frm_{{$row->id}}" class="form-horizontal" action="{{route('admin-incident-linkto-report')}}" method="POST" enctype="multipart/form-data">				
                     	{{ csrf_field() }}
				 <input type="hidden" value="{{$data->id}}" name="reportid">
				 <input type="hidden" value="report" name="linkedtype">
				 <input type="hidden"  value="{{$row->id}}" name="linktoreport[]">
				<input type="hidden"  value="{{$row->linkedid}}" name="linktoreportid[]">
                 <input type="submit" name="incidentunlink" id="add-button" value="Un-Link" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link selected incident to {{$linkedtype}}?')">
	</form>    
	</div>
                   		
			 </td>
                                
                
            </tr>
                          @endforeach
                          @else
                          @endif
             
           
        </tbody>
       
    </table>
	<div class=" pull-left">
         <!--<a id="addrow" href="{{route('admin-linkreportToIncident',['id'=>@$data->id,'type'=>'report'])}}" class="btn btn-primary " title="Add Incident"><i class="fa fa-plus"></i></a>-->
		 <a id="addrow" href="{{route('admin-addIncident')}}" class="btn btn-primary " title="Add Incident">Create Incident</a>
				<a href="{{route('admin-linkreportToIncident',['id'=>@$data->id,'type'=>'report'])}}" class="btn btn-info">Link Incidents</a>						
	</div>
	<div class=" pull-right">
						
						
					 </div>

    </div>
     </div>
</div>

    </div>
</div>
       
        </div>
       
      </div>
     
  
<script>



</script>
  @endsection