@extends('layout.backened.header')
@section('content')
<link rel="stylesheet" href="{{asset('css/forum.css')}}">
 <div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>Topic</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Topic List</li>
      </ol>
    </section>
    
  
      

      <!-- Trigger the modal with a button -->
        <button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display:none;">Open Modal</button>
        
      <div id="topicListResp">
    
      </div>
          <div class="row">
             <input type="hidden" name="case_id" id="case_id" value="<?php echo $data['case_id']; ?>">
             <input type="hidden" name="forum_id" id="forum_id" value="<?php echo $data['forum_id']; ?>">
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

                        <form id="topic-list" method="get" action="{{route('admin-topic-list',['id'=>$data['forum_id']])}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Keyword')}}" type="text">
                                        </div>
                                    </div>
                                </div> 
                                

                                  


                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-primary btn-info">{{_i('Search')}}<div></div></button>
                                    <a href="{{route('admin-topic-list',['id'=>$data['forum_id']])}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                               
                                <?php 
            $allowRolesList = array("agencySuperAdmin", "agencyAdmin", "agencyUser");
            $user_role_name = Session::get('user_role_name');
            if (in_array($user_role_name, $allowRolesList))
            {
            ?>
            <div class="col-sm-5 pull-right">
                                        <a id="createTopic" data-link1="{{route('admin-ajaxGetTopicDetails')}}" class="btn btn-block btn-warning">Create topic</a>
            </div>
            <?php } ?>
                                    
                  </div>           </div>
                        </form>

                        @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! session('message') !!} 
                        </div>
                        @endif
                    </div>

 </div> </div> </div>


     <div class="row mt mb" id="ajaxresp">
    <div class="large-12">
      <div class="large-12 ttl-in">
        <div class="large-8 small-10 column lpad">
         <h3> {{$data['forumDetails']->title}}</h3>
        </div>
       
      </div>
      
      <div class="toggleview">
        <div class="large-12 forum-head">
          <div class="large-6 small-8 column lpad">
            TOPICS
          </div>
          <div class="large-1 column lpad">
            REPLIES
          </div>
         <!--  <div class="large-1 column lpad">
            VIEWS
          </div> -->
          <div class="large-5 small-4 column lpad">
            LAST POST
          </div>
        </div>
        @if(count($data['records'])>0)
                            <?php $k = ($pageNo == 1) ? $pageNo : (($pageNo - 1) * $record_per_page) + 1; ?>
                            @foreach($data['records'] as $row)
        <div class="large-12 forum-topic">
          <div class="large-1 column lpad">
            <i class="fa fa-file"></i>
          </div>
          <div class="large-5 small-8 column lpad">
            <span class="overflow-control">
               <a href="{{route('admin-view-topic',['id'=>$row->id])}}">{{$row->subject}}</a>
            </span>
            <span>by <a href="#">{{$row->first_name}} {{$row->last_name}}</a></span>
          </div>
         <div class="large-1 column lpad">
            <span class="center"><?php echo get_total_reply_by_topicId($row->id); ?></span>
          </div>
          <!-- <div class="large-1 column lpad">
            <span class="center">0</span>
          </div> -->
          <div class="large-5 small-4 column pad">
            <span>
              <a class="tpc-ttl" href="#"><?php 
              
              $resultArr = get_last_post_by_topicId($row->id);


         
            $tempCommentval =  ($resultArr===null)?'':$resultArr->replySubject; 
            if($tempCommentval!=""){
              $tempval = substr($tempCommentval, 0 ,90);
              echo $lastPostText = wordwrap($tempval,60,"<br>\n");
            }
               ?></a>
            </span>
            <span><?php 
            $created_at = ($resultArr===null)?'':$resultArr->post_created_at; 
             if($created_at!=""){
            echo date("F j Y, h:i:s a", strtotime($created_at));   
             }
             ?>
             <?php 
            $first_name = ($resultArr===null)?'':$resultArr->first_name; 
             if($first_name!=""){
              ?>
            by <a href="#">{{$first_name}} {{$resultArr->last_name}}</a>
            <?php } ?>
            </span>
          </div>
        </div>
        <?php $k++; ?>     
                            @endforeach
                            @else
                            <div class="large-12 forum-topic">
                                <div class="large-12 small-4 column pad null-data-hd">
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
    </div>
  </div>
       
      </div>
	 </div>
<script src="{{asset('js/forum.js')}}"></script>
  @endsection