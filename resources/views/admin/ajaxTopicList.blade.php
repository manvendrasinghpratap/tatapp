<div class="large-12">
      <div class="large-12 ttl-in">
        <div class="large-8 small-10 column lpad">
          {{$data['forumDetails']->title}}
        </div>
       
      </div>
      
      <div class="toggleview">
        <div class="large-12 forum-head">
          <div class="large-8 small-8 column lpad">
            TOPICS
          </div>
          <div class="large-1 column lpad">
            REPLIES
          </div>
         <!--  <div class="large-1 column lpad">
            VIEWS
          </div> -->
          <div class="large-3 small-4 column lpad">
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
          <div class="large-7 small-8 column lpad">
            <span class="overflow-control">
              <a href="{{route('admin-view-topic',['id'=>$row->id])}}">{{$row->subject}}</a>
            </span>
            
          </div>
           <div class="large-1 column lpad">
            <span class="center"><?php echo get_total_reply_by_topicId($row->id); ?></span>
          </div>
          <!-- <div class="large-1 column lpad">
            <span class="center">0</span>
          </div> -->
          <div class="large-3 small-4 column pad">
            <span>
              <a class="tpc-ttl" href="#"><?php 
              
              $resultArr = get_last_post_by_topicId($row->id);
            echo ($resultArr===null)?'':$resultArr->replySubject; 
               ?></a>
            </span>
            <span><?php 
            $created_at = ($resultArr===null)?'':$resultArr->created_at; 
             if($created_at!=""){
            echo date("F j Y, h:i:s a", strtotime($created_at));   
             }
             ?></span>
            <span>by <a href="#">{{$row->first_name}} {{$row->last_name}}</a></span>
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