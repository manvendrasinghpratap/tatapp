    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{asset('css_new/style.css')}}">
    <link rel="stylesheet" href="{{asset('css_new/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/popupModal.css')}}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('/plugins/timepicker/bootstrap-datetimepicker.min.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script> 
    <script src="{{asset('/plugins/timepicker/bootstrap-datetimepicker.js')}}"></script>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css_new/sidebar.css')}}">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>  
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" ></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></button>
    <div id="sectorDetails"></div>
    <div class="clearfix"></div>
   
    <?php foreach($data['casecorkboard'] as $row) { $img = 'health_icon.png';
    if($row->chart_icon == 'health_icon'){
        $img = 'health_icon.png';
    }elseif($row->chart_icon == 'social_media_icon'){
        $img = 'social_media_icon.png';
    }elseif($row->chart_icon == 'criminal_history_icon'){
        $img = 'criminal_history_icon.png';        
    }elseif($row->chart_icon == 'pdf_icon'){
        $img = 'pdf_icon.png';
    }elseif($row->chart_icon == 'interview_icon'){
        $img = 'interview_icon.png';
    }elseif($row->chart_icon == 'weapon_icon'){
        $img = 'weapon_icon.png';
    }elseif($row->chart_icon == 'incident_report_icon'){
        $img = 'incident_report_icon.png';
    }
    ?>
        <style>
        #box<?php echo $row->id;?> {
        position: absolute;
        top: <?php echo $row->top;?>;
        left: <?php echo $row->lefts;?>;
        width: 50px;
        height: 50px;
        background-image: url('{{ asset("images/$img")}}');
        cursor: move;
    }
        </style>
            <?php } ?>
    <style>
    #canvas {
        width: 90%;
        height: 90%;
        background: #ccc;
        position: relative;
        margin: 2em auto;
    }
    .modal-backdrop{
    }
    button.close {
    padding: 0;
    border: 0;
    -webkit-appearance: none;
    padding: 1rem;
    margin: -1rem -1rem -1rem auto;
    cursor: pointer;
}
    #results {
        text-align: center;
    }
    button.close{background-color: black !important;}
    </style>
    <script>
    var coordinates = function(element,id) {
        element = $(element);
        var top = element.position().top;
        var left = element.position().left;
        var factorListId = id;
        $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                 url: "{{route('admin-updatecoordinate')}}",
                dataType: 'html',
                data: {// change data to this object
                token : $('meta[name="csrf-token"]').attr('content'), 
                factorListId:factorListId,
                top:top,
                left:left,                
                },
                
                success: function (data) { 
                
                
                }
            });
        console.log(id);
        $('#results').text('X: ' + left + ' ' + 'Y: ' + top);
    }
    </script>
    <?php foreach($data['casecorkboard'] as $row) { ?>
    <script>
    $(document).ready(function(draggable) {
    
        $('#box<?php echo $row->id;?>').draggable({
        start: function() {
            coordinates('#box<?php echo $row->id;?>',<?php echo $row->id;?>);
        },
        stop: function() {
            coordinates('#box<?php echo $row->id;?>',<?php echo $row->id;?>);
        }
        });
    });
    $( '#box<?php echo $row->id;?>' ).dblclick(function() {
  alert( "Handler for .dblclick() called." );
});
    </script>
    
    <?php } ?>      

    <script>
        $(document).ready(function() {
        $( ".close" ).click(function() {
            window.location.href = "{{ route('admin-caseList')}}";
        //alert( "Handler for .click() called." );
        });
        
        });

        function open_factor_modal(factor_id, case_id){
                $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('admin-ajaxGetFactorDetailscorkboard')}}",
                dataType: 'html',
                                data: {// change data to this object
                                token : $('meta[name="csrf-token"]').attr('content'), 
                                factor_id:factor_id,case_id:case_id 
                                },
                                success: function (data) {

                                $('#sectorDetails').html(data);
                                $('#modalBt').trigger('click');
                                e.preventDefault();
                                e.stopPropagation();
                                return false;
                                // editSectorDetails(factor_id);

                                }
                            });

}
    </script>
    <div id="canvas">
    <div style="float: right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button></div>
        <?php foreach($data['casecorkboard'] as $row) { ?>
            <?php $title = ' Description : '. $row->description;?>
    <div id="box<?php echo $row->id;?>"><a  title ="<?php echo $title;?>" style="padding: 2px 40px 31px 12px;" href="javascript:open_factor_modal(<?php echo $row->id; ?>, <?php echo $row->case_id; ?>);"> </a></div>
        <?php } ?>
        
    </div>
    
    <style>
.error{
  color:red;
}
</style>



