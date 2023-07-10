@component('mail::message')
<h1 style="width:100%; text-align:center; padding-top:25px;">
    SMS Received from: {{ $data->from ??'' }}
</h1>
<h3 style="width:100%; text-align:center; padding-bottom:25px;">
   {{ $data->date ?? '' }}
</h3>
@component('mail::panel', [
    'head' => "Message"
])
<p>
    <strong>Body:</strong> {{ $data->body ?? ''}}<br />
    @if(!empty($user)) 
    <hr>
    <strong>Name</strong> {{ $user->name ?? '' }}<br />
    <strong>Email</strong> {{ $user->email ?? '' }}<br />
    <strong>Phone</strong> {{ $user->phone ?? '' }}<br />
    <a href="{{ route('admin.users.manage', $user) }}">Manage User</a>
    @endif
</p>
@endcomponent

