@extends('layout.backened.header')
@section('content')
<?php
//dd($data);
?>
<link rel="stylesheet" href="{{asset('css/forum.css')}}">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Topic</h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Topic</li>
      </ol>
    </section>
    
    <section class="content forum-ovt">
      

      <!-- Trigger the modal with a button -->
        <button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display:none;">Open Modal</button>
        
      <div id="newReplyResp">
    
      </div>
          <div class="row">
            <div class="col-md-12 hidden">
             <input type="text" name="case_id" id="case_id" value="<?php echo $data['case_id']; ?>">
             <input type="text" name="forum_id" id="forum_id" value="<?php echo $data['forum_id']; ?>">
             <input type="text" name="topic_id" id="topic_id" value="<?php echo $data['topic_id']; ?>">
           </div>
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

                        <form id="user-mng" method="get" action="{{route('admin-view-topic',['id'=>$data['topic_id']])}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Keyword')}}" type="text">
                                        </div>
                                    </div>
                                </div> 
                                

                                  


                                <div class="col-sm-5">
                                    <button type="submit" class="btn btn-primary btn-info">{{_i('Search')}}<div></div></button>
                                    <a href="{{route('admin-view-topic',['id'=>$data['topic_id']])}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                   
                                </div>

                              
                                    
                            </div>
                        </form>

                        @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! session('message') !!} 
                        </div>
                        @endif
                    </div>

 </div> </div> </div>
 <div class="row">
<div class="col-sm-8 msgttl-in">        
    {{$data['forumDetails']->title}}       
</div>
  <?php 
    $allowRolesList = array("agencySuperAdmin", "agencyAdmin");
    $user_role_name = Session::get('user_role_name');
    if (in_array($user_role_name, $allowRolesList))
    {
    ?>
    <div class="col-sm-4 pull-right pst-rpli-link">
        <a href="#" id="postReply"  class="btn btn-block btn-warning pull-right">Post Reply</a>
    </div>
    <?php } ?>
  </div>

<form id="reply-form" method="post" enctype="multipart/form-data" action="{{route('admin-view-topic',['id'=>$data['topic_id']])}}" style="display:none;">
<input type="hidden" name="topic_id" id="topic_id" value="<?php echo $data['topic_id']; ?>">
<div class="reply-form-bx">
  <h3 class="pst-a-rpl">Post a reply</h3>
  <div class="form-group"> 
    <div class="row">
      <label class="col-sm-3">
          Subject :
      </label>
      <div class="col-sm-9">
          <input type="text" id="subject" name="subject" placeholder="Subject" class="form-control" value="Re:<?php echo $data['forumDetails']->subject; ?>" />
      </div>
    </div>
  </div>  
  <div class="form-group"> 
    <div class="row">
      <label class="col-sm-3">
          Message :
      </label>
      <div class="col-sm-9">
           <textarea rows="5" cols="20" type="text" id="messageboxcontent" name="messageboxcontent" placeholder="Description" class="form-control"/></textarea>
           <textarea rows="5" cols="20"  class="hidden" id="message" name="message" placeholder="Description"/></textarea>
      </div>
    </div>  
  </div>  
  <div class="form-group"> 
    <div class="row">
      <label class="col-sm-3">
          &nbsp;
      </label>
      <div class="col-sm-9 btn-rpli">
          <input type="button" value="Reply" id="postReplyBtn" class="btn btn-info" />
      </div>
    </div>  
  </div> 
</div>  
</form>

