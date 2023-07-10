@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(session('message'))
<div class="alert alert-info">
    {{ session('message') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

{{--
    @impersonating
<div class="nav-item alert alert-danger">
    <a href="#" class="nav-link" dusk="stop_impersonating_alert"
        onclick="event.preventDefault(); document.getElementById('impersonating').submit();">
        <i class="fa fa-user-times" aria-hidden="true"></i> Stop Impersonating
    </a>
    <form action="{{ route('admin.impersonate') }}" method="POST" id="impersonating" class="hidden">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
    </form>
</div>
@endimpersonating
--}}

@if( !empty(session('currentTeam')) && auth()->user()->has_cs_basic )
<div class="nav-item alert alert-danger" id="stop_managing_alert">
    <a href="{{ route('admin.account.stop_managing', auth()->user()->currentTeam->id) }}" class="nav-link">
        <i class="fa fa-user-times" aria-hidden="true"></i> Stop Managing:
        {{-- auth()->user()->currentTeam->name --}}
    </a>
</div>
@endif

@if(($freeze ?? false) == true)
<div class="alert alert-danger">
    <i class="fa fa-lock"></i>
    Your account has been locked due to unusual activity. Please call us at (844) 855-2927 to unlock your account.
</div>
@endif

@if(($bad_debt ?? false) == true)
<div class="alert alert-danger">
    <i class="fa fa-credit-card"></i>
    Your payment method is currently failing. 
    @if(Route::currentRouteName() !== 'plans.card')
        Please <a href="{{ route('plans.card') }}">click here to update your payment information</a>.
    @endif
</div>
@endif
@if(isset($low_sub) && $low_sub == true)
<div class="alert alert-danger">
    <i class="fa fa-credit-card"></i>
    Your Domain : <strong>{{ Auth::user()->currentTeam->domains()->first()->domain }}</strong> is at risk. Your current plan does not include a free domain.<br />
    <a href="{{ route('plans.index') }}">click here to upgrade your plan</a>.
</div>
@endif
@if(isset($canceled_with_domain) && $canceled_with_domain == true)
<div class="alert alert-danger">
    <i class="fa fa-credit-card"></i>
    Your Domain : <strong>{{ Auth::user()->currentTeam->domains()->first()->domain }}</strong> is at risk. Please restart your canceled subscription to prevent losing your domain.<br />
    <a href="{{ route('plans.index') }}">click here to restart your plan</a>.
</div>
@endif


@if(session('warning'))
<div class="alert alert-warning">
    <i class="fa fa-warning"></i>
    {{ session('warning') }}
</div>
@endif
<div id="js_warning" class="alert alert-warning" style="display:none">
    <i class="fa fa-warning"></i>
</div>
@if(session('event'))
<script type="text/javascript">
    fbq('track', '{{ session('event') }}');
</script>
@endif
