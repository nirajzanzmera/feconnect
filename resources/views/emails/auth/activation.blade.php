@component('mail::message')
# Confirm your Email Address

Thanks for signing up, please confirm your email address.

@component('mail::button', ['url' => route('auth.activate', [
	'token'=>$user->activation_token,
	'email'=>$user->email
])])
	Confirm
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
