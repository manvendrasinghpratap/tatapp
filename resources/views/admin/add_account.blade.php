@extends('layout.backened.header')
@section('content')
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
      <h3>@if(@$data->_id){{'Update'}} @else {{'Add'}} @endif Account</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="">{{_i('Account')}}</a></li>
        <li class="active">@if(@$data->_id){{'Update'}} @else {{'Add'}} @endif {{_i('Account')}}</li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
    
      <div class="row">
        <div class="col-md-10">
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
            <form class="" id="account-form" action="{{route('admin-add-account')}}" method="POST" enctype="multipart/form-data">
             {{ csrf_field() }}
         
              <div class="box-body">
              <input type="hidden" name="id" value="{{old('id',@$data->id)}}">
                <div class="form-group row @if($errors->first('name')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">  Name{{redstar()}}</label>
                  <div class="col-sm-10">
                      <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{old('name',@$data->name)}}">
                      <input type="hidden" name="module_id" value="{{@$module_id}}">
                    <?php if(@$errors->first('name')) { ?><span class="help-block">{{@$errors->first('name')}}</span> <?php } ?>
                  </div>
                </div>

                <div class="form-group row @if($errors->first('address')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Address {{redstar()}}</label>
                  <div class="col-sm-10">
                      <input type="text" name="address" id="address" class="form-control" placeholder="Address" value="{{old('address',@$data->address)}}">
                    <?php if(@$errors->first('address')) { ?><span class="help-block">{{@$errors->first('address')}}</span> <?php } ?>
                  </div>
                </div>

                 <div class="form-group row @if($errors->first('city')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">City {{redstar()}}</label>
                  <div class="col-sm-10">
                      <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{old('city',@$data->city)}}">
                    <?php if(@$errors->first('city')) { ?><span class="help-block">{{@$errors->first('city')}}</span> <?php } ?>
                  </div>
                </div>


                 <div class="form-group row @if($errors->first('state')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">State {{redstar()}}</label>
                  <div class="col-sm-10">
                      <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{old('state',@$data->state)}}">
                    <?php if(@$errors->first('state')) { ?><span class="help-block">{{@$errors->first('state')}}</span> <?php } ?>
                  </div>
                </div>

                <div class="form-group row @if($errors->first('zip_code')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Zip code {{redstar()}}</label>
                  <div class="col-sm-10">
                    
                      <input type="text" name="zip_code"  class="form-control" placeholder="Zip Code" value="{{old('zip_code',@$data->zip_code)}}">

                    <?php if(@$errors->first('zip_code')) { ?><span class="help-block">{{@$errors->first('zip_code')}}</span> <?php } ?>
                  </div>
                </div>

                <div class="form-group row @if($errors->first('website')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Website {{redstar()}}</label>
                  <div class="col-sm-10">
                      

                       <input type="text" name="website"  class="form-control" placeholder="Website" value="{{old('website',@$data->website)}}">


                    <?php if(@$errors->first('website')) { ?><span class="help-block">{{@$errors->first('website')}}</span> <?php } ?>
                  </div>
                </div>
                <!-- -->
                @if( !empty( $data->accountGroup ) )
                <div class="form-group row @if($errors->first('website')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Group {{redstar()}}</label>
                  <div class="col-sm-10"><?php if( !empty( $data->accountGroup ) ) {  echo $data->accountGroup->group->name; }  ?> </div>
                </div>
                @endif
                <!-- -->
                <div class="form-group row @if($errors->first('contact_person')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Contact Person{{redstar()}}</label>
                  <div class="col-sm-10">
                    <input type="text" name="contact_person"  class="form-control" placeholder="Contact Person" value="{{old('contact_person',@$data->contact_person)}}">

                    <?php if(@$errors->first('contact_person')) { ?><span class="help-block">{{@$errors->first('contact_person')}}</span> <?php } ?>
                  </div>
                </div>

                <div class="form-group row @if($errors->first('office_number')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Office Number {{redstar()}}</label>
                  <div class="col-sm-10">
                      

                          <input type="text" name="office_number"  class="form-control" placeholder="Office Number" value="{{old('office_number',@$data->office_number)}}">


                    <?php if(@$errors->first('office_number')) { ?><span class="help-block">{{@$errors->first('office_number')}}</span> <?php } ?>
                  </div>
                </div>



                 <div class="form-group row  @if($errors->first('cell_phone')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> cell phone {{redstar()}}</label>
                  <div class="col-sm-10">
                     

                       <input type="text" name="cell_phone"  class="form-control" placeholder="Cell Phone" value="{{old('cell_phone',@$data->cell_phone)}}">


                    <?php if(@$errors->first('cell_phone')) { ?><span class="help-block">{{@$errors->first('cell_phone')}}</span> <?php } ?>
                  </div>
                </div>


                 <div class="form-group row @if($errors->first('email_address')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Email address{{redstar()}}</label>
                  <div class="col-sm-10">
                     
                       
                      <input type="text" name="email_address"  class="form-control" placeholder="Email Address" value="{{old('email_address',@$data->email_address)}}" <?php echo (isset($data->id))?'readonly':'';  ?>>



                    <?php if(@$errors->first('email_address')) { ?><span class="help-block">{{@$errors->first('email_address')}}</span> <?php } ?>
                  </div>
                </div>



                  <div class="form-group row @if($errors->first('membership_type')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Membership Type {{redstar()}}</label>
                  <div class="col-sm-10">
                   
				    <select name="membership_type" class="form-control membership_type" id="membership_type">
				          <option value="">Select</option>
				          @foreach($memberShipPlan as $key=>$value)
				          <option data-attr-id = "{{ $value->storage_amount }}" data-attr-membertype-id = "{{ $value->id }}"  @if(@$data->membership_type==$value->membership_name) {{'selected'}} @endif value="{{ $value->membership_name}}">{{ $value->display_name}}</option>
				          @endforeach
				    </select>
                    <?php if(@$errors->first('membership_type')) { ?><span class="help-block">{{@$errors->first('membership_type')}}</span> <?php } ?>
                  </div>
                </div>

                <div class="form-group row @if($errors->first('storage_space')) {{' has-error has-feedback'}} @endif " style="display: none;">
                  <label for="inputError" class="col-sm-2 control-label"> Storage Space {{redstar()}}</label>
                  <div class="col-sm-10">                   
				        <select name="storage_space" class="form-control storage_space" id="storage_space">
				              <option value="">Select Storage Space</option>
								@foreach($memberShipPlan as $key=>$value)
								<option @if(!empty(@$data) && (@$data->accountStorageSize->space_size ==$value->storage_amount)) {{'selected'}} @endif value="{{ $value->storage_amount}}">{{ $value->storage_amount_display}}</option>
								@endforeach
				             <!-- @foreach($spaceUploadFiles as $key=>$value)
				              <option @if(!empty(@$data) && (@$data->accountStorageSize->space_size ==$key)) {{'selected'}} @endif value="{{ $key}}">{{ $value}}</option>
				              @endforeach -->
				        </select>
                    <?php if(@$errors->first('storage_space')) { ?><span class="help-block">{{@$errors->first('storage_space')}}</span> <?php } ?>
                  </div>
                </div>
                <div class="form-group row ">
                  <label for="inputError" class="col-sm-2 control-label"> Extra Storage Space </label>
                  <div class="col-sm-10">                   
				        <select name="extra_storage_space" class="form-control extra_storage_space" id="extra_storage_space">                  
