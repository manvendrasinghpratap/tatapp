<center style="background-color:#D3D3D3; height: 50px;"><p style=" padding-top: 14px;">{{ @$data['targetinsertOrUpdate']  }} </p></center>


<table class="table-bordered" nobr="true" >
    @if(!empty($data['targetDetails']->name))
    <tr>
        <td class="left">Name:</td>
        <td class="right"> {{ucfirst(@$data['targetDetails']->name)}}</td>
    </tr>
	@endif 
	@if(!empty($data['targetDetails']->phone_number))
	<tr>
		<td class="left">Phone number:</td>
		<td class="right"> {{@$data['targetDetails']->phone_number}}</td>
	</tr> @endif										
    @if(!empty($data['targetDetails']->cell_phone))
    <tr>
        <td class="left">Cell phone:</td>
        <td class="right">{{@$data['targetDetails']->cell_phone}} </td>
    </tr> @endif
    @if(!empty($data['targetDetails']->address))
    <tr>
        <td class="left">Address:</td>
        <td class="right"> {{@$data['targetDetails']->address}}</td>
    </tr>@endif
    @if(!empty($data['targetDetails']->city))
    <tr>
        <td class="left">City:</td>
        <td class="right"> {{@$data['targetDetails']->city}}</td>
    </tr>@endif
    @if(!empty($data['targetDetails']->state))
    <tr>
        <td class="left">State:</td>
        <td class="right"> {{@$data['targetDetails']->state}}</td>
    </tr>@endif
    @if(!empty($data['targetDetails']->zip_code))
    <tr>
        <td class="left">Zip code:</td>
        <td class="right"> {{@$data['targetDetails']->zip_code}}</td>
    </tr>@endif
    @if(!empty($data['targetDetails']->email))
    <tr>
        <td class="left">Email addresses:</td>
        <td class="right"> {{@$data['targetDetails']->email}}</td>
    </tr>@endif
    <tr>
        <td class="left">Created Date:</td>
        <td class="right"> {{@$data['targetDetails']->created_at->format('d-m-Y H:i:s')}}</td>
    </tr>
</table>
