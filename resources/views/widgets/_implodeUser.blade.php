@php
$users = [];
@endphp
@foreach ($models as $user)
    @php
        $users[] = '<a href="'.route('users.show', ['id' => $user->user_id]).'">'.$user->user->name.'</a>';
    @endphp
@endforeach
{!! implode(', ', $users) !!}