d				              <option value="0">Select Extra Storage Space</option>
								@foreach($extraSpace as $key=>$value)
								<option @if(!empty(@$data) && ( (@$data->accountStorageSize->space_size - @$data->membershiptype->storage_amount ) ==$key)) {{'selected'}} @endif value="{{ $key}}">{{ $value}}</option>
								@endforeach
				             <!-- @foreach($spaceUploadFiles as $key=>$value)
				              <option @if(!empty(@$data) && (@$data->accountStorageSize->space_size ==$key)) {{'selected'}} @endif value="{{ $key}}">{{ $value}}</option>
				              @endforeach -->
				        </select>
                    <?php if(@$errors->first('storage_space')) { ?><span class="help-block">{{@$errors->first('storage_space')}}</span> <?php } ?>
                  </div>
                </div>
<input type="hidden" value="" name="totalspace" id="totalspace" />                 
                  <input type="hidden" value="" name="membertypeId" id="membertypeId" /> 
                 <div class="form-group row @if($errors->first('status')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Status {{redstar()}}</label>
                  <div class="col-sm-10">
                      <select name="status" class="form-control" id="status">
                                            <option value="">Select</option>
                                            <option @if(@$data->status=='n') {{'selected'}} @endif value="n">{{_i('No')}}</option>
                                            <option @if(@$data->status=='y') {{'selected'}} @endif value="y">{{_i('Yes')}}</option>
                                        </select>


                    <?php if(@$errors->first('status')) { ?><span class="help-block">{{@$errors->first('status')}}</span> <?php } ?>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-AccountList')}}" class="btn btn-default">Cancel</a>
                <input  id="add-video" type="submit" value="Submit" class="btn btn-info">
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
<script src="{{asset('js/addAccount.js')}}"></script>
<script type="text/javascript">
	
$( ".membership_type" ).change(function(e) {
var storageAmount = $("#membership_type option:selected" ).attr("data-attr-id");
var membertypeId = $("#membership_type option:selected" ).attr("data-attr-membertype-id");
$('#membertypeId').val(membertypeId);
$(".storage_space").val(storageAmount);
toGetTotalSpace();
}).change();
$( ".extra_storage_space" ).change(function(e) {
	toGetTotalSpace();
});

function toGetTotalSpace(){
var storageSpace 		= $("#storage_space option:selected" ).val();
var extraSpace 			= $("#extra_storage_space option:selected" ).val();
var totalSpace 			=  Number(extraSpace) + Number(storageSpace);
$('#totalspace').val(totalSpace);
}
</script>
  @endsection