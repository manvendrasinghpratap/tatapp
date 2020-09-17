<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">
    
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                    <form name="modalform" id="modalform" method="post" action="{{route('admin-AccountList')}}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" id="customclose">&times;</button>
                                <h4 class="modal-title">Manage Membership Plan and Extra File Storage </h4>
                            </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible errormsg"></div>
                            <div class="form-group row @if($errors->first('membership_type')) {{' has-error has-feedback'}} @endif ">
                                <label for="inputError" class="col-sm-4 control-label"> Membership Type {{redstar()}}</label>
                                <div class="col-sm-8">
                                    <select name="membership_type" class="form-control membership_type" id="membership_type" required="true">
                                    <option value="">Select</option>
                                    @foreach($memberShipPlan as $key=>$value)
                                    <option data-attr-id = "{{ $value->storage_amount }}" data-attr-membertype-id = "{{ $value->id }}"  @if(@$account_detail->membership_type==$value->membership_name) {{'selected'}} @endif value="{{ $value->membership_name}}">{{ $value->display_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        <div>

                        <div class="form-group row " style="display: none;">
                            <label for="inputError" class="col-sm-5 control-label"> Storage Space {{redstar()}}</label>
                            <div class="col-sm-7">                   
                                <select name="storage_space" class="form-control storage_space" id="storage_space" required="true">
                                <option value="">Select Storage Space</option>
                                @foreach($memberShipPlan as $key=>$value)
                                <option @if(!empty(@$account_detail) && (@$account_detail->accountStorageSize->space_size ==$value->storage_amount)) {{'selected'}} @endif value="{{ $value->storage_amount}}">{{ $value->storage_amount_display}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                
                        <div class="form-group row ">
                        <label for="inputError" class="col-sm-4 control-label"> Extra Storage Space </label>
                        <div class="col-sm-8">               
                        <select name="extra_storage_space" class="form-control extra_storage_space" id="extra_storage_space">                  
                         <option value="0">Select Extra Storage Space</option>
                        @foreach($extraSpace as $key=>$value)
                        <option @if(!empty(@$account_detail) && ( (@$account_detail->accountStorageSize->space_size - @$account_detail->membershiptype->storage_amount ) == $key)) {{'selected'}} @endif value="{{$key}}">{{ $value}}</option>
                        @endforeach
                        </select>
                        </div>
                        </div>
                            </div>
                        </div>             
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="saveTask">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="hidden"  name ="accountId" id="accountId" value="{{@$account_detail->id}}" />
                            <input type="hidden" value="" name="totalspace" id="totalspace" /> 
                        </div>
                    </form> 
            </div>
        </div>
    </div>
<script type="text/javascript">
 $(document).ready(function () { 
    $('.errormsg').hide();
    $('#saveTask').on('click', function(){
       var membershipType   = $("#membership_type option:selected" ).val();
       var storage_space   = $("#storage_space option:selected" ).val();
       var membershipId     = $("#membership_type option:selected" ).attr("data-attr-membertype-id");
       var accountId  = $('#accountId').val();
       var totalspace  = $('#totalspace').val();
        var save = 1;
         if( (membershipType != '')  && (membershipId != '') && (accountId != '') &&  (totalspace != '' && storage_space !='')  ){  
            $.ajax({
                    type: "get",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route("admin-ajax-edit-account",10)}}',
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    accountId:accountId,save:save,membershipId:membershipId,membershipType:membershipType,totalspace:totalspace, 
                    },
                    success: function (data) {   
                    location.reload();
                       }
                    }); 
        }else{

            $('.errormsg').text('Please Select Membership Plan and Storage Space');
            $('.errormsg').show();
        }
    });
});


$( ".membership_type" ).change(function(e) {
var storageAmount = $("#membership_type option:selected" ).attr("data-attr-id");
var membertypeId = $("#membership_type option:selected" ).attr("data-attr-membertype-id");
$('#membertypeId').val(membertypeId);
$(".storage_space").val(storageAmount);
toGetTotalSpace();
}).change();
$( ".extra_storage_space" ).change(function(e) {
    toGetTotalSpace();
});

function toGetTotalSpace(){
var storageSpace        = $("#storage_space option:selected" ).val();
var extraSpace          = $("#extra_storage_space option:selected" ).val();
var totalSpace          =  Number(extraSpace) + Number(storageSpace);
$('#totalspace').val(totalSpace);
}
</script>
<!--   New Block -->

   
