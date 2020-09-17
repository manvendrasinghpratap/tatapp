<?php
$file_id = isset($data['fileDetailsArray']->id)?$data['fileDetailsArray']->id:'';
$title = isset($data['fileDetailsArray']->title)?$data['fileDetailsArray']->title:'';
$description = isset($data['fileDetailsArray']->description)?$data['fileDetailsArray']->description:'';
$profile_pic = isset($data['fileDetailsArray']->profile_pic)?$data['fileDetailsArray']->profile_pic:'';
?>
<div class="row">
    <div class="col-sm-12">
        <input type="hidden" name="token" id="token" value="">
        <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
        <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
        <input type="hidden" name="case_id" value="<?php echo $data['caseList']->id; ?>">
        <input type="hidden" name="file_id" id="file_id" value="<?php echo $file_id; ?>"  class="subjectClass" value="">
        <br/>
         @if(@$profile_pic!='')
            <div class="row">
                    <div class="col-sm-8">
                        <?php
                        $path = get_image_url($profile_pic,'files');
                        $ext = pathinfo($path, PATHINFO_EXTENSION); 
                        $extensionsArray = array('jpg', 'JPG', 'png' ,'PNG' ,'jpeg' ,'JPEG');
                        if (in_array($ext, $extensionsArray))
                        {?>
                        <img src="{{get_image_url(@$profile_pic,'files')}}" style="width:100px;height:100px">
                        <?php
                        }
                        else
                        { ?>
                        <a href="{{get_image_url(@$profile_pic,'files')}}">{{$profile_pic}}</a>
                        <?php }  ?>
                 </div>
            </div>
        @else
        <div class="row">
                <div class="col-sm-4">File:</div>
                <div class="col-sm-4"> <input type="file" id="profile_pic"  name="profile_pic" data-buttonName="btn-primary">
                </div>
        </div>
        <br/>
        @endif
        <div class="row">
                <div class="col-sm-4">Title:</div>
                <div class="col-sm-4">  <input type="text" id="title" name="title" value="<?php echo $title; ?>" placeholder="Title" style="border:1px solid black;"/>
                </div>
        </div>
        <br/>
        <div class="row">
                <div class="col-sm-4">Description:</div>
                <div class="col-sm-4">  <input type="text" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>"  style="border:1px solid black;"/>
                </div>
        </div>
        <br/> <br/>
        <div class="row">
            <div class="col-sm-4">
                <button type="button" class="btn btn-danger" id="displayAddBox3">Cancel</button>
            </div>
            <div class="col-sm-4"> 

                 <button type="button" class="btn btn-primary" id="saveFile">Save changes</button>
            </div>
        </div>
    </div> 
</div>
<script type="text/javascript">
   $( document ).ready(function() {
    $('#saveFile').on('click', function(){
        $('#modalform').submit();
    });
    $('#displayAddBox3').on('click', function(){
        $('#addDiv').hide('slow');
        $('#addFilebtn').show('slow');
		$('.sectortbl111').show('slow');
    });    
 });
</script>         