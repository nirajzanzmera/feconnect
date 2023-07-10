@component('mail::message')
<h1 style="width:100%; text-align:center; padding-top:25px;">
    Suspicious Account Frozen
</h1>
<p>
    The account <strong>{{ $team->name }}</strong> was frozen automatically due to suspicious credit card activity.
    Please contact the owner of the account and complete the Frozen Account checklist.
</p>
<table cellpadding="10" cellspacing="0" width="100%">
    <tr align="center" style="text-align:center; ">
        <td>
            <a href="{{ route('admin.account.manage', $team) }}">Manage Account</a>
        </td>
    </tr>
</table>
@endcomponent