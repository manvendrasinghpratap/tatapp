@extends('layout.backened.header')
@section('content')
<script src="{{asset('js/tasklist.js')}}"></script> 
<!-- START Datatable -->
<style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;} figcaption{display:none_;}.width100per{width:100%} </style> 
<button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
<div id="sectorDetails"></div>
<div class="section" id="printcontent">
    <div class="container">
        <div class="box-header with-border">
              <h3 class="box-title"></h3>
              @if(Session::has('add_message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('add_message') !!} 
                </div>
                @endif
            </div>
     <div class="clearfix targetwrap" style="text-align:center">
     <?php
          $rank_sum = 0; 
          $total_rank_data = count($data['getAllSectorByCaseId']);
          $avg_rank = 0;
          if($total_rank_data>0){
              foreach($data['getAllSectorByCaseId'] as $row) {
                $rank_sum = $rank_sum+ $row->rank_id;
              }  
          }
          if($total_rank_data>0){
            $avg_rank = $rank_sum / $total_rank_data;
          }
    ?>
    <h2>Summary Rank : <?php echo number_format($avg_rank,2); ?>/10</h2></div>  
    <div class="row">

      <div class="col-sm-12 btns-grp">

      <form class="" id="add-case-form" action="@if(@$data['caseList']->id) {{route('admin-editCase',['id'=>@$data['caseList']->id])}} @else  {{route('admin-addCase')}} @endif" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}   
          <input type="hidden" name="description" id="description" class="form-control" placeholder="Description" value="{{old('name',@$data['caseDetails']->description)}}">
  
        <div class="spacer7"></div>               
        <div class="row">
          <div class="col-sm-2">
            <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif "c>
              
              <label for="inputError" class="control-label"> Title {{redstar()}}</label>
              <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{old('name',@$data['caseDetails']->title)}}">

              <?php if(@$errors->first('title')) { ?><span class="help-block">{{@$errors->first('title')}}</span> <?php } ?>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group @if($errors->first('status')) {{' has-error has-feedback'}} @endif">
              <label for="inputError" class="control-label"> Status{{redstar()}}</label>
              <select name="status" class="form-control" id="status" >
                <option value="">Select</option>
                <option @if(@$data['caseDetails']->status=='new') {{'selected'}} @endif value="new">{{_i('New')}}</option>
                <option @if(@$data['caseDetails']->status=='active') {{'selected'}} @endif value="active">{{_i('Active')}}</option>
                <option @if(@$data['caseDetails']->status=='closed') {{'selected'}} @endif value="closed">{{_i('Closed')}}</option>
                <option @if(@$data['caseDetails']->status=='archived') {{'selected'}} @endif value="archived">{{_i('Archived')}}</option>
              </select>
              <?php if(@$errors->first('status')) { ?><span class="help-block">{{@$errors->first('status')}}</span> <?php } ?>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group @if($errors->first('urgency')) {{' has-error has-feedback'}} @endif ">
              <label for="inputError" class="control-label">Urgency {{redstar()}}</label>
              <select name="urgency" class="form-control" id="urgency" >              
              <option value="">Select</option>
              <?php for($i=1;$i<6;$i++){ ?>
                <option @if(@$data['caseDetails']->urgency==$i) {{'selected'}} @endif value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php } ?>

            </select>
          </div>
          </div>
              @if(in_array($request->session()->get('user_role_id'), array(1,2,3)) ) 
                  <div class="col-sm-2">
               <div class="form-group row @if($errors->first('group')) {{' has-error has-feedback'}} @endif ">
                     <label for="inputError" class="control-label"> Group{{redstar()}}</label>
                      <select name="group" class="form-control" id="group">
                            <option value="">Select</option>
                            @if(count($group)>0)
                            @foreach($group as $row) 
                            <?php 
                              $selectedClass = (isset($data['caseList']->caseGroup->group_id) && $data['caseList']->caseGroup->group_id==$row->id)?'selected':'';
                            ?>  
                            <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?> > <?php echo $row->name ?></option>
                          @endforeach
                           

                          @endif
                      </select>
                       
                    <?php if(@$errors->first('group')) { ?><span class="help-block">{{@$errors->first('group')}}</span> <?php } ?>
                </div>
                  </div>
               @else  
                    <input type="hidden" name="group" value="<?php echo (isset($data['caseList']->caseGroup->group_id))? $data['caseList']->caseGroup->group_id:''?>">   
                    @if(isset($data->caseGroup))        
                        <!-- <div class="form-group row @if($errors->first('group')) {{' has-error has-feedback'}} @endif "> -->
                          <label for="inputError" class="control-label"> Group{{redstar()}}</label>
                          <div class="col-sm-7">
                             {{ $data->caseGroup->group->name}} 
                          </div>
                        <!-- </div> -->
                    @endif 
                 
               @endif

       <!--  <div class="col-sm-4">
          <div class="form-group">
            <div class="clearfix targetwrap" style="text-align:center">

             <?php

             $rank_sum = 0; 
             $total_rank_data = count($data['getAllSectorByCaseId']);
             $avg_rank = 0;
             if($total_rank_data>0){

              foreach($data['getAllSectorByCaseId'] as $row) {
                $rank_sum = $rank_sum+ $row->rank_id;
              }  
            }
            if($total_rank_data>0){
              $avg_rank = $rank_sum / $total_rank_data;
            }

            ?>
            <h2>Summary Rank : <?php echo number_format($avg_rank,2); ?>/10</h2></div>
          </div>
        </div>
 -->
 <!--<iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJPfaFTALdQIYRN10ffieEffs&key=AIzaSyAq9He6hEcMpg9DyzHgr8r4iGJfnOcCSKg" allowfullscreen></iframe>-->
        <div class="col-sm-2">
          <div class="form-group @if($errors->first('case_owner_id')) {{' has-error has-feedback'}} @endif">
            <label for="inputError" class="control-label">Owner List{{redstar()}}</label>
            <select name="case_owner_id1" class="form-control" id="case_owner_id1" >
              <option value="">Select</option>

              @if(count($data['userList'])>0)
              @foreach($data['userList'] as $row) 
              <?php 
              $selectedClass = (isset($data['caseDetails']->case_owner_id) && $data['caseDetails']->case_owner_id==$row->id)?'selected':'';
              ?>  
              <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->first_name.' '.$row->last_name; ?></option>
              @endforeach
              @else

              @endif

            </select> 
            <?php if(@$errors->first('case_owner_id')) { ?><span class="help-block">{{@$errors->first('case_owner_id')}}</span> <?php } ?>
          </div>
        </div>

      <input type="submit" id="add-button" value="Submit" class="btn btn-info checkimagesize" style="margin-top: 22px;">
      </div>
      <input type="hidden" name="defaultSpace" id="defaultSpace" value="{{$defaultSpace}}">
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-md-5 col-sm-10">
      <div class="gravitor">
        <figure>
          <div class="edit">
            <?php 
            $allowRolesList = array("agencySuperAdmin", "agencyAdmin", "agencyUser");
            $user_role_name = Session::get('user_role_name');
            if (in_array($user_role_name, $allowRolesList))
            {
              ?>
              <a href="javascript:void(0);" onclick="open_gallery_modal_to_update_case_image(<?php echo $data['caseList']->id; ?>, '{{route('admin-ajaxShowGallery')}}');">
                <i class="fa fa-pencil fa-lg"></i>
              <?php } else{
                ?>
                <a href="#">
                <?php } ?>
                @if(@$data['caseList']->default_pic!='')
                <img src="{{get_image_url(@$data['caseList']->default_pic,'package')}}"  class="img-responsive case_pic width100per" >
                @else
                <img src="{{asset('images/gravitor.jpg')}}" alt="gravitor" class="img-responsive case_pic width100per">
                @endif
              </a></div>

            </figure>
          </div>
          </div>
        <?php 
          $allowRolesList = array("agencySuperAdmin", "agencyAdmin", "agencyUser");
          $user_role_name = Session::get('user_role_name');
          if (in_array($user_role_name, $allowRolesList))
          {
            ?>
            <div class="col-md-7 col-sm-6" style="margin-top:20px;">
                @include('admin.include.tasklist',$data['caseDetails'])
                @include('admin.include.notes',$data)
                
            </div>  
            <?php }?>
</div>


</div>
</div>
<style>
.error{
  color:red;
}
</style>

@endsection