@if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
<div class="tpc-rpli">
     <div class="row mt mb">
    <div class="large-12">
      
      
      <div class="toggleview">
        
        
        <div class="forum-topic">
          <div class="mn-msg-bdi" style="padding-left: 15px;">
            <div class="overflow-control msg-sbjct">
              <span class="msg-replySubject">
               {{$row->replySubject}}
              </span>
               
               <div class="msg-quoto">
                
                <?php 
                $login_user_id = Session::get('id');
                if($row->created_by==$login_user_id){ ?>
                 <a href="#" class="deletedPostClass" data-newid="{{$row->id}}"><i class="fa fa-trash"></i></a>&nbsp;
                 <?php } ?>
                  <a href="#reply-form"><i class="fa fa-reply msgReply"></i></a>
               </div>
            </div>
             <div class="msg-crt">
                <?php echo date("F j Y, h:i:s a", strtotime($row->created_at)); ?>               
             </div>
            <div class="msg-pstd">by <a href="#">{{$row->first_name}} {{$row->last_name}}</a></div>
            <div class="msg-bdi">
               <?php echo $row->message; ?>
            </div>
            
          </div>
          <div class="msg-pst-cntnt">
            
           
          </div>
         
        </div>
       
      </div>

  
    </div>
  </div>
   </div>      
     
 <?php $k++; ?>     
                            @endforeach
                            @else
                            <div class="large-12 forum-topic">
                                <div class="large-12 small-4 column pad">
                                   <span>Record(s) not found.</span>
                                </div>
                            </div>
                            @endif
        
 </div>

       <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {!! $data['records']->links() !!}
                        </ul>
                    </div>
<script src="{{asset('js/forum.js')}}"></script>
<!-- <script src="js/drag.js"></script> -->
<script src="https://cdn.ckeditor.com/4.8.0/standard-all/ckeditor.js"></script>
<!--   New Block -->
<script type="text/javascript">

     //debugger;
    //CKEDITOR.instances['summaryboxarea'].on('change', function() {alert('value changed!!');});
        CKEDITOR.replace( 'messageboxcontent', {
            // Define the toolbar groups as it is a more accessible solution.
            toolbarGroups: [
                {"name":"basicstyles","groups":["basicstyles"]},
                {"name":"links","groups":["links"]},
                {"name":"paragraph","groups":["list","blocks"]},
                {"name":"document","groups":["mode"]},
                {"name":"insert","groups":["insert"]},
                {"name":"styles","groups":["styles"]},
                {"name":"about","groups":["about"]}
            ],
            // Remove the WebSpellChecker plugin.
            removePlugins: 'wsc',
            height: 350,
            // Configure SCAYT to load on editor startup.
            scayt_autoStartup: true,
            // Limit the number of suggestions available in the context menu.
            scayt_maxSuggestions: 3,
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
        });


         $('#postReplyBtn').on('click', function(){
             
          var editor = CKEDITOR.instances.messageboxcontent;
          var editordata = editor.getData();
          $("#message").val(editordata);
          
           var sdata = $("#reply-form").serialize();

           $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajax-save-reply')}}",
                    dataType: 'html',
                    data: sdata,
                    success: function (data) {
                                
                     
                        location.reload();
                       
                      
                   

                       }
                    });


             
                  
                
            });



$(document).ready(function(){
   
      $( "#postReply" ).click(function() {
          $( "#reply-form" ).toggle( "slow", function() {
          // Animation complete.
          });
      });


      $( ".msgReply" ).click(function() {
         
          var msgDataContent = $(this).closest(".mn-msg-bdi").find( ".msg-bdi" ).html();

          var msgData = '<blockquote class="blockquote last">'+msgDataContent+'</blockquote>';          
          
          var editor = CKEDITOR.instances.messageboxcontent;
            editor.setData( msgData );
          
          $( "#message" ).val(msgData);

          var replySubjectData = $(this).closest(".mn-msg-bdi").find( ".msg-replySubject" ).text();
          var newSubject = 'Re:'+$.trim(replySubjectData);
          $( "#subject" ).val(newSubject);
          
          $( "#reply-form" ).toggle( "slow", function() {
          // Animation complete.
          });
      });


      
       $( ".deletedPostClass" ).click(function() {
        var post_id = $(this).data("newid");

        $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxDeletePost')}}",
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    post_id:post_id
                    },
                    success: function (data) {
                                
                     
                        location.reload();
                       
                      
                   

                       }
                    });

      });


});



</script>
  @endsection