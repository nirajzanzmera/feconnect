@component('mail::message')
# Account created!

Thanks for signing up, please login and change your password.

**Your Temp Password:** {{ $tmp_pass }}

@component('mail::button', ['url' => route('auth.activate', [
	'token'=>$user->activation_token,
	'email'=>$user->email
])])
	Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
