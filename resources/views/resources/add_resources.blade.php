@extends('layout.backened.header')
@section('content')
<?php //dd($data);
//dd($totalExistUsers);
 ?>
 <div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>@if(@$data->id){{'Update'}} @else {{'Add'}} @endif {{_i('Resources')}}</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin-resources-list')}}">Resources</a></li>
        <li class="active">@if(@$data->_id){{'Update'}} @else {{'Add'}} @endif {{_i('User')}}</li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
    
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
            <?php 

$account_membership_type = Session::get('account_membership_type');

?>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="" id="add-form" action="@if(@$data->id) {{route('admin-edit-resources',['id'=>@$data->id])}} @else  {{route('admin-add-resources')}} @endif" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
         
              <div class="box-body">
              <input type="hidden" name="id" value="{{old('id',@$data->id)}}">


<?php

$user_role_name = Session::get('user_role_name');
   
            if ($user_role_name=="superAdmin")
            {
            ?>
 <div class="form-group  row @if($errors->first('account_id')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Account List{{redstar()}}</label>
                  <div class="col-sm-7">
                      <select name="account_id" class="form-control" id="account_id">
                                            <option value="">Select</option>
                                            <?php foreach($account_list as $key=>$val){ 
                                                //dd($val);
                                              ?>

                                            <option @if(@$data->account_id===$val->id) {{'selected'}} @endif value="<?php echo $val->id; ?>"><?php echo $val->name; ?></option>
                                            <?php
                                                }
                                            ?>
                                            
                                        </select>
                    <?php if(@$errors->first('account_id')) { ?><span class="help-block">{{@$errors->first('status')}}</span> <?php } ?>
                  </div>
                </div>

<?php
 } 
 else{
  ?>
  <input type="hidden" name="account_id" value="{{ ucfirst(session('account_id')) }}">
  <?php
 }
?>
               
                <div class="form-group row @if($errors->first('first_name')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Name{{redstar()}}</label>
                  <div class="col-sm-7">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{old('name',@$data->name)}}">
                    <?php if(@$errors->first('name')) { ?><span class="help-block">{{@$errors->first('name')}}</span> <?php } ?>
                  </div>
                </div>

                <div class="form-group row @if($errors->first('website')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Website{{redstar()}}</label>
                  <div class="col-sm-7">
                    <input type="text" name="website" id="website" class="form-control" placeholder="Website" value="{{old('website',@$data->website)}}">
                    <?php if(@$errors->first('website')) { ?><span class="help-block">{{@$errors->first('website')}}</span> <?php } ?>
                  </div>
                </div>


               <div class="form-group row @if($errors->first('email')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Email{{redstar()}}</label>
                  <div class="col-sm-7">
                    <?php
               if(isset($data->id) && $data->id>0){
                echo $data->email;
                ?>
                <input type="hidden" name="email" class="form-control" placeholder="Email" value="{{old('email',@$data->email)}}">
                <?php
               }
               else{ 
                    ?>
                    <input type="text" name="email" class="form-control" placeholder="Email" value="{{old('email',@$data->email)}}">
                    <?php } ?>
                    <?php if(@$errors->first('email')) { ?><span class="help-block">{{@$errors->first('email')}}</span> <?php } ?>
                  </div>
                </div>

                
               
                <div class="form-group row @if($errors->first('contact_person')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Contact Person{{redstar()}}</label>
                  <div class="col-sm-7">
                    <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="Contact Person" value="{{old('contact_person',@$data->contact_person)}}">
                    <?php if(@$errors->first('contact_person')) { ?><span class="help-block">{{@$errors->first('contact_person')}}</span> <?php } ?>
                  </div>
                </div>
				
				 <div class="form-group row  @if($errors->first('organisation')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Organization{{redstar()}}</label>
                  <div class="col-sm-7">
                    <input type="text" name="organisation" id="organisation" class="form-control" placeholder="Organization" value="{{old('organisation',@$data->organisation)}}">
                    <?php if(@$errors->first('organisation')) { ?><span class="help-block">{{@$errors->first('organisation')}}</span> <?php } ?>
                  </div>
                </div>
        

                <div class="form-group row @if($errors->first('phone')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Phone{{redstar()}}</label>
                  <div class="col-sm-7">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="{{old('phone',@$data->phone)}}">
                    <?php if(@$errors->first('phone')) { ?><span class="help-block">{{@$errors->first('phone')}}</span> <?php } ?>
                  </div>
                </div>



                <div class="form-group row @if($errors->first('notes')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Notes</label>
                  <div class="col-sm-7">
                    <input type="text" name="notes" id="notes" class="form-control" placeholder="Notes" value="{{old('notes',@$data->notes)}}">
                    <?php if(@$errors->first('notes')) { ?><span class="help-block">{{@$errors->first('phone')}}</span> <?php } ?>
                  </div>
                </div>
<!-- 
                  <div class="form-group @if($errors->first('status')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Status{{redstar()}}</label>
                  <div class="col-sm-10">

                  <select name="status" class="form-control" id="status">
                                            <option value="">Select</option>
                                            <option @if(@$data->status=='n') {{'selected'}} @endif value="n">{{_i('No')}}</option>
                                            <option @if(@$data->status=='y') {{'selected'}} @endif value="y">{{_i('Yes')}}</option>
                                        </select> 


                    <?php //if(@$errors->first('status')) { ?><span class="help-block">{{@$errors->first('status')}}</span> <?php //} ?>
                  </div>
                </div> -->
                  <input type="hidden" name="status" id="status" class="form-control" placeholder="status" value="y">

                   


                
                  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="submit" value="Submit" class="btn btn-info">
                <a href="{{route('admin-resources-list')}}" class="btn btn-default">Cancel</a>
                
              </div>
              <!-- /.box-footer -->
            </form>
            
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
<script src="{{asset('js/customFormValidationRules.js')}}"></script>
<script src="{{asset('js/addResources.js')}}"></script>
  @endsection