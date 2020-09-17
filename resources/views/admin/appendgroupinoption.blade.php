@if(!empty($groupsListAssignedToAccount))
<option value="">Select Group</option>
@foreach($groupsListAssignedToAccount as $accountList)
    @foreach($accountList->accountGroups as $groups)
    <option @if(in_array($groups->group->id,$existingUserGroupArray)) {{ 'selected'}} @endif value="{{ $groups->group->id}}">  {{ $groups->group->name}} </option>
    @endforeach
@endforeach
@endif