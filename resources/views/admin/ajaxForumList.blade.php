<div class="large-12">
      <div class="large-12 ttl-in">
        <div class="large-8 small-10 column lpad">
          Some category title
        </div>
       
      </div>
      
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
            echo ($resultArr['last_post_array']===null)?'':$resultArr['last_post_array']->replySubject; 
               ?></a>
            </span>
            <span><?php 
            $post_created_at = ($resultArr['last_post_array']===null)?'':$resultArr['last_post_array']->post_created_at; 
             if($post_created_at!=""){
            echo date("F j Y, h:i:s a", strtotime($post_created_at));   
             }
             ?></span>
             <?php 
            $first_name = ($resultArr['last_post_array']===null)?'':$resultArr['last_post_array']->first_name; 
             if($first_name!=""){
              ?>
            <span>by <a href="#">{{$first_name}} {{$resultArr['last_post_array']->last_name}}</a></span>
            <?php } ?>
            
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