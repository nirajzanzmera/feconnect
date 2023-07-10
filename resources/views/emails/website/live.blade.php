@component('mail::message')
<h1 style="width:100%; text-align:center; padding-top:25px;">
    {{ $domain->domain }} is now live.
</h1>
<table cellpadding="10" cellspacing="0" width="100%">
    <tr align="center" style="text-align:center; ">
        <td>Manage Notification <a href="{{ route('user.profile') }}">Settings</a></td>
    </tr>
</table>
@endcomponent
