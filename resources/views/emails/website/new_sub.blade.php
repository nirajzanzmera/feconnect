@component('mail::message')

Hi {{ $user->name }}, 
<br /><br />
Congratulations, a new email has subscribed to your {{ $list->name }} list.<br />

To get started using your list you can log in to your account <a href="{{ route('login') }}">here</a>.
@if (!empty($subscriber->id))
You can manage this new subscriber <a href="{{ route('lists.subscribers.manage', ['subscriber' => $subscriber->id]) }}">here</a>.
@endif
<br /><br />
If you have any questions, please <a href="https://dataczar.com/contact_us.html">contact us</a> on our website or at 
(844) 855-2927.
<br /><br />
Thanks for choosing Dataczar!<br />
Dataczar Team<br />
www.dataczar.com<br />
<br /><br />
<small>
----------------------------------<br />
<a href="https://dataczar.com/terms_and_conditions.html">Dataczar Universal Terms of Service Agreement</a> 
for more details. For any questions call Customer Service at +1 (442) 216-0291
<br /><br />
----------------------------------<br />
<br />
This message was sent to {{ $account->owner->email }}, as a Dataczar customer, consistent with your email preferences.
<br />
Click here to <a href="{{ route('user.profile') }}">manage your email settings.</a>
</small>   

@endcomponent