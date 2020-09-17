@if(!empty($users))
@foreach($users as $userData)
<option @if(in_array($userData->id, $userIds) ) {{'selected'}} @endif value="{{$userData->id}}">{{ $userData->first_name }} {{ $userData->last_name }}</option>
@endforeach
@endif