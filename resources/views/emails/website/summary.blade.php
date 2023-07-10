@component('mail::message')

<h1 style="width:100%; text-align:center; padding-top:25px;">
    Account Summary 
</h1>
<h3 style="width:100%; text-align:center;">
    {{ $display_name }}
</h3>
<h3 style="width:100%; text-align:center; padding-bottom:25px;">
    {{ $start->format('M jS') }} - {{ $end->format('M jS, Y') }}
</h3>

@if($pay_alert == true)
@component('mail::panel', [
    'head' => 'Payment Issue',
    'panel_class' => 'panel-alert'
])
<p>
    Your payment method is currently failing. 
    Please <a href="{{ route('plans.card') }}">click here to update your payment information</a>.
</p>
@endcomponent
@endif

@if(!$next->email || !$next->interview || !$next->domains)
@component('mail::panel', [
    'head'=>'Account Setup - Next Steps',
    'rows' => [
        /* email */
        [
            'icon' => ($next->email) ? 'check-square.png' : 'square.png',
            'text' => 'Confirm Your Email', 
            'url' =>  ($next->email) ? NULL : route('auth.activate.resend'), 
            'status'=> ($next->email) ? 'DONE' : 'TODO'
        ],
        /* Interview */
        [
            'icon' => ($next->interview) ? 'check-square.png' : 'square.png',
            'text' => 'Complete Website Interview	', 
            'url' => ($next->interview) ? NULL : route('interview.restart'), 
            'status'=> ($next->interview) ? 'DONE' : 'TODO'
        ],
        /* domain */
        [
            'icon' => ($next->domains) ? 'check-square.png' : 'square.png',
            'text' => 'Register Your Domain', 
            'url' => ($next->domains) ? NULL : route('domains.index'), 
            'status'=> ($next->domains) ? 'DONE' : 'TODO'
        ],
    ]
])
@endcomponent
@endif

@component('mail::panel', [
    'head' => "$display_name - Visitors"
])
<a href="{{ route('websites.index') }}">
    <img src="{{ $user_chart }}" alt="">
</a>
@endcomponent

@if(count($behavior) > 0)
@component('mail::panel', [
    'head' => "$display_name - Top Pages"
])
<table cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <td>Page</td>
        <td align="right">Views</td>
    </tr>
    @foreach ($behavior as $item)
    <tr>
        <td>{{ $item['page'] }}</td>
        <td align="right" class="ellipsis">
            {{ $item['views'] }}
        </td>
    </tr>    
    @endforeach
</table>
@endcomponent
@endif

@component('mail::panel', [
    'head'=>'Quick Links',
    'rows' => $links,
])
@endcomponent

@component('mail::panel', [
'head' => "Refer a Friend"
])

Tell a friend to sign up with your referral code, give $10, get $10.
Your Referral code: <strong>{{ $account->token }}</strong>
<br />


@endcomponent

<table cellpadding="10" cellspacing="0" width="100%">
    <tr align="center" style="text-align:left; ">
        <td>
            <small>
                This message was sent to {{ $account->owner->email }}, as a Dataczar customer, consistent with your email preferences.
                Click here to <a href="{{ route('user.profile') }}">manage your email settings.</a>
                <br /><br />
                As a reminder, you can review the services on your account at any time by visiting the Billing Page on your account. 
                For any questions call Customer Service at +1 (442) 216-0291 or contact us on our website. For more information on 
                the terms and conditions of your account please refer to the 
                <a href="https://dataczar.com/terms_and_conditions.html">Dataczar Universal Terms of Service Agreement</a>.<br />
            </small>
        </td>
    </tr>
</table>

<div>
  
</div>
@endcomponent

