    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>  
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" ></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php foreach($data['incident_record'] as $row) { ?>
        <style>
        #box<?php echo $row->id;?> {
        position: absolute;
        top: <?php echo $row->top;?>;
        left: <?php echo $row->lefts;?>;
        width: 100px;
        height: 60px;
        background: green;
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
    </style>
    <script>
    var coordinates = function(element,id) {
        element = $(element);
        var top = element.position().top;
        var left = element.position().left;
        var incident_id = id;
        $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                 url: "{{route('admin-updatecoordinate')}}",
                dataType: 'html',
                data: {// change data to this object
                token : $('meta[name="csrf-token"]').attr('content'), 
                incident_id:incident_id,
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
    <?php foreach($data['incident_record'] as $row) { ?>
    <script>
    $(document).ready(function(draggable) {
    
        $('#box'+<?php echo $row->id;?>).draggable({
        start: function() {
            coordinates('#box'+<?php echo $row->id;?>,<?php echo $row->id;?>);
        },
        stop: function() {
            coordinates('#box'+<?php echo $row->id;?>,<?php echo $row->id;?>);
        }
        });
    });

    $(document).ready(function() {
        $( ".close" ).click(function() {
            window.location.href = "{{ route('admin-dashboard')}}";
        //alert( "Handler for .click() called." );
        });
        });
    </script>
    
    <?php } ?>      
    
    <div id="canvas">
    <div style="float: right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button></div>
        <?php foreach($data['incident_record'] as $row) { ?>
    <div id="box<?php echo $row->id;?>"><?php echo $row->title;?></div>
        <?php } ?>
        
    </div>
    
 
