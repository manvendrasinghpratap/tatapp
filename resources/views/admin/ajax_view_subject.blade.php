<?php 

//echo $data['caseList']->account_id;
//dd($data); 
//dd($data['sectorListByAccount']);

 //dd($data['getAllSectorByCaseId']);
                         
?>
<!-- START Datatable -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

<!-- END Datatable -->
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">

<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->


<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- End Datatable -->
<script type="text/javascript">
    $( document ).ready(function() {
    
      $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      });
         
      $.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
      }, "Combination of alphabets,special characters & numeric values required.");
        $('#modalform').validate({
            ignore: ".ignore",
            rules: {
                
                name:'required',
                phone_number: {
                    minlength: 6,
                    maxlength: 15,
                    digits: true
                },
                 cell_phone: {
                    minlength: 6,
                    maxlength: 15,
                    digits: true
                },
                address: {
                    minlength: 4,
                    maxlength: 250
                },
                state: {
                    minlength: 3,
                    maxlength: 200
                },
                city: {
                    minlength: 3,
                    maxlength: 200
                },
                zip_code: {
                    minlength: 3,
                    maxlength: 15
                },

            },
            // Specify validation error messages
            messages: {
              
                
                name: "Please enter name.",
                
                
                
            },
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      

             
                   var form_data = new FormData(form); 
                   

                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSaveSubject')}}",
                    dataType: 'html',
                    data:form_data,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                    //result=html.split('#');
                    $('#ajaxresp').html(response);
                    $('#myModal').modal('hide');
                     location.reload();

                       }
                    });

    }

        });
    });
  
</script>
  <?php //dd_my($data['subjectDetailsArray']); 
                      
$subject_id = isset($data['subjectDetailsArray']->id)?$data['subjectDetailsArray']->id:'';

$name = isset($data['subjectDetailsArray']->name)?$data['subjectDetailsArray']->name:'';
$phone_number = isset($data['subjectDetailsArray']->phone_number)?$data['subjectDetailsArray']->phone_number:'';
$cell_phone = isset($data['subjectDetailsArray']->cell_phone)?$data['subjectDetailsArray']->cell_phone:'';
$address = isset($data['subjectDetailsArray']->address)?$data['subjectDetailsArray']->address:'';


$state = isset($data['subjectDetailsArray']->state)?$data['subjectDetailsArray']->state:'';
$city = isset($data['subjectDetailsArray']->city)?$data['subjectDetailsArray']->city:'';
$zip_code = isset($data['subjectDetailsArray']->zip_code)?$data['subjectDetailsArray']->zip_code:'';
$profile_pic = isset($data['subjectDetailsArray']->profile_pic)?$data['subjectDetailsArray']->profile_pic:'';

                      ?>

<!-- Trigger the modal with a button -->
        
    
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <form name="modalform" id="modalform" method="post" action="">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                <h4 class="modal-title">Manage Subject</h4>
                </div>
               
                <div class="modal-body">

                <div class="inner-div">
                      
                        <input type="hidden" name="token" id="token" value="">
                        <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
                        <input type="hidden" name="case_id" value="<?php echo $data['caseList']->id; ?>">
                        <input type="hidden" name="subject_id" id="subject_id" value="<?php echo $subject_id; ?>"  class="subjectClass" value="">
                         <br/>
                         @if(@$profile_pic!='')
                        <div class="row">
                                <div class="col-sm-8">
                                    
                        
                        <img src="{{get_image_url(@$profile_pic,'subject')}}" class="img-thumbnail">
                       
                       
                                </div>
                        </div>
                         @endif
                        

                          <br/>
                        <input type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Name" style="border:1px solid black;"/>

                        <br/><br/>
                        <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" value="<?php echo $phone_number; ?>"  style="border:1px solid black;"/>
                         <br/><br/>
                        <input type="text" id="cell_phone" name="cell_phone" value="<?php echo $cell_phone; ?>"  placeholder="Cell Phone" style="border:1px solid black;"/>
                        <br/>
                    </div>
                    <div class="inner-div">
                            <div class="row">
                                <div class="col-sm-4">Address:</div>
                                <div class="col-sm-4"><input type="text" id="address" name="address" value="<?php echo $address; ?>"  placeholder="Address" style="border:1px solid black;"/></div>
                            </div>
                       
                        <br/>
                        <div class="row">
                                <div class="col-sm-4">State:</div>
                                <div class="col-sm-4"><input type="text" id="state" name="state" value="<?php echo $state; ?>"  placeholder="State" style="border:1px solid black;"/></div>
                        </div>
                        <br/>
                        <div class="row">
                                <div class="col-sm-4">City:</div>
                                <div class="col-sm-4"><input type="text" id="city" name="city" value="<?php echo $city; ?>" placeholder="City" style="border:1px solid black;"/></div>
                        </div>
                        <br/>
                        <div class="row">
                                <div class="col-sm-4">Zip Code:</div>
                                <div class="col-sm-4"><input type="text" id="zip_code" name="zip_code" value="<?php echo $zip_code; ?>" placeholder="Zip Code" style="border:1px solid black;"/></div>
                        </div>
                         <br/>
                        <div class="row">
                                <div class="col-sm-4">Image:</div>
                               <!--  <div class="col-sm-4"> <input type="file" id="profile_pic"  name="profile_pic" data-buttonName="btn-primary">
                                </div> -->

                                <div class="col-sm-4">
                                <a href="#" class="btn btn-default" id="galleryBox" onclick="open_gallery_modal(<?php echo $data['caseList']->id; ?>, '{{route('admin-ajaxShowGallery')}}');">Select from Gallery</a>
                                </div>
                        </div>
                        <br/>
                        <div class="row">
                                <div class="col-sm-4">&nbsp;<input type="hidden" id="profile_pic"  name="profile_pic" ></div>
                                <div class="col-sm-4" id="appendImgBox"></div>
                        </div>


                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="modal-footer">

                    
                    <button type="button" class="btn btn-primary" id="saveSubject">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    
                </div>
        </form>  
    

                </div>
            </div>
        </div>

<!--   New Block -->
<script type="text/javascript">
   
    $('#saveSubject').on('click', function(){

        
        $('#modalform').submit();

    });


</script>
<script>



     var open_gallery_modal = function(case_id, link1) {
          
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    case_id:case_id 
                    },
                    success: function (data) {

                      
                        $('#galleryDetails').html(data);
                        //$('#modalBt').trigger('click');
                        $('#myModal2').modal('show');  
                       
                       
                   

                       }
                    });

    
    };



</script>
   