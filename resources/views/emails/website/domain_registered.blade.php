@component('mail::message')

Hi {{ $user->name }}, 
<br /><br />
Thank you for ordering from Dataczar!<br />
This is a confirmation of your online order at <a href="https://www.dataczar.com">www.dataczar.com</a>.
<br /><br />
This is to confirm your domain name {{ $domain->domain }} has been registered. In a few minutes your website will be 100% up and
running at this URL: https://www.{{ $domain->domain }}. To get started using your new domain you can log in to your account
<a href="{{ route('login') }}"> here</a>.
<br /><br />
<strong>Below is your confirmation:</strong><br />
Registration Date: {{ $domain->created_at->format('Y-m-d') }}<br />
@if(!empty($domain_price))
Amount Paid: @money($domain_price)<br />
@endif
Domain: {{ $domain->domain }}
<br /><br />
@if(!empty($sub))
Along with your domain name, starting on {{ $first_charge_date->format('m/d/Y') }} your {{ $sub->plan->name }} 
plan will automatically renew and the payment method you provided will be charged @money($sub->plan->price ?? '') every month until you cancel.
You may manage your subscription or cancel at any time by calling customer support at (844) 855-2927 or by logging into your 
<a href="https://connect.dataczar.com/accounts/payments">My Account</a> page.
<br /><br />
@endif
To get started using your new domain you can log in to your account <a href="{{ route('login') }}"> here</a>.
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
Void where prohibited. Other terms, conditions, and restrictions may apply.
This offer is subject to change or termination without notice. Additional
taxes or duties may apply. Refer to the 
<a href="https://dataczar.com/terms_and_conditions.html">Dataczar Universal Terms of Service Agreement</a> 
for more details. For any questions call Customer Service at +1 (442) 216-0291
<br /><br />
Your purchase includes an enrollment in our automatic renewal service.
This message confirms that during the checkout process, you agreed to
Dataczar's Universal Terms of Service Agreement, Privacy Policy and all
other agreements applicable to your purchase. This message also confirms
that during the checkout process, you agreed to enroll your products in
our automatic renewal service. This keeps your products up and running,
automatically charging then-current renewal fees to your payment method
on file, with no further action on your part. The payment method you
provide today, or we have on file, will be used for renewals, unless you
change it or cancel. If you do not wish to continue using our automatic
renewal service, you can cancel by visiting the Billing page in your
account. Your domain name will renew annually at the then current rate
unless you cancel.
@if(!empty($sub))Your {{ $sub->plan->name }} plan is @if($trial) $0.00 @else @money($sub->plan->price) @endif for 30
days. Starting on {{ $first_charge_date->format('m/d/Y') }} your credit card will be
charged @money($sub->plan->price) per month every month until you cancel.] You can
cancel any subscription at any time by calling Customer
Service at the number(s) listed below, by logging in and
editing your subscriptions, or by sending us a request on
our website Contact Form. For any questions, call Customer
Service at +1 (442) 216-0291.@endif
<br /><br />
For more information on the terms and conditions of your
purchase please refer to the 
<a href="https://dataczar.com/terms_and_conditions.html">Dataczar Universal Terms of Service Agreement</a>. <br />
-------------------------<br />
<br />
This message was sent to {{ $account->owner->email }}, as a Dataczar customer, consistent with your email preferences.
<br />
Click here to <a href="{{ route('user.profile') }}">manage your email settings.</a>
</small>   

@endcomponent

