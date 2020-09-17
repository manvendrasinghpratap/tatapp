@extends('layout.backened.header')
@section('content')
<style>
    .error{
        color:red;
    }
</style>
<script type="text/javascript">
    $( document ).ready(function() {
    
      $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      });
         
      $('#userProfile').validate({
            ignore: ".ignore",
            rules: {
                email: {
                    required:true,
                    email:true,
                    remote: {
                        url: '{{route("check_email")}}'+'?id='+'{{@$data->id}}',
                        type: "get",
                        data: {
                            title: function() {
                                return $("#email").val();
                            }
                        },
                    },
                },
                 postcode: {
                  required: true,
                    //digits: true,
                    
                },
                phone: {
                    required: true,
                    digits: true,
                    
                },
                name:'required',
                //city_id: "required",
                //country_id: "required",
                //state_id: "required",
                street: "required",
                website: "required",
                // about_info: "required",

                profile_pic: {
                    accept: "image/*",
                    filesize: 5242880, //5MB  
                },
            },
            // Specify validation error messages
            messages: {
              
                email:
                {
                    required:"Please enter email.",
                    email:"Please enter valid email.",
                    remote:"Email already exist."
                },
                name: "Please enter  name.",
                //city_id: "Please select city.",
                //state_id: "Please select state.",
                //country_id: "Please select town.",
                street: "Please select street.",
                postcode: "Please select postcode/town.",
                phone: "Please select phone.",
                website: "Please select website.",
                //about_info: "Please select info.",
                profile_pic: {
                    accept: "Please select a valid profile image.",
                    filesize:"Please upload profile image of size less than 5 MB.",
                },
            },
        });
    });
  
</script>

