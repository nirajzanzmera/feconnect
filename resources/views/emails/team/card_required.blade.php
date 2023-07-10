@component('mail::message')
<h1 style="width:100%; text-align:center; padding-top:25px;">
    Domain Pricing Plan requires card on file
</h1>
<p>
    The account <strong>{{ $team->name }}</strong> downgraded their plan without a card on file.
    The system was unable to convert the domain to a paid annual subscription.
    Repair required.
</p>
<table cellpadding="10" cellspacing="0" width="100%">
    <tr align="center" style="text-align:center; ">
        <td>
            <a href="{{ route('admin.account.manage', $team) }}">Manage Account</a>
        </td>
    </tr>
</table>
@endcomponent