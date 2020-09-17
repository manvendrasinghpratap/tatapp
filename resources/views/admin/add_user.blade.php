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
      <h3>@if(@$data->id){{'Update'}} @else {{'Add'}} @endif {{_i('User')}}</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin-users')}}">Team</a></li>
        <li class="active">@if(@$data->_id){{'Update'}} @else {{'Add'}} @endif {{_i('User')}}</li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
  <script type="text/javascript">
    $( document ).ready(function() {
    
      $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      });
         
      $.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
      }, "Combination of alphabets,special characters & numeric values required.");
      $('#add-form').validate({
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
                role_id:'required',
                first_name:'required',
                last_name: "required",
                email: "required",
                referral_code: "required",

                new_password: {
                    minlength: 6,
                    maxlength: 15,
                    alphanumspecial: true
                },
                confirm_password:{
                    required: {
                        depends: function(element) {
                            return ($("input[name=new_password]").val() != "" && $('input[name=id]').val() != "");
                        },
                    },
                    minlength:6,
                    equalTo : "#new_password",
                },
                name: {
            		required:true,
                },
                'group_id[]':'required',
            },
            // Specify validation error messages
            messages: {
              
                email:
                {
                    required:"Please enter email.",
                    email:"Please enter valid email.",
                    remote:"Email already exist."
                },
                role_id: "Please Select Role from the List.",
                first_name: "Please enter  First Name.",
                last_name: "Please enter  Last Name.",
                referral_code: "Please enter  Referral Code.",
                new_password:{
                    minlength: "Password must be 6 characters long hhhh.",
                    maxlength: 'Maximum length required is 15',
                    alphanumspecial: 'Combination of alphabets,special characters & numeric values required',
                },
                confirm_password:{
                    required:"Please enter confirm password.",
                    minlength: "Password must be 6 characters long.",
                    equalTo : "Confirm password should match with new password.",
                }
            },
        });
    });
  
</script>


   
   
      <div class="row">
        <div class="col-md-9">
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
$isAllowToCreateNewUser = isAllowToCreateNewUser($account_membership_type, $totalExistUsers);
 
if(!isset($data->id)){
              
if(!$isAllowToCreateNewUser){
?>
<div class="alert alert-danger">
  <strong>Sorry!</strong> You are not allowed to create any more user in your membership plan. Please upgrade your membership.
</div>
<?php
}
}

$formVisibilityStatus = '';
       
if(!$isAllowToCreateNewUser){
$formVisibilityStatus = 'style="display:none;"';
}
if(isset($data->id) && $data->id>0){
$formVisibilityStatus = '';
} 
?>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="" id="add-form" action="@if(@$data->id) {{route('admin-edituser',['id'=>@$data->id])}} @else  {{route('admin-adduser')}} @endif" method="POST" enctype="multipart/form-data" <?php echo $formVisibilityStatus; ?>>
            {{ csrf_field() }}
         
              <div class="box-body">
              <input type="hidden" name="id" id= "userId" value="{{old('id',@$data->id)}}">


