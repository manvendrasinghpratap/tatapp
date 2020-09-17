@extends('layout.backened.header')
@section('content')
<?php 

//$data = Session::all();
//dd($data); ?>
<link rel="stylesheet" href="{{asset('css/forum.css')}}">
  <div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>Forums</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Forums</li>
      </ol>
    </section>
     


    <section class="content forum-ovt">
      <!-- Trigger the modal with a button -->
        <button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display:none;">Open Modal</button>
        
      <div id="forumListResp">
    
      </div>
          <div class="row">
             <input type="hidden" name="case_id" id="modalCaseId" value="<?php echo $data['case_id']; ?>">
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

                        <form id="forum-list" method="get" action="{{route('admin-manage-forum')}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control" name="keyword" value="{{old('keyword',$request->keyword)}}" placeholder="{{_i('Keyword')}}" type="text">
                                        </div>
                                    </div>
                                </div> 
                                

                                  


                                <div class="col-sm-5">
                                    <button type="submit" class="btn btn-primary btn-info">{{_i('Search')}}<div></div></button>
                                    <a href="{{route('admin-forum-list',['id'=>$data['case_id']])}}" class="btn btn-primary btn-success">{{_i('Reset')}}</a>
                                </div>
                                <?php 
            $allowRolesList = array("agencySuperAdmin", "agencyAdmin", "agencyUser");
            $user_role_name = Session::get('user_role_name');
            if (in_array($user_role_name, $allowRolesList))
            {
            ?>
            <!-- <div class="col-sm-2 pull-right">
                                        <a id="createForum" data-link1="{{route('admin-ajaxGetForumDetails')}}" class="btn btn-block btn-warning">Create forum</a>
            </div> -->
            <?php } ?>
                                    
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


     <div class="row mt mb" id="ajaxresp">
    <div class="large-12">
      <!--div class="large-12 forum-category rounded top">
        <div class="large-8 small-10 column lpad">
          Some category title
        </div>
       
      </div-->
      
      <div class="toggleview">
        <div class="large-12 forum-head">
          <div class="large-6 small-8 column lpad">      
           Forum
          </div>
          <div class="large-1 column lpad">
            Topics
          </div>
          <div class="large-1 column lpad">
            Posts
          </div>
          <div class="large-4 small-4 column lpad">
            Last post
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
              <a href="{{route('admin-topic-list',['id'=>$row->id])}}">{{$row->title}}</a>
            </span>
            <span class="overflow-control">
              {{$row->description}}
            </span>
          </div>
          <div class="large-1 column lpad">
            <span class="center"><?php echo get_total_topic_by_forumId($row->id); ?></span>
          </div>
          <div class="large-1 column lpad">
            <span class="center"><?php 
            $resultArr = get_total_post_by_topicId($row->id);
            echo $resultArr['total_post'];
            

             ?></span>
          </div>
          <div class="large-4 small-4 column pad">
            <span>
              <a class="tpc-ttl" href="#"><?php 

           

           
            $tempCommentval = ($resultArr['last_post_array']===null)?'':$resultArr['last_post_array']->replySubject; 

            if($tempCommentval!=""){
              $tempval = substr($tempCommentval, 0 ,80);
              echo $lastPostText = wordwrap($tempval,50,"<br>\n");
            }

               ?></a>
            </span>
            <span><?php 
            $post_created_at = ($resultArr['last_post_array']===null)?'':$resultArr['last_post_array']->post_created_at; 
             if($post_created_at!=""){
            echo date("F j Y, h:i:s a", strtotime($post_created_at));   
             }
             ?>
             <?php 
            $first_name = ($resultArr['last_post_array']===null)?'':$resultArr['last_post_array']->first_name; 
             if($first_name!=""){
              ?>
            by <a href="#">{{$first_name}} {{$resultArr['last_post_array']->last_name}}</a>
            <?php } ?>
            </span>
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
    </div>
  </div>
       </div>   
      </div>
<script src="{{asset('js/forum.js')}}"></script>
  @endsection