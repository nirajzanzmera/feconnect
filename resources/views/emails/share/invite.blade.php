@component('mail::message')
# {{ $invite->inviter->name }} wants to share an Email with you.

![Email][thumb]
[thumb]: {{ $invite->campaign->thumburl }} "Email"

Click the button below to get access.

If you didn't request this email, please disregard. 

@component('mail::button', ['url' => route('campaigns.invite.confirm', [
    'token'=>$invite->token
])])
    Confirm 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
