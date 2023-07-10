@component('mail::message')
# In order to send emails using the Dataczar Connect email platform, you must confirm you own or control this email address.  

Please confirm you own this address and that you requested this confirmation email by clicking the Confirm button below. 

If you didn't request this email, please disregard. 

@component('mail::button', ['url' => route('senders.confirm', [
	'token'=>$sender->token,
	'email'=>$sender->email
])])
	Confirm 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
