@component('mail::message')
# You have been invited to join account : {{$invite->team->name}}.

If you do not already have an user account, you will need to register for one first.  

@component('mail::button', ['url' => route('teams.accept_invite', $invite->accept_token)])
    Accept Invite 
@endcomponent

Thanks, <br />
{{ config('app.name') }}
@endcomponent
