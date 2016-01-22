Hi,<br>
<br>
New message from {{$user->username}} ({{$user->email}}):<br>
<br>

@if ($type == 'user_cheating')
    User {{$user_bad->username}} ({{$user_bad->email}}) are cheating.
@elseif ($type == 'user_conduct')
    User {{$user_bad->username}} ({{$user_bad->email}}) are conduct.
@elseif ($type == 'ride_cheating')
    User {{$user_bad->username}} ({{$user_bad->email}}) are cheating in ride {{$ride->name}} (id {{$ride->id}}).
@elseif ($type == 'ride_data')
    User {{$user_bad->username}} ({{$user_bad->email}}) are send inaccurate data in ride {{$ride->name}} (id {{$ride->id}}).
@endif
