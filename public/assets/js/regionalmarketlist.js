
    function ajaxLoadRegional(filename, content) {
      
        content = typeof content !== 'undefined' ? content : 'content';
        if(content=='content'){
            filename=filename;
            content="";
        }
        else{
            filename=filename;
        }
        $.ajax({
            type: "POST",
            url: filename,
            data : {
                range : content ,
                mstate_id:$("#rid").val()
            },
            success: function (data) {
               console.log(data);
                $("#content").html(data);
            },
            error: function (xhr, status, error) {
             //   alert(xhr.responseText);
            }
        });
    }
    function ajaxSortbyname(filename, content) {
        content = typeof content !== 'undefined' ? content : 'content';
        console.log(content);
        if(content=='content'){
            filename=filename;
        }
        else{
            filename=filename+'/'+content;
        }
        $.ajax({
            type: "GET",
            url: filename,
            contentType: false,
            success: function (data) {
                $("#content").html("");
                $("#content").html(data);
            },
            error: function (xhr, status, error) {
               // alert(xhr.responseText);
            }
        });
    }
    // $(document).ready(function () {
    //     getdata('../market/detailregional');
    // });
    function sortregional(id){
        
        ajaxLoadRegional('../market/regionallist',id);
    }
    function sortbyname(){
        $("#marketplace").val();
        ajaxSortbyname('market/listbyname',$("#marketplace").val());
    }
    function getdetailregional(id){
        getdata('../market/detailregional',id);
    }
    function getdata(filename, content){
    
        content = typeof content !== 'undefined' ? content : 'content';
        id=$("#rid").val();
        if(content=='content'){
            filename=filename;
            content="asc";
        }
        else{
            filename=filename;
        }
        $.ajax({
            type: "POST",
            url: filename,
            data : {
                date : content, // will be accessible in $_POST['data1'],
                id:id
            },
            success: function (data) {
                $("#contentdetailregional").html(data); 
            },
            error: function (xhr, status, error) {
                // alert(xhr.responseText);
            }
        });
    }