<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
        <section class="content-header">
            <div class="paddingbottom10px"><h3>Update Profile</h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
        <li class="active">Update Profile</li>
      </ol>
    </section>
    
   
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>              
              @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('message') !!} 
                </div>
                @endif
            </div> 
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" id="userProfile" action="{{route('admin-profile')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">               
              <input type="hidden" name="id" value="{{old('id',@$data->id)}}">
                <div class="form-group @if($errors->first('first_name')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">First Name</label>
                  <div class="col-sm-10">
                      <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Fisrt Name" value="{{old('name',@$data->first_name)}}">
                    <?php if(@$errors->first('first_name')) { ?><span class="help-block">{{@$errors->first('first_name')}}</span> <?php } ?>
                  </div>
                </div>
                   <div class="form-group @if($errors->first('last_name')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Last Name</label>
                  <div class="col-sm-10">
                      <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{old('name',@$data->last_name)}}">
                    <?php if(@$errors->first('last_name')) { ?><span class="help-block">{{@$errors->first('last_name')}}</span> <?php } ?>
                  </div>
                </div>
               <div class="form-group @if($errors->first('email')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Email{{redstar()}}</label>
                  <div class="col-sm-10">
                    <input readonly="true" type="text" name="email" class="form-control" placeholder="Email" value="{{old('email',@$data->email)}}">
                    <?php if(@$errors->first('email')) { ?><span class="help-block">{{@$errors->first('email')}}</span> <?php } ?>
                  </div>
                </div>
                  
                     <!--<div class="form-group @if($errors->first('country_id')) {{' has-error has-feedback'}} @endif ">
                  <label for="form-control" class="col-sm-2 control-label">Country{{redstar()}}</label>
                  <div class="col-sm-10">
                    <select name="country_id" class="input-control countries" id="countryId" required="required">
                                    <option value="">Select Country</option>
                                 
                                    </select>
                     
                      <?php if(@$errors->first('state_id')) { ?><span class="help-block">{{@$errors->first('state_id')}}</span> <?php } ?>
                  
                  </div>
                </div>
                 <div class="form-group @if($errors->first('state_id')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">State{{redstar()}}</label>
                  <div class="col-sm-10">
                     <select name="state_id" class="input-control states" id="stateId" required="required">
<option value="">Select State</option>
</select>
                       
                  </div>
                </div>
              <div class="form-group @if($errors->first('city_id')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Town{{redstar()}}</label>
                  <div class="col-sm-10">
                    <select name="city_id" class="input-control cities" id="cityId" required="required">
<option value="">Select City</option>
</select>
                   
                       <?php if(@$errors->first('city_id')) { ?><span class="help-block">{{@$errors->first('city_id')}}</span> <?php } ?>
                  
                  </div>
                </div>-->
              
          <?php  $addressArray = array('0'=>'','1'=>''); if(!empty($data->address)){ $addressArray = explode('~~',$data->address);}?>
              <div class="form-group @if($errors->first('street')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Street/Nr{{redstar()}}</label>
                  <div class="col-sm-10">
                    <input type="text" name="street" class="form-control" placeholder="Street" value="{{old('street',@$addressArray[0])}}">
                   
                  </div>
                </div>
              <div class="form-group @if($errors->first('postcode')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Postcode/Town{{redstar()}}</label>
                  <div class="col-sm-10">
                    <input type="text" name="postcode" class="form-control" placeholder="Postcode" value="{{old('postcode',@$addressArray[1])}}">
                    <?php if(@$errors->first('email')) { ?><span class="help-block">{{@$errors->first('postcode')}}</span> <?php } ?>
                  </div>
                </div>
              <div class="form-group @if($errors->first('phone')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Phone{{redstar()}}</label>
                  <div class="col-sm-10">
                    <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{old('phone',@$data->phone)}}">
                    <?php if(@$errors->first('phone')) { ?><span class="help-block">{{@$errors->first('phone')}}</span> <?php } ?>
                  </div>
                </div>
                  <div class="form-group @if($errors->first('cell_phone')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Cell Phone{{redstar()}}</label>
                  <div class="col-sm-10">
                    <input type="text" name="cell_phone" class="form-control" placeholder="Cell Phone" value="{{old('phone',@$data->cell_phone)}}">
                    <?php if(@$errors->first('cell_phone')) { ?><span class="help-block">{{@$errors->first('cell_phone')}}</span> <?php } ?>
                  </div>
                </div>
              <div class="form-group @if($errors->first('website')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Website</label>
                  <div class="col-sm-10">
                    <input  name="website" class="form-control" placeholder="Website" value="{{old('website',@$data->website)}}">
                    <?php if(@$errors->first('website')) { ?><span class="help-block">{{@$errors->first('website')}}</span> <?php } ?>
                  
                  </div>
                </div>
            
                <div class="form-group @if($errors->first('about_info')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Additional info</label>
                  <div class="col-sm-10">
                    <textarea name="about_info" rows="5" class="form-control" id="about_info" placeholder="Additional info" maxlength="400">{{old('about_info',@$data->additional_info)}}</textarea>
                    <?php if(@$errors->first('about_info')) { ?><span class="help-block">{{@$errors->first('about_info')}}</span> <?php } ?>
                  </div>
                </div>
                    
                    @if(@$data->profile_pic!='')
                  <div class="form-group  ">
                     <label for="inputError" class="col-sm-2 control-label">Image</label>
                     <div class="col-sm-10">
                         <img src="{{get_image_url(@$data->profile_pic,'user')}}" style="height:100px">
                      </div>
                  </div>
                  @endif
                
                
                <div class="form-group @if($errors->first('profile_pic')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Profile Pic</label>
                  <div class="col-sm-10">
                     <input type="file" id="profile_pic" name="profile_pic" class="upload">
                   
                  </div>
                </div>
                  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-dashboard')}}" class="btn btn-default">Cancel</a>
                <input type="submit" value="Submit" class="btn btn-info">
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          
        </div>
        <!--/.col (right) -->
        </div>
       
   </div>    </div>
	 
  @endsection