<?php
//dd($data->account_id);
$user_role_name = Session::get('user_role_name');   
            if ($user_role_name=="superAdmin")
            {
            ?>
              <div class="form-group row @if($errors->first('account_id')) {{' has-error has-feedback'}} @endif ">
                <label for="inputError" class="col-sm-3 control-label"> Account List{{redstar()}}</label>
                <div class="col-sm-9">
                    <select name="account_id" class="form-control" id="account_id">
                                          <option value="">Select</option>
                                          <?php foreach($account_list as $key=>$val){ ?>
                                          <option @if(@$data->account_id ==$val->id) {{'selected'}} @endif value="<?php echo $val->id; ?>"><?php echo $val->name; ?></option>
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
                    <div class="form-group row @if($errors->first('last_name')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-3 control-label">Group{{redstar()}}</label>
                    <div class="col-sm-9">
                    <!-- <select name="group_id[]" class="form-control" id="group_id" multiple="true">
                    <option value="">Select Group</option>
                    @foreach($groupsListAssignedToAccount as $accountList)
                    @foreach($accountList->accountGroups as $groups)                    
                    <option @if(in_array($groups->group->id,$existingUserGroupArray)) {{ 'selected'}} @endif value="{{ $groups->group->id}}">  {{ $groups->group->name}} </option>
                    @endforeach
                    @endforeach
                    </select>-->

                    <select name="group_id[]" class="form-control" id="group_id" multiple="true">
                    <option value="">Select Group</option>
                    @foreach($accountAndGroup as $key=>$groups)                    
                    <option @if(in_array($key,$existingUserGroupArray)) {{ 'selected'}} @endif value="{{$key}}">  {{ $groups}} </option>
                    @endforeach
                    </select>
                    <?php if(@$errors->first('last_name')) { ?><span class="help-block">{{@$errors->first('last_name')}}</span> <?php } ?>
                    </div>
                    </div>
                    <div class="form-group row @if($errors->first('role_id')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Role{{redstar()}}</label>
                  <div class="col-sm-9">
                      <select name="role_id" class="form-control" id="role_id">
                                            <option value="">Select</option>
                                            <?php foreach($roleList as $key=>$val){ 
                                                //dd($val);
                                              ?>

                                            <option @if(@$data->role_id == $val->id) {{'selected'}} @endif value="<?php echo $val->id; ?>"><?php echo $val->display_name; ?></option>
                                            <?php
                                                }
                                            ?>
                                            
                                        </select>


                    <?php if(@$errors->first('role_id')) { ?><span class="help-block">{{@$errors->first('status')}}</span> <?php } ?>
                  </div>
                </div>






                <div class="form-group row @if($errors->first('first_name')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label">First Name{{redstar()}}</label>
                  <div class="col-sm-9">
                    <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{old('first_name',@$data->first_name)}}">
                    <?php if(@$errors->first('first_name')) { ?><span class="help-block">{{@$errors->first('first_name')}}</span> <?php } ?>
                  </div>
                </div>

                <div class="form-group row @if($errors->first('last_name')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label">Last Name{{redstar()}}</label>
                  <div class="col-sm-9">
                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{old('last_name',@$data->last_name)}}">
                    <?php if(@$errors->first('last_name')) { ?><span class="help-block">{{@$errors->first('last_name')}}</span> <?php } ?>
                  </div>
                </div>


               <div class="form-group row @if($errors->first('email')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label">Email{{redstar()}}</label>
                  <div class="col-sm-9">
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

                

                <div class="form-group row @if($errors->first('new_password')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" id="new_password" name="new_password" class="form-control" placeholder="New password" value="{{old('new_password')}}">
                        <?php if(@$errors->first('new_password')) { ?><span class="help-block">{{@$errors->first('new_password')}}</span> <?php } ?>
                    </div>
                    </div>
                    <div class="form-group row @if($errors->first('confirm_password')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-3 control-label">Confirm Password</label>
                    <div class="col-sm-9">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="{{old('confirm_password')}}">
                        <?php if(@$errors->first('confirm_password')) { ?><span class="help-block">{{@$errors->first('confirm_password')}}</span> <?php } ?>


                    </div>
                    </div>


                
                  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="submit" value="Submit" class="btn btn-info">
                <a href="{{route('admin-users')}}" class="btn btn-default">Cancel</a>
                
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#account_id").change(function(){
            var account = $("select[name=account_id]").val();
            var userId = $("#userId").val();
            $.ajax({
            type:'POST',
            url:"{{ route('admin-list-all-group') }}",
            data:{accountId:account,userId:userId},
            success:function(data){
            $('#group_id').html(data);
            }
            });
    }).change();
    /*$("#account_id").change(function(e){
          e.preventDefault();
          var account = $("select[name=account_id]").val();
          var userId = $("#userId").val();
          $.ajax({
          type:'POST',
          url:"{{ route('admin-list-all-group') }}",
          data:{accountId:account,userId:userId},
          success:function(data){
            $('#group_id').html(data);
          }
          });

    });*/

</script>
  @endsection