@extends('layout.backened.header')
@section('content')

<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">

<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- End Datatable -->
<script type="text/javascript">
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $( document ).ready(function() { $.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
      }, "Combination of alphabets,special characters & numeric values required.");	  
        $('#modalform').validate({
            ignore: ".ignore",
            rules: {                
                title:'required',
                description:'required',
                profile_pic:{required:true}
            },
            // Specify validation error messages
            messages: {       
            },
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
                   $('#ajaxresp').html('<div class="loader"></div>');
                    var form_data = new FormData(form); 
                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxSaveFile')}}",
                    dataType: 'html',
                    data:form_data,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                     location.reload();
                    //result=html.split('#');
                    $('#ajaxresp').html(response);
                    $('#addDiv').hide('slow');
                    $('#addFilebtn').show('slow');
					$('.sectortbl111').show('slow');
                    //$('#myModal').modal('hide');
                       }
                    });
               }
        });
    });
  
</script>
<div class="clearfix"></div>
 <div class="section" > 
    <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="classnameheading">{{@$data['caseList']->title}}</div>
        <div class="paddingbottom10px"><h3>@if(@$request->id){{'Assign Case to Task '}} @else {{'Manage Files'}} @endif </h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> {{_i('Home')}}</a></li>
        <li class="active">@if(@$request->id){{'Assign Case to Task'}} @else {{'Add Files'}} @endif </li>
      </ol>
    </section>
        <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;} .margin-bottom10{margin-bottom:10px;}</style>   
  <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- End Datatable -->
<script src="{{asset('js/files.js')}}"></script>
    

<!-- Trigger the modal with a button -->
        <div id="sectorDetails"></div>
        <button id="modalBt" type="button" class="btn btn-info btn-lg hidden" data-toggle="modal" data-target="#myModal">Open Modal</button>
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <form name="modalform" id="modalform" method="post" action="">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                            <h4 class="modal-title">Manage Files</h4>
                        </div>
                        <div class="modal-body" id="addDiv" style="display:none_;"> 
                        </div> <!-- addDiv -->  
                        <div class="modal-body sectortbl111">
                              <div class="row">
                                  <div class="col-sm-8"></div>
                                  <div class="col-sm-4" class="float-sm-right">                                      
                                         <button type="button" class="btn btn-primary pull-right" id="addFilebtn" onclick="addFileDetails(0,{{ $data['caseList']->id}},'{{route('admin-ajaxEditFileDetails')}}');">Add file</button>
                                    </div>
                              </div>
                              <br>
                            </div>
                        </div> <!-- modal-content-->
                </form> 
                </div>
            </div>
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
              
        
<!--   New Block -->
            <button type="button" class="btn btn-primary pull-right margin-bottom10" id="addFilebtn" onclick="addFileDetails(0,{{ $data['caseList']->id}},'{{route('admin-ajaxEditFileDetails')}}');">Add file</button>
            <table id="sectortbl" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <!--<th>SL No</th>-->
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created Date</th>
                        <th style="width:20%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($data['fileListArray'])>0)
                        @foreach($data['fileListArray'] as $key=>$row)                             
                    <tr>
                        <td>
                            <?php $profile_pic = isset($row->profile_pic)?$row->profile_pic:''; ?>
                            @if(@$profile_pic!='')
                                <?php
                                    $path = get_image_url($profile_pic,'files');
                                    $ext = pathinfo($path, PATHINFO_EXTENSION); 
                                    $extensionsArray = array('jpg', 'JPG', 'png' ,'PNG' ,'jpeg' ,'JPEG');
                                    if (in_array($ext, $extensionsArray))
                                        { ?>
                                        <img src="{{get_image_url(@$profile_pic,'files')}}" style="width:100px;height:100px"><?php
                                        }
                                        else { ?> <a href="{{get_image_url(@$profile_pic,'files')}}">Download file</a><?php
                                        }
                                  ?> 
                            @endif
                           <div style="padding:10px 0px 0px 20px"> {{ @$row->title }}</div></td>
                            <td><?php echo $row->description; ?></td>
                            <td><?php echo date("F j, Y", strtotime($row->created_at));
                            $profile_pic = $row->profile_pic;
                            ?></td>
                            <td>
                                    <a href="{{get_image_url(@$profile_pic,'files')}}" class="btn btn-primary btn-xs action-btn" download>

                                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                                    </a>

                                     <a href="javascript:editFileDetails(<?php echo $row->id; ?>, '{{route('admin-ajaxEditFileDetails')}}');" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-xs action-btn" onclick="delete_file(<?php echo $row->id; ?>, <?php echo $row->case_id; ?>,'{{route('admin-ajaxDeleteFile')}}');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                
            </tr>
                          @endforeach
                          @else
                          @endif
             
           
        </tbody>
       
    </table>
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
