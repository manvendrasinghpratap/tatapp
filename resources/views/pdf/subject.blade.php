<center style="background-color:#D3D3D3; height: 50px;"><p style=" padding-top: 14px;">{{ @$data['subjectinsertOrUpdate']  }}</p></center>


<table class="table-bordered" nobr="true" >
    @if(!empty($data['subjectDetails']->name))
    <tr>
        <td class="left">Name:</td>
        <td class="right"> {{ucfirst(@$data['subjectDetails']->name)}}</td>
    </tr>
	@endif 
	@if(!empty($data['subjectDetails']->phone_number))
	<tr>
		<td class="left">Phone number:</td>
		<td class="right"> {{@$data['subjectDetails']->phone_number}}</td>
	</tr> @endif										
    @if(!empty($data['subjectDetails']->cell_phone))
    <tr>
        <td class="left">Cell phone:</td>
        <td class="right">{{@$data['subjectDetails']->cell_phone}} </td>
    </tr> @endif
    @if(!empty($data['subjectDetails']->address))
    <tr>
        <td class="left">Address:</td>
        <td class="right"> {{@$data['subjectDetails']->address}}</td>
    </tr>@endif
    @if(!empty($data['subjectDetails']->city))
    <tr>
        <td class="left">City:</td>
        <td class="right"> {{@$data['subjectDetails']->city}}</td>
    </tr>@endif
    @if(!empty($data['subjectDetails']->state))
    <tr>
        <td class="left">State:</td>
        <td class="right"> {{@$data['subjectDetails']->state}}</td>
    </tr>@endif
    @if(!empty($data['subjectDetails']->zip_code))
    <tr>
        <td class="left">Zip code:</td>
        <td class="right"> {{@$data['subjectDetails']->zip_code}}</td>
    </tr>@endif
    @if(!empty($data['subjectDetails']->email))
    <tr>
        <td class="left">Email addresses:</td>
        <td class="right"> {{@$data['subjectDetails']->email}}</td>
    </tr>@endif
    <tr>
        <td class="left">Created Date:</td>
        <td class="right"> {{@$data['subjectDetails']->created_at->format('d-m-Y H:i:s')}}</td>
    </tr>
</table>
