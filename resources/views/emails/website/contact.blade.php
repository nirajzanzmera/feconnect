@component('mail::message')
<h1 style="width:100%; text-align:center; padding-top:25px;">
    Contact Form on {{ $data->display }}
</h1>
<h3 style="width:100%; text-align:center; padding-bottom:25px;">
   {{ $data->date }}
</h3>

<p>
    <em>
        Website {{ $data->display }} contact form submission. This is a submission to your contact form on your website submitted by a visitor.
        Please be sure you trust this individual before going to any links provided or providing this person any personal
        information.
    </em>
</p>

@component('mail::panel', [
    'head' => "Message"
])
<p>
    <span id="message">
        <strong>Name:</strong> {{ $data->name }} <br />
        <strong>Email:</strong> {{ $data->email }} <br />
        <strong>Phone:</strong> {{ $data->phone }} <br />
        <strong>Subject:</strong> {{ $data->subject }} <br />
        <strong>Message:</strong> {{ $data->message }} <br />
    </span>
</p>
@endcomponent

<table cellpadding="10" cellspacing="0" width="100%">
    <tr align="center" style="text-align:center; ">
        <td>Manage Notification <a href="{{ route('user.profile') }}">Settings</a></td>
    </tr>
</table>
@endcomponent
