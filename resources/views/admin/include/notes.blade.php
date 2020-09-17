<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<style>
.draggable {
  cursor: move; /* fallback if grab cursor is unsupported */
  cursor: grab;
  cursor: -moz-grab;
  cursor: -webkit-grab;
}

/* (Optional) Apply a "closed-hand" cursor during drag operation. --color-stop-1: #a770ef;  --color-stop-3: #fdb99b;  --color-stop-2: #cf8bf3;*/
.draggable:active { 
  cursor: grabbing;
  cursor: -moz-grabbing;
  cursor: -webkit-grabbing;
}
#gradient-horizontal {
 --color-stop-1: #aba3b3;
 --color-stop-2: #d9d4de;
 --color-stop-3: #5c5861;
 
}
#note_add{
  padding:10px;background-color: #f4f7fb;width:100%;float:left;
}
.note_add_button{
  width:6%;float:left;
}
.note_add_button button{
  width:100%;vertical-align:middle;height:41px;
}
.note_add_input_content{
  width:90%;float:left;margin-right:2%;
}
.note_add_input_content .error{
  margin-top:5px;padding-left:10px;
}
.note_add_input{
  width:100%;height:41px;padding:10px;vertical-align:middle;
}
.note_add_content{
  width:100%;float:left;
}
.note_add_message_previous{
  width:100%;float:left;background-color: #f4f7fb;
}
.note_add_message{
  margin:10px;width:99%;float:left;border-bottom:1px solid #eee;
}
.note_add_message_previous_content{
  margin:10px;float:left;width: 96%;
}
.note_add_img{
  float:left;
}
.note_add_img img{
  width:30px;height:30px;border-radius:15px;
}
.note_add_message_text_content{
  color:#999;
}
.note_add_message_content{
  height:250px;
  overflow: hidden;
}
.note_add_message_text{
  float:left;padding-left:10px;font-weight:normal;width:80%;
}
.note_add_case_account{
  font-weight:normal;font-size:11px
}
.note_add_note_add{
  padding-left:10px;font-weight:normal;font-size:11px
}
.note_add_previous{
  width:128px;float:left;font-size:11px
}
.note_add_out{
  float:right;font-weight:normal;font-size:11px
}
#gradient-vertical {
  --color-stop-1: #00c3ff;
  --color-stop-2: #77e190;
  --color-stop-3: #ffff1c;
}
/*g.highcharts-yaxis-grid path {
   fill: url(#gradient-horizontal);
    stroke: darkgray;
}
g.highcharts-xaxis-grid path{
	 fill: url(#gradient-vertical);
    stroke: darkgray;
    }*/
    .profile-image-buttons{
      width:50%;float:left;
      margin-top:5px;
    }
    figcaption{
      width:100%;float:left;margin:4px 0;
    }
    .profile-image-inner-button{
      width:48%;float:left;
    }
    .profile-image-inner-button-right{
      width:48%;float:right;
      margin-top:0px;
    }
    @media (max-width: 768px) {
      .note_add_message_previous{
        width:100%;
      }
      .note_add_button{
        width:14%
      }
      .note_add_input_content{
        width:80%;
        padding-left: 1px;
      }
      .profile-image-inner-button,.profile-image-inner-button-right{
        width:100%;float:left
      }
      .profile-image-inner-button-right{
        margin-top:5px;
      }
      .profile-image-buttons{
        width:100%;float:left;
        margin-top:5px;
      }
    }
  </style>
<div class="panel panel-default">
    <div class="panel-heading">Notes</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12" id="ajaxresp">
                <div class="table-responsive">
                    <!--<div id="note_add">
                      <form action="javascript:void(0);" method="post" id="add_note_frm">
                          <div class="note_add_input_content">
                            <input type="text" placeholder="Add Note" name="add_note" class="note_add_input">
                            <input type="hidden" name="case_id" value="<?php echo $data['caseList']->id; ?>">
                          </div>
                          <div class="note_add_button">
                            <button type="submit" class="btn btn-info btn-xs action-btn">Add</button>
                          </div>
                      </form>
                    </div>-->
                    @if(count($data['add_note'])>0)
                    <div class="note_add_content"> 
                        <div class="note_add_message_content">  
                          @foreach($data['add_note'] as $row)  
                          <div class="note_add_message"> 
                            <div class="note_add_img">
                              @if(@$data['caseList']->default_pic!='')
                              <img src="{{get_image_url(@$data['caseList']->default_pic,'package')}}" >
                              @else
                              <img src="{{asset('images/gravitor.jpg')}}" alt="gravitor">
                              @endif
                            </div>
                            <div class="note_add_message_text"><div style=""><?php echo $row->add_note; ?></div>
                            <div class="note_add_message_text_content"><span class="note_add_case_account">Case Account: <?php echo $data['caseList']->title; ?></span><span class="note_add_note_add">Add Note.</span><span class="note_add_note_add">time: <?php if(!empty($row->modified_time)){echo date("d M, Y",strtotime($row->modified_time));} ?></span><span class="note_add_note_add">by <a href="#"><?php echo $data['userList'][0]->first_name; ?> <?php echo $data['userList'][0]->last_name; ?></a> </span></div></div></div>					
                            @endforeach
                      </div>
                    <div class="note_add_message_previous"> 
                      <div class="note_add_message_previous_content">
                          <div class="note_add_previous">
                            <a href="javascript:void(0);" id="view_previous_add_note">View previous Note</a> 
                            <a href="javascript:void(0);" id="view_previous_add_note_show" style="display:none;">Hide previous Note</a>
                          </div>
                         <?php $rowscnt=count($data['add_note']);?>
                          <div class="note_add_out">2 out of <?php echo $rowscnt;?></div>
                        </div>
                      </div>
                    </div>
              @else
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>

<script> 
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
  return false;
}
/* New code By Subhendu 15-05-2018 */
$(document).ready(function(){


  $('#view_previous_add_note').click(function(){

   $('.note_add_message_content').css('overflow','auto');
   $('#view_previous_add_note').hide();
   $('#view_previous_add_note_show').show();
 });
  $('#view_previous_add_note_show').click(function(){

   $('.note_add_message_content').css('overflow','hidden');
   $('#view_previous_add_note').show();
   $('#view_previous_add_note_show').hide();
 });


});
</script>