@component('mail::message')
<p>
    {!! nl2br($data['msg']) !!} 
</p>
@component('mail::button', ['url' => route('plans.card')])
	Update Card
@endcomponent
<table cellpadding="10" cellspacing="0" width="100%">
    <tr align="center" style="text-align:center; ">
        <td>Manage Notification <a href="{{ route('user.profile') }}">Settings</a></td>
    </tr>
</table>
@endcomponent 